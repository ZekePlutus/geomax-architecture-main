{{--
    ================================================================================
    GENERIC AG GRID COMPONENT - FOUNDATION LAYER
    ================================================================================

    A highly flexible, configuration-driven AG Grid data table component designed for
    multi-tenant SaaS applications. This component is part of the global UI layer
    and contains NO business logic or module-specific assumptions.

    DESIGN PRINCIPLES:
    - Configuration over convention
    - Every feature is opt-in
    - Abstract column definitions
    - Enterprise-upgrade ready (community edition by default)

    ================================================================================
    USAGE EXAMPLES
    ================================================================================

    1. SIMPLE STATIC TABLE
    ----------------------
    <x-table.aggrid.base
        :columns="[
            ['key' => 'name', 'label' => 'Name'],
            ['key' => 'email', 'label' => 'Email'],
            ['key' => 'status', 'label' => 'Status'],
        ]"
        :data="$users"
    />

    2. TABLE WITH SORTING & FILTERING
    ---------------------------------
    <x-table.aggrid.base
        id="users-grid"
        :columns="[
            ['key' => 'id', 'label' => 'ID', 'sortable' => true, 'filter' => 'number'],
            ['key' => 'name', 'label' => 'Name', 'sortable' => true, 'filter' => 'text'],
            ['key' => 'email', 'label' => 'Email', 'filter' => 'text'],
            ['key' => 'status', 'label' => 'Status', 'filter' => 'set'],
            ['key' => 'created_at', 'label' => 'Created', 'sortable' => true, 'filter' => 'date'],
        ]"
        :data="$users"
        :sortable="true"
        :filterable="true"
    />

    3. TABLE WITH ROW SELECTION
    ---------------------------
    <x-table.aggrid.base
        :columns="$columns"
        :data="$users"
        :selectable="true"
        selection-mode="multiple"
        row-key="id"
        on-selection-change="handleSelectionChange"
    />

    4. TABLE WITH PAGINATION
    ------------------------
    <x-table.aggrid.base
        :columns="$columns"
        :data="$users"
        :pagination="true"
        :page-size="25"
        :page-size-options="[10, 25, 50, 100]"
    />

    5. SERVER-SIDE DATA SOURCE
    --------------------------
    <x-table.aggrid.base
        :columns="$columns"
        ajax-url="/api/users"
        :server-side="true"
        :pagination="true"
    />

    6. TABLE WITH CUSTOM CELL RENDERING
    -----------------------------------
    <x-table.aggrid.base
        :columns="[
            ['key' => 'name', 'label' => 'Name'],
            ['key' => 'status', 'label' => 'Status', 'render' => 'badge', 'colors' => ['active' => 'success', 'inactive' => 'danger']],
            ['key' => 'amount', 'label' => 'Amount', 'render' => 'currency', 'symbol' => '$'],
        ]"
        :data="$users"
    />

    7. TABLE WITH COLUMN PINNING
    ----------------------------
    <x-table.aggrid.base
        :columns="[
            ['key' => 'id', 'label' => 'ID', 'pinned' => 'left'],
            ['key' => 'name', 'label' => 'Name'],
            ['key' => 'actions', 'label' => 'Actions', 'pinned' => 'right'],
        ]"
        :data="$users"
    />

    8. TABLE WITH ACTIONS COLUMN
    ----------------------------
    <x-table.aggrid.base
        :columns="$columns"
        :data="$users"
        :show-actions="true"
        row-key="id"
    >
        <x-slot:actions="['row' => $row]">
            <a href="#" class="btn btn-sm btn-light">Edit</a>
            <button class="btn btn-sm btn-light-danger">Delete</button>
        </x-slot:actions>
    </x-table.aggrid.base>

    ================================================================================
    COLUMN DEFINITION SCHEMA
    ================================================================================

    Each column in the columns array supports:

    [
        'key'           => 'field_name',        // Required: data field key
        'label'         => 'Display Name',      // Required: column header
        'sortable'      => true|false,          // Optional: enable sorting (default: false)
        'filter'        => 'text|number|date|set|boolean', // Optional: filter type
        'visible'       => true|false,          // Optional: show/hide column (default: true)
        'width'         => 100,                 // Optional: column width in pixels
        'minWidth'      => 50,                  // Optional: minimum width
        'maxWidth'      => 300,                 // Optional: maximum width
        'flex'          => 1,                   // Optional: flex sizing
        'resizable'     => true|false,          // Optional: allow resize (default: true)
        'pinned'        => 'left'|'right',      // Optional: pin column
        'class'         => 'text-center',       // Optional: cell CSS class
        'headerClass'   => 'bg-light',          // Optional: header CSS class
        'render'        => 'date|currency|...', // Optional: built-in renderer
        'format'        => 'Y-m-d',             // Optional: format for render

        // Renderer-specific options (same as DataTable):
        'symbol'        => '$',                 // For currency
        'decimals'      => 2,                   // For currency, number, percent
        'colors'        => [],                  // For badge: ['value' => 'color']
        'statuses'      => [],                  // For status
        'yes'           => 'Yes',               // For yesno
        'no'            => 'No',                // For yesno
        'imageWidth'    => '40px',              // For image
        'imageHeight'   => '40px',              // For image
        'size'          => '35px',              // For avatar
        'maxLength'     => 50,                  // For truncate
    ]

    BUILT-IN RENDERERS:
    - date          : Format date (M d, Y)
    - datetime      : Format datetime (M d, Y H:i)
    - time          : Format time (H:i)
    - relative      : Human readable time
    - currency      : Format as currency
    - number        : Format number
    - percent       : Format as percentage
    - badge         : Display as badge
    - status        : Display as status badge
    - boolean       : Show check/cross icon
    - yesno         : Show Yes/No badge
    - image         : Display image thumbnail
    - avatar        : Display avatar
    - link          : Clickable link
    - email         : Mailto link
    - phone         : Tel link
    - truncate      : Truncate with tooltip
    - html          : Render raw HTML

    ================================================================================
    JS API (GeoGrid)
    ================================================================================

    // Access grid instance
    window.GeoGrid.getInstance('grid-id')

    // Get selected rows
    window.GeoGrid.getSelectedRows('grid-id')

    // Clear selection
    window.GeoGrid.clearSelection('grid-id')

    // Refresh data
    window.GeoGrid.refresh('grid-id')

    // Export
    window.GeoGrid.exportCsv('grid-id')

    // Apply filter
    window.GeoGrid.setFilter('grid-id', 'columnKey', { type: 'contains', filter: 'value' })

    // Clear all filters
    window.GeoGrid.clearFilters('grid-id')

    // Get/Set column state
    window.GeoGrid.getColumnState('grid-id')
    window.GeoGrid.setColumnState('grid-id', state)

    ================================================================================
