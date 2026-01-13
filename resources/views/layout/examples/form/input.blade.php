@extends('layout.master')

@section('title', 'Input Components')

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
                    <h2>Input Components</h2>
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
                    Form input component with multiple variants, sizes, and features. 
                    Compatible with Metronic's form control styles.
                </p>
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
    <!--end::Col-->
</div>
<!--end::Row-->

<!--begin::Row - Basic Input -->
<div class="row g-5 g-xl-10 mt-5">
    <div class="col-12">
        <!--begin::Card-->
        <div class="card card-flush">
            <!--begin::Card header-->
            <div class="card-header pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-900">Basic Input</span>
                    <span class="text-muted mt-1 fw-semibold fs-7">Simple text input with label</span>
                </h3>
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-5">
                <div class="row">
                    <div class="col-lg-6">
                        <!--begin::Preview-->
                        <div class="rounded border p-5 mb-5 bg-light-dark">
                            <x-form.input.base 
                                label="Full Name" 
                                name="basic_name" 
                                placeholder="Enter your name"
                            />
                        </div>
                        <!--end::Preview-->
                    </div>
                    <div class="col-lg-6">
                        <!--begin::Code-->
                        <div class="rounded border p-5 bg-dark h-100">
<pre class="text-white mb-0"><code>&lt;x-form.input.base 
    label="Full Name" 
    name="basic_name" 
    placeholder="Enter your name"
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

<!--begin::Row - Variants -->
<div class="row g-5 g-xl-10 mt-5">
    <div class="col-12">
        <!--begin::Card-->
        <div class="card card-flush">
            <!--begin::Card header-->
            <div class="card-header pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-900">Style Variants</span>
                    <span class="text-muted mt-1 fw-semibold fs-7">Different background styles: default, solid, transparent, flush</span>
                </h3>
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-5">
                <div class="row">
                    <div class="col-lg-6">
                        <!--begin::Preview-->
                        <div class="rounded border p-5 mb-5 bg-light-dark">
                            <x-form.input.base 
                                label="Default Style" 
                                name="var_default" 
                                placeholder="Default background"
                            />
                            
                            <x-form.input.base 
                                label="Solid Style" 
                                name="var_solid" 
                                placeholder="Solid background"
                                variant="solid"
                            />

                            <x-form.input.base 
                                label="Transparent Style" 
                                name="var_transparent" 
                                placeholder="Transparent background"
                                variant="transparent"
                            />

                            <x-form.input.base 
                                label="Flush Style" 
                                name="var_flush" 
                                placeholder="No borders or background"
                                variant="flush"
                            />
                        </div>
                        <!--end::Preview-->
                    </div>
                    <div class="col-lg-6">
                        <!--begin::Code-->
                        <div class="rounded border p-5 bg-dark h-100">
<pre class="text-white mb-0"><code>{{-- Default --}}
&lt;x-form.input.base 
    label="Default Style" 
    name="var_default" 
    placeholder="Default background"
/&gt;

{{-- Solid --}}
&lt;x-form.input.base 
    label="Solid Style" 
    name="var_solid" 
    placeholder="Solid background"
    variant="solid"
/&gt;

{{-- Transparent --}}
&lt;x-form.input.base 
    label="Transparent Style" 
    name="var_transparent" 
    variant="transparent"
/&gt;

{{-- Flush --}}
&lt;x-form.input.base 
    label="Flush Style" 
    name="var_flush" 
    variant="flush"
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

<!--begin::Row - Sizes -->
<div class="row g-5 g-xl-10 mt-5">
    <div class="col-12">
        <!--begin::Card-->
        <div class="card card-flush">
            <!--begin::Card header-->
            <div class="card-header pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-900">Sizes</span>
                    <span class="text-muted mt-1 fw-semibold fs-7">Small, default, and large input sizes</span>
                </h3>
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-5">
                <div class="row">
                    <div class="col-lg-6">
                        <!--begin::Preview-->
                        <div class="rounded border p-5 mb-5 bg-light-dark">
                            <x-form.input.base 
                                label="Small Input" 
                                name="size_sm" 
                                placeholder="Small size"
                                size="sm"
                                variant="solid"
                            />
                            
                            <x-form.input.base 
                                label="Default Input" 
                                name="size_default" 
                                placeholder="Default size"
                                variant="solid"
                            />

                            <x-form.input.base 
                                label="Large Input" 
                                name="size_lg" 
                                placeholder="Large size"
                                size="lg"
                                variant="solid"
                            />
                        </div>
                        <!--end::Preview-->
                    </div>
                    <div class="col-lg-6">
                        <!--begin::Code-->
                        <div class="rounded border p-5 bg-dark h-100">
