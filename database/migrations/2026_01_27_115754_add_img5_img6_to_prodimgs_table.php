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
        Schema::table('prodimgs', function (Blueprint $table) {
            $table->string('img5')->nullable();
            $table->string('alt5')->nullable();
            $table->string('img6')->nullable();
            $table->string('alt6')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prodimgs', function (Blueprint $table) {
            $table->dropColumn(['img5', 'alt5', 'img6', 'alt6']);
        });
    }
};
