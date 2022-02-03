<?php

namespace App\GraphQL\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\GraphQL\Enums\OrderDirectionEnum;
use App\GraphQL\Messages\Message;

class SortParameterRule implements Rule
{
    private string $message;

    private array $allowedFields;

    public function __construct(array $allowedFields = [])
    {
        $this->allowedFields = $allowedFields;
    }

    public function passes($attribute, $value): bool
    {
        foreach ($value as $val) {
            [$field, $direction] = explode(':', $val);

            if (!in_array($field, $this->allowedFields, true)) {
                $this->message = Message::get(Message::INVALID_SORT_FIELD);

                return false;
            }

            if (!in_array($direction, OrderDirectionEnum::asArray(), true)) {
                $this->message = Message::get(Message::INCORRECT_SORT_DIRECTION);

                return false;
            }
        }

        return true;
    }

    public function message(): string
    {
        return $this->message ?? Message::get(Message::INVALID_SORT_ARGUMENT);
    }
}
