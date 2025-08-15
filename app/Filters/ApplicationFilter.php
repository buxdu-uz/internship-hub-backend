<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\ArrayShape;

class ApplicationFilter extends AbstractFilter
{
    public const STATUS = 'status';     //0 dan farqli larini olish uchun

    /**
     * @return array[]
     */
    #[ArrayShape([self::STATUS => "array"])] protected function getCallbacks(): array
    {
        return [
            self::STATUS => [$this, 'status'],
        ];
    }

    public function status(Builder $builder, $value)
    {
        $builder->where('status', $value);
    }
}
