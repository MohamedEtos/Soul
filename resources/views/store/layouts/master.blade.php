<!doctype html>
<html lang="ar">
<head>
    <!-- Head -->
    @include('store.layouts.meta')

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @include('store.layouts.settings')
    @yield('head')

</head>


<body class="animsition">
  <main id="main-content">
    <div id="page-loader" aria-hidden="true">
        <span class="spinner"></span>
    </div>


    @include('store.layouts.navbar')
    @include('store.layouts.aside')
    @include('store.layouts.cart')


    @yield('content')


    @include('store.layouts.footer')
    @include('store.layouts.scripts')
    @include('store.layouts.cartScript')
    
    @yield('script')
  </main>
</body>

</html>