<pre class="text-white mb-0"><code>{{-- Small --}}
&lt;x-form.input.base 
    label="Small Input" 
    name="size_sm" 
    size="sm"
    variant="solid"
/&gt;

{{-- Default --}}
&lt;x-form.input.base 
    label="Default Input" 
    name="size_default" 
    variant="solid"
/&gt;

{{-- Large --}}
&lt;x-form.input.base 
    label="Large Input" 
    name="size_lg" 
    size="lg"
    variant="solid"
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

<!--begin::Row - Input Types -->
<div class="row g-5 g-xl-10 mt-5">
    <div class="col-12">
        <!--begin::Card-->
        <div class="card card-flush">
            <!--begin::Card header-->
            <div class="card-header pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-900">Input Types</span>
                    <span class="text-muted mt-1 fw-semibold fs-7">Text, email, password, number, date, etc.</span>
                </h3>
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-5">
                <div class="row">
                    <div class="col-lg-6">
                        <!--begin::Preview-->
                        <div class="rounded border p-5 mb-5 bg-light-dark">
                            <x-form.input.base 
                                label="Email" 
                                name="type_email" 
                                type="email"
                                placeholder="name@example.com"
                                variant="solid"
                            />
                            
                            <x-form.input.base 
                                label="Password" 
                                name="type_password" 
                                type="password"
                                placeholder="Enter password"
                                variant="solid"
                            />

                            <x-form.input.base 
                                label="Number" 
                                name="type_number" 
                                type="number"
                                placeholder="0"
                                variant="solid"
                            />

                            <x-form.input.base 
                                label="Date" 
                                name="type_date" 
                                type="date"
                                variant="solid"
                            />
                        </div>
                        <!--end::Preview-->
                    </div>
                    <div class="col-lg-6">
                        <!--begin::Code-->
                        <div class="rounded border p-5 bg-dark h-100">
<pre class="text-white mb-0"><code>{{-- Email --}}
&lt;x-form.input.base 
    label="Email" 
    name="type_email" 
    type="email"
    placeholder="name@example.com"
    variant="solid"
/&gt;

{{-- Password --}}
&lt;x-form.input.base 
    label="Password" 
    name="type_password" 
    type="password"
    variant="solid"
/&gt;

{{-- Number --}}
&lt;x-form.input.base 
    label="Number" 
    name="type_number" 
    type="number"
    variant="solid"
/&gt;

{{-- Date --}}
&lt;x-form.input.base 
    label="Date" 
    name="type_date" 
    type="date"
    variant="solid"
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

<!--begin::Row - With Icons -->
<div class="row g-5 g-xl-10 mt-5">
    <div class="col-12">
        <!--begin::Card-->
        <div class="card card-flush">
            <!--begin::Card header-->
            <div class="card-header pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-900">With Icons</span>
                    <span class="text-muted mt-1 fw-semibold fs-7">Input group with icons at start or end</span>
                </h3>
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-5">
                <div class="row">
                    <div class="col-lg-6">
                        <!--begin::Preview-->
                        <div class="rounded border p-5 mb-5 bg-light-dark">
                            <x-form.input.base 
                                label="User Icon (Start)" 
                                name="icon_start" 
                                placeholder="Username"
                                icon="ki-outline ki-user"
                                variant="solid"
                            />
                            
                            <x-form.input.base 
                                label="Email Icon (End)" 
                                name="icon_end" 
                                type="email"
                                placeholder="name@example.com"
                                icon="ki-outline ki-sms"
                                iconPosition="end"
                                variant="solid"
                            />

                            <x-form.input.base 
                                label="Search Icon" 
                                name="icon_search" 
                                placeholder="Search..."
                                icon="ki-outline ki-magnifier"
                                variant="solid"
                            />
                        </div>
                        <!--end::Preview-->
                    </div>
                    <div class="col-lg-6">
                        <!--begin::Code-->
                        <div class="rounded border p-5 bg-dark h-100">
<pre class="text-white mb-0"><code>{{-- Icon at start --}}
&lt;x-form.input.base 
    label="User Icon" 
    name="icon_start" 
    placeholder="Username"
    icon="ki-outline ki-user"
    variant="solid"
