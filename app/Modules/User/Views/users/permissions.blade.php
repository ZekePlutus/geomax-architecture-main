@extends('layout50.master')

@section('title', 'Module Permissions - ' . $user->name)

@section('content')
<div class="d-flex flex-column flex-column-fluid">
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Module Permissions</h1>
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
                    <li class="breadcrumb-item text-muted">Permissions</li>
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
            @if(session('success'))
            <div class="alert alert-success d-flex align-items-center p-5 mb-5">
                <i class="ki-duotone ki-shield-tick fs-2hx text-success me-4">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
                <div class="d-flex flex-column">
                    <span>{{ session('success') }}</span>
                </div>
            </div>
            @endif

            <form action="{{ route('user.users.permissions.update', $user->id) }}" method="POST" class="form">
                @csrf
                @method('PATCH')
                <div class="row g-5 g-xl-8">
                    <!--begin::Left Column - Modules-->
                    <div class="col-xl-8">
                        <!--begin::Header Card-->
                        <div class="card card-flush mb-5 mb-xl-8">
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
                                            <h3 class="fw-bold mb-0">Module Access Control</h3>
                                            <span class="text-muted fs-7">Select which modules {{ $user->name }} can access</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-toolbar">
                                    <div class="d-flex gap-2">
                                        <button type="button" class="btn btn-sm btn-light-primary" id="selectAll">
                                            <i class="ki-duotone ki-check-square fs-4"></i>
                                            Select All
                                        </button>
                                        <button type="button" class="btn btn-sm btn-light-danger" id="deselectAll">
                                            <i class="ki-duotone ki-cross-square fs-4"></i>
                                            Deselect All
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="notice d-flex bg-light-info rounded border-info border border-dashed p-6 mb-6">
                                    <i class="ki-duotone ki-information fs-2tx text-info me-4">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                    <div class="d-flex flex-stack flex-grow-1">
                                        <div class="fw-semibold">
                                            <div class="fs-6 text-gray-700">
                                                Module permissions determine which sections of the application this user can see and access. 
                                                This works alongside role-based permissions for fine-grained access control.
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-6">
                                    @foreach ($modules as $module)
                                    <div class="col-md-6 col-lg-4">
                                        <label class="d-flex flex-stack cursor-pointer p-4 border border-dashed border-gray-300 rounded-3 hover-border-primary module-card" data-module-id="{{ $module->id }}">
                                            <span class="d-flex align-items-center">
                                                <span class="symbol symbol-50px me-4">
                                                    <span class="symbol-label bg-light-{{ ['primary', 'success', 'info', 'warning', 'danger'][$loop->index % 5] }}">
                                                        <i class="ki-duotone {{ $module->icon }} fs-1 text-{{ ['primary', 'success', 'info', 'warning', 'danger'][$loop->index % 5] }}">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                            <span class="path3"></span>
                                                        </i>
                                                    </span>
                                                </span>
                                                <span class="d-flex flex-column">
                                                    <span class="fw-bold fs-6">{{ $module->name }}</span>
                                                    <span class="fs-7 text-muted">{{ $module->description }}</span>
                                                </span>
                                            </span>
                                            <span class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input module-checkbox" 
                                                       type="checkbox" 
                                                       name="module_ids[]" 
                                                       value="{{ $module->id }}"
                                                       {{ $userModuleIds->contains($module->id) ? 'checked' : '' }}>
                                            </span>
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <!--end::Header Card-->
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
                                <p class="text-muted mb-3">{{ $user->email }}</p>
                                <span class="badge badge-light-{{ $user->is_active ? 'success' : 'danger' }} fs-7 mb-4">
                                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                                </span>
                                @if($user->userType)
                                <div class="d-flex justify-content-center align-items-center mb-4">
                                    <span class="badge badge-light-info fs-7">{{ $user->userType->name }}</span>
                                </div>
                                @endif
                                @if($user->roles && $user->roles->count() > 0)
                                <div class="d-flex flex-wrap justify-content-center gap-2">
                                    @foreach($user->roles as $role)
                                    <span class="badge badge-light-primary fs-8">{{ $role->name }}</span>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                        </div>
                        <!--end::User Profile Card-->

                        <!--begin::Summary Card-->
                        <div class="card card-flush mb-5 mb-xl-8">
                            <div class="card-header border-0 pt-6">
                                <div class="card-title">
                                    <h3 class="fw-bold mb-0">Access Summary</h3>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="d-flex flex-column">
                                    <div class="d-flex justify-content-between align-items-center py-3 border-bottom">
                                        <span class="text-muted fs-7">Total Modules</span>
                                        <span class="fw-bold fs-6 text-gray-800">{{ $modules->count() }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center py-3 border-bottom">
                                        <span class="text-muted fs-7">Enabled Modules</span>
                                        <span class="fw-bold fs-6 text-success" id="enabledCount">{{ $userModuleIds->count() }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center py-3">
                                        <span class="text-muted fs-7">Disabled Modules</span>
                                        <span class="fw-bold fs-6 text-danger" id="disabledCount">{{ $modules->count() - $userModuleIds->count() }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Summary Card-->

                        <!--begin::Actions Card-->
                        <div class="card card-flush">
                            <div class="card-body">
                                <div class="d-flex flex-column gap-3">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ki-duotone ki-check fs-3 me-1">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>Save Permissions
                                    </button>
                                    <a href="{{ route('user.users.show', $user->id) }}" class="btn btn-light">
                                        Cancel
                                    </a>
                                    <div class="separator separator-dashed my-2"></div>
                                    <a href="{{ route('user.users.edit', $user->id) }}" class="btn btn-light-primary">
                                        <i class="ki-duotone ki-pencil fs-3 me-1">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>Edit Profile
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
    const checkboxes = document.querySelectorAll('.module-checkbox');
    const selectAllBtn = document.getElementById('selectAll');
    const deselectAllBtn = document.getElementById('deselectAll');
    const enabledCount = document.getElementById('enabledCount');
    const disabledCount = document.getElementById('disabledCount');
    const totalModules = {{ $modules->count() }};

    function updateCounts() {
        const checked = document.querySelectorAll('.module-checkbox:checked').length;
        enabledCount.textContent = checked;
        disabledCount.textContent = totalModules - checked;
    }

    function updateCardStyle(checkbox) {
        const card = checkbox.closest('.module-card');
        if (checkbox.checked) {
            card.classList.add('border-primary', 'bg-light-primary');
            card.classList.remove('border-gray-300');
        } else {
            card.classList.remove('border-primary', 'bg-light-primary');
            card.classList.add('border-gray-300');
        }
    }

    checkboxes.forEach(function(checkbox) {
        // Initialize card styles
        updateCardStyle(checkbox);
        
        checkbox.addEventListener('change', function() {
            updateCounts();
            updateCardStyle(this);
        });
    });

    selectAllBtn.addEventListener('click', function() {
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = true;
            updateCardStyle(checkbox);
        });
        updateCounts();
    });

    deselectAllBtn.addEventListener('click', function() {
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = false;
            updateCardStyle(checkbox);
        });
        updateCounts();
    });

    // Make the entire card clickable
    document.querySelectorAll('.module-card').forEach(function(card) {
        card.addEventListener('click', function(e) {
            if (e.target.type !== 'checkbox') {
                const checkbox = this.querySelector('.module-checkbox');
                checkbox.checked = !checkbox.checked;
                checkbox.dispatchEvent(new Event('change'));
            }
        });
    });
});
</script>
@endpush

<style>
.module-card {
    transition: all 0.2s ease;
}
.module-card:hover {
    box-shadow: 0 0.5rem 1.5rem 0.5rem rgba(0, 0, 0, 0.075);
    transform: translateY(-2px);
}
.module-card.border-primary {
    background-color: rgba(var(--bs-primary-rgb), 0.05) !important;
}
</style>
