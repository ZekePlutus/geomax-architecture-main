{{--
    ================================================================================
    GLOBAL UI COMPONENT SHOWCASE - Tables (DataTable & AG Grid)
    ================================================================================

    This is a DEVELOPER-ONLY page for testing and previewing Table components.

    PURPOSE:
    - Visual validation of table components
    - Documentation of usage patterns
    - Testing different prop combinations
    - Design consistency verification

    ACCESS:
    - URL: /components
    - Environment: local, staging, development only
    - No authentication required
    ================================================================================
--}}

@extends('core-ui.layouts.showcase')

@section('header-title', 'Table Component Library')
@section('header-description', 'Browse, test, and validate DataTable and AG Grid components')

@section('sidebar-nav')
    <!-- Feature Tracking -->
    <div class="showcase-nav-category">Development</div>
    <a href="#feature-tracker" class="showcase-nav-item">
        <i class="ki-outline ki-chart-simple-2"></i>
        Feature Tracker
    </a>

    <!-- DataTable Category -->
    <div class="showcase-nav-category">DataTable (jQuery)</div>
    <a href="#datatable-static" class="showcase-nav-item active">
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
    <a href="#empty-states" class="showcase-nav-item">
        <i class="ki-outline ki-file-deleted"></i>
        Empty States
    </a>

    <!-- AG Grid Category -->
    <div class="showcase-nav-category">AG Grid (Enterprise)</div>
    <a href="#aggrid-basic" class="showcase-nav-item">
        <i class="ki-outline ki-grid"></i>
        AG Grid (Basic)
    </a>
    <a href="#aggrid-filtering" class="showcase-nav-item">
        <i class="ki-outline ki-filter"></i>
        AG Grid (Filtering)
    </a>
    <a href="#aggrid-selection" class="showcase-nav-item">
        <i class="ki-outline ki-check-square"></i>
        AG Grid (Selection)
    </a>
    <a href="#aggrid-features" class="showcase-nav-item">
        <i class="ki-outline ki-setting-3"></i>
        AG Grid Features
    </a>
@endsection

