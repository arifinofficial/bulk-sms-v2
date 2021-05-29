<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;

class Broadcast extends Model
{
    use HasFactory, LaravelVueDatatableTrait;

    protected $fillable = [
        'team_id',
        'group_id',
        'group_title',
        'sms_text',
        'broadcast_type',
        'status',
        'schedule_time'
    ];

    protected $dataTableColumns = [
        'id' => [
            'searchable' => false,
        ],
        'group_title' => [
            'searchable' => true,
        ],
        'broadcast_type' => [
            'searchable' => true,
        ],
        'status' => [
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
     * Get the group that owns the Broadcast
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * Get the team that owns the Broadcast
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Get all of the broadcastMembers for the Broadcast
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function broadcastMembers()
    {
        return $this->hasMany(BroadcastMember::class);
    }
}
