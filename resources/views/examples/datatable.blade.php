@extends('layout50.master')

@section('title', 'DataTable Component Examples')

@section('content')
<!--begin::Page Title-->
<div class="mb-10">
    <h1 class="text-gray-900 fw-bolder mb-2">DataTable Component</h1>
    <div class="text-muted fs-6">
        Professional server-side and client-side DataTable component for Metronic.
        <a href="{{ url('/examples') }}" class="link-primary">Back to Components</a>
    </div>
</div>
<!--end::Page Title-->

<!--begin::Table of Contents-->
<div class="card card-flush mb-10">
    <div class="card-body py-5">
        <h5 class="fw-bold mb-4">Quick Navigation</h5>
        <div class="d-flex flex-wrap gap-3">
            <a href="#basic" class="btn btn-sm btn-light-primary">Basic Usage</a>
            <a href="#card-wrapper" class="btn btn-sm btn-light-primary">Card Wrapper</a>
            <a href="#fixed-header" class="btn btn-sm btn-light-primary">Fixed Header</a>
            <a href="#column-alignment" class="btn btn-sm btn-light-primary">Column Alignment</a>
            <a href="#search-types" class="btn btn-sm btn-light-primary">Search Types</a>
            <a href="#column-visibility" class="btn btn-sm btn-light-primary">Column Visibility</a>
            <a href="#row-selection" class="btn btn-sm btn-light-primary">Row Selection</a>
            <a href="#col-reorder" class="btn btn-sm btn-light-primary">Column Reorder</a>
            <a href="#highlighting" class="btn btn-sm btn-light-primary">Highlighting</a>
            <a href="#server-side" class="btn btn-sm btn-light-primary">Server-Side</a>
            <a href="#props-reference" class="btn btn-sm btn-light-primary">Props Reference</a>
        </div>
    </div>
</div>
<!--end::Table of Contents-->

<!--===========================================-->
<!--begin::Section - Basic Usage -->
<!--===========================================-->
<div id="basic" class="mb-10">
    <h2 class="text-gray-800 fw-bold mb-5">1. Basic Usage</h2>
    
    <div class="row g-5 g-xl-10">
        <div class="col-12">
            <div class="card card-flush">
                <div class="card-header pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold text-gray-900">Simple DataTable</span>
                        <span class="text-muted mt-1 fw-semibold fs-7">Basic DataTable with static data</span>
                    </h3>
                </div>
                <div class="card-body">
                    <!--begin::Preview-->
                    <x-datatable.base
                        id="basic_table"
                        :columns="[
                            ['title' => 'ID', 'data' => 'id', 'width' => '60px', 'align' => 'center'],
                            ['title' => 'Name', 'data' => 'name'],
                            ['title' => 'Position', 'data' => 'position'],
                            ['title' => 'Office', 'data' => 'office'],
                            ['title' => 'Salary', 'data' => 'salary'],
                        ]"
                        :data="[
                            ['id' => 1, 'name' => 'Tiger Nixon', 'position' => 'System Architect', 'office' => 'Edinburgh', 'salary' => '\$320,800'],
                            ['id' => 2, 'name' => 'Garrett Winters', 'position' => 'Accountant', 'office' => 'Tokyo', 'salary' => '\$170,750'],
                            ['id' => 3, 'name' => 'Ashton Cox', 'position' => 'Junior Developer', 'office' => 'San Francisco', 'salary' => '\$86,000'],
                            ['id' => 4, 'name' => 'Cedric Kelly', 'position' => 'Senior Developer', 'office' => 'Edinburgh', 'salary' => '\$433,060'],
                            ['id' => 5, 'name' => 'Airi Satou', 'position' => 'Accountant', 'office' => 'Tokyo', 'salary' => '\$162,700'],
                        ]"
                        :showCard="false"
                    />
                    <!--end::Preview-->
                    
                    <!--begin::Code-->
                    <div class="rounded border p-5 bg-dark mt-5">
<pre class="text-white mb-0"><code>&lt;x-datatable.base
    id="basic_table"
    :columns="[
        ['title' => 'ID', 'data' => 'id', 'width' => '60px'],
        ['title' => 'Name', 'data' => 'name'],
        ['title' => 'Position', 'data' => 'position'],
        ['title' => 'Office', 'data' => 'office'],
        ['title' => 'Salary', 'data' => 'salary'],
    ]"
    :data="$data"
    :showCard="false"
/&gt;</code></pre>
                    </div>
                    <!--end::Code-->
                </div>
            </div>
        </div>
    </div>
</div>
<!--end::Section-->

<!--===========================================-->
<!--begin::Section - Card Wrapper -->
<!--===========================================-->
@php
$usersColumns = [
    ['title' => 'ID', 'data' => 'id', 'width' => '60px', 'align' => 'center'],
    ['title' => 'User', 'data' => 'user'],
    ['title' => 'Email', 'data' => 'email'],
    ['title' => 'Role', 'data' => 'role', 'align' => 'center'],
    ['title' => 'Status', 'data' => 'status', 'align' => 'center'],
];
$usersData = [
    ['id' => 1, 'user' => 'Max Smith', 'email' => 'max@example.com', 'role' => 'Administrator', 'status' => '<span class="badge badge-light-success">Active</span>'],
    ['id' => 2, 'user' => 'Sean Bean', 'email' => 'sean@example.com', 'role' => 'Developer', 'status' => '<span class="badge badge-light-success">Active</span>'],
    ['id' => 3, 'user' => 'Brian Cox', 'email' => 'brian@example.com', 'role' => 'Analyst', 'status' => '<span class="badge badge-light-warning">Pending</span>'],
    ['id' => 4, 'user' => 'John Doe', 'email' => 'john@example.com', 'role' => 'Support', 'status' => '<span class="badge badge-light-danger">Inactive</span>'],
];
@endphp
<div id="card-wrapper" class="mb-10">
    <h2 class="text-gray-800 fw-bold mb-5">2. Card Wrapper</h2>
    
    <div class="row g-5 g-xl-10">
        <div class="col-12">
            <!--begin::Preview-->
            <x-datatable.base
                id="card_table"
                cardTitle="Users Management"
                :columns="$usersColumns"
                :data="$usersData"
            />
            <!--end::Preview-->
        </div>
        
        <div class="col-12">
            <div class="card card-flush">
                <div class="card-header pt-5">
                    <h3 class="card-title">Code Example</h3>
                </div>
                <div class="card-body pt-0">
                    <div class="rounded border p-5 bg-dark">