@section('content')
    {{-- ================================================================== --}}
    {{-- FEATURE TRACKER                                                    --}}
    {{-- ================================================================== --}}

    <section id="feature-tracker" class="showcase-section">
        <div class="showcase-section-header">
            <h3 class="showcase-section-title">
                <i class="ki-outline ki-chart-simple-2 me-2 text-primary"></i>
                DataTable Component - Feature Tracker
            </h3>
        </div>
        <div class="showcase-section-body">
            <p class="text-muted mb-5">
                Track implemented and pending features for the <code>x-table.datatable.base</code> component.
                <br><small class="text-warning">Last Updated: January 15, 2026</small>
            </p>

            <div class="row g-5">
                {{-- Implemented Features --}}
                <div class="col-lg-6">
                    <div class="card card-bordered border-success">
                        <div class="card-header bg-light-success">
                            <h4 class="card-title">
                                <i class="ki-outline ki-check-circle text-success me-2"></i>
                                Implemented Features
                            </h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm table-row-bordered">
                                <thead>
                                    <tr class="fw-bold text-muted">
                                        <th>Feature</th>
                                        <th>Props</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Static Data Rendering</td>
                                        <td><code>:data="$array"</code></td>
                                    </tr>
                                    <tr>
                                        <td>Column Configuration</td>
                                        <td><code>:columns="[...]"</code></td>
                                    </tr>
                                    <tr>
                                        <td>DataTables.js Integration</td>
                                        <td><code>:datatable="true"</code></td>
                                    </tr>
                                    <tr>
                                        <td>Search Functionality</td>
                                        <td><code>:searchable="true"</code></td>
                                    </tr>
                                    <tr>
                                        <td>Column Sorting</td>
                                        <td><code>:sortable="true"</code></td>
                                    </tr>
                                    <tr>
                                        <td>Pagination</td>
                                        <td><code>:pagination="true"</code></td>
                                    </tr>
                                    <tr>
                                        <td>Built-in Renderers (16+)</td>
                                        <td><code>date, datetime, time, relative, currency, number, percent, badge, status, boolean, yesno, image, avatar, link, email, phone, truncate, html</code></td>
                                    </tr>
                                    <tr>
                                        <td>Row Selection (Checkboxes)</td>
                                        <td><code>:selectable="true"</code></td>
                                    </tr>
                                    <tr>
                                        <td>Row Index Column</td>
                                        <td><code>:show-index="true"</code></td>
                                    </tr>
                                    <tr>
                                        <td>Server-Side Processing</td>
                                        <td><code>ajax-url, :server-side="true"</code></td>
                                    </tr>
                                    <tr>
                                        <td>Export Buttons</td>
                                        <td><code>:exportable="true"</code></td>
                                    </tr>
                                    <tr>
                                        <td>State Save</td>
                                        <td><code>:state-save="true"</code></td>
                                    </tr>
                                    <tr>
                                        <td>Responsive Mode</td>
                                        <td><code>:responsive="true"</code></td>
                                    </tr>
                                    <tr>
                                        <td>Row Click Handler</td>
                                        <td><code>:row-clickable="true", row-url</code></td>
                                    </tr>
                                    <tr>
                                        <td>Toolbar Slot</td>
                                        <td><code>&lt;x-slot:toolbar&gt;</code></td>
                                    </tr>
                                    <tr>
                                        <td>Empty Slot</td>
                                        <td><code>&lt;x-slot:empty&gt;</code></td>
                                    </tr>
                                    <tr>
                                        <td>Deferred Loading</td>
                                        <td><code>:defer-loading="true"</code></td>
                                    </tr>
                                    <tr>
                                        <td>GeoTable JS API</td>
                                        <td><code>GeoTable.reload(), .getSelected(), .destroy()</code></td>
                                    </tr>
                                    <tr>
                                        <td>Custom Cell Rendering</td>
                                        <td><code>'view' => 'path.to.blade'</code> in column config</td>
                                    </tr>
                                    <tr>
                                        <td>Custom Actions View</td>
                                        <td><code>actions-view="path.to.blade"</code> prop</td>
                                    </tr>
                                    <tr class="table-success">
                                        <td><span class="badge badge-success me-2">NEW</span>Bulk Actions</td>
                                        <td><code>:bulk-actions="[...]", on-bulk-action="callback"</code></td>
                                    </tr>
                                    <tr class="table-success">
                                        <td><span class="badge badge-success me-2">NEW</span>Column Visibility Toggle</td>
                                        <td><code>:show-column-toggle="true"</code></td>
                                    </tr>
                                    <tr class="table-success">
                                        <td><span class="badge badge-success me-2">NEW</span>Column Reordering (Drag & Drop)</td>
                                        <td><code>:column-reorderable="true"</code></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Missing / Pending Features --}}
                <div class="col-lg-6">
                    <div class="card card-bordered border-danger">
                        <div class="card-header bg-light-danger">
                            <h4 class="card-title">
                                <i class="ki-outline ki-cross-circle text-danger me-2"></i>
                                Missing / Pending Features
                            </h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm table-row-bordered">
                                <thead>
                                    <tr class="fw-bold text-muted">
                                        <th>Feature</th>
                                        <th>Notes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Inline Editing</td>
                                        <td>
                                            Edit cells directly in the table
                                            <br><small class="text-muted">Future enhancement</small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Row Grouping</td>
                                        <td>
                                            Group rows by a column value
                                            <br><small class="text-muted">Future enhancement</small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Row Reordering (Drag & Drop)</td>
                                        <td>
                                            Reorder rows via drag handles
                                            <br><small class="text-muted">Future enhancement</small>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="alert alert-success d-flex mt-5 p-4">
                                <i class="ki-outline ki-check-circle fs-2 me-3 text-success"></i>
                                <div>
                                    <strong>Core Features Complete!</strong>
                                    <br>All essential DataTable features are implemented. Remaining items are advanced enhancements.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Implementation Notes --}}
            <div class="card card-bordered mt-5">
                <div class="card-header bg-light-success">
                    <h4 class="card-title">
                        <i class="ki-outline ki-check-circle text-success me-2"></i>
                        Implementation Reference (Custom Cell & Actions Rendering)
                    </h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-success mb-5">
                        <i class="ki-outline ki-check-circle me-2"></i>
                        <strong>Implemented!</strong> Custom cell rendering and actions with row context are now working via Blade view partials.
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-gray-800">Custom Cell View Usage:</h6>
                            <p class="text-muted fs-7">
                                Add a <code>'view'</code> key to any column definition pointing to a Blade partial.
                                The view receives <code>$row</code>, <code>$value</code>, <code>$column</code>, and <code>$index</code>.
                            </p>
                            <pre class="bg-light-dark text-white p-3 rounded fs-8"><code>// Column definition
['key' => 'status', 'label' => 'Status', 'view' => 'components.table.cells.status-badge']

// In resources/views/components/table/cells/status-badge.blade.php
@verbatim&lt;span class="badge badge-{{ $value === 'active' ? 'success' : 'danger' }}"&gt;
    {{ ucfirst($value) }}
&lt;/span&gt;@endverbatim</code></pre>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-gray-800">Custom Actions View:</h6>
                            <p class="text-muted fs-7">
                                Use the <code>actions-view</code> prop to specify a Blade partial for per-row actions.
                                The view receives <code>$row</code> and <code>$index</code>.
                            </p>
                            <pre class="bg-light-dark text-white p-3 rounded fs-8"><code>// Component usage
&lt;x-table.datatable.base
    :columns="$columns"
    :data="$data"
    :show-actions="true"
    actions-view="components.table.cells.user-actions"
/&gt;

