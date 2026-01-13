{{--
    ================================================================================
    GLOBAL UI COMPONENT SHOWCASE
    ================================================================================

    This is a DEVELOPER-ONLY page for testing and previewing global UI components.

    PURPOSE:
    - Visual validation of components
    - Documentation of usage patterns
    - Testing different prop combinations
    - Design consistency verification

    ACCESS:
    - URL: /__components
    - Environment: local, staging, development only
    - No authentication required

    TO ADD NEW COMPONENTS:
    1. Add navigation link in @section('sidebar-nav')
    2. Add component section in @section('content')
    3. Include multiple usage examples
    ================================================================================
--}}

@extends('core-ui.layouts.showcase')

@section('header-title', 'Component Library')
@section('header-description', 'Browse, test, and validate all global UI components in one place')

@section('sidebar-nav')
    <!-- Forms Category -->
    <div class="showcase-nav-category">Form Components</div>
    <a href="#input-base" class="showcase-nav-item active">
        <i class="ki-outline ki-notepad-edit"></i>
        Input Base
    </a>
    <a href="#input-variants" class="showcase-nav-item">
        <i class="ki-outline ki-element-11"></i>
        Input Variants
    </a>
    <a href="#input-masks" class="showcase-nav-item">
        <i class="ki-outline ki-mask"></i>
        Input Masks
    </a>

    <!-- Table Category -->
    <div class="showcase-nav-category">Table Components</div>
    <a href="#datatable-static" class="showcase-nav-item">
        <i class="ki-outline ki-row-horizontal"></i>
        DataTable (Static)
    </a>
    <a href="#datatable-ajax" class="showcase-nav-item">
        <i class="ki-outline ki-cloud-download"></i>
        DataTable (AJAX)
    </a>
    <a href="#datatable-features" class="showcase-nav-item">
        <i class="ki-outline ki-setting-2"></i>
        DataTable Features
    </a>

    <!-- Future Components -->
    <div class="showcase-nav-category">Coming Soon</div>
    <a href="#" class="showcase-nav-item" style="opacity: 0.5; pointer-events: none;">
        <i class="ki-outline ki-tag"></i>
        Tagify
    </a>
    <a href="#" class="showcase-nav-item" style="opacity: 0.5; pointer-events: none;">
        <i class="ki-outline ki-folder-up"></i>
        Dropzone
    </a>
    <a href="#" class="showcase-nav-item" style="opacity: 0.5; pointer-events: none;">
        <i class="ki-outline ki-calendar"></i>
        Date Picker
    </a>
@endsection

