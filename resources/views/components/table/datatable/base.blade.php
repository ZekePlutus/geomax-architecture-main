{{--
    ================================================================================
    GENERIC DATATABLE COMPONENT - FOUNDATION LAYER
    ================================================================================

    A highly flexible, configuration-driven data table component designed for
    multi-tenant SaaS applications. This component is part of the global UI layer
    and contains NO business logic or module-specific assumptions.

    DESIGN PRINCIPLES:
    - Configuration over convention
    - Progressive enhancement (works without JS)
    - Every feature is opt-in
    - Abstract column definitions (not DataTables-specific)
    - Future-proof for alternative implementations (AG Grid, etc.)

    ================================================================================
    USAGE EXAMPLES
    ================================================================================

    1. SIMPLE STATIC TABLE (No JavaScript)
    --------------------------------------
    <x-table.datatable.base
        :columns="[
            ['key' => 'name', 'label' => 'Name'],
            ['key' => 'email', 'label' => 'Email'],
            ['key' => 'status', 'label' => 'Status'],
        ]"
        :data="$users"
    />

    2. SERVER-SIDE DATATABLE
    ------------------------
    <x-table.datatable.base
        id="users-table"
        :columns="[
            ['key' => 'id', 'label' => 'ID', 'sortable' => true],
            ['key' => 'name', 'label' => 'Name', 'sortable' => true, 'searchable' => true],
            ['key' => 'email', 'label' => 'Email', 'searchable' => true],
            ['key' => 'created_at', 'label' => 'Created', 'sortable' => true],
        ]"
        ajax-url="/api/users"
        :server-side="true"
        :datatable="true"
        :pagination="true"
        :searchable="true"
    />

    3. TABLE WITH CUSTOM CELL RENDERING (Slots)
    -------------------------------------------
    <x-table.datatable.base
        :columns="[
            ['key' => 'name', 'label' => 'Name'],
            ['key' => 'status', 'label' => 'Status'],
            ['key' => 'avatar', 'label' => 'Avatar'],
        ]"
        :data="$users"
    >
        <x-slot:cell-status="['row' => $row, 'value' => $value]">
            <span class="badge badge-{{ $value === 'active' ? 'success' : 'danger' }}">
                {{ ucfirst($value) }}
            </span>
        </x-slot:cell-status>

        <x-slot:cell-avatar="['row' => $row]">
            <img src="{{ $row['avatar'] }}" class="w-35px h-35px rounded" />
        </x-slot:cell-avatar>
    </x-table.datatable.base>

    4. TABLE WITH ACTIONS COLUMN
    ----------------------------
    <x-table.datatable.base
        :columns="[
            ['key' => 'name', 'label' => 'Name'],
            ['key' => 'email', 'label' => 'Email'],
        ]"
        :data="$users"
        :show-actions="true"
        row-key="id"
    >
        <x-slot:actions="['row' => $row]">
            <a href="#" class="btn btn-sm btn-light btn-active-light-primary">Edit</a>
            <button class="btn btn-sm btn-light btn-active-light-danger">Delete</button>
        </x-slot:actions>
    </x-table.datatable.base>

    5. TABLE WITH TOOLBAR (Filters/Buttons)
    ---------------------------------------
    <x-table.datatable.base
        :columns="$columns"
        :data="$users"
        :datatable="true"
    >
        <x-slot:toolbar>
            <div class="d-flex gap-3">
                <select class="form-select form-select-sm" data-table-filter="status">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
                <button class="btn btn-sm btn-primary" data-table-action="export">
                    Export
                </button>
            </div>
        </x-slot:toolbar>
    </x-table.datatable.base>

    6. TABLE WITH ROW SELECTION (Checkboxes)
    ----------------------------------------
    <x-table.datatable.base
        :columns="$columns"
        :data="$users"
        :selectable="true"
        row-key="id"
        on-selection-change="handleSelectionChange"
    />

    7. TABLE WITH ROW INDEX
    -----------------------
    <x-table.datatable.base
        :columns="$columns"
        :data="$users"
        :show-index="true"
        index-label="#"
    />

    8. DEFERRED LOADING TABLE
    -------------------------
    <x-table.datatable.base
        id="lazy-table"
        :columns="$columns"
        ajax-url="/api/large-dataset"
        :datatable="true"
        :defer-loading="true"
    />
    <!-- Later trigger: window.GeoTable.reload('lazy-table') -->

    9. TABLE WITH BULK ACTIONS
    --------------------------
    <x-table.datatable.base
        :columns="$columns"
        :data="$users"
        :selectable="true"
        :bulk-actions="[
            ['key' => 'delete', 'label' => 'Delete', 'icon' => 'ki-outline ki-trash', 'class' => 'btn-light-danger', 'confirm' => 'Delete selected?'],
            ['key' => 'export', 'label' => 'Export', 'icon' => 'ki-outline ki-file-down', 'class' => 'btn-light-primary'],
        ]"
        on-bulk-action="handleBulkAction"
        row-key="id"
    />

    10. TABLE WITH COLUMN VISIBILITY TOGGLE
    ---------------------------------------
    <x-table.datatable.base
        :columns="$columns"
        :data="$users"
        :datatable="true"
        :show-column-toggle="true"
        :hidden-columns="['created_at']"
    />

    11. TABLE WITH COLUMN REORDERING (Drag & Drop)
    ----------------------------------------------
    <x-table.datatable.base
        :columns="$columns"
        :data="$users"
        :datatable="true"
        :column-reorderable="true"
        :state-save="true"
    />
    <!-- JS API: GeoTable.getColumnOrder(id), GeoTable.setColumnOrder(id, ['col1', 'col2']), GeoTable.resetColumnOrder(id) -->

    12. TABLE WITH EXPANDABLE ROW DETAILS
    -------------------------------------
    Click on any row to expand and see more details:
    <x-table.datatable.base
        :columns="[
            ['key' => 'name', 'label' => 'Name'],
            ['key' => 'email', 'label' => 'Email'],
        ]"
        :data="$users"
        :row-details="true"
        row-key="id"
    />

    With specific columns in details:
    <x-table.datatable.base
        :columns="[
            ['key' => 'name', 'label' => 'Name'],
            ['key' => 'email', 'label' => 'Email'],
        ]"
        :data="$users"
        :row-details="true"
        :row-details-columns="[
            ['key' => 'phone', 'label' => 'Phone Number'],
            ['key' => 'address', 'label' => 'Address'],
            ['key' => 'created_at', 'label' => 'Created Date'],
        ]"
        row-key="id"
    />

    With callbacks:
    <x-table.datatable.base
        :columns="$columns"
        :data="$users"
        :row-details="true"
        on-row-expand="handleRowExpand"
        on-row-collapse="handleRowCollapse"
    />
    <!-- JS: function handleRowExpand(rowData, rowElement, detailsElement) { console.log('Expanded:', rowData); } -->

    JS API:
    - GeoTable.expandRow(tableId, rowKey)
    - GeoTable.collapseRow(tableId, rowKey)
    - GeoTable.toggleRow(tableId, rowKey)
    - GeoTable.collapseAllRows(tableId)

    ================================================================================
    RTL / LOCALE SUPPORT
    ================================================================================

    AUTO-DETECT RTL (from HTML dir attribute):
    -----------------------------------------
    If your page has <html dir="rtl">, the table automatically enables RTL mode.

    FORCE RTL MODE:
    ---------------
    <x-table.datatable.base
        :columns="$columns"
        :data="$users"
        :rtl="true"
        locale="ar"
        :datatable="true"
    />

    ARABIC WITH ALL FEATURES:
    -------------------------
    <x-table.datatable.base
        :columns="[
            ['key' => 'name', 'label' => 'الاسم'],
            ['key' => 'email', 'label' => 'البريد الإلكتروني'],
        ]"
        :data="$users"
        :rtl="true"
        locale="ar"
        :datatable="true"
        :pagination="true"
        :searchable="true"
    />

    SUPPORTED LOCALES:
    - ar (Arabic) - Full translation
    - he (Hebrew) - Full translation
    - fa (Farsi/Persian) - Full translation
    - fr (French) - Full translation
    - Default: English (en)

    ================================================================================
    COLUMN DEFINITION SCHEMA (Abstract - Not DataTables Specific)
    ================================================================================

    Each column in the columns array supports:

    [
        'key'         => 'field_name',      // Required: data field key
        'label'       => 'Display Name',    // Required: column header
        'sortable'    => true|false,        // Optional: enable sorting (default: false)
        'searchable'  => true|false,        // Optional: include in search (default: false)
        'visible'     => true|false,        // Optional: show/hide column (default: true)
        'width'       => '100px'|'10%',     // Optional: column width
        'class'       => 'text-center',     // Optional: cell CSS class
        'headerClass' => 'bg-light',        // Optional: header CSS class
        'orderable'   => true|false,        // Optional: alias for sortable
        'render'      => 'date|currency|badge', // Optional: built-in renderers (see list below)
        'view'        => 'path.to.blade',   // Optional: custom view partial for cell rendering
        'format'      => 'Y-m-d',           // Optional: format parameter for render

        // Renderer-specific options:
        'symbol'      => '$',               // For currency renderer
        'decimals'    => 2,                 // For currency, number, percent renderers
        'prefix'      => '',                // For number renderer
        'suffix'      => '',                // For number renderer
        'colors'      => [],                // For badge renderer: ['value' => 'color']
        'statuses'    => [],                // For status renderer: ['key' => ['label' => '', 'color' => '']]
        'yes'         => 'Yes',             // For yesno renderer
        'no'          => 'No',              // For yesno renderer
        'imageWidth'  => '40px',            // For image renderer
        'imageHeight' => '40px',            // For image renderer
        'size'        => '35px',            // For avatar renderer
        'nameField'   => 'name',            // For avatar renderer (field to generate initials from)
        'url'         => '/path/{id}',      // For link renderer (supports placeholders)
        'target'      => '_self',           // For link renderer
        'maxLength'   => 50,                // For truncate renderer
    ]

    BUILT-IN RENDERERS:
    - date          : Format date (M d, Y)
    - datetime      : Format datetime (M d, Y H:i)
    - time          : Format time (H:i)
    - relative      : Human readable time (2 hours ago)
    - currency      : Format as currency with symbol
    - number        : Format number with decimals, prefix, suffix
    - percent       : Format as percentage
    - badge         : Display as badge with color
    - status        : Display as status badge with configurable mapping
    - boolean       : Show check/cross icon
    - yesno         : Show Yes/No badge
    - image         : Display image thumbnail
    - avatar        : Display avatar with fallback initials
    - link          : Clickable link
    - email         : Mailto link
    - phone         : Tel link
    - truncate      : Truncate text with tooltip
    - html          : Render raw HTML

    ================================================================================
--}}

