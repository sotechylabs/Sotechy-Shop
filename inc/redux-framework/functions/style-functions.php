<?php
/**
 * Filter functions for Styling Section of Theme Options
 */

if ( ! function_exists( 'redux_toggle_use_predefined_colors' ) ) {
    function redux_toggle_use_predefined_colors( $enable ) {
        global $electro_options;

        if ( isset( $electro_options['use_predefined_color'] ) && $electro_options['use_predefined_color'] ) {
            $enable = true;
        } else {
            $enable = false;
        }

        return $enable;
    }
}

if( ! function_exists( 'redux_apply_primary_color' ) ) {
    function redux_apply_primary_color( $color ) {
        global $electro_options;

        if ( isset( $electro_options['main_color'] ) ) {
            $color = $electro_options['main_color'];
        }

        return $color;
    }
}

if ( ! function_exists( 'sass_darken' ) ) {
    function sass_darken( $hex, $percent ) {
        preg_match( '/^#?([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})$/i', $hex, $primary_colors );
        str_replace( '%', '', $percent );
        $percent = (int) $percent;
        $color = "#";
        for( $i = 1; $i <= 3; $i++ ) {
            if ( isset( $primary_colors[$i] ) ) {
                $primary_colors[$i] = hexdec( $primary_colors[$i] );
                if ( $percent > 50 ) $percent = 50;
                $dv = 100 - ( $percent * 2 );
                $primary_colors[$i] = round( $primary_colors[$i] * ( $dv ) / 100 );
                $color .= str_pad( dechex( $primary_colors[$i] ), 2, '0', STR_PAD_LEFT );
            }
        }
        return $color;
    }
}

if ( ! function_exists( 'redux_apply_custom_color_css' ) ) {
    function redux_apply_custom_color_css() {
        global $electro_options;

        if ( isset( $electro_options['use_predefined_color'] ) && $electro_options['use_predefined_color'] ) {
            return;
        }

        $how_to_include = isset( $electro_options['include_custom_color'] ) ? $electro_options['include_custom_color'] : '1';

        if ( $how_to_include != '1' ) {
            return;
        }

        ?><style type="text/css"><?php echo redux_get_custom_color_css(); ?></style><?php
    }
}

