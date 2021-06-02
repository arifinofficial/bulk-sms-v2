<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Http\Traits\SendSmsTrait;
use Illuminate\Support\Facades\Crypt;
use Config;
use App\Enum\BroadcastMemberStatus;
use App\Enum\BroadcastStatus;
use App\Models\BroadcastMember;
use Carbon\Carbon;

class BroadcastSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, SendSmsTrait;

    protected $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $apiUsername = $this->data->team->api_username;
        $apiPassword = $this->data->team->api_password;
        $msisdnSender = $this->data->team->msisdn_sender;
        $groupModel = $this->data->group;
        $smsText = $this->data->sms_text;
        $boradcastId = $this->data->id;

        preg_match_all('~\[(.*?)\]~s', $smsText, $meta);

        $broadcastMemberData = [];

        foreach ($groupModel->members as $member) {
            $formattedText = $smsText;
            // Pairing variable string to array meta
            foreach ($meta[0] as $key => $value) {
                if (array_key_exists($meta[1][$key], $member->attribute)) {
                    $formattedText = str_replace($value, $member->attribute[$meta[1][$key]], $formattedText);
                }
            }

            $time = time();
            $key = "{$boradcastId} + {$time}";
            $encryptKey = Crypt::encryptString($key);

            $requestSms = SendSmsTrait::send($apiUsername, $apiPassword, $msisdnSender, $member->msisdn, $formattedText, $boradcastId, $encryptKey);

            $responseSms = explode(PHP_EOL, $requestSms);

            $responseCode = $responseSms[0];
            $responseCodeDisplay = Config::get("status-response-code.$responseCode");
            $status = $responseCode == "6801" ? BroadcastMemberStatus::PROCESSING : BroadcastMemberStatus::FAILED;
            $sessionId = count($responseSms) > 1 ? $responseSms[1] : null;

            $data = [
                'broadcast_id' => $boradcastId,
                'key' => $encryptKey,
                'status' => $status,
                'msisdn' => $member->msisdn,
                'sms_text' => $formattedText,
                'response_code' => $responseCode,
                'response_code_display' => $responseCodeDisplay,
                'session_id' => $sessionId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            array_push($broadcastMemberData, $data);
        }

        BroadcastMember::insert($broadcastMemberData);

        $this->data->update([
            'status' => BroadcastStatus::COMPLETED
        ]);
    }
}