@section('content')
    {{-- ================================================================== --}}
    {{-- FORM INPUTS                                                       --}}
    {{-- ================================================================== --}}

    <!-- Basic Input -->
    <section id="input-base" class="showcase-section">
        <div class="showcase-section-header">
            <h3 class="showcase-section-title">
                <i class="ki-outline ki-notepad-edit me-2 text-primary"></i>
                Input Base
                <code>x-form.input.base</code>
            </h3>
            <button class="btn btn-sm btn-light showcase-toggle-code" data-toggle-code="#code-input-base">
                Show Code
            </button>
        </div>
        <div class="showcase-section-body">
            <p class="text-muted mb-5">
                The foundation input component with support for labels, icons, validation, and various input types.
            </p>

            <!-- Example: Basic Input -->
            <div class="showcase-example">
                <div class="showcase-example-label">
                    Basic Text Input
                    <span class="badge badge-light-primary">Default</span>
                </div>
                <div class="showcase-example-preview">
                    <x-form.input.base
                        name="demo_name"
                        label="Full Name"
                        placeholder="Enter your name"
                    />
                </div>
            </div>

            <!-- Example: With Icon -->
            <div class="showcase-example">
                <div class="showcase-example-label">
                    Input with Icon
                </div>
                <div class="showcase-example-preview">
                    <div class="row">
                        <div class="col-md-6">
                            <x-form.input.base
                                name="demo_email"
                                label="Email Address"
                                type="email"
                                placeholder="name@example.com"
                                icon="ki-outline ki-sms"
                            />
                        </div>
                        <div class="col-md-6">
                            <x-form.input.base
                                name="demo_phone"
                                label="Phone Number"
                                type="tel"
                                placeholder="+1 (555) 000-0000"
                                icon="ki-outline ki-phone"
                                icon-position="end"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Example: Required with Tooltip -->
            <div class="showcase-example">
                <div class="showcase-example-label">
                    Required Field with Tooltip
                </div>
                <div class="showcase-example-preview">
                    <x-form.input.base
                        name="demo_required"
                        label="Company Name"
                        placeholder="Enter company name"
                        :required="true"
                        tooltip="This field is required for registration"
                        hint="Your official business name as registered"
                    />
                </div>
            </div>

            <!-- Example: Different Types -->
            <div class="showcase-example">
                <div class="showcase-example-label">
                    Different Input Types
                </div>
                <div class="showcase-example-preview">
                    <div class="row">
                        <div class="col-md-4">
                            <x-form.input.base
                                name="demo_number"
                                label="Quantity"
                                type="number"
                                :min="1"
                                :max="100"
                                value="10"
                            />
                        </div>
                        <div class="col-md-4">
                            <x-form.input.base
                                name="demo_date"
                                label="Date"
                                type="date"
                            />
                        </div>
                        <div class="col-md-4">
                            <x-form.input.base
                                name="demo_color"
                                label="Brand Color"
                                type="color"
                                value="#3699FF"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Code Example -->
        <div id="code-input-base" class="showcase-code-wrapper">
            <div class="showcase-code-header">
                <span class="showcase-code-label">Blade Usage</span>
                <button class="showcase-code-copy">Copy</button>
            </div>
            <pre class="showcase-code">&lt;x-form.input.base
    name="email"
    label="Email Address"
    type="email"
    placeholder="name@example.com"
    icon="ki-outline ki-sms"
    :required="true"
    tooltip="Your primary contact email"
    hint="We'll never share your email"
/&gt;

{{-- With Icon at End --}}
&lt;x-form.input.base
    name="phone"
    label="Phone"
    icon="ki-outline ki-phone"
    icon-position="end"
/&gt;

{{-- Number Input with Min/Max --}}
&lt;x-form.input.base
    name="quantity"
    label="Quantity"
    type="number"
    :min="1"
    :max="100"
    value="10"
