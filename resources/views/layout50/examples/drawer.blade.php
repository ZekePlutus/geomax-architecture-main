@extends('layout50.master')

@section('title', 'Drawer Component')

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
                    <a href="{{ route('examples') }}" class="btn btn-sm btn-icon btn-light-primary me-3">
                        <i class="ki-outline ki-arrow-left fs-2"></i>
                    </a>
                    <h2>Drawer Component</h2>
                </div>
                <div class="card-toolbar">
                    <a href="https://preview.keenthemes.com/html/metronic/docs/?page=general/drawer" target="_blank" class="btn btn-sm btn-light-primary">
                        <i class="ki-outline ki-document fs-4 me-1"></i>
                        Metronic Docs
                    </a>
                </div>
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0">
                <p class="text-muted fs-6">
                    KTDrawer is Metronic's exclusive offcanvas/sidebar component. 
                    It slides in from the side of the screen and can contain any content.
                </p>
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
    <!--end::Col-->
</div>
<!--end::Row-->

<!--begin::Row - Basic Drawer -->
<div class="row g-5 g-xl-10 mt-5">
    <div class="col-12">
        <!--begin::Card-->
        <div class="card card-flush">
            <!--begin::Card header-->
            <div class="card-header pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-900">Basic Drawer</span>
                    <span class="text-muted mt-1 fw-semibold fs-7">Simple drawer with title</span>
                </h3>
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-5">
                <div class="row">
                    <div class="col-lg-6">
                        <!--begin::Preview-->
                        <div class="rounded border p-5 mb-5 bg-light-dark">
                            <button id="kt_basic_drawer_toggle" class="btn btn-primary">
                                <i class="ki-outline ki-arrow-right fs-2 me-1"></i>
                                Open Basic Drawer
                            </button>

                            <x-offconvas.drawer 
                                id="kt_basic_drawer" 
                                name="basic"
                                title="Basic Drawer"
                                subtitle="Simple example"
                            >
                                <p class="text-gray-700">
                                    This is a basic drawer with just a title and content.
                                </p>
                                <p class="text-gray-500">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                                    Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                </p>
                            </x-offconvas.drawer>
                        </div>
                        <!--end::Preview-->
                    </div>
                    <div class="col-lg-6">
                        <!--begin::Code-->
                        <div class="rounded border p-5 bg-dark h-100">
<pre class="text-white mb-0"><code>{{-- Toggle Button --}}
&lt;button id="kt_basic_drawer_toggle" class="btn btn-primary"&gt;
    Open Basic Drawer
&lt;/button&gt;

{{-- Drawer Component --}}
&lt;x-offconvas.drawer 
    id="kt_basic_drawer" 
    name="basic"
    title="Basic Drawer"
    subtitle="Simple example"
&gt;
    &lt;p&gt;Your content here...&lt;/p&gt;
&lt;/x-offconvas.drawer&gt;</code></pre>
                        </div>
                        <!--end::Code-->
                    </div>
                </div>
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
</div>
<!--end::Row-->

<!--begin::Row - Drawer with Footer -->
<div class="row g-5 g-xl-10 mt-5">
    <div class="col-12">
        <!--begin::Card-->
        <div class="card card-flush">
            <!--begin::Card header-->
            <div class="card-header pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-900">Drawer with Footer</span>
                    <span class="text-muted mt-1 fw-semibold fs-7">Include action buttons in footer</span>
                </h3>
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-5">
                <div class="row">
                    <div class="col-lg-6">
                        <!--begin::Preview-->
                        <div class="rounded border p-5 mb-5 bg-light-dark">
                            <button id="kt_footer_drawer_toggle" class="btn btn-success">
                                <i class="ki-outline ki-arrow-right fs-2 me-1"></i>
                                Open Drawer with Footer
                            </button>

                            <x-offconvas.drawer 
                                id="kt_footer_drawer" 
                                name="footer-example"
                                title="Edit Profile"
                                subtitle="Update your information"
                                :showFooter="true"
                            >
                                <x-form.input.base 
                                    label="Full Name" 
                                    name="drawer_name" 
                                    placeholder="Enter your name"
                                    variant="solid"
                                />
                                <x-form.input.base 
                                    label="Email" 
                                    name="drawer_email" 
                                    type="email"
                                    placeholder="name@example.com"
                                    variant="solid"
                                />

                                <x-slot name="footer">
                                    <button class="btn btn-light me-3" data-kt-drawer-dismiss="true">Cancel</button>
                                    <button class="btn btn-primary">Save Changes</button>
                                </x-slot>
                            </x-offconvas.drawer>
                        </div>
                        <!--end::Preview-->
                    </div>
                    <div class="col-lg-6">
                        <!--begin::Code-->
                        <div class="rounded border p-5 bg-dark h-100">
