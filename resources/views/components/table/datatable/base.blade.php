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
        'render'      => 'date|currency|badge', // Optional: built-in renderers
        'format'      => 'Y-m-d',           // Optional: format parameter for render
    ]

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
    // CALLBACKS (JavaScript function names)
    // ============================================
    'onInit' => null,                       // Callback after table init
    'onDraw' => null,                       // Callback after table draw
    'onRowClick' => null,                   // Callback for row click
    'onSelectionChange' => null,            // Callback when selection changes
    'onAjaxError' => null,                  // Callback for AJAX errors
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
        'callbacks' => [
            'onInit' => $onInit,
            'onDraw' => $onDraw,
            'onRowClick' => $onRowClick,
            'onSelectionChange' => $onSelectionChange,
            'onAjaxError' => $onAjaxError,
        ],
    ];
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
    /* Responsive Adjustments                      */
    /* ============================================ */
    @media (max-width: 768px) {
        .geo-datatable-toolbar {
            flex-direction: column;
            align-items: stretch;
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

            // Trigger init callback
            this._triggerCallback(config.callbacks.onInit, [dt, tableId]);
        },

        _buildDTOptions: function(tableId, config) {
            var self = this;
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
                language: {
                    emptyTable: '<div class="geo-datatable-empty"><i class="ki-outline ki-file-deleted"></i><div>No data available</div></div>',
                    zeroRecords: '<div class="geo-datatable-empty"><i class="ki-outline ki-magnifier"></i><div>No matching records found</div></div>',
                    processing: '<div class="spinner-border spinner-border-sm text-primary" role="status"><span class="visually-hidden">Loading...</span></div>'
                },
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
    @if(isset($toolbar))
    <div class="geo-datatable-toolbar">
        {{ $toolbar }}
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
                    {{-- Checkbox Column --}}
                    @if($selectable)
                    <th class="w-10px pe-2">
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
                    <th class="w-50px">{{ $indexLabel }}</th>
                    @endif

                    {{-- Data Columns --}}
                    @foreach($normalizedColumns as $column)
                    @if($column['visible'] !== false)
                    <th
                        class="{{ $column['headerClass'] }}"
                        @if($column['width']) style="width: {{ $column['width'] }}" @endif
                    >
                        {{ $column['label'] }}
                    </th>
                    @endif
                    @endforeach

                    {{-- Actions Column --}}
                    @if($showActions)
                    <th
                        class="text-end"
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
                    class="{{ $rowClass }} {{ $rowClickable ? 'geo-row-clickable' : '' }}"
                    data-row-key="{{ $rowKeyValue }}"
                    data-row-data="{{ json_encode($row) }}"
                    @foreach($rowAttributes as $attrKey => $attrValue)
                    {{ $attrKey }}="{{ is_callable($attrValue) ? $attrValue($row) : $attrValue }}"
                    @endforeach
                    @if($rowClickable && $rowUrl)
                    onclick="window.location='{{ str_replace('{id}', $rowKeyValue, $rowUrl) }}'"
                    @endif
                >
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
                                @case('currency')
                                    {{ $cellValue ? number_format((float)$cellValue, 2) : '0.00' }}
                                    @break
                                @case('badge')
                                    <span class="badge badge-light-{{ $cellValue ? 'success' : 'danger' }}">
                                        {{ $cellValue ?: 'N/A' }}
                                    </span>
                                    @break
                                @case('boolean')
                                    @if($cellValue)
                                        <i class="ki-outline ki-check-circle text-success fs-4"></i>
                                    @else
                                        <i class="ki-outline ki-cross-circle text-danger fs-4"></i>
                                    @endif
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