/&gt;</pre>
        </div>
    </section>

    <!-- Input Variants -->
    <section id="input-variants" class="showcase-section">
        <div class="showcase-section-header">
            <h3 class="showcase-section-title">
                <i class="ki-outline ki-element-11 me-2 text-primary"></i>
                Input Variants
                <code>variant, size</code>
            </h3>
            <button class="btn btn-sm btn-light showcase-toggle-code" data-toggle-code="#code-input-variants">
                Show Code
            </button>
        </div>
        <div class="showcase-section-body">

            <!-- Variants -->
            <div class="showcase-example">
                <div class="showcase-example-label">
                    Style Variants
                </div>
                <div class="showcase-example-preview">
                    <div class="row">
                        <div class="col-md-4">
                            <x-form.input.base
                                name="demo_solid"
                                label="Solid (Default)"
                                variant="solid"
                                placeholder="Solid variant"
                            />
                        </div>
                        <div class="col-md-4">
                            <x-form.input.base
                                name="demo_transparent"
                                label="Transparent"
                                variant="transparent"
                                placeholder="Transparent variant"
                            />
                        </div>
                        <div class="col-md-4">
                            <x-form.input.base
                                name="demo_flush"
                                label="Flush"
                                variant="flush"
                                placeholder="Flush variant"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sizes -->
            <div class="showcase-example">
                <div class="showcase-example-label">
                    Size Options
                </div>
                <div class="showcase-example-preview">
                    <div class="row align-items-end">
                        <div class="col-md-4">
                            <x-form.input.base
                                name="demo_sm"
                                label="Small"
                                size="sm"
                                placeholder="Small input"
                            />
                        </div>
                        <div class="col-md-4">
                            <x-form.input.base
                                name="demo_default"
                                label="Default"
                                placeholder="Default input"
                            />
                        </div>
                        <div class="col-md-4">
                            <x-form.input.base
                                name="demo_lg"
                                label="Large"
                                size="lg"
                                placeholder="Large input"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Prepend/Append -->
            <div class="showcase-example">
                <div class="showcase-example-label">
                    Prepend & Append
                </div>
                <div class="showcase-example-preview">
                    <div class="row">
                        <div class="col-md-4">
                            <x-form.input.base
                                name="demo_prepend"
                                label="Website"
                                prepend="https://"
                                placeholder="example.com"
                            />
                        </div>
                        <div class="col-md-4">
                            <x-form.input.base
                                name="demo_append"
                                label="Price"
                                type="number"
                                append=".00 USD"
                                placeholder="0"
                            />
                        </div>
                        <div class="col-md-4">
                            <x-form.input.base
                                name="demo_both"
                                label="Subdomain"
                                prepend="https://"
                                append=".myapp.com"
                                placeholder="yourcompany"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <!-- States -->
            <div class="showcase-example">
                <div class="showcase-example-label">
                    Input States
                </div>
                <div class="showcase-example-preview">
                    <div class="row">
                        <div class="col-md-4">
                            <x-form.input.base
                                name="demo_disabled"
                                label="Disabled"
                                value="Cannot edit this"
                                :disabled="true"
                            />
                        </div>
                        <div class="col-md-4">
                            <x-form.input.base
                                name="demo_readonly"
                                label="Readonly"
                                value="Read only value"
                                :readonly="true"
                            />
                        </div>
                        <div class="col-md-4">
                            <x-form.input.base
                                name="demo_error"
                                label="With Error"
                                value="invalid@"
                                error="Please enter a valid email address"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="code-input-variants" class="showcase-code-wrapper">
            <div class="showcase-code-header">
                <span class="showcase-code-label">Blade Usage</span>
                <button class="showcase-code-copy">Copy</button>
            </div>
            <pre class="showcase-code">&lt;!-- Style Variants --&gt;
&lt;x-form.input.base name="field" variant="solid" /&gt;
&lt;x-form.input.base name="field" variant="transparent" /&gt;
&lt;x-form.input.base name="field" variant="flush" /&gt;

&lt;!-- Size Options --&gt;
&lt;x-form.input.base name="field" size="sm" /&gt;
&lt;x-form.input.base name="field" size="lg" /&gt;

&lt;!-- Prepend & Append --&gt;
&lt;x-form.input.base
    name="website"
    prepend="https://"
    placeholder="example.com"
/&gt;

&lt;x-form.input.base
    name="price"
    append=".00 USD"
    type="number"
/&gt;

&lt;x-form.input.base
    name="subdomain"
    prepend="https://"
    append=".myapp.com"
/&gt;