<pre class="text-white mb-0"><code>&lt;x-offconvas.drawer 
    id="kt_footer_drawer" 
    name="footer-example"
    title="Edit Profile"
    :showFooter="true"
&gt;
    {{-- Body content --}}
    &lt;x-form.input.base 
        label="Full Name" 
        name="name" 
        variant="solid"
    /&gt;

    {{-- Footer slot --}}
    &lt;x-slot name="footer"&gt;
        &lt;button class="btn btn-light" 
            data-kt-drawer-dismiss="true"&gt;
            Cancel
        &lt;/button&gt;
        &lt;button class="btn btn-primary"&gt;
            Save
        &lt;/button&gt;
    &lt;/x-slot&gt;
&lt;/x-offconvas.drawer&gt;</code></pre>
                        </div>
                        <!--end::Code-->
                    </div>
                </div>
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
</div>
<!--end::Row-->

<!--begin::Row - Left Side Drawer -->
<div class="row g-5 g-xl-10 mt-5">
    <div class="col-12">
        <!--begin::Card-->
        <div class="card card-flush">
            <!--begin::Card header-->
            <div class="card-header pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-900">Left Side Drawer</span>
                    <span class="text-muted mt-1 fw-semibold fs-7">Drawer sliding from the left</span>
                </h3>
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-5">
                <div class="row">
                    <div class="col-lg-6">
                        <!--begin::Preview-->
                        <div class="rounded border p-5 mb-5 bg-light-dark">
                            <button id="kt_left_drawer_toggle" class="btn btn-info">
                                <i class="ki-outline ki-arrow-left fs-2 me-1"></i>
                                Open Left Drawer
                            </button>

                            <x-offconvas.drawer 
                                id="kt_left_drawer" 
                                name="left-example"
                                title="Filter Options"
                                direction="start"
                                width="350px"
                                :showFooter="true"
                            >
                                <div class="mb-5">
                                    <label class="form-label">Category</label>
                                    <select class="form-select form-select-solid">
                                        <option>All Categories</option>
                                        <option>Electronics</option>
                                        <option>Clothing</option>
                                        <option>Books</option>
                                    </select>
                                </div>
                                <div class="mb-5">
                                    <label class="form-label">Price Range</label>
                                    <select class="form-select form-select-solid">
                                        <option>All Prices</option>
                                        <option>$0 - $50</option>
                                        <option>$50 - $100</option>
                                        <option>$100+</option>
                                    </select>
                                </div>

                                <x-slot name="footer">
                                    <button class="btn btn-light me-3" data-kt-drawer-dismiss="true">Reset</button>
                                    <button class="btn btn-primary">Apply Filters</button>
                                </x-slot>
                            </x-offconvas.drawer>
                        </div>
                        <!--end::Preview-->
                    </div>
                    <div class="col-lg-6">
                        <!--begin::Code-->
                        <div class="rounded border p-5 bg-dark h-100">
<pre class="text-white mb-0"><code>&lt;x-offconvas.drawer 
    id="kt_left_drawer" 
    name="left-example"
    title="Filter Options"
    direction="start"
    width="350px"
    :showFooter="true"
&gt;
    {{-- Filter content --}}
    &lt;div class="mb-5"&gt;
        &lt;label&gt;Category&lt;/label&gt;
        &lt;select class="form-select form-select-solid"&gt;
            &lt;option&gt;All Categories&lt;/option&gt;
        &lt;/select&gt;
    &lt;/div&gt;

    &lt;x-slot name="footer"&gt;
        &lt;button class="btn btn-light"&gt;Reset&lt;/button&gt;
        &lt;button class="btn btn-primary"&gt;Apply&lt;/button&gt;
    &lt;/x-slot&gt;
&lt;/x-offconvas.drawer&gt;</code></pre>
                        </div>
                        <!--end::Code-->
                    </div>
                </div>
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
</div>
<!--end::Row-->

