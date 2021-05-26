<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'team_id',
        'meta'
    ];

    public function getMetaAttribute($value)
    {
        return unserialize($value);
    }

    public function setMetaAttribute($value)
    {
        $this->attributes['meta'] = serialize($value);
    }
}
