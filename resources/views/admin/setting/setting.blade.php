@extends('admin.layout.master')
@section('css')
    <link rel="apple-touch-icon" href="{{ asset('admin/images/ico/apple-icon-120.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('admin/images/ico/favicon.ico') }}">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/vendors/css/forms/select/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/vendors/css/pickers/pickadate/pickadate.css') }}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css-rtl/plugins/forms/validation/form-validation.css') }}">
    <!-- END: Page CSS-->
@endsection


@section('content')

        <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-left mb-0">اعدادت الموقع</h2>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{ route('setting') }}">اعدادت الموقع</a>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- account setting page start -->
                <section id="page-account-settings">
                    <div class="row">
                        <!-- left menu section -->
                        <div class="col-md-3 mb-2 mb-md-0">
                            <ul class="nav nav-pills flex-column mt-md-0 mt-1">
                                <li class="nav-item">
                                    <a class="nav-link d-flex py-75 active" id="pill-general" data-toggle="pill" href="#vertical-general" aria-expanded="true">
                                        <i class="feather icon-globe mr-50 font-medium-3"></i>
                                        إعدادات عامة
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link d-flex py-75" id="pill-sliders" data-toggle="pill" href="#vertical-sliders" aria-expanded="false">
                                        <i class="feather icon-image mr-50 font-medium-3"></i>
                                        السلايدر (الرئيسية)
                                    </a>
                                </li>
                            <li class="nav-item">
                                    <a class="nav-link d-flex py-75" id="pill-banners" data-toggle="pill" href="#vertical-banners" aria-expanded="false">
                                        <i class="feather icon-layers mr-50 font-medium-3"></i>
                                        البنرات (الرئيسية)
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link d-flex py-75" id="pill-colors" data-toggle="pill" href="#vertical-colors" aria-expanded="false">
                                        <i class="feather icon-droplet mr-50 font-medium-3"></i>
                                        ألوان الموقع
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- right content section -->
                        <div class="col-md-9">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body">
                                        <form action="{{ route('setting.update') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="tab-content">
                                                <!-- General Settings -->
                                                <div role="tabpanel" class="tab-pane active" id="vertical-general" aria-labelledby="pill-general" aria-expanded="true">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="home_section_title">عنوان القسم الرئيسي (Homepage)</label>
                                                                <input type="text" class="form-control" name="home_section_title" value="{{ $setting->home_section_title }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="favicon">Favicon (أيقونة المتصفح)</label>
                                                                <input type="file" class="form-control" name="favicon">
                                                                @if($setting->favicon)
                                                                    <img src="{{ asset($setting->favicon) }}" width="32" class="mt-1">
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="mainLogo">اللوجو الرئيسي</label>
                                                                <input type="file" class="form-control" name="mainLogo">
                                                                @if($setting->mainLogo)
                                                                    <img src="{{ asset($setting->mainLogo) }}" width="100" class="mt-1">
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="whiteLogo">اللوجو الأبيض (اختياري)</label>
                                                                <input type="file" class="form-control" name="whiteLogo">
                                                                @if($setting->whiteLogo)
                                                                    <img src="{{ asset($setting->whiteLogo) }}" width="100" class="mt-1 bg-dark">
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Sliders Settings -->
                                                <div class="tab-pane fade" id="vertical-sliders" role="tabpanel" aria-labelledby="pill-sliders" aria-expanded="false">
                                                    @for ($i = 1; $i <= 3; $i++)
                                                        <h4 class="mb-2 text-primary">Slider {{ $i }}</h4>
                                                        <div class="row border-bottom pb-4 mb-4">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>صورة الخلفية</label>
                                                                    <input type="file" class="form-control" name="slider{{ $i }}_image">
                                                                    @if($setting->{'slider'.$i.'_image'})
                                                                        <img src="{{ asset($setting->{'slider'.$i.'_image'}) }}" width="100" class="mt-1">
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>صورة مصغرة (Thumb)</label>
                                                                    <input type="file" class="form-control" name="slider{{ $i }}_thumb">
                                                                    @if($setting->{'slider'.$i.'_thumb'})
                                                                        <img src="{{ asset($setting->{'slider'.$i.'_thumb'}) }}" width="50" class="mt-1">
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>العنوان (Title)</label>
                                                                    <input type="text" class="form-control" name="slider{{ $i }}_title" value="{{ $setting->{'slider'.$i.'_title'} }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>الوصف (Caption)</label>
                                                                    <input type="text" class="form-control" name="slider{{ $i }}_caption" value="{{ $setting->{'slider'.$i.'_caption'} }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>نص الزر</label>
                                                                    <input type="text" class="form-control" name="slider{{ $i }}_btn_text" value="{{ $setting->{'slider'.$i.'_btn_text'} }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>الرابط</label>
                                                                    <input type="text" class="form-control" name="slider{{ $i }}_link" value="{{ $setting->{'slider'.$i.'_link'} }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endfor
                                                </div>

                                                <!-- Banners Settings -->
                                                <div class="tab-pane fade" id="vertical-banners" role="tabpanel" aria-labelledby="pill-banners" aria-expanded="false">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <h4 class="mb-2 text-info">Banner {{ $i }}</h4>
                                                        <div class="row border-bottom pb-4 mb-4">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>الصورة</label>
                                                                    <input type="file" class="form-control" name="banner{{ $i }}_image">
                                                                    @if($setting->{'banner'.$i.'_image'})
                                                                        <img src="{{ asset($setting->{'banner'.$i.'_image'}) }}" width="100" class="mt-1">
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>العنوان كبير (Title)</label>
                                                                    <input type="text" class="form-control" name="banner{{ $i }}_title" value="{{ $setting->{'banner'.$i.'_title'} }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>نص فرعي (Info)</label>
                                                                    <input type="text" class="form-control" name="banner{{ $i }}_info" value="{{ $setting->{'banner'.$i.'_info'} }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>الرابط</label>
                                                                    <input type="text" class="form-control" name="banner{{ $i }}_link" value="{{ $setting->{'banner'.$i.'_link'} }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endfor
                                                </div>

                                                <!-- Colors Settings -->
                                                <div class="tab-pane fade" id="vertical-colors" role="tabpanel" aria-labelledby="pill-colors" aria-expanded="false">
                                                    <div class="row">
                                                        <div class="col-12 mb-2">
                                                            <div class="alert alert-info">
                                                                <i class="feather icon-info mr-1"></i>
                                                                يمكنك تغيير ألوان الموقع الرئيسية من هنا
                                                            </div>
                                                        </div>

                                                        <div class="col-12">
                                                            <h5 class="mb-1 text-bold-500 text-primary">الألوان العامة</h5>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>اللون الأساسي (Primary)</label>
                                                                <input type="color" class="form-control" name="primary_color" value="{{ $setting->primary_color ?? '#717fe0' }}" style="height: 50px;">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>اللون الثانوي (Secondary)</label>
                                                                <input type="color" class="form-control" name="secondary_color" value="{{ $setting->secondary_color ?? '#333333' }}" style="height: 50px;">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>لون التحويم (Hover)</label>
                                                                <input type="color" class="form-control" name="hover_color" value="{{ $setting->hover_color ?? '#717fe0' }}" style="height: 50px;">
                                                            </div>
                                                        </div>

                                                        <div class="col-12 mt-2">
                                                            <h5 class="mb-1 text-bold-500 text-primary">الهيدر والقائمة (موبايل)</h5>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>خلفية الهيدر (Mobile Header)</label>
                                                                <input type="color" class="form-control" name="mobile_header_bg" value="{{ $setting->mobile_header_bg ?? '#ffffff' }}" style="height: 50px;">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>خلفية القائمة (Mobile Menu BG)</label>
                                                                <input type="color" class="form-control" name="mobile_menu_bg" value="{{ $setting->mobile_menu_bg ?? '#ffffff' }}" style="height: 50px;">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>لون نصوص القائمة (Mobile Menu Text)</label>
                                                                <input type="color" class="form-control" name="mobile_menu_text" value="{{ $setting->mobile_menu_text ?? '#333333' }}" style="height: 50px;">
                                                            </div>
                                                        </div>

                                                        <div class="col-12 mt-2">
                                                            <h5 class="mb-1 text-bold-500 text-primary">الأزرار (Buttons)</h5>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>خلفية الزر عند التحويم (Hover BG)</label>
                                                                <input type="color" class="form-control" name="btn_hover_bg" value="{{ $setting->btn_hover_bg ?? '#333333' }}" style="height: 50px;">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>نص الزر عند التحويم (Hover Text)</label>
                                                                <input type="color" class="form-control" name="btn_hover_text" value="{{ $setting->btn_hover_text ?? '#ffffff' }}" style="height: 50px;">
                                                            </div>
                                                        </div>

                                                        <div class="col-12 mt-2">
                                                            <h5 class="mb-1 text-bold-500 text-primary">الفوتر (Footer)</h5>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>خلفية الفوتر</label>
                                                                <input type="color" class="form-control" name="footer_bg" value="{{ $setting->footer_bg ?? '#222222' }}" style="height: 50px;">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>نصوص الفوتر</label>
                                                                <input type="color" class="form-control" name="footer_text" value="{{ $setting->footer_text ?? '#ffffff' }}" style="height: 50px;">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>خلفية الحقوق (Copyright)</label>
                                                                <input type="color" class="form-control" name="copyright_bg" value="{{ $setting->copyright_bg ?? '#111111' }}" style="height: 50px;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 d-flex flex-sm-row flex-column justify-content-end mt-2">
                                                <button type="submit" class="btn btn-primary mr-sm-1 mb-1 mb-sm-0">حفظ التغييرات</button>
                                                <button type="reset" class="btn btn-outline-warning">إلغاء</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- account setting page end -->

            </div>
        </div>
    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>


@endsection

@section('script')


    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset('admin/vendors/js/forms/select/select2.full.min.js') }}"></script>
    <script src="{{ asset('admin/vendors/js/forms/validation/jqBootstrapValidation.js') }}"></script>
    <script src="{{ asset('admin/vendors/js/pickers/pickadate/picker.js') }}"></script>
    <script src="{{ asset('admin/vendors/js/pickers/pickadate/picker.date.js') }}"></script>
    <script src="{{ asset('admin/vendors/js/extensions/dropzone.min.js') }}"></script>
    <!-- END: Page Vendor JS-->



    <!-- BEGIN: Page JS-->
    <script src="{{ asset('admin/js/scripts/pages/account-setting.js') }}"></script>
    <!-- END: Page JS-->


@endsection