// In user-actions.blade.php
@verbatim&lt;a href="/users/{{ $row['id'] }}/edit"&gt;Edit&lt;/a&gt;
&lt;button onclick="deleteUser({{ $row['id'] }})"&gt;Delete&lt;/button&gt;@endverbatim</code></pre>
                        </div>
                    </div>
                </div>
            </div>
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

            {{-- Custom Cell Views Example --}}
            <div class="showcase-example">
                <div class="showcase-example-label">
                    Custom Cell Rendering
                    <span class="badge badge-light-success">NEW - view partials with row context</span>
                </div>
                <div class="showcase-example-preview">
                    <x-table.datatable.base
                        id="demo-custom-cells"
                        :columns="[
                            ['key' => 'name', 'label' => 'Product'],
                            ['key' => 'price', 'label' => 'Price', 'view' => 'components.table.cells.price'],
                            ['key' => 'stock', 'label' => 'Stock Status', 'view' => 'components.table.cells.stock-status'],
                            ['key' => 'active', 'label' => 'Status', 'view' => 'components.table.cells.active-toggle'],
                        ]"
                        :data="$sampleProducts"
                        :show-actions="true"
                        actions-view="components.table.cells.product-actions"
                        row-key="id"
                    />
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

            {{-- Bulk Actions Example --}}
            <div class="showcase-example">
                <div class="showcase-example-label">
                    <span class="badge badge-success me-2">NEW</span> Bulk Actions
                    <span class="badge badge-light-primary ms-2">Select rows to see toolbar</span>
                </div>
                <div class="showcase-example-preview">
                    <x-table.datatable.base
                        id="demo-bulk-actions"
                        :columns="[
                            ['key' => 'name', 'label' => 'Product'],
                            ['key' => 'price', 'label' => 'Price', 'render' => 'currency'],
                            ['key' => 'stock', 'label' => 'Stock'],
                            ['key' => 'active', 'label' => 'Status', 'render' => 'yesno'],
                        ]"
                        :data="$sampleProducts"
                        :selectable="true"
                        :bulk-actions="[
                            ['key' => 'delete', 'label' => 'Delete', 'icon' => 'ki-outline ki-trash', 'class' => 'btn-light-danger', 'confirm' => 'Delete selected items?'],
                            ['key' => 'export', 'label' => 'Export', 'icon' => 'ki-outline ki-file-down', 'class' => 'btn-light-primary'],
                            ['key' => 'archive', 'label' => 'Archive', 'icon' => 'ki-outline ki-archive', 'class' => 'btn-light-warning'],
                        ]"
                        on-bulk-action="handleBulkAction"
                        row-key="id"
                    />
                </div>
            </div>

            {{-- Column Visibility Example --}}
            <div class="showcase-example">
                <div class="showcase-example-label">
                    <span class="badge badge-success me-2">NEW</span> Column Visibility Toggle
                    <span class="badge badge-light-info ms-2">Click "Columns" button</span>
                </div>
                <div class="showcase-example-preview">
                    <x-table.datatable.base
                        id="demo-column-toggle"
                        :columns="[
                            ['key' => 'id', 'label' => 'ID', 'width' => '60px'],
                            ['key' => 'name', 'label' => 'Name'],
                            ['key' => 'email', 'label' => 'Email'],
                            ['key' => 'role', 'label' => 'Role'],
                            ['key' => 'status', 'label' => 'Status'],
                            ['key' => 'created_at', 'label' => 'Created', 'render' => 'date'],
                        ]"
                        :data="$sampleUsers"
                        :datatable="true"
                        :show-column-toggle="true"
                        :hidden-columns="['created_at']"
                    />
                </div>
            </div>

            {{-- Column Reordering Example --}}
            <div class="showcase-example">
                <div class="showcase-example-label">
                    <span class="badge badge-success me-2">NEW</span> Column Reordering (Drag & Drop)
                    <span class="badge badge-light-info ms-2">Drag column headers to reorder</span>
                </div>
                <div class="showcase-example-preview">
                    <x-table.datatable.base
                        id="demo-column-reorder"
                        :columns="[
                            ['key' => 'id', 'label' => 'ID', 'width' => '60px'],
                            ['key' => 'name', 'label' => 'Name'],
                            ['key' => 'email', 'label' => 'Email'],
                            ['key' => 'role', 'label' => 'Role'],
                            ['key' => 'status', 'label' => 'Status'],
                        ]"
                        :data="$sampleUsers"
                        :datatable="true"
                        :column-reorderable="true"
                        :state-save="true"
                    />
                    <div class="mt-3 d-flex gap-2">
                        <button class="btn btn-sm btn-light-primary" onclick="alert('Column Order: ' + GeoTable.getColumnOrder('demo-column-reorder').join(', '))">
                            <i class="ki-outline ki-information-5 me-1"></i> Get Column Order
                        </button>
                        <button class="btn btn-sm btn-light-warning" onclick="GeoTable.resetColumnOrder('demo-column-reorder')">
                            <i class="ki-outline ki-arrows-loop me-1"></i> Reset Order
                        </button>
                    </div>
                </div>
            </div>

            {{-- New Renderers Example --}}
            <div class="showcase-example">
                <div class="showcase-example-label">
                    <span class="badge badge-success me-2">NEW</span> Extended Built-in Renderers
                </div>
                <div class="showcase-example-preview">
                    @php
                        $renderersDemo = [
                            ['id' => 1, 'name' => 'John Doe', 'avatar' => null, 'email' => 'john@example.com', 'phone' => '+1 (555) 123-4567', 'salary' => 75000, 'rating' => 92.5, 'status' => 'active', 'bio' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore.', 'created_at' => now()->subDays(2)],
                            ['id' => 2, 'name' => 'Jane Smith', 'avatar' => 'https://i.pravatar.cc/100?u=jane', 'email' => 'jane@example.com', 'phone' => '+1 (555) 987-6543', 'salary' => 85000, 'rating' => 88.3, 'status' => 'pending', 'bio' => 'Short bio', 'created_at' => now()->subHours(5)],
                            ['id' => 3, 'name' => 'Bob Wilson', 'avatar' => 'https://i.pravatar.cc/100?u=bob', 'email' => 'bob@example.com', 'phone' => '+1 (555) 456-7890', 'salary' => 65000, 'rating' => 75.0, 'status' => 'inactive', 'bio' => 'Another longer biography that needs truncation for proper display in the table cell.', 'created_at' => now()->subMinutes(30)],
                        ];
                    @endphp
                    <x-table.datatable.base
                        :columns="[
                            ['key' => 'avatar', 'label' => 'Avatar', 'render' => 'avatar', 'nameField' => 'name', 'size' => '40px'],
                            ['key' => 'name', 'label' => 'Name'],
                            ['key' => 'email', 'label' => 'Email', 'render' => 'email'],
                            ['key' => 'phone', 'label' => 'Phone', 'render' => 'phone'],
                            ['key' => 'salary', 'label' => 'Salary', 'render' => 'currency', 'symbol' => '$', 'decimals' => 0],
                            ['key' => 'rating', 'label' => 'Score', 'render' => 'percent', 'decimals' => 1],
                            ['key' => 'status', 'label' => 'Status', 'render' => 'status', 'statuses' => [
                                'active' => ['label' => 'Active', 'color' => 'success'],
                                'pending' => ['label' => 'Pending', 'color' => 'warning'],
                                'inactive' => ['label' => 'Inactive', 'color' => 'danger'],
                            ]],
                            ['key' => 'bio', 'label' => 'Bio', 'render' => 'truncate', 'maxLength' => 30],
                            ['key' => 'created_at', 'label' => 'Added', 'render' => 'relative'],
                        ]"
                        :data="$renderersDemo"
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

