@extends('layout50.master')

@section('title', 'Component Examples')

@section('content')
<!--begin::Row-->
<div class="row g-5 g-xl-10">
    <!--begin::Col-->
    <div class="col-12">
        <!--begin::Card-->
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header border-0 pt-6">
                <div class="card-title">
                    <h2>Component Library</h2>
                </div>
                <div class="card-toolbar">
                    <span class="badge badge-light-primary fs-7">Metronic Compatible</span>
                </div>
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0">
                <p class="text-muted fs-6">
                    Browse all available Laravel Blade components compatible with 
                    <a href="https://preview.keenthemes.com/html/metronic/docs/" target="_blank" class="link-primary">Metronic Template</a>.
                    Click on any component to see examples and usage documentation.
                </p>
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
    <!--end::Col-->
</div>
<!--end::Row-->

<!--begin::Row - Form Components -->
<div class="row g-5 g-xl-10 mt-5">
    <div class="col-12">
        <h3 class="fw-bold mb-5">
            <i class="ki-outline ki-notepad-edit fs-2 me-2 text-primary"></i>
            Form Components
        </h3>
    </div>

    <!--begin::Col - Input -->
    <div class="col-md-4 col-lg-3">
        <a href="{{ route('examples.form.input') }}" class="card card-flush h-100 hover-elevate-up">
            <div class="card-body d-flex flex-column align-items-center justify-content-center py-10">
                <div class="symbol symbol-60px symbol-circle mb-5 bg-light-primary">
                    <span class="symbol-label">
                        <i class="ki-outline ki-text-bold fs-2x text-primary"></i>
                    </span>
                </div>
                <span class="fs-5 fw-bold text-gray-800 mb-1">Input</span>
                <span class="fs-7 text-muted">Text, Email, Password, etc.</span>
            </div>
        </a>
    </div>
    <!--end::Col-->

    <!--begin::Col - Range -->
    <div class="col-md-4 col-lg-3">
        <a href="{{ route('examples.form.range') }}" class="card card-flush h-100 hover-elevate-up">
            <div class="card-body d-flex flex-column align-items-center justify-content-center py-10">
                <div class="symbol symbol-60px symbol-circle mb-5 bg-light-primary">
                    <span class="symbol-label">
                        <i class="ki-outline ki-slider fs-2x text-primary"></i>
                    </span>
                </div>
                <span class="fs-5 fw-bold text-gray-800 mb-1">Range</span>
                <span class="fs-7 text-muted">Slider, Volume, Rating</span>
            </div>
        </a>
    </div>
    <!--end::Col-->

    <!--begin::Col - Textarea -->
    <div class="col-md-4 col-lg-3">
        <div class="card card-flush h-100 bg-light">
            <div class="card-body d-flex flex-column align-items-center justify-content-center py-10">
                <div class="symbol symbol-60px symbol-circle mb-5 bg-light-secondary">
                    <span class="symbol-label">
                        <i class="ki-outline ki-text-align-left fs-2x text-secondary"></i>
                    </span>
                </div>
                <span class="fs-5 fw-bold text-gray-600 mb-1">Textarea</span>
                <span class="badge badge-light-warning fs-8">Coming Soon</span>
            </div>
        </div>
    </div>
    <!--end::Col-->

    <!--begin::Col - Select -->
    <div class="col-md-4 col-lg-3">
        <div class="card card-flush h-100 bg-light">
            <div class="card-body d-flex flex-column align-items-center justify-content-center py-10">
                <div class="symbol symbol-60px symbol-circle mb-5 bg-light-secondary">
                    <span class="symbol-label">
                        <i class="ki-outline ki-down-square fs-2x text-secondary"></i>
                    </span>
                </div>
                <span class="fs-5 fw-bold text-gray-600 mb-1">Select</span>
                <span class="badge badge-light-warning fs-8">Coming Soon</span>
            </div>
        </div>
    </div>
    <!--end::Col-->

    <!--begin::Col - Checkbox & Radio -->
    <div class="col-md-4 col-lg-3">
        <div class="card card-flush h-100 bg-light">
            <div class="card-body d-flex flex-column align-items-center justify-content-center py-10">
                <div class="symbol symbol-60px symbol-circle mb-5 bg-light-secondary">
                    <span class="symbol-label">
                        <i class="ki-outline ki-check-square fs-2x text-secondary"></i>
                    </span>
                </div>
                <span class="fs-5 fw-bold text-gray-600 mb-1">Checkbox & Radio</span>
                <span class="badge badge-light-warning fs-8">Coming Soon</span>
            </div>
        </div>
    </div>
    <!--end::Col-->
</div>
<!--end::Row-->