<pre class="text-white mb-0"><code>&lt;x-datatable.base
    id="card_table"
    cardTitle="Users Management"
    :columns="$columns"
    :data="$data"
/&gt;</code></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end::Section-->

<!--===========================================-->
<!--begin::Section - Fixed Header -->
<!--===========================================-->
<div id="fixed-header" class="mb-10">
    <h2 class="text-gray-800 fw-bold mb-5">3. Fixed Header (Scroll Y)</h2>
    
    <div class="row g-5 g-xl-10">
        <div class="col-12">
            <!--begin::Preview-->
            <x-datatable.base
                id="fixed_header_table"
                cardTitle="Fixed Header Table"
                :columns="[
                    ['title' => 'ID', 'data' => 'id', 'width' => '60px', 'align' => 'center'],
                    ['title' => 'Name', 'data' => 'name'],
                    ['title' => 'Position', 'data' => 'position'],
                    ['title' => 'Office', 'data' => 'office'],
                    ['title' => 'Age', 'data' => 'age', 'align' => 'center'],
                    ['title' => 'Start Date', 'data' => 'start_date'],
                    ['title' => 'Salary', 'data' => 'salary', 'align' => 'right'],
                ]"
                :data="[
                    ['id' => 1, 'name' => 'Tiger Nixon', 'position' => 'System Architect', 'office' => 'Edinburgh', 'age' => 61, 'start_date' => '2011/04/25', 'salary' => '\$320,800'],
                    ['id' => 2, 'name' => 'Garrett Winters', 'position' => 'Accountant', 'office' => 'Tokyo', 'age' => 63, 'start_date' => '2011/07/25', 'salary' => '\$170,750'],
                    ['id' => 3, 'name' => 'Ashton Cox', 'position' => 'Junior Developer', 'office' => 'San Francisco', 'age' => 66, 'start_date' => '2009/01/12', 'salary' => '\$86,000'],
                    ['id' => 4, 'name' => 'Cedric Kelly', 'position' => 'Senior Developer', 'office' => 'Edinburgh', 'age' => 22, 'start_date' => '2012/03/29', 'salary' => '\$433,060'],
                    ['id' => 5, 'name' => 'Airi Satou', 'position' => 'Accountant', 'office' => 'Tokyo', 'age' => 33, 'start_date' => '2008/11/28', 'salary' => '\$162,700'],
                    ['id' => 6, 'name' => 'Brielle Williamson', 'position' => 'Integration Specialist', 'office' => 'New York', 'age' => 61, 'start_date' => '2012/12/02', 'salary' => '\$372,000'],
                    ['id' => 7, 'name' => 'Herrod Chandler', 'position' => 'Sales Assistant', 'office' => 'San Francisco', 'age' => 59, 'start_date' => '2012/08/06', 'salary' => '\$137,500'],
                    ['id' => 8, 'name' => 'Rhona Davidson', 'position' => 'Integration Specialist', 'office' => 'Tokyo', 'age' => 55, 'start_date' => '2010/10/14', 'salary' => '\$327,900'],
                    ['id' => 9, 'name' => 'Colleen Hurst', 'position' => 'Javascript Developer', 'office' => 'San Francisco', 'age' => 39, 'start_date' => '2009/09/15', 'salary' => '\$205,500'],
                    ['id' => 10, 'name' => 'Sonya Frost', 'position' => 'Software Engineer', 'office' => 'Edinburgh', 'age' => 23, 'start_date' => '2008/12/13', 'salary' => '\$103,600'],
                    ['id' => 11, 'name' => 'Jena Gaines', 'position' => 'Office Manager', 'office' => 'London', 'age' => 30, 'start_date' => '2008/12/19', 'salary' => '\$90,560'],
                    ['id' => 12, 'name' => 'Quinn Flynn', 'position' => 'Support Lead', 'office' => 'Edinburgh', 'age' => 22, 'start_date' => '2013/03/03', 'salary' => '\$342,000'],
                    ['id' => 13, 'name' => 'Charde Marshall', 'position' => 'Regional Director', 'office' => 'San Francisco', 'age' => 36, 'start_date' => '2008/10/16', 'salary' => '\$470,600'],
                    ['id' => 14, 'name' => 'Haley Kennedy', 'position' => 'Senior Marketing Designer', 'office' => 'London', 'age' => 43, 'start_date' => '2012/12/18', 'salary' => '\$313,500'],
                    ['id' => 15, 'name' => 'Tatyana Fitzpatrick', 'position' => 'Regional Director', 'office' => 'London', 'age' => 19, 'start_date' => '2010/03/17', 'salary' => '\$385,750'],
                ]"
                scrollY="300px"
                :paging="false"
                :info="false"
            />
            <!--end::Preview-->
        </div>
        
        <div class="col-12">
            <div class="card card-flush">
                <div class="card-header pt-5">
                    <h3 class="card-title">Code Example</h3>
                </div>
                <div class="card-body pt-0">
                    <div class="rounded border p-5 bg-dark">
<pre class="text-white mb-0"><code>&lt;x-datatable.base
    id="fixed_header_table"
    cardTitle="Fixed Header Table"
    :columns="$columns"
    :data="$largeData"
    scrollY="300px"
    :paging="false"
    :info="false"
/&gt;

// Use scrollY to set a fixed height for the table body
// The header will remain fixed while scrolling through the data</code></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end::Section-->

