
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="rtl">

<head>
@include('admin.layout.head')

    @yield('css')

    {{-- toastr --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/vendors/css/extensions/toastr.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css-rtl/plugins/extensions/toastr.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Alexandria:300,400,500,600" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Alexandria:wght@100..900&display=swap" rel="stylesheet">


    
</head>
<body class="vertical-layout vertical-menu-modern 2-columns  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">

    @include('admin.layout.navbar')
    @include('admin.layout.aside')


    @yield('content')


    @include('admin.layout.footer')

    <!-- BEGIN: Vendor JS-->
    <script src="{{ asset('admin/vendors/js/vendors.min.js') }}"></script>
    <!-- BEGIN Vendor JS-->
    
    <!-- BEGIN: Theme JS-->
    <script src="{{ asset('admin/js/core/app-menu.js') }}"></script>
    <script src="{{ asset('admin/js/core/app.js') }}"></script>
    <script src="{{ asset('admin/js/scripts/components.js') }}"></script>
    <!-- END: Theme JS-->

    @yield('script')
    <script src="{{ asset('admin/js/scripts/notifications.js') }}"></script>

        <script src="{{ asset('admin/vendors/js/extensions/toastr.min.js') }}"></script>
    	@if(Session::has('success'))
            <script>toastr.success('{{ session('success') }}', 'تمت العمليه ');</script>
         @endif

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <script>
                    toastr.error("{{ $error }}", "خطا");
                </script>
            @endforeach
        @endif

</body>

</html>