--}}

@props([
    // ============================================
    // IDENTIFICATION
    // ============================================
    'id' => null,                           // Unique grid ID (auto-generated if null)

    // ============================================
    // TABLE STRUCTURE
    // ============================================
    'columns' => [],                        // Array of column definitions
    'rowKey' => 'id',                       // Field to use as row identifier
    'showIndex' => false,                   // Show row index column
    'indexLabel' => '#',                    // Label for index column
    'showActions' => false,                 // Show actions column
    'actionsLabel' => 'Actions',            // Label for actions column
    'actionsWidth' => 120,                  // Width for actions column (pixels)
    'actionsPinned' => 'right',             // Pin actions column ('left', 'right', null)

    // ============================================
    // DATA SOURCE
    // ============================================
    'data' => [],                           // Static data array
    'ajaxUrl' => null,                      // URL for AJAX data source
    'serverSide' => false,                  // Enable server-side mode

    // ============================================
    // SORTING
    // ============================================
    'sortable' => true,                     // Enable sorting globally
    'multiSort' => false,                   // Allow multi-column sorting
    'defaultSort' => null,                  // Default sort: ['key' => 'asc']

    // ============================================
    // FILTERING
    // ============================================
    'filterable' => false,                  // Enable column filters
    'floatingFilter' => false,              // Show floating filter row below headers
    'quickFilter' => false,                 // Enable quick filter (search all)

    // ============================================
    // PAGINATION
    // ============================================
    'pagination' => false,                  // Enable pagination
    'pageSize' => 25,                       // Default page size
    'pageSizeOptions' => [10, 25, 50, 100], // Page size options

    // ============================================
    // ROW SELECTION
    // ============================================
    'selectable' => false,                  // Enable row selection
    'selectionMode' => 'multiple',          // 'single' or 'multiple'
    'checkboxSelection' => true,            // Use checkboxes for selection
    'headerCheckbox' => true,               // Show select all checkbox in header

    // ============================================
    // COLUMN SIZING & FEATURES
    // ============================================
    'resizable' => true,                    // Allow column resize
    'autoSizeColumns' => false,             // Auto-size columns to fit content
    'suppressMovable' => false,             // Prevent column reordering

    // ============================================
    // APPEARANCE
    // ============================================
    'theme' => 'quartz',                    // Grid theme: 'quartz', 'alpine', 'balham', 'material'
    'darkMode' => false,                    // Enable dark mode variant
    'height' => '500px',                    // Grid height (CSS value)
    'minHeight' => '300px',                 // Minimum height
    'rowHeight' => null,                    // Custom row height (pixels)
    'headerHeight' => null,                 // Custom header height (pixels)
    'domLayout' => 'normal',                // 'normal', 'autoHeight', 'print'
    'class' => '',                          // Additional CSS classes for wrapper
    'loading' => false,                     // Show loading overlay initially

    // ============================================
    // EMPTY STATE
    // ============================================
    'emptyMessage' => 'No data available',
    'emptyIcon' => 'ki-outline ki-file-deleted',
    'loadingMessage' => 'Loading...',

    // ============================================
    // EXPORT (Community: CSV only)
    // ============================================
    'exportable' => false,                  // Enable export functionality
    'exportFilename' => 'export',           // Export filename

    // ============================================
    // STATE PERSISTENCE
    // ============================================
    'stateSave' => false,                   // Save column state to localStorage

    // ============================================
    // CALLBACKS (JavaScript function names)
    // ============================================
    'onInit' => null,                       // Called after grid initialized
    'onRowClick' => null,                   // Called on row click
    'onSelectionChange' => null,            // Called when selection changes
    'onSortChange' => null,                 // Called when sort changes
    'onFilterChange' => null,               // Called when filters change
    'onColumnResize' => null,               // Called when column resized
    'onColumnMove' => null,                 // Called when column moved
])