<!--===========================================-->
<!--begin::Section - Column Alignment -->
<!--===========================================-->
<div id="column-alignment" class="mb-10">
    <h2 class="text-gray-800 fw-bold mb-5">4. Column Alignment</h2>
    
    <div class="row g-5 g-xl-10">
        <div class="col-12">
            <!--begin::Preview-->
            <x-datatable.base
                id="alignment_table"
                cardTitle="Column Alignment Example"
                :columns="[
                    ['title' => 'ID', 'data' => 'id', 'width' => '80px', 'align' => 'center'],
                    ['title' => 'Name (Left)', 'data' => 'name', 'align' => 'left'],
                    ['title' => 'Position (Center)', 'data' => 'position', 'align' => 'center'],
                    ['title' => 'Office', 'data' => 'office'],
                    ['title' => 'Salary (Right)', 'data' => 'salary', 'align' => 'right'],
                ]"
                :data="[
                    ['id' => 1, 'name' => 'Tiger Nixon', 'position' => 'System Architect', 'office' => 'Edinburgh', 'salary' => '\$320,800'],
                    ['id' => 2, 'name' => 'Garrett Winters', 'position' => 'Accountant', 'office' => 'Tokyo', 'salary' => '\$170,750'],
                    ['id' => 3, 'name' => 'Ashton Cox', 'position' => 'Junior Developer', 'office' => 'San Francisco', 'salary' => '\$86,000'],
                    ['id' => 4, 'name' => 'Cedric Kelly', 'position' => 'Senior Developer', 'office' => 'Edinburgh', 'salary' => '\$433,060'],
                    ['id' => 5, 'name' => 'Airi Satou', 'position' => 'Accountant', 'office' => 'Tokyo', 'salary' => '\$162,700'],
                ]"
            />
            <!--end::Preview-->
        </div>
        
        <div class="col-12">
            <div class="card card-flush">
                <div class="card-header pt-5">
                    <h3 class="card-title">Code Example</h3>
                </div>
                <div class="card-body pt-0">
                    <div class="rounded border p-5 bg-dark">
<pre class="text-white mb-0"><code>&lt;x-datatable.base
    id="alignment_table"
    cardTitle="Column Alignment"
    :columns="[
        ['title' => 'ID', 'data' => 'id', 'align' => 'center'],
        ['title' => 'Name', 'data' => 'name', 'align' => 'left'],      // Default
        ['title' => 'Position', 'data' => 'position', 'align' => 'center'],
        ['title' => 'Office', 'data' => 'office'],                      // No align = left
        ['title' => 'Salary', 'data' => 'salary', 'align' => 'right'],
    ]"
    :data="$data"
/&gt;

// Available alignment options: 'left', 'center', 'right'
// Applies to both header and body cells</code></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end::Section-->

<!--===========================================-->
<!--begin::Section - Search Types -->
<!--===========================================-->
<div id="search-types" class="mb-10">
    <h2 class="text-gray-800 fw-bold mb-5">5. Column Search Types</h2>
    
    <div class="row g-5 g-xl-10">
        <div class="col-12">
            <!--begin::Preview-->
            <x-datatable.base
                id="search_types_table"
                cardTitle="Different Search Types per Column"
                :columnSearch="true"
                :columns="[
                    ['title' => 'ID', 'data' => 'id', 'width' => '60px', 'searchable' => false, 'align' => 'center'],
                    ['title' => 'Name', 'data' => 'name', 'searchType' => 'text'],
                    ['title' => 'Position', 'data' => 'position', 'searchType' => 'text'],
                    ['title' => 'Office', 'data' => 'office', 'searchType' => 'select', 'searchOptions' => [
                        'Edinburgh' => 'Edinburgh', 
                        'Tokyo' => 'Tokyo', 
                        'San Francisco' => 'San Francisco', 
                        'New York' => 'New York'
                    ]],
                    ['title' => 'Age', 'data' => 'age', 'searchType' => 'number', 'align' => 'center'],
                    ['title' => 'Salary', 'data' => 'salary', 'align' => 'right'],
                ]"
                :data="[
                    ['id' => 1, 'name' => 'Tiger Nixon', 'position' => 'System Architect', 'office' => 'Edinburgh', 'age' => 61, 'salary' => '\$320,800'],
                    ['id' => 2, 'name' => 'Garrett Winters', 'position' => 'Accountant', 'office' => 'Tokyo', 'age' => 63, 'salary' => '\$170,750'],
                    ['id' => 3, 'name' => 'Ashton Cox', 'position' => 'Junior Developer', 'office' => 'San Francisco', 'age' => 66, 'salary' => '\$86,000'],
                    ['id' => 4, 'name' => 'Cedric Kelly', 'position' => 'Senior Developer', 'office' => 'Edinburgh', 'age' => 22, 'salary' => '\$433,060'],
                    ['id' => 5, 'name' => 'Airi Satou', 'position' => 'Accountant', 'office' => 'Tokyo', 'age' => 33, 'salary' => '\$162,700'],
                    ['id' => 6, 'name' => 'Brielle Williams', 'position' => 'Integration Specialist', 'office' => 'New York', 'age' => 41, 'salary' => '\$372,000'],
                    ['id' => 7, 'name' => 'Herrod Chandler', 'position' => 'Sales Assistant', 'office' => 'San Francisco', 'age' => 59, 'salary' => '\$137,500'],
                    ['id' => 8, 'name' => 'Rhona Davidson', 'position' => 'Integration Specialist', 'office' => 'Tokyo', 'age' => 55, 'salary' => '\$327,900'],
                ]"
            />
            <!--end::Preview-->
        </div>
        
        <div class="col-12">
            <div class="card card-flush">
                <div class="card-header pt-5">
                    <h3 class="card-title">Search Type Options</h3>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive mb-5">
                        <table class="table table-row-bordered gy-4">
                            <thead>
                                <tr class="fw-bold bg-light">
                                    <th class="ps-4">searchType</th>
                                    <th>Description</th>
                                    <th class="pe-4">Additional Props</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="ps-4"><code>text</code></td>
                                    <td>Standard text input (default)</td>
                                    <td class="pe-4">-</td>
                                </tr>
                                <tr>
                                    <td class="ps-4"><code>select</code></td>
                                    <td>Dropdown select with predefined options</td>
                                    <td class="pe-4"><code>searchOptions</code> - array of options</td>
                                </tr>
                                <tr>
                                    <td class="ps-4"><code>number</code></td>
                                    <td>Min/Max number range filter</td>
                                    <td class="pe-4">-</td>
                                </tr>
                                <tr>
                                    <td class="ps-4"><code>date</code></td>
                                    <td>Date picker with range support</td>
                                    <td class="pe-4">Requires Flatpickr</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="rounded border p-5 bg-dark">
