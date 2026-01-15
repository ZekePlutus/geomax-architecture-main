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

@extends('layout50.master')

@section('title', 'Component Showcase')
@section('page_title', 'UI Component Library')

@php
    $breadcrumbs = [
        ['url' => "/", 'label' => 'Home'],
        'Components'
    ];
@endphp

@push('styles')
<style>
    /* Showcase Section Styles */
    .showcase-section {
        background: #fff;
        border-radius: 12px;
        margin-bottom: 40px;
        box-shadow: 0 0 20px rgba(0,0,0,0.03);
        overflow: hidden;
        display: block;
        clear: both;
    }

    /* Ensure proper section separation */
    .showcase-section:not(:last-child) {
        margin-bottom: 40px !important;
    }

    .showcase-section-header {
        padding: 20px 25px;
        border-bottom: 1px solid #e4e6ef;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .showcase-section-title {
        margin: 0;
        font-size: 16px;
        font-weight: 600;
        color: #181c32;
    }

    .showcase-section-title code {
        font-size: 12px;
        background: #f1f3f5;
        padding: 3px 8px;
        border-radius: 4px;
        margin-left: 10px;
        color: #7e8299;
    }

    .showcase-section-body {
        padding: 25px;
    }

    .showcase-section-footer {
        padding: 15px 25px;
        background: #f9fafb;
        border-top: 1px solid #e4e6ef;
        border-radius: 0 0 12px 12px;
    }

    /* Example Grid */
    .showcase-example {
        margin-bottom: 30px;
        padding-bottom: 30px;
        border-bottom: 1px dashed #e4e6ef;
    }

    .showcase-example:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }

    /* Additional spacing for multiple examples */
    .showcase-example + .showcase-example,
    .showcase-example.mt-10 {
        margin-top: 40px !important;
        padding-top: 30px;
        border-top: 1px dashed #e4e6ef;
    }

    .showcase-example-label {
        font-size: 13px;
        font-weight: 600;
        color: #5e6278;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
    }

    .showcase-example-label .badge {
        margin-left: 8px;
    }

    /* Example Header */
    .showcase-example-header {
        margin-bottom: 15px;
    }

    .showcase-example-header h4 {
        font-size: 15px;
        font-weight: 600;
        color: #181c32;
        margin: 0 0 5px 0;
    }

    .showcase-example-header p {
        margin: 0;
    }

    .showcase-example-preview {
        background: #fafbfc;
        border: 1px solid #e4e6ef;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 0;
        min-height: 150px;
        overflow: auto;
        position: relative;
    }

    /* Ensure geo-grid-wrapper takes full height when inside preview */
    .showcase-example-preview > .geo-grid-wrapper {
        position: relative;
        width: 100%;
    }

    /* Dark mode support for showcase */
    [data-bs-theme="dark"] .showcase-section {
        background: var(--bs-body-bg, #1e1e2d);
        box-shadow: 0 0 20px rgba(0,0,0,0.2);
    }

    [data-bs-theme="dark"] .showcase-section-header {
        border-bottom-color: var(--bs-border-color, #2d2d3a);
    }

    [data-bs-theme="dark"] .showcase-section-title {
        color: var(--bs-body-color, #f5f8fa);
    }

    [data-bs-theme="dark"] .showcase-example {
        border-bottom-color: var(--bs-border-color, #2d2d3a);
    }

    [data-bs-theme="dark"] .showcase-example-header h4 {
        color: var(--bs-body-color, #f5f8fa);
    }

    [data-bs-theme="dark"] .showcase-example-preview {
        background: var(--bs-gray-900, #151521);
        border-color: var(--bs-border-color, #2d2d3a);
    }

    /* Ensure AG Grid containers have proper sizing */
    .showcase-example-preview .ag-theme-quartz,
    .showcase-example-preview .ag-theme-quartz-dark,
    .showcase-example-preview [id*="aggrid"] {
        width: 100% !important;
        display: block;
    }

    /* Ensure tables have proper spacing within examples */
    .showcase-example-preview .geo-grid-wrapper,
    .showcase-example-preview .geo-table-wrapper {
        margin-bottom: 0;
        width: 100%;
        position: relative;
    }

    /* AG Grid specific fixes for showcase - critical for proper display */
    .showcase-section .geo-grid-wrapper {
        width: 100% !important;
        display: block;
        position: relative;
        margin-bottom: 15px;
    }

    /* Ensure AG Grid container respects height */
    .showcase-example-preview [class*="ag-theme-"] {
        width: 100% !important;
        position: relative;
        box-sizing: border-box;
    }

    /* Critical: Force AG Grid to respect inline height */
    .showcase-example-preview .ag-root-wrapper {
        width: 100% !important;
        height: 100% !important;
        border-radius: 8px;
        position: relative;
        box-sizing: border-box;
    }

    /* Prevent AG Grid from overflowing */
    .showcase-section .ag-root-wrapper-body {
        position: relative;
        height: 100%;
    }

    /* Force showcase sections to properly contain their content */
    .showcase-section {
        contain: layout style;
    }

    .showcase-section-body {
        position: relative;
        overflow: visible;
    }

    /* Fix for quick filter search box */
    .showcase-section .geo-grid-toolbar {
        margin-bottom: 10px;
    }

    /* Hide example code blocks - code should only show in slide-out panel */
    .showcase-example-code {
        display: none !important;
    }

    /* Code Block */
    .showcase-code {
        background: #1e1e2d;
        color: #e4e6ef;
        padding: 20px;
        border-radius: 8px;
        font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', 'Consolas', monospace;
        font-size: 13px;
        line-height: 1.7;
        overflow-x: auto;
        margin: 0;
        white-space: pre;
        border: 1px solid #2d2d3a;
    }

    /* Legacy code wrapper (hidden by default, used for storing code) */
    .showcase-code-wrapper {
        display: none;
    }

    /* Slide-out Code Panel */
    .showcase-code-panel {
        position: fixed;
        top: 0;
        right: 0;
        width: 550px;
        max-width: 50vw;
        height: 100vh;
        background: #1e1e2d;
        z-index: 1050;
        transform: translateX(100%);
        transition: transform 0.3s ease-in-out;
        display: flex;
        flex-direction: column;
        box-shadow: -5px 0 30px rgba(0, 0, 0, 0.3);
    }

    .showcase-code-panel.open {
        transform: translateX(0);
    }

    .showcase-code-panel-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        background: #151521;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        flex-shrink: 0;
    }

    .showcase-code-panel-title {
        color: #fff;
        font-size: 14px;
        font-weight: 600;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .showcase-code-panel-title i {
        color: #3699ff;
    }

    .showcase-code-panel-actions {
        display: flex;
        gap: 8px;
    }

    .showcase-code-panel-btn {
        padding: 6px 12px;
        font-size: 12px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .showcase-code-panel-copy {
        background: #3699ff;
        color: #fff;
    }

    .showcase-code-panel-copy:hover {
        background: #1a73e8;
    }

    .showcase-code-panel-close {
        background: rgba(255, 255, 255, 0.1);
        color: #fff;
    }

    .showcase-code-panel-close:hover {
        background: rgba(255, 255, 255, 0.2);
    }

    .showcase-code-panel-body {
        flex: 1;
        overflow: auto;
        padding: 20px;
    }

    .showcase-code-panel-body .showcase-code {
        border-radius: 0;
        border: none;
        background: transparent;
        padding: 0;
        min-height: 100%;
    }

    .showcase-code-panel-label {
        display: inline-block;
        padding: 4px 10px;
        background: rgba(54, 153, 255, 0.2);
        color: #3699ff;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-radius: 4px;
    }

    /* Backdrop when panel is open */
    .showcase-code-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1040;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s, visibility 0.3s;
    }

    .showcase-code-backdrop.open {
        opacity: 1;
        visibility: visible;
    }

    .showcase-code .tag {
        color: #e74c3c;
    }

    .showcase-code .attr {
        color: #3498db;
    }

    .showcase-code .string {
        color: #2ecc71;
    }

    /* Toggle Button - Consistent style */
    .showcase-toggle-code {
        font-size: 12px;
        padding: 6px 14px;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #f1f3f5 !important;
        border: 1px solid #e4e6ef !important;
        color: #5e6278 !important;
    }

    .showcase-toggle-code:hover {
        background: #e9ecef !important;
        border-color: #d1d5db !important;
    }

    .showcase-toggle-code.active {
        background: #3699ff !important;
        border-color: #3699ff !important;
        color: #fff !important;
    }

    .showcase-toggle-code i {
        font-size: 14px;
    }
</style>
@endpush

@section('content')
    <!-- Slide-out Code Panel -->
    <div class="showcase-code-backdrop" id="codeBackdrop"></div>
    <div class="showcase-code-panel" id="codePanel">
        <div class="showcase-code-panel-header">
            <h4 class="showcase-code-panel-title">
                <i class="ki-outline ki-code"></i>
                <span id="codePanelTitle">Blade Usage</span>
            </h4>
            <div class="showcase-code-panel-actions">
                <button class="showcase-code-panel-btn showcase-code-panel-copy" id="codePanelCopy">
                    <i class="ki-outline ki-copy"></i>
                    Copy
                </button>
                <button class="showcase-code-panel-btn showcase-code-panel-close" id="codePanelClose">
                    <i class="ki-outline ki-cross"></i>
                </button>
            </div>
        </div>
        <div class="showcase-code-panel-body">
            <pre class="showcase-code" id="codePanelContent"></pre>
        </div>
    </div>

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
                                    <tr class="table-success">
                                        <td><span class="badge badge-success me-2">NEW</span>Column Filters (Per-Column Search)</td>
                                        <td><code>:column-filters="true"</code>, <code>column-filters-position="header|footer"</code></td>
                                    </tr>
                                    <tr class="table-success">
                                        <td><span class="badge badge-success me-2">NEW</span>Inline Editing (Cell Edit)</td>
                                        <td><code>:inline-editing="true"</code>, <code>on-cell-edit-start</code>, <code>on-cell-edit-commit</code></td>
                                    </tr>
                                    <tr class="table-success">
                                        <td><span class="badge badge-success me-2">NEW</span>Row Grouping</td>
                                        <td><code>group-by="column"</code>, <code>:group-collapsible="true"</code>, <code>:group-collapsed="false"</code></td>
                                    </tr>
                                    <tr class="table-success">
                                        <td><span class="badge badge-success me-2">NEW</span>Row Reordering (Drag & Drop)</td>
                                        <td><code>:row-reorder="true"</code>, <code>on-row-reorder="callback"</code></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Missing / Pending Features --}}
                <div class="col-lg-6">
                    <div class="card card-bordered border-success">
                        <div class="card-header bg-light-success">
                            <h4 class="card-title">
                                <i class="ki-outline ki-check-circle text-success me-2"></i>
                                All Core Features Implemented! ✅
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-success d-flex p-4">
                                <i class="ki-outline ki-check-circle fs-2 me-3 text-success"></i>
                                <div>
                                    <strong>Feature Complete!</strong>
                                    <br>All DataTable features including Inline Editing, Row Grouping, and Row Reordering have been implemented.
                                    <br><small class="text-muted">All features are optional, config-driven, and event-based (no data persistence).</small>
                                </div>
                            </div>

                            <h6 class="fw-bold text-gray-700 mt-5 mb-3">New Features Summary:</h6>
                            <table class="table table-sm table-row-bordered">
                                <thead>
                                    <tr class="fw-bold text-muted">
                                        <th>Feature</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Inline Editing</td>
                                        <td><span class="badge badge-success">✅ DONE</span></td>
                                    </tr>
                                    <tr>
                                        <td>Row Grouping</td>
                                        <td><span class="badge badge-success">✅ DONE</span></td>
                                    </tr>
                                    <tr>
                                        <td>Row Reordering</td>
                                        <td><span class="badge badge-success">✅ DONE</span></td>
                                    </tr>
                                </tbody>
                            </table>
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

            {{-- Column Filters Example (Header Position) --}}
            <div class="showcase-example">
                <div class="showcase-example-label">
                    <span class="badge badge-success me-2">NEW</span> Column Filters (Per-Column Search) - Header Position
                    <span class="badge badge-light-info ms-2">Type in filter inputs to search each column</span>
                </div>
                <div class="showcase-example-preview">
                    <x-table.datatable.base
                        id="demo-column-filters-header"
                        :columns="[
                            ['key' => 'id', 'label' => 'ID', 'width' => '60px', 'searchable' => true],
                            ['key' => 'name', 'label' => 'Name', 'searchable' => true, 'filterPlaceholder' => 'Search name...'],
                            ['key' => 'email', 'label' => 'Email', 'searchable' => true],
                            ['key' => 'role', 'label' => 'Role', 'searchable' => true, 'filterOptions' => [
                                'Admin' => 'Admin',
                                'Editor' => 'Editor',
                                'Viewer' => 'Viewer',
                            ]],
                            ['key' => 'status', 'label' => 'Status', 'searchable' => true, 'filterOptions' => [
                                'active' => 'Active',
                                'inactive' => 'Inactive',
                                'pending' => 'Pending',
                            ]],
                        ]"
                        :data="$sampleUsers"
                        :datatable="true"
                        :sortable="true"
                        :column-filters="true"
                        column-filters-position="header"
                    />
                    <div class="mt-3 d-flex gap-2">
                        <button class="btn btn-sm btn-light-warning" onclick="GeoTable.clearColumnFilters('demo-column-filters-header')">
                            <i class="ki-outline ki-arrows-loop me-1"></i> Clear All Filters
                        </button>
                        <button class="btn btn-sm btn-light-info" onclick="alert(JSON.stringify(GeoTable.getColumnFilters('demo-column-filters-header'), null, 2))">
                            <i class="ki-outline ki-information-5 me-1"></i> Get Filter Values
                        </button>
                        <button class="btn btn-sm btn-light-primary" onclick="GeoTable.setColumnFilter('demo-column-filters-header', 'name', 'John')">
                            <i class="ki-outline ki-filter me-1"></i> Set Name = "John"
                        </button>
                    </div>
                </div>
            </div>

            {{-- Column Filters Example (Footer Position) --}}
            <div class="showcase-example">
                <div class="showcase-example-label">
                    <span class="badge badge-success me-2">NEW</span> Column Filters - Footer Position
                </div>
                <div class="showcase-example-preview">
                    <x-table.datatable.base
                        id="demo-column-filters-footer"
                        :columns="[
                            ['key' => 'id', 'label' => 'ID', 'width' => '60px', 'searchable' => true],
                            ['key' => 'name', 'label' => 'Name', 'searchable' => true],
                            ['key' => 'email', 'label' => 'Email', 'searchable' => true],
                            ['key' => 'role', 'label' => 'Role', 'searchable' => true],
                            ['key' => 'status', 'label' => 'Status', 'searchable' => false],
                        ]"
                        :data="$sampleUsers"
                        :datatable="true"
                        :sortable="true"
                        :pagination="true"
                        :page-length="5"
                        :column-filters="true"
                        column-filters-position="footer"
                    />
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
    {{-- INLINE EDITING (NEW FEATURE)                                       --}}
    {{-- ================================================================== --}}

    <section id="datatable-inline-editing" class="showcase-section">
        <div class="showcase-section-header">
            <h3 class="showcase-section-title">
                <i class="ki-outline ki-pencil me-2 text-info"></i>
                <span class="badge badge-success me-2">NEW</span>
                Inline Editing
                <code>inline-editing, on-cell-edit-commit</code>
            </h3>
            <button class="btn btn-sm btn-light showcase-toggle-code" data-toggle-code="#code-datatable-inline-editing">
                <i class="ki-outline ki-code"></i> View Code
            </button>
        </div>
        <div class="showcase-section-body">
            <p class="text-muted mb-5">
                Click on <strong>Name</strong> or <strong>Role</strong> cells to edit inline. Press <kbd>Enter</kbd> or click outside to commit, <kbd>Escape</kbd> to cancel.
                <br><small class="text-warning">⚠️ The component does NOT persist changes - your callback handles persistence via API.</small>
            </p>

            <div class="showcase-example">
                <div class="showcase-example-label">
                    Inline Editing with Text & Select Editors
                </div>
                <div class="showcase-example-preview">
                    @php
                        $inlineEditData = [
                            ['id' => 1, 'name' => 'Alice Johnson', 'email' => 'alice@example.com', 'role' => 'Admin', 'status' => 'active'],
                            ['id' => 2, 'name' => 'Bob Smith', 'email' => 'bob@example.com', 'role' => 'Editor', 'status' => 'active'],
                            ['id' => 3, 'name' => 'Carol Williams', 'email' => 'carol@example.com', 'role' => 'Viewer', 'status' => 'pending'],
                            ['id' => 4, 'name' => 'David Brown', 'email' => 'david@example.com', 'role' => 'Editor', 'status' => 'inactive'],
                        ];
                    @endphp
                    <x-table.datatable.base
                        id="demo-inline-editing"
                        :columns="[
                            ['key' => 'id', 'label' => 'ID', 'width' => '60px'],
                            ['key' => 'name', 'label' => 'Name', 'editable' => true, 'editorType' => 'text'],
                            ['key' => 'email', 'label' => 'Email'],
                            ['key' => 'role', 'label' => 'Role', 'editable' => true, 'editorType' => 'select', 'editorOptions' => [
                                ['value' => 'Admin', 'label' => 'Admin'],
                                ['value' => 'Editor', 'label' => 'Editor'],
                                ['value' => 'Viewer', 'label' => 'Viewer'],
                            ]],
                            ['key' => 'status', 'label' => 'Status', 'render' => 'status', 'statuses' => [
                                'active' => ['label' => 'Active', 'color' => 'success'],
                                'pending' => ['label' => 'Pending', 'color' => 'warning'],
                                'inactive' => ['label' => 'Inactive', 'color' => 'danger'],
                            ]],
                        ]"
                        :data="$inlineEditData"
                        :datatable="true"
                        :inline-editing="true"
                        on-cell-edit-start="handleCellEditStart"
                        on-cell-edit-commit="handleCellEditCommit"
                        row-key="id"
                    />
                </div>
            </div>
        </div>

        <div id="code-datatable-inline-editing" class="showcase-code-wrapper">
            <div class="showcase-code-header">
                <span class="showcase-code-label">Blade Usage - Inline Editing</span>
                <button class="showcase-code-copy">Copy</button>
            </div>
            <pre class="showcase-code">&lt;!-- Inline Editing with Text and Select Editors --&gt;
&lt;x-table.datatable.base
    id="users-table"
    :columns="[
        ['key' => 'id', 'label' => 'ID'],
        ['key' => 'name', 'label' => 'Name', 'editable' => true, 'editorType' => 'text'],
        ['key' => 'email', 'label' => 'Email'],
        ['key' => 'role', 'label' => 'Role', 'editable' => true, 'editorType' => 'select', 'editorOptions' => [
            ['value' => 'Admin', 'label' => 'Admin'],
            ['value' => 'Editor', 'label' => 'Editor'],
            ['value' => 'Viewer', 'label' => 'Viewer'],
        ]],
    ]"
    :data="$users"
    :datatable="true"
    :inline-editing="true"
    on-cell-edit-start="handleCellEditStart"
    on-cell-edit-commit="handleCellEditCommit"
    row-key="id"
/&gt;

&lt;script&gt;
// Called when editing starts
function handleCellEditStart(tableId, cell, rowData, field, currentValue) {
    console.log('Editing started:', { field, currentValue, rowId: rowData.id });
}

// Called when edit is committed - return false to prevent
function handleCellEditCommit(tableId, cell, rowData, field, oldValue, newValue) {
    console.log('Edit committed:', { field, oldValue, newValue });

    // Example: Send to server
    fetch(`/api/users/${rowData.id}`, {
        method: 'PATCH',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ [field]: newValue })
    });

    return true; // Allow change (return false to reject)
}
&lt;/script&gt;