&lt;!-- With Actions Column (static, no row context) --&gt;
&lt;x-table.datatable.base
    :columns="$columns"
    :data="$data"
    :show-actions="true"
&gt;
    &lt;x-slot:actions&gt;
        &lt;button class="btn btn-sm btn-light-primary"&gt;Edit&lt;/button&gt;
        &lt;button class="btn btn-sm btn-light-danger"&gt;Delete&lt;/button&gt;
    &lt;/x-slot:actions&gt;
&lt;/x-table.datatable.base&gt;

&lt;!-- Custom Cell Rendering via View Partials --&gt;
&lt;x-table.datatable.base
    :columns="[
        ['key' => 'name', 'label' => 'Name'],
        ['key' => 'status', 'label' => 'Status', 'view' => 'components.table.cells.status-badge'],
        ['key' => 'avatar', 'label' => 'Avatar', 'view' => 'components.table.cells.avatar'],
    ]"
    :data="$users"
/&gt;

&lt;!-- Custom Actions with Row Context --&gt;
&lt;x-table.datatable.base
    :columns="$columns"
    :data="$data"
    :show-actions="true"
    actions-view="components.table.cells.user-actions"
    row-key="id"
/&gt;

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

    {{-- ================================================================== --}}
    {{-- AG GRID - FEATURE TRACKER                                          --}}
    {{-- ================================================================== --}}

    <section id="aggrid-feature-tracker" class="showcase-section">
        <div class="showcase-section-header">
            <h3 class="showcase-section-title">
                <i class="ki-outline ki-grid me-2 text-info"></i>
                AG Grid Component - Feature Tracker
            </h3>
        </div>
        <div class="showcase-section-body">
            <p class="text-muted mb-5">
                Track implemented and pending features for the <code>x-table.aggrid.base</code> component.
                <br><small class="text-warning">Last Updated: January 15, 2026</small>
            </p>

            <div class="row g-5">
                {{-- Implemented Features --}}
                <div class="col-lg-6">
                    <div class="card card-bordered border-success">
                        <div class="card-header bg-light-success">
                            <h4 class="card-title">
                                <i class="ki-outline ki-check-circle text-success me-2"></i>
                                Implemented Features (P0)
                            </h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm table-row-bordered">
                                <thead>
                                    <tr class="fw-bold text-muted">
                                        <th>Feature</th>
                                        <th>Props</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Static Data Rendering</td>
                                        <td><code>:data="$array"</code></td>
                                    </tr>
                                    <tr>
                                        <td>Column Configuration</td>
                                        <td><code>:columns="[...]"</code></td>
                                    </tr>
                                    <tr>
                                        <td>Sorting (Single/Multi)</td>
                                        <td><code>:sortable="true"</code>, <code>:multi-sort="true"</code></td>
                                    </tr>
                                    <tr>
                                        <td>Column Filtering</td>
                                        <td><code>:filterable="true"</code>, <code>'filter' => 'text|number|date'</code></td>
                                    </tr>
                                    <tr>
                                        <td>Floating Filters</td>
                                        <td><code>:floating-filter="true"</code></td>
                                    </tr>
                                    <tr>
                                        <td>Quick Filter (Search)</td>
                                        <td><code>:quick-filter="true"</code></td>
                                    </tr>
                                    <tr>
                                        <td>Pagination</td>
                                        <td><code>:pagination="true"</code>, <code>:page-size="25"</code></td>
                                    </tr>
                                    <tr>
                                        <td>Row Selection</td>
                                        <td><code>:selectable="true"</code>, <code>selection-mode="multiple"</code></td>
                                    </tr>
                                    <tr>
                                        <td>Checkbox Selection</td>
                                        <td><code>:checkbox-selection="true"</code></td>
                                    </tr>
                                    <tr>
                                        <td>Column Resizing</td>
                                        <td><code>:resizable="true"</code></td>
                                    </tr>
                                    <tr>
                                        <td>Column Pinning</td>
                                        <td><code>'pinned' => 'left|right'</code></td>
                                    </tr>
                                    <tr>
                                        <td>Cell Renderers (16+)</td>
                                        <td><code>'render' => 'badge|currency|...'</code></td>
                                    </tr>
                                    <tr>
                                        <td>CSV Export</td>
                                        <td><code>:exportable="true"</code></td>
                                    </tr>
                                    <tr>
                                        <td>Themes (4)</td>
                                        <td><code>theme="quartz|alpine|balham|material"</code></td>
                                    </tr>
                                    <tr>
                                        <td>Dark Mode</td>
                                        <td><code>:dark-mode="true"</code></td>
                                    </tr>
                                    <tr>
                                        <td>State Persistence</td>
                                        <td><code>:state-save="true"</code></td>
                                    </tr>
                                    <tr>
                                        <td>AJAX Data Source</td>
                                        <td><code>ajax-url="/api/data"</code></td>
                                    </tr>
                                    <tr>
                                        <td>Actions Column</td>
                                        <td><code>:show-actions="true"</code></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Pending Features --}}
                <div class="col-lg-6">
                    <div class="card card-bordered border-warning">
                        <div class="card-header bg-light-warning">
                            <h4 class="card-title">
                                <i class="ki-outline ki-time text-warning me-2"></i>
                                Coming Soon (P1/P2)
                            </h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm table-row-bordered">
                                <thead>
                                    <tr class="fw-bold text-muted">
                                        <th>Feature</th>
                                        <th>Priority</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Server-Side Data Model</td>
                                        <td><span class="badge badge-light-primary">P1</span></td>
                                    </tr>
                                    <tr>
                                        <td>Row Grouping</td>
                                        <td><span class="badge badge-light-primary">P1</span> <small class="text-muted">(Enterprise)</small></td>
                                    </tr>
                                    <tr>
                                        <td>Inline Cell Editing</td>
                                        <td><span class="badge badge-light-primary">P1</span></td>
                                    </tr>
                                    <tr>
                                        <td>Row Dragging</td>
                                        <td><span class="badge badge-light-info">P2</span></td>
                                    </tr>
                                    <tr>
                                        <td>Master/Detail (Expandable)</td>
                                        <td><span class="badge badge-light-info">P2</span> <small class="text-muted">(Enterprise)</small></td>
                                    </tr>
                                    <tr>
                                        <td>Excel Export</td>
                                        <td><span class="badge badge-light-info">P2</span> <small class="text-muted">(Enterprise)</small></td>
                                    </tr>
                                    <tr>
                                        <td>Context Menu</td>
                                        <td><span class="badge badge-light-info">P2</span></td>
                                    </tr>
                                    <tr>
                                        <td>Column Aggregation</td>
                                        <td><span class="badge badge-light-info">P2</span> <small class="text-muted">(Enterprise)</small></td>
                                    </tr>
                                    <tr>
                                        <td>Clipboard</td>
                                        <td><span class="badge badge-light-info">P2</span> <small class="text-muted">(Enterprise)</small></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="mt-4 p-3 bg-light-info rounded">
                                <small class="text-info">
                                    <i class="ki-outline ki-information-3 me-1"></i>
                                    Features marked "(Enterprise)" require AG Grid Enterprise license.
                                    Currently using Community edition.
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ================================================================== --}}
    {{-- AG GRID - BASIC                                                    --}}
    {{-- ================================================================== --}}

    <section id="aggrid-basic" class="showcase-section">
        <div class="showcase-section-header">
            <h3 class="showcase-section-title">
                <i class="ki-outline ki-grid me-2 text-info"></i>
                AG Grid - Basic Usage
            </h3>
        </div>
        <div class="showcase-section-body">
            <div class="showcase-example">
                <div class="showcase-example-header">
                    <h4>Simple Static Data Grid</h4>
                    <p class="text-muted mb-0">Basic grid with sortable columns and pagination</p>
                </div>
                <div class="showcase-example-preview">
                    @php
                        $agGridUsers = [
                            ['id' => 1, 'name' => 'John Smith', 'email' => 'john@example.com', 'role' => 'Admin', 'status' => 'active', 'salary' => 85000, 'joined' => '2023-01-15'],
                            ['id' => 2, 'name' => 'Jane Doe', 'email' => 'jane@example.com', 'role' => 'Editor', 'status' => 'active', 'salary' => 65000, 'joined' => '2023-03-22'],
                            ['id' => 3, 'name' => 'Bob Wilson', 'email' => 'bob@example.com', 'role' => 'Viewer', 'status' => 'inactive', 'salary' => 45000, 'joined' => '2022-11-08'],
                            ['id' => 4, 'name' => 'Alice Brown', 'email' => 'alice@example.com', 'role' => 'Editor', 'status' => 'active', 'salary' => 72000, 'joined' => '2023-06-14'],
                            ['id' => 5, 'name' => 'Charlie Davis', 'email' => 'charlie@example.com', 'role' => 'Viewer', 'status' => 'pending', 'salary' => 48000, 'joined' => '2024-01-03'],
                            ['id' => 6, 'name' => 'Diana Miller', 'email' => 'diana@example.com', 'role' => 'Admin', 'status' => 'active', 'salary' => 92000, 'joined' => '2022-08-19'],
                            ['id' => 7, 'name' => 'Edward Garcia', 'email' => 'edward@example.com', 'role' => 'Editor', 'status' => 'active', 'salary' => 68000, 'joined' => '2023-09-27'],
                            ['id' => 8, 'name' => 'Fiona Martinez', 'email' => 'fiona@example.com', 'role' => 'Viewer', 'status' => 'inactive', 'salary' => 42000, 'joined' => '2023-04-11'],
                        ];
                    @endphp

                    <x-table.aggrid.base
                        id="aggrid-basic-demo"
                        :columns="[
                            ['key' => 'id', 'label' => 'ID', 'width' => 80],
                            ['key' => 'name', 'label' => 'Name', 'flex' => 1],
                            ['key' => 'email', 'label' => 'Email', 'flex' => 1],
                            ['key' => 'role', 'label' => 'Role', 'width' => 120, 'render' => 'badge', 'colors' => ['Admin' => 'primary', 'Editor' => 'info', 'Viewer' => 'secondary']],
                            ['key' => 'status', 'label' => 'Status', 'width' => 120, 'render' => 'status', 'statuses' => [
                                'active' => ['label' => 'Active', 'color' => 'success'],
                                'inactive' => ['label' => 'Inactive', 'color' => 'danger'],
                                'pending' => ['label' => 'Pending', 'color' => 'warning'],
                            ]],
                            ['key' => 'salary', 'label' => 'Salary', 'width' => 120, 'render' => 'currency', 'symbol' => '$', 'decimals' => 0],
                            ['key' => 'joined', 'label' => 'Joined', 'width' => 130, 'render' => 'date'],
                        ]"
                        :data="$agGridUsers"
                        :sortable="true"
                        :pagination="true"
                        :page-size="5"
                        height="350px"
                    />
                </div>
                <div class="showcase-example-code">
                    <pre><code class="language-blade">&lt;x-table.aggrid.base
    :columns="[
        ['key' => 'id', 'label' => 'ID', 'width' => 80],
        ['key' => 'name', 'label' => 'Name', 'flex' => 1],
        ['key' => 'email', 'label' => 'Email', 'flex' => 1],
        ['key' => 'role', 'label' => 'Role', 'render' => 'badge', 'colors' => ['Admin' => 'primary']],
        ['key' => 'status', 'label' => 'Status', 'render' => 'status', 'statuses' => [...]],
        ['key' => 'salary', 'label' => 'Salary', 'render' => 'currency', 'symbol' => '$'],
        ['key' => 'joined', 'label' => 'Joined', 'render' => 'date'],
    ]"
    :data="$users"
    :sortable="true"
    :pagination="true"
    :page-size="5"
