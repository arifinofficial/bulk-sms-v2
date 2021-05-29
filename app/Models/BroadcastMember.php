<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;

class BroadcastMember extends Model
{
    use HasFactory, LaravelVueDatatableTrait;

    protected $fillable = [
        'broadcast_id',
        'key',
        'status',
        'msisdn',
        'sms_text',
        'response_code',
        'response_code_display',
        'final_response_code',
        'final_response_code_display',
        'session_id',
        'final_error_code',
        'operator_smsc_ack',
        'operator_dlr',
        'billable'
    ];

    protected $dataTableColumns = [
        'id' => [
            'searchable' => false,
        ],
        'broadcast_id' => [
            'searchable' => true,
        ],
        'key' => [
            'searchable' => true,
        ],
        'session_id' => [
            'searchable' => true,
        ],
        'status' => [
            'searchable' => true,
        ],
        'msisdn' => [
            'searchable' => true,
        ],
        'sms_text' => [
            'searchable' => false,
        ],
        'response_code' => [
            'searchable' => true,
        ],
        'response_code_display' => [
            'searchable' => false,
        ],
        'final_response_code' => [
            'searchable' => true,
        ],
        'final_response_code_display' => [
            'searchable' => false,
        ],
        'session_id' => [
            'searchable' => true,
        ],
        'final_error_code' => [
            'searchable' => true,
        ],
        'operator_smsc_ack' => [
            'searchable' => false,
        ],
        'operator_dlr' => [
            'searchable' => false,
        ],
        'billable' => [
            'searchable' => true,
        ],
        'created_at' => [
            'searchable' => false,
        ],
        'updated_at' => [
            'searchable' => false,
        ]
    ];
}