@props([
    // ============================================
    // IDENTIFICATION
    // ============================================
    'id' => null,                           // Unique table ID (auto-generated if null)

    // ============================================
    // TABLE STRUCTURE
    // ============================================
    'columns' => [],                        // Array of column definitions
    'rowKey' => 'id',                       // Field to use as row identifier
    'showIndex' => false,                   // Show row index column
    'indexLabel' => '#',                    // Label for index column
    'showActions' => false,                 // Show actions column
    'actionsLabel' => 'Actions',            // Label for actions column
    'actionsWidth' => null,                 // Width for actions column
    'selectable' => false,                  // Show checkbox column for row selection

    // ============================================
    // DATA SOURCE
    // ============================================
    'data' => [],                           // Static data (array/collection)
    'ajaxUrl' => null,                      // URL for AJAX data loading
    'serverSide' => false,                  // Enable server-side processing
    'deferLoading' => false,                // Defer initial data load
    'ajaxMethod' => 'GET',                  // HTTP method for AJAX
    'ajaxHeaders' => [],                    // Additional headers for AJAX

    // ============================================
    // DATATABLE FEATURES (Opt-in)
    // ============================================
    'datatable' => false,                   // Enable DataTables initialization
    'searchable' => false,                  // Enable search functionality
    'sortable' => false,                    // Enable sorting
    'pagination' => false,                  // Enable pagination
    'pageLength' => 10,                     // Default page length
    'pageLengthOptions' => [10, 25, 50, 100], // Page length options
    'responsive' => false,                  // Enable responsive mode
    'stateSave' => false,                   // Save table state in localStorage
    'ordering' => null,                     // Default ordering [['column', 'asc']]
    'columnReorderable' => false,           // Enable column drag & drop reordering

    // ============================================
    // EXPORT OPTIONS (Opt-in)
    // ============================================
    'exportable' => false,                  // Enable export buttons
    'exportButtons' => ['csv', 'excel'],    // Which export buttons to show
    'exportFilename' => 'export',           // Base filename for exports

    // ============================================
    // UI / STYLING
    // ============================================
    'tableClass' => '',                     // Additional table classes
    'wrapperClass' => '',                   // Wrapper div classes
    'headerClass' => '',                    // Table header classes
    'bodyClass' => '',                      // Table body classes
    'rowClass' => '',                       // Default row classes
    'striped' => true,                      // Striped rows
    'bordered' => false,                    // Bordered table
    'hover' => true,                        // Hover effect on rows
    'compact' => false,                     // Compact/dense mode

    // ============================================
    // RTL / LOCALE SUPPORT
    // ============================================
    'rtl' => null,                          // Enable RTL mode (null = auto-detect from HTML dir, true/false = force)
    'locale' => null,                       // Locale code ('ar', 'he', 'fa', 'en', 'fr', etc.) - auto-detect if null

    // ============================================
    // STATES
    // ============================================
    'loading' => false,                     // Initial loading state
    'emptyMessage' => 'No data available',  // Message when no data
    'emptyIcon' => 'ki-outline ki-file-deleted', // Icon for empty state
    'loadingMessage' => 'Loading...',       // Loading state message
    'errorMessage' => null,                 // Error message to display

    // ============================================
    // ROW BEHAVIORS
    // ============================================
    'rowClickable' => false,                // Enable row click handling
    'rowUrl' => null,                       // URL pattern for row click (use {id} placeholder)
    'rowAttributes' => [],                  // Default data-* attributes for rows
    'actionsView' => null,                  // Blade view path for actions (receives $row, $index)

    // ============================================
    // ROW DETAILS / EXPANDABLE ROWS
    // ============================================
    'rowDetails' => false,                  // Enable expandable row details (click row to expand)
    'rowDetailsView' => null,               // Blade view path for row details (receives $row, $index)
    'rowDetailsColumns' => null,            // Array of columns to show in details (null = all non-visible or all)
    'rowDetailsIcon' => 'ki-outline ki-plus',  // Icon for expand button (collapsed)
    'rowDetailsIconExpanded' => 'ki-outline ki-minus', // Icon for collapse button (expanded)
    'rowDetailsAnimation' => true,          // Animate row details expand/collapse
    'onRowExpand' => null,                  // Callback when row expands: function(rowData, rowElement)
    'onRowCollapse' => null,                // Callback when row collapses: function(rowData, rowElement)

    // ============================================
    // CALLBACKS (JavaScript function names)
    // ============================================
    'onInit' => null,                       // Callback after table init
    'onDraw' => null,                       // Callback after table draw
    'onRowClick' => null,                   // Callback for row click
    'onSelectionChange' => null,            // Callback when selection changes
    'onAjaxError' => null,                  // Callback for AJAX errors

    // ============================================
    // BULK ACTIONS
    // ============================================
    'bulkActions' => [],                    // Array of bulk action configs: ['key' => 'delete', 'label' => 'Delete', 'icon' => 'ki-trash', 'class' => 'btn-danger', 'confirm' => 'Are you sure?']
    'onBulkAction' => null,                 // Callback for bulk action: function(action, selectedIds)
    'bulkActionsLabel' => 'Bulk Actions',   // Label for bulk actions dropdown
    'showBulkActionsCount' => true,         // Show selected count in bulk toolbar

    // ============================================
    // COLUMN VISIBILITY
    // ============================================
    'showColumnToggle' => false,            // Show column visibility toggle dropdown
    'hiddenColumns' => [],                  // Initially hidden column keys
    'columnToggleLabel' => 'Columns',       // Label for column toggle dropdown
])

@php
    // ============================================
    // COMPUTED VALUES
    // ============================================

    // Generate unique table ID
    $tableId = $id ?? 'datatable_' . \Illuminate\Support\Str::uuid()->toString();
    $tableIdSafe = str_replace('-', '_', $tableId);

    // Normalize columns to ensure consistent structure
    $normalizedColumns = collect($columns)->map(function ($col) {
        if (is_string($col)) {
            return ['key' => $col, 'label' => \Illuminate\Support\Str::headline($col)];
        }
        return array_merge([
            'key' => '',
            'label' => '',
            'sortable' => false,
            'searchable' => false,
            'visible' => true,
            'width' => null,
            'class' => '',
            'headerClass' => '',
            'render' => null,
            'format' => null,
        ], $col);
    })->toArray();

    // Normalize data to array
    $tableData = $data instanceof \Illuminate\Support\Collection ? $data->toArray() : (array) $data;

    // Build table classes
    $computedTableClass = collect([
        'table',
        'align-middle',
        $striped ? 'table-row-bordered' : '',
        $bordered ? 'table-bordered' : '',
        $hover ? 'table-row-dashed' : '',
        $compact ? 'table-sm' : '',
        'gy-5',
        'gs-7',
        $tableClass,
    ])->filter()->implode(' ');

    // Determine if we need DataTables JS
    $needsDataTable = $datatable || $ajaxUrl || $serverSide || $searchable || $sortable || $pagination || $exportable;

    // Check for any custom cell slots
    $hasCustomSlots = false;
    foreach ($normalizedColumns as $col) {
        if (isset(${'cell-' . $col['key']})) {
            $hasCustomSlots = true;
            break;
        }
    }

    // Build DataTables configuration (abstract, converted to DT format in JS)
    $tableConfig = [
        'id' => $tableId,
        'serverSide' => $serverSide,
        'ajaxUrl' => $ajaxUrl,
        'ajaxMethod' => $ajaxMethod,
        'ajaxHeaders' => $ajaxHeaders,
        'deferLoading' => $deferLoading,
        'searchable' => $searchable,
        'sortable' => $sortable,
        'pagination' => $pagination,
        'pageLength' => $pageLength,
        'pageLengthOptions' => $pageLengthOptions,
        'responsive' => $responsive,
        'stateSave' => $stateSave,
        'ordering' => $ordering,
        'exportable' => $exportable,
        'exportButtons' => $exportButtons,
        'exportFilename' => $exportFilename,
        'columns' => $normalizedColumns,
        'selectable' => $selectable,
        'rowKey' => $rowKey,
        'showIndex' => $showIndex,
        'showActions' => $showActions,
        // RTL / Locale
        'rtl' => $rtl,
        'locale' => $locale ?? app()->getLocale(),
        // Row Details
        'rowDetails' => $rowDetails,
        'rowDetailsColumns' => $rowDetailsColumns,
        'rowDetailsIcon' => $rowDetailsIcon,
        'rowDetailsIconExpanded' => $rowDetailsIconExpanded,
        'rowDetailsAnimation' => $rowDetailsAnimation,
        // Bulk Actions
        'bulkActions' => $bulkActions,
        'onBulkAction' => $onBulkAction,
        'showBulkActionsCount' => $showBulkActionsCount,
        // Column Visibility
        'showColumnToggle' => $showColumnToggle,
        'hiddenColumns' => $hiddenColumns,
        // Column Reordering
        'columnReorderable' => $columnReorderable,
        'callbacks' => [
            'onInit' => $onInit,
            'onDraw' => $onDraw,
            'onRowClick' => $onRowClick,
            'onSelectionChange' => $onSelectionChange,
            'onAjaxError' => $onAjaxError,
            'onBulkAction' => $onBulkAction,
            'onRowExpand' => $onRowExpand,
            'onRowCollapse' => $onRowCollapse,
        ],
    ];

    // Check if bulk actions toolbar should be available
    $hasBulkActions = !empty($bulkActions) && $selectable;
@endphp