@php
    // Generate unique ID if not provided
    $gridId = $id ?? 'geo-grid-' . uniqid();

    // Normalize columns to standard format
    $normalizedColumns = collect($columns)->map(function ($col) use ($sortable, $filterable, $resizable) {
        // Handle simple string columns
        if (is_string($col)) {
            return [
                'key' => $col,
                'label' => ucfirst(str_replace('_', ' ', $col)),
                'sortable' => $sortable,
                'filter' => $filterable ? 'text' : false,
                'resizable' => $resizable,
            ];
        }

        // Ensure defaults for array columns
        return array_merge([
            'key' => '',
            'label' => '',
            'sortable' => $sortable,
            'filter' => $filterable ? 'text' : false,
            'visible' => true,
            'resizable' => $resizable,
            'width' => null,
            'minWidth' => null,
            'maxWidth' => null,
            'flex' => null,
            'pinned' => null,
            'class' => null,
            'headerClass' => null,
            'render' => null,
            'format' => null,
        ], $col);
    })->toArray();

    // Determine theme class
    $themeClass = match($theme) {
        'alpine' => $darkMode ? 'ag-theme-alpine-dark' : 'ag-theme-alpine',
        'balham' => $darkMode ? 'ag-theme-balham-dark' : 'ag-theme-balham',
        'material' => $darkMode ? 'ag-theme-material-dark' : 'ag-theme-material',
        default => $darkMode ? 'ag-theme-quartz-dark' : 'ag-theme-quartz',
    };

    // Build grid configuration for JavaScript
    $gridConfig = [
        'id' => $gridId,
        'columns' => $normalizedColumns,
        'rowKey' => $rowKey,
        'showIndex' => $showIndex,
        'indexLabel' => $indexLabel,
        'showActions' => $showActions,
        'actionsLabel' => $actionsLabel,
        'actionsWidth' => $actionsWidth,
        'actionsPinned' => $actionsPinned,
        // Data
        'data' => !$ajaxUrl ? $data : [],
        'ajaxUrl' => $ajaxUrl,
        'serverSide' => $serverSide,
        // Sorting
        'sortable' => $sortable,
        'multiSort' => $multiSort,
        'defaultSort' => $defaultSort,
        // Filtering
        'filterable' => $filterable,
        'floatingFilter' => $floatingFilter,
        'quickFilter' => $quickFilter,
        // Pagination
        'pagination' => $pagination,
        'pageSize' => $pageSize,
        'pageSizeOptions' => $pageSizeOptions,
        // Selection
        'selectable' => $selectable,
        'selectionMode' => $selectionMode,
        'checkboxSelection' => $checkboxSelection,
        'headerCheckbox' => $headerCheckbox,
        // Column features
        'resizable' => $resizable,
        'autoSizeColumns' => $autoSizeColumns,
        'suppressMovable' => $suppressMovable,
        // Appearance
        'theme' => $theme,
        'darkMode' => $darkMode,
        'rowHeight' => $rowHeight,
        'headerHeight' => $headerHeight,
        'domLayout' => $domLayout,
        // Empty/Loading
        'emptyMessage' => $emptyMessage,
        'loadingMessage' => $loadingMessage,
        // Export
        'exportable' => $exportable,
        'exportFilename' => $exportFilename,
        // State
        'stateSave' => $stateSave,
        // Callbacks
        'callbacks' => [
            'onInit' => $onInit,
            'onRowClick' => $onRowClick,
            'onSelectionChange' => $onSelectionChange,
            'onSortChange' => $onSortChange,
            'onFilterChange' => $onFilterChange,
            'onColumnResize' => $onColumnResize,
            'onColumnMove' => $onColumnMove,
        ],
    ];
@endphp

