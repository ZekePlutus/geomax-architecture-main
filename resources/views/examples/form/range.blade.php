@extends('layout50.master')

@section('title', 'Range Components')

@section('content')
<!--begin::Row-->
<div class="row g-5 g-xl-10">
    <!--begin::Col-->
    <div class="col-12">
        <!--begin::Card-->
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header border-0 pt-6">
                <div class="card-title">
                    <a href="{{ route('examples') }}" class="btn btn-sm btn-icon btn-light-primary me-3">
                        <i class="ki-outline ki-arrow-left fs-2"></i>
                    </a>
                    <h2>Range Components</h2>
                </div>
                <div class="card-toolbar">
                    <a href="https://preview.keenthemes.com/html/metronic/docs/?page=base/forms/controls" target="_blank" class="btn btn-sm btn-light-primary">
                        <i class="ki-outline ki-document fs-4 me-1"></i>
                        Metronic Docs
                    </a>
                </div>
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0">
                <p class="text-muted fs-6">
                    Range slider component with value display, min/max labels, and tick marks.
                    Compatible with Metronic's form-range styles.
                </p>
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
    <!--end::Col-->
</div>
<!--end::Row-->

<!--begin::Row - Basic Range -->
<div class="row g-5 g-xl-10 mt-5">
    <div class="col-12">
        <!--begin::Card-->
        <div class="card card-flush">
            <!--begin::Card header-->
            <div class="card-header pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-900">Basic Range</span>
                    <span class="text-muted mt-1 fw-semibold fs-7">Simple range slider with label</span>
                </h3>
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-5">
                <div class="row">
                    <div class="col-lg-6">
                        <!--begin::Preview-->
                        <div class="rounded border p-5 mb-5">
                            <x-form.range.base 
                                label="Volume" 
                                name="basic_volume" 
                            />
                        </div>
                        <!--end::Preview-->
                    </div>
                    <div class="col-lg-6">
                        <!--begin::Code-->
                        <div class="rounded border p-5 bg-dark h-100">
<pre class="text-white mb-0"><code>&lt;x-form.range.base 
    label="Volume" 
    name="basic_volume" 
/&gt;</code></pre>
                        </div>
                        <!--end::Code-->
                    </div>
                </div>
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
</div>
<!--end::Row-->

<!--begin::Row - With Value Display -->
<div class="row g-5 g-xl-10 mt-5">
    <div class="col-12">
        <!--begin::Card-->
        <div class="card card-flush">
            <!--begin::Card header-->
            <div class="card-header pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-900">Value Display</span>
                    <span class="text-muted mt-1 fw-semibold fs-7">Show current value with different positions</span>
                </h3>
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-5">
                <div class="row">
                    <div class="col-lg-6">
                        <!--begin::Preview-->
                        <div class="rounded border p-5 mb-5">
                            <x-form.range.base 
                                label="Value at End" 
                                name="value_end" 
                                :showValue="true"
                                valuePosition="end"
                                value="50"
                            />
                            
                            <x-form.range.base 
                                label="Value at Start" 
                                name="value_start" 
                                :showValue="true"
                                valuePosition="start"
                                value="75"
                            />
                            
                            <x-form.range.base 
                                label="Value at Top (Badge)" 
                                name="value_top" 
                                :showValue="true"
                                valuePosition="top"
                                value="30"
                            />
                        </div>
                        <!--end::Preview-->
                    </div>
                    <div class="col-lg-6">
                        <!--begin::Code-->
                        <div class="rounded border p-5 bg-dark h-100">
<pre class="text-white mb-0"><code>{{-- Value at End --}}
&lt;x-form.range.base 
    label="Value at End" 
    name="value_end" 
    :showValue="true"
    valuePosition="end"
    value="50"
/&gt;

{{-- Value at Start --}}
&lt;x-form.range.base 
    label="Value at Start" 
    name="value_start" 
    :showValue="true"
    valuePosition="start"
    value="75"
/&gt;

{{-- Value at Top --}}
&lt;x-form.range.base 
    label="Value at Top (Badge)" 
    name="value_top" 
    :showValue="true"
    valuePosition="top"
    value="30"
/&gt;</code></pre>
                        </div>
                        <!--end::Code-->
                    </div>
                </div>
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
</div>
<!--end::Row-->

