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
            // General Home Text
            $table->string('home_section_title')->nullable()->default('اكتشفي جمال التفاصيل...');

            // Slider 1
            $table->string('slider1_image')->nullable();
            $table->string('slider1_thumb')->nullable();
            $table->string('slider1_title')->nullable()->default('إطلالات الموسم الباردة');
            $table->string('slider1_caption')->nullable()->default('ملابستك… لمستك الخاصة كل يوم');
            $table->string('slider1_btn_text')->nullable()->default('اكتشف الان');
            $table->string('slider1_link')->nullable();

            // Slider 2
            $table->string('slider2_image')->nullable();
            $table->string('slider2_thumb')->nullable();
            $table->string('slider2_title')->nullable()->default('تفرّدي بستايلك: ملابس حصرية تكسر حاجز المألوف.');
            $table->string('slider2_caption')->nullable()->default('اكتشفي أحدث صيحات الطرح');
            $table->string('slider2_btn_text')->nullable()->default('اكتشف الان');
            $table->string('slider2_link')->nullable();

            // Slider 3
            $table->string('slider3_image')->nullable();
            $table->string('slider3_thumb')->nullable();
            $table->string('slider3_title')->nullable()->default('كوني الأجمل.. باختلاف.');
            $table->string('slider3_caption')->nullable()->default('ضيفي لمسة فريدة لإطلالتك');
            $table->string('slider3_btn_text')->nullable()->default('اكتشف الان');
            $table->string('slider3_link')->nullable();

            // Banners 1-5
            // Banner 1
            $table->string('banner1_image')->nullable();
            $table->string('banner1_title')->nullable()->default('Women');
            $table->string('banner1_info')->nullable()->default('New Trend');
            $table->string('banner1_link')->nullable();

             // Banner 2
             $table->string('banner2_image')->nullable();
             $table->string('banner2_title')->nullable()->default('woman');
             $table->string('banner2_info')->nullable()->default('New Trend');
             $table->string('banner2_link')->nullable();

              // Banner 3
            $table->string('banner3_image')->nullable();
            $table->string('banner3_title')->nullable()->default('Watches');
            $table->string('banner3_info')->nullable()->default('Spring 2018');
            $table->string('banner3_link')->nullable();

             // Banner 4
             $table->string('banner4_image')->nullable();
             $table->string('banner4_title')->nullable()->default('Bags');
             $table->string('banner4_info')->nullable()->default('Spring 2018');
             $table->string('banner4_link')->nullable();

              // Banner 5
            $table->string('banner5_image')->nullable();
            $table->string('banner5_title')->nullable()->default('Accessories');
            $table->string('banner5_info')->nullable()->default('Spring 2018');
            $table->string('banner5_link')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'home_section_title',
                'slider1_image', 'slider1_thumb', 'slider1_title', 'slider1_caption', 'slider1_btn_text', 'slider1_link',
                'slider2_image', 'slider2_thumb', 'slider2_title', 'slider2_caption', 'slider2_btn_text', 'slider2_link',
                'slider3_image', 'slider3_thumb', 'slider3_title', 'slider3_caption', 'slider3_btn_text', 'slider3_link',
                'banner1_image', 'banner1_title', 'banner1_info', 'banner1_link',
                'banner2_image', 'banner2_title', 'banner2_info', 'banner2_link',
                'banner3_image', 'banner3_title', 'banner3_info', 'banner3_link',
                'banner4_image', 'banner4_title', 'banner4_info', 'banner4_link',
                'banner5_image', 'banner5_title', 'banner5_info', 'banner5_link',
            ]);
        });
    }
};