if ( ! function_exists( 'redux_get_custom_color_css' ) ) {
    function redux_get_custom_color_css() {
        global $electro_options;

        $primary_color      = isset( $electro_options['custom_primary_color'] ) ? $electro_options['custom_primary_color'] : '#0787ea';
        $primary_text_color = isset( $electro_options['custom_primary_text_color'] ) ? $electro_options['custom_primary_text_color'] : '#fff';
        $color_body         = '#333e48';

        $active_background  = sass_darken( $primary_color, '100%' );
        $active_border      = sass_darken( $primary_color, '100%' );

        $styles             = '
        .footer-call-us .call-us-icon i,
        .header-support-info .support-icon i,
        .header-support-inner .support-icon,
        .widget_electro_products_filter .widget_layered_nav li > a:hover::before,
        .widget_electro_products_filter .widget_layered_nav li > a:focus::before,
        .widget_electro_products_filter .widget_product_categories li > a:hover::before,
        .widget_electro_products_filter .widget_product_categories li > a:focus::before,
        .widget_electro_products_filter .widget_layered_nav li.chosen > a::before,
        .widget_electro_products_filter .widget_product_categories li.current-cat > a::before,
        .features-list .media-left i,
        .secondary-nav>.dropdown.open >a::before,
        .secondary-nav>.dropdown.show >a::before,
        p.stars a,
        .top-bar.top-bar-v1 #menu-top-bar-left.nav-inline .menu-item > a i,
        .handheld-footer .handheld-footer-bar .footer-call-us .call-us-text span,
        .footer-v2 .handheld-footer .handheld-footer-bar .footer-call-us .call-us-text span,
        .top-bar .menu-item.customer-support i,
        .header-v13 .primary-nav-menu .nav-inline>.menu-item>a:hover,
        .header-v13 .primary-nav-menu .nav-inline>.dropdown:hover > a,
        .header-v13 .off-canvas-navigation-wrapper .navbar-toggler:hover,
        .header-v13 .off-canvas-navigation-wrapper button:hover,
        .header-v13 .off-canvas-navigation-wrapper.toggled .navbar-toggler:hover,
        .header-v13 .off-canvas-navigation-wrapper.toggled button:hover {
            color: ' . $primary_color . ';
        }

        .header-logo svg ellipse,
        .footer-logo svg ellipse{
            fill:' . $primary_color . ';
        }

        .primary-nav .nav-inline > .menu-item .dropdown-menu,
        .primary-nav-menu .nav-inline > .menu-item .dropdown-menu,
        .navbar-primary .navbar-nav > .menu-item .dropdown-menu,
        .vertical-menu .menu-item-has-children > .dropdown-menu,
        .departments-menu .menu-item-has-children:hover > .dropdown-menu,
        .top-bar .nav-inline > .menu-item .dropdown-menu,
        .secondary-nav>.dropdown .dropdown-menu,
        .header-v6 .vertical-menu .list-group-item > .dropdown-menu,
        .best-selling-menu .nav-item>ul>li.electro-more-menu-item .dropdown-menu,
        .home-v5-slider .tp-tab.selected .tp-tab-title:before,
        .home-v5-slider .tp-tab.selected .tp-tab-title:after,
        .header-v5 .electro-navigation .departments-menu-v2>.dropdown>.dropdown-menu,
        .product-categories-list-with-header.v2 header .caption .section-title:after,
        .primary-nav-menu .nav-inline >.menu-item .dropdown-menu,
        .dropdown-menu-mini-cart,
        .dropdown-menu-user-account,
        .electro-navbar-primary .nav>.menu-item.menu-item-has-children .dropdown-menu,
        .header-v6 .header-logo-area .departments-menu-v2 .departments-menu-v2-title+.dropdown-menu,
        .departments-menu-v2 .departments-menu-v2-title+.dropdown-menu li.menu-item-has-children .dropdown-menu,
        .secondary-nav-v6 .secondary-nav-v6-inner .sub-menu,
        .secondary-nav-v6 .widget_nav_menu .sub-menu {
            border-top-color: ' . $primary_color . ';
        }

        .columns-6-1 > ul.products > li.product .thumbnails > a:hover,
        .primary-nav .nav-inline .yamm-fw.open > a::before,
        .columns-6-1>ul.products.product-main-6-1 .electro-wc-product-gallery__wrapper .electro-wc-product-gallery__image.flex-active-slide img,
        .single-product .electro-wc-product-gallery .electro-wc-product-gallery__wrapper .electro-wc-product-gallery__image.flex-active-slide img,
        .products-6-1-with-categories-inner .product-main-6-1 .images .thumbnails a:hover,
        .home-v5-slider .tp-tab.selected .tp-tab-title:after,
        .electro-navbar .departments-menu-v2 .departments-menu-v2-title+.dropdown-menu li.menu-item-has-children>.dropdown-menu,
        .product-main-6-1 .thumbnails>a:focus, .product-main-6-1 .thumbnails>a:hover,
        .product-main-6-1 .thumbnails>a:focus, .product-main-6-1 .thumbnails>a:focus,
        .product-main-6-1 .thumbnails>a:focus>img, .product-main-6-1 .thumbnails>a:hover>img,
        .product-main-6-1 .thumbnails>a:focus>img, .product-main-6-1 .thumbnails>a:focus>img {
            border-bottom-color: ' . $primary_color . ';
        }

        .navbar-primary,
        .footer-newsletter,
        .button:hover::before,
        li.product:hover .button::before,
        li.product:hover .added_to_cart::before,
        .owl-item .product:hover .button::before,
        .owl-item .product:hover .added_to_cart::before,
        .widget_price_filter .ui-slider .ui-slider-handle,
        .woocommerce-pagination ul.page-numbers > li a.current,
        .woocommerce-pagination ul.page-numbers > li span.current,
        .pagination ul.page-numbers > li a.current,
        .pagination ul.page-numbers > li span.current,
        .owl-dots .owl-dot.active,
        .products-carousel-tabs .nav-link.active::before,
        .deal-progress .progress-bar,
        .products-2-1-2 .nav-link.active::before,
        .products-4-1-4 .nav-link.active::before,
        .da .da-action > a::after,
        .header-v1 .navbar-search .input-group .btn,
        .header-v3 .navbar-search .input-group .btn,
        .header-v6 .navbar-search .input-group .btn,
        .header-v8 .navbar-search .input-group .btn,
        .header-v9 .navbar-search .input-group .btn,
        .header-v10 .navbar-search .input-group .btn,
        .header-v11 .navbar-search .input-group-btn .btn,
        .vertical-menu > li:first-child,
        .widget.widget_tag_cloud .tagcloud a:hover,
        .widget.widget_tag_cloud .tagcloud a:focus,
        .navbar-mini-cart .cart-items-count,
        .navbar-compare .count,
        .navbar-wishlist .count,
        .wc-tabs > li.active a::before,
        .ec-tabs > li.active a::before,
        .woocommerce-info,
        .woocommerce-noreviews,
        p.no-comments,
        .products-2-1-2 .nav-link:hover::before,
        .products-4-1-4 .nav-link:hover::before,
        .single_add_to_cart_button,
        .section-onsale-product-carousel .onsale-product-carousel .onsale-product .onsale-product-content .deal-cart-button .button,
        .section-onsale-product-carousel .onsale-product-carousel .onsale-product .onsale-product-content .deal-cart-button .added_to_cart,
        .wpb-accordion .vc_tta.vc_general .vc_tta-panel.vc_active .vc_tta-panel-heading .vc_tta-panel-title > a i,
        ul.products > li.product.list-view:not(.list-view-small) .button:hover,
        ul.products > li.product.list-view:not(.list-view-small) .button:focus,
        ul.products > li.product.list-view:not(.list-view-small) .button:active,
        ul.products > li.product.list-view.list-view-small .button:hover::after,
        ul.products > li.product.list-view.list-view-small .button:focus::after,
        ul.products > li.product.list-view.list-view-small .button:active::after,
        .widget_electro_products_carousel_widget .section-products-carousel .owl-nav .owl-prev:hover,
        .widget_electro_products_carousel_widget .section-products-carousel .owl-nav .owl-next:hover,
        .full-color-background .header-v3,
        .full-color-background .header-v4,
        .full-color-background .top-bar,
        .top-bar-v3,
        .pace .pace-progress,
        .electro-handheld-footer-bar ul li a .count,
        .handheld-navigation-wrapper .stuck .navbar-toggler,
        .handheld-navigation-wrapper .stuck button,
        .handheld-navigation-wrapper.toggled .stuck .navbar-toggler,
        .handheld-navigation-wrapper.toggled .stuck button,
        .da .da-action>a::after,
        .demo_store,
        .header-v5 .header-top,
        .handheld-header-v2,
        .handheld-header-v2.stuck,
        #payment .place-order button[type=submit],
        .single-product .product-images-wrapper .woocommerce-product-gallery.electro-carousel-loaded .flex-control-nav li a.flex-active,
        .single-product .product-images-wrapper .electro-wc-product-gallery .flex-control-nav li a.flex-active,
        .single-product .product-images-wrapper .flex-control-nav li a.flex-active,
        .section-onsale-product .savings,
        .section-onsale-product-carousel .savings,
        .columns-6-1>ul.products.product-main-6-1>li.product .electro-wc-product-gallery .flex-control-nav li a.flex-active,
        .products-carousel-tabs-v5 header ul.nav-inline .nav-link.active,
        .products-carousel-tabs-with-deal header ul.nav-inline .nav-link.active,
        section .deals-carousel-inner-block .onsale-product .onsale-product-content .deal-cart-button .added_to_cart,
        section .deals-carousel-inner-block .onsale-product .onsale-product-content .deal-cart-button .button,
        .header-icon-counter,
        .electro-navbar,
        .departments-menu-v2-title,
        section .deals-carousel-inner-block .onsale-product .onsale-product-content .deal-cart-button .added_to_cart,
        section .deals-carousel-inner-block .onsale-product .onsale-product-content .deal-cart-button .button,
        .deal-products-with-featured header,
        .deal-products-with-featured ul.products > li.product.product-featured .savings,
        .mobile-header-v2,
        .mobile-header-v2.stuck,
        .product-categories-list-with-header.v2 header .caption .section-title,
        .product-categories-list-with-header.v2 header .caption .section-title,
        .home-mobile-v2-features-block,
        .show-nav .nav .nav-item.active .nav-link,
        .header-v5,
        .header-v5 .stuck,
        .electro-navbar-primary,
        .navbar-search-input-group .navbar-search-button,
        .da-block .da-action::after,
        .products-6-1 header.show-nav ul.nav .nav-item.active .nav-link,
        ul.products[data-view=list-view].columns-1>li.product .product-loop-footer .button,
        ul.products[data-view=list-view].columns-2>li.product .product-loop-footer .button,
        ul.products[data-view=list-view].columns-3>li.product .product-loop-footer .button,
        ul.products[data-view=list-view].columns-4>li.product .product-loop-footer .button,
        ul.products[data-view=list-view].columns-5>li.product .product-loop-footer .button,
        ul.products[data-view=list-view].columns-6>li.product .product-loop-footer .button,
        ul.products[data-view=list-view].columns-7>li.product .product-loop-footer .button,
        ul.products[data-view=list-view].columns-8>li.product .product-loop-footer .button,
        ul.products[data-view=list-view]>li.product .product-item__footer .add-to-cart-wrap a,
        .products.show-btn>li.product .added_to_cart,
        .products.show-btn>li.product .button,
        .yith-wcqv-button,
        .header-v7 .masthead,
        .header-v10 .secondary-nav-menu,
        section.category-icons-carousel-v2,
        .category-icons-carousel .category a:hover .category-icon,
        .products-carousel-banner-vertical-tabs .banners-tabs>.nav a.active,
        .products-carousel-with-timer .deal-countdown-timer,
        .section-onsale-product-carousel-v9 .onsale-product .deal-countdown-timer,
        .dokan-elector-style-active.store-v1 .profile-frame + .dokan-store-tabs > ul li.active a:after,
        .dokan-elector-style-active.store-v5 .profile-frame + .dokan-store-tabs > ul li.active a:after,
        .aws-container .aws-search-form .aws-search-clear,
        div.wpforms-container-full .wpforms-form input[type=submit],
        div.wpforms-container-full .wpforms-form button[type=submit],
        div.wpforms-container-full .wpforms-form .wpforms-page-button,
        .electro-dark .full-color-background .masthead .navbar-search .input-group .btn,
        .electro-dark .electro-navbar-primary .nav>.menu-item:hover>a,
        .electro-dark .masthead .navbar-search .input-group .btn {
            background-color: ' . $primary_color . ';
        }

        .electro-navbar .departments-menu-v2 .departments-menu-v2-title+.dropdown-menu li.menu-item-has-children>.dropdown-menu,
        .products-carousel-banner-vertical-tabs .banners-tabs>.nav a.active::before {
            border-right-color: ' . $primary_color . ';
        }

        .hero-action-btn:hover {
            background-color: ' . sass_darken( $primary_color, '4%' ) . ' !important;
        }

        .hero-action-btn,
        #scrollUp,
        .custom .tp-bullet.selected,
        .home-v1-slider .btn-primary,
        .home-v2-slider .btn-primary,
        .home-v3-slider .btn-primary,
        .electro-dark .show-nav .nav .active .nav-link,
        .electro-dark .full-color-background .masthead .header-icon-counter,
        .electro-dark .full-color-background .masthead .navbar-search .input-group .btn,
        .electro-dark .electro-navbar-primary .nav>.menu-item:hover>a,
        .electro-dark .masthead .navbar-search .input-group .btn,
        .home-v13-hero-search .woocommerce-product-search button {
            background-color: ' . $primary_color . ' !important;
        }

        .departments-menu .departments-menu-dropdown,
        .departments-menu .menu-item-has-children > .dropdown-menu,
        .widget_price_filter .ui-slider .ui-slider-handle:last-child,
        section header h1::after,
        section header .h1::after,
        .products-carousel-tabs .nav-link.active::after,
        section.section-product-cards-carousel header ul.nav .active .nav-link,
        section.section-onsale-product,
        section.section-onsale-product-carousel .onsale-product-carousel,
        .products-2-1-2 .nav-link.active::after,
        .products-4-1-4 .nav-link.active::after,
        .products-6-1 header ul.nav .active .nav-link,
        .header-v1 .navbar-search .input-group .form-control,
        .header-v1 .navbar-search .input-group .input-group-addon,
        .header-v1 .navbar-search .input-group .btn,
        .header-v3 .navbar-search .input-group .form-control,
        .header-v3 .navbar-search .input-group .input-group-addon,
        .header-v3 .navbar-search .input-group .btn,
        .header-v6 .navbar-search .input-group .form-control,
        .header-v6 .navbar-search .input-group .input-group-addon,
        .header-v6 .navbar-search .input-group .btn,
        .header-v8 .navbar-search .input-group .form-control,
        .header-v8 .navbar-search .input-group .input-group-addon,
        .header-v8 .navbar-search .input-group .btn,
        .header-v9 .navbar-search .input-group .form-control,
        .header-v9 .navbar-search .input-group .input-group-addon,
        .header-v9 .navbar-search .input-group .btn,
        .header-v10 .navbar-search .input-group .form-control,
        .header-v10 .navbar-search .input-group .input-group-addon,
        .header-v10 .navbar-search .input-group .btn,
        .widget.widget_tag_cloud .tagcloud a:hover,
        .widget.widget_tag_cloud .tagcloud a:focus,
        .navbar-primary .navbar-mini-cart .dropdown-menu-mini-cart,
        .woocommerce-checkout h3::after,
        #customer_login h2::after,
        .customer-login-form h2::after,
        .navbar-primary .navbar-mini-cart .dropdown-menu-mini-cart,
        .woocommerce-edit-address form h3::after,
        .edit-account legend::after,
        .woocommerce-account h2::after,
        .address header.title h3::after,
        .addresses header.title h3::after,
        .woocommerce-order-received h2::after,
        .track-order h2::after,
        .wc-tabs > li.active a::after,
        .ec-tabs > li.active a::after,
        .comments-title::after,
        .comment-reply-title::after,
        .pings-title::after,
        #reviews #comments > h2::after,
        .single-product .woocommerce-tabs ~ div.products > h2::after,
        .single-product .electro-tabs ~ div.products > h2::after,
        .single-product .related>h2::after,
        .single-product .up-sells>h2::after,
        .cart-collaterals h2:not(.woocommerce-loop-product__title)::after,
        .footer-widgets .widget-title:after,
        .sidebar .widget-title::after,
        .sidebar-blog .widget-title::after,
        .contact-page-title::after,
        #reviews:not(.electro-advanced-reviews) #comments > h2::after,
        .cpf-type-range .tm-range-picker .noUi-origin .noUi-handle,
        .widget_electro_products_carousel_widget .section-products-carousel .owl-nav .owl-prev:hover,
        .widget_electro_products_carousel_widget .section-products-carousel .owl-nav .owl-next:hover,
        .wpb-accordion .vc_tta.vc_general .vc_tta-panel.vc_active .vc_tta-panel-heading .vc_tta-panel-title > a i,
        .single-product .woocommerce-tabs+section.products>h2::after,
        #payment .place-order button[type=submit],
        .single-product .electro-tabs+section.products>h2::after,
        .deal-products-carousel .deal-products-carousel-inner .deal-products-timer header .section-title:after,
        .deal-products-carousel .deal-products-carousel-inner .deal-countdown > span,
        .deals-carousel-inner-block .onsale-product .onsale-product-content .deal-countdown > span,
        .home-v5-slider .section-onsale-product-v2 .onsale-product .onsale-product-content .deal-countdown > span,
        .products-with-category-image header ul.nav-inline .active .nav-link,
        .products-6-1-with-categories header ul.nav-inline .active .nav-link,
        .products-carousel-tabs-v5 header ul.nav-inline .nav-link:hover,
        .products-carousel-tabs-with-deal header ul.nav-inline .nav-link:hover,
        section.products-carousel-v5 header .nav-inline .active .nav-link,
        .mobile-header-v1 .site-search .widget.widget_product_search form,
        .mobile-header-v1 .site-search .widget.widget_search form,
        .show-nav .nav .nav-item.active .nav-link,
        .departments-menu-v2 .departments-menu-v2-title+.dropdown-menu,
        .navbar-search-input-group .search-field,
        .navbar-search-input-group .custom-select,
        .products-6-1 header.show-nav ul.nav .nav-item.active .nav-link,
        .header-v1 .aws-container .aws-search-field,
        .header-v3 .aws-container .aws-search-field,
        .header-v6 .aws-container .aws-search-field,
        .header-v8 .aws-container .aws-search-field,
        div.wpforms-container-full .wpforms-form input[type=submit],
        div.wpforms-container-full .wpforms-form button[type=submit],
        div.wpforms-container-full .wpforms-form .wpforms-page-button,
        .electro-dark .electro-navbar .navbar-search .input-group .btn,
        .electro-dark .masthead .navbar-search .input-group .btn,
        .home-v13-vertical-menu .vertical-menu-title .title::after {
            border-color: ' . $primary_color . ';
        }

        @media (min-width: 1480px) {
            .onsale-product-carousel .onsale-product__inner {
        		border-color: ' . $primary_color . ';
        	}
        }

        .widget_price_filter .price_slider_amount .button,
        .dropdown-menu-mini-cart .wc-forward.checkout,
        table.cart .actions .checkout-button,
        .cart-collaterals .cart_totals .wc-proceed-to-checkout a,
        .customer-login-form .button,
        .btn-primary,
        input[type="submit"],
        input.dokan-btn-theme[type="submit"],
        a.dokan-btn-theme, .dokan-btn-theme,
        .sign-in-button,
        .products-carousel-banner-vertical-tabs .banners-tabs .tab-content-inner>a,
        .dokan-store-support-and-follow-wrap .dokan-btn {
          color: ' . $primary_text_color . ';
          background-color: ' . $primary_color . ';
          border-color: ' . $primary_color . ';
        }

        .widget_price_filter .price_slider_amount .button:hover,
        .dropdown-menu-mini-cart .wc-forward.checkout:hover,
        table.cart .actions .checkout-button:hover,
        .customer-login-form .button:hover,
        .btn-primary:hover,
        input[type="submit"]:hover,
        input.dokan-btn-theme[type="submit"]:hover,
        a.dokan-btn-theme:hover, .dokan-btn-theme:hover,
        .sign-in-button:hover,
        .products-carousel-banner-vertical-tabs .banners-tabs .tab-content-inner>a:hover,
        .dokan-store-support-and-follow-wrap .dokan-btn:hover {
          color: #fff;
          background-color: ' . $active_background . ';
          border-color: ' . $active_border . ';
        }

        .widget_price_filter .price_slider_amount .button:focus, .widget_price_filter .price_slider_amount .button.focus,
        .dropdown-menu-mini-cart .wc-forward.checkout:focus,
        .dropdown-menu-mini-cart .wc-forward.checkout.focus,
        table.cart .actions .checkout-button:focus,
        table.cart .actions .checkout-button.focus,
        .customer-login-form .button:focus,
        .customer-login-form .button.focus,
        .btn-primary:focus,
        .btn-primary.focus,
        input[type="submit"]:focus,
        input[type="submit"].focus,
        input.dokan-btn-theme[type="submit"]:focus,
        input.dokan-btn-theme[type="submit"].focus,
        a.dokan-btn-theme:focus,
        a.dokan-btn-theme.focus, .dokan-btn-theme:focus, .dokan-btn-theme.focus,
        .sign-in-button:focus,
        .products-carousel-banner-vertical-tabs .banners-tabs .tab-content-inner>a:focus,
        .dokan-store-support-and-follow-wrap .dokan-btn:focus {
          color: #fff;
          background-color: ' . $active_background . ';
          border-color: ' . $active_border . ';
        }

        .widget_price_filter .price_slider_amount .button:active, .widget_price_filter .price_slider_amount .button.active, .open > .widget_price_filter .price_slider_amount .button.dropdown-toggle,
        .dropdown-menu-mini-cart .wc-forward.checkout:active,
        .dropdown-menu-mini-cart .wc-forward.checkout.active, .open >
        .dropdown-menu-mini-cart .wc-forward.checkout.dropdown-toggle,
        table.cart .actions .checkout-button:active,
        table.cart .actions .checkout-button.active, .open >
        table.cart .actions .checkout-button.dropdown-toggle,
        .customer-login-form .button:active,
        .customer-login-form .button.active, .open >
        .customer-login-form .button.dropdown-toggle,
        .btn-primary:active,
        .btn-primary.active, .open >
        .btn-primary.dropdown-toggle,
        input[type="submit"]:active,
        input[type="submit"].active, .open >
        input[type="submit"].dropdown-toggle,
        input.dokan-btn-theme[type="submit"]:active,
        input.dokan-btn-theme[type="submit"].active, .open >
        input.dokan-btn-theme[type="submit"].dropdown-toggle,
        a.dokan-btn-theme:active,
        a.dokan-btn-theme.active, .open >
        a.dokan-btn-theme.dropdown-toggle, .dokan-btn-theme:active, .dokan-btn-theme.active, .open > .dokan-btn-theme.dropdown-toggle {
          color: ' . $primary_text_color . ';
          background-color: ' . $active_background . ';
          border-color: ' . $active_border . ';
          background-image: none;
        }

        .widget_price_filter .price_slider_amount .button:active:hover, .widget_price_filter .price_slider_amount .button:active:focus, .widget_price_filter .price_slider_amount .button:active.focus, .widget_price_filter .price_slider_amount .button.active:hover, .widget_price_filter .price_slider_amount .button.active:focus, .widget_price_filter .price_slider_amount .button.active.focus, .open > .widget_price_filter .price_slider_amount .button.dropdown-toggle:hover, .open > .widget_price_filter .price_slider_amount .button.dropdown-toggle:focus, .open > .widget_price_filter .price_slider_amount .button.dropdown-toggle.focus,
        .dropdown-menu-mini-cart .wc-forward.checkout:active:hover,
        .dropdown-menu-mini-cart .wc-forward.checkout:active:focus,
        .dropdown-menu-mini-cart .wc-forward.checkout:active.focus,
        .dropdown-menu-mini-cart .wc-forward.checkout.active:hover,
        .dropdown-menu-mini-cart .wc-forward.checkout.active:focus,
        .dropdown-menu-mini-cart .wc-forward.checkout.active.focus, .open >
        .dropdown-menu-mini-cart .wc-forward.checkout.dropdown-toggle:hover, .open >
        .dropdown-menu-mini-cart .wc-forward.checkout.dropdown-toggle:focus, .open >
        .dropdown-menu-mini-cart .wc-forward.checkout.dropdown-toggle.focus,
        table.cart .actions .checkout-button:active:hover,
        table.cart .actions .checkout-button:active:focus,
        table.cart .actions .checkout-button:active.focus,
        table.cart .actions .checkout-button.active:hover,
        table.cart .actions .checkout-button.active:focus,
        table.cart .actions .checkout-button.active.focus, .open >
        table.cart .actions .checkout-button.dropdown-toggle:hover, .open >
        table.cart .actions .checkout-button.dropdown-toggle:focus, .open >
        table.cart .actions .checkout-button.dropdown-toggle.focus,
        .customer-login-form .button:active:hover,
        .customer-login-form .button:active:focus,
        .customer-login-form .button:active.focus,
        .customer-login-form .button.active:hover,
        .customer-login-form .button.active:focus,
        .customer-login-form .button.active.focus, .open >
        .customer-login-form .button.dropdown-toggle:hover, .open >
        .customer-login-form .button.dropdown-toggle:focus, .open >
        .customer-login-form .button.dropdown-toggle.focus,
        .btn-primary:active:hover,
        .btn-primary:active:focus,
        .btn-primary:active.focus,
        .btn-primary.active:hover,
        .btn-primary.active:focus,
        .btn-primary.active.focus, .open >
        .btn-primary.dropdown-toggle:hover, .open >
        .btn-primary.dropdown-toggle:focus, .open >
        .btn-primary.dropdown-toggle.focus,
        input[type="submit"]:active:hover,
        input[type="submit"]:active:focus,
        input[type="submit"]:active.focus,
        input[type="submit"].active:hover,
        input[type="submit"].active:focus,
        input[type="submit"].active.focus, .open >
        input[type="submit"].dropdown-toggle:hover, .open >
        input[type="submit"].dropdown-toggle:focus, .open >
        input[type="submit"].dropdown-toggle.focus,
        input.dokan-btn-theme[type="submit"]:active:hover,
        input.dokan-btn-theme[type="submit"]:active:focus,
        input.dokan-btn-theme[type="submit"]:active.focus,
        input.dokan-btn-theme[type="submit"].active:hover,
        input.dokan-btn-theme[type="submit"].active:focus,
        input.dokan-btn-theme[type="submit"].active.focus, .open >
        input.dokan-btn-theme[type="submit"].dropdown-toggle:hover, .open >
        input.dokan-btn-theme[type="submit"].dropdown-toggle:focus, .open >
        input.dokan-btn-theme[type="submit"].dropdown-toggle.focus,
        a.dokan-btn-theme:active:hover,
        a.dokan-btn-theme:active:focus,
        a.dokan-btn-theme:active.focus,
        a.dokan-btn-theme.active:hover,
        a.dokan-btn-theme.active:focus,
        a.dokan-btn-theme.active.focus, .open >
        a.dokan-btn-theme.dropdown-toggle:hover, .open >
        a.dokan-btn-theme.dropdown-toggle:focus, .open >
        a.dokan-btn-theme.dropdown-toggle.focus, .dokan-btn-theme:active:hover, .dokan-btn-theme:active:focus, .dokan-btn-theme:active.focus, .dokan-btn-theme.active:hover, .dokan-btn-theme.active:focus, .dokan-btn-theme.active.focus, .open > .dokan-btn-theme.dropdown-toggle:hover, .open > .dokan-btn-theme.dropdown-toggle:focus, .open > .dokan-btn-theme.dropdown-toggle.focus {
          color: ' . $primary_text_color . ';
          background-color: ' . sass_darken( $primary_color, '17%' ) . ';
          border-color: ' . sass_darken( $primary_color, '25%' ) . ';
        }

        .widget_price_filter .price_slider_amount .button.disabled:focus, .widget_price_filter .price_slider_amount .button.disabled.focus, .widget_price_filter .price_slider_amount .button:disabled:focus, .widget_price_filter .price_slider_amount .button:disabled.focus,
        .dropdown-menu-mini-cart .wc-forward.checkout.disabled:focus,
        .dropdown-menu-mini-cart .wc-forward.checkout.disabled.focus,
        .dropdown-menu-mini-cart .wc-forward.checkout:disabled:focus,
        .dropdown-menu-mini-cart .wc-forward.checkout:disabled.focus,
        table.cart .actions .checkout-button.disabled:focus,
        table.cart .actions .checkout-button.disabled.focus,
        table.cart .actions .checkout-button:disabled:focus,
        table.cart .actions .checkout-button:disabled.focus,
        .customer-login-form .button.disabled:focus,
        .customer-login-form .button.disabled.focus,
        .customer-login-form .button:disabled:focus,
        .customer-login-form .button:disabled.focus,
        .btn-primary.disabled:focus,
        .btn-primary.disabled.focus,
        .btn-primary:disabled:focus,
        .btn-primary:disabled.focus,
        input[type="submit"].disabled:focus,
        input[type="submit"].disabled.focus,
        input[type="submit"]:disabled:focus,
        input[type="submit"]:disabled.focus,
        input.dokan-btn-theme[type="submit"].disabled:focus,
        input.dokan-btn-theme[type="submit"].disabled.focus,
        input.dokan-btn-theme[type="submit"]:disabled:focus,
        input.dokan-btn-theme[type="submit"]:disabled.focus,
        a.dokan-btn-theme.disabled:focus,
        a.dokan-btn-theme.disabled.focus,
        a.dokan-btn-theme:disabled:focus,
        a.dokan-btn-theme:disabled.focus, .dokan-btn-theme.disabled:focus, .dokan-btn-theme.disabled.focus, .dokan-btn-theme:disabled:focus, .dokan-btn-theme:disabled.focus {
          background-color: ' . $primary_color . ';
          border-color: ' . $primary_color . ';
        }

        .widget_price_filter .price_slider_amount .button.disabled:hover, .widget_price_filter .price_slider_amount .button:disabled:hover,
        .dropdown-menu-mini-cart .wc-forward.checkout.disabled:hover,
        .dropdown-menu-mini-cart .wc-forward.checkout:disabled:hover,
        table.cart .actions .checkout-button.disabled:hover,
        table.cart .actions .checkout-button:disabled:hover,
        .customer-login-form .button.disabled:hover,
        .customer-login-form .button:disabled:hover,
        .btn-primary.disabled:hover,
        .btn-primary:disabled:hover,
        input[type="submit"].disabled:hover,
        input[type="submit"]:disabled:hover,
        input.dokan-btn-theme[type="submit"].disabled:hover,
        input.dokan-btn-theme[type="submit"]:disabled:hover,
        a.dokan-btn-theme.disabled:hover,
        a.dokan-btn-theme:disabled:hover, .dokan-btn-theme.disabled:hover, .dokan-btn-theme:disabled:hover {
          background-color: ' . $primary_color . ';
          border-color: ' . $primary_color . ';
        }

        .navbar-primary .navbar-nav > .menu-item > a:hover,
        .navbar-primary .navbar-nav > .menu-item > a:focus,
        .electro-navbar-primary .nav>.menu-item>a:focus,
        .electro-navbar-primary .nav>.menu-item>a:hover  {
            background-color: ' . sass_darken( $primary_color, '4.5%' ) . ';
        }

        .navbar-primary .navbar-nav > .menu-item > a {
            border-color: ' . sass_darken( $primary_color, '4.5%' ) . ';
        }

        .full-color-background .navbar-primary,
        .header-v4 .electro-navbar-primary,
        .header-v4 .electro-navbar-primary {
            border-top-color: ' . sass_darken( $primary_color, '4.5%' ) . ';
        }

        .full-color-background .top-bar .nav-inline .menu-item+.menu-item:before {
            color: ' . sass_darken( $primary_color, '4.5%' ) . ';
        }

        .electro-navbar-primary .nav>.menu-item+.menu-item>a,
        .home-mobile-v2-features-block .features-list .feature+.feature .media {
            border-left-color: ' . sass_darken( $primary_color, '4.5%' ) . ';
        }

        .header-v5 .vertical-menu .list-group-item>.dropdown-menu {
            border-top-color: ' . $primary_color . ';
        }

        .single-product div.thumbnails-all .synced a,
        .woocommerce-product-gallery .flex-control-thumbs li img.flex-active,
        .columns-6-1>ul.products.product-main-6-1 .flex-control-thumbs li img.flex-active,
        .products-2-1-2 .nav-link:hover::after,
        .products-4-1-4 .nav-link:hover::after,
        .section-onsale-product-carousel .onsale-product-carousel .onsale-product .onsale-product-thumbnails .images .thumbnails a.current,
        .dokan-elector-style-active.store-v1 .profile-frame + .dokan-store-tabs > ul li.active a,
        .dokan-elector-style-active.store-v5 .profile-frame + .dokan-store-tabs > ul li.active a {
            border-bottom-color: ' . $primary_color . ';
        }

        .home-v1-slider .btn-primary:hover,
        .home-v2-slider .btn-primary:hover,
        .home-v3-slider .btn-primary:hover {
            background-color: ' . sass_darken( $primary_color, '4%' ) . ' !important;
        }


        /*........Dokan.......*/

        .dokan-dashboard .dokan-dash-sidebar ul.dokan-dashboard-menu li.active,
        .dokan-dashboard .dokan-dash-sidebar ul.dokan-dashboard-menu li:hover,
        .dokan-dashboard .dokan-dash-sidebar ul.dokan-dashboard-menu li:focus,
        .dokan-dashboard .dokan-dash-sidebar ul.dokan-dashboard-menu li.dokan-common-links a:hover,
        .dokan-dashboard .dokan-dash-sidebar ul.dokan-dashboard-menu li.dokan-common-links a:focus,
        .dokan-dashboard .dokan-dash-sidebar ul.dokan-dashboard-menu li.dokan-common-links a.active,
        .dokan-store .pagination-wrap ul.pagination > li a.current,
        .dokan-store .pagination-wrap ul.pagination > li span.current,
        .dokan-dashboard .pagination-wrap ul.pagination > li a.current,
        .dokan-dashboard .pagination-wrap ul.pagination > li span.current,
        .dokan-pagination-container ul.dokan-pagination > li.active > a,
        .dokan-coupon-content .code:hover,
        .dokan-report-wrap ul.dokan_tabs > li.active a::before,
        .dokan-dashboard-header h1.entry-title span.dokan-right a.dokan-btn.dokan-btn-sm {
            background-color: ' . $primary_color . ';
        }

        .dokan-widget-area .widget .widget-title:after,
        .dokan-report-wrap ul.dokan_tabs > li.active a::after,
        .dokan-dashboard-header h1.entry-title span.dokan-right a.dokan-btn.dokan-btn-sm,
        .dokan-store-sidebar .widget-store-owner .widget-title:after {
            border-color: ' . $primary_color . ';
        }

        .electro-tabs #tab-seller.electro-tab .tab-content ul.list-unstyled li.seller-name span.details a,
        .dokan-dashboard-header h1.entry-title small a,
        .dokan-orders-content .dokan-orders-area .general-details ul.customer-details li a{
            color: ' . $primary_color . ';
        }

        .dokan-dashboard-header h1.entry-title small a:hover,
        .dokan-dashboard-header h1.entry-title small a:focus {
            color: ' . sass_darken( $primary_color , '4%' ) . ';
        }

        .dokan-store-support-and-follow-wrap .dokan-btn {
            color: ' . $primary_text_color . '!important;
            background-color: ' . $primary_color . '!important;
        }

        .dokan-store-support-and-follow-wrap .dokan-btn:hover {
            color: ' . sass_darken( $primary_text_color, '4%' ) . '!important;
            background-color: ' . sass_darken( $primary_color, '4%' ) . '!important;
        }

        .header-v1 .navbar-search .input-group .btn,
        .header-v1 .navbar-search .input-group .hero-action-btn,
        .header-v3 .navbar-search .input-group .btn,
        .header-v3 .navbar-search .input-group .hero-action-btn,
        .header-v6 .navbar-search .input-group .btn,
        .header-v8 .navbar-search .input-group .btn,
        .header-v9 .navbar-search .input-group .btn,
        .header-v10 .navbar-search .input-group .btn,
        .navbar-mini-cart .cart-items-count,
        .navbar-compare .count,
        .navbar-wishlist .count,
        .navbar-primary a[data-bs-toggle=dropdown]::after,
        .navbar-primary .navbar-nav .nav-link,
        .vertical-menu>li.list-group-item>a,
        .vertical-menu>li.list-group-item>span,
        .vertical-menu>li.list-group-item.dropdown>a[data-bs-toggle=dropdown-hover],
        .vertical-menu>li.list-group-item.dropdown>a[data-bs-toggle=dropdown],
        .departments-menu>.nav-item .nav-link,
        .customer-login-form .button,
        .dropdown-menu-mini-cart .wc-forward.checkout,
        .widget_price_filter .price_slider_amount .button,
        input[type=submit],
        table.cart .actions .checkout-button,
        .pagination ul.page-numbers>li a.current,
        .pagination ul.page-numbers>li span.current,
        .woocommerce-pagination ul.page-numbers>li a.current,
        .woocommerce-pagination ul.page-numbers>li span.current,
        .footer-newsletter .newsletter-title::before,
        .footer-newsletter .newsletter-marketing-text,
        .footer-newsletter .newsletter-title,
        .top-bar-v3 .nav-inline .menu-item>a,
        .top-bar-v3 .menu-item.customer-support.menu-item>a i,
        .top-bar-v3 .additional-links-label,
        .full-color-background .top-bar .nav-inline .menu-item>a,
        .full-color-background .top-bar .nav-inline .menu-item+.menu-item:before,
        .full-color-background .header-v1 .navbar-nav .nav-link,
        .full-color-background .header-v3 .navbar-nav .nav-link,
        .full-color-background .navbar-primary .navbar-nav>.menu-item>a,
        .full-color-background .navbar-primary .navbar-nav>.menu-item>a:focus,
        .full-color-background .navbar-primary .navbar-nav>.menu-item>a:hover,
        .woocommerce-info,
        .woocommerce-noreviews,
        p.no-comments,
        .woocommerce-info a,
        .woocommerce-info button,
        .woocommerce-noreviews a,
        .woocommerce-noreviews button,
        p.no-comments a,
        p.no-comments button,
        .navbar-primary .navbar-nav > .menu-item >a,
        .navbar-primary .navbar-nav > .menu-item >a:hover,
        .navbar-primary .navbar-nav > .menu-item >a:focus,
        .demo_store,
        .header-v5 .masthead .header-icon>a,
        .header-v4 .masthead .header-icon>a,
        .departments-menu-v2-title,
        .departments-menu-v2-title:focus,
        .departments-menu-v2-title:hover,
        .electro-navbar .header-icon>a,
        .section-onsale-product .savings,
        .section-onsale-product-carousel .savings,
        .electro-navbar-primary .nav>.menu-item>a,
        .header-icon .header-icon-counter,
        .header-v6 .navbar-search .input-group .btn,
        .products-carousel-tabs-v5 header .nav-link.active,
        #payment .place-order .button,
        .deal-products-with-featured header h2,
        .deal-products-with-featured ul.products>li.product.product-featured .savings,
        .deal-products-with-featured header h2:after,
        .deal-products-with-featured header .deal-countdown-timer,
        .deal-products-with-featured header .deal-countdown-timer:before,
        .product-categories-list-with-header.v2 header .caption .section-title,
        .home-mobile-v2-features-block .features-list .media-left i,
        .home-mobile-v2-features-block .features-list .feature,
        .handheld-header-v2 .handheld-header-links .columns-3 a,
        .handheld-header-v2 .off-canvas-navigation-wrapper .navbar-toggler,
        .handheld-header-v2 .off-canvas-navigation-wrapper button,
        .handheld-header-v2 .off-canvas-navigation-wrapper.toggled .navbar-toggler,
        .handheld-header-v2 .off-canvas-navigation-wrapper.toggled button,
        .mobile-header-v2 .handheld-header-links .columns-3 a,
        .mobile-header-v2 .off-canvas-navigation-wrapper .navbar-toggler,
        .mobile-header-v2 .off-canvas-navigation-wrapper button,
        .mobile-header-v2 .off-canvas-navigation-wrapper.toggled .navbar-toggler,
        .mobile-header-v2 .off-canvas-navigation-wrapper.toggled button,
        .mobile-handheld-department ul.nav li a,
        .header-v5 .handheld-header-v2 .handheld-header-links .cart .count,
        .yith-wcqv-button,
        .home-vertical-nav.departments-menu-v2 .vertical-menu-title a,
        .products-carousel-with-timer .deal-countdown-timer,
        .demo_store a,
        div.wpforms-container-full .wpforms-form input[type=submit],
        div.wpforms-container-full .wpforms-form button[type=submit],
        div.wpforms-container-full .wpforms-form .wpforms-page-button,
        .aws-search-form:not(.aws-form-active):not(.aws-processing) .aws-search-clear::after {
            color: ' . $primary_text_color . ';
        }

        .woocommerce-info a:focus,
        .woocommerce-info a:hover,
        .woocommerce-info button:focus,
        .woocommerce-info button:hover,
        .woocommerce-noreviews a:focus,
        .woocommerce-noreviews a:hover,
        .woocommerce-noreviews button:focus,
        .woocommerce-noreviews button:hover,
        p.no-comments a:focus,
        p.no-comments a:hover,
        p.no-comments button:focus,
        p.no-comments button:hover,
        .vertical-menu>li.list-group-item.dropdown>a[data-bs-toggle=dropdown-hover]:hover,
        .vertical-menu>li.list-group-item.dropdown>a[data-bs-toggle=dropdown]:hover,
        .vertical-menu>li.list-group-item.dropdown>a[data-bs-toggle=dropdown-hover]:focus,
        .vertical-menu>li.list-group-item.dropdown>a[data-bs-toggle=dropdown]:focus {
            color: ' . sass_darken( $primary_text_color, '2%' ) . ';
        }

        .full-color-background .header-logo path {
            fill:' . $primary_text_color . ';
        }

        .home-v1-slider .btn-primary,
        .home-v2-slider .btn-primary,
        .home-v3-slider .btn-primary,
        .home-v1-slider .btn-primary:hover,
        .home-v2-slider .btn-primary:hover,
        .home-v3-slider .btn-primary:hover,
        .handheld-navigation-wrapper .stuck .navbar-toggler,
        .handheld-navigation-wrapper .stuck button,
        .handheld-navigation-wrapper.toggled .stuck .navbar-toggler,
        .handheld-navigation-wrapper.toggled .stuck button,
        .header-v5 .masthead .header-icon>a:hover,
        .header-v5 .masthead .header-icon>a:focus,
        .header-v5 .masthead .header-logo-area .navbar-toggler,
        .header-v4 .off-canvas-navigation-wrapper .navbar-toggler,
        .header-v4 .off-canvas-navigation-wrapper button,
        .header-v4 .off-canvas-navigation-wrapper.toggled .navbar-toggler,
        .header-v4 .off-canvas-navigation-wrapper.toggled button,
        .products-carousel-tabs-v5 header .nav-link.active,
        .products-carousel-tabs-with-deal header .nav-link.active {
            color: ' . $primary_text_color . ' !important;
        }

        @media (max-width: 575.98px) {
          .electro-wc-product-gallery .electro-wc-product-gallery__image.flex-active-slide a {
                background-color: ' . $primary_color . ' !important;
            }
        }

        @media (max-width: 767px) {
            .show-nav .nav .nav-item.active .nav-link {
                color: ' . $primary_text_color . ';
            }
        }';

        return $styles;
    }
}

function sass_button_variant( $color, $bg, $border ) {
    return '';
}

function redux_load_external_custom_css() {
    global $electro_options;

    if ( isset( $electro_options['use_predefined_color'] ) && $electro_options['use_predefined_color'] ) {
        return;
    }

    $how_to_include = isset( $electro_options['include_custom_color'] ) ? $electro_options['include_custom_color'] : '1';

    if ( $how_to_include == '1' ) {
        return;
    }

    $custom_color_file = get_stylesheet_directory() . '/custom-color.css';

    if ( file_exists( $custom_color_file ) ) {
        wp_enqueue_style( 'electro-custom-color', get_stylesheet_directory_uri() . '/custom-color.css' );
    }
}

function redux_toggle_custom_css_page() {
    global $electro_options;

    if ( isset( $electro_options['use_predefined_color'] ) && $electro_options['use_predefined_color'] ) {
        $should_add = false;
    } else {
        if ( !isset( $electro_options['include_custom_color'] ) ) {
            $electro_options['include_custom_color'] = '1';
        }

        if ( $electro_options['include_custom_color'] == '2' ) {
            $should_add = true;
        } else {
            $should_add = false;
        }
    }

    return $should_add;
}