{{-- ========================================== --}}
{{-- AG GRID CDN STYLES                         --}}
{{-- ========================================== --}}
@once
    @push('styles')
        {{-- AG Grid Community CSS --}}
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ag-grid-community@32.3.3/styles/ag-grid.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ag-grid-community@32.3.3/styles/ag-theme-quartz.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ag-grid-community@32.3.3/styles/ag-theme-alpine.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ag-grid-community@32.3.3/styles/ag-theme-balham.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ag-grid-community@32.3.3/styles/ag-theme-material.css">

        <style>
            /* ========================================== */
            /* AG Grid Component - Custom Styles          */
            /* ========================================== */

            .geo-grid-wrapper {
                position: relative;
            }

            .geo-grid-toolbar {
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                gap: 1rem;
                margin-bottom: 1rem;
            }

            .geo-grid-toolbar-left {
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }

            .geo-grid-toolbar-right {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                margin-left: auto;
            }

            .geo-grid-quick-filter {
                min-width: 250px;
            }

            /* Selection count badge */
            .geo-grid-selection-count {
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                padding: 0.4rem 0.8rem;
                background: var(--bs-primary);
                color: white;
                border-radius: 0.375rem;
                font-size: 0.875rem;
                font-weight: 500;
            }

            /* Custom cell renderers */
            .geo-grid-badge {
                display: inline-flex;
                align-items: center;
                padding: 0.25rem 0.5rem;
                border-radius: 0.25rem;
                font-size: 0.8rem;
                font-weight: 500;
            }

            .geo-grid-avatar {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border-radius: 50%;
                background: var(--bs-gray-300);
                color: var(--bs-gray-700);
                font-weight: 600;
                font-size: 0.75rem;
                overflow: hidden;
            }

            .geo-grid-avatar img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .geo-grid-boolean-true {
                color: var(--bs-success);
            }

            .geo-grid-boolean-false {
                color: var(--bs-danger);
            }

            .geo-grid-link {
                color: var(--bs-primary);
                text-decoration: none;
            }

            .geo-grid-link:hover {
                text-decoration: underline;
            }

            .geo-grid-truncate {
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }

            /* Actions cell */
            .geo-grid-actions {
                display: flex;
                align-items: center;
                gap: 0.25rem;
            }

            /* Empty overlay custom styling */
            .geo-grid-empty-overlay {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                height: 100%;
                padding: 2rem;
            }

            .geo-grid-empty-overlay i {
                font-size: 3rem;
                color: var(--bs-gray-400);
                margin-bottom: 1rem;
            }

            .geo-grid-empty-overlay span {
                color: var(--bs-gray-600);
                font-size: 1rem;
            }

            /* Dark mode adjustments */
            [data-bs-theme="dark"] .geo-grid-avatar {
                background: var(--bs-gray-700);
                color: var(--bs-gray-300);
            }

            /* Loading overlay */
            .geo-grid-loading-overlay {
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }

            /* Fix for AG Grid in modals */
            .modal .ag-root-wrapper {
                border-radius: 0.375rem;
            }
        </style>
    @endpush
@endonce

{{-- ========================================== --}}
{{-- GRID WRAPPER                               --}}
{{-- ========================================== --}}
<div
    id="{{ $gridId }}-wrapper"
    class="geo-grid-wrapper {{ $class }}"
    data-grid-id="{{ $gridId }}"
>
    {{-- Toolbar Slot --}}
    @if(isset($toolbar))
        <div class="geo-grid-toolbar">
            {{ $toolbar }}
        </div>
    @elseif($quickFilter || $exportable || $selectable)
        <div class="geo-grid-toolbar">
            <div class="geo-grid-toolbar-left">
                {{-- Quick Filter --}}
                @if($quickFilter)
                    <div class="geo-grid-quick-filter">
                        <input
                            type="text"
                            class="form-control form-control-sm"
                            placeholder="Search..."
                            data-grid-quick-filter="{{ $gridId }}"
                        >
                    </div>
                @endif

                {{-- Selection Count (shown when rows selected) --}}
                @if($selectable)
                    <div
                        id="{{ $gridId }}-selection-count"
                        class="geo-grid-selection-count"
                        style="display: none;"
                    >
                        <span data-selected-count>0</span> selected
                    </div>
                @endif
            </div>

            <div class="geo-grid-toolbar-right">
                {{-- Export Button --}}
                @if($exportable)
                    <button
                        type="button"
                        class="btn btn-sm btn-light-primary"
                        onclick="GeoGrid.exportCsv('{{ $gridId }}')"
                    >
                        <i class="ki-outline ki-file-down me-1"></i>
                        Export CSV
                    </button>
                @endif
            </div>
        </div>
    @endif

    {{-- The Grid Container --}}
    <div
        id="{{ $gridId }}"
        class="{{ $themeClass }}"
        style="height: {{ $height }}; min-height: {{ $minHeight }};"
    ></div>
</div>

{{-- ========================================== --}}
{{-- ACTIONS TEMPLATE (Hidden)                  --}}
{{-- ========================================== --}}
@if($showActions && isset($actions))
    <template id="{{ $gridId }}-actions-template">
        {{ $actions }}
    </template>
@endif