&lt;!-- Available Editor Types --&gt;
&lt;!-- 'text'     - Simple text input --&gt;
&lt;!-- 'textarea' - Multi-line text --&gt;
&lt;!-- 'number'   - Numeric input --&gt;
&lt;!-- 'select'   - Dropdown (requires editorOptions) --&gt;</pre>
        </div>
    </section>

    {{-- ================================================================== --}}
    {{-- ROW GROUPING (NEW FEATURE)                                         --}}
    {{-- ================================================================== --}}

    <section id="datatable-row-grouping" class="showcase-section">
        <div class="showcase-section-header">
            <h3 class="showcase-section-title">
                <i class="ki-outline ki-element-11 me-2 text-primary"></i>
                <span class="badge badge-success me-2">NEW</span>
                Row Grouping
                <code>group-by, group-collapsible</code>
            </h3>
            <button class="btn btn-sm btn-light showcase-toggle-code" data-toggle-code="#code-datatable-row-grouping">
                <i class="ki-outline ki-code"></i> View Code
            </button>
        </div>
        <div class="showcase-section-body">
            <p class="text-muted mb-5">
                Rows are grouped by <strong>Department</strong>. Click on group headers to expand/collapse.
                <br><small class="text-warning">⚠️ Grouping is purely visual - use API methods for programmatic control.</small>
            </p>

            <div class="showcase-example">
                <div class="showcase-example-label">
                    Group by Column Value
                </div>
                <div class="showcase-example-preview">
                    @php
                        $groupingData = [
                            ['id' => 1, 'name' => 'Alice', 'department' => 'Engineering', 'title' => 'Senior Developer'],
                            ['id' => 2, 'name' => 'Bob', 'department' => 'Engineering', 'title' => 'Junior Developer'],
                            ['id' => 3, 'name' => 'Carol', 'department' => 'Engineering', 'title' => 'Tech Lead'],
                            ['id' => 4, 'name' => 'David', 'department' => 'Marketing', 'title' => 'Marketing Manager'],
                            ['id' => 5, 'name' => 'Eve', 'department' => 'Marketing', 'title' => 'Content Writer'],
                            ['id' => 6, 'name' => 'Frank', 'department' => 'Sales', 'title' => 'Sales Rep'],
                            ['id' => 7, 'name' => 'Grace', 'department' => 'Sales', 'title' => 'Account Executive'],
                            ['id' => 8, 'name' => 'Henry', 'department' => 'HR', 'title' => 'HR Manager'],
                        ];
                    @endphp
                    <x-table.datatable.base
                        id="demo-row-grouping"
                        :columns="[
                            ['key' => 'id', 'label' => 'ID', 'width' => '60px'],
                            ['key' => 'name', 'label' => 'Name'],
                            ['key' => 'department', 'label' => 'Department'],
                            ['key' => 'title', 'label' => 'Job Title'],
                        ]"
                        :data="$groupingData"
                        :datatable="false"
                        group-by="department"
                        :group-collapsible="true"
                        :group-collapsed="false"
                        row-key="id"
                    />
                </div>
            </div>
        </div>

        <div id="code-datatable-row-grouping" class="showcase-code-wrapper">
            <div class="showcase-code-header">
                <span class="showcase-code-label">Blade Usage - Row Grouping</span>
                <button class="showcase-code-copy">Copy</button>
            </div>
            <pre class="showcase-code">&lt;!-- Row Grouping by Column --&gt;