{{-- ============================================ --}}
{{-- LOAD DATATABLES ASSETS (ONCE, IF NEEDED)    --}}
{{-- ============================================ --}}
@if($needsDataTable)
@once
@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
@if($responsive)
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
@endif
<style>
    /* ============================================ */
    /* GeoTable - Modern DataTable Styles          */
    /* Supports Light & Dark Mode                  */
    /* ============================================ */

    :root {
        /* Light Mode (Default) */
        --geo-table-bg: #ffffff;
        --geo-table-header-bg: #f8f9fa;
        --geo-table-header-text: #6c757d;
        --geo-table-border: #e9ecef;
        --geo-table-row-hover: #f8f9fa;
        --geo-table-row-stripe: #fafbfc;
        --geo-table-text: #3f4254;
        --geo-table-text-muted: #a1a5b7;
        --geo-table-shadow: 0 0 20px 0 rgba(76, 87, 125, 0.02);
        --geo-table-card-shadow: 0 0 30px 0 rgba(82, 63, 105, 0.05);
        --geo-input-bg: #ffffff;
        --geo-input-border: #e4e6ef;
        --geo-input-focus-border: #b5b5c3;
        --geo-pagination-bg: #ffffff;
        --geo-pagination-active-bg: #3699ff;
        --geo-pagination-active-text: #ffffff;
        --geo-pagination-hover-bg: #f3f6f9;
    }

    [data-bs-theme="dark"],
    [data-theme="dark"],
    .theme-dark {
        /* Dark Mode */
        --geo-table-bg: #1e1e2d;
        --geo-table-header-bg: #1a1a27;
        --geo-table-header-text: #9899ac;
        --geo-table-border: #2b2b40;
        --geo-table-row-hover: #252536;
        --geo-table-row-stripe: #1b1b29;
        --geo-table-text: #cdcdde;
        --geo-table-text-muted: #6c7293;
        --geo-table-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.1);
        --geo-table-card-shadow: 0 0 30px 0 rgba(0, 0, 0, 0.15);
        --geo-input-bg: #1b1b29;
        --geo-input-border: #323248;
        --geo-input-focus-border: #474761;
        --geo-pagination-bg: #1e1e2d;
        --geo-pagination-active-bg: #3699ff;
        --geo-pagination-active-text: #ffffff;
        --geo-pagination-hover-bg: #252536;
    }

    /* ============================================ */
    /* Table Wrapper & Card                        */
    /* ============================================ */
    .geo-datatable-wrapper {
        background: var(--geo-table-bg);
        border-radius: 0.75rem;
        box-shadow: var(--geo-table-card-shadow);
        overflow: hidden;
    }

    .geo-datatable-wrapper .table-responsive {
        margin: 0;
    }

    /* ============================================ */
    /* Toolbar Area                                */
    /* ============================================ */
    .geo-datatable-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--geo-table-border);
        background: var(--geo-table-bg);
        flex-wrap: wrap;
        gap: 1rem;
    }

    /* ============================================ */
    /* Table Base Styles                           */
    /* ============================================ */
    .geo-datatable-wrapper table {
        margin-bottom: 0 !important;
        border-collapse: separate;
        border-spacing: 0;
    }

    .geo-datatable-wrapper table thead {
        background: var(--geo-table-header-bg);
    }

    .geo-datatable-wrapper table thead tr th {
        color: var(--geo-table-header-text) !important;
        font-weight: 600;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        padding: 1rem 1.25rem;
        border-bottom: 1px solid var(--geo-table-border) !important;
        border-top: none !important;
        white-space: nowrap;
        background: var(--geo-table-header-bg);
    }

    .geo-datatable-wrapper table thead tr th:first-child {
        padding-left: 1.5rem;
    }

    .geo-datatable-wrapper table thead tr th:last-child {
        padding-right: 1.5rem;
    }

    .geo-datatable-wrapper table tbody tr {
        transition: background-color 0.15s ease;
    }

    .geo-datatable-wrapper table tbody tr td {
        color: var(--geo-table-text);
        padding: 1rem 1.25rem;
        vertical-align: middle;
        border-bottom: 1px solid var(--geo-table-border);
        background: var(--geo-table-bg);
    }

    .geo-datatable-wrapper table tbody tr td:first-child {
        padding-left: 1.5rem;
    }

    .geo-datatable-wrapper table tbody tr td:last-child {
        padding-right: 1.5rem;
    }

    /* Striped Rows */
    .geo-datatable-wrapper table.table-row-bordered tbody tr:nth-child(even) td {
        background: var(--geo-table-row-stripe);
    }

    /* Hover Effect */
    .geo-datatable-wrapper table tbody tr:hover td {
        background: var(--geo-table-row-hover) !important;
    }

    /* Row Clickable */
    .geo-row-clickable {
        cursor: pointer;
    }

    /* ============================================ */
    /* DataTables Controls                         */
    /* ============================================ */
    .dataTables_wrapper {
        padding: 0 !important;
        background: var(--geo-table-bg);
    }

    /* Top Controls (Length & Filter) */
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
        padding: 1.25rem 1.5rem !important;
        margin: 0;
    }

    .dataTables_wrapper .dataTables_length label,
    .dataTables_wrapper .dataTables_filter label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin: 0;
        color: var(--geo-table-text-muted);
        font-size: 0.9rem;
    }

    .dataTables_wrapper .dataTables_length select,
    .dataTables_wrapper .dataTables_filter input {
        background: var(--geo-input-bg);
        border: 1px solid var(--geo-input-border);
        border-radius: 0.5rem;
        padding: 0.6rem 1rem;
        color: var(--geo-table-text);
        font-size: 0.9rem;
        transition: border-color 0.15s ease, box-shadow 0.15s ease;
    }

    .dataTables_wrapper .dataTables_length select:focus,
    .dataTables_wrapper .dataTables_filter input:focus {
        outline: none;
        border-color: var(--geo-input-focus-border);
        box-shadow: 0 0 0 3px rgba(54, 153, 255, 0.1);
    }

    .dataTables_wrapper .dataTables_filter input {
        min-width: 200px;
    }

    /* Bottom Controls (Info & Pagination) */
    .dataTables_wrapper .dataTables_info {
        padding: 1.25rem 1.5rem !important;
        color: var(--geo-table-text-muted);
        font-size: 0.875rem;
    }

    .dataTables_wrapper .dataTables_paginate {
        padding: 1rem 1.5rem !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        background: var(--geo-pagination-bg) !important;
        border: 1px solid var(--geo-table-border) !important;
        color: var(--geo-table-text) !important;
        border-radius: 0.5rem !important;
        padding: 0.5rem 0.85rem !important;
        margin: 0 0.2rem !important;
        font-size: 0.875rem;
        font-weight: 500;
        transition: all 0.15s ease;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: var(--geo-pagination-hover-bg) !important;
        border-color: var(--geo-input-focus-border) !important;
        color: var(--geo-table-text) !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current,
    .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        background: var(--geo-pagination-active-bg) !important;
        border-color: var(--geo-pagination-active-bg) !important;
        color: var(--geo-pagination-active-text) !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover {
        opacity: 0.5;
        cursor: not-allowed;
        background: var(--geo-pagination-bg) !important;
    }

    /* ============================================ */
    /* Sorting Indicators                          */
    /* ============================================ */
    .dataTables_wrapper table thead th.sorting,
    .dataTables_wrapper table thead th.sorting_asc,
    .dataTables_wrapper table thead th.sorting_desc {
        cursor: pointer;
        position: relative;
        padding-right: 1.75rem !important;
    }

    .dataTables_wrapper table thead th.sorting::after,
    .dataTables_wrapper table thead th.sorting_asc::after,
    .dataTables_wrapper table thead th.sorting_desc::after {
        position: absolute;
        right: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        opacity: 0.4;
        font-size: 0.65rem;
    }

    .dataTables_wrapper table thead th.sorting::after {
        content: "▲▼";
        font-size: 0.5rem;
        letter-spacing: -1px;
        opacity: 0.3;
    }

    .dataTables_wrapper table thead th.sorting_asc::after {
        content: "▲";
        opacity: 0.8;
        color: var(--geo-pagination-active-bg);
    }

    .dataTables_wrapper table thead th.sorting_desc::after {
        content: "▼";
        opacity: 0.8;
        color: var(--geo-pagination-active-bg);
    }

    /* ============================================ */
    /* Empty & Loading States                      */
    /* ============================================ */
    .geo-datatable-empty {
        padding: 4rem 2rem;
        text-align: center;
        background: var(--geo-table-bg);
    }

    .geo-datatable-empty i {
        font-size: 3.5rem;
        color: var(--geo-table-text-muted);
        opacity: 0.5;
        margin-bottom: 1.25rem;
        display: block;
    }

    .geo-datatable-empty div {
        color: var(--geo-table-text-muted);
        font-size: 1rem;
    }

    .geo-datatable-loading {
        position: relative;
        min-height: 250px;
    }

    .geo-datatable-loading::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: var(--geo-table-bg);
        opacity: 0.8;
        z-index: 10;
    }

    .geo-datatable-error {
        padding: 2.5rem;
        text-align: center;
        background: var(--geo-table-bg);
    }

    .geo-datatable-error i {
        font-size: 2.5rem;
        color: #f1416c;
        margin-bottom: 1rem;
        display: block;
    }

    .geo-datatable-error div {
        color: #f1416c;
        font-size: 0.95rem;
    }

    /* ============================================ */
    /* Checkbox Styling                            */
    /* ============================================ */
    .geo-datatable-wrapper .form-check-input {
        width: 1.25rem;
        height: 1.25rem;
        border: 2px solid var(--geo-input-border);
        border-radius: 0.35rem;
        background-color: var(--geo-input-bg);
        cursor: pointer;
        transition: all 0.15s ease;
    }

    .geo-datatable-wrapper .form-check-input:checked {
        background-color: var(--geo-pagination-active-bg);
        border-color: var(--geo-pagination-active-bg);
    }

    .geo-datatable-wrapper .form-check-input:focus {
        box-shadow: 0 0 0 3px rgba(54, 153, 255, 0.15);
    }

    /* ============================================ */
    /* Actions Column                              */
    /* ============================================ */
    .geo-datatable-wrapper table td:last-child .btn-icon {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    /* ============================================ */
    /* Bulk Actions Toolbar                        */
    /* ============================================ */
    .geo-bulk-toolbar {
        display: none;
        align-items: center;
        gap: 1rem;
        padding: 0.75rem 1.5rem;
        background: linear-gradient(135deg, rgba(54, 153, 255, 0.08) 0%, rgba(54, 153, 255, 0.04) 100%);
        border-bottom: 1px solid rgba(54, 153, 255, 0.2);
        animation: slideDown 0.2s ease;
    }

    .geo-bulk-toolbar.active {
        display: flex;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .geo-bulk-count {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9rem;
        font-weight: 500;
        color: var(--geo-pagination-active-bg);
    }

    .geo-bulk-count .count-badge {
        background: var(--geo-pagination-active-bg);
        color: var(--geo-pagination-active-text);
        padding: 0.2rem 0.6rem;
        border-radius: 0.35rem;
        font-size: 0.8rem;
        font-weight: 600;
        min-width: 28px;
        text-align: center;
    }

    .geo-bulk-actions {
        display: flex;
        gap: 0.5rem;
        margin-left: auto;
    }

    .geo-bulk-actions .btn {
        padding: 0.5rem 1rem;
        font-size: 0.85rem;
        font-weight: 500;
        border-radius: 0.5rem;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        transition: all 0.15s ease;
    }

    .geo-bulk-clear {
        background: transparent;
        border: 1px solid var(--geo-input-border);
        color: var(--geo-table-text-muted);
        padding: 0.5rem 0.75rem;
        border-radius: 0.5rem;
        font-size: 0.85rem;
        cursor: pointer;
        transition: all 0.15s ease;
    }

    .geo-bulk-clear:hover {
        background: var(--geo-table-row-hover);
        color: var(--geo-table-text);
    }

    /* ============================================ */
    /* Column Visibility Toggle                    */
    /* ============================================ */
    .geo-column-toggle {
        position: relative;
    }

    .geo-column-toggle-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background: var(--geo-input-bg);
        border: 1px solid var(--geo-input-border);
        border-radius: 0.5rem;
        color: var(--geo-table-text);
        font-size: 0.875rem;
        cursor: pointer;
        transition: all 0.15s ease;
    }

    .geo-column-toggle-btn:hover {
        border-color: var(--geo-input-focus-border);
        background: var(--geo-table-row-hover);
    }

    .geo-column-toggle-btn i {
        font-size: 1rem;
        opacity: 0.7;
    }

    .geo-column-dropdown {
        position: absolute;
        top: 100%;
        right: 0;
        z-index: 1000;
        min-width: 200px;
        background: var(--geo-table-bg);
        border: 1px solid var(--geo-table-border);
        border-radius: 0.75rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        margin-top: 0.5rem;
        display: none;
        animation: fadeIn 0.15s ease;
    }

    .geo-column-dropdown.active {
        display: block;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-5px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .geo-column-dropdown-header {
        padding: 0.75rem 1rem;
        border-bottom: 1px solid var(--geo-table-border);
        font-weight: 600;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--geo-table-header-text);
    }

    .geo-column-dropdown-body {
        padding: 0.5rem 0;
        max-height: 300px;
        overflow-y: auto;
    }

    .geo-column-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.6rem 1rem;
        cursor: pointer;
        transition: background-color 0.15s ease;
    }

    .geo-column-item:hover {
        background: var(--geo-table-row-hover);
    }

    .geo-column-item input[type="checkbox"] {
        width: 1rem;
        height: 1rem;
        cursor: pointer;
    }

    .geo-column-item label {
        flex: 1;
        cursor: pointer;
        font-size: 0.875rem;
        color: var(--geo-table-text);
    }

    .geo-column-dropdown-footer {
        padding: 0.75rem 1rem;
        border-top: 1px solid var(--geo-table-border);
        display: flex;
        gap: 0.5rem;
    }

    .geo-column-dropdown-footer button {
        flex: 1;
        padding: 0.4rem 0.75rem;
        border-radius: 0.35rem;
        font-size: 0.8rem;
        cursor: pointer;
        transition: all 0.15s ease;
    }

    .geo-column-show-all {
        background: var(--geo-input-bg);
        border: 1px solid var(--geo-input-border);
        color: var(--geo-table-text);
    }

    .geo-column-show-all:hover {
        background: var(--geo-table-row-hover);
    }

    /* ============================================ */
    /* Column Reordering (Drag & Drop)             */
    /* ============================================ */
    .geo-datatable-wrapper.column-reorderable table thead th {
        cursor: grab;
        user-select: none;
        position: relative;
    }

    .geo-datatable-wrapper.column-reorderable table thead th:active {
        cursor: grabbing;
    }

    .geo-datatable-wrapper.column-reorderable table thead th.geo-col-dragging {
        opacity: 0.5;
        background: var(--geo-pagination-active-bg) !important;
        color: var(--geo-pagination-active-text) !important;
    }

    .geo-datatable-wrapper.column-reorderable table thead th.geo-col-drag-over {
        background: rgba(54, 153, 255, 0.15) !important;
    }

    .geo-datatable-wrapper.column-reorderable table thead th.geo-col-drag-over::before {
        content: '';
        position: absolute;
        left: -2px;
        top: 0;
        bottom: 0;
        width: 4px;
        background: var(--geo-pagination-active-bg);
        border-radius: 2px;
    }

    .geo-datatable-wrapper.column-reorderable table thead th.geo-col-drag-over-right::before {
        left: auto;
        right: -2px;
    }

    .geo-datatable-wrapper.column-reorderable table thead th .geo-drag-handle {
        display: inline-block;
        margin-right: 0.5rem;
        opacity: 0.4;
        transition: opacity 0.15s ease;
    }

    .geo-datatable-wrapper.column-reorderable table thead th:hover .geo-drag-handle {
        opacity: 0.8;
    }

    /* Don't allow drag on checkbox/index columns */
    .geo-datatable-wrapper.column-reorderable table thead th.geo-col-fixed {
        cursor: default;
    }

    .geo-datatable-wrapper.column-reorderable table thead th.geo-col-fixed .geo-drag-handle {
        display: none;
    }

    /* ============================================ */
    /* Responsive Adjustments                      */
    /* ============================================ */
    @media (max-width: 768px) {
        .geo-datatable-toolbar {
            flex-direction: column;
            align-items: stretch;
        }

        .geo-bulk-toolbar {
            flex-wrap: wrap;
            padding: 0.75rem 1rem;
        }

        .geo-bulk-actions {
            margin-left: 0;
            width: 100%;
            flex-wrap: wrap;
        }

        .geo-column-dropdown {
            position: fixed;
            top: auto;
            bottom: 0;
            left: 0;
            right: 0;
            border-radius: 1rem 1rem 0 0;
            max-height: 60vh;
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            padding: 1rem !important;
            text-align: left !important;
        }

        .dataTables_wrapper .dataTables_filter input {
            min-width: 100%;
            width: 100%;
        }

        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            padding: 1rem !important;
            text-align: center !important;
        }
    }

    /* ============================================ */
    /* RTL (Right-to-Left) SUPPORT                 */
    /* ============================================ */
    [dir="rtl"] .geo-datatable-wrapper,
    .geo-datatable-wrapper[dir="rtl"] {
        direction: rtl;
        text-align: right;
    }

    [dir="rtl"] .geo-datatable-toolbar,
    .geo-datatable-wrapper[dir="rtl"] .geo-datatable-toolbar {
        flex-direction: row-reverse;
    }

    [dir="rtl"] .geo-bulk-toolbar,
    .geo-datatable-wrapper[dir="rtl"] .geo-bulk-toolbar {
        flex-direction: row-reverse;
    }

    [dir="rtl"] .geo-bulk-count,
    .geo-datatable-wrapper[dir="rtl"] .geo-bulk-count {
        margin-left: 1rem;
        margin-right: 0;
    }

    [dir="rtl"] .geo-bulk-actions,
    .geo-datatable-wrapper[dir="rtl"] .geo-bulk-actions {
        margin-left: 0;
        margin-right: auto;
    }

    [dir="rtl"] .dataTables_wrapper .dataTables_length,
    .geo-datatable-wrapper[dir="rtl"] .dataTables_wrapper .dataTables_length {
        float: right;
        text-align: right;
    }

    [dir="rtl"] .dataTables_wrapper .dataTables_filter,
    .geo-datatable-wrapper[dir="rtl"] .dataTables_wrapper .dataTables_filter {
        float: left;
        text-align: left;
    }

    [dir="rtl"] .dataTables_wrapper .dataTables_info,
    .geo-datatable-wrapper[dir="rtl"] .dataTables_wrapper .dataTables_info {
        float: right;
        text-align: right;
    }

    [dir="rtl"] .dataTables_wrapper .dataTables_paginate,
    .geo-datatable-wrapper[dir="rtl"] .dataTables_wrapper .dataTables_paginate {
        float: left;
        text-align: left;
    }

    [dir="rtl"] .dataTables_wrapper .dataTables_paginate .paginate_button,
    .geo-datatable-wrapper[dir="rtl"] .dataTables_wrapper .dataTables_paginate .paginate_button {
        margin-left: 0;
        margin-right: 0.25rem;
    }

    [dir="rtl"] .geo-column-dropdown,
    .geo-datatable-wrapper[dir="rtl"] .geo-column-dropdown {
        left: auto;
        right: 0;
        text-align: right;
    }

    [dir="rtl"] .geo-column-toggle-item label,
    .geo-datatable-wrapper[dir="rtl"] .geo-column-toggle-item label {
        flex-direction: row-reverse;
        justify-content: flex-end;
    }

    [dir="rtl"] .geo-column-toggle-item input,
    .geo-datatable-wrapper[dir="rtl"] .geo-column-toggle-item input {
        margin-left: 0.5rem;
        margin-right: 0;
    }

    /* RTL Table Headers */
    [dir="rtl"] table.dataTable thead th,
    [dir="rtl"] table.dataTable thead td,
    .geo-datatable-wrapper[dir="rtl"] table.dataTable thead th,
    .geo-datatable-wrapper[dir="rtl"] table.dataTable thead td {
        text-align: right;
    }

    /* RTL Table Cells */
    [dir="rtl"] table.dataTable tbody td,
    .geo-datatable-wrapper[dir="rtl"] table.dataTable tbody td {
        text-align: right;
    }

    /* RTL Sorting Icons */
    [dir="rtl"] table.dataTable thead .sorting::after,
    [dir="rtl"] table.dataTable thead .sorting_asc::after,
    [dir="rtl"] table.dataTable thead .sorting_desc::after,
    .geo-datatable-wrapper[dir="rtl"] table.dataTable thead .sorting::after,
    .geo-datatable-wrapper[dir="rtl"] table.dataTable thead .sorting_asc::after,
    .geo-datatable-wrapper[dir="rtl"] table.dataTable thead .sorting_desc::after {
        left: 0.5rem;
        right: auto;
    }

    /* RTL Empty State */
    [dir="rtl"] .geo-datatable-empty,
    .geo-datatable-wrapper[dir="rtl"] .geo-datatable-empty {
        direction: rtl;
    }

    /* ============================================ */
    /* ROW DETAILS / EXPANDABLE ROWS               */
    /* ============================================ */

    /* Expand toggle button */
    .geo-row-expand-toggle {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
        border: none;
        background: transparent;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.2s ease;
        color: var(--geo-table-text-muted);
    }

    .geo-row-expand-toggle:hover {
        background: var(--geo-table-row-hover);
        color: var(--bs-primary, #3699ff);
    }

    .geo-row-expand-toggle i {
        font-size: 1rem;
        transition: transform 0.2s ease;
    }

    /* Expanded state */
    tr.geo-row-expanded .geo-row-expand-toggle {
        background: rgba(var(--bs-primary-rgb, 54, 153, 255), 0.1);
        color: var(--bs-primary, #3699ff);
    }

    tr.geo-row-expanded {
        background: var(--geo-table-row-hover) !important;
    }

    tr.geo-row-expanded td {
        background: var(--geo-table-row-hover) !important;
        border-bottom-color: transparent !important;
    }

    /* Details row */
    tr.geo-row-details {
        background: var(--geo-table-bg);
    }

    tr.geo-row-details > td {
        padding: 0 !important;
        border-bottom: 1px solid var(--geo-table-border);
        background: linear-gradient(to bottom, var(--geo-table-row-hover) 0%, var(--geo-table-bg) 8px, var(--geo-table-bg) 100%);
    }

    /* Details content wrapper */
    .geo-row-details-content {
        padding: 1.5rem 2rem;
        overflow: hidden;
    }

    /* Animation */
    .geo-row-details-content.geo-animate {
        animation: geo-slide-down 0.25s ease-out;
    }

    @keyframes geo-slide-down {
        from {
            opacity: 0;
            max-height: 0;
            padding-top: 0;
            padding-bottom: 0;
        }
        to {
            opacity: 1;
            max-height: 500px;
            padding-top: 1.5rem;
            padding-bottom: 1.5rem;
        }
    }

    /* Details grid layout */
    .geo-row-details-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1rem 2rem;
    }

    .geo-row-details-item {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .geo-row-details-label {
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--geo-table-text-muted);
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }

    .geo-row-details-value {
        font-size: 0.95rem;
        color: var(--geo-table-text);
        word-break: break-word;
    }

    .geo-row-details-value:empty::before {
        content: '-';
        color: var(--geo-table-text-muted);
    }

    /* Card style variant for details */
    .geo-row-details-cards {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .geo-row-details-card {
        flex: 1 1 200px;
        max-width: 300px;
        padding: 1rem;
        background: var(--geo-table-row-stripe);
        border-radius: 8px;
        border: 1px solid var(--geo-table-border);
    }

    .geo-row-details-card .geo-row-details-label {
        margin-bottom: 0.5rem;
    }

    /* RTL support for row details */
    [dir="rtl"] .geo-row-details-content,
    .geo-datatable-wrapper[dir="rtl"] .geo-row-details-content {
        direction: rtl;
        text-align: right;
    }
</style>
@endpush

@push('scripts')
<script>
/**
 * GeoTable - Generic DataTable Manager
 * Provides a namespace for table operations without polluting global scope
 */
(function() {
    'use strict';

    // ========================================
    // LOCALE TRANSLATIONS FOR DATATABLE
    // ========================================
    const dtLocaleTexts = {
        // Arabic
        ar: {
            emptyTable: 'لا توجد بيانات',
            info: 'عرض _START_ إلى _END_ من _TOTAL_ سجل',
            infoEmpty: 'عرض 0 إلى 0 من 0 سجل',
            infoFiltered: '(مفلتر من _MAX_ سجل)',
            lengthMenu: 'عرض _MENU_ سجل',
            loadingRecords: 'جاري التحميل...',
            processing: 'جاري المعالجة...',
            search: 'بحث:',
            zeroRecords: 'لم يتم العثور على سجلات مطابقة',
            paginate: {
                first: 'الأول',
                last: 'الأخير',
                next: 'التالي',
                previous: 'السابق'
            },
            aria: {
                sortAscending: ': تفعيل لترتيب العمود تصاعدياً',
                sortDescending: ': تفعيل لترتيب العمود تنازلياً'
            },
            select: {
                rows: {
                    _: '%d صفوف محددة',
                    0: '',
                    1: '1 صف محدد'
                }
            }
        },
        // Hebrew
        he: {
            emptyTable: 'אין נתונים זמינים בטבלה',
            info: 'מציג _START_ עד _END_ מתוך _TOTAL_ רשומות',
            infoEmpty: 'מציג 0 עד 0 מתוך 0 רשומות',
            infoFiltered: '(מסונן מתוך _MAX_ רשומות)',
            lengthMenu: 'הצג _MENU_ רשומות',
            loadingRecords: 'טוען...',
            processing: 'מעבד...',
            search: 'חיפוש:',
            zeroRecords: 'לא נמצאו רשומות תואמות',
            paginate: {
                first: 'ראשון',
                last: 'אחרון',
                next: 'הבא',
                previous: 'הקודם'
            }
        },
        // Farsi/Persian
        fa: {
            emptyTable: 'هیچ داده‌ای موجود نیست',
            info: 'نمایش _START_ تا _END_ از _TOTAL_ رکورد',
            infoEmpty: 'نمایش 0 تا 0 از 0 رکورد',
            infoFiltered: '(فیلتر شده از _MAX_ رکورد)',
            lengthMenu: 'نمایش _MENU_ رکورد',
            loadingRecords: 'در حال بارگذاری...',
            processing: 'در حال پردازش...',
            search: 'جستجو:',
            zeroRecords: 'رکوردی یافت نشد',
            paginate: {
                first: 'اولین',
                last: 'آخرین',
                next: 'بعدی',
                previous: 'قبلی'
            }
        },
        // French
        fr: {
            emptyTable: 'Aucune donnée disponible',
            info: 'Affichage de _START_ à _END_ sur _TOTAL_ entrées',
            infoEmpty: 'Affichage de 0 à 0 sur 0 entrées',
            infoFiltered: '(filtré depuis _MAX_ entrées)',
            lengthMenu: 'Afficher _MENU_ entrées',
            loadingRecords: 'Chargement...',
            processing: 'Traitement...',
            search: 'Rechercher:',
            zeroRecords: 'Aucun enregistrement correspondant trouvé',
            paginate: {
                first: 'Premier',
                last: 'Dernier',
                next: 'Suivant',
                previous: 'Précédent'
            }
        }
    };

    /**
     * Get locale text for DataTables
     */
    function getDtLocaleText(locale) {
        // Normalize locale (e.g., 'ar_SA' -> 'ar', 'en-US' -> 'en')
        const normalizedLocale = locale ? locale.split(/[-_]/)[0].toLowerCase() : null;
        return dtLocaleTexts[normalizedLocale] || null;
    }

    /**
     * Check if locale is RTL
     */
    function isRtlLocale(locale) {
        const rtlLocales = ['ar', 'he', 'fa', 'ur'];
        const normalizedLocale = locale ? locale.split(/[-_]/)[0].toLowerCase() : null;
        return rtlLocales.includes(normalizedLocale);
    }

    // Namespace
    window.GeoTable = window.GeoTable || {
        instances: {},

        /**
         * Initialize a DataTable instance
         * @param {string} tableId - The table element ID
         * @param {object} config - Table configuration
         */
        init: function(tableId, config) {
            var self = this;

            // Check if already initialized - prevent reinitialize error
            if (this.instances[tableId] && this.instances[tableId].dt) {
                console.debug('GeoTable: Table already initialized:', tableId);
                return this.instances[tableId].dt;
            }

            // Also check if DataTable is already initialized on the element
            var $table = jQuery('#' + tableId);
            if ($table.length && jQuery.fn.DataTable.isDataTable($table)) {
                console.debug('GeoTable: DataTable already exists on element:', tableId);
                return $table.DataTable();
            }

            // Wait for dependencies
            this._waitForDependencies(function() {
                self._initTable(tableId, config);
            });
        },

        /**
         * Reload table data
         * @param {string} tableId - The table element ID
         * @param {function} callback - Optional callback after reload
         */
        reload: function(tableId, callback) {
            var instance = this.instances[tableId];
            if (instance && instance.dt) {
                instance.dt.ajax.reload(callback, false);
            }
        },

        /**
         * Get selected rows
         * @param {string} tableId - The table element ID
         * @returns {array} Array of selected row keys
         */
        getSelected: function(tableId) {
            var instance = this.instances[tableId];
            return instance ? instance.selected : [];
        },

        /**
         * Clear selection
         * @param {string} tableId - The table element ID
         */
        clearSelection: function(tableId) {
            var instance = this.instances[tableId];
            if (instance) {
                instance.selected = [];
                var table = document.getElementById(tableId);
                if (table) {
                    var checkboxes = table.querySelectorAll('.geo-row-checkbox');
                    checkboxes.forEach(function(cb) { cb.checked = false; });
                    var selectAll = table.querySelector('.geo-select-all');
                    if (selectAll) selectAll.checked = false;
                }
                this._updateBulkToolbar(tableId, []);
                this._triggerCallback(instance.config.callbacks.onSelectionChange, [[]]);
            }
        },

        /**
         * Destroy table instance
         * @param {string} tableId - The table element ID
         */
        destroy: function(tableId) {
            var instance = this.instances[tableId];
            if (instance && instance.dt) {
                instance.dt.destroy();
                delete this.instances[tableId];
            }
        },

        /**
         * Show loading state
         * @param {string} tableId - The table element ID
         */
        showLoading: function(tableId) {
            var wrapper = document.querySelector('[data-geo-table="' + tableId + '"]');
            if (wrapper) wrapper.classList.add('geo-datatable-loading');
        },

        /**
         * Hide loading state
         * @param {string} tableId - The table element ID
         */
        hideLoading: function(tableId) {
            var wrapper = document.querySelector('[data-geo-table="' + tableId + '"]');
            if (wrapper) wrapper.classList.remove('geo-datatable-loading');
        },

        // ========================================
        // BULK ACTIONS
        // ========================================

        /**
         * Execute a bulk action on selected rows
         * @param {string} tableId - The table element ID
         * @param {string} actionKey - The action key
         * @param {string|null} confirmMessage - Optional confirmation message
         */
        executeBulkAction: function(tableId, actionKey, confirmMessage) {
            var instance = this.instances[tableId];
            if (!instance || !instance.selected.length) {
                console.warn('GeoTable: No rows selected for bulk action');
                return;
            }

            var proceed = true;
            if (confirmMessage) {
                proceed = confirm(confirmMessage);
            }

            if (proceed) {
                this._triggerCallback(instance.config.callbacks.onBulkAction, [actionKey, instance.selected, tableId]);
            }
        },

        /**
         * Update bulk actions toolbar visibility and count
         * @param {string} tableId - The table element ID
         * @param {array} selected - Array of selected row keys
         */
        _updateBulkToolbar: function(tableId, selected) {
            var toolbar = document.getElementById(tableId + '_bulk_toolbar');
            var countEl = document.getElementById(tableId + '_selected_count');

            if (toolbar) {
                if (selected.length > 0) {
                    toolbar.classList.add('active');
                    if (countEl) countEl.textContent = selected.length;
                } else {
                    toolbar.classList.remove('active');
                }
            }
        },

        // ========================================
        // COLUMN VISIBILITY
        // ========================================

        /**
         * Toggle column dropdown visibility
         * @param {string} tableId - The table element ID
         */
        toggleColumnDropdown: function(tableId) {
            var dropdown = document.getElementById(tableId + '_column_dropdown');
            if (dropdown) {
                dropdown.classList.toggle('active');

                // Close dropdown when clicking outside
                if (dropdown.classList.contains('active')) {
                    var closeHandler = function(e) {
                        if (!dropdown.contains(e.target) && !e.target.closest('.geo-column-toggle-btn')) {
                            dropdown.classList.remove('active');
                            document.removeEventListener('click', closeHandler);
                        }
                    };
                    setTimeout(function() {
                        document.addEventListener('click', closeHandler);
                    }, 10);
                }
            }
        },

        /**
         * Toggle a column's visibility
         * @param {string} tableId - The table element ID
         * @param {number} columnIndex - The column index
         * @param {boolean} visible - Whether to show or hide the column
         */
        toggleColumn: function(tableId, columnIndex, visible) {
            var instance = this.instances[tableId];
            if (instance && instance.dt) {
                // Account for selectable/index columns offset
                var offset = 0;
                if (instance.config.selectable) offset++;
                // Note: showIndex is not tracked in config, so check the table
                var indexCol = document.querySelector('#' + tableId + ' th.w-50px');
                if (indexCol) offset++;

                var dtColumn = instance.dt.column(columnIndex + offset);
                dtColumn.visible(visible);
            }
        },

        /**
         * Show all columns
         * @param {string} tableId - The table element ID
         */
        showAllColumns: function(tableId) {
            var instance = this.instances[tableId];
            if (instance && instance.dt) {
                instance.dt.columns().visible(true);

                // Update checkboxes
                var dropdown = document.getElementById(tableId + '_column_dropdown');
                if (dropdown) {
                    var checkboxes = dropdown.querySelectorAll('input[type="checkbox"]');
                    checkboxes.forEach(function(cb) { cb.checked = true; });
                }
            }
        },

        /**
         * Hide specific columns by keys
         * @param {string} tableId - The table element ID
         * @param {array} columnKeys - Array of column keys to hide
         */
        hideColumns: function(tableId, columnKeys) {
            var instance = this.instances[tableId];
            if (instance && instance.dt && instance.config.columns) {
                instance.config.columns.forEach(function(col, index) {
                    if (columnKeys.indexOf(col.key) !== -1) {
                        instance.dt.column(index).visible(false);
                    }
                });
            }
        },

        // ========================================
        // COLUMN REORDERING
        // ========================================

        /**
         * Get current column order
         * @param {string} tableId - The table element ID
         * @returns {array} Array of column keys in current order
         */
        getColumnOrder: function(tableId) {
            var instance = this.instances[tableId];
            return instance && instance.columnOrder ? instance.columnOrder : [];
        },

        /**
         * Set column order programmatically
         * @param {string} tableId - The table element ID
         * @param {array} columnKeys - Array of column keys in desired order
         */
        setColumnOrder: function(tableId, columnKeys) {
            var instance = this.instances[tableId];
            if (!instance) return;

            var table = document.getElementById(tableId);
            if (!table) return;

            // Build index mapping
            var currentOrder = instance.columnOrder || instance.config.columns.map(function(c) { return c.key; });
            var newOrder = columnKeys.filter(function(key) {
                return currentOrder.indexOf(key) !== -1;
            });

            // Add any missing columns at the end
            currentOrder.forEach(function(key) {
                if (newOrder.indexOf(key) === -1) {
                    newOrder.push(key);
                }
            });

            instance.columnOrder = newOrder;
            this._reorderTableColumns(tableId, newOrder);
            this._saveColumnOrder(tableId, newOrder);
        },

        /**
         * Reset column order to original
         * @param {string} tableId - The table element ID
         */
        resetColumnOrder: function(tableId) {
            var instance = this.instances[tableId];
            if (!instance) return;

            var originalOrder = instance.config.columns.map(function(c) { return c.key; });
            instance.columnOrder = originalOrder;
            this._reorderTableColumns(tableId, originalOrder);
            this._clearColumnOrder(tableId);
        },

        /**
         * Setup column reordering drag & drop
         * @param {string} tableId - The table element ID
         */
        _setupColumnReorder: function(tableId) {
            var self = this;
            var instance = this.instances[tableId];
            var table = document.getElementById(tableId);
            if (!table || !instance) return;

            var wrapper = table.closest('.geo-datatable-wrapper');
            if (wrapper) {
                wrapper.classList.add('column-reorderable');
            }

            // Load saved column order
            var savedOrder = this._loadColumnOrder(tableId);
            if (savedOrder && savedOrder.length) {
                instance.columnOrder = savedOrder;
                this._reorderTableColumns(tableId, savedOrder);
            } else {
                instance.columnOrder = instance.config.columns.map(function(c) { return c.key; });
            }

            // Get all draggable header cells (skip fixed columns like checkbox/index)
            var headers = table.querySelectorAll('thead th');
            var dragState = { dragging: null, dragIndex: -1 };

            headers.forEach(function(th, index) {
                // Skip fixed columns (checkbox, index, actions)
                if (th.classList.contains('geo-col-fixed')) return;

                th.setAttribute('draggable', 'true');
                th.dataset.colIndex = index;

                // Drag start
                th.addEventListener('dragstart', function(e) {
                    dragState.dragging = th;
                    dragState.dragIndex = index;
                    th.classList.add('geo-col-dragging');
                    e.dataTransfer.effectAllowed = 'move';
                    e.dataTransfer.setData('text/plain', index);
                });

                // Drag over
                th.addEventListener('dragover', function(e) {
                    if (!dragState.dragging || dragState.dragging === th) return;
                    if (th.classList.contains('geo-col-fixed')) return;

                    e.preventDefault();
                    e.dataTransfer.dropEffect = 'move';

                    // Determine if drop should be before or after
                    var rect = th.getBoundingClientRect();
                    var midpoint = rect.left + rect.width / 2;
                    var isRight = e.clientX > midpoint;

                    th.classList.add('geo-col-drag-over');
                    th.classList.toggle('geo-col-drag-over-right', isRight);
                });

                // Drag leave
                th.addEventListener('dragleave', function(e) {
                    th.classList.remove('geo-col-drag-over', 'geo-col-drag-over-right');
                });

                // Drop
                th.addEventListener('drop', function(e) {
                    e.preventDefault();
                    if (!dragState.dragging || dragState.dragging === th) return;
                    if (th.classList.contains('geo-col-fixed')) return;

                    var fromIndex = dragState.dragIndex;
                    var toIndex = parseInt(th.dataset.colIndex);

                    // Determine insert position
                    var rect = th.getBoundingClientRect();
                    var midpoint = rect.left + rect.width / 2;
                    if (e.clientX > midpoint) {
                        toIndex++;
                    }

                    // Reorder columns
                    self._moveColumn(tableId, fromIndex, toIndex);

                    // Clean up
                    th.classList.remove('geo-col-drag-over', 'geo-col-drag-over-right');
                });

                // Drag end
                th.addEventListener('dragend', function(e) {
                    th.classList.remove('geo-col-dragging');
                    dragState.dragging = null;
                    dragState.dragIndex = -1;

                    // Clean up all drag-over classes
                    headers.forEach(function(h) {
                        h.classList.remove('geo-col-drag-over', 'geo-col-drag-over-right');
                    });
                });
            });
        },

        /**
         * Move a column from one position to another
         * @param {string} tableId - The table element ID
         * @param {number} fromIndex - Source column index
         * @param {number} toIndex - Destination column index
         */
        _moveColumn: function(tableId, fromIndex, toIndex) {
            var instance = this.instances[tableId];
            var table = document.getElementById(tableId);
            if (!table || !instance) return;

            if (fromIndex === toIndex) return;

            // Calculate actual data column indices (accounting for fixed columns)
            var fixedCount = this._getFixedColumnCount(tableId);
            var dataFromIndex = fromIndex - fixedCount;
            var dataToIndex = toIndex - fixedCount;

            if (dataFromIndex < 0 || dataToIndex < 0) return;

            // Update column order array
            var order = instance.columnOrder.slice();
            var moved = order.splice(dataFromIndex, 1)[0];
            if (dataToIndex > dataFromIndex) dataToIndex--;
            order.splice(dataToIndex, 0, moved);
            instance.columnOrder = order;

            // Reorder DOM
            this._reorderTableColumns(tableId, order);

            // Save to localStorage if stateSave is enabled
            if (instance.config.stateSave) {
                this._saveColumnOrder(tableId, order);
            }
        },

        /**
         * Get count of fixed (non-reorderable) columns
         * @param {string} tableId - The table element ID
         * @returns {number} Number of fixed columns
         */
        _getFixedColumnCount: function(tableId) {
            var table = document.getElementById(tableId);
            if (!table) return 0;
            return table.querySelectorAll('thead th.geo-col-fixed').length;
        },

        /**
         * Reorder table columns in DOM
         * @param {string} tableId - The table element ID
         * @param {array} order - Array of column keys in order
         */
        _reorderTableColumns: function(tableId, order) {
            var instance = this.instances[tableId];
            var table = document.getElementById(tableId);
            if (!table || !instance) return;

            var fixedCount = this._getFixedColumnCount(tableId);

            // Build index mapping from key to original position
            var keyToOriginal = {};
            instance.config.columns.forEach(function(col, i) {
                keyToOriginal[col.key] = i;
            });

            // Reorder header
            var headerRow = table.querySelector('thead tr');
            if (headerRow) {
                var headerCells = Array.from(headerRow.children);
                var fixedHeaders = headerCells.slice(0, fixedCount);
                var dataHeaders = headerCells.slice(fixedCount);

                // Check if there's an actions column at the end
                var hasActions = instance.config.showActions || table.querySelector('thead th:last-child')?.textContent?.toLowerCase().includes('action');
                var actionsHeader = null;
                if (hasActions && dataHeaders.length > order.length) {
                    actionsHeader = dataHeaders.pop();
                }

                // Sort data headers according to order
                var sortedHeaders = order.map(function(key) {
                    var origIndex = keyToOriginal[key];
                    return dataHeaders[origIndex];
                }).filter(Boolean);

                // Rebuild header row
                headerRow.innerHTML = '';
                fixedHeaders.forEach(function(h) { headerRow.appendChild(h); });
                sortedHeaders.forEach(function(h) { if (h) headerRow.appendChild(h); });
                if (actionsHeader) headerRow.appendChild(actionsHeader);

                // Update data-col-index attributes
                Array.from(headerRow.children).forEach(function(th, i) {
                    th.dataset.colIndex = i;
                });
            }

            // Reorder body rows
            var bodyRows = table.querySelectorAll('tbody tr');
            bodyRows.forEach(function(row) {
                var cells = Array.from(row.children);
                var fixedCells = cells.slice(0, fixedCount);
                var dataCells = cells.slice(fixedCount);

                // Check for actions column
                var actionsCell = null;
                if (dataCells.length > order.length) {
                    actionsCell = dataCells.pop();
                }

                // Sort data cells according to order
                var sortedCells = order.map(function(key) {
                    var origIndex = keyToOriginal[key];
                    return dataCells[origIndex];
                }).filter(Boolean);

                // Rebuild row
                row.innerHTML = '';
                fixedCells.forEach(function(c) { row.appendChild(c); });
                sortedCells.forEach(function(c) { if (c) row.appendChild(c); });
                if (actionsCell) row.appendChild(actionsCell);
            });
        },

        /**
         * Save column order to localStorage
         * @param {string} tableId - The table element ID
         * @param {array} order - Array of column keys
         */
        _saveColumnOrder: function(tableId, order) {
            try {
                localStorage.setItem('geo_table_col_order_' + tableId, JSON.stringify(order));
            } catch (e) {
                console.warn('GeoTable: Could not save column order', e);
            }
        },

        /**
         * Load column order from localStorage
         * @param {string} tableId - The table element ID
         * @returns {array|null} Array of column keys or null
         */
        _loadColumnOrder: function(tableId) {
            try {
                var saved = localStorage.getItem('geo_table_col_order_' + tableId);
                return saved ? JSON.parse(saved) : null;
            } catch (e) {
                return null;
            }
        },

        /**
         * Clear saved column order
         * @param {string} tableId - The table element ID
         */
        _clearColumnOrder: function(tableId) {
            try {
                localStorage.removeItem('geo_table_col_order_' + tableId);
            } catch (e) {}
        },

        // ========================================
        // PRIVATE METHODS
        // ========================================

        _waitForDependencies: function(callback) {
            var checkDeps = function() {
                if (typeof jQuery !== 'undefined' && typeof jQuery.fn.DataTable !== 'undefined') {
                    callback();
                } else {
                    setTimeout(checkDeps, 50);
                }
            };
            checkDeps();
        },

        _initTable: function(tableId, config) {
            var self = this;
            var $table = jQuery('#' + tableId);

            if (!$table.length) {
                console.warn('GeoTable: Table not found:', tableId);
                return;
            }

            // Double-check: prevent reinitialize if already a DataTable
            if (jQuery.fn.DataTable.isDataTable($table)) {
                console.debug('GeoTable: Skipping init - already a DataTable:', tableId);
                if (!this.instances[tableId]) {
                    this.instances[tableId] = {
                        config: config,
                        selected: [],
                        dt: $table.DataTable()
                    };
                }
                return;
            }

            // Store instance
            this.instances[tableId] = {
                config: config,
                selected: [],
                dt: null
            };

            // Build DataTables options
            var dtOptions = this._buildDTOptions(tableId, config);

            // Initialize DataTable
            var dt = $table.DataTable(dtOptions);
            this.instances[tableId].dt = dt;

            // Setup selection handling
            if (config.selectable) {
                this._setupSelection(tableId, config);
            }

            // Setup row click handling
            if (config.callbacks.onRowClick) {
                this._setupRowClick(tableId, config);
            }

            // Setup column reordering
            if (config.columnReorderable) {
                this._setupColumnReorder(tableId);
            }

            // Setup row details / expandable rows
            if (config.rowDetails) {
                this._setupRowDetails(tableId, config);
            }

            // Trigger init callback
            this._triggerCallback(config.callbacks.onInit, [dt, tableId]);
        },

        _buildDTOptions: function(tableId, config) {
            var self = this;

            // ========================================
            // RTL DETECTION
            // ========================================
            // Determine RTL: use explicit config, or auto-detect from HTML dir attribute or locale
            var isRtl = config.rtl !== null ? config.rtl :
                (document.documentElement.dir === 'rtl' || document.body.dir === 'rtl' || isRtlLocale(config.locale));

            // Get locale-specific text (or use defaults)
            var localeText = getDtLocaleText(config.locale);
            var defaultLanguage = {
                emptyTable: '<div class="geo-datatable-empty"><i class="ki-outline ki-file-deleted"></i><div>No data available</div></div>',
                zeroRecords: '<div class="geo-datatable-empty"><i class="ki-outline ki-magnifier"></i><div>No matching records found</div></div>',
                processing: '<div class="spinner-border spinner-border-sm text-primary" role="status"><span class="visually-hidden">Loading...</span></div>'
            };

            // Build language object with locale overrides
            var language = localeText ? Object.assign({}, localeText, {
                // Keep custom HTML templates for empty/loading but override text
                emptyTable: '<div class="geo-datatable-empty"><i class="ki-outline ki-file-deleted"></i><div>' + (localeText.emptyTable || 'No data available') + '</div></div>',
                zeroRecords: '<div class="geo-datatable-empty"><i class="ki-outline ki-magnifier"></i><div>' + (localeText.zeroRecords || 'No matching records found') + '</div></div>',
                processing: '<div class="spinner-border spinner-border-sm text-primary" role="status"><span class="visually-hidden">' + (localeText.loadingRecords || 'Loading...') + '</span></div>'
            }) : defaultLanguage;

            var options = {
                processing: config.serverSide,
                serverSide: config.serverSide,
                searching: config.searchable,
                ordering: config.sortable,
                paging: config.pagination,
                pageLength: config.pageLength,
                lengthMenu: config.pageLengthOptions,
                responsive: config.responsive,
                stateSave: config.stateSave,
                deferLoading: config.deferLoading ? 0 : null,
                language: language,
                drawCallback: function(settings) {
                    self._triggerCallback(config.callbacks.onDraw, [this.api(), tableId]);
                }
            };

            // AJAX configuration
            if (config.ajaxUrl) {
                options.ajax = {
                    url: config.ajaxUrl,
                    type: config.ajaxMethod,
                    headers: config.ajaxHeaders,
                    error: function(xhr, error, thrown) {
                        self.hideLoading(tableId);
                        self._triggerCallback(config.callbacks.onAjaxError, [xhr, error, thrown]);
                    }
                };
            }

            // Column definitions
            if (config.columns && config.columns.length) {
                options.columns = config.columns.map(function(col) {
                    return {
                        data: col.key,
                        name: col.key,
                        title: col.label,
                        orderable: col.sortable || col.orderable || false,
                        searchable: col.searchable || false,
                        visible: col.visible !== false,
                        width: col.width || null,
                        className: col.class || ''
                    };
                });
            }

            // Default ordering
            if (config.ordering) {
                options.order = config.ordering;
            }

            // Export buttons
            if (config.exportable && config.exportButtons.length) {
                options.dom = 'Bfrtip';
                options.buttons = config.exportButtons.map(function(btn) {
                    return {
                        extend: btn,
                        filename: config.exportFilename,
                        className: 'btn btn-sm btn-light-primary'
                    };
                });
            }

            return options;
        },

        _setupSelection: function(tableId, config) {
            var self = this;
            var table = document.getElementById(tableId);
            if (!table) return;

            // Select all checkbox
            var selectAll = table.querySelector('.geo-select-all');
            if (selectAll) {
                selectAll.addEventListener('change', function() {
                    var checkboxes = table.querySelectorAll('.geo-row-checkbox');
                    var instance = self.instances[tableId];

                    if (this.checked) {
                        instance.selected = [];
                        checkboxes.forEach(function(cb) {
                            cb.checked = true;
                            var key = cb.getAttribute('data-row-key');
                            if (key) instance.selected.push(key);
                        });
                    } else {
                        instance.selected = [];
                        checkboxes.forEach(function(cb) { cb.checked = false; });
                    }

                    self._updateBulkToolbar(tableId, instance.selected);
                    self._triggerCallback(config.callbacks.onSelectionChange, [instance.selected]);
                });
            }

            // Individual row checkboxes
            table.addEventListener('change', function(e) {
                if (e.target.classList.contains('geo-row-checkbox')) {
                    var instance = self.instances[tableId];
                    var key = e.target.getAttribute('data-row-key');

                    if (e.target.checked) {
                        if (key && instance.selected.indexOf(key) === -1) {
                            instance.selected.push(key);
                        }
                    } else {
                        instance.selected = instance.selected.filter(function(k) { return k !== key; });
                        if (selectAll) selectAll.checked = false;
                    }

                    self._updateBulkToolbar(tableId, instance.selected);
                    self._triggerCallback(config.callbacks.onSelectionChange, [instance.selected]);
                }
            });
        },

        _setupRowClick: function(tableId, config) {
            var self = this;
            var table = document.getElementById(tableId);
            if (!table) return;

            table.querySelector('tbody').addEventListener('click', function(e) {
                // Ignore clicks on checkboxes, buttons, links
                if (e.target.closest('input, button, a, .btn')) return;

                var row = e.target.closest('tr');
                if (row) {
                    var rowKey = row.getAttribute('data-row-key');
                    var rowData = row.getAttribute('data-row-data');
                    try { rowData = JSON.parse(rowData); } catch (e) { rowData = null; }

                    self._triggerCallback(config.callbacks.onRowClick, [rowKey, rowData, row]);
                }
            });
        },

        // ========================================
        // ROW DETAILS / EXPANDABLE ROWS
        // ========================================

        _setupRowDetails: function(tableId, config) {
            var self = this;
            var table = document.getElementById(tableId);
            if (!table) return;

            var tbody = table.querySelector('tbody');
            if (!tbody) return;

            // Store expanded rows state
            this.instances[tableId].expandedRows = {};

            // Handle click on expand toggle buttons
            tbody.addEventListener('click', function(e) {
                var toggleBtn = e.target.closest('.geo-row-expand-toggle');
                if (!toggleBtn) return;

                e.preventDefault();
                e.stopPropagation();

                var row = toggleBtn.closest('tr');
                if (!row) return;

                var rowKey = row.getAttribute('data-row-key');
                var isExpanded = row.classList.contains('geo-row-expanded');

                if (isExpanded) {
                    self._collapseRow(tableId, row, rowKey, config);
                } else {
                    self._expandRow(tableId, row, rowKey, config);
                }
            });

            // Also handle click on entire row if no rowClickable
            tbody.addEventListener('click', function(e) {
                // Skip if clicked on toggle button, checkbox, button, link, or actions
                if (e.target.closest('.geo-row-expand-toggle, input, button, a, .btn')) return;

                var row = e.target.closest('tr.geo-row-expandable');
                if (!row || row.classList.contains('geo-row-details')) return;

                var rowKey = row.getAttribute('data-row-key');
                var isExpanded = row.classList.contains('geo-row-expanded');

                if (isExpanded) {
                    self._collapseRow(tableId, row, rowKey, config);
                } else {
                    self._expandRow(tableId, row, rowKey, config);
                }
            });
        },

        _expandRow: function(tableId, row, rowKey, config) {
            var self = this;
            var instance = this.instances[tableId];

            // Mark row as expanded
            row.classList.add('geo-row-expanded');
            instance.expandedRows[rowKey] = true;

            // Update toggle icon
            var toggleBtn = row.querySelector('.geo-row-expand-toggle i');
            if (toggleBtn && config.rowDetailsIconExpanded) {
                toggleBtn.className = config.rowDetailsIconExpanded;
            }

            // Get row data
            var rowData = row.getAttribute('data-row-data');
            try { rowData = JSON.parse(rowData); } catch (e) { rowData = {}; }

            // Calculate colspan (all visible columns)
            var colspan = row.querySelectorAll('td').length;

            // Build details content
            var detailsHtml = this._buildRowDetailsContent(rowData, config);

            // Create details row
            var detailsRow = document.createElement('tr');
            detailsRow.className = 'geo-row-details';
            detailsRow.setAttribute('data-details-for', rowKey);

            var detailsTd = document.createElement('td');
            detailsTd.setAttribute('colspan', colspan);
            detailsTd.innerHTML = '<div class="geo-row-details-content' + (config.rowDetailsAnimation ? ' geo-animate' : '') + '">' + detailsHtml + '</div>';

            detailsRow.appendChild(detailsTd);

            // Insert after the row
            row.parentNode.insertBefore(detailsRow, row.nextSibling);

            // Trigger callback
            this._triggerCallback(config.callbacks.onRowExpand, [rowData, row, detailsRow]);
        },

        _collapseRow: function(tableId, row, rowKey, config) {
            var instance = this.instances[tableId];

            // Mark row as collapsed
            row.classList.remove('geo-row-expanded');
            delete instance.expandedRows[rowKey];

            // Update toggle icon
            var toggleBtn = row.querySelector('.geo-row-expand-toggle i');
            if (toggleBtn && config.rowDetailsIcon) {
                toggleBtn.className = config.rowDetailsIcon;
            }

            // Get row data for callback
            var rowData = row.getAttribute('data-row-data');
            try { rowData = JSON.parse(rowData); } catch (e) { rowData = {}; }

            // Remove details row
            var detailsRow = row.parentNode.querySelector('tr.geo-row-details[data-details-for="' + rowKey + '"]');
            if (detailsRow) {
                detailsRow.remove();
            }

            // Trigger callback
            this._triggerCallback(config.callbacks.onRowCollapse, [rowData, row]);
        },

        _buildRowDetailsContent: function(rowData, config) {
            var html = '<div class="geo-row-details-grid">';

            // Determine which columns to show
            var columnsToShow = config.rowDetailsColumns || config.columns;

            if (columnsToShow && columnsToShow.length) {
                columnsToShow.forEach(function(col) {
                    var key = typeof col === 'string' ? col : col.key;
                    var label = typeof col === 'string' ? key.replace(/_/g, ' ').replace(/\b\w/g, function(l) { return l.toUpperCase(); }) : (col.label || key);
                    var value = rowData[key];

                    // Format value
                    if (value === null || value === undefined) {
                        value = '';
                    } else if (typeof value === 'object') {
                        value = JSON.stringify(value);
                    }

                    html += '<div class="geo-row-details-item">';
                    html += '<span class="geo-row-details-label">' + label + '</span>';
                    html += '<span class="geo-row-details-value">' + value + '</span>';
                    html += '</div>';
                });
            } else {
                // Show all data if no columns specified
                Object.keys(rowData).forEach(function(key) {
                    var value = rowData[key];
                    var label = key.replace(/_/g, ' ').replace(/\b\w/g, function(l) { return l.toUpperCase(); });

                    // Format value
                    if (value === null || value === undefined) {
                        value = '';
                    } else if (typeof value === 'object') {
                        value = JSON.stringify(value);
                    }

                    html += '<div class="geo-row-details-item">';
                    html += '<span class="geo-row-details-label">' + label + '</span>';
                    html += '<span class="geo-row-details-value">' + value + '</span>';
                    html += '</div>';
                });
            }

            html += '</div>';
            return html;
        },

        /**
         * Expand a row programmatically
         * @param {string} tableId - The table element ID
         * @param {string} rowKey - The row key to expand
         */
        expandRow: function(tableId, rowKey) {
            var table = document.getElementById(tableId);
            if (!table) return;

            var row = table.querySelector('tr[data-row-key="' + rowKey + '"]');
            if (row && !row.classList.contains('geo-row-expanded')) {
                var config = this.instances[tableId]?.config;
                if (config) {
                    this._expandRow(tableId, row, rowKey, config);
                }
            }
        },

        /**
         * Collapse a row programmatically
         * @param {string} tableId - The table element ID
         * @param {string} rowKey - The row key to collapse
         */
        collapseRow: function(tableId, rowKey) {
            var table = document.getElementById(tableId);
            if (!table) return;

            var row = table.querySelector('tr[data-row-key="' + rowKey + '"]');
            if (row && row.classList.contains('geo-row-expanded')) {
                var config = this.instances[tableId]?.config;
                if (config) {
                    this._collapseRow(tableId, row, rowKey, config);
                }
            }
        },

        /**
         * Toggle a row's expanded state
         * @param {string} tableId - The table element ID
         * @param {string} rowKey - The row key to toggle
         */
        toggleRow: function(tableId, rowKey) {
            var table = document.getElementById(tableId);
            if (!table) return;

            var row = table.querySelector('tr[data-row-key="' + rowKey + '"]');
            if (row) {
                if (row.classList.contains('geo-row-expanded')) {
                    this.collapseRow(tableId, rowKey);
                } else {
                    this.expandRow(tableId, rowKey);
                }
            }
        },

        /**
         * Collapse all expanded rows
         * @param {string} tableId - The table element ID
         */
        collapseAllRows: function(tableId) {
            var self = this;
            var instance = this.instances[tableId];
            if (!instance) return;

            var expandedKeys = Object.keys(instance.expandedRows || {});
            expandedKeys.forEach(function(rowKey) {
                self.collapseRow(tableId, rowKey);
            });
        },

        _triggerCallback: function(callbackName, args) {
            if (callbackName && typeof window[callbackName] === 'function') {
                window[callbackName].apply(null, args);
            }
        }
    };
})();
</script>

{{-- Load DataTables Core --}}
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
@if($responsive ?? false)
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
@endif
@if($exportable ?? false)
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
@endif
@endpush
@endonce
@endif

{{-- ============================================ --}}
{{-- COMPONENT HTML                              --}}
{{-- ============================================ --}}

<div
    class="geo-datatable-wrapper {{ $wrapperClass }} {{ $loading ? 'geo-datatable-loading' : '' }}"
    data-geo-table="{{ $tableId }}"
    {{ $attributes }}
>
    {{-- Error State --}}
    @if($errorMessage)
    <div class="geo-datatable-error">
        <i class="ki-outline ki-cross-circle fs-3x text-danger mb-3"></i>
        <div>{{ $errorMessage }}</div>
    </div>
    @else

    {{-- Toolbar Slot --}}
    @if(isset($toolbar) || $showColumnToggle)
    <div class="geo-datatable-toolbar">
        {{-- Custom Toolbar Content --}}
        @if(isset($toolbar))
            {{ $toolbar }}
        @else
            <div></div>
        @endif

        {{-- Column Visibility Toggle --}}
        @if($showColumnToggle)
        <div class="geo-column-toggle" data-table-id="{{ $tableId }}">
            <button type="button" class="geo-column-toggle-btn" onclick="GeoTable.toggleColumnDropdown('{{ $tableId }}')">
                <i class="ki-outline ki-setting-2"></i>
                <span>{{ $columnToggleLabel }}</span>
                <i class="ki-outline ki-down fs-7"></i>
            </button>
            <div class="geo-column-dropdown" id="{{ $tableId }}_column_dropdown">
                <div class="geo-column-dropdown-header">Toggle Columns</div>
                <div class="geo-column-dropdown-body">
                    @foreach($normalizedColumns as $colIndex => $column)
                    <div class="geo-column-item">
                        <input
                            type="checkbox"
                            id="{{ $tableId }}_col_{{ $colIndex }}"
                            data-column-index="{{ $colIndex }}"
                            {{ !in_array($column['key'], $hiddenColumns) && ($column['visible'] !== false) ? 'checked' : '' }}
                            onchange="GeoTable.toggleColumn('{{ $tableId }}', {{ $colIndex }}, this.checked)"
                        />
                        <label for="{{ $tableId }}_col_{{ $colIndex }}">{{ $column['label'] }}</label>
                    </div>
                    @endforeach
                </div>
                <div class="geo-column-dropdown-footer">
                    <button type="button" class="geo-column-show-all" onclick="GeoTable.showAllColumns('{{ $tableId }}')">
                        Show All
                    </button>
                </div>
            </div>
        </div>
        @endif
    </div>
    @endif

    {{-- Bulk Actions Toolbar --}}
    @if($hasBulkActions)
    <div class="geo-bulk-toolbar" id="{{ $tableId }}_bulk_toolbar">
        @if($showBulkActionsCount)
        <div class="geo-bulk-count">
            <span class="count-badge" id="{{ $tableId }}_selected_count">0</span>
            <span>items selected</span>
        </div>
        @endif

        <button type="button" class="geo-bulk-clear" onclick="GeoTable.clearSelection('{{ $tableId }}')">
            <i class="ki-outline ki-cross-square fs-6"></i>
            Clear
        </button>

        <div class="geo-bulk-actions">
            @foreach($bulkActions as $action)
            @php
                $confirmParam = isset($action['confirm']) ? "'" . addslashes($action['confirm']) . "'" : 'null';
            @endphp
            <button
                type="button"
                class="btn {{ $action['class'] ?? 'btn-light-primary' }}"
                onclick="GeoTable.executeBulkAction('{{ $tableId }}', '{{ $action['key'] }}', {{ $confirmParam }})"
            >
                @if(!empty($action['icon']))
                <i class="{{ $action['icon'] }}"></i>
                @endif
                {{ $action['label'] }}
            </button>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Table Card --}}
    <div class="table-responsive">
        <table
            id="{{ $tableId }}"
            class="{{ $computedTableClass }}"
            data-row-key="{{ $rowKey }}"
        >
            {{-- Table Header --}}
            <thead class="{{ $headerClass }}">
                <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase">
                    {{-- Expand Toggle Column --}}
                    @if($rowDetails)
                    <th class="w-10px pe-2 geo-col-fixed geo-col-expand"></th>
                    @endif

                    {{-- Checkbox Column --}}
                    @if($selectable)
                    <th class="w-10px pe-2 geo-col-fixed">
                        <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                            <input
                                class="form-check-input geo-select-all"
                                type="checkbox"
                                value="all"
                                aria-label="Select all rows"
                            />
                        </div>
                    </th>
                    @endif

                    {{-- Index Column --}}
                    @if($showIndex)
                    <th class="w-50px geo-col-fixed">{{ $indexLabel }}</th>
                    @endif

                    {{-- Data Columns --}}
                    @foreach($normalizedColumns as $colIdx => $column)
                    @if($column['visible'] !== false)
                    <th
                        class="{{ $column['headerClass'] }}"
                        data-column-key="{{ $column['key'] }}"
                        @if($column['width']) style="width: {{ $column['width'] }}" @endif
                    >
                        {{ $column['label'] }}
                    </th>
                    @endif
                    @endforeach

                    {{-- Actions Column --}}
                    @if($showActions)
                    <th
                        class="text-end geo-col-fixed"
                        @if($actionsWidth) style="width: {{ $actionsWidth }}" @endif
                    >
                        {{ $actionsLabel }}
                    </th>
                    @endif
                </tr>
            </thead>

            {{-- Table Body --}}
            <tbody class="fw-semibold text-gray-600 {{ $bodyClass }}">
                @forelse($tableData as $index => $row)
                @php
                    $rowKeyValue = is_array($row) ? ($row[$rowKey] ?? $index) : ($row->{$rowKey} ?? $index);
                    $rowIsArray = is_array($row);
                @endphp
                <tr
                    class="{{ $rowClass }} {{ $rowClickable ? 'geo-row-clickable' : '' }} {{ $rowDetails ? 'geo-row-expandable' : '' }}"
                    data-row-key="{{ $rowKeyValue }}"
                    data-row-data="{{ json_encode($row) }}"
                    @foreach($rowAttributes as $attrKey => $attrValue)
                    {{ $attrKey }}="{{ is_callable($attrValue) ? $attrValue($row) : $attrValue }}"
                    @endforeach
                    @if($rowClickable && $rowUrl)
                    onclick="window.location='{{ str_replace('{id}', $rowKeyValue, $rowUrl) }}'"
                    @endif
                >
                    {{-- Expand Toggle Cell --}}
                    @if($rowDetails)
                    <td class="geo-col-expand">
                        <button type="button" class="geo-row-expand-toggle" aria-label="Expand row details" data-row-key="{{ $rowKeyValue }}">
                            <i class="{{ $rowDetailsIcon }}"></i>
                        </button>
                    </td>
                    @endif

                    {{-- Checkbox Cell --}}
                    @if($selectable)
                    <td>
                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                            <input
                                class="form-check-input geo-row-checkbox"
                                type="checkbox"
                                value="{{ $rowKeyValue }}"
                                data-row-key="{{ $rowKeyValue }}"
                                aria-label="Select row {{ $rowKeyValue }}"
                            />
                        </div>
                    </td>
                    @endif

                    {{-- Index Cell --}}
                    @if($showIndex)
                    <td>{{ $index + 1 }}</td>
                    @endif

                    {{-- Data Cells --}}
                    @foreach($normalizedColumns as $column)
                    @if($column['visible'] !== false)
                    @php
                        $cellValue = $rowIsArray ? ($row[$column['key']] ?? '') : ($row->{$column['key']} ?? '');
                    @endphp
                    <td class="{{ $column['class'] }}">
                        {{-- Check for custom view path first --}}
                        @if(!empty($column['view']))
                            @include($column['view'], ['row' => $row, 'value' => $cellValue, 'column' => $column, 'index' => $index])
                        @else
                            {{-- Built-in renderers --}}
                            @switch($column['render'] ?? null)
                                @case('date')
                                    {{ $cellValue ? \Carbon\Carbon::parse($cellValue)->format($column['format'] ?? 'M d, Y') : '-' }}
                                    @break
                                @case('datetime')
                                    {{ $cellValue ? \Carbon\Carbon::parse($cellValue)->format($column['format'] ?? 'M d, Y H:i') : '-' }}
                                    @break
                                @case('time')
                                    {{ $cellValue ? \Carbon\Carbon::parse($cellValue)->format($column['format'] ?? 'H:i') : '-' }}
                                    @break
                                @case('relative')
                                    <span title="{{ $cellValue ? \Carbon\Carbon::parse($cellValue)->format('M d, Y H:i') : '' }}">
                                        {{ $cellValue ? \Carbon\Carbon::parse($cellValue)->diffForHumans() : '-' }}
                                    </span>
                                    @break
                                @case('currency')
                                    @php
                                        $currencySymbol = $column['symbol'] ?? '$';
                                        $decimals = $column['decimals'] ?? 2;
                                    @endphp
                                    {{ $currencySymbol }}{{ $cellValue ? number_format((float)$cellValue, $decimals) : '0.00' }}
                                    @break
                                @case('number')
                                    @php
                                        $decimals = $column['decimals'] ?? 0;
                                        $suffix = $column['suffix'] ?? '';
                                        $prefix = $column['prefix'] ?? '';
                                    @endphp
                                    {{ $prefix }}{{ $cellValue !== null && $cellValue !== '' ? number_format((float)$cellValue, $decimals) : '-' }}{{ $suffix }}
                                    @break
                                @case('percent')
                                    @php
                                        $decimals = $column['decimals'] ?? 1;
                                    @endphp
                                    {{ $cellValue !== null && $cellValue !== '' ? number_format((float)$cellValue, $decimals) . '%' : '-' }}
                                    @break
                                @case('badge')
                                    @php
                                        // Support custom badge colors via 'colors' array in column config
                                        $colors = $column['colors'] ?? [];
                                        $badgeColor = $colors[$cellValue] ?? ($cellValue ? 'success' : 'danger');
                                    @endphp
                                    <span class="badge badge-light-{{ $badgeColor }}">
                                        {{ $cellValue ?: 'N/A' }}
                                    </span>
                                    @break
                                @case('status')
                                    @php
                                        // Status with configurable label/color mappings
                                        $statuses = $column['statuses'] ?? [
                                            'active' => ['label' => 'Active', 'color' => 'success'],
                                            'inactive' => ['label' => 'Inactive', 'color' => 'danger'],
                                            'pending' => ['label' => 'Pending', 'color' => 'warning'],
                                            'draft' => ['label' => 'Draft', 'color' => 'secondary'],
                                        ];
                                        $statusKey = strtolower($cellValue ?? '');
                                        $status = $statuses[$statusKey] ?? ['label' => $cellValue, 'color' => 'secondary'];
                                    @endphp
                                    <span class="badge badge-light-{{ $status['color'] }}">
                                        {{ $status['label'] }}
                                    </span>
                                    @break
                                @case('boolean')
                                    @if($cellValue)
                                        <i class="ki-outline ki-check-circle text-success fs-4"></i>
                                    @else
                                        <i class="ki-outline ki-cross-circle text-danger fs-4"></i>
                                    @endif
                                    @break
                                @case('yesno')
                                    <span class="badge badge-light-{{ $cellValue ? 'success' : 'danger' }}">
                                        {{ $cellValue ? ($column['yes'] ?? 'Yes') : ($column['no'] ?? 'No') }}
                                    </span>
                                    @break
                                @case('image')
                                    @if($cellValue)
                                        <img
                                            src="{{ $cellValue }}"
                                            alt=""
                                            class="rounded {{ $column['imageClass'] ?? '' }}"
                                            style="width: {{ $column['imageWidth'] ?? '40px' }}; height: {{ $column['imageHeight'] ?? '40px' }}; object-fit: cover;"
                                        />
                                    @else
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: {{ $column['imageWidth'] ?? '40px' }}; height: {{ $column['imageHeight'] ?? '40px' }};">
                                            <i class="ki-outline ki-picture text-muted fs-5"></i>
                                        </div>
                                    @endif
                                    @break
                                @case('avatar')
                                    @php
                                        $size = $column['size'] ?? '35px';
                                        $nameField = $column['nameField'] ?? null;
                                        $name = $nameField ? ($rowIsArray ? ($row[$nameField] ?? '') : ($row->{$nameField} ?? '')) : '';
                                        $initials = collect(explode(' ', $name))->take(2)->map(fn($w) => strtoupper(substr($w, 0, 1)))->join('');
                                    @endphp
                                    @if($cellValue)
                                        <img src="{{ $cellValue }}" alt="{{ $name }}" class="rounded-circle" style="width: {{ $size }}; height: {{ $size }}; object-fit: cover;" />
                                    @else
                                        <div class="symbol symbol-circle bg-light-primary" style="width: {{ $size }}; height: {{ $size }};">
                                            <span class="symbol-label fs-7 fw-semibold text-primary">{{ $initials ?: '?' }}</span>
                                        </div>
                                    @endif
                                    @break
                                @case('link')
                                    @php
                                        $linkUrl = $column['url'] ?? $cellValue;
                                        $linkTarget = $column['target'] ?? '_self';
                                        $linkLabel = $column['linkLabel'] ?? $cellValue;
                                        // Support placeholders like {id}, {slug} in URL
                                        foreach ($row as $key => $val) {
                                            if (is_scalar($val)) {
                                                $linkUrl = str_replace('{' . $key . '}', $val, $linkUrl);
                                            }
                                        }
                                    @endphp
                                    @if($cellValue)
                                        <a href="{{ $linkUrl }}" target="{{ $linkTarget }}" class="text-primary fw-semibold text-hover-primary">
                                            {{ $linkLabel }}
                                        </a>
                                    @else
                                        -
                                    @endif
                                    @break
                                @case('email')
                                    @if($cellValue)
                                        <a href="mailto:{{ $cellValue }}" class="text-primary text-hover-primary">
                                            {{ $cellValue }}
                                        </a>
                                    @else
                                        -
                                    @endif
                                    @break
                                @case('phone')
                                    @if($cellValue)
                                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $cellValue) }}" class="text-primary text-hover-primary">
                                            {{ $cellValue }}
                                        </a>
                                    @else
                                        -
                                    @endif
                                    @break
                                @case('truncate')
                                    @php
                                        $maxLength = $column['maxLength'] ?? 50;
                                    @endphp
                                    @if(strlen($cellValue) > $maxLength)
                                        <span title="{{ $cellValue }}">
                                            {{ substr($cellValue, 0, $maxLength) }}...
                                        </span>
                                    @else
                                        {{ $cellValue }}
                                    @endif
                                    @break
                                @case('html')
                                    {!! $cellValue !!}
                                    @break
                                @default
                                    {{ $cellValue }}
                            @endswitch
                        @endif
                    </td>
                    @endif
                    @endforeach

                    {{-- Actions Cell --}}
                    @if($showActions)
                    <td class="text-end">
                        @if($actionsView)
                            @include($actionsView, ['row' => $row, 'index' => $index])
                        @elseif(isset($actions))
                            {{ $actions }}
                        @endif
                    </td>
                    @endif
                </tr>
                @empty
                {{-- Empty State (only for static data, AJAX tables handle this via DataTables) --}}
                @if(!$ajaxUrl && !$needsDataTable)
                <tr>
                    <td colspan="{{ count($normalizedColumns) + ($selectable ? 1 : 0) + ($showIndex ? 1 : 0) + ($showActions ? 1 : 0) }}">
                        @if(isset($empty))
                            {{ $empty }}
                        @else
                        <div class="geo-datatable-empty">
                            <i class="{{ $emptyIcon }}"></i>
                            <div>{{ $emptyMessage }}</div>
                        </div>
                        @endif
                    </td>
                </tr>
                @endif
                @endforelse
            </tbody>
        </table>
    </div>

    @endif {{-- End error check --}}
</div>

{{-- ============================================ --}}
{{-- INITIALIZE DATATABLE (IF ENABLED)          --}}
{{-- ============================================ --}}
@if($needsDataTable)
@push('scripts')
<script>
(function() {
    'use strict';

    var tableConfig = @json($tableConfig);

    // Initialize when DOM is ready
    function initTable() {
        if (typeof GeoTable !== 'undefined') {
            GeoTable.init('{{ $tableId }}', tableConfig);
        } else {
            setTimeout(initTable, 50);
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initTable);
    } else {
        initTable();
    }
})();
</script>
@endpush
@endif