/&gt;</code></pre>
                </div>
            </div>
        </div>
    </section>

    {{-- ================================================================== --}}
    {{-- AG GRID - FILTERING                                                --}}
    {{-- ================================================================== --}}

    <section id="aggrid-filtering" class="showcase-section">
        <div class="showcase-section-header">
            <h3 class="showcase-section-title">
                <i class="ki-outline ki-filter me-2 text-info"></i>
                AG Grid - Filtering
            </h3>
        </div>
        <div class="showcase-section-body">
            <div class="showcase-example">
                <div class="showcase-example-header">
                    <h4>Grid with Column Filters & Quick Search</h4>
                    <p class="text-muted mb-0">Floating filters below headers + quick filter search box</p>
                </div>
                <div class="showcase-example-preview">
                    <x-table.aggrid.base
                        id="aggrid-filter-demo"
                        :columns="[
                            ['key' => 'id', 'label' => 'ID', 'width' => 80, 'filter' => 'number'],
                            ['key' => 'name', 'label' => 'Name', 'flex' => 1, 'filter' => 'text'],
                            ['key' => 'email', 'label' => 'Email', 'flex' => 1, 'filter' => 'text'],
                            ['key' => 'role', 'label' => 'Role', 'width' => 120, 'filter' => 'text', 'render' => 'badge', 'colors' => ['Admin' => 'primary', 'Editor' => 'info', 'Viewer' => 'secondary']],
                            ['key' => 'salary', 'label' => 'Salary', 'width' => 130, 'filter' => 'number', 'render' => 'currency', 'symbol' => '$', 'decimals' => 0],
                            ['key' => 'joined', 'label' => 'Joined', 'width' => 140, 'filter' => 'date', 'render' => 'date'],
                        ]"
                        :data="$agGridUsers"
                        :sortable="true"
                        :filterable="true"
                        :floating-filter="true"
                        :quick-filter="true"
                        :pagination="true"
                        height="400px"
                    />
                </div>
                <div class="showcase-example-code">
                    <pre><code class="language-blade">&lt;x-table.aggrid.base
    :columns="[
        ['key' => 'id', 'label' => 'ID', 'filter' => 'number'],
        ['key' => 'name', 'label' => 'Name', 'filter' => 'text'],
        ['key' => 'salary', 'label' => 'Salary', 'filter' => 'number'],
        ['key' => 'joined', 'label' => 'Joined', 'filter' => 'date'],
    ]"
    :data="$users"
    :filterable="true"
    :floating-filter="true"
    :quick-filter="true"