&lt;x-table.datatable.base
    id="employees-table"
    :columns="[
        ['key' => 'id', 'label' => 'ID'],
        ['key' => 'name', 'label' => 'Name'],
        ['key' => 'department', 'label' => 'Department'],
        ['key' => 'title', 'label' => 'Job Title'],
    ]"
    :data="$employees"
    group-by="department"
    :group-collapsible="true"
    :group-collapsed="false"
    row-key="id"
/&gt;

&lt;!-- Start with groups collapsed --&gt;
&lt;x-table.datatable.base
    :columns="$columns"
    :data="$data"
    group-by="status"
    :group-collapsible="true"
    :group-collapsed="true"
/&gt;

&lt;!-- JavaScript API --&gt;
&lt;script&gt;
// Toggle specific group
GeoTable.toggleGroup('employees-table', 'Engineering');

// Expand all groups
GeoTable.expandAllGroups('employees-table');

// Collapse all groups
GeoTable.collapseAllGroups('employees-table');
&lt;/script&gt;</pre>
        </div>
    </section>

    {{-- ================================================================== --}}
    {{-- ROW REORDERING (NEW FEATURE)                                       --}}
    {{-- ================================================================== --}}

    <section id="datatable-row-reorder" class="showcase-section">
        <div class="showcase-section-header">
            <h3 class="showcase-section-title">
                <i class="ki-outline ki-arrow-up-down me-2 text-warning"></i>
                <span class="badge badge-success me-2">NEW</span>
                Row Reordering (Drag & Drop)
                <code>row-reorder, on-row-reorder</code>
            </h3>
            <button class="btn btn-sm btn-light showcase-toggle-code" data-toggle-code="#code-datatable-row-reorder">
                <i class="ki-outline ki-code"></i> View Code
            </button>
        </div>
        <div class="showcase-section-body">
            <p class="text-muted mb-5">
                Drag the <strong>☰</strong> handle to reorder rows. The new order is emitted via callback.
                <br><small class="text-warning">⚠️ The component does NOT persist order - your callback handles persistence via API.</small>
            </p>

            <div class="showcase-example">
                <div class="showcase-example-label">
                    Drag Handle Row Reordering
                </div>
                <div class="showcase-example-preview">
                    @php
                        $reorderData = [
                            ['id' => 1, 'priority' => 1, 'task' => 'Complete project proposal', 'due' => 'Tomorrow'],
                            ['id' => 2, 'priority' => 2, 'task' => 'Review pull requests', 'due' => 'Today'],
                            ['id' => 3, 'priority' => 3, 'task' => 'Update documentation', 'due' => 'Next week'],
                            ['id' => 4, 'priority' => 4, 'task' => 'Fix bug #1234', 'due' => 'Today'],
                            ['id' => 5, 'priority' => 5, 'task' => 'Team standup meeting', 'due' => 'Daily'],
                        ];
                    @endphp
                    <x-table.datatable.base
                        id="demo-row-reorder"
                        :columns="[
                            ['key' => 'priority', 'label' => '#', 'width' => '50px'],
                            ['key' => 'task', 'label' => 'Task'],
                            ['key' => 'due', 'label' => 'Due Date'],
                        ]"
                        :data="$reorderData"
                        :datatable="false"
                        :row-reorder="true"
                        on-row-reorder="handleRowReorder"
                        row-key="id"
                    />
                </div>
            </div>
        </div>

        <div id="code-datatable-row-reorder" class="showcase-code-wrapper">
            <div class="showcase-code-header">
                <span class="showcase-code-label">Blade Usage - Row Reordering</span>
                <button class="showcase-code-copy">Copy</button>
            </div>
            <pre class="showcase-code">&lt;!-- Row Reordering with Drag & Drop --&gt;
&lt;x-table.datatable.base
    id="tasks-table"
    :columns="[
        ['key' => 'priority', 'label' => '#'],
        ['key' => 'task', 'label' => 'Task'],
        ['key' => 'due', 'label' => 'Due Date'],
    ]"
    :data="$tasks"
    :row-reorder="true"
    on-row-reorder="handleRowReorder"
    row-key="id"
/&gt;

&lt;script&gt;
// Called when rows are reordered
function handleRowReorder(tableId, newOrder, fromIndex, toIndex) {
    console.log('Row reordered:', { fromIndex, toIndex });

    // Get ordered IDs
    const orderedIds = newOrder.map(row => row.id);

    // Send to server
    fetch('/api/tasks/reorder', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ order: orderedIds })
    });
}
&lt;/script&gt;

&lt;!-- JavaScript API --&gt;
&lt;script&gt;
// Get current row order
const order = GeoTable.getRowOrder('tasks-table');
console.log(order); // Array of row data in current order

