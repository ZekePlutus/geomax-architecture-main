@extends('layout50.master')

@section('title', 'Roles')

@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Roles
                        Management</h1>
                    <x-breadcrumb :items="[['label' => 'Users', 'url' => route('user.users.index')], ['label' => 'Roles']]" />
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <button type="button" class="btn btn-sm fw-bold btn-primary" data-bs-toggle="modal"
                        data-bs-target="#createRoleModal">
                        <i class="ki-outline ki-plus fs-4 me-1"></i>Create Role
                    </button>
                </div>
                <!--end::Actions-->
            </div>
        </div>
        <!--end::Toolbar-->

        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-xxl">
                @if (session('success'))
                    <div class="alert alert-success d-flex align-items-center p-5 mb-5">
                        <i class="ki-outline ki-shield-tick fs-2hx text-success me-4"></i>
                        <div class="d-flex flex-column">
                            <span>{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger d-flex align-items-center p-5 mb-5">
                        <i class="ki-outline ki-shield-cross fs-2hx text-danger me-4"></i>
                        <div class="d-flex flex-column">
                            <span>{{ session('error') }}</span>
                        </div>
                    </div>
                @endif

                <!--begin::System Roles-->
                <div class="card card-flush mb-6">
                    <div class="card-header border-0 pt-6">
                        <div class="card-title">
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-45px w-45px bg-light-primary me-4">
                                    <span class="symbol-label">
                                        <i class="ki-outline ki-crown fs-2 text-primary"></i>
                                    </span>
                                </div>
                                <div>
                                    <h3 class="fw-bold mb-0">System Roles</h3>
                                    <span class="text-muted fs-7">Default roles provided by the system</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        @if ($systemRoles->isEmpty())
                            <div class="text-center text-muted py-5">No system roles defined.</div>
                        @else
                            <div class="table-responsive">
                                <table class="table align-middle table-row-dashed fs-6 gy-5">
                                    <thead>
                                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                            <th class="min-w-200px">Role</th>
                                            <th class="min-w-150px">Description</th>
                                            <th class="min-w-100px text-center">Permissions</th>
                                            <th class="min-w-100px text-center">Users</th>
                                            <th class="text-end min-w-100px">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-600 fw-semibold">
                                        @foreach ($systemRoles as $role)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <span class="symbol symbol-35px me-3">
                                                            <span class="symbol-label bg-light-primary">
                                                                <i class="ki-outline ki-crown fs-5 text-primary"></i>
                                                            </span>
                                                        </span>
                                                        <div class="d-flex flex-column">
                                                            <a href="{{ route('user.roles.show', $role) }}"
                                                                class="text-gray-800 text-hover-primary fw-bold">{{ $role->name }}</a>
                                                            <span class="badge badge-light-primary fs-8 mt-1">System</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="text-gray-600">{{ $role->description ?? '—' }}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span
                                                        class="badge badge-light-info">{{ $role->permissions_count }}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge badge-light-success">{{ $role->users_count }}</span>
                                                </td>
                                                <td class="text-end">
                                                    <a href="{{ route('user.roles.show', $role) }}"
                                                        class="btn btn-sm btn-light btn-active-light-primary">
                                                        View
                                                    </a>
                                                    <a href="{{ route('user.roles.duplicate', $role) }}"
                                                        class="btn btn-sm btn-light btn-active-light-info"
                                                        onclick="return confirm('Create a copy of this role?')">
                                                        <i class="ki-outline ki-copy fs-5"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
                <!--end::System Roles-->

                <!--begin::Custom Roles-->
                <div class="card card-flush">
                    <div class="card-header border-0 pt-6">
                        <div class="card-title">
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-45px w-45px bg-light-success me-4">
                                    <span class="symbol-label">
                                        <i class="ki-outline ki-shield-tick fs-2 text-success"></i>
                                    </span>
                                </div>
                                <div>
                                    <h3 class="fw-bold mb-0">Custom Roles</h3>
                                    <span class="text-muted fs-7">Roles created by your organization</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-toolbar">
                            <a href="{{ route('user.roles.create') }}" class="btn btn-sm btn-light-primary">
                                <i class="ki-outline ki-plus fs-5 me-1"></i>New Role
                            </a>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        @if ($customRoles->isEmpty())
                            <div class="text-center py-10">
                                <div class="symbol symbol-100px symbol-circle mb-5">
                                    <span class="symbol-label bg-light-success">
                                        <i class="ki-outline ki-shield-tick fs-1 text-success"></i>
                                    </span>
                                </div>
                                <h3 class="fw-bold mb-2">No Custom Roles Yet</h3>
                                <p class="text-muted fs-6 mb-5">Create custom roles to define specific permissions for your
                                    team.</p>
                                <a href="{{ route('user.roles.create') }}" class="btn btn-primary">
                                    <i class="ki-outline ki-plus fs-4 me-1"></i>Create First Role
                                </a>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table align-middle table-row-dashed fs-6 gy-5">
                                    <thead>
                                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                            <th class="min-w-200px">Role</th>
                                            <th class="min-w-150px">Description</th>
                                            <th class="min-w-100px text-center">Permissions</th>
                                            <th class="min-w-100px text-center">Users</th>
                                            <th class="text-end min-w-150px">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-600 fw-semibold">
                                        @foreach ($customRoles as $role)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <span class="symbol symbol-35px me-3">
                                                            <span class="symbol-label bg-light-success">
                                                                <i class="ki-outline ki-shield-tick fs-5 text-success"></i>
                                                            </span>
                                                        </span>
                                                        <div class="d-flex flex-column">
                                                            <a href="{{ route('user.roles.show', $role) }}"
                                                                class="text-gray-800 text-hover-primary fw-bold">{{ $role->name }}</a>
                                                            <span class="text-muted fs-7">Custom Role</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="text-gray-600">{{ $role->description ?? '—' }}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span
                                                        class="badge badge-light-info">{{ $role->permissions_count }}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span
                                                        class="badge badge-light-success">{{ $role->users_count }}</span>
                                                </td>
                                                <td class="text-end">
                                                    <a href="{{ route('user.roles.show', $role) }}"
                                                        class="btn btn-sm btn-icon btn-light btn-active-light-primary"
                                                        data-bs-toggle="tooltip" title="View">
                                                        <i class="ki-outline ki-eye fs-5"></i>
                                                    </a>
                                                    <a href="{{ route('user.roles.edit', $role) }}"
                                                        class="btn btn-sm btn-icon btn-light btn-active-light-primary"
                                                        data-bs-toggle="tooltip" title="Edit">
                                                        <i class="ki-outline ki-pencil fs-5"></i>
                                                    </a>
                                                    <a href="{{ route('user.roles.duplicate', $role) }}"
                                                        class="btn btn-sm btn-icon btn-light btn-active-light-info"
                                                        data-bs-toggle="tooltip" title="Duplicate"
                                                        onclick="return confirm('Create a copy of this role?')">
                                                        <i class="ki-outline ki-copy fs-5"></i>
                                                    </a>
                                                    @if ($role->users_count == 0)
                                                        <form action="{{ route('user.roles.destroy', $role) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn btn-sm btn-icon btn-light btn-active-light-danger"
                                                                data-bs-toggle="tooltip" title="Delete"
                                                                onclick="return confirm('Are you sure you want to delete this role?')">
                                                                <i class="ki-outline ki-trash fs-5"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
                <!--end::Custom Roles-->
            </div>
        </div>
        <!--end::Content-->
    </div>

    {{-- Create Role Modal --}}
    @include('user::roles.partials.create-modal')
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Listen for new role creation from modal - reload page to show new role
            document.addEventListener('roleCreated', function(e) {
                window.location.reload();
            });
        });
    </script>
@endpush
