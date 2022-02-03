<?php


namespace App\GraphQL\Services\Files;

use App\GraphQL\Dto\Files\FileDto;
use App\GraphQL\Dto\Files\FileInputDto;
use App\GraphQL\Dto\Files\FileSizeDto;
use App\GraphQL\Models\Files\File;
use App\GraphQL\Repositories\Files\FileRepository;
use App\Models\Images\Path;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class FileService
{
    public function __construct(protected FileRepository $fileRepository)
    {
    }

    public static function getUrl(?string $name = null): ?string
    {
        if (!Storage::disk(self::getDisc())->exists(Path::filePath($name))) {
            return self::getBaseImage();
        }

        $filePath = Path::dir($name);

        if (self::getDisc() === 'local') {
            return asset('storage/app/' . $filePath . $name);
        }

        return $filePath . $name;
    }

    public static function getDisc(): string
    {
        return env('DISC');
    }

    private static function getBaseImage()
    {
        return env('BASE_IMAGE');
    }

    public function uploadFiles(array $files, int $modelId, string $modelType): void
    {
        foreach ($files as $file) {
            $this->uploadFile(FileInputDto::build($file), $modelId, $modelType);
        }
    }

    public function uploadFile(FileInputDto $fileInput, int $modelId, string $modelType): void
    {
        $dto = $this->upload($fileInput, $modelId, $modelType);

        if ($dto->getIsMain()) {
            $this->fileRepository->resetIsMain($dto);
        }

        $model = $this->fileRepository->create($dto);

        if ($fileInput->isSizes()) {
            $this->resizeImage($model, $fileInput);
        }
    }

    private function upload(FileInputDto $fileInput, int $modelId, string $modelType): FileDto
    {
        return FileDto::build([
            'model_id' => $modelId,
            'model_type' => $modelType,
            'name' => $this->saveFile($fileInput->getFile()),
            'origin_name' => $fileInput->getFile()->getClientOriginalName(),
            'size' => $fileInput->getFile()->getSize(),
            'mime_type' => $fileInput->getFile()->getMimeType(),
            'type_id' => $fileInput->getTypeId(),
            'is_main' => $fileInput->getIsMain(),
        ]);
    }

    public function saveFile(UploadedFile $file): string
    {
        $name = Path::name($file->getClientOriginalName(), '', '', self::getDisc());
        $file->storeAs(Path::dir($name), $name, ['disk' => self::getDisc()]);

        return $name;
    }

    public function resizeImage(File $file, FileInputDto $fileInput): void
    {
        foreach ($fileInput->getSizes() as $value) {
            $value = FileSizeDto::build($value);

            if (!$value->isResizeImage()) {
                continue;
            }

            $image = Image::make($fileInput->getFile());

            $image->resize(
                $value->getWeight(),
                $value->getHeight(),
                function ($constraint) {
                    $constraint->aspectRatio();
                }
            );

            $image->interlace();

            $name = Path::name($fileInput->getFile()->getClientOriginalName(), '', '', self::getDisc());

            Storage::disk(self::getDisc())->put(Path::dir($name) . $name, $image->stream());

            $this->fileRepository->create(
                FileDto::build([
                    'model_id' => $file->model_id,
                    'model_type' => $file->model_type,
                    'name' => $name,
                    'origin_name' => $file->origin_name,
                    'size' => $image->filesize(),
                    'mime_type' => $image->mime(),
                    'parent_id' => $file->id,
                    'is_main' => $fileInput->getIsMain(),
                    'type_id' => $fileInput->getTypeId(),
                    'height' => $value->getHeight(),
                    'weight' => $value->getWeight(),
                ])
            );
        }
    }


    /**
     * @param File[] $files
     */
    public function deleteFiles(array $files): void
    {
        foreach ($files as $file) {
            $this->deleteFile($file);
        }
    }

    public function deleteFile(File $file): bool
    {
        if ($file->sizes->isNotEmpty()) {
            foreach ($file->sizes as $size) {
                $this->deleteFile($size);
            }
        }

        $this->deleteFileByName($file->name);
        $this->fileRepository->delete($file);

        return true;
    }

    public function deleteFileByName(string $name): bool
    {
        return $this->getStorage()->delete($this->getFilePath($name));
    }

    public function getStorage(): Filesystem
    {
        return Storage::disk(self::getDisc());
    }

    public function getFilePath(string $name): string
    {
        return Path::filePath($name);
    }

    public function isFile(string $name): bool
    {
        return $this->getStorage()->exists($this->getFilePath($name));
    }
}