<!--begin::Row - Prefix & Suffix -->
<div class="row g-5 g-xl-10 mt-5">
    <div class="col-12">
        <!--begin::Card-->
        <div class="card card-flush">
            <!--begin::Card header-->
            <div class="card-header pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-900">Prefix & Suffix</span>
                    <span class="text-muted mt-1 fw-semibold fs-7">Add units or symbols to the displayed value</span>
                </h3>
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-5">
                <div class="row">
                    <div class="col-lg-6">
                        <!--begin::Preview-->
                        <div class="rounded border p-5 mb-5">
                            <x-form.range.base 
                                label="Brightness" 
                                name="brightness" 
                                :showValue="true"
                                suffix="%"
                                value="80"
                            />
                            
                            <x-form.range.base 
                                label="Price Range" 
                                name="price" 
                                :showValue="true"
                                prefix="$"
                                min="10"
                                max="500"
                                step="10"
                                value="150"
                            />
                            
                            <x-form.range.base 
                                label="Font Size" 
                                name="font_size" 
                                :showValue="true"
                                suffix="px"
                                min="8"
                                max="72"
                                step="2"
                                value="16"
                            />
                        </div>
                        <!--end::Preview-->
                    </div>
                    <div class="col-lg-6">
                        <!--begin::Code-->
                        <div class="rounded border p-5 bg-dark h-100">
<pre class="text-white mb-0"><code>{{-- Percentage --}}
&lt;x-form.range.base 
    label="Brightness" 
    name="brightness" 
    :showValue="true"
    suffix="%"
    value="80"
/&gt;

{{-- Currency --}}
&lt;x-form.range.base 
    label="Price Range" 
    name="price" 
    :showValue="true"
    prefix="$"
    min="10"
    max="500"
    step="10"
    value="150"
/&gt;

{{-- Pixels --}}
&lt;x-form.range.base 
    label="Font Size" 
    name="font_size" 
    :showValue="true"
    suffix="px"
    min="8"
    max="72"
    step="2"
    value="16"
/&gt;</code></pre>
                        </div>
                        <!--end::Code-->
                    </div>
                </div>
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
</div>
<!--end::Row-->

<!--begin::Row - Min/Max & Ticks -->
<div class="row g-5 g-xl-10 mt-5">
    <div class="col-12">
        <!--begin::Card-->
        <div class="card card-flush">
            <!--begin::Card header-->
            <div class="card-header pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-900">Min/Max Labels & Tick Marks</span>
                    <span class="text-muted mt-1 fw-semibold fs-7">Visual indicators for range boundaries and steps</span>
                </h3>
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-5">
                <div class="row">
                    <div class="col-lg-6">
                        <!--begin::Preview-->
                        <div class="rounded border p-5 mb-5">
                            <x-form.range.base 
                                label="With Min/Max Labels" 
                                name="minmax" 
                                :showMinMax="true"
                                min="0"
                                max="100"
                                suffix="%"
                                value="50"
                            />
                            
                            <x-form.range.base 
                                label="Rating with Ticks" 
                                name="rating" 
                                :showValue="true"
                                :showTicks="true"
                                min="1"
                                max="5"
                                step="1"
                                value="3"
                            />
                            
                            <x-form.range.base 
                                label="Combined: Ticks + Min/Max + Value" 
                                name="combined" 
                                :showValue="true"
                                :showTicks="true"
                                :showMinMax="true"
                                min="0"
                                max="10"
                                step="1"
                                value="7"
                            />
                        </div>
                        <!--end::Preview-->
                    </div>
                    <div class="col-lg-6">
                        <!--begin::Code-->
                        <div class="rounded border p-5 bg-dark h-100">
<pre class="text-white mb-0"><code>{{-- Min/Max Labels --}}
&lt;x-form.range.base 
    label="With Min/Max Labels" 
    name="minmax" 
    :showMinMax="true"
    min="0"
    max="100"
    suffix="%"
    value="50"
/&gt;

{{-- Tick Marks --}}
&lt;x-form.range.base 
    label="Rating with Ticks" 
    name="rating" 
    :showValue="true"
    :showTicks="true"
    min="1"
    max="5"
    step="1"
    value="3"
/&gt;

{{-- Combined --}}
&lt;x-form.range.base 
    label="Combined" 
    name="combined" 
    :showValue="true"
    :showTicks="true"
    :showMinMax="true"
    min="0"
    max="10"
    step="1"
    value="7"
/&gt;</code></pre>
                        </div>
                        <!--end::Code-->
                    </div>
                </div>
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
</div>
<!--end::Row-->