/&gt;</code></pre>
                </div>
            </div>
        </div>
    </section>

    {{-- ================================================================== --}}
    {{-- AG GRID - SELECTION                                                --}}
    {{-- ================================================================== --}}

    <section id="aggrid-selection" class="showcase-section">
        <div class="showcase-section-header">
            <h3 class="showcase-section-title">
                <i class="ki-outline ki-check-square me-2 text-info"></i>
                AG Grid - Row Selection
            </h3>
        </div>
        <div class="showcase-section-body">
            <div class="showcase-example">
                <div class="showcase-example-header">
                    <h4>Multi-Select with Checkboxes</h4>
                    <p class="text-muted mb-0">Select multiple rows with checkbox column. Selection count shows in toolbar.</p>
                </div>
                <div class="showcase-example-preview">
                    <x-table.aggrid.base
                        id="aggrid-selection-demo"
                        :columns="[
                            ['key' => 'id', 'label' => 'ID', 'width' => 80],
                            ['key' => 'name', 'label' => 'Name', 'flex' => 1],
                            ['key' => 'email', 'label' => 'Email', 'flex' => 1],
                            ['key' => 'role', 'label' => 'Role', 'width' => 120],
                            ['key' => 'status', 'label' => 'Status', 'width' => 120, 'render' => 'badge', 'colors' => ['active' => 'success', 'inactive' => 'danger', 'pending' => 'warning']],
                        ]"
                        :data="$agGridUsers"
                        :selectable="true"
                        selection-mode="multiple"
                        :checkbox-selection="true"
                        :header-checkbox="true"
                        :exportable="true"
                        on-selection-change="handleAgGridSelection"
                        height="350px"
                    />
                </div>
                <div class="showcase-example-code">
                    <pre><code class="language-blade">&lt;x-table.aggrid.base
    :columns="$columns"
    :data="$users"
    :selectable="true"
    selection-mode="multiple"
    :checkbox-selection="true"
    :header-checkbox="true"
    :exportable="true"
    on-selection-change="handleSelection"