&lt;!-- States --&gt;
&lt;x-form.input.base name="disabled_field" :disabled="true" /&gt;
&lt;x-form.input.base name="readonly_field" :readonly="true" /&gt;
&lt;x-form.input.base name="error_field" error="Validation error message" /&gt;</pre>
        </div>
    </section>

    <!-- Input Masks -->
    <section id="input-masks" class="showcase-section">
        <div class="showcase-section-header">
            <h3 class="showcase-section-title">
                <i class="ki-outline ki-mask me-2 text-primary"></i>
                Input Masks
                <code>mask, maskOptions</code>
            </h3>
            <button class="btn btn-sm btn-light showcase-toggle-code" data-toggle-code="#code-input-masks">
                Show Code
            </button>
        </div>
        <div class="showcase-section-body">
            <p class="text-muted mb-5">
                Input masking using jQuery Mask Plugin for formatted input like phone numbers, dates, and custom patterns.
            </p>

            <div class="showcase-example">
                <div class="showcase-example-label">
                    Common Mask Patterns
                </div>
                <div class="showcase-example-preview">
                    <div class="row">
                        <div class="col-md-4">
                            <x-form.input.base
                                name="demo_phone_mask"
                                label="Phone (US)"
                                mask="(000) 000-0000"
                                placeholder="(555) 123-4567"
                                icon="ki-outline ki-phone"
                            />
                        </div>
                        <div class="col-md-4">
                            <x-form.input.base
                                name="demo_date_mask"
                                label="Date"
                                mask="00/00/0000"
                                placeholder="MM/DD/YYYY"
                                icon="ki-outline ki-calendar"
                            />
                        </div>
                        <div class="col-md-4">
                            <x-form.input.base
                                name="demo_ssn_mask"
                                label="SSN"
                                mask="000-00-0000"
                                placeholder="123-45-6789"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <div class="showcase-example">
                <div class="showcase-example-label">
                    Business Formats
                </div>
                <div class="showcase-example-preview">
                    <div class="row">
                        <div class="col-md-4">
                            <x-form.input.base
                                name="demo_credit_mask"
                                label="Credit Card"
                                mask="0000 0000 0000 0000"
                                placeholder="1234 5678 9012 3456"
                                icon="ki-outline ki-credit-cart"
                            />
                        </div>
                        <div class="col-md-4">
                            <x-form.input.base
                                name="demo_zip_mask"
                                label="ZIP Code"
                                mask="00000-0000"
                                placeholder="12345-6789"
                            />
                        </div>
                        <div class="col-md-4">
                            <x-form.input.base
                                name="demo_tax_mask"
                                label="Tax ID (EIN)"
                                mask="00-0000000"
                                placeholder="12-3456789"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="code-input-masks" class="showcase-code-wrapper">
            <div class="showcase-code-header">
                <span class="showcase-code-label">Blade Usage</span>
                <button class="showcase-code-copy">Copy</button>
            </div>
            <pre class="showcase-code">&lt;!-- Phone Mask (US Format) --&gt;
&lt;x-form.input.base
    name="phone"
    label="Phone"
    mask="(000) 000-0000"
    placeholder="(555) 123-4567"
    icon="ki-outline ki-phone"
/&gt;

&lt;!-- Date Mask --&gt;
&lt;x-form.input.base
    name="date"
    label="Date"
    mask="00/00/0000"
    placeholder="MM/DD/YYYY"
/&gt;

&lt;!-- Credit Card Mask --&gt;
&lt;x-form.input.base
    name="card"
    label="Credit Card"
    mask="0000 0000 0000 0000"
    placeholder="1234 5678 9012 3456"
/&gt;

&lt;!-- ZIP Code with Extension --&gt;
&lt;x-form.input.base
    name="zip"
    label="ZIP Code"
    mask="00000-0000"
/&gt;

&lt;!-- Tax ID / EIN --&gt;
&lt;x-form.input.base
    name="ein"
    label="Tax ID (EIN)"
    mask="00-0000000"
