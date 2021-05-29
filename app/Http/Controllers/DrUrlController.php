<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BroadcastMember;
use Config;
use Illuminate\Support\Facades\Log;
use App\Enum\BroadcastMemberStatus;

class DrUrlController extends Controller
{
    public function drUrl(Request $request, $broadcast_id, $key)
    {
        try {
            $model = BroadcastMember::where([
                'broadcast_id' => $broadcast_id,
                'key' => $key
            ])->first();

            if ($model == null) {
                Log::debug([
                    'title' => 'NULL',
                    'broadcast_id' => $broadcast_id,
                    'key' => $key,
                ]);
                return;
            }

            $status = BroadcastMemberStatus::FAILED;

            if (in_array($request->final_error_code, Config::get("status-response-code.list_success_final_status_code"))) {
                $status = BroadcastMemberStatus::SUCCESS;
            }

            $data = [
                'final_response_code' => $request->final_error_code,
                'final_response_code_display' => Config::get("status-response-code.$request->final_error_code"),
                'session_id' => $request->session_id,
                'operator_smsc_ack' => $request->operator_smsc_ack,
                'operator_dlr' => $request->operator_dlr,
                'billable' => $request->billable,
                'status' => $status
            ];

            $model->update($data);
        } catch (\Throwable $th) {
            Log::debug([
                'title' => 'throw',
                'broadcast_id' => $broadcast_id,
                'key' => $key,
                'desc' => $th
            ]);
        }

        return;
    }
}