{{-- ========================================== --}}
{{-- AG GRID CDN SCRIPT & INITIALIZATION        --}}
{{-- ========================================== --}}
@once
    @push('scripts')
        {{-- AG Grid Community JS --}}
        <script src="https://cdn.jsdelivr.net/npm/ag-grid-community@32.3.3/dist/ag-grid-community.min.js"></script>

        <script>
            /**
             * ================================================================
             * GeoGrid - AG Grid Wrapper API
             * ================================================================
             */
            window.GeoGrid = (function() {
                'use strict';

                // Store grid instances
                const instances = {};

                /**
                 * Initialize a grid with configuration
                 */
                function init(config) {
                    const gridId = config.id;
                    const container = document.getElementById(gridId);

                    if (!container) {
                        console.error(`GeoGrid: Container not found for id "${gridId}"`);
                        return null;
                    }

                    // Build column definitions
                    const columnDefs = buildColumnDefs(config);

                    // Build grid options
                    const gridOptions = {
                        columnDefs: columnDefs,
                        rowData: config.data || [],
                        defaultColDef: {
                            sortable: config.sortable,
                            resizable: config.resizable,
                            filter: config.filterable,
                            floatingFilter: config.floatingFilter,
                        },
                        // Row ID
                        getRowId: (params) => String(params.data[config.rowKey] || params.data.id),

                        // Sorting
                        multiSortKey: config.multiSort ? 'ctrl' : null,

                        // Pagination
                        pagination: config.pagination,
                        paginationPageSize: config.pageSize,
                        paginationPageSizeSelector: config.pageSizeOptions,

                        // Selection
                        rowSelection: config.selectable ? {
                            mode: config.selectionMode === 'single' ? 'singleRow' : 'multiRow',
                            checkboxes: config.checkboxSelection,
                            headerCheckbox: config.headerCheckbox,
                            enableClickSelection: true,
                        } : undefined,

                        // Appearance
                        rowHeight: config.rowHeight,
                        headerHeight: config.headerHeight,
                        domLayout: config.domLayout,

                        // Suppress features
                        suppressMovableColumns: config.suppressMovable,

                        // Overlays
                        overlayLoadingTemplate: `
                            <div class="geo-grid-loading-overlay">
                                <span class="spinner-border spinner-border-sm"></span>
                                <span>${config.loadingMessage}</span>
                            </div>
                        `,
                        overlayNoRowsTemplate: `
                            <div class="geo-grid-empty-overlay">
                                <i class="${config.emptyIcon || 'ki-outline ki-file-deleted'}"></i>
                                <span>${config.emptyMessage}</span>
                            </div>
                        `,

                        // Event handlers
                        onGridReady: (params) => {
                            // Auto-size columns if enabled
                            if (config.autoSizeColumns) {
                                params.api.autoSizeAllColumns();
                            }

                            // Restore state if enabled
                            if (config.stateSave) {
                                restoreState(gridId, params.api);
                            }

                            // Apply default sort
                            if (config.defaultSort) {
                                const sortModel = Object.entries(config.defaultSort).map(([colId, sort]) => ({
                                    colId,
                                    sort
                                }));
                                params.api.applyColumnState({ state: sortModel });
                            }

                            // Callback
                            if (config.callbacks.onInit) {
                                executeCallback(config.callbacks.onInit, params);
                            }
                        },

                        onRowClicked: (params) => {
                            if (config.callbacks.onRowClick) {
                                executeCallback(config.callbacks.onRowClick, params.data, params);
                            }
                        },

                        onSelectionChanged: (params) => {
                            const selectedRows = params.api.getSelectedRows();
                            updateSelectionCount(gridId, selectedRows.length);

                            if (config.callbacks.onSelectionChange) {
                                executeCallback(config.callbacks.onSelectionChange, selectedRows, params);
                            }
                        },

                        onSortChanged: (params) => {
                            if (config.stateSave) {
                                saveState(gridId, params.api);
                            }
                            if (config.callbacks.onSortChange) {
                                executeCallback(config.callbacks.onSortChange, params);
                            }
                        },

                        onFilterChanged: (params) => {
                            if (config.stateSave) {
                                saveState(gridId, params.api);
                            }
                            if (config.callbacks.onFilterChange) {
                                executeCallback(config.callbacks.onFilterChange, params);
                            }
                        },

                        onColumnResized: (params) => {
                            if (config.stateSave && params.finished) {
                                saveState(gridId, params.api);
                            }
                            if (config.callbacks.onColumnResize) {
                                executeCallback(config.callbacks.onColumnResize, params);
                            }
                        },

                        onColumnMoved: (params) => {
                            if (config.stateSave) {
                                saveState(gridId, params.api);
                            }
                            if (config.callbacks.onColumnMove) {
                                executeCallback(config.callbacks.onColumnMove, params);
                            }
                        },
                    };

                    // Create grid
                    const gridApi = agGrid.createGrid(container, gridOptions);

                    // Store instance with config
                    instances[gridId] = {
                        api: gridApi,
                        config: config,
                        options: gridOptions
                    };

                    // Handle AJAX data source
                    if (config.ajaxUrl && !config.serverSide) {
                        loadAjaxData(gridId, config.ajaxUrl);
                    }

                    return gridApi;
                }

                /**
                 * Build AG Grid column definitions from config
                 */
                function buildColumnDefs(config) {
                    const columnDefs = [];

                    // Index column
                    if (config.showIndex) {
                        columnDefs.push({
                            headerName: config.indexLabel,
                            valueGetter: 'node.rowIndex + 1',
                            width: 70,
                            pinned: 'left',
                            sortable: false,
                            filter: false,
                            resizable: false,
                            suppressMovable: true,
                        });
                    }

                    // Selection checkbox column (handled by rowSelection config now)

                    // Data columns
                    config.columns.forEach(col => {
                        if (col.visible === false) return;

                        const colDef = {
                            field: col.key,
                            headerName: col.label,
                            sortable: col.sortable !== false,
                            resizable: col.resizable !== false,
                            filter: buildFilter(col.filter),
                            floatingFilter: config.floatingFilter && col.filter !== false,
                            width: col.width,
                            minWidth: col.minWidth,
                            maxWidth: col.maxWidth,
                            flex: col.flex,
                            pinned: col.pinned,
                            cellClass: col.class,
                            headerClass: col.headerClass,
                            hide: col.visible === false,
                        };

                        // Add cell renderer if specified
                        if (col.render) {
                            colDef.cellRenderer = buildCellRenderer(col);
                        }

                        columnDefs.push(colDef);
                    });

                    // Actions column
                    if (config.showActions) {
                        columnDefs.push({
                            headerName: config.actionsLabel,
                            field: '_actions',
                            width: config.actionsWidth,
                            pinned: config.actionsPinned,
                            sortable: false,
                            filter: false,
                            resizable: false,
                            suppressMovable: true,
                            cellRenderer: (params) => {
                                return renderActionsCell(config.id, params.data);
                            }
                        });
                    }

                    return columnDefs;
                }

                /**
                 * Build filter configuration
                 */
                function buildFilter(filterType) {
                    if (!filterType || filterType === false) return false;

                    switch (filterType) {
                        case 'number':
                            return 'agNumberColumnFilter';
                        case 'date':
                            return 'agDateColumnFilter';
                        case 'set':
                            return 'agSetColumnFilter'; // Enterprise only - falls back gracefully
                        case 'boolean':
                            return 'agTextColumnFilter';
                        case 'text':
                        default:
                            return 'agTextColumnFilter';
                    }
                }

                /**
                 * Build cell renderer function
                 */
                function buildCellRenderer(col) {
                    return (params) => {
                        const value = params.value;
                        const data = params.data;

                        if (value === null || value === undefined) {
                            return '<span class="text-muted">—</span>';
                        }

                        switch (col.render) {
                            case 'date':
                                return formatDate(value, col.format || 'M d, Y');

                            case 'datetime':
                                return formatDate(value, col.format || 'M d, Y H:i');

                            case 'time':
                                return formatDate(value, col.format || 'H:i');

                            case 'relative':
                                return formatRelativeTime(value);

                            case 'currency':
                                return formatCurrency(value, col.symbol || '$', col.decimals ?? 2);

                            case 'number':
                                return formatNumber(value, col.decimals ?? 0, col.prefix || '', col.suffix || '');

                            case 'percent':
                                return formatNumber(value, col.decimals ?? 1, '', '%');

                            case 'badge':
                                const badgeColor = col.colors?.[value] || 'secondary';
                                return `<span class="badge badge-light-${badgeColor}">${escapeHtml(value)}</span>`;

                            case 'status':
                                const statusConfig = col.statuses?.[value] || { label: value, color: 'secondary' };
                                return `<span class="badge badge-light-${statusConfig.color}">${escapeHtml(statusConfig.label)}</span>`;

                            case 'boolean':
                                return value
                                    ? '<i class="ki-outline ki-check-circle geo-grid-boolean-true fs-4"></i>'
                                    : '<i class="ki-outline ki-cross-circle geo-grid-boolean-false fs-4"></i>';

                            case 'yesno':
                                const yesLabel = col.yes || 'Yes';
                                const noLabel = col.no || 'No';
                                return value
                                    ? `<span class="badge badge-light-success">${yesLabel}</span>`
                                    : `<span class="badge badge-light-danger">${noLabel}</span>`;

                            case 'image':
                                const imgW = col.imageWidth || '40px';
                                const imgH = col.imageHeight || '40px';
                                return `<img src="${escapeHtml(value)}" style="width:${imgW};height:${imgH};object-fit:cover;border-radius:4px;" />`;

                            case 'avatar':
                                const size = col.size || '35px';
                                const nameField = col.nameField || 'name';
                                const name = data[nameField] || '';
                                const initials = name.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase();
                                if (value) {
                                    return `<div class="geo-grid-avatar" style="width:${size};height:${size};"><img src="${escapeHtml(value)}" /></div>`;
                                }
                                return `<div class="geo-grid-avatar" style="width:${size};height:${size};">${initials}</div>`;

                            case 'link':
                                let url = col.url || value;
                                // Replace placeholders like {id}, {name}
                                Object.keys(data).forEach(key => {
                                    url = url.replace(`{${key}}`, data[key]);
                                });
                                const target = col.target || '_self';
                                return `<a href="${escapeHtml(url)}" target="${target}" class="geo-grid-link">${escapeHtml(value)}</a>`;

                            case 'email':
                                return `<a href="mailto:${escapeHtml(value)}" class="geo-grid-link">${escapeHtml(value)}</a>`;

                            case 'phone':
                                return `<a href="tel:${escapeHtml(value)}" class="geo-grid-link">${escapeHtml(value)}</a>`;

                            case 'truncate':
                                const maxLen = col.maxLength || 50;
                                if (value.length <= maxLen) return escapeHtml(value);
                                return `<span class="geo-grid-truncate" title="${escapeHtml(value)}">${escapeHtml(value.substring(0, maxLen))}...</span>`;

                            case 'html':
                                return value;

                            default:
                                return escapeHtml(value);
                        }
                    };
                }

                /**
                 * Render actions cell from template
                 */
                function renderActionsCell(gridId, rowData) {
                    const template = document.getElementById(`${gridId}-actions-template`);
                    if (!template) {
                        return '<div class="geo-grid-actions"></div>';
                    }

                    // Clone and process template
                    let html = template.innerHTML;

                    // Replace placeholders
                    Object.keys(rowData).forEach(key => {
                        const regex = new RegExp(`\\{\\{\\s*\\$row\\['${key}'\\]\\s*\\}\\}|\\{\\{\\s*\\$row\\.${key}\\s*\\}\\}`, 'g');
                        html = html.replace(regex, escapeHtml(String(rowData[key] ?? '')));
                    });

                    // Replace row JSON for onclick handlers
                    html = html.replace(/\{\{\s*\$row\s*\}\}/g, escapeHtml(JSON.stringify(rowData)));

                    return `<div class="geo-grid-actions">${html}</div>`;
                }

                /**
                 * Load data via AJAX
                 */
                function loadAjaxData(gridId, url) {
                    const instance = instances[gridId];
                    if (!instance) return;

                    instance.api.showLoadingOverlay();

                    fetch(url, {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        const rowData = Array.isArray(data) ? data : (data.data || []);
                        instance.api.setGridOption('rowData', rowData);
                        if (rowData.length === 0) {
                            instance.api.showNoRowsOverlay();
                        } else {
                            instance.api.hideOverlay();
                        }
                    })
                    .catch(error => {
                        console.error('GeoGrid AJAX error:', error);
                        instance.api.showNoRowsOverlay();
                    });
                }

                /**
                 * Update selection count display
                 */
                function updateSelectionCount(gridId, count) {
                    const countEl = document.getElementById(`${gridId}-selection-count`);
                    if (!countEl) return;

                    if (count > 0) {
                        countEl.style.display = 'inline-flex';
                        countEl.querySelector('[data-selected-count]').textContent = count;
                    } else {
                        countEl.style.display = 'none';
                    }
                }

                /**
                 * Save state to localStorage
                 */
                function saveState(gridId, api) {
                    const state = api.getColumnState();
                    localStorage.setItem(`geo-grid-state-${gridId}`, JSON.stringify(state));
                }

                /**
                 * Restore state from localStorage
                 */
                function restoreState(gridId, api) {
                    const saved = localStorage.getItem(`geo-grid-state-${gridId}`);
                    if (saved) {
                        try {
                            const state = JSON.parse(saved);
                            api.applyColumnState({ state, applyOrder: true });
                        } catch (e) {
                            console.warn('GeoGrid: Could not restore state', e);
                        }
                    }
                }

                /**
                 * Execute callback function
                 */
                function executeCallback(callbackName, ...args) {
                    if (typeof callbackName === 'function') {
                        callbackName(...args);
                    } else if (typeof callbackName === 'string' && typeof window[callbackName] === 'function') {
                        window[callbackName](...args);
                    }
                }

                // ========================================
                // Utility Functions
                // ========================================

                function escapeHtml(str) {
                    if (str === null || str === undefined) return '';
                    const div = document.createElement('div');
                    div.textContent = String(str);
                    return div.innerHTML;
                }

                function formatDate(value, format) {
                    try {
                        const date = new Date(value);
                        if (isNaN(date)) return value;

                        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

                        const replacements = {
                            'Y': date.getFullYear(),
                            'm': String(date.getMonth() + 1).padStart(2, '0'),
                            'M': months[date.getMonth()],
                            'd': String(date.getDate()).padStart(2, '0'),
                            'H': String(date.getHours()).padStart(2, '0'),
                            'i': String(date.getMinutes()).padStart(2, '0'),
                            's': String(date.getSeconds()).padStart(2, '0'),
                        };

                        let result = format;
                        for (const [key, val] of Object.entries(replacements)) {
                            result = result.replace(new RegExp(key, 'g'), val);
                        }
                        return result;
                    } catch {
                        return value;
                    }
                }

                function formatRelativeTime(value) {
                    try {
                        const date = new Date(value);
                        const now = new Date();
                        const seconds = Math.floor((now - date) / 1000);

                        const intervals = [
                            { label: 'year', seconds: 31536000 },
                            { label: 'month', seconds: 2592000 },
                            { label: 'week', seconds: 604800 },
                            { label: 'day', seconds: 86400 },
                            { label: 'hour', seconds: 3600 },
                            { label: 'minute', seconds: 60 },
                        ];

                        for (const interval of intervals) {
                            const count = Math.floor(seconds / interval.seconds);
                            if (count >= 1) {
                                return `${count} ${interval.label}${count > 1 ? 's' : ''} ago`;
                            }
                        }
                        return 'Just now';
                    } catch {
                        return value;
                    }
                }

                function formatCurrency(value, symbol, decimals) {
                    const num = parseFloat(value);
                    if (isNaN(num)) return value;
                    return symbol + num.toFixed(decimals).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                }

                function formatNumber(value, decimals, prefix, suffix) {
                    const num = parseFloat(value);
                    if (isNaN(num)) return value;
                    return prefix + num.toFixed(decimals).replace(/\B(?=(\d{3})+(?!\d))/g, ',') + suffix;
                }

                // ========================================
                // Public API
                // ========================================

                return {
                    init,

                    getInstance(gridId) {
                        return instances[gridId]?.api || null;
                    },

                    getSelectedRows(gridId) {
                        const instance = instances[gridId];
                        return instance ? instance.api.getSelectedRows() : [];
                    },

                    clearSelection(gridId) {
                        const instance = instances[gridId];
                        if (instance) {
                            instance.api.deselectAll();
                        }
                    },

                    refresh(gridId) {
                        const instance = instances[gridId];
                        if (instance && instance.config.ajaxUrl) {
                            loadAjaxData(gridId, instance.config.ajaxUrl);
                        }
                    },

                    setData(gridId, data) {
                        const instance = instances[gridId];
                        if (instance) {
                            instance.api.setGridOption('rowData', data);
                        }
                    },

                    exportCsv(gridId, filename) {
                        const instance = instances[gridId];
                        if (instance) {
                            instance.api.exportDataAsCsv({
                                fileName: filename || instance.config.exportFilename || 'export'
                            });
                        }
                    },

                    setFilter(gridId, columnKey, filterModel) {
                        const instance = instances[gridId];
                        if (instance) {
                            instance.api.setColumnFilterModel(columnKey, filterModel);
                            instance.api.onFilterChanged();
                        }
                    },

                    clearFilters(gridId) {
                        const instance = instances[gridId];
                        if (instance) {
                            instance.api.setFilterModel(null);
                        }
                    },

                    setQuickFilter(gridId, text) {
                        const instance = instances[gridId];
                        if (instance) {
                            instance.api.setGridOption('quickFilterText', text);
                        }
                    },

                    getColumnState(gridId) {
                        const instance = instances[gridId];
                        return instance ? instance.api.getColumnState() : null;
                    },

                    setColumnState(gridId, state) {
                        const instance = instances[gridId];
                        if (instance) {
                            instance.api.applyColumnState({ state, applyOrder: true });
                        }
                    },

                    autoSizeColumns(gridId) {
                        const instance = instances[gridId];
                        if (instance) {
                            instance.api.autoSizeAllColumns();
                        }
                    },

                    showLoading(gridId) {
                        const instance = instances[gridId];
                        if (instance) {
                            instance.api.showLoadingOverlay();
                        }
                    },

                    hideLoading(gridId) {
                        const instance = instances[gridId];
                        if (instance) {
                            instance.api.hideOverlay();
                        }
                    },
                };
            })();

            // ========================================
            // Quick Filter Event Handler
            // ========================================
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('[data-grid-quick-filter]').forEach(input => {
                    const gridId = input.dataset.gridQuickFilter;
                    let debounceTimer;

                    input.addEventListener('input', function() {
                        clearTimeout(debounceTimer);
                        debounceTimer = setTimeout(() => {
                            GeoGrid.setQuickFilter(gridId, this.value);
                        }, 300);
                    });
                });
            });
        </script>
    @endpush
@endonce

{{-- ========================================== --}}
{{-- GRID INITIALIZATION                        --}}
{{-- ========================================== --}}
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            GeoGrid.init(@json($gridConfig));
        });
    </script>
@endpush