/&gt;</pre>
        </div>
    </section>

    {{-- ================================================================== --}}
    {{-- DATATABLES                                                        --}}
    {{-- ================================================================== --}}

    <!-- Static DataTable -->
    <section id="datatable-static" class="showcase-section">
        <div class="showcase-section-header">
            <h3 class="showcase-section-title">
                <i class="ki-outline ki-row-horizontal me-2 text-success"></i>
                DataTable (Static Data)
                <code>x-table.datatable.base</code>
            </h3>
            <button class="btn btn-sm btn-light showcase-toggle-code" data-toggle-code="#code-datatable-static">
                Show Code
            </button>
        </div>
        <div class="showcase-section-body">
            <p class="text-muted mb-5">
                Basic table with static data. Works without JavaScript for progressive enhancement.
            </p>

            @php
                // Sample data for demonstration
                $sampleUsers = [
                    ['id' => 1, 'name' => 'John Doe', 'email' => 'john@example.com', 'role' => 'Admin', 'status' => 'active', 'created_at' => '2026-01-10'],
                    ['id' => 2, 'name' => 'Jane Smith', 'email' => 'jane@example.com', 'role' => 'Editor', 'status' => 'active', 'created_at' => '2026-01-09'],
                    ['id' => 3, 'name' => 'Bob Wilson', 'email' => 'bob@example.com', 'role' => 'Viewer', 'status' => 'inactive', 'created_at' => '2026-01-08'],
                    ['id' => 4, 'name' => 'Alice Brown', 'email' => 'alice@example.com', 'role' => 'Editor', 'status' => 'active', 'created_at' => '2026-01-07'],
                    ['id' => 5, 'name' => 'Charlie Davis', 'email' => 'charlie@example.com', 'role' => 'Viewer', 'status' => 'pending', 'created_at' => '2026-01-06'],
                ];
            @endphp

            <div class="showcase-example">
                <div class="showcase-example-label">
                    Basic Static Table
                    <span class="badge badge-light-success">No JS Required</span>
                </div>
                <div class="showcase-example-preview">
                    <x-table.datatable.base
                        :columns="[
                            ['key' => 'id', 'label' => 'ID', 'width' => '60px'],
                            ['key' => 'name', 'label' => 'Name'],
                            ['key' => 'email', 'label' => 'Email'],
                            ['key' => 'role', 'label' => 'Role'],
                        ]"
                        :data="$sampleUsers"
                    />
                </div>
            </div>

            <div class="showcase-example">
                <div class="showcase-example-label">
                    With Row Index & Selection
                </div>
                <div class="showcase-example-preview">
                    <x-table.datatable.base
                        id="demo-selectable-table"
                        :columns="[
                            ['key' => 'name', 'label' => 'Name'],
                            ['key' => 'email', 'label' => 'Email'],
                            ['key' => 'role', 'label' => 'Role'],
                        ]"
                        :data="$sampleUsers"
                        :show-index="true"
                        :selectable="true"
                        row-key="id"
                    />
                </div>
            </div>
        </div>

        <div id="code-datatable-static" class="showcase-code-wrapper">
            <div class="showcase-code-header">
                <span class="showcase-code-label">Blade Usage</span>
                <button class="showcase-code-copy">Copy</button>
            </div>
            <pre class="showcase-code">&lt;!-- Basic Static Table --&gt;
&lt;x-table.datatable.base
    :columns="[
        ['key' => 'id', 'label' => 'ID', 'width' => '60px'],
        ['key' => 'name', 'label' => 'Name'],
        ['key' => 'email', 'label' => 'Email'],
        ['key' => 'role', 'label' => 'Role'],
    ]"
    :data="$users"
/&gt;

&lt;!-- With Row Index and Selection Checkboxes --&gt;
&lt;x-table.datatable.base
    id="users-table"
    :columns="[
        ['key' => 'name', 'label' => 'Name'],
        ['key' => 'email', 'label' => 'Email'],
        ['key' => 'role', 'label' => 'Role'],
    ]"
    :data="$users"
    :show-index="true"
    :selectable="true"
    row-key="id"
/&gt;

&lt;!-- Get selected rows via JavaScript --&gt;
&lt;script&gt;
    var selected = GeoTable.getSelected('users-table');
    console.log(selected); // ['1', '3', '5']
&lt;/script&gt;</pre>
        </div>
    </section>

    <!-- DataTable with AJAX placeholder -->
    <section id="datatable-ajax" class="showcase-section">
        <div class="showcase-section-header">
            <h3 class="showcase-section-title">
                <i class="ki-outline ki-cloud-download me-2 text-info"></i>
                DataTable (AJAX / Server-Side)
                <code>ajax-url, server-side</code>
            </h3>
            <button class="btn btn-sm btn-light showcase-toggle-code" data-toggle-code="#code-datatable-ajax">
                Show Code
            </button>
        </div>
        <div class="showcase-section-body">
            <p class="text-muted mb-5">
                Server-side processing for large datasets. Data is loaded via AJAX.
            </p>

            <div class="alert alert-info d-flex align-items-center">
                <i class="ki-outline ki-information-5 fs-2 me-3"></i>
                <div>
                    <strong>Note:</strong> AJAX tables require a backend API endpoint.
                    Configure using <code>ajax-url</code> and <code>:server-side="true"</code> props.
                </div>
            </div>

            <div class="showcase-example">
                <div class="showcase-example-label">
                    Configuration Example
                    <span class="badge badge-light-info">Requires API</span>
                </div>
                <div class="showcase-example-preview bg-light-dark p-5 rounded">
                    <pre class="mb-0 text-white"><code>&lt;x-table.datatable.base
    id="users-server-table"
    :columns="[
        ['key' => 'id', 'label' => 'ID', 'sortable' => true],
        ['key' => 'name', 'label' => 'Name', 'sortable' => true, 'searchable' => true],
        ['key' => 'email', 'label' => 'Email', 'searchable' => true],
        ['key' => 'created_at', 'label' => 'Created', 'sortable' => true, 'render' => 'date'],
    ]"
    ajax-url="/api/users"
    :server-side="true"
    :datatable="true"
    :pagination="true"
    :searchable="true"
    :page-length="25"
