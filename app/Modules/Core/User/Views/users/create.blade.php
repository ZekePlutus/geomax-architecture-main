@extends('layout50.master')

@section('title', 'Create User')

@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Create
                        New User</h1>
                    <x-breadcrumb :items="[['label' => 'Users', 'url' => route('user.users.index')], ['label' => 'Create']]" />
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <a href="{{ route('user.users.index') }}" class="btn btn-sm fw-bold btn-secondary">
                        <i class="ki-duotone ki-arrow-left fs-4 me-1"></i>Back to List
                    </a>
                </div>
                <!--end::Actions-->
            </div>
        </div>
        <!--end::Toolbar-->

        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-xxl">
                <form action="{{ route('user.users.store') }}" method="POST" class="form">
                    @csrf
                    <div class="row g-5 g-xl-8">
                        <!--begin::Left Column-->
                        <div class="col-xl-8">
                            <!--begin::Basic Info Card-->
                            <div class="card card-flush mb-5 mb-xl-8">
                                <div class="card-header border-0 pt-6">
                                    <div class="card-title">
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-45px w-45px bg-light-primary me-4">
                                                <span class="symbol-label">
                                                    <i class="ki-duotone ki-user fs-2 text-primary">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </span>
                                            </div>
                                            <div>
                                                <h3 class="fw-bold mb-0">Basic Information</h3>
                                                <span class="text-muted fs-7">Enter the user's personal details</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body pt-0">
                                    <div class="row mb-6">
                                        <div class="col-lg-6">
                                            <x-form.input.base name="name" label="Full Name"
                                                placeholder="Enter full name" icon="ki-outline ki-user" size="lg"
                                                :required="true" />
                                        </div>
                                        <div class="col-lg-6">
                                            <x-form.input.base name="email" type="email" label="Email Address"
                                                placeholder="Enter email address" icon="ki-outline ki-sms" size="lg"
                                                :required="true" />
                                        </div>
                                    </div>
                                    <div class="row mb-6">
                                        <div class="col-lg-6">
                                            <x-form.input.base name="phone" type="tel" label="Phone Number"
                                                placeholder="+1 555-0100" icon="ki-outline ki-phone" size="lg" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Basic Info Card-->

                            <!--begin::Password Card-->
                            <div class="card card-flush mb-5 mb-xl-8">
                                <div class="card-header border-0 pt-6">
                                    <div class="card-title">
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-45px w-45px bg-light-warning me-4">
                                                <span class="symbol-label">
                                                    <i class="ki-duotone ki-lock fs-2 text-warning">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                    </i>
                                                </span>
                                            </div>
                                            <div>
                                                <h3 class="fw-bold mb-0">Password Setup</h3>
                                                <span class="text-muted fs-7">Set initial password or let user create their
                                                    own</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body pt-0">
                                    <div
                                        class="notice d-flex bg-light-primary rounded border-primary border border-dashed p-6 mb-6">
                                        <i class="ki-duotone ki-information fs-2tx text-primary me-4">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                        <div class="d-flex flex-stack flex-grow-1">
                                            <div class="fw-semibold">
                                                <div class="fs-6 text-gray-700">Leave password fields empty to send the user
                                                    an email invitation to set their own password.</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 mb-3 mb-lg-0">
                                            <x-form.input.base name="password" type="password" label="Password"
                                                placeholder="Enter password" icon="ki-outline ki-lock" size="lg" />
                                        </div>
                                        <div class="col-lg-6">
                                            <x-form.input.base name="password_confirmation" type="password"
                                                label="Confirm Password" placeholder="Confirm password"
                                                icon="ki-outline ki-lock-2" size="lg" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Password Card-->

                            <!--begin::Company Info Card (Dynamic - shown for reseller_owner type)-->
                            <div class="card card-flush mb-5 mb-xl-8" id="companyInfoCard" style="display: none;">
                                <div class="card-header border-0 pt-6">
                                    <div class="card-title">
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-45px w-45px bg-light-success me-4">
                                                <span class="symbol-label">
                                                    <i class="ki-duotone ki-home fs-2 text-success">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </span>
                                            </div>
                                            <div>
                                                <h3 class="fw-bold mb-0">Organization Information</h3>
                                                <span class="text-muted fs-7">Company/organization details for this reseller</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body pt-0">
                                    <div class="row mb-6">
                                        <div class="col-lg-6">
                                            <x-form.input.base name="company[name]" label="Company Name"
                                                placeholder="Enter company name" icon="ki-outline ki-home" size="lg" />
                                        </div>
                                        <div class="col-lg-6">
                                            <x-form.input.base name="company[legal_name]" label="Legal Name"
                                                placeholder="Legal business name" icon="ki-outline ki-document" size="lg" />
                                        </div>
                                    </div>
                                    <div class="row mb-6">
                                        <div class="col-lg-6">
                                            <x-form.input.base name="company[tax_id]" label="Tax ID / EIN"
                                                placeholder="Tax identification" icon="ki-outline ki-clipboard" size="lg" />
                                        </div>
                                        <div class="col-lg-6">
                                            <x-form.input.base name="company[website]" type="url" label="Website"
                                                placeholder="https://example.com" icon="ki-outline ki-globe" size="lg" />
                                        </div>
                                    </div>
                                    <div class="row mb-6">
                                        <div class="col-lg-6">
                                            <x-form.input.base name="company[contact_email]" type="email" label="Contact Email"
                                                placeholder="contact@company.com" icon="ki-outline ki-sms" size="lg" />
                                        </div>
                                        <div class="col-lg-6">
                                            <x-form.input.base name="company[contact_phone]" type="tel" label="Contact Phone"
                                                placeholder="+1 555-0100" icon="ki-outline ki-phone" size="lg" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Company Info Card-->

                            <!--begin::Company Address Card (Dynamic)-->
                            <div class="card card-flush mb-5 mb-xl-8" id="companyAddressCard" style="display: none;">
                                <div class="card-header border-0 pt-6">
                                    <div class="card-title">
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-45px w-45px bg-light-info me-4">
                                                <span class="symbol-label">
                                                    <i class="ki-duotone ki-geolocation fs-2 text-info">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </span>
                                            </div>
                                            <div>
                                                <h3 class="fw-bold mb-0">Company Address</h3>
                                                <span class="text-muted fs-7">Physical location of the organization</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body pt-0">
                                    <div class="row mb-6">
                                        <div class="col-12">
                                            <x-form.input.base name="company[address_line_1]" label="Address Line 1"
                                                placeholder="Street address" icon="ki-outline ki-geolocation" size="lg" />
                                        </div>
                                    </div>
                                    <div class="row mb-6">
                                        <div class="col-12">
                                            <x-form.input.base name="company[address_line_2]" label="Address Line 2"
                                                placeholder="Suite, unit, floor, etc." icon="ki-outline ki-map" size="lg" />
                                        </div>
                                    </div>
                                    <div class="row mb-6">
                                        <div class="col-lg-6">
                                            <x-form.input.base name="company[city]" label="City"
                                                placeholder="Enter city" icon="ki-outline ki-flag" size="lg" />
                                        </div>
                                        <div class="col-lg-6">
                                            <x-form.input.base name="company[state]" label="State / Province"
                                                placeholder="Enter state" icon="ki-outline ki-map" size="lg" />
                                        </div>
                                    </div>
                                    <div class="row mb-6">
                                        <div class="col-lg-6">
                                            <x-form.input.base name="company[postal_code]" label="Postal / ZIP Code"
                                                placeholder="Enter postal code" icon="ki-outline ki-send" size="lg" />
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label fs-6 fw-semibold">Country</label>
                                            <select name="company[country_code]" class="form-select form-select-lg" data-control="select2" data-placeholder="Select country">
                                                <option></option>
                                                <option value="US">United States</option>
                                                <option value="CA">Canada</option>
                                                <option value="MX">Mexico</option>
                                                <option value="GB">United Kingdom</option>
                                                <option value="AU">Australia</option>
                                                <option value="DE">Germany</option>
                                                <option value="FR">France</option>
                                                <option value="ES">Spain</option>
                                                <option value="IT">Italy</option>
                                                <option value="BR">Brazil</option>
                                                <option value="AR">Argentina</option>
                                                <option value="CO">Colombia</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Company Address Card-->

                            <!--begin::Localization Card (Dynamic)-->
                            <div class="card card-flush mb-5 mb-xl-8" id="companyLocalizationCard" style="display: none;">
                                <div class="card-header border-0 pt-6">
                                    <div class="card-title">
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-45px w-45px bg-light-warning me-4">
                                                <span class="symbol-label">
                                                    <i class="ki-duotone ki-globe fs-2 text-warning">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </span>
                                            </div>
                                            <div>
                                                <h3 class="fw-bold mb-0">Localization & Units</h3>
                                                <span class="text-muted fs-7">Regional settings and measurement units</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body pt-0">
                                    <div class="row mb-6">
                                        <div class="col-lg-6">
                                            <label class="form-label fs-6 fw-semibold">Timezone</label>
                                            <select name="company[timezone]" class="form-select form-select-lg" data-control="select2" data-placeholder="Select timezone">
                                                <option></option>
                                                <option value="America/New_York">Eastern Time (US & Canada)</option>
                                                <option value="America/Chicago">Central Time (US & Canada)</option>
                                                <option value="America/Denver">Mountain Time (US & Canada)</option>
                                                <option value="America/Los_Angeles">Pacific Time (US & Canada)</option>
                                                <option value="America/Anchorage">Alaska</option>
                                                <option value="Pacific/Honolulu">Hawaii</option>
                                                <option value="America/Mexico_City">Mexico City</option>
                                                <option value="America/Bogota">Bogota</option>
                                                <option value="America/Sao_Paulo">Sao Paulo</option>
                                                <option value="Europe/London">London</option>
                                                <option value="Europe/Paris">Paris</option>
                                                <option value="Europe/Berlin">Berlin</option>
                                                <option value="UTC">UTC</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label fs-6 fw-semibold">Language</label>
                                            <select name="company[locale]" class="form-select form-select-lg" data-control="select2" data-placeholder="Select language">
                                                <option></option>
                                                <option value="en">English</option>
                                                <option value="es">Spanish</option>
                                                <option value="pt">Portuguese</option>
                                                <option value="fr">French</option>
                                                <option value="de">German</option>
                                                <option value="it">Italian</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-6">
                                        <div class="col-lg-6">
                                            <label class="form-label fs-6 fw-semibold">Currency</label>
                                            <select name="company[currency_code]" class="form-select form-select-lg" data-control="select2" data-placeholder="Select currency">
                                                <option></option>
                                                <option value="USD">USD - US Dollar</option>
                                                <option value="CAD">CAD - Canadian Dollar</option>
                                                <option value="MXN">MXN - Mexican Peso</option>
                                                <option value="EUR">EUR - Euro</option>
                                                <option value="GBP">GBP - British Pound</option>
                                                <option value="BRL">BRL - Brazilian Real</option>
                                                <option value="ARS">ARS - Argentine Peso</option>
                                                <option value="COP">COP - Colombian Peso</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label fs-6 fw-semibold">Date Format</label>
                                            <select name="company[date_format]" class="form-select form-select-lg">
                                                <option value="Y-m-d">2026-01-13 (ISO)</option>
                                                <option value="m/d/Y">01/13/2026 (US)</option>
                                                <option value="d/m/Y">13/01/2026 (EU)</option>
                                                <option value="d.m.Y">13.01.2026 (DE)</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="separator separator-dashed my-6"></div>
                                    <h5 class="fw-bold mb-4">Measurement Units</h5>

                                    <div class="row mb-6">
                                        <div class="col-lg-6">
                                            <label class="form-label fs-6 fw-semibold">Distance</label>
                                            <div class="d-flex gap-5 mt-2">
                                                <label class="form-check form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="radio" name="company[units][distance]" value="mile" checked>
                                                    <span class="form-check-label fw-semibold">Miles</span>
                                                </label>
                                                <label class="form-check form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="radio" name="company[units][distance]" value="kilometer">
                                                    <span class="form-check-label fw-semibold">Kilometers</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label fs-6 fw-semibold">Temperature</label>
                                            <div class="d-flex gap-5 mt-2">
                                                <label class="form-check form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="radio" name="company[units][temperature]" value="fahrenheit" checked>
                                                    <span class="form-check-label fw-semibold">Fahrenheit (°F)</span>
                                                </label>
                                                <label class="form-check form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="radio" name="company[units][temperature]" value="celsius">
                                                    <span class="form-check-label fw-semibold">Celsius (°C)</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-6">
                                        <div class="col-lg-6">
                                            <label class="form-label fs-6 fw-semibold">Volume</label>
                                            <div class="d-flex gap-5 mt-2">
                                                <label class="form-check form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="radio" name="company[units][volume]" value="gallon" checked>
                                                    <span class="form-check-label fw-semibold">Gallons</span>
                                                </label>
                                                <label class="form-check form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="radio" name="company[units][volume]" value="liter">
                                                    <span class="form-check-label fw-semibold">Liters</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label fs-6 fw-semibold">Weight</label>
                                            <div class="d-flex gap-5 mt-2">
                                                <label class="form-check form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="radio" name="company[units][weight]" value="pound" checked>
                                                    <span class="form-check-label fw-semibold">Pounds (lb)</span>
                                                </label>
                                                <label class="form-check form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="radio" name="company[units][weight]" value="kilogram">
                                                    <span class="form-check-label fw-semibold">Kilograms (kg)</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Localization Card-->

                            <!--begin::Company Branding Card (Dynamic)-->
                            <div class="card card-flush mb-5 mb-xl-8" id="companyBrandingCard" style="display: none;">
                                <div class="card-header border-0 pt-6">
                                    <div class="card-title">
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-45px w-45px bg-light-danger me-4">
                                                <span class="symbol-label">
                                                    <i class="ki-duotone ki-picture fs-2 text-danger">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </span>
                                            </div>
                                            <div>
                                                <h3 class="fw-bold mb-0">Branding</h3>
                                                <span class="text-muted fs-7">Logo and brand colors</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body pt-0">
                                    <div class="row mb-6">
                                        <div class="col-12">
                                            <label class="form-label fs-6 fw-semibold">Company Logo</label>
                                            <input type="file" name="company[logo]" class="form-control form-control-lg" accept="image/*">
                                            <div class="form-text">Recommended: 200x200px PNG or JPG</div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label class="form-label fs-6 fw-semibold">Primary Brand Color</label>
                                            <input type="color" name="company[primary_color]" class="form-control form-control-lg" value="#3699FF">
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label fs-6 fw-semibold">Secondary Brand Color</label>
                                            <input type="color" name="company[secondary_color]" class="form-control form-control-lg" value="#E4E6EF">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Company Branding Card-->

                            <!--begin::Roles Card-->
                            <div class="card card-flush">
                                <div class="card-header border-0 pt-6">
                                    <div class="card-title">
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-45px w-45px bg-light-success me-4">
                                                <span class="symbol-label">
                                                    <i class="ki-duotone ki-shield-tick fs-2 text-success">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </span>
                                            </div>
                                            <div>
                                                <h3 class="fw-bold mb-0">Role Assignment</h3>
                                                <span class="text-muted fs-7">Select a role for this user</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-toolbar">
                                        <button type="button" class="btn btn-sm btn-light-primary"
                                            data-bs-toggle="modal" data-bs-target="#createRoleModal">
                                            <i class="ki-outline ki-plus fs-5 me-1"></i>Create New Role
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body pt-0">
                                    <div class="row g-4" id="rolesContainer">
                                        @foreach ($roles as $role)
                                            <div class="col-md-6">
                                                <label class="d-flex flex-stack cursor-pointer">
                                                    <span class="d-flex align-items-center me-2">
                                                        <span class="symbol symbol-40px me-4">
                                                            <span
                                                                class="symbol-label bg-light-{{ $role->is_system ? 'primary' : 'info' }}">
                                                                <i
                                                                    class="ki-duotone ki-{{ $role->is_system ? 'crown' : 'user-tick' }} fs-3 text-{{ $role->is_system ? 'primary' : 'info' }}">
                                                                    <span class="path1"></span>
                                                                    <span class="path2"></span>
                                                                    <span class="path3"></span>
                                                                </i>
                                                            </span>
                                                        </span>
                                                        <span class="d-flex flex-column">
                                                            <span class="fw-bold fs-6">{{ $role->name }}</span>
                                                            <span
                                                                class="fs-7 text-muted">{{ $role->description ?? 'No description' }}</span>
                                                        </span>
                                                    </span>
                                                    <span class="form-check form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="radio" name="role_id"
                                                            value="{{ $role->id }}"
                                                            {{ old('role_id') == $role->id ? 'checked' : '' }}>
                                                    </span>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error('role_id')
                                        <div class="text-danger small mt-3">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!--end::Roles Card-->

                            <!--begin::Module Permissions Card-->
                            <div class="card card-flush">
                                <div class="card-header border-0 pt-6">
                                    <div class="card-title">
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-45px w-45px bg-light-info me-4">
                                                <span class="symbol-label">
                                                    <i class="ki-duotone ki-security-user fs-2 text-info">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </span>
                                            </div>
                                            <div>
                                                <h3 class="fw-bold mb-0">Module Permissions</h3>
                                                <span class="text-muted fs-7">Auto-assigned based on selected role</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-toolbar">
                                        <div class="d-flex gap-2">
                                            <button type="button" class="btn btn-sm btn-light-primary"
                                                id="selectAllModules">
                                                <i class="ki-duotone ki-check-square fs-4"></i>
                                                All
                                            </button>
                                            <button type="button" class="btn btn-sm btn-light-danger"
                                                id="deselectAllModules">
                                                <i class="ki-duotone ki-cross-square fs-4"></i>
                                                None
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body pt-0">
                                    <div
                                        class="notice d-flex bg-light-info rounded border-info border border-dashed p-4 mb-4">
                                        <i class="ki-duotone ki-information fs-2tx text-info me-3">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                        <div class="d-flex flex-stack flex-grow-1">
                                            <div class="fw-semibold">
                                                <div class="fs-7 text-gray-700">
                                                    Selecting a role will auto-assign recommended module permissions. You
                                                    can customize them below.
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row g-3">
                                        @foreach ($modules as $module)
                                            <div class="col-md-6 col-lg-4">
                                                <label
                                                    class="d-flex align-items-center cursor-pointer p-3 border border-dashed border-gray-300 rounded-3 module-card"
                                                    data-module-id="{{ $module->id }}">
                                                    <span class="form-check form-check-custom form-check-solid me-3">
                                                        <input class="form-check-input module-checkbox" type="checkbox"
                                                            name="module_ids[]" value="{{ $module->id }}">
                                                    </span>
                                                    <span class="d-flex flex-column">
                                                        <span class="fw-bold fs-7">{{ $module->name }}</span>
                                                    </span>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mt-4 pt-4 border-top">
                                        <span class="text-muted fs-7">Selected modules:</span>
                                        <span class="badge badge-light-primary fs-7" id="selectedModuleCount">0</span>
                                    </div>
                                </div>
                            </div>
                            <!--end::Module Permissions Card-->
                        </div>
                        <!--end::Left Column-->

                        <!--begin::Right Column-->
                        <div class="col-xl-4">
                            <!--begin::User Type Card-->
                            <div class="card card-flush mb-5 mb-xl-8">
                                <div class="card-header border-0 pt-6">
                                    <div class="card-title">
                                        <h3 class="fw-bold mb-0">User Type</h3>
                                    </div>
                                </div>
                                <div class="card-body pt-0">
                                    <div class="d-flex flex-column gap-4">
                                        @foreach ($userTypes as $type)
                                            <label class="d-flex flex-stack cursor-pointer">
                                                <span class="d-flex align-items-center me-2">
                                                    <span class="symbol symbol-40px me-4">
                                                        <span
                                                            class="symbol-label bg-light-{{ $loop->index % 5 == 0 ? 'danger' : ($loop->index % 5 == 1 ? 'warning' : ($loop->index % 5 == 2 ? 'info' : ($loop->index % 5 == 3 ? 'success' : 'primary'))) }}">
                                                            <i
                                                                class="ki-duotone ki-{{ $loop->index % 5 == 0 ? 'crown' : ($loop->index % 5 == 1 ? 'briefcase' : ($loop->index % 5 == 2 ? 'shield' : ($loop->index % 5 == 3 ? 'people' : 'car'))) }} fs-3 text-{{ $loop->index % 5 == 0 ? 'danger' : ($loop->index % 5 == 1 ? 'warning' : ($loop->index % 5 == 2 ? 'info' : ($loop->index % 5 == 3 ? 'success' : 'primary'))) }}">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                                <span class="path3"></span>
                                                            </i>
                                                        </span>
                                                    </span>
                                                    <span class="d-flex flex-column">
                                                        <span class="fw-bold fs-6">{{ $type->name }}</span>
                                                        <span
                                                            class="fs-7 text-muted">{{ $type->description ?? '' }}</span>
                                                    </span>
                                                </span>
                                                <span class="form-check form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="radio" name="user_type_id"
                                                        value="{{ $type->id }}"
                                                        {{ old('user_type_id') == $type->id ? 'checked' : '' }} required>
                                                </span>
                                            </label>
                                            <div class="separator separator-dashed"></div>
                                        @endforeach
                                    </div>
                                    @error('user_type_id')
                                        <div class="text-danger small mt-3">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!--end::User Type Card-->

                            <!--begin::Status Card-->
                            <div class="card card-flush mb-5 mb-xl-8">
                                <div class="card-header border-0 pt-6">
                                    <div class="card-title">
                                        <h3 class="fw-bold mb-0">Account Status</h3>
                                    </div>
                                </div>
                                <div class="card-body pt-0">
                                    <label class="form-check form-switch form-check-custom form-check-solid">
                                        <input class="form-check-input h-30px w-50px" type="checkbox" name="is_active"
                                            value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                        <span class="form-check-label fw-semibold text-muted ms-3">
                                            Active Account
                                        </span>
                                    </label>
                                    <div class="text-gray-500 fs-7 mt-3">
                                        Inactive users cannot log in to the system.
                                    </div>
                                </div>
                            </div>
                            <!--end::Status Card-->

                            <!--begin::Actions Card-->
                            <div class="card card-flush">
                                <div class="card-body">
                                    <div class="d-flex flex-column gap-3">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="ki-duotone ki-check fs-3 me-1">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>Create User
                                        </button>
                                        <a href="{{ route('user.users.index') }}" class="btn btn-light">
                                            Cancel
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!--end::Actions Card-->
                        </div>
                        <!--end::Right Column-->
                    </div>
                </form>
            </div>
        </div>
        <!--end::Content-->
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // User type detection - show company fields for reseller_owner
            const userTypeRadios = document.querySelectorAll('input[name="user_type_id"]');
            const companyCards = [
                document.getElementById('companyInfoCard'),
                document.getElementById('companyAddressCard'),
                document.getElementById('companyLocalizationCard'),
                document.getElementById('companyBrandingCard')
            ];

            // User types that require company creation (reseller_owner = id 1 typically)
            // Adjust these IDs based on your actual user_types table
            const companyRequiredTypes = [1]; // reseller_owner

            function toggleCompanyFields(userTypeId) {
                const showCompany = companyRequiredTypes.includes(parseInt(userTypeId));
                companyCards.forEach(card => {
                    if (card) {
                        card.style.display = showCompany ? 'block' : 'none';
                        // Toggle required on company name
                        const companyNameInput = card.querySelector('input[name="company[name]"]');
                        if (companyNameInput) {
                            companyNameInput.required = showCompany;
                        }
                    }
                });
            }

            userTypeRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.checked) {
                        toggleCompanyFields(this.value);
                    }
                });

                // Check initial state
                if (radio.checked) {
                    toggleCompanyFields(radio.value);
                }
            });

            // Role-based default module permissions
            const roleDefaultModules = @json($roleDefaultModules ?? []);

            const roleRadios = document.querySelectorAll('input[name="role_id"]');
            const moduleCheckboxes = document.querySelectorAll('.module-checkbox');
            const selectAllBtn = document.getElementById('selectAllModules');
            const deselectAllBtn = document.getElementById('deselectAllModules');
            const moduleCountEl = document.getElementById('selectedModuleCount');

            function updateModuleCount() {
                const count = document.querySelectorAll('.module-checkbox:checked').length;
                if (moduleCountEl) {
                    moduleCountEl.textContent = count;
                }
            }

            function updateCardStyles() {
                document.querySelectorAll('.module-card').forEach(card => {
                    const checkbox = card.querySelector('.module-checkbox');
                    if (checkbox.checked) {
                        card.classList.add('border-primary', 'bg-light-primary');
                        card.classList.remove('border-gray-300');
                    } else {
                        card.classList.remove('border-primary', 'bg-light-primary');
                        card.classList.add('border-gray-300');
                    }
                });
            }

            function applyRoleDefaults(roleId) {
                const defaultModules = roleDefaultModules[roleId] || [];

                moduleCheckboxes.forEach(checkbox => {
                    const moduleId = parseInt(checkbox.value);
                    checkbox.checked = defaultModules.includes(moduleId);
                });

                updateCardStyles();
                updateModuleCount();
            }

            // Listen for role selection changes
            roleRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.checked) {
                        applyRoleDefaults(parseInt(this.value));
                    }
                });
            });

            // Module checkbox changes
            moduleCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    updateCardStyles();
                    updateModuleCount();
                });
            });

            // Make module cards clickable
            document.querySelectorAll('.module-card').forEach(card => {
                card.addEventListener('click', function(e) {
                    if (e.target.type !== 'checkbox') {
                        const checkbox = this.querySelector('.module-checkbox');
                        checkbox.checked = !checkbox.checked;
                        checkbox.dispatchEvent(new Event('change'));
                    }
                });
            });

            // Select/Deselect all buttons
            if (selectAllBtn) {
                selectAllBtn.addEventListener('click', function() {
                    moduleCheckboxes.forEach(cb => cb.checked = true);
                    updateCardStyles();
                    updateModuleCount();
                });
            }

            if (deselectAllBtn) {
                deselectAllBtn.addEventListener('click', function() {
                    moduleCheckboxes.forEach(cb => cb.checked = false);
                    updateCardStyles();
                    updateModuleCount();
                });
            }

            // Initialize
            updateCardStyles();
            updateModuleCount();
        });
    </script>