<!--begin::Row - States -->
<div class="row g-5 g-xl-10 mt-5">
    <div class="col-12">
        <!--begin::Card-->
        <div class="card card-flush">
            <!--begin::Card header-->
            <div class="card-header pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-900">States</span>
                    <span class="text-muted mt-1 fw-semibold fs-7">Disabled state and validation error</span>
                </h3>
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-5">
                <div class="row">
                    <div class="col-lg-6">
                        <!--begin::Preview-->
                        <div class="rounded border p-5 mb-5">
                            <x-form.range.base 
                                label="Disabled Range" 
                                name="disabled_range" 
                                :disabled="true"
                                :showValue="true"
                                value="60"
                            />
                            
                            <x-form.range.base 
                                label="With Error" 
                                name="error_range" 
                                :showValue="true"
                                value="10"
                                error="Value must be at least 25"
                            />
                        </div>
                        <!--end::Preview-->
                    </div>
                    <div class="col-lg-6">
                        <!--begin::Code-->
                        <div class="rounded border p-5 bg-dark h-100">
<pre class="text-white mb-0"><code>{{-- Disabled --}}
&lt;x-form.range.base 
    label="Disabled Range" 
    name="disabled_range" 
    :disabled="true"
    :showValue="true"
    value="60"
/&gt;

{{-- With Error --}}
&lt;x-form.range.base 
    label="With Error" 
    name="error_range" 
    :showValue="true"
    value="10"
    error="Value must be at least 25"
/&gt;</code></pre>
                        </div>
                        <!--end::Code-->
                    </div>
                </div>
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
</div>
<!--end::Row-->

<!--begin::Row - Help Text -->
<div class="row g-5 g-xl-10 mt-5">
    <div class="col-12">
        <!--begin::Card-->
        <div class="card card-flush">
            <!--begin::Card header-->
            <div class="card-header pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-900">Hint & Tooltip</span>
                    <span class="text-muted mt-1 fw-semibold fs-7">Additional help text and information tooltips</span>
                </h3>
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-5">
                <div class="row">
                    <div class="col-lg-6">
                        <!--begin::Preview-->
                        <div class="rounded border p-5 mb-5">
                            <x-form.range.base 
                                label="With Hint" 
                                name="hint_range" 
                                :showValue="true"
                                suffix="%"
                                value="50"
                                hint="Adjust the quality level. Higher values produce better results but larger file sizes."
                            />
                            
                            <x-form.range.base 
                                label="With Tooltip" 
                                name="tooltip_range" 
                                :showValue="true"
                                value="75"
                                tooltip="This setting controls the compression ratio"
                            />
                        </div>
                        <!--end::Preview-->
                    </div>
                    <div class="col-lg-6">
                        <!--begin::Code-->
                        <div class="rounded border p-5 bg-dark h-100">
<pre class="text-white mb-0"><code>{{-- With Hint --}}
&lt;x-form.range.base 
    label="With Hint" 
    name="hint_range" 
    :showValue="true"
    suffix="%"
    value="50"
    hint="Adjust the quality level..."
/&gt;

{{-- With Tooltip --}}
&lt;x-form.range.base 
    label="With Tooltip" 
    name="tooltip_range" 
    :showValue="true"
    value="75"
    tooltip="This setting controls..."
/&gt;</code></pre>
                        </div>
                        <!--end::Code-->
                    </div>
                </div>
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
</div>
<!--end::Row-->