/&gt;</code></pre>
                </div>
            </div>
        </div>

        <div id="code-datatable-ajax" class="showcase-code-wrapper">
            <div class="showcase-code-header">
                <span class="showcase-code-label">Blade Usage</span>
                <button class="showcase-code-copy">Copy</button>
            </div>
            <pre class="showcase-code">&lt;!-- Server-Side DataTable with Full Features --&gt;
&lt;x-table.datatable.base
    id="users-server-table"
    :columns="[
        ['key' => 'id', 'label' => 'ID', 'sortable' => true],
        ['key' => 'name', 'label' => 'Name', 'sortable' => true, 'searchable' => true],
        ['key' => 'email', 'label' => 'Email', 'searchable' => true],
        ['key' => 'created_at', 'label' => 'Created', 'sortable' => true, 'render' => 'date'],
    ]"
    ajax-url="/api/users"
    :server-side="true"
    :datatable="true"
    :pagination="true"
    :searchable="true"
    :sortable="true"
    :page-length="25"
    :responsive="true"
/&gt;

&lt;!-- Deferred Loading (load data on demand) --&gt;
&lt;x-table.datatable.base
    id="lazy-table"
    :columns="$columns"
    ajax-url="/api/large-dataset"
    :datatable="true"
    :defer-loading="true"
/&gt;

&lt;!-- Trigger load manually via JavaScript --&gt;
&lt;script&gt;
    // Load when user clicks a button or tab
    document.getElementById('loadBtn').addEventListener('click', function() {
        GeoTable.reload('lazy-table');
    });
&lt;/script&gt;

&lt;!-- With Export Buttons --&gt;
&lt;x-table.datatable.base
    id="export-table"
    :columns="$columns"
    :data="$data"
    :datatable="true"
    :exportable="true"
    :export-buttons="['csv', 'excel', 'pdf']"
    export-filename="users-export"
