<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;

class Member extends Model
{
    use HasFactory, LaravelVueDatatableTrait;

    protected $fillable = [
        'group_id',
        'msisdn',
        'attribute'
    ];

    public function getAttributeAttribute($value)
    {
        return unserialize($value);
    }

    public function setAttributeAttribute($value)
    {
        $this->attributes['attribute'] = serialize($value);
    }

    protected $dataTableColumns = [
        'id' => [
            'searchable' => false,
        ],
        'msisdn' => [
            'searchable' => true,
        ],
        'attribute' => [
            'searchable' => false,
        ]
    ];
}
