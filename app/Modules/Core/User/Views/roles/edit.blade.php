@extends('layout50.master')

@section('title', 'Edit Role - ' . $role->name)

@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Edit
                        Role</h1>
                    <x-breadcrumb :items="[
                        ['label' => 'Users', 'url' => route('user.users.index')],
                        ['label' => 'Roles', 'url' => route('user.roles.index')],
                        ['label' => $role->name, 'url' => route('user.roles.show', $role)],
                        ['label' => 'Edit'],
                    ]" />
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <a href="{{ route('user.roles.show', $role) }}" class="btn btn-sm fw-bold btn-secondary">
                        <i class="ki-outline ki-arrow-left fs-4 me-1"></i>Back to Role
                    </a>
                </div>
                <!--end::Actions-->
            </div>
        </div>
        <!--end::Toolbar-->

        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-xxl">
                @if (session('error'))
                    <div class="alert alert-danger d-flex align-items-center p-5 mb-5">
                        <i class="ki-outline ki-shield-cross fs-2hx text-danger me-4"></i>
                        <div class="d-flex flex-column">
                            <span>{{ session('error') }}</span>
                        </div>
                    </div>
                @endif

                <form action="{{ route('user.roles.update', $role) }}" method="POST" class="form">
                    @csrf
                    @method('PUT')
                    <div class="row g-5 g-xl-8">
                        <!--begin::Left Column-->
                        <div class="col-xl-4">
                            <!--begin::Role Info Card-->
                            <div class="card card-flush mb-5 mb-xl-8">
                                <div class="card-header border-0 pt-6">
                                    <div class="card-title">
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-45px w-45px bg-light-primary me-4">
                                                <span class="symbol-label">
                                                    <i class="ki-outline ki-shield-tick fs-2 text-primary"></i>
                                                </span>
                                            </div>
                                            <div>
                                                <h3 class="fw-bold mb-0">Role Information</h3>
                                                <span class="text-muted fs-7">Update the role basics</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body pt-0">
                                    <div class="mb-6">
                                        <x-form.input.base name="name" label="Role Name"
                                            placeholder="e.g., Sales Manager" :value="$role->name"
                                            icon="ki-outline ki-shield-tick" size="lg" :required="true" />
                                    </div>
                                    <div class="mb-0">
                                        <label class="form-label">Description</label>
                                        <textarea name="description" class="form-control form-control-solid" rows="4"
                                            placeholder="Describe what this role is for...">{{ old('description', $role->description) }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <!--end::Role Info Card-->

                            <!--begin::Stats Card-->
                            <div class="card card-flush mb-5 mb-xl-8">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-5">
                                        <div class="symbol symbol-40px me-3">
                                            <span class="symbol-label bg-light-success">
                                                <i class="ki-outline ki-people fs-4 text-success"></i>
                                            </span>
                                        </div>
                                        <div>
                                            <div class="fs-5 fw-bold text-gray-800">{{ $role->users()->count() }}</div>
                                            <div class="fs-7 text-muted">Users with this role</div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="symbol symbol-40px me-3">
                                            <span class="symbol-label bg-light-info">
                                                <i class="ki-outline ki-key fs-4 text-info"></i>
                                            </span>
                                        </div>
                                        <div>
                                            <div class="fs-5 fw-bold text-gray-800" id="selectedCount">
                                                {{ count($rolePermissionIds) }}</div>
                                            <div class="fs-7 text-muted">Permissions selected</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Stats Card-->

                            <!--begin::Submit Card-->
                            <div class="card card-flush">
                                <div class="card-body">
                                    <div class="d-flex flex-column gap-3">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="ki-outline ki-check fs-4 me-1"></i>Save Changes
                                        </button>
                                        <a href="{{ route('user.roles.show', $role) }}" class="btn btn-light">Cancel</a>
                                    </div>
                                </div>
                            </div>
                            <!--end::Submit Card-->
                        </div>
                        <!--end::Left Column-->

                        <!--begin::Right Column-->
                        <div class="col-xl-8">
                            <!--begin::Permissions Card-->
                            <div class="card card-flush">
                                <div class="card-header border-0 pt-6">
                                    <div class="card-title">
                                        <div class="d-flex align-items-center">
                                            <div class="symbol symbol-45px w-45px bg-light-success me-4">
                                                <span class="symbol-label">
                                                    <i class="ki-outline ki-key fs-2 text-success"></i>
                                                </span>
                                            </div>
                                            <div>
                                                <h3 class="fw-bold mb-0">Permissions</h3>
                                                <span class="text-muted fs-7">Select what this role can do</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-toolbar">
                                        <button type="button" class="btn btn-sm btn-light-primary" id="selectAll">
                                            <i class="ki-outline ki-check-square fs-5 me-1"></i>Select All
                                        </button>
                                        <button type="button" class="btn btn-sm btn-light ms-2" id="deselectAll">
                                            <i class="ki-outline ki-cross-square fs-5 me-1"></i>Deselect All
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body pt-0">
                                    @if ($permissions->isEmpty())
                                        <div class="text-center text-muted py-10">
                                            <i class="ki-outline ki-information-5 fs-3x text-gray-400 mb-3"></i>
                                            <p>No permissions available.</p>
                                        </div>
                                    @else
                                        <div class="accordion" id="permissionsAccordion">
                                            @foreach ($permissions as $module => $modulePermissions)
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header">
                                                        <button
                                                            class="accordion-button {{ $loop->first ? '' : 'collapsed' }} fs-5 fw-semibold"
                                                            type="button" data-bs-toggle="collapse"
                                                            data-bs-target="#module_{{ $module }}">
                                                            <span class="d-flex align-items-center">
                                                                <i class="ki-outline ki-cube-2 fs-4 me-2 text-primary"></i>
                                                                {{ ucfirst($module) }} Module
                                                                <span
                                                                    class="badge badge-light-primary ms-2">{{ $modulePermissions->count() }}</span>
                                                            </span>
                                                        </button>
                                                    </h2>
                                                    <div id="module_{{ $module }}"
                                                        class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}"
                                                        data-bs-parent="#permissionsAccordion">
                                                        <div class="accordion-body">
                                                            <div class="d-flex justify-content-end mb-3">
                                                                <button type="button"
                                                                    class="btn btn-sm btn-light-primary select-module"
                                                                    data-module="{{ $module }}">
                                                                    Select All {{ ucfirst($module) }}
                                                                </button>
                                                            </div>
                                                            <div class="row g-4">
                                                                @foreach ($modulePermissions as $permission)
                                                                    <div class="col-md-6">
                                                                        <label
                                                                            class="form-check form-check-custom form-check-solid form-check-sm">
                                                                            <input
                                                                                class="form-check-input permission-checkbox"
                                                                                type="checkbox" name="permissions[]"
                                                                                value="{{ $permission->id }}"
                                                                                data-module="{{ $module }}"
                                                                                {{ in_array($permission->id, old('permissions', $rolePermissionIds)) ? 'checked' : '' }}>
                                                                            <span
                                                                                class="form-check-label d-flex flex-column">
                                                                                <span
                                                                                    class="fw-semibold text-gray-800">{{ $permission->name }}</span>
                                                                                <span
                                                                                    class="text-muted fs-7">{{ $permission->key }}</span>
                                                                            </span>
                                                                        </label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <!--end::Permissions Card-->
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
            const updateCount = () => {
                const count = document.querySelectorAll('.permission-checkbox:checked').length;
                document.getElementById('selectedCount').textContent = count;
            };

            // Select All
            document.getElementById('selectAll').addEventListener('click', function() {
                document.querySelectorAll('.permission-checkbox').forEach(cb => cb.checked = true);
                updateCount();
            });

            // Deselect All
            document.getElementById('deselectAll').addEventListener('click', function() {
                document.querySelectorAll('.permission-checkbox').forEach(cb => cb.checked = false);
                updateCount();
            });

            // Select Module
            document.querySelectorAll('.select-module').forEach(btn => {
                btn.addEventListener('click', function() {
                    const module = this.dataset.module;
                    document.querySelectorAll(`.permission-checkbox[data-module="${module}"]`)
                        .forEach(cb => cb.checked = true);
                    updateCount();
                });
            });

            // Update count on individual checkbox change
            document.querySelectorAll('.permission-checkbox').forEach(cb => {
                cb.addEventListener('change', updateCount);
            });
        });
    </script>
@endpush
