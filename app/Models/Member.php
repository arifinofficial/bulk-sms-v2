<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

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
}
