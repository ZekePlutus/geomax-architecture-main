{{--
    Metronic DataTable Component
    
    Based on: https://preview.keenthemes.com/html/metronic/docs/?page=general/datatables
    
    Usage Examples:
    
    1. Basic (Zero Configuration):
    <x-datatable.base id="my_table" :columns="$columns" :data="$data" />
    
    2. With Card Wrapper:
    <x-datatable.base 
        id="users_table" 
        cardTitle="Users Management"
        :columns="$columns" 
        :data="$data" 
    />
    
    3. Server-side with AJAX:
    <x-datatable.base 
        id="server_table" 
        :columns="$columns"
        :ajax="route('users.datatable')"
        :serverSide="true"
    />
    
    4. With Column Search & Column Visibility:
    <x-datatable.base 
        id="advanced_table"
        cardTitle="Advanced Table"
        :columns="$columns"
        :data="$data"
        :columnSearch="true"
        :colVis="true"
    />
--}}

@props([
    // Table ID (required for multiple tables on same page)
    'id' => 'kt_datatable_' . uniqid(),
    
    // Table CSS classes (Metronic default)
    'class' => 'table align-middle table-row-dashed table-row-bordered fs-6 gy-5',
    
    // Column definitions array
    // Format: [['title' => 'Name', 'data' => 'name', 'width' => '100px', 'align' => 'left|center|right', 'orderable' => true, 'searchable' => true, 'className' => '', 'render' => null]]
    'columns' => [],
    
    // Data source - either static array or AJAX URL
    'data' => null,
    'ajax' => null,
    
    // Server-side processing
    'serverSide' => false,
    'processing' => true,
    
    // Pagination
    'paging' => true,
    'pageLength' => 10,
    'lengthMenu' => [[10, 25, 50, 100], [10, 25, 50, 100]],
    
    // Features
    'searching' => true,
    'ordering' => true,
    'order' => [[0, 'asc']],
    'info' => true,
    
    // Responsive
    'responsive' => true,
    
    // Scrolling
    'scrollX' => false,
    'scrollY' => null,
    
    // State saving
    'stateSave' => false,
    
    // Column search row
    'columnSearch' => false,
    
    // Column visibility toggle
    'colVis' => false,
    
    // Card wrapper
    'showCard' => true,
    'cardTitle' => null,
    'cardToolbar' => null,
    
    // Show footer
    'showFooter' => false,
    
    // Row selection: false, 'single', 'multi', or 'os' (os = operating system style)
    'select' => false,
    
    // Highlighting: 'row', 'column', 'cell', 'rowColumn', or false
    'highlight' => false,
    
    // Column reorder: allows drag & drop column reordering
    'colReorder' => false,
    
    // Extra DataTable options (will be merged)
    'options' => [],
])

@php
    // Normalize columns and add alignment className for DataTables
    $normalizedColumns = collect($columns)->map(function ($col) {
        if (is_string($col)) {
            return ['title' => $col, 'data' => \Illuminate\Support\Str::slug($col, '_')];
        }
        
        // Add alignment class to className for DataTables body cells
        if (!empty($col['align'])) {
            $alignClass = 'dt-' . $col['align'];
            $col['className'] = isset($col['className']) 
                ? $col['className'] . ' ' . $alignClass 
                : $alignClass;
        }
        
        return $col;
    })->values()->all();
    
    // Build DataTable options
    $dtOptions = [
        'processing' => $processing,
        'serverSide' => $serverSide,
        'paging' => $paging,
        'pageLength' => $pageLength,
        'lengthMenu' => $lengthMenu,
        'searching' => $searching,
        'ordering' => $ordering,
        'order' => $order,
        'info' => $info,
        'responsive' => $responsive,
        'stateSave' => $stateSave,
        'columns' => $normalizedColumns,
        // Layout configuration - positions elements correctly
        'layout' => [
            'topStart' => 'pageLength',
            'topEnd' => 'search',
            'bottomStart' => 'info',
            'bottomEnd' => 'paging',
        ],
    ];
    
    // Scrolling
    if ($scrollX) {
        $dtOptions['scrollX'] = true;
    }
    if ($scrollY) {
        $dtOptions['scrollY'] = $scrollY;
        $dtOptions['scrollCollapse'] = true;
    }
    
    // Data source
    if ($ajax) {
        $dtOptions['ajax'] = $ajax;
    }
    if ($data) {
        $dtOptions['data'] = $data;
    }
    
    // Row selection
    if ($select) {
        $dtOptions['select'] = is_string($select) ? ['style' => $select] : $select;
    }
    
    // Column reorder
    if ($colReorder) {
        $dtOptions['colReorder'] = is_array($colReorder) ? $colReorder : true;
    }
    
    // Merge extra options
    $dtOptions = array_merge($dtOptions, $options);