<!--begin::Row - Permanent Drawer -->
<div class="row g-5 g-xl-10 mt-5">
    <div class="col-12">
        <!--begin::Card-->
        <div class="card card-flush">
            <!--begin::Card header-->
            <div class="card-header pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-900">Permanent Drawer</span>
                    <span class="text-muted mt-1 fw-semibold fs-7">Cannot be closed by clicking overlay</span>
                </h3>
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-5">
                <div class="row">
                    <div class="col-lg-6">
                        <!--begin::Preview-->
                        <div class="rounded border p-5 mb-5 bg-light-dark">
                            <button id="kt_permanent_drawer_toggle" class="btn btn-warning">
                                <i class="ki-outline ki-lock fs-2 me-1"></i>
                                Open Permanent Drawer
                            </button>

                            <x-offconvas.drawer 
                                id="kt_permanent_drawer" 
                                name="permanent-example"
                                title="Important Notice"
                                :permanent="true"
                            >
                                <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed p-6 mb-5">
                                    <i class="ki-outline ki-information-5 fs-2tx text-warning me-4"></i>
                                    <div class="d-flex flex-stack flex-grow-1">
                                        <div class="fw-semibold">
                                            <div class="fs-6 text-gray-700">
                                                This drawer cannot be closed by clicking the overlay. 
                                                You must use the close button.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-gray-600">
                                    This is useful for important confirmations or mandatory forms.
                                </p>
                            </x-offconvas.drawer>
                        </div>
                        <!--end::Preview-->
                    </div>
                    <div class="col-lg-6">
                        <!--begin::Code-->
                        <div class="rounded border p-5 bg-dark h-100">
<pre class="text-white mb-0"><code>&lt;x-offconvas.drawer 
    id="kt_permanent_drawer" 
    name="permanent-example"
    title="Important Notice"
    :permanent="true"
&gt;
    &lt;p&gt;This drawer cannot be closed 
    by clicking the overlay.&lt;/p&gt;
&lt;/x-offconvas.drawer&gt;</code></pre>
                        </div>
                        <!--end::Code-->
                    </div>
                </div>
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
</div>
<!--end::Row-->

<!--begin::Row - External Toggle -->
<div class="row g-5 g-xl-10 mt-5">
    <div class="col-12">
        <!--begin::Card-->
        <div class="card card-flush">
            <!--begin::Card header-->
            <div class="card-header pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-900">External Toggle</span>
                    <span class="text-muted mt-1 fw-semibold fs-7">Toggle without ID binding using data attributes</span>
                </h3>
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-5">
                <div class="row">
                    <div class="col-lg-6">
                        <!--begin::Preview-->
                        <div class="rounded border p-5 mb-5 bg-light-dark">
                            <button class="btn btn-dark" data-kt-drawer-show="true" data-kt-drawer-target="#kt_basic_drawer">
                                <i class="ki-outline ki-exit-right fs-2 me-1"></i>
                                External Toggle (Opens Basic Drawer)
                            </button>
                        </div>
                        <!--end::Preview-->
                    </div>
                    <div class="col-lg-6">
                        <!--begin::Code-->
                        <div class="rounded border p-5 bg-dark h-100">
<pre class="text-white mb-0"><code>{{-- No ID binding needed --}}
&lt;button 
    class="btn btn-dark" 
    data-kt-drawer-show="true" 
    data-kt-drawer-target="#kt_basic_drawer"
&gt;
    External Toggle
&lt;/button&gt;</code></pre>
                        </div>
                        <!--end::Code-->
                    </div>
                </div>
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
</div>
<!--end::Row-->

