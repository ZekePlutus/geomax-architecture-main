<div id="kt_app_header" class="app-header" data-kt-sticky="true" data-kt-sticky-activate="{default: true, lg: true}"
    data-kt-sticky-name="app-header-minimize" data-kt-sticky-offset="{default: '200px', lg: '300px'}"
    data-kt-sticky-animation="false">
    <!--begin::Header container-->
    <div class="app-container container-fluid d-flex align-items-stretch flex-stack" id="kt_app_header_container">
        <!--begin::Header mobile-->
        <div class="d-flex align-items-center d-lg-none">
            <!--begin::Sidebar toggle-->
            <button id="kt_app_sidebar_mobile_toggle"
                class="btn btn-icon btn-color-gray-500 btn-active-color-primary ms-n4 me-1">
                <i class="ki-outline ki-burger-menu-6 fs-2x"></i>
            </button>
            <!--end::Sidebar toggle-->
            <!--begin::Logo-->
            <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0 me-lg-15">
                <a href="/">
                    <img alt="Logo" src="/assets/media/logos/demo50.svg" class="h-30px" />
                </a>
            </div>
            <!--end::Logo-->
            <!--begin::Header mobile toggle-->
            <div class="d-flex align-items-center d-lg-none ms-2" title="Show sidebar menu">
                <div class="btn btn-icon btn-color-white bg-white bg-opacity-0 bg-hover-opacity-10 w-35px h-35px"
                    id="kt_app_sidebar_mobile_toggle">
                    <i class="ki-outline ki-abstract-14 fs-2"></i>
                </div>
            </div>
            <!--end::Header mobile toggle-->
        </div>
        <!--end::Header mobile-->
        <!--begin::Navbar wrapper-->
        <div class="d-flex flex-stack justify-content-end flex-row-fluid" id="kt_app_navbar_wrapper">
            <div class="page-entry d-flex flex-column flex-row-fluid" data-kt-swapper="true"
                data-kt-swapper-mode="{default: 'prepend', lg: 'prepend'}"
                data-kt-swapper-parent="{default: '#kt_app_toolbar_container', lg: '#kt_app_navbar_wrapper'}">
                <!--begin::Breadcrumb-->
                @include("layout50.header.breadcrumb")
                <!--end::Breadcrumb-->
                <!--begin::Page title-->
                <div class="page-title d-flex align-items-center">
                    <!--begin::Title-->
                 @include("layout50.header.title")
                    <!--end::Title-->
                </div>
                <!--end::Page title-->
            </div>
            <!--begin::Navbar-->
            <div class="app-navbar flex-shrink-0">
                <!--begin::Search-->
                <div class="d-flex align-items-center align-items-stretch">
                    <!--begin::Search-->
                    @include("layout50.header.search")
                    <!--end::Search-->
                </div>
                <!--end::Search-->

                <!--begin::Chat-->
                @include('layout50.header.chat')
                <!--end::Chat-->
            </div>
            <!--end::Navbar-->
        </div>
        <!--end::Navbar wrapper-->
    </div>
    <!--end::Header container-->
</div>