// Get specific row data
const rowData = GeoTable.getRowData('tasks-table', 0);
&lt;/script&gt;</pre>
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
                                        <td>Server-Side Data Model</td>
                                        <td><code>:server-side="true"</code></td>
                                    </tr>
                                    <tr>
                                        <td>Infinite Scroll</td>
                                        <td><code>:server-side-infinite="true"</code></td>
                                    </tr>
                                    <tr>
                                        <td>Actions Column</td>
                                        <td><code>:show-actions="true"</code></td>
                                    </tr>
                                    <tr class="table-success">
                                        <td><span class="badge badge-success me-2">NEW</span>Inline Cell Editing</td>
                                        <td><code>:editable="true"</code>, <code>'editor' => 'text|number|select'</code></td>
                                    </tr>
                                    <tr class="table-success">
                                        <td><span class="badge badge-success me-2">NEW</span>Row Dragging</td>
                                        <td><code>:row-draggable="true"</code>, <code>on-row-drag-end</code></td>
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
                                        <td>Row Grouping</td>
                                        <td><span class="badge badge-light-primary">P1</span> <small class="text-muted">(Enterprise)</small></td>
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
                                        <td><span class="badge badge-light-success"><i class="ki-outline ki-check-circle fs-8 me-1"></i>Done</span> <small class="text-muted">(Custom Implementation)</small></td>
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
                            <div class="mt-4 p-3 bg-light-success rounded">
                                <small class="text-success">
                                    <i class="ki-outline ki-check-circle me-1"></i>
                                    <strong>Inline Cell Editing</strong>, <strong>Row Dragging</strong>, and <strong>Context Menu</strong> are now implemented!
                                </small>
                            </div>
                            <div class="mt-2 p-3 bg-light-info rounded">
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
            <button class="btn btn-sm btn-light showcase-toggle-code" data-toggle-code="#code-aggrid-basic">
                Show Code
            </button>
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
            </div>
        </div>

        <div id="code-aggrid-basic" class="showcase-code-wrapper">
            <div class="showcase-code-header">
                <span class="showcase-code-label">Blade Usage</span>
            </div>
            <pre class="showcase-code">&lt;x-table.aggrid.base
    :columns="[
        ['key' => 'id', 'label' => 'ID', 'width' => 80],
        ['key' => 'name', 'label' => 'Name', 'flex' => 1],
        ['key' => 'email', 'label' => 'Email', 'flex' => 1],
        ['key' => 'role', 'label' => 'Role', 'render' => 'badge', 'colors' => ['Admin' => 'primary', 'Editor' => 'info', 'Viewer' => 'secondary']],
        ['key' => 'status', 'label' => 'Status', 'render' => 'status', 'statuses' => [
            'active' => ['label' => 'Active', 'color' => 'success'],
            'inactive' => ['label' => 'Inactive', 'color' => 'danger'],
            'pending' => ['label' => 'Pending', 'color' => 'warning'],
        ]],
        ['key' => 'salary', 'label' => 'Salary', 'render' => 'currency', 'symbol' => '$', 'decimals' => 0],
        ['key' => 'joined', 'label' => 'Joined', 'render' => 'date'],
    ]"
    :data="$users"
    :sortable="true"
    :pagination="true"
    :page-size="5"
    height="350px"
/&gt;</pre>
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
            <button class="btn btn-sm btn-light showcase-toggle-code" data-toggle-code="#code-aggrid-filtering">
                Show Code
            </button>
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
            </div>
        </div>

        <div id="code-aggrid-filtering" class="showcase-code-wrapper">
            <div class="showcase-code-header">
                <span class="showcase-code-label">Blade Usage</span>
            </div>
            <pre class="showcase-code">&lt;x-table.aggrid.base
    :columns="[
        ['key' => 'id', 'label' => 'ID', 'filter' => 'number'],
        ['key' => 'name', 'label' => 'Name', 'filter' => 'text'],
        ['key' => 'email', 'label' => 'Email', 'filter' => 'text'],
        ['key' => 'role', 'label' => 'Role', 'filter' => 'text', 'render' => 'badge'],
        ['key' => 'salary', 'label' => 'Salary', 'filter' => 'number', 'render' => 'currency'],
        ['key' => 'joined', 'label' => 'Joined', 'filter' => 'date', 'render' => 'date'],
    ]"
    :data="$users"
    :sortable="true"
    :filterable="true"
    :floating-filter="true"
    :quick-filter="true"
    :pagination="true"
/&gt;

&lt;!-- Filter types available: 'text', 'number', 'date', 'set' --&gt;</pre>
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
            <button class="btn btn-sm btn-light showcase-toggle-code" data-toggle-code="#code-aggrid-selection">
                Show Code
            </button>
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
            </div>
        </div>

        <div id="code-aggrid-selection" class="showcase-code-wrapper">
            <div class="showcase-code-header">
                <span class="showcase-code-label">Blade Usage</span>
            </div>
            <pre class="showcase-code">&lt;x-table.aggrid.base
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
    console.log('Selected IDs:', selectedRows.map(r => r.id));
}

// JS API methods
const selected = GeoGrid.getSelected('grid-id');      // Get selected row data
const selectedIds = GeoGrid.getSelectedIds('grid-id'); // Get selected IDs only
GeoGrid.selectAll('grid-id');                          // Select all rows
GeoGrid.deselectAll('grid-id');                        // Deselect all rows
GeoGrid.selectRows('grid-id', [1, 2, 3]);              // Select specific rows by ID
&lt;/script&gt;</pre>
        </div>
    </section>

    {{-- ================================================================== --}}
    {{-- AG GRID - SERVER-SIDE DATA MODEL                                   --}}
    {{-- ================================================================== --}}

    <section id="aggrid-server-side" class="showcase-section">
        <div class="showcase-section-header">
            <h3 class="showcase-section-title">
                <i class="ki-outline ki-cloud-download me-2 text-primary"></i>
                AG Grid - Server-Side Data Model
            </h3>
            <button class="btn btn-sm btn-light showcase-toggle-code" data-toggle-code="#code-aggrid-server-side">
                Show Code
            </button>
        </div>
        <div class="showcase-section-body">
            <div class="alert alert-info mb-5">
                <i class="ki-outline ki-information-5 me-2"></i>
                <strong>Server-Side Row Model:</strong> Ideal for large datasets (100k+ rows). Data is fetched from the server on demand with sorting, filtering, and pagination handled server-side.
            </div>

            {{-- Server-Side Mock Demo --}}
            <div class="showcase-example">
                <div class="showcase-example-header">
                    <h4>Server-Side Data (Simulated)</h4>
                    <p class="text-muted mb-0">
                        This demo simulates server-side behavior using a JavaScript mock. In production, data would be fetched from your API endpoint.
                        <br><small>Try sorting, filtering, or changing pages to see server requests in the console.</small>
                    </p>
                </div>
                <div class="showcase-example-preview">
                    <div id="aggrid-server-side-demo-wrapper">
                        <x-table.aggrid.base
                            id="aggrid-server-side-demo"
                            :columns="[
                                ['key' => 'id', 'label' => 'ID', 'width' => 80, 'sortable' => true, 'filter' => 'number'],
                                ['key' => 'name', 'label' => 'Name', 'flex' => 1, 'sortable' => true, 'filter' => 'text'],
                                ['key' => 'email', 'label' => 'Email', 'flex' => 1, 'filter' => 'text'],
                                ['key' => 'department', 'label' => 'Department', 'width' => 150, 'sortable' => true, 'filter' => 'text'],
                                ['key' => 'salary', 'label' => 'Salary', 'width' => 120, 'render' => 'currency', 'sortable' => true, 'filter' => 'number'],
                                ['key' => 'status', 'label' => 'Status', 'width' => 100, 'render' => 'badge', 'colors' => ['active' => 'success', 'inactive' => 'danger']],
                            ]"
                            ajax-url="/api/mock/server-side-users"
                            :server-side="true"
                            :pagination="true"
                            :page-size="10"
                            :page-size-options="[10, 25, 50]"
                            :filterable="true"
                            :floating-filter="true"
                            :sortable="true"
                            on-server-request="logServerRequest"
                            on-server-response="logServerResponse"
                            height="400px"
                        />
                    </div>
                    <div class="mt-3">
                        <button class="btn btn-sm btn-light-primary" onclick="GeoGrid.refresh('aggrid-server-side-demo')">
                            <i class="ki-outline ki-arrows-circle me-1"></i>
                            Refresh Data
                        </button>
                        <button class="btn btn-sm btn-light-warning" onclick="GeoGrid.purgeServerSideCache('aggrid-server-side-demo')">
                            <i class="ki-outline ki-trash me-1"></i>
                            Purge Cache
                        </button>
                    </div>
                </div>
            </div>

            {{-- Infinite Scroll Demo --}}
            <div class="showcase-example mt-10">
                <div class="showcase-example-header">
                    <h4>Infinite Scroll Mode</h4>
                    <p class="text-muted mb-0">
                        Alternative to pagination - rows load automatically as user scrolls. Better for continuous browsing.
                    </p>
                </div>
                <div class="showcase-example-preview">
                    <x-table.aggrid.base
                        id="aggrid-infinite-demo"
                        :columns="[
                            ['key' => 'id', 'label' => 'ID', 'width' => 80],
                            ['key' => 'name', 'label' => 'Name', 'flex' => 1],
                            ['key' => 'email', 'label' => 'Email', 'flex' => 1],
                            ['key' => 'created_at', 'label' => 'Created', 'width' => 150, 'render' => 'date'],
                        ]"
                        ajax-url="/api/mock/infinite-users"
                        :server-side="true"
                        :server-side-infinite="true"
                        :cache-block-size="50"
                        :sortable="true"
                        height="350px"
                    />
                    <p class="text-muted mt-2 small">
                        <i class="ki-outline ki-information me-1"></i>
                        Scroll down to load more rows. Data loads in blocks of 50.
                    </p>
                </div>
            </div>
        </div>

        <div id="code-aggrid-server-side" class="showcase-code-wrapper">
            <div class="showcase-code-header">
                <span class="showcase-code-label">Blade Usage</span>
            </div>
            <pre class="showcase-code">&lt;!-- Server-Side with Pagination --&gt;
&lt;x-table.aggrid.base
    id="users-grid"
    :columns="[
        ['key' => 'id', 'label' => 'ID', 'sortable' => true, 'filter' => 'number'],
        ['key' => 'name', 'label' => 'Name', 'sortable' => true, 'filter' => 'text'],
        ['key' => 'email', 'label' => 'Email', 'filter' => 'text'],
        ['key' => 'salary', 'label' => 'Salary', 'render' => 'currency', 'filter' => 'number'],
    ]"
    ajax-url="/api/users"
    :server-side="true"
    :pagination="true"
    :page-size="25"
    :filterable="true"
    :floating-filter="true"
    :sortable="true"
/&gt;

&lt;!-- Infinite Scroll Mode --&gt;
&lt;x-table.aggrid.base
    :columns="$columns"
    ajax-url="/api/users"
    :server-side="true"
    :server-side-infinite="true"
    :cache-block-size="50"
/&gt;

&lt;!-- API Response Format --&gt;
{
    "data": [
        {"id": 1, "name": "John", "email": "john@example.com", "salary": 75000},
        ...
    ],
    "total": 10000
}

