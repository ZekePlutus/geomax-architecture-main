@extends('layout50.master')

@section('title', 'Edit User - ' . $user->name)

@section('content')
<div class="d-flex flex-column flex-column-fluid">
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Edit User</h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('user.users.index') }}" class="text-muted text-hover-primary">Users</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('user.users.show', $user->id) }}" class="text-muted text-hover-primary">{{ $user->name }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Edit</li>
                </ul>
            </div>
            <!--end::Page title-->
            <!--begin::Actions-->
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <a href="{{ route('user.users.show', $user->id) }}" class="btn btn-sm fw-bold btn-secondary">
                    <i class="ki-duotone ki-arrow-left fs-4 me-1"></i>Back to Profile
                </a>
            </div>
            <!--end::Actions-->
        </div>
    </div>
    <!--end::Toolbar-->

    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <form action="{{ route('user.users.update', $user->id) }}" method="POST" class="form">
                @csrf
                @method('PUT')
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
                                            <span class="text-muted fs-7">Update the user's personal details</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="row mb-6">
                                    <div class="col-lg-6 fv-row">
                                        <label class="required form-label fw-semibold fs-6">Full Name</label>
                                        <input type="text" 
                                               name="name" 
                                               class="form-control form-control-lg form-control-solid @error('name') is-invalid @enderror" 
                                               placeholder="Enter full name"
                                               value="{{ old('name', $user->name) }}" 
                                               required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6 fv-row">
                                        <label class="required form-label fw-semibold fs-6">Email Address</label>
                                        <input type="email" 
                                               name="email" 
                                               class="form-control form-control-lg form-control-solid @error('email') is-invalid @enderror" 
                                               placeholder="Enter email address"
                                               value="{{ old('email', $user->email) }}" 
                                               required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-6">
                                    <div class="col-lg-6 fv-row">
                                        <label class="form-label fw-semibold fs-6">Phone Number</label>
                                        <input type="tel" 
                                               name="phone" 
                                               class="form-control form-control-lg form-control-solid @error('phone') is-invalid @enderror" 
                                               placeholder="+1 555-0100"
                                               value="{{ old('phone', $user->phone ?? '') }}">
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
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
                                            <h3 class="fw-bold mb-0">Change Password</h3>
                                            <span class="text-muted fs-7">Leave blank to keep current password</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="row">
                                    <div class="col-lg-6 fv-row mb-3 mb-lg-0">
                                        <label class="form-label fw-semibold fs-6">New Password</label>
                                        <div class="position-relative">
                                            <input type="password" 
                                                   name="password" 
                                                   class="form-control form-control-lg form-control-solid @error('password') is-invalid @enderror" 
                                                   placeholder="Enter new password"
                                                   id="password">
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 fv-row">
                                        <label class="form-label fw-semibold fs-6">Confirm Password</label>
                                        <input type="password" 
                                               name="password_confirmation" 
                                               class="form-control form-control-lg form-control-solid" 
                                               placeholder="Confirm new password">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Password Card-->

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
                            </div>
                            <div class="card-body pt-0">
                                @php $userRoleId = $user->roles->first()?->id; @endphp
                                <div class="row g-4">
                                    @foreach ($roles as $role)
                                    <div class="col-md-6">
                                        <label class="d-flex flex-stack cursor-pointer">
                                            <span class="d-flex align-items-center me-2">
                                                <span class="symbol symbol-40px me-4">
                                                    <span class="symbol-label bg-light-{{ $role->is_system ? 'primary' : 'info' }}">
                                                        <i class="ki-duotone ki-{{ $role->is_system ? 'crown' : 'user-tick' }} fs-3 text-{{ $role->is_system ? 'primary' : 'info' }}">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                            <span class="path3"></span>
                                                        </i>
                                                    </span>
                                                </span>
                                                <span class="d-flex flex-column">
                                                    <span class="fw-bold fs-6">{{ $role->name }}</span>
                                                    <span class="fs-7 text-muted">{{ $role->description ?? 'No description' }}</span>
                                                </span>
                                            </span>
                                            <span class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input" 
                                                       type="radio" 
                                                       name="role_id" 
                                                       value="{{ $role->id }}"
                                                       {{ old('role_id', $userRoleId) == $role->id ? 'checked' : '' }}>
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
                                            <span class="text-muted fs-7">Change role to reset to defaults</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-toolbar">
                                    <div class="d-flex gap-2">
                                        <button type="button" class="btn btn-sm btn-light-primary" id="selectAllModules">
                                            <i class="ki-duotone ki-check-square fs-4"></i>
                                            All
                                        </button>
                                        <button type="button" class="btn btn-sm btn-light-danger" id="deselectAllModules">
                                            <i class="ki-duotone ki-cross-square fs-4"></i>
                                            None
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                @php
                                    $userModuleIds = isset($user->modules) ? collect($user->modules)->pluck('id') : collect();
                                @endphp
                                <div class="row g-3">
                                    @foreach ($modules as $module)
                                    <div class="col-md-6 col-lg-4">
                                        <label class="d-flex align-items-center cursor-pointer p-3 border border-dashed border-gray-300 rounded-3 module-card" data-module-id="{{ $module->id }}">
                                            <span class="form-check form-check-custom form-check-solid me-3">
                                                <input class="form-check-input module-checkbox" 
                                                       type="checkbox" 
                                                       name="module_ids[]" 
                                                       value="{{ $module->id }}"
                                                       {{ $userModuleIds->contains($module->id) ? 'checked' : '' }}>
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
                                    <span class="badge badge-light-primary fs-7" id="selectedModuleCount">{{ $userModuleIds->count() }}</span>
                                </div>
                            </div>
                        </div>
                        <!--end::Module Permissions Card-->
                    </div>
                    <!--end::Left Column-->

                    <!--begin::Right Column-->
                    <div class="col-xl-4">
                        <!--begin::User Profile Card-->
                        <div class="card card-flush mb-5 mb-xl-8">
                            <div class="card-body text-center pt-8">
                                <div class="symbol symbol-100px symbol-circle mb-5">
                                    <span class="symbol-label bg-light-primary fs-1 fw-bold text-primary">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </span>
                                </div>
                                <h3 class="fw-bold mb-1">{{ $user->name }}</h3>
                                <p class="text-muted mb-4">{{ $user->email }}</p>
                                <span class="badge badge-light-{{ $user->is_active ? 'success' : 'danger' }} fs-7">
                                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                            <div class="card-footer border-0 pt-0">
                                <div class="d-flex flex-column">
                                    <div class="d-flex justify-content-between py-3 border-bottom">
                                        <span class="text-muted fs-7">Member Since</span>
                                        <span class="fw-semibold fs-7">{{ $user->created_at ? $user->created_at->format('M d, Y') : 'N/A' }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between py-3">
                                        <span class="text-muted fs-7">Last Login</span>
                                        <span class="fw-semibold fs-7">{{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::User Profile Card-->

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
                                                <span class="symbol-label bg-light-{{ $loop->index % 5 == 0 ? 'danger' : ($loop->index % 5 == 1 ? 'warning' : ($loop->index % 5 == 2 ? 'info' : ($loop->index % 5 == 3 ? 'success' : 'primary'))) }}">
                                                    <i class="ki-duotone ki-{{ $loop->index % 5 == 0 ? 'crown' : ($loop->index % 5 == 1 ? 'briefcase' : ($loop->index % 5 == 2 ? 'shield' : ($loop->index % 5 == 3 ? 'people' : 'car'))) }} fs-3 text-{{ $loop->index % 5 == 0 ? 'danger' : ($loop->index % 5 == 1 ? 'warning' : ($loop->index % 5 == 2 ? 'info' : ($loop->index % 5 == 3 ? 'success' : 'primary'))) }}">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                    </i>
                                                </span>
                                            </span>
                                            <span class="d-flex flex-column">
                                                <span class="fw-bold fs-6">{{ $type->name }}</span>
                                                <span class="fs-7 text-muted">{{ $type->description ?? '' }}</span>
                                            </span>
                                        </span>
                                        <span class="form-check form-check-custom form-check-solid">
                                            <input class="form-check-input" 
                                                   type="radio" 
                                                   name="user_type_id" 
                                                   value="{{ $type->id }}"
                                                   {{ old('user_type_id', $user->user_type_id) == $type->id ? 'checked' : '' }}
                                                   required>
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
                                    <input class="form-check-input h-30px w-50px" 
                                           type="checkbox" 
                                           name="is_active" 
                                           value="1"
                                           {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
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
                                        </i>Save Changes
                                    </button>
                                    <a href="{{ route('user.users.show', $user->id) }}" class="btn btn-light">
                                        Cancel
                                    </a>
                                    <div class="separator separator-dashed my-2"></div>
                                    <a href="{{ route('user.users.permissions', $user->id) }}" class="btn btn-light-info">
                                        <i class="ki-duotone ki-security-user fs-3 me-1">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>Module Permissions
                                    </a>
                                    <a href="{{ route('user.users.restrictions', $user->id) }}" class="btn btn-light-warning">
                                        <i class="ki-duotone ki-shield-cross fs-3 me-1">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>Restrictions
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
