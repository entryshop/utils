<?php

namespace Entryshop\Utils\Models\Traits;

use Illuminate\Support\Str;

trait Searchable
{
    public function scopeSearch($query, $keyword)
    {
        $searches = $this->getSearches();

        if (empty($searches)) {
            return $query;
        }
        $keyword = '%' . str_replace(' ', '%', $keyword) . '%';
        return $query->where(function ($query) use ($keyword, $searches) {
            foreach ($searches as $search) {
                $this->addWhereLikeBinding($query, $search, true, $keyword);
            }
        });
    }

    public function getSearches()
    {
        return $this->searches ?? [];
    }

    protected function addWhereLikeBinding($query, ?string $column, ?bool $or, ?string $pattern)
    {
        $likeOperator = 'like';
        $method       = $or ? 'orWhere' : 'where';
        static::with_query_condition($query, $column, $method, [$likeOperator, $pattern]);
    }

    public function scopeGetForList($query)
    {
        if (!empty($this->list_columns)) {
            $query->select($this->list_columns);
        }
        return $query;
    }

    public static function with_query_condition($model, ?string $column, string $query, array $params)
    {
        if (!Str::contains($column, '.')) {
            $model->$query($column, ...$params);
            return;
        }

        $method   = $query === 'orWhere' ? 'orWhere' : 'where';
        $subQuery = $query === 'orWhere' ? 'where' : $query;

        $model->$method(function ($q) use ($column, $subQuery, $params) {
            static::with_relation_query($q, $column, $subQuery, $params);
        });
    }

    public static function with_relation_query($model, ?string $column, string $query, array $params)
    {
        $column = explode('.', $column);

        $relColumn = array_pop($column);

        $method = 'whereHas';

        $model->$method(implode('.', $column), function ($relation) use ($relColumn, $params, $query) {
            $table = $relation->getModel()->getTable();
            $relation->$query("{$table}.{$relColumn}", ...$params);
        });
    }
}
