{{--
    Metronic KTDrawer Component
    
    Documentation: https://preview.keenthemes.com/html/metronic/docs/?page=general/drawer
    
    Usage:
    <x-offconvas.drawer id="kt_my_drawer" name="my-drawer" title="My Title">
        Content here...
    </x-offconvas.drawer>
    
    Toggle button (place anywhere):
    <button id="kt_my_drawer_toggle">Open</button>
    
    Or use external toggle without binding:
    <button data-kt-drawer-show="true" data-kt-drawer-target="#kt_my_drawer">Open</button>
--}}

@props([
    'id' => 'kt_drawer',
    'name' => 'drawer',
    'title' => 'Drawer Title',
    'subtitle' => null,
    'direction' => 'end',                                   // start (left), end (right)
    'width' => "{default:'300px', 'md': '500px'}",          // Responsive width
    'overlay' => true,                                      // Show backdrop
    'permanent' => false,                                   // Prevent close on overlay click
    'escape' => false,                                      // Close on ESC key
    'activate' => 'true',                                   // Can be: true, false, or {default: false, lg: true}
    'headerClass' => '',
    'bodyClass' => '',
    'footerClass' => '',
    'showHeader' => true,
    'showFooter' => false,
    'showMenu' => false,
    'scrollable' => true,                                   // Enable scroll in body
])

<div 
    id="{{ $id }}" 
    class="bg-body" 
    data-kt-drawer="true" 
    data-kt-drawer-name="{{ $name }}" 
    data-kt-drawer-activate="{{ is_array($activate) ? json_encode($activate) : $activate }}"
    data-kt-drawer-overlay="{{ $overlay ? 'true' : 'false' }}" 
    data-kt-drawer-width="{{ $width }}" 
    data-kt-drawer-direction="{{ $direction }}"
    data-kt-drawer-toggle="#{{ $id }}_toggle" 
    data-kt-drawer-close="#{{ $id }}_close"
    @if($permanent) data-kt-drawer-permanent="true" @endif
    @if($escape) data-kt-drawer-escape="true" @endif
    {{ $attributes }}
>
    <!--begin::Card-->
    <div class="card w-100 border-0 rounded-0" id="{{ $id }}_content">
        @if($showHeader)
        <!--begin::Card header-->
        <div class="card-header pe-5 {{ $headerClass }}" id="{{ $id }}_header">
            <!--begin::Title-->
            <div class="card-title">
                @if(isset($headerTitle))
                    {{ $headerTitle }}
                @else
                <div class="d-flex justify-content-center flex-column me-3">
                    <span class="fs-4 fw-bold text-gray-900 me-1 mb-2 lh-1">{{ $title }}</span>
                    @if($subtitle)
                    <div class="mb-0 lh-1">
                        <span class="fs-7 fw-semibold text-muted">{{ $subtitle }}</span>
                    </div>
                    @endif
                </div>
                @endif
            </div>
            <!--end::Title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                @if($showMenu && isset($menu))
                <!--begin::Menu-->
                <div class="me-2">
                    {{ $menu }}
                </div>
                <!--end::Menu-->
                @endif
                <!--begin::Close-->
                <div class="btn btn-sm btn-icon btn-active-color-primary" id="{{ $id }}_close">
                    <i class="ki-outline ki-cross-square fs-2"></i>
                </div>
                <!--end::Close-->
            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->
        @endif

        <!--begin::Card body-->
        <div class="card-body {{ $scrollable ? 'hover-scroll-overlay-y' : '' }} {{ $bodyClass }}" id="{{ $id }}_body"
            @if($scrollable)
            data-kt-scroll="true"
            data-kt-scroll-activate="true"
            data-kt-scroll-height="auto"
            data-kt-scroll-dependencies="#{{ $id }}_header{{ $showFooter ? ', #' . $id . '_footer' : '' }}"
            data-kt-scroll-wrappers="#{{ $id }}_body"
            data-kt-scroll-offset="0px"
            @endif
        >
            {{ $slot }}
        </div>
        <!--end::Card body-->

        @if($showFooter)
        <!--begin::Card footer-->
        <div class="card-footer pt-4 {{ $footerClass }}" id="{{ $id }}_footer">
            {{ $footer ?? '' }}
        </div>
        <!--end::Card footer-->
        @endif
    </div>
    <!--end::Card-->
</div>