<!--begin::Row - Props Reference -->
<div class="row g-5 g-xl-10 mt-5 mb-10">
    <div class="col-12">
        <!--begin::Card-->
        <div class="card card-flush">
            <!--begin::Card header-->
            <div class="card-header pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-900">Props Reference</span>
                    <span class="text-muted mt-1 fw-semibold fs-7">All available component properties</span>
                </h3>
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-5">
                <div class="table-responsive">
                    <table class="table table-row-bordered table-row-gray-200 align-middle gs-0 gy-4">
                        <thead>
                            <tr class="fw-bold text-muted bg-light">
                                <th class="ps-4 rounded-start">Prop</th>
                                <th>Type</th>
                                <th>Default</th>
                                <th class="pe-4 rounded-end">Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="ps-4"><code>name</code></td>
                                <td><span class="badge badge-light-danger">string</span></td>
                                <td>—</td>
                                <td>Input name attribute (required)</td>
                            </tr>
                            <tr>
                                <td class="ps-4"><code>id</code></td>
                                <td><span class="badge badge-light">string</span></td>
                                <td>auto</td>
                                <td>Input ID (auto-generated from name)</td>
                            </tr>
                            <tr>
                                <td class="ps-4"><code>label</code></td>
                                <td><span class="badge badge-light">string</span></td>
                                <td>null</td>
                                <td>Label text</td>
                            </tr>
                            <tr>
                                <td class="ps-4"><code>value</code></td>
                                <td><span class="badge badge-light">number</span></td>
                                <td>min</td>
                                <td>Initial value</td>
                            </tr>
                            <tr>
                                <td class="ps-4"><code>min</code></td>
                                <td><span class="badge badge-light">number</span></td>
                                <td>0</td>
                                <td>Minimum value</td>
                            </tr>
                            <tr>
                                <td class="ps-4"><code>max</code></td>
                                <td><span class="badge badge-light">number</span></td>
                                <td>100</td>
                                <td>Maximum value</td>
                            </tr>
                            <tr>
                                <td class="ps-4"><code>step</code></td>
                                <td><span class="badge badge-light">number</span></td>
                                <td>1</td>
                                <td>Step increment</td>
                            </tr>
                            <tr>
                                <td class="ps-4"><code>showValue</code></td>
                                <td><span class="badge badge-light-primary">bool</span></td>
                                <td>false</td>
                                <td>Display current value</td>
                            </tr>
                            <tr>
                                <td class="ps-4"><code>valuePosition</code></td>
                                <td><span class="badge badge-light">string</span></td>
                                <td>end</td>
                                <td>Value position: start, end, top</td>
                            </tr>
                            <tr>
                                <td class="ps-4"><code>prefix</code></td>
                                <td><span class="badge badge-light">string</span></td>
                                <td>""</td>
                                <td>Value prefix (e.g., "$")</td>
                            </tr>
                            <tr>
                                <td class="ps-4"><code>suffix</code></td>
                                <td><span class="badge badge-light">string</span></td>
                                <td>""</td>
                                <td>Value suffix (e.g., "%", "px")</td>
                            </tr>
                            <tr>
                                <td class="ps-4"><code>showMinMax</code></td>
                                <td><span class="badge badge-light-primary">bool</span></td>
                                <td>false</td>
                                <td>Show min/max labels</td>
                            </tr>
                            <tr>
                                <td class="ps-4"><code>showTicks</code></td>
                                <td><span class="badge badge-light-primary">bool</span></td>
                                <td>false</td>
                                <td>Show tick marks (max 20)</td>
                            </tr>
                            <tr>
                                <td class="ps-4"><code>hint</code></td>
                                <td><span class="badge badge-light">string</span></td>
                                <td>null</td>
                                <td>Help text below input</td>
                            </tr>
                            <tr>
                                <td class="ps-4"><code>tooltip</code></td>
                                <td><span class="badge badge-light">string</span></td>
                                <td>null</td>
                                <td>Tooltip text for label</td>
                            </tr>
                            <tr>
                                <td class="ps-4"><code>disabled</code></td>
                                <td><span class="badge badge-light-primary">bool</span></td>
                                <td>false</td>
                                <td>Disable the input</td>
                            </tr>
                            <tr>
                                <td class="ps-4"><code>required</code></td>
                                <td><span class="badge badge-light-primary">bool</span></td>
                                <td>false</td>
                                <td>Mark as required</td>
                            </tr>
                            <tr>
                                <td class="ps-4"><code>error</code></td>
                                <td><span class="badge badge-light">string</span></td>
                                <td>null</td>
                                <td>Manual error message</td>
                            </tr>
                            <tr>
                                <td class="ps-4"><code>errorBag</code></td>
                                <td><span class="badge badge-light">string</span></td>
                                <td>default</td>
                                <td>Laravel error bag name</td>
                            </tr>
                            <tr>
                                <td class="ps-4"><code>wrapperClass</code></td>
                                <td><span class="badge badge-light">string</span></td>
                                <td>""</td>
                                <td>Additional wrapper classes</td>
                            </tr>
                            <tr>
                                <td class="ps-4"><code>inputClass</code></td>
                                <td><span class="badge badge-light">string</span></td>
                                <td>""</td>
                                <td>Additional input classes</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
</div>
<!--end::Row-->
@endsection