@endpush

<style>
    .module-card {
        transition: all 0.2s ease;
    }

    .module-card:hover {
        box-shadow: 0 0.25rem 0.75rem 0.25rem rgba(0, 0, 0, 0.05);
        transform: translateY(-1px);
    }

    .module-card.border-primary {
        background-color: rgba(var(--bs-primary-rgb), 0.05) !important;
    }
</style>

{{-- Include Role Creation Modal --}}
@include('user::roles.partials.create-modal')

@push('scripts')
    <script>
        // Handle new role being created - add it to the roles list
        document.addEventListener('roleCreated', function(e) {
            const role = e.detail.role;
            const container = document.getElementById('rolesContainer');

            if (container) {
                const roleHtml = `
            <div class="col-md-6">
                <label class="d-flex flex-stack cursor-pointer">
                    <span class="d-flex align-items-center me-2">
                        <span class="symbol symbol-40px me-4">
                            <span class="symbol-label bg-light-info">
                                <i class="ki-duotone ki-user-tick fs-3 text-info">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>
                            </span>
                        </span>
                        <span class="d-flex flex-column">
                            <span class="fw-bold fs-6">${role.name}</span>
                            <span class="fs-7 text-muted">${role.description || 'No description'}</span>
                        </span>
                    </span>
                    <span class="form-check form-check-custom form-check-solid">
                        <input class="form-check-input" type="radio" name="role_id" value="${role.id}" checked>
                    </span>
                </label>
            </div>
        `;
                container.insertAdjacentHTML('beforeend', roleHtml);
            }
        });
    </script>
@endpush