<pre class="text-white mb-0"><code>&lt;x-datatable.base
    id="search_types_table"
    cardTitle="Search Types Example"
    :columnSearch="true"
    :columns="[
        // No search for this column
        ['title' => 'ID', 'data' => 'id', 'searchable' => false],
        
        // Text search (default)
        ['title' => 'Name', 'data' => 'name', 'searchType' => 'text'],
        
        // Select dropdown search
        ['title' => 'Office', 'data' => 'office', 
         'searchType' => 'select', 
         'searchOptions' => [
             'Edinburgh' => 'Edinburgh', 
             'Tokyo' => 'Tokyo',
             'San Francisco' => 'San Francisco'
         ]
        ],
        
        // Number range (Min/Max)
        ['title' => 'Age', 'data' => 'age', 'searchType' => 'number'],
        
        // Date picker
        ['title' => 'Start Date', 'data' => 'start_date', 'searchType' => 'date'],
    ]"
    :data="$data"
/&gt;</code></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end::Section-->

<!--===========================================-->
<!--begin::Section - Column Visibility -->
<!--===========================================-->
<div id="column-visibility" class="mb-10">
    <h2 class="text-gray-800 fw-bold mb-5">6. Column Visibility & Reset Filter</h2>
    
    <div class="row g-5 g-xl-10">
        <div class="col-12">
            <!--begin::Preview-->
            <x-datatable.base
                id="colvis_table"
                cardTitle="Toggle Columns & Reset Filters"
                :columnSearch="true"
                :colVis="true"
                :columns="[
                    ['title' => 'ID', 'data' => 'id', 'width' => '60px', 'searchable' => false, 'align' => 'center'],
                    ['title' => 'Name', 'data' => 'name', 'searchType' => 'text'],
                    ['title' => 'Position', 'data' => 'position', 'searchType' => 'text'],
                    ['title' => 'Office', 'data' => 'office', 'searchType' => 'select', 'searchOptions' => [
                        'Edinburgh' => 'Edinburgh', 
                        'Tokyo' => 'Tokyo', 
                        'San Francisco' => 'San Francisco', 
                        'New York' => 'New York'
                    ]],
                    ['title' => 'Age', 'data' => 'age', 'searchType' => 'number', 'align' => 'center'],
                    ['title' => 'Salary', 'data' => 'salary', 'align' => 'right'],
                ]"
                :data="[
                    ['id' => 1, 'name' => 'Tiger Nixon', 'position' => 'System Architect', 'office' => 'Edinburgh', 'age' => 61, 'salary' => '\$320,800'],
                    ['id' => 2, 'name' => 'Garrett Winters', 'position' => 'Accountant', 'office' => 'Tokyo', 'age' => 63, 'salary' => '\$170,750'],
                    ['id' => 3, 'name' => 'Ashton Cox', 'position' => 'Junior Developer', 'office' => 'San Francisco', 'age' => 66, 'salary' => '\$86,000'],
                    ['id' => 4, 'name' => 'Cedric Kelly', 'position' => 'Senior Developer', 'office' => 'Edinburgh', 'age' => 22, 'salary' => '\$433,060'],
                    ['id' => 5, 'name' => 'Airi Satou', 'position' => 'Accountant', 'office' => 'Tokyo', 'age' => 33, 'salary' => '\$162,700'],
                    ['id' => 6, 'name' => 'Brielle Williams', 'position' => 'Integration Specialist', 'office' => 'New York', 'age' => 41, 'salary' => '\$372,000'],
                    ['id' => 7, 'name' => 'Herrod Chandler', 'position' => 'Sales Assistant', 'office' => 'San Francisco', 'age' => 59, 'salary' => '\$137,500'],
                    ['id' => 8, 'name' => 'Rhona Davidson', 'position' => 'Integration Specialist', 'office' => 'Tokyo', 'age' => 55, 'salary' => '\$327,900'],
                ]"
            />
            <!--end::Preview-->
        </div>
        
        <div class="col-12">
            <div class="card card-flush">
                <div class="card-header pt-5">
                    <h3 class="card-title">Code Example</h3>
                </div>
                <div class="card-body pt-0">
                    <div class="rounded border p-5 bg-dark">
<pre class="text-white mb-0"><code>&lt;x-datatable.base
    id="colvis_table"
    cardTitle="Advanced Table"
    :columnSearch="true"    {{-- Enables column search + Reset button --}}
    :colVis="true"          {{-- Enables column visibility toggle --}}
    :columns="$columns"
    :data="$data"
/&gt;

// :columnSearch="true" adds:
//   - Per-column search inputs in header
//   - Reset filter button in toolbar
//
// :colVis="true" adds:
//   - "Columns" dropdown button in toolbar
//   - Checkboxes to show/hide columns</code></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end::Section-->

