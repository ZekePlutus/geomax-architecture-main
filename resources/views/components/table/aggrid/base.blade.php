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

    5. SERVER-SIDE DATA SOURCE (Simple AJAX)
    ----------------------------------------
    <x-table.aggrid.base
        :columns="$columns"
        ajax-url="/api/users"
        :server-side="true"
        :pagination="true"
    />

    5b. SERVER-SIDE WITH INFINITE SCROLL
    -------------------------------------
    For very large datasets with lazy loading:
    <x-table.aggrid.base
        :columns="$columns"
        ajax-url="/api/users"
        :server-side="true"
        :server-side-infinite="true"
        :cache-block-size="100"
        :filterable="true"
        :sortable="true"
    />

    Expected server response format:
    {
        "data": [...],           // Array of row objects
        "total": 10000,          // Total row count (optional)
        "meta": { "total": N }   // Alternative: Laravel pagination format
    }

    Server receives these query params:
    - page, per_page: Laravel-style pagination
    - start, limit: Offset-based pagination
    - sort_by, sort_dir: Primary sort column
    - filters: Object with column filters

    5c. SERVER-SIDE WITH CALLBACKS
    ------------------------------
    <x-table.aggrid.base
        :columns="$columns"
        ajax-url="/api/users"
        :server-side="true"
        :pagination="true"
        on-server-request="handleBeforeRequest"
        on-server-response="handleAfterResponse"
        on-server-error="handleServerError"
    />

    <script>
        function handleBeforeRequest(params, request) {
            // Modify params before sending to server
            params.custom_param = 'value';
        }
        function handleAfterResponse(response) {
            // Process response before rendering
            console.log('Loaded', response.total, 'rows');
        }
        function handleServerError(error) {
            alert('Failed to load data');
        }
    </script>

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

    9. INLINE CELL EDITING
    ----------------------
    <x-table.aggrid.base
        :columns="[
            ['key' => 'name', 'label' => 'Name', 'editor' => 'text'],
            ['key' => 'price', 'label' => 'Price', 'editor' => 'number', 'min' => 0],
            ['key' => 'status', 'label' => 'Status', 'editor' => 'select', 'options' => ['active', 'inactive', 'pending']],
            ['key' => 'notes', 'label' => 'Notes', 'editor' => 'textarea', 'editable' => true],
            ['key' => 'id', 'label' => 'ID', 'editable' => false], // Not editable
        ]"
        :data="$users"
        :editable="true"
        edit-type="cell"
        on-cell-value-changed="handleCellChange"
    />

    // Callback receives: { rowData, field, oldValue, newValue, rowIndex, api }
    <script>
        function handleCellChange(event) {
            console.log(`Changed ${event.field} from ${event.oldValue} to ${event.newValue}`);
            // Save to server...
        }
    </script>

    10. ROW DRAGGING (REORDER)
    --------------------------
    <x-table.aggrid.base
        :columns="$columns"
        :data="$users"
        :row-draggable="true"
        :row-drag-managed="true"
        on-row-drag-end="handleRowReorder"
    />

    <script>
        function handleRowReorder(event) {
            console.log('New order:', event.allRows);
            // Save new order to server...
            const ids = event.allRows.map(row => row.id);
            fetch('/api/reorder', {
                method: 'POST',
                body: JSON.stringify({ ids })
            });
        }
    </script>

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

        // INLINE EDITING options:
        'editable'      => true|false,          // Optional: override global editable setting
        'editor'        => 'text|number|select|date|textarea|checkbox', // Editor type
        'options'       => [],                  // For select editor: dropdown options
        'min'           => 0,                   // For number editor
        'max'           => 100,                 // For number editor
        'step'          => 1,                   // For number editor
        'precision'     => 2,                   // For number editor
        'maxLength'     => 500,                 // For textarea editor
        'rows'          => 5,                   // For textarea editor
        'validator'     => 'required|email|...',// Validation rule

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
    RTL / LOCALE SUPPORT
    ================================================================================

    AUTO-DETECT RTL (from HTML dir attribute):
    -----------------------------------------
    If your page has <html dir="rtl">, the grid automatically enables RTL mode.

    FORCE RTL MODE:
    ---------------
    <x-table.aggrid.base
        :columns="$columns"
        :data="$users"
        :rtl="true"
        locale="ar"
    />

    ARABIC WITH ALL FEATURES:
    -------------------------
    <x-table.aggrid.base
        :columns="[
            ['key' => 'الاسم', 'label' => 'الاسم'],
            ['key' => 'البريد', 'label' => 'البريد الإلكتروني'],
        ]"
        :data="$users"
        :rtl="true"
        locale="ar"
        :sortable="true"
        :filterable="true"
        :pagination="true"
    />

    SUPPORTED LOCALES:
    - ar (Arabic)
    - he (Hebrew)
    - fa (Farsi/Persian)
    - fr (French)
    - Default: English (en)

    ================================================================================
    JS API (GeoGrid)
    ================================================================================

    // Access grid instance
    window.GeoGrid.getInstance('grid-id')

    // Get selected rows
    window.GeoGrid.getSelectedRows('grid-id')

    // Clear selection
    window.GeoGrid.clearSelection('grid-id')

    // Refresh data (works for both client-side and server-side)
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

    // SERVER-SIDE SPECIFIC:

    // Refresh server-side data with options
    window.GeoGrid.refreshServerSide('grid-id', { purge: true })

    // Get server-side cache info
    window.GeoGrid.getServerSideCacheInfo('grid-id')

    // Purge cache and reload all data
    window.GeoGrid.purgeServerSideCache('grid-id')

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
    'serverSide' => false,                  // Enable server-side row model (lazy loading)
    'serverSideInfinite' => false,          // Use infinite scroll with server-side
    'cacheBlockSize' => 100,                // Rows per block for server-side
    'maxBlocksInCache' => 10,               // Max blocks to keep in cache
    'totalRows' => null,                    // Total row count (if known) for server-side

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
    // RTL / LOCALE SUPPORT
    // ============================================
    'rtl' => null,                          // Enable RTL mode (null = auto-detect from HTML dir, true/false = force)
    'locale' => null,                       // Locale code ('ar', 'he', 'fa', 'en', 'fr', etc.) - auto-detect if null

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
    // INLINE EDITING
    // ============================================
    'editable' => false,                    // Enable inline cell editing globally
    'editType' => 'fullRow',                // 'fullRow' (edit entire row) or 'cell' (single cell)
    'singleClickEdit' => false,             // Start edit on single click (default: double-click)
    'stopEditingWhenCellsLoseFocus' => true,// Stop editing when clicking outside
    'undoRedoCellEditing' => false,         // Enable undo/redo for cell edits
    'undoRedoCellEditingLimit' => 20,       // Max undo steps

    // ============================================
    // ROW DRAGGING
    // ============================================
    'rowDraggable' => false,                // Enable row dragging
    'rowDragManaged' => true,               // Let AG Grid handle row order
    'rowDragEntireRow' => false,            // Drag from anywhere (not just drag handle)
    'rowDragMultiRow' => false,             // Allow dragging multiple selected rows

    // ============================================
    // CONTEXT MENU
    // ============================================
    'contextMenu' => false,                 // Enable context menu (right-click)
    'contextMenuItems' => [],               // Array of menu items: [{key, label, icon, class, divider, disabled, callback}]
    'onContextMenuAction' => null,          // Callback when menu item clicked: (actionKey, rowData, event)
    'contextMenuClass' => '',               // Additional CSS class for menu

    // ============================================
    // CALLBACKS (JavaScript function names)
    // ============================================
    'onInit' => null,                       // Called after grid initialized
    'onRowClick' => null,                   // Called on row click
    'onSelectionChange' => null,            // Called when selection changes
    'onSortChange' => null,                 // Called when sort changes
    'onFilterChange' => null,               // Called when filters change
    'onColumnResize' => null,               // Called when column resized
    'onColumnMove' => null,                // Called when column moved
    'onServerRequest' => null,              // Called before server-side request (can modify params)
    'onServerResponse' => null,             // Called after server-side response (can modify data)
    'onServerError' => null,                // Called on server-side request error
    'onCellValueChanged' => null,           // Called when cell value changes (inline editing)
    'onRowValueChanged' => null,            // Called when row editing completes (fullRow mode)
    'onRowDragEnd' => null,                 // Called when row drag ends
    'onRowDragMove' => null,                 // Called during row drag
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
        'serverSideInfinite' => $serverSideInfinite,
        'cacheBlockSize' => $cacheBlockSize,
        'maxBlocksInCache' => $maxBlocksInCache,
        'totalRows' => $totalRows,
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
        // RTL / Locale
        'rtl' => $rtl,
        'locale' => $locale ?? app()->getLocale(),
        // Empty/Loading
        'emptyMessage' => $emptyMessage,
        'loadingMessage' => $loadingMessage,
        // Export
        'exportable' => $exportable,
        'exportFilename' => $exportFilename,
        // State
        'stateSave' => $stateSave,
        // Inline Editing
        'editable' => $editable,
        'editType' => $editType,
        'singleClickEdit' => $singleClickEdit,
        'stopEditingWhenCellsLoseFocus' => $stopEditingWhenCellsLoseFocus,
        'undoRedoCellEditing' => $undoRedoCellEditing,
        'undoRedoCellEditingLimit' => $undoRedoCellEditingLimit,
        // Row Dragging
        'rowDraggable' => $rowDraggable,
        'rowDragManaged' => $rowDragManaged,
        'rowDragEntireRow' => $rowDragEntireRow,
        'rowDragMultiRow' => $rowDragMultiRow,
        // Context Menu
        'contextMenu' => $contextMenu,
        'contextMenuItems' => $contextMenuItems,
        'contextMenuClass' => $contextMenuClass,
        // Callbacks
        'callbacks' => [
            'onInit' => $onInit,
            'onRowClick' => $onRowClick,
            'onSelectionChange' => $onSelectionChange,
            'onSortChange' => $onSortChange,
            'onFilterChange' => $onFilterChange,
            'onColumnResize' => $onColumnResize,
            'onColumnMove' => $onColumnMove,
            'onServerRequest' => $onServerRequest,
            'onServerResponse' => $onServerResponse,
            'onServerError' => $onServerError,
            'onCellValueChanged' => $onCellValueChanged,
            'onRowValueChanged' => $onRowValueChanged,
            'onRowDragEnd' => $onRowDragEnd,
            'onRowDragMove' => $onRowDragMove,
            'onContextMenuAction' => $onContextMenuAction,
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

            /* ========================================== */
            /* ROW DRAG HANDLE                            */
            /* ========================================== */
            .geo-grid-drag-handle {
                cursor: move;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .geo-grid-drag-handle .ag-drag-handle {
                opacity: 0.5;
                transition: opacity 0.15s ease;
            }

            .geo-grid-drag-handle:hover .ag-drag-handle,
            .ag-row-dragging .geo-grid-drag-handle .ag-drag-handle {
                opacity: 1;
            }

            .ag-row-dragging {
                background-color: var(--bs-light) !important;
                opacity: 0.9;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            }

            .ag-row-drag-preview {
                border: 2px dashed var(--bs-primary);
                background-color: rgba(var(--bs-primary-rgb), 0.1);
            }

            /* ========================================== */
            /* INLINE EDITING                             */
            /* ========================================== */
            .ag-cell-edit-input {
                width: 100%;
                height: 100%;
                padding: 0 8px;
                border: none;
                outline: none;
                background: transparent;
            }

            .ag-cell.ag-cell-inline-editing {
                background-color: var(--bs-light);
                border: 2px solid var(--bs-primary) !important;
                border-radius: 4px;
                padding: 0;
            }

            .ag-popup-editor {
                background: var(--bs-body-bg);
                border: 1px solid var(--bs-border-color);
                border-radius: 4px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            }

            .ag-large-text-input {
                padding: 8px;
                font-family: inherit;
                resize: vertical;
            }

            /* Validation error styling */
            .ag-cell-validation-error {
                border-color: var(--bs-danger) !important;
                background-color: rgba(var(--bs-danger-rgb), 0.1) !important;
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

            /* ========================================== */
            /* CONTEXT MENU                               */
            /* ========================================== */
            .geo-grid-context-menu {
                position: fixed;
                z-index: 9999;
                min-width: 180px;
                max-width: 280px;
                background: var(--bs-body-bg, #fff);
                border: 1px solid var(--bs-border-color, #dee2e6);
                border-radius: 0.5rem;
                box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.175);
                padding: 0.5rem 0;
                opacity: 0;
                transform: scale(0.95);
                transform-origin: top left;
                transition: opacity 0.1s ease, transform 0.1s ease;
                pointer-events: none;
            }

            .geo-grid-context-menu.show {
                opacity: 1;
                transform: scale(1);
                pointer-events: auto;
            }

            .geo-grid-context-menu-item {
                display: flex;
                align-items: center;
                gap: 0.75rem;
                padding: 0.6rem 1rem;
                font-size: 0.9rem;
                color: var(--bs-body-color, #212529);
                cursor: pointer;
                transition: background-color 0.15s ease;
                border: none;
                background: none;
                width: 100%;
                text-align: left;
            }

            .geo-grid-context-menu-item:hover {
                background-color: var(--bs-gray-100, #f8f9fa);
            }

            .geo-grid-context-menu-item:active {
                background-color: var(--bs-gray-200, #e9ecef);
            }

            .geo-grid-context-menu-item.disabled {
                opacity: 0.5;
                pointer-events: none;
                cursor: not-allowed;
            }

            .geo-grid-context-menu-item.danger {
                color: var(--bs-danger, #dc3545);
            }

            .geo-grid-context-menu-item.danger:hover {
                background-color: rgba(220, 53, 69, 0.1);
            }

            .geo-grid-context-menu-item i {
                font-size: 1.1rem;
                width: 1.25rem;
                text-align: center;
                opacity: 0.7;
            }

            .geo-grid-context-menu-item .shortcut {
                margin-left: auto;
                font-size: 0.75rem;
                color: var(--bs-gray-500, #adb5bd);
            }

            .geo-grid-context-menu-divider {
                height: 1px;
                margin: 0.5rem 0;
                background-color: var(--bs-border-color, #dee2e6);
            }

            .geo-grid-context-menu-header {
                padding: 0.5rem 1rem;
                font-size: 0.75rem;
                font-weight: 600;
                color: var(--bs-gray-500, #adb5bd);
                text-transform: uppercase;
                letter-spacing: 0.05em;
            }

            /* Submenu support (optional future enhancement) */
            .geo-grid-context-menu-item.has-submenu::after {
                content: '';
                margin-left: auto;
                border: 4px solid transparent;
                border-left-color: currentColor;
                opacity: 0.5;
            }

            /* Dark mode support */
            [data-bs-theme="dark"] .geo-grid-context-menu {
                background: var(--bs-gray-800, #343a40);
                border-color: var(--bs-gray-700, #495057);
            }

            [data-bs-theme="dark"] .geo-grid-context-menu-item:hover {
                background-color: var(--bs-gray-700, #495057);
            }

            [data-bs-theme="dark"] .geo-grid-context-menu-divider {
                background-color: var(--bs-gray-700, #495057);
            }

            /* ========================================== */
            /* RTL (Right-to-Left) SUPPORT               */
            /* ========================================== */
            [dir="rtl"] .geo-grid-wrapper,
            .geo-grid-wrapper[dir="rtl"] {
                direction: rtl;
                text-align: right;
            }

            [dir="rtl"] .geo-grid-toolbar,
            .geo-grid-wrapper[dir="rtl"] .geo-grid-toolbar {
                flex-direction: row-reverse;
            }

            [dir="rtl"] .geo-grid-toolbar-left,
            .geo-grid-wrapper[dir="rtl"] .geo-grid-toolbar-left {
                flex-direction: row-reverse;
            }

            [dir="rtl"] .geo-grid-toolbar-right,
            .geo-grid-wrapper[dir="rtl"] .geo-grid-toolbar-right {
                flex-direction: row-reverse;
                margin-left: 0;
                margin-right: auto;
            }

            [dir="rtl"] .geo-grid-context-menu,
            .geo-grid-context-menu[dir="rtl"] {
                text-align: right;
            }

            [dir="rtl"] .geo-grid-context-menu-item,
            .geo-grid-context-menu[dir="rtl"] .geo-grid-context-menu-item {
                flex-direction: row-reverse;
            }

            [dir="rtl"] .geo-grid-context-menu-item i,
            .geo-grid-context-menu[dir="rtl"] .geo-grid-context-menu-item i {
                margin-left: 0.75rem;
                margin-right: 0;
            }

            [dir="rtl"] .geo-grid-context-menu-item .shortcut,
            .geo-grid-context-menu[dir="rtl"] .geo-grid-context-menu-item .shortcut {
                margin-left: 0;
                margin-right: auto;
            }

            /* RTL Submenu arrow */
            [dir="rtl"] .geo-grid-context-menu-item.has-submenu::after,
            .geo-grid-context-menu[dir="rtl"] .geo-grid-context-menu-item.has-submenu::after {
                border-left-color: transparent;
                border-right-color: currentColor;
            }

            /* RTL Selection count badge */
            [dir="rtl"] .geo-grid-selection-count .btn-close,
            .geo-grid-wrapper[dir="rtl"] .geo-grid-selection-count .btn-close {
                margin-left: 0;
                margin-right: 0.5rem;
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

                // ========================================
                // LOCALE TRANSLATIONS
                // ========================================
                const localeTexts = {
                    // Arabic
                    ar: {
                        // Pagination
                        page: 'صفحة',
                        to: 'إلى',
                        of: 'من',
                        more: 'المزيد',
                        next: 'التالي',
                        previous: 'السابق',
                        first: 'الأول',
                        last: 'الأخير',
                        // Filter
                        filter: 'تصفية',
                        filterOoo: 'تصفية...',
                        equals: 'يساوي',
                        notEqual: 'لا يساوي',
                        blank: 'فارغ',
                        notBlank: 'غير فارغ',
                        lessThan: 'أقل من',
                        greaterThan: 'أكبر من',
                        lessThanOrEqual: 'أقل من أو يساوي',
                        greaterThanOrEqual: 'أكبر من أو يساوي',
                        inRange: 'في النطاق',
                        contains: 'يحتوي',
                        notContains: 'لا يحتوي',
                        startsWith: 'يبدأ بـ',
                        endsWith: 'ينتهي بـ',
                        andCondition: 'و',
                        orCondition: 'أو',
                        applyFilter: 'تطبيق',
                        resetFilter: 'إعادة تعيين',
                        clearFilter: 'مسح',
                        // Grid
                        noRowsToShow: 'لا توجد بيانات',
                        loading: 'جاري التحميل...',
                        enabled: 'مفعل',
                        disabled: 'معطل',
                        // Selection
                        selectAll: 'تحديد الكل',
                        selectAllSearchResults: 'تحديد كل نتائج البحث',
                        searchOoo: 'بحث...',
                        // Export
                        export: 'تصدير',
                        csvExport: 'تصدير CSV',
                        excelExport: 'تصدير Excel',
                        // Copy
                        copy: 'نسخ',
                        copyWithHeaders: 'نسخ مع العناوين',
                        paste: 'لصق',
                        // Columns
                        columns: 'الأعمدة',
                        column: 'عمود',
                        pinColumn: 'تثبيت العمود',
                        autosizeThiscolumn: 'حجم تلقائي لهذا العمود',
                        autosizeAllColumns: 'حجم تلقائي لجميع الأعمدة',
                        resetColumns: 'إعادة تعيين الأعمدة',
                        // Row grouping
                        group: 'مجموعة',
                        rowGroupColumnsEmptyMessage: 'اسحب هنا للتجميع',
                        // Values
                        sum: 'المجموع',
                        count: 'العدد',
                        avg: 'المتوسط',
                        min: 'الأدنى',
                        max: 'الأقصى',
                        // Pivot
                        pivotMode: 'وضع المحور',
                        pivots: 'المحاور',
                        // Row Drag
                        rowDragRows: 'سحب الصفوف',
                    },
                    // Hebrew
                    he: {
                        page: 'עמוד',
                        to: 'עד',
                        of: 'מתוך',
                        noRowsToShow: 'אין נתונים להצגה',
                        loading: 'טוען...',
                        filter: 'סינון',
                        columns: 'עמודות',
                        export: 'ייצוא',
                    },
                    // Farsi/Persian
                    fa: {
                        page: 'صفحه',
                        to: 'تا',
                        of: 'از',
                        noRowsToShow: 'داده‌ای برای نمایش وجود ندارد',
                        loading: 'در حال بارگذاری...',
                        filter: 'فیلتر',
                        columns: 'ستون‌ها',
                        export: 'صادرات',
                    },
                    // French
                    fr: {
                        page: 'Page',
                        to: 'à',
                        of: 'sur',
                        noRowsToShow: 'Aucune donnée à afficher',
                        loading: 'Chargement...',
                        filter: 'Filtre',
                        columns: 'Colonnes',
                        export: 'Exporter',
                        copy: 'Copier',
                        paste: 'Coller',
                        selectAll: 'Tout sélectionner',
                    },
                };

                /**
                 * Get locale text for a specific locale
                 */
                function getLocaleTextForLocale(locale) {
                    // Normalize locale (e.g., 'ar_SA' -> 'ar', 'en-US' -> 'en')
                    const normalizedLocale = locale ? locale.split(/[-_]/)[0].toLowerCase() : null;
                    return localeTexts[normalizedLocale] || {};
                }

                /**
                 * Create server-side datasource for AG Grid Server-Side Row Model
                 * This handles large datasets with lazy loading
                 */
                function createServerSideDatasource(config) {
                    return {
                        getRows: (params) => {
                            const request = params.request;

                            // Build query parameters
                            const queryParams = buildServerSideParams(request, config);

                            // Allow callback to modify params
                            if (config.callbacks.onServerRequest) {
                                executeCallback(config.callbacks.onServerRequest, queryParams, request);
                            }

                            // Build URL with query string
                            const url = new URL(config.ajaxUrl, window.location.origin);
                            Object.entries(queryParams).forEach(([key, value]) => {
                                if (value !== null && value !== undefined) {
                                    if (typeof value === 'object') {
                                        url.searchParams.append(key, JSON.stringify(value));
                                    } else {
                                        url.searchParams.append(key, value);
                                    }
                                }
                            });

                            fetch(url.toString(), {
                                headers: {
                                    'Accept': 'application/json',
                                    'X-Requested-With': 'XMLHttpRequest',
                                }
                            })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                                }
                                return response.json();
                            })
                            .then(response => {
                                // Allow callback to modify response
                                if (config.callbacks.onServerResponse) {
                                    executeCallback(config.callbacks.onServerResponse, response);
                                }

                                // Extract data and total from response
                                // Support various response formats:
                                // - { data: [], total: N }
                                // - { data: [], meta: { total: N } }
                                // - { rows: [], rowCount: N }
                                // - [ ] (array directly, total unknown)
                                let rowData, rowCount;

                                if (Array.isArray(response)) {
                                    rowData = response;
                                    rowCount = response.length;
                                } else {
                                    rowData = response.data || response.rows || [];
                                    rowCount = response.total
                                        || response.rowCount
                                        || response.meta?.total
                                        || response.meta?.totalRows
                                        || (config.totalRows ?? -1); // -1 means unknown
                                }

                                params.success({
                                    rowData: rowData,
                                    rowCount: rowCount
                                });
                            })
                            .catch(error => {
                                console.error('GeoGrid Server-Side Error:', error);
                                if (config.callbacks.onServerError) {
                                    executeCallback(config.callbacks.onServerError, error);
                                }
                                params.fail();
                            });
                        }
                    };
                }

                /**
                 * Create infinite scroll datasource (alternative to server-side)
                 * Uses simpler pagination model
                 */
                function createInfiniteDatasource(config) {
                    return {
                        getRows: (params) => {
                            const startRow = params.startRow;
                            const endRow = params.endRow;
                            const pageSize = endRow - startRow;

                            // Build query parameters
                            const queryParams = {
                                start: startRow,
                                limit: pageSize,
                                // Include sort model
                                sort: params.sortModel?.length > 0 ? params.sortModel : null,
                                // Include filter model
                                filter: Object.keys(params.filterModel || {}).length > 0 ? params.filterModel : null,
                            };

                            // Allow callback to modify params
                            if (config.callbacks.onServerRequest) {
                                executeCallback(config.callbacks.onServerRequest, queryParams, params);
                            }

                            // Build URL
                            const url = new URL(config.ajaxUrl, window.location.origin);
                            Object.entries(queryParams).forEach(([key, value]) => {
                                if (value !== null && value !== undefined) {
                                    if (typeof value === 'object') {
                                        url.searchParams.append(key, JSON.stringify(value));
                                    } else {
                                        url.searchParams.append(key, value);
                                    }
                                }
                            });

                            fetch(url.toString(), {
                                headers: {
                                    'Accept': 'application/json',
                                    'X-Requested-With': 'XMLHttpRequest',
                                }
                            })
                            .then(response => response.json())
                            .then(response => {
                                // Allow callback to modify response
                                if (config.callbacks.onServerResponse) {
                                    executeCallback(config.callbacks.onServerResponse, response);
                                }

                                let rowData, lastRow;

                                if (Array.isArray(response)) {
                                    rowData = response;
                                    lastRow = response.length < pageSize ? startRow + response.length : -1;
                                } else {
                                    rowData = response.data || response.rows || [];
                                    const total = response.total || response.rowCount || response.meta?.total;
                                    lastRow = total ? total : (rowData.length < pageSize ? startRow + rowData.length : -1);
                                }

                                params.successCallback(rowData, lastRow);
                            })
                            .catch(error => {
                                console.error('GeoGrid Infinite Scroll Error:', error);
                                if (config.callbacks.onServerError) {
                                    executeCallback(config.callbacks.onServerError, error);
                                }
                                params.failCallback();
                            });
                        }
                    };
                }

                /**
                 * Build server-side request parameters from AG Grid request
                 */
                function buildServerSideParams(request, config) {
                    const params = {};

                    // Pagination
                    if (request.startRow !== undefined) {
                        params.start = request.startRow;
                        params.limit = request.endRow - request.startRow;
                        // Also include page number for Laravel-style pagination
                        params.page = Math.floor(request.startRow / (request.endRow - request.startRow)) + 1;
                        params.per_page = request.endRow - request.startRow;
                    }

                    // Sorting
                    if (request.sortModel && request.sortModel.length > 0) {
                        // Format: sort[0][field]=name&sort[0][dir]=asc
                        // Also support: sort_by=name&sort_dir=asc (single sort)
                        const primarySort = request.sortModel[0];
                        params.sort_by = primarySort.colId;
                        params.sort_dir = primarySort.sort;

                        // For multi-sort, include full model
                        if (request.sortModel.length > 1) {
                            params.sort = request.sortModel.map(s => ({
                                field: s.colId,
                                dir: s.sort
                            }));
                        }
                    }

                    // Filtering
                    if (request.filterModel && Object.keys(request.filterModel).length > 0) {
                        // Convert AG Grid filter model to server-friendly format
                        const filters = {};
                        Object.entries(request.filterModel).forEach(([field, filterDef]) => {
                            if (filterDef.filterType === 'text') {
                                filters[field] = {
                                    type: filterDef.type, // contains, equals, startsWith, endsWith
                                    value: filterDef.filter
                                };
                            } else if (filterDef.filterType === 'number') {
                                filters[field] = {
                                    type: filterDef.type, // equals, lessThan, greaterThan, inRange
                                    value: filterDef.filter,
                                    valueTo: filterDef.filterTo // for inRange
                                };
                            } else if (filterDef.filterType === 'date') {
                                filters[field] = {
                                    type: filterDef.type,
                                    value: filterDef.dateFrom,
                                    valueTo: filterDef.dateTo
                                };
                            } else if (filterDef.filterType === 'set') {
                                filters[field] = {
                                    type: 'in',
                                    values: filterDef.values
                                };
                            }
                        });
                        params.filters = filters;
                    }

                    // Row grouping (for future use)
                    if (request.rowGroupCols && request.rowGroupCols.length > 0) {
                        params.group_by = request.rowGroupCols.map(c => c.id);
                    }

                    // Group keys (for expanding groups)
                    if (request.groupKeys && request.groupKeys.length > 0) {
                        params.group_keys = request.groupKeys;
                    }

                    return params;
                }

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

                    // ========================================
                    // RTL DETECTION
                    // ========================================
                    // Determine RTL: use explicit config, or auto-detect from HTML dir attribute
                    const isRtl = config.rtl !== null ? config.rtl :
                        (document.documentElement.dir === 'rtl' || document.body.dir === 'rtl');

                    // Build grid options
                    const gridOptions = {
                        columnDefs: columnDefs,
                        defaultColDef: {
                            sortable: config.sortable,
                            resizable: config.resizable,
                            filter: config.filterable,
                            floatingFilter: config.floatingFilter,
                            // Editing defaults
                            editable: config.editable,
                        },
                        // Row ID
                        getRowId: (params) => String(params.data[config.rowKey] || params.data.id),

                        // ========================================
                        // RTL MODE
                        // ========================================
                        enableRtl: isRtl,

                        // Sorting
                        multiSortKey: config.multiSort ? 'ctrl' : null,

                        // Pagination (for client-side mode)
                        pagination: config.pagination && !config.serverSide,
                        paginationPageSize: config.pageSize,
                        paginationPageSizeSelector: config.pageSizeOptions,

                        // Selection
                        rowSelection: config.selectable ? {
                            mode: config.selectionMode === 'single' ? 'singleRow' : 'multiRow',
                            checkboxes: config.checkboxSelection,
                            headerCheckbox: config.headerCheckbox,
                            enableClickSelection: !config.editable, // Disable click selection if editing
                        } : undefined,

                        // Appearance
                        rowHeight: config.rowHeight,
                        headerHeight: config.headerHeight,
                        domLayout: config.domLayout,

                        // Suppress features
                        suppressMovableColumns: config.suppressMovable,

                        // ========================================
                        // INLINE EDITING
                        // ========================================
                        ...(config.editable ? {
                            editType: config.editType === 'fullRow' ? 'fullRow' : undefined,
                            singleClickEdit: config.singleClickEdit,
                            stopEditingWhenCellsLoseFocus: config.stopEditingWhenCellsLoseFocus,
                            undoRedoCellEditing: config.undoRedoCellEditing,
                            undoRedoCellEditingLimit: config.undoRedoCellEditingLimit,
                        } : {}),

                        // ========================================
                        // ROW DRAGGING
                        // ========================================
                        ...(config.rowDraggable ? {
                            rowDragManaged: config.rowDragManaged,
                            rowDragEntireRow: config.rowDragEntireRow,
                            rowDragMultiRow: config.rowDragMultiRow,
                            suppressRowDrag: false,
                        } : {}),

                        // ========================================
                        // CONTEXT MENU SUPPRESSION
                        // ========================================
                        // Suppress AG Grid's built-in context menu to use our custom one
                        suppressContextMenu: config.contextMenu,

                        // Server-side row model configuration
                        ...(config.serverSide ? {
                            rowModelType: config.serverSideInfinite ? 'infinite' : 'serverSide',
                            serverSideDatasource: config.serverSideInfinite ? undefined : createServerSideDatasource(config),
                            datasource: config.serverSideInfinite ? createInfiniteDatasource(config) : undefined,
                            cacheBlockSize: config.cacheBlockSize,
                            maxBlocksInCache: config.maxBlocksInCache,
                            // Server-side pagination
                            pagination: config.pagination,
                            paginationPageSize: config.pageSize,
                            paginationPageSizeSelector: config.pageSizeOptions,
                        } : {
                            rowData: config.data || [],
                        }),

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

                        // ========================================
                        // LOCALE TEXT (for RTL languages like Arabic)
                        // ========================================
                        localeText: GeoGrid.getLocaleText(config.locale),

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

                        // ========================================
                        // INLINE EDITING EVENT HANDLERS
                        // ========================================
                        onCellValueChanged: (params) => {
                            if (config.callbacks.onCellValueChanged) {
                                executeCallback(config.callbacks.onCellValueChanged, {
                                    rowData: params.data,
                                    field: params.colDef.field,
                                    oldValue: params.oldValue,
                                    newValue: params.newValue,
                                    rowIndex: params.rowIndex,
                                    api: params.api,
                                });
                            }
                        },

                        onRowValueChanged: (params) => {
                            if (config.callbacks.onRowValueChanged) {
                                executeCallback(config.callbacks.onRowValueChanged, {
                                    rowData: params.data,
                                    rowIndex: params.rowIndex,
                                    api: params.api,
                                });
                            }
                        },

                        // ========================================
                        // ROW DRAGGING EVENT HANDLERS
                        // ========================================
                        onRowDragEnd: (params) => {
                            if (config.callbacks.onRowDragEnd) {
                                // Get updated row order
                                const rowData = [];
                                params.api.forEachNode((node) => {
                                    if (node.data) rowData.push(node.data);
                                });
                                executeCallback(config.callbacks.onRowDragEnd, {
                                    node: params.node,
                                    overNode: params.overNode,
                                    overIndex: params.overIndex,
                                    draggedData: params.node.data,
                                    allRows: rowData,
                                    api: params.api,
                                });
                            }
                        },

                        onRowDragMove: (params) => {
                            if (config.callbacks.onRowDragMove) {
                                executeCallback(config.callbacks.onRowDragMove, {
                                    node: params.node,
                                    overNode: params.overNode,
                                    overIndex: params.overIndex,
                                    api: params.api,
                                });
                            }
                        },

                        // ========================================
                        // CONTEXT MENU (Custom Implementation)
                        // ========================================
                        onCellContextMenu: config.contextMenu ? (params) => {
                            params.event.preventDefault();
                            showContextMenu(gridId, params.event, params.data, params.node);
                        } : undefined,
                    };

                    // Create grid
                    const gridApi = agGrid.createGrid(container, gridOptions);

                    // Store instance with config
                    instances[gridId] = {
                        api: gridApi,
                        config: config,
                        options: gridOptions,
                        contextMenuEl: null,
                    };

                    // Initialize context menu if enabled
                    if (config.contextMenu) {
                        initContextMenu(gridId, config);
                    }

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

                    // ========================================
                    // ROW DRAG HANDLE COLUMN
                    // ========================================
                    if (config.rowDraggable && !config.rowDragEntireRow) {
                        columnDefs.push({
                            headerName: '',
                            field: '_dragHandle',
                            width: 50,
                            rowDrag: true,
                            sortable: false,
                            filter: false,
                            resizable: false,
                            suppressMovable: true,
                            pinned: 'left',
                            cellClass: 'geo-grid-drag-handle',
                        });
                    }

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
                    config.columns.forEach((col, index) => {
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

                        // ========================================
                        // INLINE EDITING PER COLUMN
                        // ========================================
                        if (config.editable) {
                            // Column-level editable override
                            if (col.editable !== undefined) {
                                colDef.editable = col.editable;
                            }

                            // Editor type (text, number, select, date, etc.)
                            if (col.editor) {
                                colDef.cellEditor = buildCellEditor(col);
                                colDef.cellEditorParams = buildCellEditorParams(col);
                            }

                            // Validation
                            if (col.validator) {
                                colDef.valueSetter = (params) => {
                                    const validationResult = validateCellValue(col, params.newValue, params.data);
                                    if (validationResult.valid) {
                                        params.data[col.key] = params.newValue;
                                        return true;
                                    } else {
                                        console.warn(`Validation failed for ${col.key}: ${validationResult.message}`);
                                        return false;
                                    }
                                };
                            }
                        }

                        // Row drag on first column (if rowDragEntireRow is false and no separate handle)
                        if (config.rowDraggable && config.rowDragEntireRow && index === 0) {
                            colDef.rowDrag = true;
                        }

                        // Add cell renderer if specified (but not for editable columns with editors)
                        if (col.render && !col.editor) {
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
                            editable: false, // Never editable
                            cellRenderer: (params) => {
                                return renderActionsCell(config.id, params.data);
                            }
                        });
                    }

                    return columnDefs;
                }

                /**
                 * Build cell editor type
                 */
                function buildCellEditor(col) {
                    switch (col.editor) {
                        case 'number':
                            return 'agNumberCellEditor';
                        case 'largeText':
                        case 'textarea':
                            return 'agLargeTextCellEditor';
                        case 'select':
                        case 'dropdown':
                            return 'agSelectCellEditor';
                        case 'date':
                            return 'agDateCellEditor';
                        case 'checkbox':
                            return 'agCheckboxCellEditor';
                        case 'text':
                        default:
                            return 'agTextCellEditor';
                    }
                }

                /**
                 * Build cell editor params
                 */
                function buildCellEditorParams(col) {
                    const params = {};

                    switch (col.editor) {
                        case 'number':
                            if (col.min !== undefined) params.min = col.min;
                            if (col.max !== undefined) params.max = col.max;
                            if (col.precision !== undefined) params.precision = col.precision;
                            if (col.step !== undefined) params.step = col.step;
                            break;

                        case 'largeText':
                        case 'textarea':
                            params.maxLength = col.maxLength || 500;
                            params.rows = col.rows || 5;
                            params.cols = col.cols || 50;
                            break;

                        case 'select':
                        case 'dropdown':
                            params.values = col.options || [];
                            break;

                        case 'date':
                            // AG Grid Community date editor is basic
                            break;
                    }

                    return params;
                }

                /**
                 * Validate cell value
                 */
                function validateCellValue(col, value, rowData) {
                    const validator = col.validator;
                    if (!validator) return { valid: true };

                    // Built-in validators
                    if (typeof validator === 'string') {
                        switch (validator) {
                            case 'required':
                                if (!value && value !== 0) {
                                    return { valid: false, message: 'This field is required' };
                                }
                                break;
                            case 'email':
                                if (value && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
                                    return { valid: false, message: 'Invalid email address' };
                                }
                                break;
                            case 'number':
                                if (value && isNaN(Number(value))) {
                                    return { valid: false, message: 'Must be a number' };
                                }
                                break;
                        }
                    }

                    // Custom validator function
                    if (typeof validator === 'object') {
                        if (validator.required && !value && value !== 0) {
                            return { valid: false, message: validator.message || 'This field is required' };
                        }
                        if (validator.min !== undefined && Number(value) < validator.min) {
                            return { valid: false, message: validator.message || `Minimum value is ${validator.min}` };
                        }
                        if (validator.max !== undefined && Number(value) > validator.max) {
                            return { valid: false, message: validator.message || `Maximum value is ${validator.max}` };
                        }
                        if (validator.pattern && !new RegExp(validator.pattern).test(value)) {
                            return { valid: false, message: validator.message || 'Invalid format' };
                        }
                    }

                    // Custom function validator
                    if (typeof validator === 'function') {
                        return validator(value, rowData);
                    }

                    // String function name
                    if (typeof validator === 'string' && typeof window[validator] === 'function') {
                        return window[validator](value, rowData);
                    }

                    return { valid: true };
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

                // ========================================
                // CONTEXT MENU FUNCTIONS
                // ========================================

                /**
                 * Initialize context menu for a grid
                 */
                function initContextMenu(gridId, config) {
                    const instance = instances[gridId];
                    if (!instance) return;

                    // Create context menu container (hidden by default)
                    const menuEl = document.createElement('div');
                    menuEl.id = `${gridId}-context-menu`;
                    menuEl.className = `geo-grid-context-menu ${config.contextMenuClass || ''}`.trim();
                    menuEl.style.display = 'none';
                    document.body.appendChild(menuEl);

                    instance.contextMenuEl = menuEl;

                    // Add native contextmenu event listener on the grid container
                    // This ensures context menu works even if AG Grid's onCellContextMenu doesn't fire
                    const container = document.getElementById(gridId);
                    if (container) {
                        container.addEventListener('contextmenu', (e) => {
                            // Check if right-click is on a grid row
                            const rowElement = e.target.closest('.ag-row');
                            if (rowElement) {
                                e.preventDefault();
                                e.stopPropagation();

                                // Get row index from the row element
                                const rowIndex = parseInt(rowElement.getAttribute('row-index'));
                                if (!isNaN(rowIndex)) {
                                    // Get the row node from the API
                                    const rowNode = instance.api.getDisplayedRowAtIndex(rowIndex);
                                    if (rowNode && rowNode.data) {
                                        showContextMenu(gridId, e, rowNode.data, rowNode);
                                    }
                                }
                            }
                        });
                    }

                    // Close menu on click outside
                    document.addEventListener('click', (e) => {
                        if (!menuEl.contains(e.target)) {
                            hideContextMenu(gridId);
                        }
                    });

                    // Close menu on scroll
                    document.addEventListener('scroll', () => hideContextMenu(gridId), true);

                    // Close menu on escape key
                    document.addEventListener('keydown', (e) => {
                        if (e.key === 'Escape') {
                            hideContextMenu(gridId);
                        }
                    });
                }

                /**
                 * Show context menu at specified position
                 */
                function showContextMenu(gridId, event, rowData, node) {
                    const instance = instances[gridId];
                    if (!instance || !instance.contextMenuEl) {
                        console.warn('GeoGrid: No instance or contextMenuEl found for', gridId);
                        return;
                    }

                    const config = instance.config;
                    const menuEl = instance.contextMenuEl;

                    // Get menu items (either static or dynamic)
                    let menuItems = config.contextMenuItems || [];

                    // If no items configured, use default items
                    if (menuItems.length === 0) {
                        menuItems = getDefaultContextMenuItems(config);
                    }

                    // Build menu HTML
                    const menuHtml = buildContextMenuHtml(gridId, menuItems, rowData, node);
                    menuEl.innerHTML = menuHtml;

                    // Position menu
                    const x = event.clientX;
                    const y = event.clientY;

                    // Make menu visible for size calculation (but not shown yet)
                    menuEl.style.display = 'block';
                    menuEl.classList.remove('show');

                    const menuRect = menuEl.getBoundingClientRect();
                    const viewportWidth = window.innerWidth;
                    const viewportHeight = window.innerHeight;

                    let finalX = x;
                    let finalY = y;

                    if (x + menuRect.width > viewportWidth) {
                        finalX = viewportWidth - menuRect.width - 10;
                    }
                    if (y + menuRect.height > viewportHeight) {
                        finalY = viewportHeight - menuRect.height - 10;
                    }

                    menuEl.style.left = `${finalX}px`;
                    menuEl.style.top = `${finalY}px`;

                    // Show menu with animation
                    requestAnimationFrame(() => {
                        menuEl.classList.add('show');
                    });

                    // Store current row data for menu actions
                    menuEl.dataset.rowData = JSON.stringify(rowData);
                    menuEl.dataset.nodeId = node.id;

                    // Add click handlers to menu items
                    menuEl.querySelectorAll('.geo-grid-context-menu-item:not(.disabled)').forEach(item => {
                        item.onclick = (e) => {
                            e.stopPropagation();
                            const action = item.dataset.action;
                            handleContextMenuAction(gridId, action, rowData, node);
                            hideContextMenu(gridId);
                        };
                    });
                }

                /**
                 * Hide context menu
                 */
                function hideContextMenu(gridId) {
                    const instance = instances[gridId];
                    if (!instance || !instance.contextMenuEl) return;

                    instance.contextMenuEl.classList.remove('show');
                    // Wait for animation to complete before hiding
                    setTimeout(() => {
                        if (!instance.contextMenuEl.classList.contains('show')) {
                            instance.contextMenuEl.style.display = 'none';
                        }
                    }, 150);
                }

                /**
                 * Get default context menu items based on grid config
                 */
                function getDefaultContextMenuItems(config) {
                    const items = [];

                    // View action (if actions enabled)
                    if (config.showActions) {
                        items.push({
                            action: 'view',
                            label: 'View Details',
                            icon: 'eye',
                        });
                    }

                    // Edit action (if editable)
                    if (config.editable) {
                        items.push({
                            action: 'edit',
                            label: 'Edit Row',
                            icon: 'pencil',
                        });
                    }

                    // Divider
                    if (items.length > 0) {
                        items.push({ divider: true });
                    }

                    // Copy action
                    items.push({
                        action: 'copy',
                        label: 'Copy Row Data',
                        icon: 'copy',
                    });

                    // Delete action (always available)
                    items.push({
                        action: 'delete',
                        label: 'Delete Row',
                        icon: 'trash',
                        class: 'danger',
                    });

                    return items;
                }

                /**
                 * Build context menu HTML
                 */
                function buildContextMenuHtml(gridId, items, rowData, node) {
                    let html = '';

                    items.forEach((item, index) => {
                        // Divider
                        if (item.divider) {
                            html += '<div class="geo-grid-context-menu-divider"></div>';
                            return;
                        }

                        // Header (non-clickable label)
                        if (item.header) {
                            html += `<div class="geo-grid-context-menu-header">${escapeHtml(item.header)}</div>`;
                            return;
                        }

                        // Check if item should be visible (dynamic visibility)
                        if (typeof item.visible === 'function' && !item.visible(rowData)) {
                            return;
                        }

                        // Check if item should be disabled
                        let isDisabled = false;
                        if (typeof item.disabled === 'function') {
                            isDisabled = item.disabled(rowData);
                        } else if (item.disabled === true) {
                            isDisabled = true;
                        }

                        // Build item classes
                        const classes = ['geo-grid-context-menu-item'];
                        if (isDisabled) classes.push('disabled');
                        if (item.class) classes.push(item.class);

                        // Icon
                        let iconHtml = '';
                        if (item.icon) {
                            iconHtml = `<i class="ki-outline ki-${item.icon} fs-5"></i>`;
                        } else if (item.iconHtml) {
                            iconHtml = item.iconHtml;
                        }

                        // Shortcut hint
                        let shortcutHtml = '';
                        if (item.shortcut) {
                            shortcutHtml = `<span class="geo-grid-context-menu-shortcut">${escapeHtml(item.shortcut)}</span>`;
                        }

                        html += `
                            <div class="${classes.join(' ')}" data-action="${escapeHtml(item.action || '')}">
                                ${iconHtml}
                                <span class="geo-grid-context-menu-label">${escapeHtml(item.label)}</span>
                                ${shortcutHtml}
                            </div>
                        `;
                    });

                    return html;
                }

                /**
                 * Handle context menu action
                 */
                function handleContextMenuAction(gridId, action, rowData, node) {
                    const instance = instances[gridId];
                    if (!instance) return;

                    const config = instance.config;

                    // Call custom callback if defined
                    if (config.callbacks.onContextMenuAction) {
                        executeCallback(config.callbacks.onContextMenuAction, {
                            action: action,
                            rowData: rowData,
                            node: node,
                            gridId: gridId,
                            api: instance.api,
                        });
                        return;
                    }

                    // Default action handlers
                    switch (action) {
                        case 'copy':
                            copyRowToClipboard(rowData);
                            break;
                        case 'delete':
                            if (confirm('Are you sure you want to delete this row?')) {
                                instance.api.applyTransaction({ remove: [rowData] });
                            }
                            break;
                        case 'edit':
                            // Start editing first editable cell
                            const firstEditableCol = config.columns.find(col => col.editable !== false);
                            if (firstEditableCol) {
                                instance.api.startEditingCell({
                                    rowIndex: node.rowIndex,
                                    colKey: firstEditableCol.key,
                                });
                            }
                            break;
                        case 'view':
                            console.log('View row:', rowData);
                            break;
                        default:
                            console.log(`Context menu action: ${action}`, rowData);
                    }
                }

                /**
                 * Copy row data to clipboard
                 */
                function copyRowToClipboard(rowData) {
                    const text = JSON.stringify(rowData, null, 2);
                    if (navigator.clipboard) {
                        navigator.clipboard.writeText(text).then(() => {
                            console.log('Row data copied to clipboard');
                        }).catch(err => {
                            console.error('Failed to copy:', err);
                        });
                    } else {
                        // Fallback for older browsers
                        const textarea = document.createElement('textarea');
                        textarea.value = text;
                        document.body.appendChild(textarea);
                        textarea.select();
                        document.execCommand('copy');
                        document.body.removeChild(textarea);
                    }
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

                    /**
                     * Get locale text for AG Grid localization
                     * @param {string} locale - Locale code (e.g., 'ar', 'fr', 'he')
                     * @returns {Object} Locale text object for AG Grid
                     */
                    getLocaleText(locale) {
                        return getLocaleTextForLocale(locale);
                    },

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
                        if (!instance) return;

                        if (instance.config.serverSide) {
                            // For server-side, refresh the data source
                            if (instance.config.serverSideInfinite) {
                                instance.api.setDatasource(createInfiniteDatasource(instance.config));
                            } else {
                                instance.api.refreshServerSide({ purge: true });
                            }
                        } else if (instance.config.ajaxUrl) {
                            loadAjaxData(gridId, instance.config.ajaxUrl);
                        }
                    },

                    /**
                     * Refresh server-side data (alias for refresh with server-side grids)
                     */
                    refreshServerSide(gridId, options = {}) {
                        const instance = instances[gridId];
                        if (!instance || !instance.config.serverSide) return;

                        if (instance.config.serverSideInfinite) {
                            instance.api.setDatasource(createInfiniteDatasource(instance.config));
                        } else {
                            instance.api.refreshServerSide({
                                route: options.route || undefined,
                                purge: options.purge !== false, // Default: true
                            });
                        }
                    },

                    /**
                     * Get server-side cache info
                     */
                    getServerSideCacheInfo(gridId) {
                        const instance = instances[gridId];
                        if (!instance || !instance.config.serverSide) return null;

                        return {
                            isServerSide: true,
                            isInfinite: instance.config.serverSideInfinite,
                            cacheBlockSize: instance.config.cacheBlockSize,
                        };
                    },

                    /**
                     * Purge server-side cache and reload
                     */
                    purgeServerSideCache(gridId) {
                        const instance = instances[gridId];
                        if (!instance || !instance.config.serverSide) return;

                        if (instance.config.serverSideInfinite) {
                            instance.api.purgeInfiniteCache();
                        } else {
                            instance.api.refreshServerSide({ purge: true });
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

                    // ========================================
                    // INLINE EDITING API
                    // ========================================

                    /**
                     * Start editing a cell
                     */
                    startEditing(gridId, rowIndex, colKey) {
                        const instance = instances[gridId];
                        if (instance) {
                            instance.api.startEditingCell({
                                rowIndex: rowIndex,
                                colKey: colKey,
                            });
                        }
                    },

                    /**
                     * Stop all editing
                     */
                    stopEditing(gridId, cancel = false) {
                        const instance = instances[gridId];
                        if (instance) {
                            instance.api.stopEditing(cancel);
                        }
                    },

                    /**
                     * Get all edited cells (for tracking changes)
                     */
                    getEditedCells(gridId) {
                        const instance = instances[gridId];
                        if (!instance) return [];
                        // Note: AG Grid doesn't track this by default
                        // This would need custom implementation if needed
                        return [];
                    },

                    /**
                     * Undo last cell edit
                     */
                    undoCellEdit(gridId) {
                        const instance = instances[gridId];
                        if (instance && instance.config.undoRedoCellEditing) {
                            instance.api.undoCellEditing();
                        }
                    },

                    /**
                     * Redo last undone cell edit
                     */
                    redoCellEdit(gridId) {
                        const instance = instances[gridId];
                        if (instance && instance.config.undoRedoCellEditing) {
                            instance.api.redoCellEditing();
                        }
                    },

                    /**
                     * Update a cell value programmatically
                     */
                    updateCellValue(gridId, rowKey, colKey, newValue) {
                        const instance = instances[gridId];
                        if (!instance) return false;

                        const rowNode = instance.api.getRowNode(rowKey);
                        if (rowNode) {
                            rowNode.setDataValue(colKey, newValue);
                            return true;
                        }
                        return false;
                    },

                    // ========================================
                    // ROW DRAGGING API
                    // ========================================

                    /**
                     * Get current row order after dragging
                     */
                    getRowOrder(gridId) {
                        const instance = instances[gridId];
                        if (!instance) return [];

                        const rowData = [];
                        instance.api.forEachNode((node) => {
                            if (node.data) {
                                rowData.push(node.data);
                            }
                        });
                        return rowData;
                    },

                    /**
                     * Get row IDs in current order
                     */
                    getRowOrderIds(gridId) {
                        const instance = instances[gridId];
                        if (!instance) return [];

                        const ids = [];
                        instance.api.forEachNode((node) => {
                            if (node.data) {
                                const id = node.data[instance.config.rowKey] || node.data.id;
                                if (id !== undefined) ids.push(id);
                            }
                        });
                        return ids;
                    },

                    /**
                     * Move row to new position programmatically
                     */
                    moveRow(gridId, fromIndex, toIndex) {
                        const instance = instances[gridId];
                        if (!instance) return false;

                        // Get all row data
                        const rowData = [];
                        instance.api.forEachNode((node) => {
                            if (node.data) rowData.push(node.data);
                        });

                        if (fromIndex < 0 || fromIndex >= rowData.length) return false;
                        if (toIndex < 0 || toIndex >= rowData.length) return false;

                        // Move the row
                        const [movedRow] = rowData.splice(fromIndex, 1);
                        rowData.splice(toIndex, 0, movedRow);

                        // Update grid
                        instance.api.setGridOption('rowData', rowData);
                        return true;
                    },

                    /**
                     * Reset row order to original data order
                     */
                    resetRowOrder(gridId) {
                        const instance = instances[gridId];
                        if (instance && instance.config.data) {
                            instance.api.setGridOption('rowData', [...instance.config.data]);
                        }
                    },

                    // ========================================
                    // CONTEXT MENU API
                    // ========================================

                    /**
                     * Show context menu programmatically
                     */
                    showContextMenu(gridId, rowData, x, y) {
                        const instance = instances[gridId];
                        if (!instance) return;

                        // Create a fake event and node for the menu
                        const fakeEvent = { clientX: x, clientY: y };
                        const fakeNode = { id: rowData[instance.config.rowKey] || rowData.id };

                        showContextMenu(gridId, fakeEvent, rowData, fakeNode);
                    },

                    /**
                     * Hide context menu
                     */
                    hideContextMenu(gridId) {
                        hideContextMenu(gridId);
                    },

                    /**
                     * Update context menu items dynamically
                     */
                    setContextMenuItems(gridId, items) {
                        const instance = instances[gridId];
                        if (instance) {
                            instance.config.contextMenuItems = items;
                        }
                    },

                    /**
                     * Get current context menu items
                     */
                    getContextMenuItems(gridId) {
                        const instance = instances[gridId];
                        if (!instance) return [];
                        return instance.config.contextMenuItems || getDefaultContextMenuItems(instance.config);
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
