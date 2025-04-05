<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('mobile_otp_logins', function (Blueprint $table) {
            $table->id();
            $table->string('phone', 15);
            $table->string('otp', 8);
            $table->boolean('is_verified')->default(false);
            $table->timestamp('expires_at');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mobile_otp_logins');
    }
}; 