@endphp

{{-- Card wrapper start --}}
@if($showCard)
<div class="card card-flush">
    @if($cardTitle || $cardToolbar || $colVis || $columnSearch)
    <div class="card-header align-items-center py-5 gap-2 gap-md-5">
        @if($cardTitle)
        <div class="card-title">
            <h3 class="card-label fw-bold text-gray-900">{{ $cardTitle }}</h3>
        </div>
        @endif
        
        <div class="card-toolbar flex-row-fluid justify-content-end gap-2">
            @if($columnSearch)
            {{-- Reset Filter Button --}}
            <button type="button" class="btn btn-light btn-sm" id="{{ $id }}_reset" title="{{ __('Reset filters') }}">
                <i class="ki-outline ki-arrows-circle fs-4"></i>
            </button>
            @endif
            
            @if($colVis)
            {{-- Column Visibility Button --}}
            <button type="button" class="btn btn-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                <i class="ki-outline ki-eye fs-4 me-1"></i>{{ __('Columns') }}
            </button>
            {{-- Column Visibility Menu --}}
            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4" data-kt-menu="true" id="{{ $id }}_colvis_menu">
                @foreach($normalizedColumns as $index => $col)
                    @if(isset($col['data']) && !in_array($col['data'], ['actions', 'checkbox']))
                    <div class="menu-item px-3">
                        <label class="menu-link px-3 d-flex align-items-center cursor-pointer">
                            <input class="form-check-input me-3" type="checkbox" checked data-column="{{ $index }}" />
                            <span>{{ $col['title'] ?? '' }}</span>
                        </label>
                    </div>
                    @endif
                @endforeach
            </div>
            @endif
            
            @if($cardToolbar)
            {{ $cardToolbar }}
            @endif
        </div>
    </div>
    @endif
    
    <div class="card-body pt-0">
@endif

{{-- Table --}}
@php
    $tableClasses = $class;
    if ($highlight) {
        $tableClasses .= ' dt-highlight-' . $highlight;
    }