&lt;!-- Query params sent to server: --&gt;
?page=1&amp;per_page=25&amp;sort_by=name&amp;sort_dir=asc&amp;filters={"name":{"type":"contains","value":"john"}}

&lt;!-- Laravel Controller Example --&gt;
public function index(Request $request)
{
    $query = User::query();

    // Apply filters
    if ($filters = $request-&gt;input('filters')) {
        $filters = is_string($filters) ? json_decode($filters, true) : $filters;
        foreach ($filters as $field =&gt; $filter) {
            match ($filter['type']) {
                'contains' =&gt; $query-&gt;where($field, 'like', '%' . $filter['value'] . '%'),
                'equals' =&gt; $query-&gt;where($field, $filter['value']),
                default =&gt; null,
            };
        }
    }

    // Apply sorting
    if ($sortBy = $request-&gt;input('sort_by')) {
        $query-&gt;orderBy($sortBy, $request-&gt;input('sort_dir', 'asc'));
    }

    // Paginate
    $paginated = $query-&gt;paginate($request-&gt;input('per_page', 25));

    return response()-&gt;json([
        'data' =&gt; $paginated-&gt;items(),
        'total' =&gt; $paginated-&gt;total(),
    ]);
}</pre>
        </div>
    </section>

    {{-- ================================================================== --}}
    {{-- AG GRID - INLINE CELL EDITING                                      --}}
    {{-- ================================================================== --}}

    <section id="aggrid-editing" class="showcase-section">
        <div class="showcase-section-header">
            <h3 class="showcase-section-title">
                <i class="ki-outline ki-pencil me-2 text-success"></i>
                <span class="badge badge-success me-2">NEW</span>
                AG Grid - Inline Cell Editing
            </h3>
            <button class="btn btn-sm btn-light showcase-toggle-code" data-toggle-code="#code-aggrid-editing">
                Show Code
            </button>
        </div>
        <div class="showcase-section-body">
            <p class="text-muted mb-5">
                Edit cells directly in the grid. Double-click a cell to start editing.
                Supports text, number, select dropdown, textarea, and date editors with validation.
            </p>

            @php
                $editableProducts = [
                    ['id' => 1, 'name' => 'MacBook Pro', 'price' => 2499.00, 'stock' => 15, 'status' => 'active', 'notes' => 'Popular item'],
                    ['id' => 2, 'name' => 'iPhone 15', 'price' => 999.00, 'stock' => 50, 'status' => 'active', 'notes' => 'Best seller'],
                    ['id' => 3, 'name' => 'AirPods Pro', 'price' => 249.00, 'stock' => 0, 'status' => 'out_of_stock', 'notes' => 'Restock pending'],
                    ['id' => 4, 'name' => 'iPad Air', 'price' => 799.00, 'stock' => 25, 'status' => 'active', 'notes' => ''],
                    ['id' => 5, 'name' => 'Apple Watch', 'price' => 399.00, 'stock' => 30, 'status' => 'on_sale', 'notes' => '10% discount'],
                ];
            @endphp

            {{-- Basic Inline Editing --}}
            <div class="showcase-example">
                <div class="showcase-example-label">
                    Basic Inline Editing
                    <span class="badge badge-light-success">Double-click to edit</span>
                </div>
                <div class="showcase-example-preview">
                    <x-table.aggrid.base
                        id="demo-edit-basic"
                        :columns="[
                            ['key' => 'id', 'label' => 'ID', 'width' => 70, 'editable' => false],
                            ['key' => 'name', 'label' => 'Product Name', 'editor' => 'text'],
                            ['key' => 'price', 'label' => 'Price', 'editor' => 'number', 'min' => 0, 'precision' => 2],
                            ['key' => 'stock', 'label' => 'Stock', 'editor' => 'number', 'min' => 0, 'step' => 1],
                            ['key' => 'status', 'label' => 'Status', 'editor' => 'select', 'options' => ['active', 'out_of_stock', 'on_sale', 'discontinued']],
                        ]"
                        :data="$editableProducts"
                        :editable="true"
                        :sortable="true"
                        height="300px"
                        on-cell-value-changed="handleDemoCellChange"
                    />
                    <div class="mt-3">
                        <div id="demo-edit-log" class="bg-light p-3 rounded fs-7" style="max-height: 100px; overflow-y: auto;">
                            <em class="text-muted">Edit log will appear here...</em>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Full Row Editing --}}
            <div class="showcase-example">
                <div class="showcase-example-label">
                    Full Row Editing Mode
                    <span class="badge badge-light-info">Edit entire row at once</span>
                </div>
                <div class="showcase-example-preview">
                    <x-table.aggrid.base
                        id="demo-edit-fullrow"
                        :columns="[
                            ['key' => 'id', 'label' => 'ID', 'width' => 70, 'editable' => false],
                            ['key' => 'name', 'label' => 'Product Name', 'editor' => 'text'],
                            ['key' => 'price', 'label' => 'Price ($)', 'editor' => 'number', 'min' => 0],
                            ['key' => 'stock', 'label' => 'Stock', 'editor' => 'number', 'min' => 0],
                            ['key' => 'notes', 'label' => 'Notes', 'editor' => 'textarea', 'maxLength' => 200, 'rows' => 3],
                        ]"
                        :data="$editableProducts"
                        :editable="true"
                        edit-type="fullRow"
                        height="300px"
                        on-row-value-changed="handleDemoRowChange"
                    />
                    <div class="mt-3 d-flex gap-2">
                        <button class="btn btn-sm btn-light-warning" onclick="GeoGrid.stopEditing('demo-edit-fullrow', true)">
                            <i class="ki-outline ki-cross me-1"></i> Cancel Editing
                        </button>
                        <button class="btn btn-sm btn-light-success" onclick="GeoGrid.stopEditing('demo-edit-fullrow', false)">
                            <i class="ki-outline ki-check me-1"></i> Save Changes
                        </button>
                    </div>
                </div>
            </div>

            {{-- Editing with Undo/Redo --}}
            <div class="showcase-example">
                <div class="showcase-example-label">
                    Editing with Undo/Redo
                    <span class="badge badge-light-primary">Ctrl+Z / Ctrl+Y</span>
                </div>
                <div class="showcase-example-preview">
                    <x-table.aggrid.base
                        id="demo-edit-undo"
                        :columns="[
                            ['key' => 'id', 'label' => 'ID', 'width' => 70, 'editable' => false],
                            ['key' => 'name', 'label' => 'Product', 'editor' => 'text'],
                            ['key' => 'price', 'label' => 'Price', 'editor' => 'number', 'min' => 0],
                            ['key' => 'stock', 'label' => 'Stock', 'editor' => 'number'],
                        ]"
                        :data="$editableProducts"
                        :editable="true"
                        :undo-redo-cell-editing="true"
                        :undo-redo-cell-editing-limit="20"
                        height="250px"
                    />
                    <div class="mt-3 d-flex gap-2">
                        <button class="btn btn-sm btn-light-secondary" onclick="GeoGrid.undoCellEdit('demo-edit-undo')">
                            <i class="ki-outline ki-arrow-left me-1"></i> Undo
                        </button>
                        <button class="btn btn-sm btn-light-secondary" onclick="GeoGrid.redoCellEdit('demo-edit-undo')">
                            <i class="ki-outline ki-arrow-right me-1"></i> Redo
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Code Examples --}}
        <div id="code-aggrid-editing" class="showcase-code-wrapper">
            <div class="showcase-code-header">
                <span class="showcase-code-label">Blade Usage</span>
                <button class="showcase-code-copy">Copy</button>
            </div>
            <pre class="showcase-code">&lt;!-- Basic Inline Editing --&gt;
&lt;x-table.aggrid.base
    :columns="[
        ['key' => 'id', 'label' => 'ID', 'editable' => false], // Not editable
        ['key' => 'name', 'label' => 'Name', 'editor' => 'text'],
        ['key' => 'price', 'label' => 'Price', 'editor' => 'number', 'min' => 0, 'precision' => 2],
        ['key' => 'status', 'label' => 'Status', 'editor' => 'select', 'options' => ['active', 'inactive']],
        ['key' => 'notes', 'label' => 'Notes', 'editor' => 'textarea', 'maxLength' => 500],
    ]"
    :data="$products"
    :editable="true"
    on-cell-value-changed="handleCellChange"
/&gt;

&lt;!-- Full Row Editing Mode --&gt;
&lt;x-table.aggrid.base
    :columns="$columns"
    :data="$products"
    :editable="true"
    edit-type="fullRow"
    on-row-value-changed="handleRowChange"
/&gt;

&lt;!-- With Undo/Redo --&gt;
&lt;x-table.aggrid.base
    :columns="$columns"
    :data="$products"
    :editable="true"
    :undo-redo-cell-editing="true"
    :undo-redo-cell-editing-limit="20"
/&gt;

&lt;script&gt;
// Callback when cell value changes
function handleCellChange(event) {
    console.log('Cell changed:', {
        field: event.field,
        oldValue: event.oldValue,
        newValue: event.newValue,
        rowData: event.rowData
    });

    // Save to server
    fetch('/api/products/' + event.rowData.id, {
        method: 'PATCH',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ [event.field]: event.newValue })
    });
}

