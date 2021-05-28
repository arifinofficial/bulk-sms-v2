<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BroadcastMember extends Model
{
    use HasFactory;

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
}