/&gt;

{{-- Icon at end --}}
&lt;x-form.input.base 
    label="Email Icon" 
    name="icon_end" 
    type="email"
    icon="ki-outline ki-sms"
    iconPosition="end"
    variant="solid"
/&gt;

{{-- Search icon --}}
&lt;x-form.input.base 
    label="Search" 
    name="icon_search" 
    icon="ki-outline ki-magnifier"
    variant="solid"
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

<!--begin::Row - Prepend/Append -->
<div class="row g-5 g-xl-10 mt-5">
    <div class="col-12">
        <!--begin::Card-->
        <div class="card card-flush">
            <!--begin::Card header-->
            <div class="card-header pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-900">Prepend & Append</span>
                    <span class="text-muted mt-1 fw-semibold fs-7">Input group with text addons</span>
                </h3>
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-5">
                <div class="row">
                    <div class="col-lg-6">
                        <!--begin::Preview-->
                        <div class="rounded border p-5 mb-5 bg-light-dark">
                            <x-form.input.base 
                                label="Username" 
                                name="prepend_at" 
                                placeholder="username"
                                prepend="@"
                                variant="solid"
                            />
                            
                            <x-form.input.base 
                                label="Email Domain" 
                                name="append_domain" 
                                placeholder="recipient"
                                append="@example.com"
                                variant="solid"
                            />

                            <x-form.input.base 
                                label="Price" 
                                name="prepend_append" 
                                placeholder="0"
                                type="number"
                                prepend="$"
                                append=".00"
                                variant="solid"
                            />

                            <x-form.input.base 
                                label="Website URL" 
                                name="prepend_url" 
                                placeholder="yoursite"
                                prepend="https://"
                                append=".com"
                                variant="solid"
                            />
                        </div>
                        <!--end::Preview-->
                    </div>
                    <div class="col-lg-6">
                        <!--begin::Code-->
                        <div class="rounded border p-5 bg-dark h-100">
<pre class="text-white mb-0"><code>{{-- Prepend @ --}}
&lt;x-form.input.base 
    label="Username" 
    name="prepend_at" 
    prepend="@"
    variant="solid"
/&gt;

{{-- Append domain --}}
&lt;x-form.input.base 
    label="Email Domain" 
    name="append_domain" 
    append="@example.com"
    variant="solid"
/&gt;

{{-- Both prepend & append --}}
&lt;x-form.input.base 
    label="Price" 
    name="prepend_append" 
    type="number"
    prepend="$"
    append=".00"
    variant="solid"
/&gt;

{{-- URL format --}}
&lt;x-form.input.base 
    label="Website URL" 
    name="prepend_url" 
    prepend="https://"
    append=".com"
    variant="solid"
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

<!--begin::Row - Tooltip -->
<div class="row g-5 g-xl-10 mt-5">
    <div class="col-12">
        <!--begin::Card-->
        <div class="card card-flush">
            <!--begin::Card header-->
            <div class="card-header pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-900">With Tooltip</span>
                    <span class="text-muted mt-1 fw-semibold fs-7">Help icon with tooltip next to label</span>
                </h3>
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-5">
                <div class="row">
                    <div class="col-lg-6">
                        <!--begin::Preview-->
                        <div class="rounded border p-5 mb-5 bg-light-dark">
                            <x-form.input.base 
                                label="Email Address" 
                                name="tooltip_email" 
                                type="email"
                                placeholder="name@example.com"
                                tooltip="We'll never share your email with anyone else"
                                variant="solid"
                            />
                            
                            <x-form.input.base 
                                label="API Key" 
                                name="tooltip_api" 
                                placeholder="Enter your API key"
                                tooltip="You can find your API key in the settings page"
                                :required="true"
                                variant="solid"
                            />
                        </div>
                        <!--end::Preview-->
                    </div>
                    <div class="col-lg-6">
                        <!--begin::Code-->
                        <div class="rounded border p-5 bg-dark h-100">
<pre class="text-white mb-0"><code>&lt;x-form.input.base 
    label="Email Address" 
    name="tooltip_email" 
    type="email"
    tooltip="We'll never share your email"
    variant="solid"
/&gt;

&lt;x-form.input.base 
    label="API Key" 
    name="tooltip_api" 
    tooltip="Find your API key in settings"
    :required="true"
    variant="solid"
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