// JS API methods
GeoGrid.startEditing('grid-id', rowIndex, 'columnKey');
GeoGrid.stopEditing('grid-id', cancel);
GeoGrid.undoCellEdit('grid-id');
GeoGrid.redoCellEdit('grid-id');
GeoGrid.updateCellValue('grid-id', rowKey, 'columnKey', newValue);
&lt;/script&gt;</pre>
        </div>
    </section>

    {{-- ================================================================== --}}
    {{-- AG GRID - ROW DRAGGING                                             --}}
    {{-- ================================================================== --}}

    <section id="aggrid-row-dragging" class="showcase-section">
        <div class="showcase-section-header">
            <h3 class="showcase-section-title">
                <i class="ki-outline ki-arrow-up-down me-2 text-success"></i>
                <span class="badge badge-success me-2">NEW</span>
                AG Grid - Row Dragging
            </h3>
            <button class="btn btn-sm btn-light showcase-toggle-code" data-toggle-code="#code-aggrid-dragging">
                Show Code
            </button>
        </div>
        <div class="showcase-section-body">
            <p class="text-muted mb-5">
                Reorder rows by dragging. Supports drag handle column or full row dragging.
                Get the new order via callback or API for saving to server.
            </p>

            @php
                $draggableItems = [
                    ['id' => 1, 'order' => 1, 'task' => 'Review pull requests', 'priority' => 'high', 'assignee' => 'John'],
                    ['id' => 2, 'order' => 2, 'task' => 'Write documentation', 'priority' => 'medium', 'assignee' => 'Jane'],
                    ['id' => 3, 'order' => 3, 'task' => 'Fix bug #123', 'priority' => 'high', 'assignee' => 'Bob'],
                    ['id' => 4, 'order' => 4, 'task' => 'Deploy to staging', 'priority' => 'low', 'assignee' => 'Alice'],
                    ['id' => 5, 'order' => 5, 'task' => 'Team meeting', 'priority' => 'medium', 'assignee' => 'John'],
                ];
            @endphp

            {{-- Basic Row Dragging with Handle --}}
            <div class="showcase-example">
                <div class="showcase-example-label">
                    Row Dragging with Handle
                    <span class="badge badge-light-info">Drag the ⋮⋮ handle</span>
                </div>
                <div class="showcase-example-preview">
                    <x-table.aggrid.base
                        id="demo-drag-handle"
                        :columns="[
                            ['key' => 'order', 'label' => '#', 'width' => 60],
                            ['key' => 'task', 'label' => 'Task'],
                            ['key' => 'priority', 'label' => 'Priority', 'render' => 'badge', 'colors' => ['high' => 'danger', 'medium' => 'warning', 'low' => 'info']],
                            ['key' => 'assignee', 'label' => 'Assignee'],
                        ]"
                        :data="$draggableItems"
                        :row-draggable="true"
                        :row-drag-managed="true"
                        height="300px"
                        on-row-drag-end="handleDemoRowDrag"
                    />
                    <div class="mt-3 d-flex gap-2 flex-wrap">
                        <button class="btn btn-sm btn-light-primary" onclick="showDemoRowOrder('demo-drag-handle')">
                            <i class="ki-outline ki-information-5 me-1"></i> Get Row Order
                        </button>
                        <button class="btn btn-sm btn-light-warning" onclick="GeoGrid.resetRowOrder('demo-drag-handle')">
                            <i class="ki-outline ki-arrows-loop me-1"></i> Reset Order
                        </button>
                    </div>
                    <div id="demo-drag-order" class="mt-3 bg-light p-3 rounded fs-7" style="display: none;">
                    </div>
                </div>
            </div>

            {{-- Full Row Dragging --}}
            <div class="showcase-example">
                <div class="showcase-example-label">
                    Full Row Dragging
                    <span class="badge badge-light-success">Drag from anywhere on the row</span>
                </div>
                <div class="showcase-example-preview">
                    <x-table.aggrid.base
                        id="demo-drag-fullrow"
                        :columns="[
                            ['key' => 'order', 'label' => '#', 'width' => 60],
                            ['key' => 'task', 'label' => 'Task'],
                            ['key' => 'priority', 'label' => 'Priority'],
                            ['key' => 'assignee', 'label' => 'Assignee'],
                        ]"
                        :data="$draggableItems"
                        :row-draggable="true"
                        :row-drag-entire-row="true"
                        :row-drag-managed="true"
                        height="280px"
                    />
                </div>
            </div>

            {{-- Row Dragging with Selection --}}
            <div class="showcase-example">
                <div class="showcase-example-label">
                    Drag Multiple Selected Rows
                    <span class="badge badge-light-primary">Select rows, then drag together</span>
                </div>
                <div class="showcase-example-preview">
                    <x-table.aggrid.base
                        id="demo-drag-multi"
                        :columns="[
                            ['key' => 'order', 'label' => '#', 'width' => 60],
                            ['key' => 'task', 'label' => 'Task'],
                            ['key' => 'priority', 'label' => 'Priority'],
                        ]"
                        :data="$draggableItems"
                        :row-draggable="true"
                        :row-drag-managed="true"
                        :row-drag-multi-row="true"
                        :selectable="true"
                        selection-mode="multiple"
                        height="280px"
                    />
                </div>
            </div>
        </div>

        {{-- Code Examples --}}
        <div id="code-aggrid-dragging" class="showcase-code-wrapper">
            <div class="showcase-code-header">
                <span class="showcase-code-label">Blade Usage</span>
                <button class="showcase-code-copy">Copy</button>
            </div>
            <pre class="showcase-code">&lt;!-- Row Dragging with Handle Column --&gt;
&lt;x-table.aggrid.base
    :columns="$columns"
    :data="$tasks"
    :row-draggable="true"
    :row-drag-managed="true"
    on-row-drag-end="handleReorder"
/&gt;

&lt;!-- Full Row Dragging (drag from anywhere) --&gt;
&lt;x-table.aggrid.base
    :columns="$columns"
    :data="$tasks"
    :row-draggable="true"
    :row-drag-entire-row="true"
    :row-drag-managed="true"
/&gt;

&lt;!-- Drag Multiple Selected Rows --&gt;
&lt;x-table.aggrid.base
    :columns="$columns"
    :data="$tasks"
    :row-draggable="true"
    :row-drag-multi-row="true"
    :selectable="true"
    selection-mode="multiple"
/&gt;

&lt;script&gt;
// Callback when row drag ends
function handleReorder(event) {
    console.log('Dragged:', event.draggedData);
    console.log('New position:', event.overIndex);
    console.log('All rows in new order:', event.allRows);

    // Save new order to server
    const ids = event.allRows.map(row => row.id);
    fetch('/api/tasks/reorder', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ ids: ids })
    });
}

// JS API methods
const allRows = GeoGrid.getRowOrder('grid-id');      // Get all rows in current order
const ids = GeoGrid.getRowOrderIds('grid-id');       // Get just the IDs
GeoGrid.moveRow('grid-id', fromIndex, toIndex);      // Move row programmatically
GeoGrid.resetRowOrder('grid-id');                    // Reset to original order
&lt;/script&gt;</pre>
        </div>
    </section>

    {{-- ================================================================== --}}
    {{-- AG GRID - CONTEXT MENU                                            --}}
    {{-- ================================================================== --}}

    <section id="aggrid-context-menu" class="showcase-section">
        <div class="showcase-section-header">
            <h3 class="showcase-section-title">
                <i class="ki-outline ki-menu me-2 text-info"></i>
                <span class="badge badge-success me-2">NEW</span>
                AG Grid - Context Menu
            </h3>
            <button class="btn btn-sm btn-light showcase-toggle-code" data-toggle-code="#code-aggrid-context">
                Show Code
            </button>
        </div>
        <div class="showcase-section-body">
            <p class="text-muted mb-4">
                Right-click on rows to see a custom context menu with actions.
            </p>

            {{-- Basic Context Menu --}}
            <div class="showcase-example">
                <div class="showcase-example-label">
                    Basic Context Menu
                    <span class="badge badge-light-info">Right-click to test</span>
                </div>
                <div class="showcase-example-preview">
                    <x-table.aggrid.base
                        id="demo-context-basic"
                        :columns="[
                            ['key' => 'id', 'label' => 'ID', 'width' => 70],
                            ['key' => 'name', 'label' => 'Name'],
                            ['key' => 'email', 'label' => 'Email'],
                            ['key' => 'status', 'label' => 'Status', 'render' => 'badge', 'colors' => ['active' => 'success', 'inactive' => 'warning']],
                        ]"
                        :data="[
                            ['id' => 1, 'name' => 'John Smith', 'email' => 'john@example.com', 'status' => 'active'],
                            ['id' => 2, 'name' => 'Jane Doe', 'email' => 'jane@example.com', 'status' => 'active'],
                            ['id' => 3, 'name' => 'Bob Wilson', 'email' => 'bob@example.com', 'status' => 'inactive'],
                        ]"
                        :context-menu="true"
                        height="250px"
                    />
                </div>
            </div>

            {{-- Custom Context Menu Items --}}
            <div class="showcase-example">
                <div class="showcase-example-label">
                    Custom Menu Items
                    <span class="badge badge-light-primary">With icons & dividers</span>
                </div>
                <div class="showcase-example-preview">
                    <x-table.aggrid.base
                        id="demo-context-custom"
                        :columns="[
                            ['key' => 'id', 'label' => 'ID', 'width' => 70],
                            ['key' => 'task', 'label' => 'Task'],
                            ['key' => 'priority', 'label' => 'Priority', 'render' => 'badge', 'colors' => ['high' => 'danger', 'medium' => 'warning', 'low' => 'success']],
                            ['key' => 'assignee', 'label' => 'Assignee'],
                        ]"
                        :data="[
                            ['id' => 1, 'task' => 'Implement login', 'priority' => 'high', 'assignee' => 'John'],
                            ['id' => 2, 'task' => 'Design homepage', 'priority' => 'medium', 'assignee' => 'Jane'],
                            ['id' => 3, 'task' => 'Write documentation', 'priority' => 'low', 'assignee' => 'Bob'],
                        ]"
                        :context-menu="true"
                        :context-menu-items="[
                            ['action' => 'view', 'label' => 'View Task', 'icon' => 'eye'],
                            ['action' => 'edit', 'label' => 'Edit Task', 'icon' => 'pencil'],
                            ['action' => 'assign', 'label' => 'Reassign', 'icon' => 'user-tick'],
                            ['divider' => true],
                            ['header' => 'Priority'],
                            ['action' => 'priority-high', 'label' => 'Set High', 'icon' => 'arrow-up'],
                            ['action' => 'priority-low', 'label' => 'Set Low', 'icon' => 'arrow-down'],
                            ['divider' => true],
                            ['action' => 'delete', 'label' => 'Delete Task', 'icon' => 'trash', 'class' => 'danger'],
                        ]"
                        on-context-menu-action="handleDemoContextAction"
                        height="250px"
                    />
                    <div id="demo-context-log" class="mt-3 bg-light-info p-3 rounded fs-7">
                        <em class="text-muted">Right-click a row and select an action...</em>
                    </div>
                </div>
            </div>

            {{-- Context Menu with Callbacks --}}
            <div class="showcase-example">
                <div class="showcase-example-label">
                    Dynamic Menu Items
                    <span class="badge badge-light-warning">Runtime updates</span>
                </div>
                <div class="showcase-example-preview">
                    <div class="d-flex gap-3 mb-3">
                        <button class="btn btn-sm btn-light-primary" onclick="GeoGrid.setContextMenuItems('demo-context-dynamic', demoMenuItemsBasic)">
                            <i class="ki-outline ki-category me-1"></i> Basic Menu
                        </button>
                        <button class="btn btn-sm btn-light-info" onclick="GeoGrid.setContextMenuItems('demo-context-dynamic', demoMenuItemsExtended)">
                            <i class="ki-outline ki-add-files me-1"></i> Extended Menu
                        </button>
                    </div>
                    <x-table.aggrid.base
                        id="demo-context-dynamic"
                        :columns="[
                            ['key' => 'id', 'label' => 'ID', 'width' => 70],
                            ['key' => 'product', 'label' => 'Product'],
                            ['key' => 'price', 'label' => 'Price', 'render' => 'currency'],
                            ['key' => 'stock', 'label' => 'Stock'],
                        ]"
                        :data="[
                            ['id' => 101, 'product' => 'Laptop Pro', 'price' => 1299.99, 'stock' => 15],
                            ['id' => 102, 'product' => 'Wireless Mouse', 'price' => 49.99, 'stock' => 230],
                            ['id' => 103, 'product' => 'USB-C Hub', 'price' => 79.99, 'stock' => 0],
                        ]"
                        :context-menu="true"
                        :context-menu-items="[
                            ['action' => 'view', 'label' => 'View Product', 'icon' => 'eye'],
                            ['action' => 'edit', 'label' => 'Edit', 'icon' => 'pencil'],
                        ]"
                        on-context-menu-action="handleDemoContextAction"
                        height="220px"
                    />
                </div>
            </div>
        </div>

        {{-- Code Examples --}}
        <div id="code-aggrid-context" class="showcase-code-wrapper">
            <div class="showcase-code-header">
                <span class="showcase-code-label">Blade Usage</span>
                <button class="showcase-code-copy">Copy</button>
            </div>
            <pre class="showcase-code">&lt;!-- Basic Context Menu (uses default items) --&gt;