<!--begin::Row - Props Reference -->
<div class="row g-5 g-xl-10 mt-5 mb-10">
    <div class="col-12">
        <!--begin::Card-->
        <div class="card card-flush">
            <!--begin::Card header-->
            <div class="card-header pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-900">Props Reference</span>
                    <span class="text-muted mt-1 fw-semibold fs-7">All available component properties</span>
                </h3>
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-5">
                <div class="table-responsive">
                    <table class="table table-row-bordered table-row-gray-300 gy-4">
                        <thead>
                            <tr class="fw-bold text-muted bg-light">
                                <th class="ps-4 rounded-start">Prop</th>
                                <th>Type</th>
                                <th>Default</th>
                                <th class="pe-4 rounded-end">Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="ps-4"><code>id</code></td>
                                <td><span class="badge badge-light-info">string</span></td>
                                <td><span class="text-muted">kt_drawer</span></td>
                                <td>Unique drawer ID</td>
                            </tr>
                            <tr>
                                <td class="ps-4"><code>name</code></td>
                                <td><span class="badge badge-light-info">string</span></td>
                                <td><span class="text-muted">drawer</span></td>
                                <td>Drawer name for JS identification</td>
                            </tr>
                            <tr>
                                <td class="ps-4"><code>title</code></td>
                                <td><span class="badge badge-light-info">string</span></td>
                                <td><span class="text-muted">Drawer Title</span></td>
                                <td>Header title text</td>
                            </tr>
                            <tr>
                                <td class="ps-4"><code>subtitle</code></td>
                                <td><span class="badge badge-light-info">string</span></td>
                                <td><span class="text-muted">null</span></td>
                                <td>Optional subtitle below title</td>
                            </tr>
                            <tr>
                                <td class="ps-4"><code>direction</code></td>
                                <td><span class="badge badge-light-info">string</span></td>
                                <td><span class="text-muted">end</span></td>
                                <td>Slide direction: start (left), end (right)</td>
                            </tr>
                            <tr>
                                <td class="ps-4"><code>width</code></td>
                                <td><span class="badge badge-light-info">string</span></td>
                                <td><span class="text-muted">{default:'300px', 'md': '500px'}</span></td>
                                <td>Responsive width (can be JSON for breakpoints)</td>
                            </tr>
                            <tr>
                                <td class="ps-4"><code>overlay</code></td>
                                <td><span class="badge badge-light-success">bool</span></td>
                                <td><span class="text-muted">true</span></td>
                                <td>Show backdrop overlay</td>
                            </tr>
                            <tr>
                                <td class="ps-4"><code>permanent</code></td>
                                <td><span class="badge badge-light-success">bool</span></td>
                                <td><span class="text-muted">false</span></td>
                                <td>Prevent close on overlay click</td>
                            </tr>
                            <tr>
                                <td class="ps-4"><code>escape</code></td>
                                <td><span class="badge badge-light-success">bool</span></td>
                                <td><span class="text-muted">false</span></td>
                                <td>Close on ESC key press</td>
                            </tr>
                            <tr>
                                <td class="ps-4"><code>activate</code></td>
                                <td><span class="badge badge-light-info">string</span></td>
                                <td><span class="text-muted">true</span></td>
                                <td>Responsive activation: true, false, or {default: false, lg: true}</td>
                            </tr>
                            <tr>
                                <td class="ps-4"><code>showHeader</code></td>
                                <td><span class="badge badge-light-success">bool</span></td>
                                <td><span class="text-muted">true</span></td>
                                <td>Show/hide header section</td>
                            </tr>
                            <tr>
                                <td class="ps-4"><code>showFooter</code></td>
                                <td><span class="badge badge-light-success">bool</span></td>
                                <td><span class="text-muted">false</span></td>
                                <td>Show/hide footer section</td>
                            </tr>
                            <tr>
                                <td class="ps-4"><code>showMenu</code></td>
                                <td><span class="badge badge-light-success">bool</span></td>
                                <td><span class="text-muted">false</span></td>
                                <td>Show menu slot in header</td>
                            </tr>
                            <tr>
                                <td class="ps-4"><code>scrollable</code></td>
                                <td><span class="badge badge-light-success">bool</span></td>
                                <td><span class="text-muted">true</span></td>
                                <td>Enable KTScroll in body</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!--begin::JS Methods-->
                <h5 class="fw-bold mt-10 mb-5">JavaScript Methods</h5>
                <div class="rounded border p-5 bg-dark">
<pre class="text-white mb-0"><code>// Get drawer instance
var drawer = KTDrawer.getInstance(document.querySelector("#kt_basic_drawer"));

// Methods
drawer.show();      // Open drawer
drawer.hide();      // Close drawer
drawer.toggle();    // Toggle state
drawer.isShown();   // Check if open (returns boolean)

// Events
drawer.on("kt.drawer.shown", function() {
    console.log("Drawer opened!");
});

drawer.on("kt.drawer.hidden", function() {
    console.log("Drawer closed!");
});</code></pre>
                </div>
                <!--end::JS Methods-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
</div>
<!--end::Row-->
@endsection