<!--begin::Row - Input Masks -->
<div class="row g-5 g-xl-10 mt-5">
    <div class="col-12">
        <!--begin::Card-->
        <div class="card card-flush">
            <!--begin::Card header-->
            <div class="card-header pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-900">Input Masks</span>
                    <span class="text-muted mt-1 fw-semibold fs-7">Format input with jQuery Mask Plugin</span>
                </h3>
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-5">
                <div class="row">
                    <div class="col-lg-6">
                        <!--begin::Preview-->
                        <div class="rounded border p-5 mb-5 bg-light-dark">
                            <x-form.input.base 
                                label="Phone (BR)" 
                                name="mask_phone" 
                                placeholder="(00) 00000-0000"
                                mask="(00) 00000-0000"
                                inputmode="tel"
                                variant="solid"
                            />
                            
                            <x-form.input.base 
                                label="CPF" 
                                name="mask_cpf" 
                                placeholder="000.000.000-00"
                                mask="000.000.000-00"
                                inputmode="numeric"
                                variant="solid"
                            />

                            <x-form.input.base 
                                label="CNPJ" 
                                name="mask_cnpj" 
                                placeholder="00.000.000/0000-00"
                                mask="00.000.000/0000-00"
                                inputmode="numeric"
                                variant="solid"
                            />

                            <x-form.input.base 
                                label="Credit Card" 
                                name="mask_card" 
                                placeholder="0000 0000 0000 0000"
                                mask="0000 0000 0000 0000"
                                inputmode="numeric"
                                variant="solid"
                            />

                            <x-form.input.base 
                                label="Date" 
                                name="mask_date" 
                                placeholder="00/00/0000"
                                mask="00/00/0000"
                                inputmode="numeric"
                                variant="solid"
                            />

                            <x-form.input.base 
                                label="CEP" 
                                name="mask_cep" 
                                placeholder="00000-000"
                                mask="00000-000"
                                inputmode="numeric"
                                variant="solid"
                            />
                        </div>
                        <!--end::Preview-->
                    </div>
                    <div class="col-lg-6">
                        <!--begin::Code-->
                        <div class="rounded border p-5 bg-dark h-100">
<pre class="text-white mb-0"><code>{{-- Phone --}}
&lt;x-form.input.base 
    label="Phone (BR)" 
    name="mask_phone" 
    mask="(00) 00000-0000"
    inputmode="tel"
    variant="solid"
/&gt;

{{-- CPF --}}
&lt;x-form.input.base 
    label="CPF" 
    name="mask_cpf" 
    mask="000.000.000-00"
    inputmode="numeric"
    variant="solid"
/&gt;

{{-- CNPJ --}}
&lt;x-form.input.base 
    label="CNPJ" 
    name="mask_cnpj" 
    mask="00.000.000/0000-00"
    variant="solid"
/&gt;

{{-- Credit Card --}}
&lt;x-form.input.base 
    label="Credit Card" 
    name="mask_card" 
    mask="0000 0000 0000 0000"
    variant="solid"
/&gt;

{{-- Date --}}
&lt;x-form.input.base 
    label="Date" 
    name="mask_date" 
    mask="00/00/0000"
    variant="solid"
/&gt;

{{-- CEP --}}
&lt;x-form.input.base 
    label="CEP" 
    name="mask_cep" 
    mask="00000-000"
    variant="solid"
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

