<?php


namespace App\GraphQL\Traits\Filter;

use Exception;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Str;

trait SortFilterTrait
{
    public function sort(array $sort): void
    {
        foreach ($sort as $val) {
            [$field, $direction] = explode(':', Str::lower($val));

            if (in_array($field, $this->allowedOrders(), true)
                && in_array($direction, $this->allowedDirections(), true)
            ) {
                if ($this->existCustomMethod($field)) {
                    $this->buildCustomMethod($field, $direction);
                } elseif (str_contains($field, ".")) {
                    $this->orderRelationQuery($direction, $field);
                } else {
                    $this->orderQuery($field, $direction);
                }
            }
        }
    }

    protected function allowedOrders(): array
    {
        return [];
    }

    protected function allowedDirections(): array
    {
        return ['asc', 'desc'];
    }

    protected function existCustomMethod(string $field): bool
    {
        return method_exists($this, $this->getCustomMethodName($field));
    }

    protected function getCustomMethodName(string $field): string
    {
        return 'custom' . Str::studly($field) . 'Sort';
    }

    protected function buildCustomMethod(string $field, string $direction): void
    {
        if ($this->existCustomMethod($field)) {
            $this->{$this->getCustomMethodName($field)}($field, $direction);
        }
    }

    protected function orderRelationQuery(string $direction, string $method): void
    {
        $methods = explode('.', $method);
        $key = array_pop($methods);
        $field = $key;

        $keyWithTable = "`" . $this->getTableForOrderRelation($methods) . "`.`$key`";
        $field .= "_sort_$direction";

        $model = $this->getModel();
        $table = $model->getTable();
        $tableSub = $table . "_sub";
        $keyForReplace = '__LOCAL_KEY__';

        $query = $model->from("$table as $tableSub")
            ->selectRaw("$keyWithTable as `$field`")
            ->joinRelationship(
                implode('.', $methods)
            )
            ->whereRaw("`$tableSub`.`id` = $keyForReplace")
            ->orderBy($field, $direction)
            ->limit(1)
            ->getQuery();

        $sql = str_replace(
            $keyForReplace,
            "`$table`.`id`",
            preg_replace(
                "/`$table`\./",
                "`$tableSub`.",
                $this->getSqlForBuilder($query)
            )
        );

        $this->selectRaw("($sql) as `$field`")->orderBy($field, $direction);
    }

    protected function getTableForOrderRelation(array $relations): string
    {
        $models = [];

        foreach ($relations as $relation) {
            $model = empty($models) ? $this->getModel() : end($models)->getModel();

            if (!method_exists($model, $relation)) {
                throw new Exception("Метот $relation не найден");
            }

            $models[] = $model->{$relation}();
        }

        return (array_pop($models))->getModel()->getTable();
    }

    protected function getSqlForBuilder(Builder $model): string
    {
        $replace = static function ($sql, $bindings) {
            $needle = '?';
            foreach ($bindings as $replace) {
                $pos = strpos($sql, $needle);
                if ($pos !== false) {
                    if (is_string($replace)) {
                        $replace = " '" . addslashes($replace) . "' ";
                    }
                    $sql = substr_replace($sql, $replace, $pos, strlen($needle));
                }
            }

            return $sql;
        };

        return $replace($model->toSql(), $model->getBindings());
    }

    protected function orderQuery(string $field, string $direction): void
    {
        $this->orderBy($field, $direction);
    }
}
