<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;

class Group extends Model
{
    use HasFactory, LaravelVueDatatableTrait;

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

    protected $dataTableColumns = [
        'id' => [
            'searchable' => false,
        ],
        'title' => [
            'searchable' => true,
        ],
        'created_at' => [
            'searchable' => false,
        ],
        'updated_at' => [
            'searchable' => false,
        ]
    ];

    /**
     * Get all of the members for the Group
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function members()
    {
        return $this->hasMany(Member::class);
    }

    /**
     * Get all of the broadcasts for the Group
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function broadcasts()
    {
        return $this->hasMany(Broadcast::class);
    }
}