<!--begin::Row - HTML5 Constraints -->
<div class="row g-5 g-xl-10 mt-5">
    <div class="col-12">
        <!--begin::Card-->
        <div class="card card-flush">
            <!--begin::Card header-->
            <div class="card-header pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-900">HTML5 Constraints</span>
                    <span class="text-muted mt-1 fw-semibold fs-7">Native browser validation with min, max, pattern, etc.</span>
                </h3>
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-5">
                <div class="row">
                    <div class="col-lg-6">
                        <!--begin::Preview-->
                        <div class="rounded border p-5 mb-5 bg-light-dark">
                            <x-form.input.base 
                                label="Age (18-100)" 
                                name="constraint_age" 
                                type="number"
                                placeholder="Enter your age"
                                :min="18"
                                :max="100"
                                inputmode="numeric"
                                variant="solid"
                            />
                            
                            <x-form.input.base 
                                label="Quantity (step: 5)" 
                                name="constraint_qty" 
                                type="number"
                                placeholder="0"
                                :min="0"
                                :max="100"
                                :step="5"
                                variant="solid"
                            />

                            <x-form.input.base 
                                label="Username (3-20 chars)" 
                                name="constraint_username" 
                                placeholder="Enter username"
                                :minlength="3"
                                :maxlength="20"
                                hint="Between 3 and 20 characters"
                                variant="solid"
                            />

                            <x-form.input.base 
                                label="Hex Color Code" 
                                name="constraint_hex" 
                                placeholder="#000000"
                                pattern="^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$"
                                hint="Format: #RGB or #RRGGBB"
                                variant="solid"
                            />

                            <x-form.input.base 
                                label="Price" 
                                name="constraint_price" 
                                type="number"
                                placeholder="0.00"
                                :min="0"
                                step="0.01"
                                inputmode="decimal"
                                prepend="$"
                                variant="solid"
                            />
                        </div>
                        <!--end::Preview-->
                    </div>
                    <div class="col-lg-6">
                        <!--begin::Code-->
                        <div class="rounded border p-5 bg-dark h-100">
<pre class="text-white mb-0"><code>{{-- Number with min/max --}}
&lt;x-form.input.base 
    label="Age (18-100)" 
    name="constraint_age" 
    type="number"
    :min="18"
    :max="100"
    inputmode="numeric"
    variant="solid"
/&gt;

{{-- Number with step --}}
&lt;x-form.input.base 
    label="Quantity (step: 5)" 
    name="constraint_qty" 
    type="number"
    :min="0"
    :step="5"
    variant="solid"
/&gt;

{{-- Text with minlength/maxlength --}}
&lt;x-form.input.base 
    label="Username" 
    name="constraint_username" 
    :minlength="3"
    :maxlength="20"
    variant="solid"
/&gt;

{{-- With regex pattern --}}
&lt;x-form.input.base 
    label="Hex Color Code" 
    name="constraint_hex" 
    pattern="^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$"
    hint="Format: #RGB or #RRGGBB"
    variant="solid"
/&gt;

{{-- Decimal with step --}}
&lt;x-form.input.base 
    label="Price" 
    name="constraint_price" 
    type="number"
    :min="0"
    step="0.01"
    inputmode="decimal"
    prepend="$"
    variant="solid"
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
                    <span class="card-label fw-bold text-gray-900">States & Features</span>
                    <span class="text-muted mt-1 fw-semibold fs-7">Required, disabled, readonly, hint, and error states</span>
                </h3>
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-5">
                <div class="row">
                    <div class="col-lg-6">
                        <!--begin::Preview-->
                        <div class="rounded border p-5 mb-5 bg-light-dark">
                            <x-form.input.base 
                                label="Required Field" 
                                name="state_required" 
                                placeholder="This field is required"
                                :required="true"
                                variant="solid"
                            />
                            
                            <x-form.input.base 
                                label="With Hint" 
                                name="state_hint" 
                                placeholder="Enter value"
                                hint="This is a helpful hint message for the user"
                                variant="solid"
                            />

                            <x-form.input.base 
                                label="With Error" 
                                name="state_error" 
                                value="invalid value"
                                error="This field has an error message"
                                variant="solid"
                            />

                            <x-form.input.base 
                                label="Disabled Input" 
                                name="state_disabled" 
                                value="Disabled value"
                                :disabled="true"
                                variant="solid"
                            />

                            <x-form.input.base 
                                label="Readonly Input" 
                                name="state_readonly" 
                                value="Readonly value"
                                :readonly="true"
                                variant="solid"
                            />
                        </div>
                        <!--end::Preview-->
                    </div>
                    <div class="col-lg-6">
                        <!--begin::Code-->
                        <div class="rounded border p-5 bg-dark h-100">
<pre class="text-white mb-0"><code>{{-- Required --}}
&lt;x-form.input.base 
    label="Required Field" 
    name="state_required" 
    :required="true"
    variant="solid"
/&gt;

{{-- With hint --}}
&lt;x-form.input.base 
    label="With Hint" 
    name="state_hint" 
    hint="Helpful hint message"
    variant="solid"
/&gt;

{{-- With error --}}
&lt;x-form.input.base 
    label="With Error" 
    name="state_error" 
    error="Error message here"
    variant="solid"
/&gt;