<!--===========================================-->
<!--begin::Section - Row Selection -->
<!--===========================================-->
<div id="row-selection" class="mb-10">
    <h2 class="text-gray-800 fw-bold mb-5">7. Row Selection</h2>
    
    <div class="row g-5 g-xl-10">
        <div class="col-12">
            <!--begin::Preview-->
            <x-datatable.base
                id="select_table"
                cardTitle="Select Rows (Click to select)"
                select="multi"
                :columns="[
                    ['title' => 'ID', 'data' => 'id', 'width' => '60px', 'align' => 'center'],
                    ['title' => 'Name', 'data' => 'name'],
                    ['title' => 'Position', 'data' => 'position'],
                    ['title' => 'Office', 'data' => 'office'],
                    ['title' => 'Salary', 'data' => 'salary', 'align' => 'right'],
                ]"
                :data="[
                    ['id' => 1, 'name' => 'Tiger Nixon', 'position' => 'System Architect', 'office' => 'Edinburgh', 'salary' => '\$320,800'],
                    ['id' => 2, 'name' => 'Garrett Winters', 'position' => 'Accountant', 'office' => 'Tokyo', 'salary' => '\$170,750'],
                    ['id' => 3, 'name' => 'Ashton Cox', 'position' => 'Junior Developer', 'office' => 'San Francisco', 'salary' => '\$86,000'],
                    ['id' => 4, 'name' => 'Cedric Kelly', 'position' => 'Senior Developer', 'office' => 'Edinburgh', 'salary' => '\$433,060'],
                    ['id' => 5, 'name' => 'Airi Satou', 'position' => 'Accountant', 'office' => 'Tokyo', 'salary' => '\$162,700'],
                ]"
            />
            <!--end::Preview-->
        </div>
        
        <div class="col-12">
            <div class="card card-flush">
                <div class="card-header pt-5">
                    <h3 class="card-title">Selection Options</h3>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive mb-5">
                        <table class="table table-row-bordered gy-4">
                            <thead>
                                <tr class="fw-bold bg-light">
                                    <th class="ps-4">Value</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="ps-4"><code>false</code></td>
                                    <td>Selection disabled (default)</td>
                                </tr>
                                <tr>
                                    <td class="ps-4"><code>'single'</code></td>
                                    <td>Only one row can be selected at a time</td>
                                </tr>
                                <tr>
                                    <td class="ps-4"><code>'multi'</code></td>
                                    <td>Multiple rows can be selected</td>
                                </tr>
                                <tr>
                                    <td class="ps-4"><code>'os'</code></td>
                                    <td>Operating system style (Ctrl/Cmd + click for multi)</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="rounded border p-5 bg-dark">
<pre class="text-white mb-0"><code>&lt;x-datatable.base
    id="select_table"
    cardTitle="Selectable Table"
    select="multi"          {{-- 'single', 'multi', or 'os' --}}
    :columns="$columns"
    :data="$data"
/&gt;

// Get selected rows via JavaScript:
// var table = $('#select_table').DataTable();
// var selectedData = table.rows({ selected: true }).data().toArray();</code></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end::Section-->

<!--===========================================-->
<!--begin::Section - Column Reorder -->
<!--===========================================-->
<div id="col-reorder" class="mb-10">
    <h2 class="text-gray-800 fw-bold mb-5">8. Column Reorder</h2>
    
    <div class="row g-5 g-xl-10">
        <div class="col-12">
            <!--begin::Preview-->
            <x-datatable.base
                id="colreorder_table"
                cardTitle="Drag & Drop Columns (Drag column headers to reorder)"
                :colReorder="true"
                :columns="[
                    ['title' => 'ID', 'data' => 'id', 'width' => '60px', 'align' => 'center'],
                    ['title' => 'Name', 'data' => 'name'],
                    ['title' => 'Position', 'data' => 'position'],
                    ['title' => 'Office', 'data' => 'office'],
                    ['title' => 'Salary', 'data' => 'salary', 'align' => 'right'],
                ]"
                :data="[
                    ['id' => 1, 'name' => 'Tiger Nixon', 'position' => 'System Architect', 'office' => 'Edinburgh', 'salary' => '\$320,800'],
                    ['id' => 2, 'name' => 'Garrett Winters', 'position' => 'Accountant', 'office' => 'Tokyo', 'salary' => '\$170,750'],
                    ['id' => 3, 'name' => 'Ashton Cox', 'position' => 'Junior Developer', 'office' => 'San Francisco', 'salary' => '\$86,000'],
                    ['id' => 4, 'name' => 'Cedric Kelly', 'position' => 'Senior Developer', 'office' => 'Edinburgh', 'salary' => '\$433,060'],
                    ['id' => 5, 'name' => 'Airi Satou', 'position' => 'Accountant', 'office' => 'Tokyo', 'salary' => '\$162,700'],
                ]"
            />
            <!--end::Preview-->
        </div>
        
        <div class="col-12">
            <div class="card card-flush">
                <div class="card-header pt-5">
                    <h3 class="card-title">Usage</h3>
                </div>
                <div class="card-body pt-0">
                    <div class="rounded border p-5 bg-dark">
<pre class="text-white mb-0"><code>&lt;x-datatable.base
    id="colreorder_table"
    cardTitle="Reorderable Columns"
    :colReorder="true"
    :columns="$columns"
    :data="$data"
/&gt;

{{-- Advanced: Fix certain columns in place --}}
&lt;x-datatable.base
    id="colreorder_fixed"
    :colReorder="['fixedColumnsLeft' => 1, 'fixedColumnsRight' => 1]"
    :columns="$columns"
    :data="$data"
/&gt;</code></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end::Section-->