<!--begin::Row - General Components -->
<div class="row g-5 g-xl-10 mt-5">
    <div class="col-12">
        <h3 class="fw-bold mb-5">
            <i class="ki-outline ki-element-11 fs-2 me-2 text-info"></i>
            General Components
        </h3>
    </div>

    <!--begin::Col - Drawer -->
    <div class="col-md-4 col-lg-3">
        <a href="{{ route('examples.drawer') }}" class="card card-flush h-100 hover-elevate-up">
            <div class="card-body d-flex flex-column align-items-center justify-content-center py-10">
                <div class="symbol symbol-60px symbol-circle mb-5 bg-light-info">
                    <span class="symbol-label">
                        <i class="ki-outline ki-arrow-right-left fs-2x text-info"></i>
                    </span>
                </div>
                <span class="fs-5 fw-bold text-gray-800 mb-1">Drawer</span>
                <span class="fs-7 text-muted">Offcanvas / Sidebar</span>
            </div>
        </a>
    </div>
    <!--end::Col-->

    <!--begin::Col - Modal -->
    <div class="col-md-4 col-lg-3">
        <div class="card card-flush h-100 bg-light">
            <div class="card-body d-flex flex-column align-items-center justify-content-center py-10">
                <div class="symbol symbol-60px symbol-circle mb-5 bg-light-secondary">
                    <span class="symbol-label">
                        <i class="ki-outline ki-abstract-26 fs-2x text-secondary"></i>
                    </span>
                </div>
                <span class="fs-5 fw-bold text-gray-600 mb-1">Modal</span>
                <span class="badge badge-light-warning fs-8">Coming Soon</span>
            </div>
        </div>
    </div>
    <!--end::Col-->

    <!--begin::Col - Card -->
    <div class="col-md-4 col-lg-3">
        <div class="card card-flush h-100 bg-light">
            <div class="card-body d-flex flex-column align-items-center justify-content-center py-10">
                <div class="symbol symbol-60px symbol-circle mb-5 bg-light-secondary">
                    <span class="symbol-label">
                        <i class="ki-outline ki-note fs-2x text-secondary"></i>
                    </span>
                </div>
                <span class="fs-5 fw-bold text-gray-600 mb-1">Card</span>
                <span class="badge badge-light-warning fs-8">Coming Soon</span>
            </div>
        </div>
    </div>
    <!--end::Col-->

    <!--begin::Col - Alert -->
    <div class="col-md-4 col-lg-3">
        <div class="card card-flush h-100 bg-light">
            <div class="card-body d-flex flex-column align-items-center justify-content-center py-10">
                <div class="symbol symbol-60px symbol-circle mb-5 bg-light-secondary">
                    <span class="symbol-label">
                        <i class="ki-outline ki-notification-bing fs-2x text-secondary"></i>
                    </span>
                </div>
                <span class="fs-5 fw-bold text-gray-600 mb-1">Alert</span>
                <span class="badge badge-light-warning fs-8">Coming Soon</span>
            </div>
        </div>
    </div>
    <!--end::Col-->
</div>
<!--end::Row-->

<!--begin::Row - Data Components -->
<div class="row g-5 g-xl-10 mt-5">
    <div class="col-12">
        <h3 class="fw-bold mb-5">
            <i class="ki-outline ki-chart-simple fs-2 me-2 text-success"></i>
            Data Components
        </h3>
    </div>

    <!--begin::Col - Table -->
    <div class="col-md-4 col-lg-3">
        <div class="card card-flush h-100 bg-light">
            <div class="card-body d-flex flex-column align-items-center justify-content-center py-10">
                <div class="symbol symbol-60px symbol-circle mb-5 bg-light-secondary">
                    <span class="symbol-label">
                        <i class="ki-outline ki-row-horizontal fs-2x text-secondary"></i>
                    </span>
                </div>
                <span class="fs-5 fw-bold text-gray-600 mb-1">Table</span>
                <span class="badge badge-light-warning fs-8">Coming Soon</span>
            </div>
        </div>
    </div>
    <!--end::Col-->

    <!--begin::Col - DataTable -->
    <div class="col-md-4 col-lg-3">
        <a href="{{ url('/examples/datatable') }}" class="card card-flush h-100 bg-hover-light-primary border border-hover-primary">
            <div class="card-body d-flex flex-column align-items-center justify-content-center py-10">
                <div class="symbol symbol-60px symbol-circle mb-5 bg-light-primary">
                    <span class="symbol-label">
                        <i class="ki-outline ki-filter-search fs-2x text-primary"></i>
                    </span>
                </div>
                <span class="fs-5 fw-bold text-gray-800 mb-1">DataTable</span>
                <span class="badge badge-light-success fs-8">Ready</span>
            </div>
        </a>
    </div>
    <!--end::Col-->
</div>
<!--end::Row-->
@endsection