@endphp
<div class="table-responsive">
    <table id="{{ $id }}" class="{{ $tableClasses }}" style="width: 100%;">
        <thead>
            <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                @foreach($normalizedColumns as $col)
                @php
                    $thClasses = [];
                    if (!empty($col['align'])) {
                        $thClasses[] = 'dt-' . $col['align'];
                    }
                    if (!empty($col['className'])) {
                        $thClasses[] = $col['className'];
                    }
                @endphp
                <th @if(!empty($col['width'])) style="width: {{ $col['width'] }};" @endif @if(!empty($thClasses)) class="{{ implode(' ', $thClasses) }}" @endif>
                    {{ $col['title'] ?? '' }}
                </th>
                @endforeach
            </tr>
            @if($columnSearch)
            <tr class="dt-column-search">
                @foreach($normalizedColumns as $index => $col)
                <th class="p-2">
                    @php
                        $searchable = $col['searchable'] ?? true;
                        $searchType = $col['searchType'] ?? 'text';
                        $searchOptions = $col['searchOptions'] ?? [];
                        $colData = $col['data'] ?? null;
                    @endphp
                    @if($searchable && $colData && !in_array($colData, ['actions', 'checkbox']))
                        @if($searchType === 'select')
                        <select class="form-select form-select-sm form-select-solid dt-column-search-input" data-column="{{ $index }}">
                            <option value="">{{ __('All') }}</option>
                            @foreach($searchOptions as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @elseif($searchType === 'date')
                        <input type="text" class="form-control form-control-sm form-control-solid dt-column-search-date" data-column="{{ $index }}" placeholder="{{ __('Select date') }}" readonly />
                        @elseif($searchType === 'number')
                        <div class="d-flex gap-1">
                            <input type="number" class="form-control form-control-sm form-control-solid dt-column-search-min" data-column="{{ $index }}" placeholder="{{ __('Min') }}" style="width: 50%;" />
                            <input type="number" class="form-control form-control-sm form-control-solid dt-column-search-max" data-column="{{ $index }}" placeholder="{{ __('Max') }}" style="width: 50%;" />
                        </div>
                        @else
                        <input type="text" class="form-control form-control-sm form-control-solid dt-column-search-input" data-column="{{ $index }}" placeholder="{{ __('Search...') }}" />
                        @endif
                    @endif
                </th>
                @endforeach
            </tr>
            @endif
        </thead>
        <tbody class="text-gray-600 fw-semibold">
            {{ $slot }}
        </tbody>
        @if($showFooter)
        <tfoot>
            <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                @foreach($normalizedColumns as $col)
                <th>{{ $col['title'] ?? '' }}</th>
                @endforeach
            </tr>
        </tfoot>
        @endif
    </table>
</div>

{{-- Card wrapper end --}}
@if($showCard)
    </div>
</div>
@endif

{{-- DataTable Assets (loaded once) --}}
@once
@push('styles')
<link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
<style>
/* Default: all headers left-aligned (override DataTables numeric auto-alignment) */
table.dataTable thead th,
table.dataTable thead th.dt-type-numeric {
    text-align: left !important;
}

/* Column alignment classes */
table.dataTable thead th.dt-left,
table.dataTable tbody td.dt-left {
    text-align: left !important;
}

table.dataTable thead th.dt-center,
table.dataTable tbody td.dt-center {
    text-align: center !important;
}

table.dataTable thead th.dt-right,
table.dataTable tbody td.dt-right {
    text-align: right !important;
}

/* Fix sorting icon alignment - always on right */
table.dataTable thead th.dt-orderable-asc .dt-column-order,
table.dataTable thead th.dt-orderable-desc .dt-column-order,
table.dataTable thead th.dt-ordering-asc .dt-column-order,
table.dataTable thead th.dt-ordering-desc .dt-column-order {
    right: 10px !important;
    left: auto !important;
}

table.dataTable thead th .dt-column-header {
    display: flex;
    align-items: center;
    justify-content: flex-start;
}

table.dataTable thead th .dt-column-title {
    flex: 1;
}

/* Override numeric column alignment */
table.dataTable thead th.dt-type-numeric .dt-column-order {
    right: 10px !important;
    left: auto !important;
    position: absolute !important;
}

table.dataTable thead th.dt-type-numeric .dt-column-header {
    padding-right: 20px;
    justify-content: flex-start !important;
}

/* Column search row styling */
.dt-column-search th {
    background-color: var(--bs-gray-100);
    padding: 8px !important;
}

/* Row border styling */
table.dataTable.table-row-bordered tbody tr {
    border-bottom: 1px solid var(--bs-gray-100) !important;
}

table.dataTable.table-row-bordered tbody tr:last-child {
    border-bottom: 0 !important;
}

/* Card toolbar gap fix */
.card-toolbar .menu-sub-dropdown {
    z-index: 1050;
}

/* Hide empty label generated by DataTables length menu */
label[for="dt-length-0"] {
    display: none;
}

.dt-info {
    margin-left: 0.75rem;
}

/* Row highlighting on hover */
table.dataTable.dt-highlight-row tbody tr:hover {
    background-color: var(--bs-gray-100) !important;
}

/* Column highlighting on hover */
table.dataTable.dt-highlight-column tbody td.highlight {
    background-color: var(--bs-gray-100) !important;
}

table.dataTable.dt-highlight-column thead th.highlight {
    background-color: var(--bs-gray-100) !important;
}

/* Cell highlighting on hover */
table.dataTable.dt-highlight-cell tbody td:hover {
    background-color: var(--bs-gray-100) !important;
    cursor: pointer;
}

/* Row + Column highlighting (cross pattern) */
table.dataTable.dt-highlight-rowColumn tbody tr:hover {
    background-color: var(--bs-gray-100) !important;
}

table.dataTable.dt-highlight-rowColumn tbody td.highlight {
    background-color: var(--bs-gray-100) !important;
}

/* Selected row styling */
table.dataTable tbody tr.selected {
    background-color: var(--bs-primary-light) !important;
}

table.dataTable tbody tr.selected > td {
    background-color: var(--bs-primary-light) !important;
}

table.dataTable tbody tr.selected:hover {
    background-color: var(--bs-primary-light) !important;
}

/* Checkbox column styling */
table.dataTable th.dt-select-checkbox,
table.dataTable td.dt-select-checkbox {
    text-align: center !important;
    width: 40px !important;
}

table.dataTable th.dt-select-checkbox .form-check,
table.dataTable td.dt-select-checkbox .form-check {
    display: flex;
    justify-content: center;
    margin: 0;
    padding: 0;
}
</style>
@endpush

@push('scripts')
<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
@endpush
@endonce

{{-- DataTable Initialization --}}
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Wait for jQuery and DataTables
    function initDataTable() {
        if (typeof jQuery === 'undefined' || typeof jQuery.fn.DataTable === 'undefined') {
            setTimeout(initDataTable, 50);
            return;
        }
        
        var $ = jQuery;
        var tableId = '{{ $id }}';
        var $table = $('#' + tableId);
        
        // Skip if already initialized
        if ($.fn.DataTable.isDataTable('#' + tableId)) {
            return;
        }
        
        // DataTable options
        var options = @json($dtOptions);
        
        // Language settings
        options.language = {
            lengthMenu: '_MENU_',
            info: "{{ __('Showing _START_ to _END_ of _TOTAL_ records') }}",
            infoEmpty: "{{ __('No records available') }}",
            infoFiltered: "{{ __('(filtered from _MAX_ total records)') }}",
            search: '',
            searchPlaceholder: "{{ __('Search...') }}",
            zeroRecords: "{{ __('No matching records found') }}",
            processing: '<span class="spinner-border spinner-border-sm align-middle me-2"></span> {{ __("Loading...") }}',
            paginate: {
                first: '<i class="first"></i>',
                last: '<i class="last"></i>',
                next: '<i class="next"></i>',
                previous: '<i class="previous"></i>'
            }
        };
        
        @if($columnSearch)
        // Use orderCellsTop for column search
        options.orderCellsTop = true;
        @endif
        
        // Initialize DataTable
        var table = $table.DataTable(options);
        
        @if($colVis)
        // Column visibility toggle
        var $colvisMenu = $('#{{ $id }}_colvis_menu');
        $colvisMenu.on('change', 'input[type="checkbox"]', function() {
            var columnIndex = $(this).data('column');
            var column = table.column(columnIndex);
            column.visible(this.checked);
        });
        
        // Initialize KTMenu
        if (typeof KTMenu !== 'undefined') {
            KTMenu.createInstances();
        }
        @endif
        
        @if($columnSearch)
        // Column search - text input
        $table.find('.dt-column-search-input').on('keyup change', function() {
            var columnIndex = $(this).data('column');
            var value = this.value;
            table.column(columnIndex).search(value).draw();
        });
        
        // Column search - select
        $table.find('.dt-column-search-input[type="text"], .dt-column-search select.dt-column-search-input').on('change', function() {
            var columnIndex = $(this).data('column');
            var value = $(this).val();
            table.column(columnIndex).search(value).draw();
        });
        
        // Column search - number range
        $table.find('.dt-column-search-min, .dt-column-search-max').on('keyup change', function() {
            table.draw();
        });
        
        // Custom number range filter
        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
            if (settings.nTable.id !== tableId) return true;
            
            var validRow = true;
            $table.find('.dt-column-search-min').each(function() {
                var columnIndex = $(this).data('column');
                var min = parseFloat($(this).val()) || -Infinity;
                var max = parseFloat($table.find('.dt-column-search-max[data-column="' + columnIndex + '"]').val()) || Infinity;
                var value = parseFloat(data[columnIndex]) || 0;
                
                if (value < min || value > max) {
                    validRow = false;
                    return false;
                }
            });
            
            return validRow;
        });
        
        // Date picker for date columns
        $table.find('.dt-column-search-date').each(function() {
            var $input = $(this);
            var columnIndex = $input.data('column');
            
            if (typeof flatpickr !== 'undefined') {
                flatpickr($input[0], {
                    mode: 'range',
                    dateFormat: 'Y-m-d',
                    onChange: function(selectedDates, dateStr) {
                        table.column(columnIndex).search(dateStr).draw();
                    }
                });
            }
        });
        
        // Reset filters button
        $('#{{ $id }}_reset').on('click', function() {
            // Clear all inputs
            $table.find('.dt-column-search input').val('');
            $table.find('.dt-column-search select').val('');
            
            // Clear flatpickr
            $table.find('.dt-column-search-date').each(function() {
                if (this._flatpickr) {
                    this._flatpickr.clear();
                }
            });
            
            // Clear global search
            table.search('');
            
            // Clear column searches and redraw
            table.columns().search('').draw();
        });
        @endif
        
        @if($highlight === 'column' || $highlight === 'rowColumn')
        // Column highlighting
        $table.on('mouseenter', 'tbody td', function() {
            var colIdx = table.cell(this).index().column;
            $(table.cells().nodes()).removeClass('highlight');
            $(table.column(colIdx).nodes()).addClass('highlight');
            $(table.column(colIdx).header()).addClass('highlight');
        });
        
        $table.on('mouseleave', 'tbody', function() {
            $(table.cells().nodes()).removeClass('highlight');
            $table.find('thead th').removeClass('highlight');
        });
        @endif
        
        // Reinitialize KTMenu on redraw (for action dropdowns)
        table.on('draw', function() {
            if (typeof KTMenu !== 'undefined') {
                KTMenu.createInstances();
            }
            
            // Reinitialize tooltips
            var tooltips = document.querySelectorAll('#' + tableId + ' [data-bs-toggle="tooltip"]');
            tooltips.forEach(function(el) {
                new bootstrap.Tooltip(el);
            });
        });
    }
    
    initDataTable();
});
</script>
@endpush