<!--===========================================-->
<!--begin::Section - Highlighting -->
<!--===========================================-->
<div id="highlighting" class="mb-10">
    <h2 class="text-gray-800 fw-bold mb-5">9. Row & Column Highlighting</h2>
    
    <div class="row g-5 g-xl-10">
        <div class="col-md-6">
            <!--begin::Row Highlight-->
            <x-datatable.base
                id="highlight_row_table"
                cardTitle="Row Highlighting"
                highlight="row"
                :paging="false"
                :searching="false"
                :info="false"
                :columns="[
                    ['title' => 'Name', 'data' => 'name'],
                    ['title' => 'Position', 'data' => 'position'],
                    ['title' => 'Office', 'data' => 'office'],
                ]"
                :data="[
                    ['name' => 'Tiger Nixon', 'position' => 'System Architect', 'office' => 'Edinburgh'],
                    ['name' => 'Garrett Winters', 'position' => 'Accountant', 'office' => 'Tokyo'],
                    ['name' => 'Ashton Cox', 'position' => 'Junior Developer', 'office' => 'San Francisco'],
                    ['name' => 'Cedric Kelly', 'position' => 'Senior Developer', 'office' => 'Edinburgh'],
                ]"
            />
            <!--end::Row Highlight-->
        </div>
        
        <div class="col-md-6">
            <!--begin::Column Highlight-->
            <x-datatable.base
                id="highlight_column_table"
                cardTitle="Column Highlighting"
                highlight="column"
                :paging="false"
                :searching="false"
                :info="false"
                :columns="[
                    ['title' => 'Name', 'data' => 'name'],
                    ['title' => 'Position', 'data' => 'position'],
                    ['title' => 'Office', 'data' => 'office'],
                ]"
                :data="[
                    ['name' => 'Tiger Nixon', 'position' => 'System Architect', 'office' => 'Edinburgh'],
                    ['name' => 'Garrett Winters', 'position' => 'Accountant', 'office' => 'Tokyo'],
                    ['name' => 'Ashton Cox', 'position' => 'Junior Developer', 'office' => 'San Francisco'],
                    ['name' => 'Cedric Kelly', 'position' => 'Senior Developer', 'office' => 'Edinburgh'],
                ]"
            />
            <!--end::Column Highlight-->
        </div>
        
        <div class="col-12">
            <!--begin::Row+Column Highlight-->
            <x-datatable.base
                id="highlight_rowcolumn_table"
                cardTitle="Row + Column Highlighting (Cross Pattern)"
                highlight="rowColumn"
                :paging="false"
                :searching="false"
                :info="false"
                :columns="[
                    ['title' => 'ID', 'data' => 'id', 'width' => '60px', 'align' => 'center'],
                    ['title' => 'Name', 'data' => 'name'],
                    ['title' => 'Position', 'data' => 'position'],
                    ['title' => 'Office', 'data' => 'office'],
                    ['title' => 'Salary', 'data' => 'salary', 'align' => 'right'],
                ]"
                :data="[
                    ['id' => 1, 'name' => 'Tiger Nixon', 'position' => 'System Architect', 'office' => 'Edinburgh', 'salary' => '\$320,800'],
                    ['id' => 2, 'name' => 'Garrett Winters', 'position' => 'Accountant', 'office' => 'Tokyo', 'salary' => '\$170,750'],
                    ['id' => 3, 'name' => 'Ashton Cox', 'position' => 'Junior Developer', 'office' => 'San Francisco', 'salary' => '\$86,000'],
                    ['id' => 4, 'name' => 'Cedric Kelly', 'position' => 'Senior Developer', 'office' => 'Edinburgh', 'salary' => '\$433,060'],
                    ['id' => 5, 'name' => 'Airi Satou', 'position' => 'Accountant', 'office' => 'Tokyo', 'salary' => '\$162,700'],
                ]"
            />
            <!--end::Row+Column Highlight-->
        </div>
        
        <div class="col-12">
            <div class="card card-flush">
                <div class="card-header pt-5">
                    <h3 class="card-title">Highlight Options</h3>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive mb-5">
                        <table class="table table-row-bordered gy-4">
                            <thead>
                                <tr class="fw-bold bg-light">
                                    <th class="ps-4">Value</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="ps-4"><code>false</code></td>
                                    <td>No highlighting (default)</td>
                                </tr>
                                <tr>
                                    <td class="ps-4"><code>'row'</code></td>
                                    <td>Highlight entire row on hover</td>
                                </tr>
                                <tr>
                                    <td class="ps-4"><code>'column'</code></td>
                                    <td>Highlight entire column on hover</td>
                                </tr>
                                <tr>
                                    <td class="ps-4"><code>'cell'</code></td>
                                    <td>Highlight only the hovered cell</td>
                                </tr>
                                <tr>
                                    <td class="ps-4"><code>'rowColumn'</code></td>
                                    <td>Highlight both row and column (cross pattern)</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="rounded border p-5 bg-dark">
<pre class="text-white mb-0"><code>&lt;x-datatable.base
    id="highlight_table"
    cardTitle="Highlighted Table"
    highlight="rowColumn"   {{-- 'row', 'column', 'cell', or 'rowColumn' --}}
    :columns="$columns"
    :data="$data"
/&gt;</code></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end::Section-->

<!--===========================================-->
<!--begin::Section - Server Side -->
<!--===========================================-->
<div id="server-side" class="mb-10">
    <h2 class="text-gray-800 fw-bold mb-5">10. Server-Side Processing</h2>
    
    <div class="row g-5 g-xl-10">
        <div class="col-12">
            <div class="card card-flush">
                <div class="card-header pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold text-gray-900">AJAX Server-Side</span>
                        <span class="text-muted mt-1 fw-semibold fs-7">For large datasets with server pagination</span>
                    </h3>
                </div>
                <div class="card-body pt-0">
                    <div class="alert alert-info d-flex align-items-center mb-5">
                        <i class="ki-outline ki-information-4 fs-2hx text-info me-4"></i>
                        <div>
                            <h4 class="mb-1 text-info">Server-Side Example</h4>
                            <span>This example requires a backend route. Below is the implementation code.</span>
                        </div>
                    </div>
                    
                    <div class="rounded border p-5 bg-dark">
<pre class="text-white mb-0"><code>{{-- Blade Component --}}
&lt;x-datatable.base
    id="server_table"
    cardTitle="Server-Side DataTable"
    :ajax="route('users.datatable')"
    :serverSide="true"
    :processing="true"
    :columnSearch="true"
    :colVis="true"
    :columns="[
        ['title' => 'ID', 'data' => 'id', 'width' => '60px'],
        ['title' => 'Name', 'data' => 'name'],
        ['title' => 'Email', 'data' => 'email'],
        ['title' => 'Role', 'data' => 'role', 'searchType' => 'select', 
         'searchOptions' => ['Admin' => 'Admin', 'User' => 'User']],
        ['title' => 'Status', 'data' => 'status'],
        ['title' => 'Created', 'data' => 'created_at', 'searchType' => 'date'],
        ['title' => 'Actions', 'data' => 'actions', 'orderable' => false, 'searchable' => false],
    ]"