&lt;x-table.aggrid.base
    :columns="$columns"
    :data="$users"
    :context-menu="true"
/&gt;

&lt;!-- Custom Menu Items --&gt;
&lt;x-table.aggrid.base
    :columns="$columns"
    :data="$tasks"
    :context-menu="true"
    :context-menu-items="[
        ['action' => 'view', 'label' => 'View Details', 'icon' => 'eye'],
        ['action' => 'edit', 'label' => 'Edit', 'icon' => 'pencil'],
        ['divider' => true],
        ['header' => 'Actions'],
        ['action' => 'duplicate', 'label' => 'Duplicate', 'icon' => 'copy'],
        ['action' => 'archive', 'label' => 'Archive', 'icon' => 'archive'],
        ['divider' => true],
        ['action' => 'delete', 'label' => 'Delete', 'icon' => 'trash', 'class' => 'danger'],
    ]"
    on-context-menu-action="handleContextAction"
/&gt;

&lt;script&gt;
// Handle menu actions
function handleContextAction(event) {
    const { action, rowData, gridId, api } = event;

    switch (action) {
        case 'view':
            window.location.href = `/items/${rowData.id}`;
            break;
        case 'edit':
            openEditModal(rowData);
            break;
        case 'duplicate':
            api.applyTransaction({ add: [{ ...rowData, id: null }] });
            break;
        case 'delete':
            if (confirm('Delete this item?')) {
                api.applyTransaction({ remove: [rowData] });
            }
            break;
    }
}

// JS API methods
GeoGrid.showContextMenu('grid-id', rowData, x, y);   // Show menu programmatically
GeoGrid.hideContextMenu('grid-id');                   // Hide menu
GeoGrid.setContextMenuItems('grid-id', items);        // Update menu items dynamically
GeoGrid.getContextMenuItems('grid-id');               // Get current menu items
&lt;/script&gt;</pre>
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
            <button class="btn btn-sm btn-light showcase-toggle-code" data-toggle-code="#code-aggrid-features">
                Show Code
            </button>
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

        <div id="code-aggrid-features" class="showcase-code-wrapper">
            <div class="showcase-code-header">
                <span class="showcase-code-label">Blade Usage</span>
            </div>
            <pre class="showcase-code">&lt;!-- Column Pinning --&gt;
&lt;x-table.aggrid.base
    :columns="[
        ['key' => 'id', 'label' => 'ID', 'pinned' => 'left'],
        ['key' => 'name', 'label' => 'Name', 'pinned' => 'left'],
        ['key' => 'email', 'label' => 'Email'],
        ['key' => 'department', 'label' => 'Department'],
        // ... more scrollable columns ...
        ['key' => 'status', 'label' => 'Status', 'pinned' => 'right'],
    ]"
    :data="$users"
/&gt;

&lt;!-- AG Grid Themes --&gt;
&lt;x-table.aggrid.base
    :columns="$columns"
    :data="$users"
    theme="alpine"   {{-- Options: quartz (default), alpine, balham, material --}}
/&gt;

&lt;!-- State Persistence --&gt;
&lt;x-table.aggrid.base
    id="my-grid"
    :columns="$columns"
    :data="$users"
    :sortable="true"
    :resizable="true"
    :state-save="true"  {{-- Saves column state to localStorage --}}
/&gt;

&lt;!-- Reset saved state via JavaScript --&gt;
&lt;script&gt;
    localStorage.removeItem('geo-grid-state-my-grid');
    location.reload();
