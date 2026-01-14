{{--
    ================================================================================
    GLOBAL UI COMPONENT SHOWCASE - DataTable Only
    ================================================================================

    This is a DEVELOPER-ONLY page for testing and previewing DataTable components.

    PURPOSE:
    - Visual validation of DataTable component
    - Documentation of usage patterns
    - Testing different prop combinations
    - Design consistency verification

    ACCESS:
    - URL: /__components
    - Environment: local, staging, development only
    - No authentication required
    ================================================================================
--}}

@extends('core-ui.layouts.showcase')

@section('header-title', 'DataTable Component Library')
@section('header-description', 'Browse, test, and validate DataTable components')

@section('sidebar-nav')
    <!-- Feature Tracking -->
    <div class="showcase-nav-category">Development</div>
    <a href="#feature-tracker" class="showcase-nav-item">
        <i class="ki-outline ki-chart-simple-2"></i>
        Feature Tracker
    </a>

    <!-- Table Category -->
    <div class="showcase-nav-category">Table Components</div>
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
                <br><small class="text-warning">Last Updated: January 14, 2026</small>
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
                                        <td>Built-in Renderers</td>
                                        <td><code>render => 'date|datetime|currency|badge|boolean'</code></td>
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
                                        <td><code>&lt;x-slot:toolbar&gt;</code> <span class="badge badge-light-warning">No row context</span></td>
                                    </tr>
                                    <tr>
                                        <td>Empty Slot</td>
                                        <td><code>&lt;x-slot:empty&gt;</code> <span class="badge badge-light-warning">No row context</span></td>
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
                                        <td>Bulk Actions</td>
                                        <td>
                                            Delete/Export selected via toolbar + selectable
                                            <br><small class="text-muted">Requires custom cell slots + JS</small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Column Visibility Toggle</td>
                                        <td>
                                            Show/hide columns dynamically via UI
                                            <br><small class="text-muted">DataTables supports it, needs UI component</small>
                                        </td>
                                    </tr>
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

                            <div class="alert alert-info d-flex mt-5 p-4">
                                <i class="ki-outline ki-information-5 fs-2 me-3"></i>
                                <div>
                                    <strong>Note:</strong>
                                    <br>Features listed here are planned for future implementation. Prioritize based on real consumption needs.
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

@endsection