/&gt;</code></pre>
                    </div>
                    
                    <h5 class="mt-8 mb-4">Controller Example (using yajra/laravel-datatables)</h5>
                    <div class="rounded border p-5 bg-dark">
<pre class="text-white mb-0"><code>// routes/web.php
Route::get('/users/datatable', [UserController::class, 'datatable'])->name('users.datatable');

// app/Http/Controllers/UserController.php
use Yajra\DataTables\Facades\DataTables;

public function datatable(Request $request)
{
    $query = User::query();
    
    return DataTables::of($query)
        ->addColumn('status', function($user) {
            $class = $user->is_active ? 'success' : 'danger';
            $text = $user->is_active ? 'Active' : 'Inactive';
            return '&lt;span class="badge badge-light-'.$class.'"&gt;'.$text.'&lt;/span&gt;';
        })
        ->addColumn('actions', function($user) {
            return view('users.partials.actions', compact('user'))->render();
        })
        ->rawColumns(['status', 'actions'])
        ->toJson();
}

// Install package: composer require yajra/laravel-datatables-oracle</code></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end::Section-->

<!--===========================================-->
<!--begin::Section - Props Reference -->
<!--===========================================-->
<div id="props-reference" class="mb-10">
    <h2 class="text-gray-800 fw-bold mb-5">11. Props Reference</h2>
    
    <div class="row g-5 g-xl-10">
        <div class="col-12">
            <div class="card card-flush">
                <div class="card-header pt-5">
                    <h3 class="card-title">Component Props</h3>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table table-row-bordered gy-4">
                            <thead>
                                <tr class="fw-bold bg-light">
                                    <th class="ps-4">Prop</th>
                                    <th>Type</th>
                                    <th>Default</th>
                                    <th class="pe-4">Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-light-primary">
                                    <td colspan="4" class="ps-4 fw-bold text-primary">Table Basics</td>
                                </tr>
                                <tr>
                                    <td class="ps-4"><code>id</code></td>
                                    <td><span class="badge badge-light-info">string</span></td>
                                    <td>auto</td>
                                    <td>Unique table identifier</td>
                                </tr>
                                <tr>
                                    <td class="ps-4"><code>class</code></td>
                                    <td><span class="badge badge-light-info">string</span></td>
                                    <td>Metronic default</td>
                                    <td>Table CSS classes</td>
                                </tr>
                                <tr>
                                    <td class="ps-4"><code>columns</code></td>
                                    <td><span class="badge badge-light-danger">array</span></td>
                                    <td>[]</td>
                                    <td>Column definitions</td>
                                </tr>
                                
                                <tr class="bg-light-primary">
                                    <td colspan="4" class="ps-4 fw-bold text-primary">Data Source</td>
                                </tr>
                                <tr>
                                    <td class="ps-4"><code>data</code></td>
                                    <td><span class="badge badge-light-info">array</span></td>
                                    <td>null</td>
                                    <td>Static data array</td>
                                </tr>
                                <tr>
                                    <td class="ps-4"><code>ajax</code></td>
                                    <td><span class="badge badge-light-info">string|object</span></td>
                                    <td>null</td>
                                    <td>AJAX URL or config</td>
                                </tr>
                                <tr>
                                    <td class="ps-4"><code>serverSide</code></td>
                                    <td><span class="badge badge-light-success">bool</span></td>
                                    <td>false</td>
                                    <td>Enable server-side processing</td>
                                </tr>
                                <tr>
                                    <td class="ps-4"><code>processing</code></td>
                                    <td><span class="badge badge-light-success">bool</span></td>
                                    <td>true</td>
                                    <td>Show processing indicator</td>
                                </tr>
                                
                                <tr class="bg-light-primary">
                                    <td colspan="4" class="ps-4 fw-bold text-primary">Pagination</td>
                                </tr>
                                <tr>
                                    <td class="ps-4"><code>paging</code></td>
                                    <td><span class="badge badge-light-success">bool</span></td>
                                    <td>true</td>
                                    <td>Enable pagination</td>
                                </tr>
                                <tr>
                                    <td class="ps-4"><code>pageLength</code></td>
                                    <td><span class="badge badge-light-primary">int</span></td>
                                    <td>10</td>
                                    <td>Rows per page</td>
                                </tr>
                                <tr>
                                    <td class="ps-4"><code>lengthMenu</code></td>
                                    <td><span class="badge badge-light-info">array</span></td>
                                    <td>[10,25,50,100]</td>
                                    <td>Page length options</td>
                                </tr>
                                
                                <tr class="bg-light-primary">
                                    <td colspan="4" class="ps-4 fw-bold text-primary">Features</td>
                                </tr>
                                <tr>
                                    <td class="ps-4"><code>searching</code></td>
                                    <td><span class="badge badge-light-success">bool</span></td>
                                    <td>true</td>
                                    <td>Enable global search</td>
                                </tr>
                                <tr>
                                    <td class="ps-4"><code>ordering</code></td>
                                    <td><span class="badge badge-light-success">bool</span></td>
                                    <td>true</td>
                                    <td>Enable column sorting</td>
                                </tr>
                                <tr>
                                    <td class="ps-4"><code>order</code></td>
                                    <td><span class="badge badge-light-info">array</span></td>
                                    <td>[[0,'asc']]</td>
                                    <td>Default sort order</td>
                                </tr>
                                <tr>
                                    <td class="ps-4"><code>info</code></td>
                                    <td><span class="badge badge-light-success">bool</span></td>
                                    <td>true</td>
                                    <td>Show info text</td>
                                </tr>
                                <tr>
                                    <td class="ps-4"><code>responsive</code></td>
                                    <td><span class="badge badge-light-success">bool</span></td>
                                    <td>true</td>
                                    <td>Enable responsive mode</td>
                                </tr>
                                <tr>
                                    <td class="ps-4"><code>stateSave</code></td>
                                    <td><span class="badge badge-light-success">bool</span></td>
                                    <td>false</td>
                                    <td>Save table state</td>
                                </tr>
                                
                                <tr class="bg-light-primary">
                                    <td colspan="4" class="ps-4 fw-bold text-primary">Scrolling</td>
                                </tr>
                                <tr>
                                    <td class="ps-4"><code>scrollX</code></td>
                                    <td><span class="badge badge-light-success">bool</span></td>
                                    <td>false</td>
                                    <td>Enable horizontal scroll</td>
                                </tr>
                                <tr>
                                    <td class="ps-4"><code>scrollY</code></td>
                                    <td><span class="badge badge-light-info">string</span></td>
                                    <td>null</td>
                                    <td>Fixed header height (e.g., '300px')</td>
                                </tr>
                                
                                <tr class="bg-light-primary">
                                    <td colspan="4" class="ps-4 fw-bold text-primary">Advanced</td>
                                </tr>
                                <tr>
                                    <td class="ps-4"><code>columnSearch</code></td>
                                    <td><span class="badge badge-light-success">bool</span></td>
                                    <td>false</td>
                                    <td>Per-column search inputs</td>
                                </tr>
                                <tr>
                                    <td class="ps-4"><code>colVis</code></td>
                                    <td><span class="badge badge-light-success">bool</span></td>
                                    <td>false</td>
                                    <td>Column visibility toggle</td>
                                </tr>
                                <tr>
                                    <td class="ps-4"><code>showFooter</code></td>
                                    <td><span class="badge badge-light-success">bool</span></td>
                                    <td>false</td>
                                    <td>Show table footer</td>
                                </tr>
                                <tr>
                                    <td class="ps-4"><code>options</code></td>
                                    <td><span class="badge badge-light-info">array</span></td>
                                    <td>[]</td>
                                    <td>Extra DataTable options</td>
                                </tr>
                                
                                <tr class="bg-light-primary">
                                    <td colspan="4" class="ps-4 fw-bold text-primary">Selection & Highlighting</td>
                                </tr>
                                <tr>
                                    <td class="ps-4"><code>select</code></td>
                                    <td><span class="badge badge-light-info">bool|string</span></td>
                                    <td>false</td>
                                    <td>Row selection: false, 'single', 'multi', 'os'</td>
                                </tr>
                                <tr>
                                    <td class="ps-4"><code>highlight</code></td>
                                    <td><span class="badge badge-light-info">bool|string</span></td>
                                    <td>false</td>
                                    <td>Highlight mode: false, 'row', 'column', 'cell', 'rowColumn'</td>
                                </tr>
                                <tr>
                                    <td class="ps-4"><code>colReorder</code></td>
                                    <td><span class="badge badge-light-info">bool|array</span></td>
                                    <td>false</td>
                                    <td>Enable drag & drop column reordering</td>
                                </tr>
                                
                                <tr class="bg-light-primary">
                                    <td colspan="4" class="ps-4 fw-bold text-primary">Card Wrapper</td>
                                </tr>
                                <tr>
                                    <td class="ps-4"><code>showCard</code></td>
                                    <td><span class="badge badge-light-success">bool</span></td>
                                    <td>true</td>
                                    <td>Wrap in card</td>
                                </tr>
                                <tr>
                                    <td class="ps-4"><code>cardTitle</code></td>
                                    <td><span class="badge badge-light-info">string</span></td>
                                    <td>null</td>
                                    <td>Card header title</td>
                                </tr>
                                <tr>
                                    <td class="ps-4"><code>cardToolbar</code></td>
                                    <td><span class="badge badge-light-info">slot</span></td>
                                    <td>null</td>
                                    <td>Custom toolbar content</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-12">
            <div class="card card-flush">
                <div class="card-header pt-5">
                    <h3 class="card-title">Column Definition Options</h3>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table table-row-bordered gy-4">
                            <thead>
                                <tr class="fw-bold bg-light">
                                    <th class="ps-4">Property</th>
                                    <th>Type</th>
                                    <th class="pe-4">Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="ps-4"><code>title</code></td>
                                    <td><span class="badge badge-light-info">string</span></td>
                                    <td>Column header text</td>
                                </tr>
                                <tr>
                                    <td class="ps-4"><code>data</code></td>
                                    <td><span class="badge badge-light-info">string</span></td>
                                    <td>Data property/key name</td>
                                </tr>
                                <tr>
                                    <td class="ps-4"><code>width</code></td>
                                    <td><span class="badge badge-light-info">string</span></td>
                                    <td>Column width (e.g., '100px', '20%')</td>
                                </tr>
                                <tr>
                                    <td class="ps-4"><code>align</code></td>
                                    <td><span class="badge badge-light-info">string</span></td>
                                    <td>Alignment: 'left', 'center', 'right'</td>
                                </tr>
                                <tr>
                                    <td class="ps-4"><code>orderable</code></td>
                                    <td><span class="badge badge-light-success">bool</span></td>
                                    <td>Enable sorting (default: true)</td>
                                </tr>
                                <tr>
                                    <td class="ps-4"><code>searchable</code></td>
                                    <td><span class="badge badge-light-success">bool</span></td>
                                    <td>Enable searching (default: true)</td>
                                </tr>
                                <tr>
                                    <td class="ps-4"><code>searchType</code></td>
                                    <td><span class="badge badge-light-info">string</span></td>
                                    <td>'text', 'select', 'number', 'date'</td>
                                </tr>
                                <tr>
                                    <td class="ps-4"><code>searchOptions</code></td>
                                    <td><span class="badge badge-light-info">array</span></td>
                                    <td>Options for select searchType</td>
                                </tr>
                                <tr>
                                    <td class="ps-4"><code>className</code></td>
                                    <td><span class="badge badge-light-info">string</span></td>
                                    <td>Custom CSS class for column</td>
                                </tr>
                                <tr>
                                    <td class="ps-4"><code>render</code></td>
                                    <td><span class="badge badge-light-info">string</span></td>
                                    <td>JS render function name</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end::Section-->

@endsection