&lt;/script&gt;</pre>
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

    // ========================================
    // DATATABLE INLINE EDITING HANDLERS
    // ========================================

    /**
     * Called when a cell enters edit mode
     * @param {string} tableId - The table ID
     * @param {HTMLElement} cell - The cell element
     * @param {Object} rowData - The row data
     * @param {string} field - The field/column key
     * @param {*} currentValue - The current cell value
     */
    function handleCellEditStart(tableId, cell, rowData, field, currentValue) {
        console.log('%c[DataTable] Cell Edit Start', 'color: #3498db; font-weight: bold', {
            tableId,
            field,
            currentValue,
            rowId: rowData.id
        });
    }

    /**
     * Called when a cell edit is committed (Enter or blur)
     * @param {string} tableId - The table ID
     * @param {HTMLElement} cell - The cell element
     * @param {Object} rowData - The row data
     * @param {string} field - The field/column key
     * @param {*} oldValue - The previous value
     * @param {*} newValue - The new value
     * @returns {boolean} Return false to prevent the change
     */
    function handleCellEditCommit(tableId, cell, rowData, field, oldValue, newValue) {
        console.log('%c[DataTable] Cell Edit Commit', 'color: #27ae60; font-weight: bold', {
            tableId,
            field,
            oldValue,
            newValue,
            rowId: rowData.id
        });

        // Example: Validate the change
        // if (field === 'name' && newValue.trim() === '') {
        //     alert('Name cannot be empty');
        //     return false; // Prevent the change
        // }

        // Example: Send to server
        // fetch(`/api/users/${rowData.id}`, {
        //     method: 'PATCH',
        //     body: JSON.stringify({ [field]: newValue })
        // });

        return true; // Allow the change
    }

    // ========================================
    // DATATABLE ROW REORDER HANDLER
    // ========================================

    /**
     * Called when rows are reordered via drag & drop
     * @param {string} tableId - The table ID
     * @param {Array} newOrder - Array of row data in new order
     * @param {number} fromIndex - Original index of dragged row
     * @param {number} toIndex - New index of dragged row
     */
    function handleRowReorder(tableId, newOrder, fromIndex, toIndex) {
        console.log('%c[DataTable] Row Reorder', 'color: #9b59b6; font-weight: bold', {
            tableId,
            fromIndex,
            toIndex,
            newOrderIds: newOrder.map(row => row.id || row.priority)
        });

        // Example: Send new order to server
        // const orderedIds = newOrder.map(row => row.id);
        // fetch('/api/tasks/reorder', {
        //     method: 'POST',
        //     body: JSON.stringify({ order: orderedIds })
        // });
    }

    // Demo handler for AG Grid selection
    function handleAgGridSelection(selectedRows, params) {
        console.log('AG Grid Selection:', selectedRows);
        console.log('Selected count:', selectedRows.length);
    }

    // Server-side demo request/response logging
    function logServerRequest(params, request) {
        console.log('%c[Server-Side Request]', 'color: #3498db; font-weight: bold', params);
    }

    function logServerResponse(response) {
        console.log('%c[Server-Side Response]', 'color: #27ae60; font-weight: bold', {
            rowCount: response.total || response.data?.length,
            data: response.data?.slice(0, 2) // Show first 2 rows
        });
    }

    // ========================================
    // INLINE EDITING DEMO HANDLERS
    // ========================================

    function handleDemoCellChange(event) {
        const log = document.getElementById('demo-edit-log');
        const entry = document.createElement('div');
        entry.innerHTML = `<span class="text-success">✓</span> <strong>${event.field}</strong>: "${event.oldValue}" → "${event.newValue}" <small class="text-muted">(Row ${event.rowIndex})</small>`;
        log.prepend(entry);

        // Remove the placeholder text if it exists
        const placeholder = log.querySelector('em');
        if (placeholder) placeholder.remove();

        console.log('Cell changed:', event);
    }

    function handleDemoRowChange(event) {
        console.log('Row edit completed:', event.rowData);
        alert('Row saved: ' + JSON.stringify(event.rowData, null, 2));
    }

    // ========================================
    // ROW DRAGGING DEMO HANDLERS
    // ========================================

    function handleDemoRowDrag(event) {
        console.log('Row drag ended:', {
            draggedData: event.draggedData,
            newIndex: event.overIndex,
            allRows: event.allRows
        });
    }

    function showDemoRowOrder(gridId) {
        const ids = GeoGrid.getRowOrderIds(gridId);
        const orderDiv = document.getElementById('demo-drag-order');
        orderDiv.style.display = 'block';
        orderDiv.innerHTML = '<strong>Current Order (IDs):</strong> ' + ids.join(' → ');
    }

    // ========================================
    // CONTEXT MENU DEMO HANDLERS
    // ========================================

    function handleDemoContextAction(event) {
        const log = document.getElementById('demo-context-log');
        const placeholder = log.querySelector('em');
        if (placeholder) placeholder.remove();

        const entry = document.createElement('div');
        entry.className = 'mb-1';
        entry.innerHTML = `<strong>${event.action}</strong>: ${JSON.stringify(event.rowData)}`;
        log.appendChild(entry);

        console.log('Context menu action:', event);
    }

    // Menu item sets for dynamic demo
    const demoMenuItemsBasic = [
        { action: 'view', label: 'View Product', icon: 'eye' },
        { action: 'edit', label: 'Edit', icon: 'pencil' },
    ];

    const demoMenuItemsExtended = [
        { action: 'view', label: 'View Product', icon: 'eye' },
        { action: 'edit', label: 'Edit', icon: 'pencil' },
        { divider: true },
        { header: 'Inventory' },
        { action: 'restock', label: 'Restock', icon: 'plus-circle' },
        { action: 'adjust', label: 'Adjust Stock', icon: 'setting-2' },
        { divider: true },
        { action: 'export', label: 'Export to CSV', icon: 'exit-down' },
        { action: 'delete', label: 'Delete Product', icon: 'trash', class: 'danger' },
    ];

    // Mock server-side API endpoint
    // In production, this would be handled by your actual backend
    (function() {
        // Generate mock data
        const departments = ['Engineering', 'Marketing', 'Sales', 'HR', 'Finance', 'Operations'];
        const statuses = ['active', 'inactive'];
        const mockUsers = [];

        for (let i = 1; i <= 500; i++) {
            mockUsers.push({
                id: i,
                name: `User ${i}`,
                email: `user${i}@example.com`,
                department: departments[Math.floor(Math.random() * departments.length)],
                salary: Math.floor(Math.random() * 100000) + 40000,
                status: statuses[Math.floor(Math.random() * statuses.length)],
                created_at: new Date(Date.now() - Math.random() * 365 * 24 * 60 * 60 * 1000).toISOString()
            });
        }

        // Intercept fetch for mock endpoints
        const originalFetch = window.fetch;
        window.fetch = function(url, options) {
            const urlObj = new URL(url, window.location.origin);

            // Mock server-side endpoint
            if (urlObj.pathname === '/api/mock/server-side-users') {
                return handleMockServerSide(urlObj, mockUsers);
            }

            // Mock infinite scroll endpoint
            if (urlObj.pathname === '/api/mock/infinite-users') {
                return handleMockInfinite(urlObj, mockUsers);
            }

            // Pass through to original fetch
            return originalFetch.apply(this, arguments);
        };

        function handleMockServerSide(urlObj, data) {
            return new Promise(resolve => {
                // Simulate network delay
                setTimeout(() => {
                    let filtered = [...data];

                    // Apply filters
                    const filtersParam = urlObj.searchParams.get('filters');
                    if (filtersParam) {
                        const filters = JSON.parse(filtersParam);
                        Object.entries(filters).forEach(([field, filter]) => {
                            filtered = filtered.filter(row => {
                                const value = row[field];
                                if (filter.type === 'contains') {
                                    return String(value).toLowerCase().includes(filter.value.toLowerCase());
                                }
                                if (filter.type === 'equals') {
                                    return value == filter.value;
                                }
                                if (filter.type === 'greaterThan') {
                                    return value > filter.value;
                                }
                                if (filter.type === 'lessThan') {
                                    return value < filter.value;
                                }
                                return true;
                            });
                        });
                    }

                    // Apply sorting
                    const sortBy = urlObj.searchParams.get('sort_by');
                    const sortDir = urlObj.searchParams.get('sort_dir') || 'asc';
                    if (sortBy) {
                        filtered.sort((a, b) => {
                            let aVal = a[sortBy];
                            let bVal = b[sortBy];
                            if (typeof aVal === 'string') {
                                aVal = aVal.toLowerCase();
                                bVal = bVal.toLowerCase();
                            }
                            if (aVal < bVal) return sortDir === 'asc' ? -1 : 1;
                            if (aVal > bVal) return sortDir === 'asc' ? 1 : -1;
                            return 0;
                        });
                    }

                    // Paginate
                    const start = parseInt(urlObj.searchParams.get('start') || '0');
                    const limit = parseInt(urlObj.searchParams.get('limit') || '25');
                    const paginated = filtered.slice(start, start + limit);

                    resolve(new Response(JSON.stringify({
                        data: paginated,
                        total: filtered.length
                    }), {
                        status: 200,
                        headers: { 'Content-Type': 'application/json' }
                    }));
                }, 300); // 300ms simulated delay
            });
        }

        function handleMockInfinite(urlObj, data) {
            return new Promise(resolve => {
                setTimeout(() => {
                    const start = parseInt(urlObj.searchParams.get('start') || '0');
                    const limit = parseInt(urlObj.searchParams.get('limit') || '50');

                    const paginated = data.slice(start, start + limit);

                    resolve(new Response(JSON.stringify({
                        data: paginated,
                        total: data.length
                    }), {
                        status: 200,
                        headers: { 'Content-Type': 'application/json' }
                    }));
                }, 200);
            });
        }
    })();

    // ========================================
    // Showcase Code Panel Functionality
    // ========================================
    (function() {
        // Code Panel Elements
        const codePanel = document.getElementById('codePanel');
        const codeBackdrop = document.getElementById('codeBackdrop');
        const codePanelContent = document.getElementById('codePanelContent');
        const codePanelTitle = document.getElementById('codePanelTitle');
        const codePanelCopy = document.getElementById('codePanelCopy');
        const codePanelClose = document.getElementById('codePanelClose');
        let activeCodeButton = null;

        // Open code panel
        function openCodePanel(codeContent, title) {
            codePanelContent.textContent = codeContent;
            codePanelTitle.textContent = title || 'Blade Usage';
            codePanel.classList.add('open');
            codeBackdrop.classList.add('open');
            document.body.style.overflow = 'hidden';
        }

        // Close code panel
        function closeCodePanel() {
            codePanel.classList.remove('open');
            codeBackdrop.classList.remove('open');
            document.body.style.overflow = '';

            // Remove active state from button
            if (activeCodeButton) {
                activeCodeButton.classList.remove('active');
                activeCodeButton.innerHTML = '<i class="ki-outline ki-code"></i> Show Code';
                activeCodeButton = null;
            }
        }

        // Toggle code visibility (new slide-out behavior)
        document.querySelectorAll('[data-toggle-code]').forEach(function(btn) {
            // Update button HTML to include icon
            if (!btn.querySelector('i')) {
                btn.innerHTML = '<i class="ki-outline ki-code"></i> Show Code';
            }

            btn.addEventListener('click', function() {
                var targetId = this.dataset.toggleCode;
                var target = document.querySelector(targetId);

                if (target) {
                    // If this button is already active, close the panel
                    if (this.classList.contains('active')) {
                        closeCodePanel();
                        return;
                    }

                    // Close any other active button
                    if (activeCodeButton && activeCodeButton !== this) {
                        activeCodeButton.classList.remove('active');
                        activeCodeButton.innerHTML = '<i class="ki-outline ki-code"></i> Show Code';
                    }

                    // Get code content
                    var codeBlock = target.querySelector('.showcase-code');
                    var codeLabel = target.querySelector('.showcase-code-label');
                    var title = codeLabel ? codeLabel.textContent : 'Blade Usage';
                    var codeContent = codeBlock ? codeBlock.textContent : '';

                    // Update button state
                    this.classList.add('active');
                    this.innerHTML = '<i class="ki-outline ki-eye-slash"></i> Hide Code';
                    activeCodeButton = this;

                    // Open panel
                    openCodePanel(codeContent, title);
                }
            });
        });

        // Close panel events
        if (codePanelClose) {
            codePanelClose.addEventListener('click', closeCodePanel);
        }
        if (codeBackdrop) {
            codeBackdrop.addEventListener('click', closeCodePanel);
        }

        // Close on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && codePanel && codePanel.classList.contains('open')) {
                closeCodePanel();
            }
        });

        // Copy code to clipboard
        if (codePanelCopy) {
            codePanelCopy.addEventListener('click', function() {
                var codeContent = codePanelContent.textContent;
                navigator.clipboard.writeText(codeContent).then(function() {
                    codePanelCopy.innerHTML = '<i class="ki-outline ki-check"></i> Copied!';
                    setTimeout(function() {
                        codePanelCopy.innerHTML = '<i class="ki-outline ki-copy"></i> Copy';
                    }, 2000);
                });
            });
        }
    })();
</script>
@endpush
