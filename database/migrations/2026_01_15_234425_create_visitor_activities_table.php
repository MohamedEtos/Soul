<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('visitor_activities', function (Blueprint $table) {
            $table->id();
            $table->ipAddress('ip_address');
            $table->string('session_id', 100);
            $table->longText('url');
            $table->string('page_title')->nullable();
            $table->string('referrer')->nullable();
            $table->integer('duration_seconds')->default(0); // الوقت بالثواني
            $table->timestamp('started_at')->nullable(); // وقت البدء
            $table->timestamp('ended_at')->nullable(); // وقت الانتهاء
            $table->string('device_type', 20)->nullable();
            $table->string('browser', 50)->nullable();
            $table->string('platform', 50)->nullable();
            $table->string('country', 50)->nullable();
            $table->string('city', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitor_activities');
    }
};
