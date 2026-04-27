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
        Schema::table('settings', function (Blueprint $table) {
            $table->string('mobile_header_bg')->nullable()->default('#ffffff');
            $table->string('mobile_menu_bg')->nullable()->default('#ffffff');
            $table->string('mobile_menu_text')->nullable()->default('#333333');
            $table->string('btn_hover_bg')->nullable()->default('#333333');
            $table->string('btn_hover_text')->nullable()->default('#ffffff');
            $table->string('footer_bg')->nullable()->default('#222222');
            $table->string('footer_text')->nullable()->default('#ffffff');
            $table->string('copyright_bg')->nullable()->default('#111111');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'mobile_header_bg',
                'mobile_menu_bg',
                'mobile_menu_text',
                'btn_hover_bg',
                'btn_hover_text',
                'footer_bg',
                'footer_text',
                'copyright_bg'
            ]);
        });
    }
};
