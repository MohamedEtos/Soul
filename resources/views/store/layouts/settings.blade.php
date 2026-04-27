    @if(isset($setting))
    @php
        $primary = $setting->primary_color ?? '#da0e7d';
        $secondary = $setting->secondary_color ?? '#222222';
        $hover = $setting->hover_color ?? '#da0e7d';

        // New Color Settings
        $mobileHeaderBg = $setting->mobile_header_bg ?? '#ffffff';
        $mobileMenuBg = $setting->mobile_menu_bg ?? '#ffffff';
        $mobileMenuText = $setting->mobile_menu_text ?? '#333333';
        $btnHoverBg = $setting->btn_hover_bg ?? '#db3636ff';
        $btnHoverText = $setting->btn_hover_text ?? '#ffffff';
        $footerBg = $setting->footer_bg ?? '#222222';
        $footerText = $setting->footer_text ?? '#ffffff';
        $copyrightBg = $setting->copyright_bg ?? '#111111';

        // Convert hex to rgb for opacity usage
        $hex = ltrim($primary, '#');
        if(strlen($hex) == 3) { $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2]; }
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
        $primaryRgb = "$r, $g, $b";
    @endphp
    <style>
        :root {
            --primary-color: {{ $primary }};
            --secondary-color: {{ $secondary }};
            --hover-color: {{ $hover }};
            --primary-rgb: {{ $primaryRgb }};

            /* New Variables */
            --mobile-header-bg: {{ $mobileHeaderBg }};
            --mobile-menu-bg: {{ $mobileMenuBg }};
            --mobile-menu-text: {{ $mobileMenuText }};
            --btn-hover-bg: {{ $btnHoverBg }};
            --btn-hover-text: {{ $btnHoverText }};
            --footer-bg: {{ $footerBg }};
            --footer-text: {{ $footerText }};
            --copyright-bg: {{ $copyrightBg }};
        }

        /* Generic Classes */
        .bg1 { background-color: var(--primary-color) !important; }
        .cl1 { color: var(--primary-color) !important; }
        
        /* Buttons and Hover Effects */
        .hov-btn1:hover { 
            background-color: var(--secondary-color) !important; 
            border-color: var(--secondary-color) !important; 
            color: #fff !important; 
        }
        .hov-btn2:hover {
            border-color: var(--primary-color) !important;
            color: var(--primary-color) !important;
        }
        .hov-btn3:hover { 
            background-color: var(--hover-color) !important; 
            border-color: var(--hover-color) !important; 
            color: #fff !important; 
        }

        /* Helper class for dynamic button hovers if not covered by above */
        .dynamic-btn-hover:hover {
            background-color: var(--btn-hover-bg) !important;
            color: var(--btn-hover-text) !important;
            border-color: var(--btn-hover-bg) !important;
        }

        .hov-tag1:hover {
            border-color: var(--primary-color) !important;
            color: var(--primary-color) !important;
        }

        /* Loaders and Overlays */
        #page-loader { background: var(--primary-color) !important; }
        .loader05 { border-color: var(--primary-color) !important; }
        
        .block1-txt:hover { 
            background-color: rgba(var(--primary-rgb), 0.7) !important; 
        }
        .hov-ovelay1::after {
            background-color: rgba(var(--primary-rgb), 0.8) !important;
        }

        /* Components */
        .btn-back-to-top, .main-menu-m, .icon-header-noti::after, .swal-button, .bbc { 
            background-color: var(--primary-color) !important; 
        }
        .btn-back-to-top:hover {
            background-color: var(--primary-color) !important; 
            opacity: 1;
        }
        
        .main-menu > li:hover > a, 
        .filter-link-active, 
        .filter-link:hover, 
        a.filter-link-active { 
            color: var(--primary-color) !important; 
        }
        
        /* Fixed Desktop Navbar Hover - Black Text */
        .fix-menu-desktop .main-menu > li:hover > a {
            color: #000000 !important;
        }
        
        .filter-link-active, .filter-link:hover {
            border-bottom-color: var(--primary-color) !important;
        }

        /* Isotope Active Filter */
        .how-active1 {
            color: #333;
            border-color: var(--primary-color) !important;
        }

        /* Mobile Menu */
        .header-v3 .fix-menu-desktop .wrap-menu-desktop,
        .show-filter:hover:after,
        .show-search:hover:after {
            background-color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
        }
        
        /* Misc */
        .arrow-slick1:hover { color: var(--primary-color) !important; }
        .label1::after { background-color: var(--primary-color) !important; }
        
        /* Selection */
        ::selection {
            background: var(--primary-color) !important;
            color: #fff;
        }

        /* Fixed Mobile Header & Menu Colors */
        .wrap-header-mobile {
            background-color: var(--mobile-header-bg) !important;
        }
        .menu-mobile {
            background-color: var(--mobile-menu-bg) !important;
        }
        .main-menu-m {
            background-color: var(--mobile-menu-bg) !important;
        }
        .main-menu-m > li > a {
            color: var(--mobile-menu-text) !important;
        }
        .hamburger-inner, .hamburger-inner::before, .hamburger-inner::after {
            background-color: var(--mobile-menu-text) !important;
        }

        /* Footer Colors */
        footer {
            background-color: var(--footer-bg) !important;
            color: var(--footer-text) !important;
        }
        footer h4, footer a, footer p, footer span, footer li {
            color: var(--footer-text) !important;
        }
        
        @media (max-width: 992px) {
            .wrap-header-mobile {
                position: fixed;
                top: 0;
                left: 0; 
                width: 100%;
                z-index: 9999;
            }
            .menu-mobile {
                position: fixed;
                top: 70px; /* wrap-header-mobile height */
                width: 100%;
                z-index: 9998;
                overflow-y: auto;
                max-height: calc(100vh - 70px);
            }
            /* Add padding to prevent content from hiding behind fixed header */
            body {
                padding-top: 70px;
            }
        }
    </style>
    @endif