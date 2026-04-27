@extends('admin.layout.master')
@section('css')

    <link rel="apple-touch-icon" href="{{ asset('admin/images/ico/apple-icon-120.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('admin/images/ico/favicon.ico') }}">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/vendors/css/tables/datatable/datatables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/vendors/css/tables/datatable/extensions/dataTables.checkboxes.css') }}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css-rtl/plugins/file-uploaders/dropzone.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css-rtl/pages/data-list-view.css') }}">
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
                            <h2 class="content-header-title float-left mb-0">نشاط الزوار</h2>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href=" {{ route('dashboard') }} ">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{ route('visitorsActivities') }}">نشاط الزوار</a>

                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="content-body">
                <!-- Data list view starts -->
                <section id="data-list-view" class="data-list-view-header">
                    <div class="action-btns d-none">
                        <div class="btn-dropdown mr-1 mb-1">
                            <div class="btn-group dropdown actions-dropodown">
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#"><i class="feather icon-trash"></i>Delete</a>
                                    <a class="dropdown-item" href="#"><i class="feather icon-archive"></i>Archive</a>
                                    <a class="dropdown-item" href="#"><i class="feather icon-file"></i>Print</a>
                                    <a class="dropdown-item" href="#"><i class="feather icon-save"></i>Another Action</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- DataTable starts -->
                    <div class="table-responsive">
                        <table class="table data-list-view">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>id</th>
                                    <th>IP</th>
                                    <th>عنوان الصفحة</th>
                                    <th>الرابط</th>
                                    <th>قادم من</th>
                                    <th>مدة البقاء</th>
                                    <th>نوع الجهاز</th>
                                    <th>المتصفح</th>
                                    <th>النظام</th>
                                    <th>الدوله</th>
                                    <th>المدينه</th>
                                    <th>وقت الزياره</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($activitiesList as $activity)
                                <tr>
                                    <td></td>
                                    <td class="product-name">{{ $activity->id }}</td>
                                    <td class="product-name">{{ $activity->ip_address }}</td>
                                    <td class="product-name">{{ $activity->page_title ?? 'غير محدد' }}</td>
                                    <td class="product-name" style="max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $activity->url }}">
                                        {{ $activity->url }}
                                    </td>
                                    <td class="product-name">{{ $activity->referrer ?? 'مباشر' }}</td>
                                    <td class="product-name">
                                        <span class="badge badge-success">
                                            {{ gmdate('H:i:s', $activity->duration_seconds) }}
                                        </span>
                                        <small class="text-muted">({{ $activity->duration_seconds }} ثانية)</small>
                                    </td>
                                    <td class="product-name"> {{ $activity->device_type }} </td>
                                    <td class="product-name"> {{ $activity->browser }} </td>
                                    <td class="product-name"> {{ $activity->platform }} </td>
                                    <td class="product-name"> {{ $activity->country ?? 'غير محدد' }} </td>
                                    <td class="product-name"> {{ $activity->city ?? 'غير محدد' }} </td>
                                    <td class="product-name time"> {{ $activity->created_at->diffForHumans() }} </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- DataTable ends -->

                </section>
                <!-- Data list view end -->

            </div>
        </div>
    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>


@endsection




@section('script')


    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset('admin/vendors/js/tables/datatable/datatables.min.js') }}"></script>
    <script src="{{ asset('admin/vendors/js/tables/datatable/datatables.buttons.min.js') }}"></script>
    <script src="{{ asset('admin/vendors/js/tables/datatable/datatables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('admin/vendors/js/tables/datatable/buttons.bootstrap.min.js') }}"></script>
    <script src="{{ asset('admin/vendors/js/tables/datatable/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('admin/vendors/js/tables/datatable/datatables.checkboxes.min.js') }}"></script>
    <!-- END: Page Vendor JS-->




    <!-- BEGIN: Page JS-->
    <script src="{{ asset('admin/js/scripts/ui/data-list-view-no-add.js') }}"></script>
    <!-- END: Page JS-->


<script>

    </script>

@endsection