/&gt;

&lt;script&gt;
function handleSelection(selectedRows, params) {
    console.log('Selected:', selectedRows);
}
&lt;/script&gt;</code></pre>
                </div>
            </div>
        </div>
    </section>

    {{-- ================================================================== --}}
    {{-- AG GRID - FEATURES                                                 --}}
    {{-- ================================================================== --}}

    <section id="aggrid-features" class="showcase-section">
        <div class="showcase-section-header">
            <h3 class="showcase-section-title">
                <i class="ki-outline ki-setting-3 me-2 text-info"></i>
                AG Grid - Advanced Features
            </h3>
        </div>
        <div class="showcase-section-body">
            {{-- Column Pinning --}}
            <div class="showcase-example">
                <div class="showcase-example-header">
                    <h4>Column Pinning</h4>
                    <p class="text-muted mb-0">Pin columns to left or right. Scroll horizontally to see effect.</p>
                </div>
                <div class="showcase-example-preview">
                    <x-table.aggrid.base
                        id="aggrid-pinning-demo"
                        :columns="[
                            ['key' => 'id', 'label' => 'ID', 'width' => 70, 'pinned' => 'left'],
                            ['key' => 'name', 'label' => 'Name', 'width' => 150, 'pinned' => 'left'],
                            ['key' => 'email', 'label' => 'Email', 'width' => 200],
                            ['key' => 'role', 'label' => 'Role', 'width' => 150],
                            ['key' => 'department', 'label' => 'Department', 'width' => 150],
                            ['key' => 'location', 'label' => 'Location', 'width' => 150],
                            ['key' => 'phone', 'label' => 'Phone', 'width' => 150],
                            ['key' => 'status', 'label' => 'Status', 'width' => 120, 'pinned' => 'right', 'render' => 'badge', 'colors' => ['active' => 'success', 'inactive' => 'danger']],
                        ]"
                        :data="[
                            ['id' => 1, 'name' => 'John Smith', 'email' => 'john@example.com', 'role' => 'Admin', 'department' => 'Engineering', 'location' => 'New York', 'phone' => '+1-555-0100', 'status' => 'active'],
                            ['id' => 2, 'name' => 'Jane Doe', 'email' => 'jane@example.com', 'role' => 'Manager', 'department' => 'Marketing', 'location' => 'Los Angeles', 'phone' => '+1-555-0101', 'status' => 'active'],
                            ['id' => 3, 'name' => 'Bob Wilson', 'email' => 'bob@example.com', 'role' => 'Developer', 'department' => 'Engineering', 'location' => 'Chicago', 'phone' => '+1-555-0102', 'status' => 'inactive'],
                        ]"
                        :sortable="true"
                        height="250px"
                    />
                </div>
                <div class="showcase-example-code">
                    <pre><code class="language-blade">&lt;x-table.aggrid.base
    :columns="[
        ['key' => 'id', 'label' => 'ID', 'pinned' => 'left'],
        ['key' => 'name', 'label' => 'Name', 'pinned' => 'left'],
        // ... middle columns scroll ...
        ['key' => 'status', 'label' => 'Status', 'pinned' => 'right'],
    ]"
    :data="$users"