/&gt;</pre>
        </div>
    </section>

    <!-- DataTable Features -->
    <section id="datatable-features" class="showcase-section">
        <div class="showcase-section-header">
            <h3 class="showcase-section-title">
                <i class="ki-outline ki-setting-2 me-2 text-warning"></i>
                DataTable Features
                <code>toolbar, actions, cell slots</code>
            </h3>
            <button class="btn btn-sm btn-light showcase-toggle-code" data-toggle-code="#code-datatable-features">
                Show Code
            </button>
        </div>
        <div class="showcase-section-body">
            <p class="text-muted mb-5">
                Advanced features: custom cell rendering, action buttons, toolbar, and built-in renderers.
            </p>

            @php
                $sampleProducts = [
                    ['id' => 1, 'name' => 'MacBook Pro', 'price' => 2499.00, 'stock' => 15, 'active' => true, 'created_at' => '2026-01-10 14:30:00'],
                    ['id' => 2, 'name' => 'iPhone 15', 'price' => 999.00, 'stock' => 50, 'active' => true, 'created_at' => '2026-01-09 09:15:00'],
                    ['id' => 3, 'name' => 'AirPods Pro', 'price' => 249.00, 'stock' => 0, 'active' => false, 'created_at' => '2026-01-08 16:45:00'],
                    ['id' => 4, 'name' => 'iPad Air', 'price' => 799.00, 'stock' => 25, 'active' => true, 'created_at' => '2026-01-07 11:20:00'],
                ];
            @endphp

            <div class="showcase-example">
                <div class="showcase-example-label">
                    Built-in Cell Renderers
                    <span class="badge badge-light-warning">date, currency, boolean</span>
                </div>
                <div class="showcase-example-preview">
                    <x-table.datatable.base
                        :columns="[
                            ['key' => 'name', 'label' => 'Product'],
                            ['key' => 'price', 'label' => 'Price', 'render' => 'currency', 'class' => 'text-end'],
                            ['key' => 'stock', 'label' => 'Stock', 'class' => 'text-center'],
                            ['key' => 'active', 'label' => 'Active', 'render' => 'boolean', 'class' => 'text-center'],
                            ['key' => 'created_at', 'label' => 'Added', 'render' => 'datetime'],
                        ]"
                        :data="$sampleProducts"
                    />
                </div>
            </div>

            <div class="showcase-example">
                <div class="showcase-example-label">
                    With Toolbar & Actions
                </div>
                <div class="showcase-example-preview">
                    <x-table.datatable.base
                        id="demo-actions-table"
                        :columns="[
                            ['key' => 'name', 'label' => 'Product'],
                            ['key' => 'price', 'label' => 'Price', 'render' => 'currency'],
                            ['key' => 'stock', 'label' => 'Stock'],
                        ]"
                        :data="$sampleProducts"
                        :show-actions="true"
                        row-key="id"
                    >
                        <x-slot:toolbar>
                            <div class="d-flex gap-3 align-items-center">
                                <div class="d-flex align-items-center">
                                    <span class="text-muted me-2">Filter:</span>
                                    <select class="form-select form-select-sm form-select-solid w-150px">
                                        <option value="">All Status</option>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>
                                <button class="btn btn-sm btn-primary">
                                    <i class="ki-outline ki-plus"></i>
                                    Add Product
                                </button>
                            </div>
                        </x-slot:toolbar>

                        <x-slot:actions>
                            <div class="d-flex justify-content-end gap-2">
                                <button class="btn btn-sm btn-icon btn-light-primary" title="Edit">
                                    <i class="ki-outline ki-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-icon btn-light-danger" title="Delete">
                                    <i class="ki-outline ki-trash"></i>
                                </button>
                            </div>
                        </x-slot:actions>
                    </x-table.datatable.base>
                </div>
            </div>

            <div class="showcase-example">
                <div class="showcase-example-label">
                    DataTables Enabled (Search, Sort, Paginate)
                </div>
                <div class="showcase-example-preview">
                    <x-table.datatable.base
                        id="demo-datatable-full"
                        :columns="[
                            ['key' => 'id', 'label' => 'ID', 'sortable' => true, 'width' => '60px'],
                            ['key' => 'name', 'label' => 'Name', 'sortable' => true, 'searchable' => true],
                            ['key' => 'email', 'label' => 'Email', 'searchable' => true],
                            ['key' => 'role', 'label' => 'Role', 'sortable' => true],
                            ['key' => 'created_at', 'label' => 'Joined', 'sortable' => true, 'render' => 'date'],
                        ]"
                        :data="$sampleUsers"
                        :datatable="true"
                        :searchable="true"
                        :sortable="true"
                        :pagination="true"
                        :page-length="3"
                    />
                </div>
            </div>
        </div>

        <div id="code-datatable-features" class="showcase-code-wrapper">
            <div class="showcase-code-header">
                <span class="showcase-code-label">Blade Usage</span>
                <button class="showcase-code-copy">Copy</button>
            </div>
            <pre class="showcase-code">&lt;!-- Built-in Cell Renderers --&gt;
&lt;x-table.datatable.base
    :columns="[
        ['key' => 'name', 'label' => 'Product'],
        ['key' => 'price', 'label' => 'Price', 'render' => 'currency'],
        ['key' => 'active', 'label' => 'Active', 'render' => 'boolean'],
        ['key' => 'created_at', 'label' => 'Created', 'render' => 'date'],
        ['key' => 'updated_at', 'label' => 'Updated', 'render' => 'datetime'],
    ]"
    :data="$products"
