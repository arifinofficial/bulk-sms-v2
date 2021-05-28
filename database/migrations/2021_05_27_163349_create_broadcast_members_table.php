<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBroadcastMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('broadcast_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('broadcast_id')->constrained()->cascadeOnDelete();
            $table->text('key');
            $table->string('status');
            $table->string('msisdn');
            $table->text('sms_text');
            $table->integer('response_code');
            $table->string('response_code_display');
            $table->integer('final_response_code')->nullable();
            $table->string('final_response_code_display')->nullable();
            $table->text('session_id')->nullable();
            $table->integer('final_error_code')->nullable();
            $table->string('operator_smsc_ack')->nullable();
            $table->string('operator_dlr')->nullable();
            $table->boolean('billable')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('broadcast_members');
    }
}