/&gt;</code></pre>
                </div>
            </div>

            {{-- Themes --}}
            <div class="showcase-example mt-10">
                <div class="showcase-example-header">
                    <h4>Themes</h4>
                    <p class="text-muted mb-0">AG Grid supports multiple themes: Quartz (default), Alpine, Balham, Material</p>
                </div>
                <div class="showcase-example-preview">
                    <div class="row g-5">
                        <div class="col-md-6">
                            <h6 class="mb-3">Alpine Theme</h6>
                            <x-table.aggrid.base
                                id="aggrid-theme-alpine"
                                :columns="[
                                    ['key' => 'name', 'label' => 'Name'],
                                    ['key' => 'email', 'label' => 'Email'],
                                    ['key' => 'status', 'label' => 'Status', 'render' => 'badge', 'colors' => ['active' => 'success', 'inactive' => 'danger']],
                                ]"
                                :data="[
                                    ['name' => 'John', 'email' => 'john@test.com', 'status' => 'active'],
                                    ['name' => 'Jane', 'email' => 'jane@test.com', 'status' => 'inactive'],
                                ]"
                                theme="alpine"
                                height="180px"
                            />
                        </div>
                        <div class="col-md-6">
                            <h6 class="mb-3">Balham Theme</h6>
                            <x-table.aggrid.base
                                id="aggrid-theme-balham"
                                :columns="[
                                    ['key' => 'name', 'label' => 'Name'],
                                    ['key' => 'email', 'label' => 'Email'],
                                    ['key' => 'status', 'label' => 'Status', 'render' => 'badge', 'colors' => ['active' => 'success', 'inactive' => 'danger']],
                                ]"
                                :data="[
                                    ['name' => 'John', 'email' => 'john@test.com', 'status' => 'active'],
                                    ['name' => 'Jane', 'email' => 'jane@test.com', 'status' => 'inactive'],
                                ]"
                                theme="balham"
                                height="180px"
                            />
                        </div>
                    </div>
                </div>
            </div>

            {{-- State Persistence --}}
            <div class="showcase-example mt-10">
                <div class="showcase-example-header">
                    <h4>State Persistence</h4>
                    <p class="text-muted mb-0">Column order, widths, and sort state are saved to localStorage. Try resizing columns, then refresh the page.</p>
                </div>
                <div class="showcase-example-preview">
                    <x-table.aggrid.base
                        id="aggrid-state-demo"
                        :columns="[
                            ['key' => 'id', 'label' => 'ID', 'width' => 80],
                            ['key' => 'name', 'label' => 'Name', 'flex' => 1],
                            ['key' => 'email', 'label' => 'Email', 'flex' => 1],
                            ['key' => 'role', 'label' => 'Role', 'width' => 120],
                        ]"
                        :data="$agGridUsers"
                        :sortable="true"
                        :resizable="true"
                        :state-save="true"
                        height="250px"
                    />
                    <div class="mt-3">
                        <button class="btn btn-sm btn-light-warning" onclick="localStorage.removeItem('geo-grid-state-aggrid-state-demo'); location.reload();">
                            <i class="ki-outline ki-arrows-circle me-1"></i>
                            Reset Saved State
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
<script>
    // Demo handler for DataTable bulk actions
    function handleBulkAction(actionKey, selectedIds, tableId) {
        console.log('Bulk Action:', actionKey, 'Selected IDs:', selectedIds);
        alert('Action: ' + actionKey + '\nSelected IDs: ' + selectedIds.join(', '));

        // In real app, you would:
        // - Make AJAX call to backend
        // - Reload table after success
        // Example:
        // if (actionKey === 'delete') {
        //     fetch('/api/products/bulk-delete', {
        //         method: 'POST',
        //         body: JSON.stringify({ ids: selectedIds })
        //     }).then(() => GeoTable.reload(tableId));
        // }
    }

    // Demo handler for AG Grid selection
    function handleAgGridSelection(selectedRows, params) {
        console.log('AG Grid Selection:', selectedRows);
        console.log('Selected count:', selectedRows.length);
    }
</script>
@endpush