/&gt;

&lt;!-- With Toolbar Slot --&gt;
&lt;x-table.datatable.base :columns="$columns" :data="$data"&gt;
    &lt;x-slot:toolbar&gt;
        &lt;div class="d-flex gap-3"&gt;
            &lt;select class="form-select form-select-sm"&gt;
                &lt;option&gt;Filter by Status&lt;/option&gt;
            &lt;/select&gt;
            &lt;button class="btn btn-sm btn-primary"&gt;
                &lt;i class="ki-outline ki-plus"&gt;&lt;/i&gt; Add New
            &lt;/button&gt;
        &lt;/div&gt;
    &lt;/x-slot:toolbar&gt;
&lt;/x-table.datatable.base&gt;

&lt;!-- With Actions Column --&gt;
&lt;x-table.datatable.base
    :columns="$columns"
    :data="$data"
    :show-actions="true"
    row-key="id"
&gt;
    &lt;x-slot:actions&gt;
        &lt;button class="btn btn-sm btn-light-primary"&gt;Edit&lt;/button&gt;
        &lt;button class="btn btn-sm btn-light-danger"&gt;Delete&lt;/button&gt;
    &lt;/x-slot:actions&gt;
&lt;/x-table.datatable.base&gt;

&lt;!-- Full DataTables with Search, Sort, Pagination --&gt;
&lt;x-table.datatable.base
    id="products-table"
    :columns="[
        ['key' => 'id', 'label' => 'ID', 'sortable' => true],
        ['key' => 'name', 'label' => 'Name', 'sortable' => true, 'searchable' => true],
        ['key' => 'price', 'label' => 'Price', 'render' => 'currency', 'sortable' => true],
    ]"
    :data="$products"
    :datatable="true"
    :searchable="true"
    :sortable="true"
    :pagination="true"
    :page-length="10"
/&gt;</pre>
        </div>
    </section>

    {{-- ================================================================== --}}
    {{-- EMPTY STATES & MISC                                               --}}
    {{-- ================================================================== --}}

    <section id="empty-states" class="showcase-section">
        <div class="showcase-section-header">
            <h3 class="showcase-section-title">
                <i class="ki-outline ki-file-deleted me-2 text-muted"></i>
                Empty & Loading States
            </h3>
        </div>
        <div class="showcase-section-body">
            <div class="showcase-example">
                <div class="showcase-example-label">
                    Empty Table State
                </div>
                <div class="showcase-example-preview">
                    <x-table.datatable.base
                        :columns="[
                            ['key' => 'name', 'label' => 'Name'],
                            ['key' => 'email', 'label' => 'Email'],
                        ]"
                        :data="[]"
                        empty-message="No records found. Try adjusting your filters."
                        empty-icon="ki-outline ki-search-list"
                    />
                </div>
            </div>

            <div class="showcase-example">
                <div class="showcase-example-label">
                    Custom Empty State (Slot)
                </div>
                <div class="showcase-example-preview">
                    <x-table.datatable.base
                        :columns="[
                            ['key' => 'name', 'label' => 'Name'],
                            ['key' => 'email', 'label' => 'Email'],
                        ]"
                        :data="[]"
                    >
                        <x-slot:empty>
                            <div class="text-center py-10">
                                <img src="{{ asset('assets/media/illustrations/sigma-1/5.png') }}" alt="No data" class="mw-200px mb-5" style="opacity: 0.7;">
                                <h4 class="text-gray-700">No Products Yet</h4>
                                <p class="text-muted">Start by adding your first product to the catalog.</p>
                                <button class="btn btn-primary mt-3">
                                    <i class="ki-outline ki-plus"></i>
                                    Add Product
                                </button>
                            </div>
                        </x-slot:empty>
                    </x-table.datatable.base>
                </div>
            </div>
        </div>
    </section>

@endsection