{{-- Disabled --}}
&lt;x-form.input.base 
    label="Disabled" 
    name="state_disabled" 
    :disabled="true"
    variant="solid"
/&gt;

{{-- Readonly --}}
&lt;x-form.input.base 
    label="Readonly" 
    name="state_readonly" 
    :readonly="true"
    variant="solid"
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
                    <table class="table table-row-bordered table-row-gray-300 gy-4">
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
                                <td><span class="text-muted">required</span></td>
                                <td>Input name attribute</td>
                            </tr>
                            <tr>
                                <td class="ps-4"><code>id</code></td>
                                <td><span class="badge badge-light-info">string</span></td>
                                <td><span class="text-muted">name</span></td>
                                <td>Input id attribute (defaults to name)</td>
                            </tr>
                            <tr>
                                <td class="ps-4"><code>label</code></td>
                                <td><span class="badge badge-light-info">string</span></td>
                                <td><span class="text-muted">null</span></td>
                                <td>Label text above input</td>
                            </tr>
                            <tr>
                                <td class="ps-4"><code>type</code></td>
                                <td><span class="badge badge-light-info">string</span></td>
                                <td><span class="text-muted">text</span></td>
                                <td>Input type (text, email, password, number, date, etc.)</td>
                            </tr>
                            <tr>
                                <td class="ps-4"><code>placeholder</code></td>
                                <td><span class="badge badge-light-info">string</span></td>
                                <td><span class="text-muted">''</span></td>
                                <td>Placeholder text</td>
                            </tr>
                            <tr>
                                <td class="ps-4"><code>value</code></td>
                                <td><span class="badge badge-light-info">string</span></td>
                                <td><span class="text-muted">''</span></td>
                                <td>Input value</td>
                            </tr>
                            <tr>
                                <td class="ps-4"><code>variant</code></td>
                                <td><span class="badge badge-light-info">string</span></td>
                                <td><span class="text-muted">default</span></td>
                                <td>Style variant: default, solid, transparent, flush</td>
                            </tr>
                            <tr>
                                <td class="ps-4"><code>size</code></td>
                                <td><span class="badge badge-light-info">string</span></td>
                                <td><span class="text-muted">null</span></td>
                                <td>Input size: sm, lg</td>
                            </tr>
                            <tr>
                                <td class="ps-4"><code>icon</code></td>
                                <td><span class="badge badge-light-info">string</span></td>
                                <td><span class="text-muted">null</span></td>
                                <td>Icon class (e.g., ki-outline ki-user)</td>
                            </tr>
                            <tr>
                                <td class="ps-4"><code>iconPosition</code></td>
                                <td><span class="badge badge-light-info">string</span></td>
                                <td><span class="text-muted">start</span></td>
                                <td>Icon position: start, end</td>
                            </tr>
                            <tr>
                                <td class="ps-4"><code>prepend</code></td>
                                <td><span class="badge badge-light-info">string</span></td>
                                <td><span class="text-muted">null</span></td>
                                <td>Text/HTML to prepend (input group)</td>
                            </tr>
                            <tr>
                                <td class="ps-4"><code>append</code></td>
                                <td><span class="badge badge-light-info">string</span></td>
                                <td><span class="text-muted">null</span></td>
                                <td>Text/HTML to append (input group)</td>
                            </tr>
                            <tr>
                                <td class="ps-4"><code>hint</code></td>
                                <td><span class="badge badge-light-info">string</span></td>
                                <td><span class="text-muted">null</span></td>
                                <td>Help text displayed below input</td>
                            </tr>
                            <tr>
                                <td class="ps-4"><code>error</code></td>
                                <td><span class="badge badge-light-info">string</span></td>
                                <td><span class="text-muted">null</span></td>
                                <td>Error message (also checks $errors bag)</td>
                            </tr>
                            <tr>
                                <td class="ps-4"><code>required</code></td>
                                <td><span class="badge badge-light-success">bool</span></td>
                                <td><span class="text-muted">false</span></td>
                                <td>Add required indicator to label</td>
                            </tr>
                            <tr>
                                <td class="ps-4"><code>disabled</code></td>
                                <td><span class="badge badge-light-success">bool</span></td>
                                <td><span class="text-muted">false</span></td>
                                <td>Disable the input</td>
                            </tr>
                            <tr>
                                <td class="ps-4"><code>readonly</code></td>
                                <td><span class="badge badge-light-success">bool</span></td>
                                <td><span class="text-muted">false</span></td>
                                <td>Make input readonly</td>
                            </tr>
                            <tr>
                                <td class="ps-4"><code>wrapperClass</code></td>
                                <td><span class="badge badge-light-info">string</span></td>
                                <td><span class="text-muted">''</span></td>
                                <td>Additional CSS class for wrapper div</td>
                            </tr>
                            <tr>
                                <td class="ps-4"><code>inputClass</code></td>
                                <td><span class="badge badge-light-info">string</span></td>
                                <td><span class="text-muted">''</span></td>
                                <td>Additional CSS class for input element</td>
                            </tr>
                            <tr class="bg-light-warning">
                                <td colspan="4" class="ps-4 fw-bold text-dark">New Props (Tooltip, Mask, HTML5 Constraints)</td>
                            </tr>
                            <tr>
                                <td class="ps-4"><code>tooltip</code></td>
                                <td><span class="badge badge-light-info">string</span></td>
                                <td><span class="text-muted">null</span></td>
                                <td>Help tooltip text shown next to label (hover icon)</td>
                            </tr>
                            <tr>
                                <td class="ps-4"><code>mask</code></td>
                                <td><span class="badge badge-light-info">string</span></td>
                                <td><span class="text-muted">null</span></td>
                                <td>Input mask pattern using jQuery Mask Plugin (e.g., '000.000.000-00')</td>
                            </tr>
                            <tr>
                                <td class="ps-4"><code>maskOptions</code></td>
                                <td><span class="badge badge-light-info">array</span></td>
                                <td><span class="text-muted">[]</span></td>
                                <td>Additional jQuery Mask Plugin options (reverse, clearIfNotMatch, etc.)</td>
                            </tr>
                            <tr>
                                <td class="ps-4"><code>autocomplete</code></td>
                                <td><span class="badge badge-light-info">string</span></td>
                                <td><span class="text-muted">null</span></td>
                                <td>HTML autocomplete attribute (e.g., 'email', 'off', 'new-password')</td>
                            </tr>
                            <tr>
                                <td class="ps-4"><code>min</code></td>
                                <td><span class="badge badge-light-primary">int/string</span></td>
                                <td><span class="text-muted">null</span></td>
                                <td>Minimum value (for number, date, range types)</td>
                            </tr>
                            <tr>
                                <td class="ps-4"><code>max</code></td>
                                <td><span class="badge badge-light-primary">int/string</span></td>
                                <td><span class="text-muted">null</span></td>
                                <td>Maximum value (for number, date, range types)</td>
                            </tr>
                            <tr>
                                <td class="ps-4"><code>step</code></td>
                                <td><span class="badge badge-light-primary">int/string</span></td>
                                <td><span class="text-muted">null</span></td>
                                <td>Step increment (for number, range types)</td>
                            </tr>
                            <tr>
                                <td class="ps-4"><code>minlength</code></td>
                                <td><span class="badge badge-light-primary">int</span></td>
                                <td><span class="text-muted">null</span></td>
                                <td>Minimum character length</td>
                            </tr>
                            <tr>
                                <td class="ps-4"><code>maxlength</code></td>
                                <td><span class="badge badge-light-primary">int</span></td>
                                <td><span class="text-muted">null</span></td>
                                <td>Maximum character length</td>
                            </tr>
                            <tr>
                                <td class="ps-4"><code>pattern</code></td>
                                <td><span class="badge badge-light-info">string</span></td>
                                <td><span class="text-muted">null</span></td>
                                <td>Regex pattern for validation</td>
                            </tr>
                            <tr>
                                <td class="ps-4"><code>inputmode</code></td>
                                <td><span class="badge badge-light-info">string</span></td>
                                <td><span class="text-muted">null</span></td>
                                <td>Virtual keyboard type: text, decimal, numeric, tel, search, email, url</td>
                            </tr>
                            <tr>
                                <td class="ps-4"><code>dir</code></td>
                                <td><span class="badge badge-light-info">string</span></td>
                                <td><span class="text-muted">null</span></td>
                                <td>Text direction: ltr, rtl, auto</td>
                            </tr>
                            <tr>
                                <td class="ps-4"><code>errorBag</code></td>
                                <td><span class="badge badge-light-info">string</span></td>
                                <td><span class="text-muted">default</span></td>
                                <td>Laravel error bag name for retrieving validation errors</td>
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
