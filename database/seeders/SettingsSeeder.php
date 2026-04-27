<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\setting::create([
            'favicon' => 'store/images/icons/favicon.ico',
            'mainLogo' => 'store/images/icons/logo-02.png',
            'whiteLogo' => 'store/images/icons/logo-02.png', // Assuming white logo path if different

            'home_section_title' => 'اكتشفي جمال التفاصيل...',

            // Slider 1
            'slider1_image' => 'store/images/slide-05.avif',
            'slider1_thumb' => 'store/images/thumb-01.avif',
            'slider1_title' => 'إطلالات الموسم الباردة',
            'slider1_caption' => 'ملابستك… لمستك الخاصة كل يوم',
            'slider1_btn_text' => 'اكتشف الان',
            'slider1_link' => route('product'),

            // Slider 2
            'slider2_image' => 'store/images/slide-06.avif',
            'slider2_thumb' => 'store/images/thumb-02.avif',
            'slider2_title' => 'تفرّدي بستايلك: ملابس حصرية تكسر حاجز المألوف.',
            'slider2_caption' => 'اكتشفي أحدث صيحات الطرح',
            'slider2_btn_text' => 'اكتشف الان',
            'slider2_link' => route('product'),

             // Slider 3
             'slider3_image' => 'store/images/slide-07.avif',
             'slider3_thumb' => 'store/images/thumb-03.avif',
             'slider3_title' => 'كوني الأجمل.. باختلاف.',
             'slider3_caption' => 'ضيفي لمسة فريدة لإطلالتك',
             'slider3_btn_text' => 'اكتشف الان',
             'slider3_link' => route('product'),

             // Banners
             'banner1_image' => 'store/images/banner-04.avif',
             'banner1_title' => 'Women',
             'banner1_info' => 'New Trend',
             'banner1_link' => route('product'),

             'banner2_image' => 'store/images/banner-05.avif',
             'banner2_title' => 'woman',
             'banner2_info' => 'New Trend',
             'banner2_link' => route('product'),

             'banner3_image' => 'store/images/banner-07.avif',
             'banner3_title' => 'Watches',
             'banner3_info' => 'Spring 2018',
             'banner3_link' => route('product'),

             'banner4_image' => 'store/images/banner-08.avif',
             'banner4_title' => 'Bags',
             'banner4_info' => 'Spring 2018',
             'banner4_link' => route('product'),

             'banner5_image' => 'store/images/banner-09.avif',
             'banner5_title' => 'Accessories',
             'banner5_info' => 'Spring 2018',
             'banner5_link' => route('product'),
        ]);
    }
}
