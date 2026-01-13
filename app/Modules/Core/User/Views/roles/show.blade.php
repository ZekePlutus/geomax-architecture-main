@extends('layout50.master')

@section('title', $role->name)

@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Role
                        Details</h1>
                    <x-breadcrumb :items="[
                        ['label' => 'Users', 'url' => route('user.users.index')],
                        ['label' => 'Roles', 'url' => route('user.roles.index')],
                        ['label' => $role->name],
                    ]" />
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <a href="{{ route('user.roles.index') }}" class="btn btn-sm fw-bold btn-secondary">
                        <i class="ki-outline ki-arrow-left fs-4 me-1"></i>Back to Roles
                    </a>
                    @if (!$role->isSystemRole())
                        <a href="{{ route('user.roles.edit', $role) }}" class="btn btn-sm fw-bold btn-primary">
                            <i class="ki-outline ki-pencil fs-4 me-1"></i>Edit Role
                        </a>
                    @endif
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

                <div class="row g-5 g-xl-8">
                    <!--begin::Left Column-->
                    <div class="col-xl-4">
                        <!--begin::Role Card-->
                        <div class="card card-flush mb-5 mb-xl-8">
                            <div class="card-body text-center pt-10">
                                <div class="symbol symbol-100px symbol-circle mb-7">
                                    <span
                                        class="symbol-label bg-light-{{ $role->isSystemRole() ? 'primary' : 'success' }} fs-1 fw-bold text-{{ $role->isSystemRole() ? 'primary' : 'success' }}">
                                        <i
                                            class="ki-outline ki-{{ $role->isSystemRole() ? 'crown' : 'shield-tick' }} fs-2x"></i>
                                    </span>
                                </div>
                                <h3 class="fs-2 fw-bold mb-1">{{ $role->name }}</h3>
                                <span
                                    class="badge badge-light-{{ $role->isSystemRole() ? 'primary' : 'success' }} fs-7 mb-4">
                                    {{ $role->isSystemRole() ? 'System Role' : 'Custom Role' }}
                                </span>
                                @if ($role->description)
                                    <p class="text-gray-500 fs-6 mb-5">{{ $role->description }}</p>
                                @endif

                                <div class="d-flex flex-wrap justify-content-center gap-4 mb-5">
                                    <div class="border border-dashed border-gray-300 rounded py-3 px-4">
                                        <div class="fs-2 fw-bold text-gray-800">{{ $role->permissions->count() }}</div>
                                        <div class="fs-7 text-muted">Permissions</div>
                                    </div>
                                    <div class="border border-dashed border-gray-300 rounded py-3 px-4">
                                        <div class="fs-2 fw-bold text-gray-800">{{ $role->users->count() }}</div>
                                        <div class="fs-7 text-muted">Users</div>
                                    </div>
                                </div>

                                @if (!$role->isSystemRole())
                                    <div class="d-flex flex-column gap-2">
                                        <a href="{{ route('user.roles.edit', $role) }}" class="btn btn-light-primary">
                                            <i class="ki-outline ki-pencil fs-4 me-1"></i>Edit Permissions
                                        </a>
                                        <a href="{{ route('user.roles.duplicate', $role) }}" class="btn btn-light"
                                            onclick="return confirm('Create a copy of this role?')">
                                            <i class="ki-outline ki-copy fs-4 me-1"></i>Duplicate Role
                                        </a>
                                    </div>
                                @else
                                    <a href="{{ route('user.roles.duplicate', $role) }}" class="btn btn-light-primary"
                                        onclick="return confirm('Create a customizable copy of this system role?')">
                                        <i class="ki-outline ki-copy fs-4 me-1"></i>Create Custom Copy
                                    </a>
                                @endif
                            </div>
                        </div>
                        <!--end::Role Card-->
                    </div>
                    <!--end::Left Column-->

                    <!--begin::Right Column-->
                    <div class="col-xl-8">
                        <!--begin::Permissions Card-->
                        <div class="card card-flush mb-5 mb-xl-8">
                            <div class="card-header border-0 pt-6">
                                <div class="card-title">
                                    <div class="d-flex align-items-center">
                                        <div class="symbol symbol-45px w-45px bg-light-success me-4">
                                            <span class="symbol-label">
                                                <i class="ki-outline ki-key fs-2 text-success"></i>
                                            </span>
                                        </div>
                                        <div>
                                            <h3 class="fw-bold mb-0">Assigned Permissions</h3>
                                            <span class="text-muted fs-7">What users with this role can do</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                @if ($role->permissions->isEmpty())
                                    <div class="text-center text-muted py-10">
                                        <i class="ki-outline ki-shield-cross fs-3x text-gray-400 mb-3"></i>
                                        <p>No permissions assigned to this role.</p>
                                    </div>
                                @else
                                    @foreach ($permissionsByModule as $module => $modulePermissions)
                                        <div class="mb-6">
                                            <div class="d-flex align-items-center mb-4">
                                                <span class="bullet bullet-vertical h-40px bg-primary me-3"></span>
                                                <div class="flex-grow-1">
                                                    <span class="text-gray-800 fw-bold fs-5">{{ ucfirst($module) }}
                                                        Module</span>
                                                    <span
                                                        class="badge badge-light-primary ms-2">{{ $modulePermissions->count() }}</span>
                                                </div>
                                            </div>
                                            <div class="row g-3 ms-6">
                                                @foreach ($modulePermissions as $permission)
                                                    <div class="col-md-6">
                                                        <div class="d-flex align-items-center bg-light-success rounded p-3">
                                                            <i
                                                                class="ki-outline ki-check-circle fs-4 text-success me-2"></i>
                                                            <div class="flex-grow-1">
                                                                <span
                                                                    class="text-gray-800 fw-semibold d-block">{{ $permission->name }}</span>
                                                                <span class="text-muted fs-8">{{ $permission->key }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <!--end::Permissions Card-->

                        <!--begin::Users Card-->
                        <div class="card card-flush">
                            <div class="card-header border-0 pt-6">
                                <div class="card-title">
                                    <div class="d-flex align-items-center">
                                        <div class="symbol symbol-45px w-45px bg-light-info me-4">
                                            <span class="symbol-label">
                                                <i class="ki-outline ki-people fs-2 text-info"></i>
                                            </span>
                                        </div>
                                        <div>
                                            <h3 class="fw-bold mb-0">Users with this Role</h3>
                                            <span class="text-muted fs-7">{{ $role->users->count() }} users assigned</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                @if ($role->users->isEmpty())
                                    <div class="text-center text-muted py-10">
                                        <i class="ki-outline ki-people fs-3x text-gray-400 mb-3"></i>
                                        <p>No users have been assigned this role yet.</p>
                                        <a href="{{ route('user.users.index') }}" class="btn btn-sm btn-light-primary">Go
                                            to Users</a>
                                    </div>
                                @else
                                    <div class="table-responsive">
                                        <table class="table align-middle table-row-dashed fs-6 gy-4">
                                            <thead>
                                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                                    <th>User</th>
                                                    <th>Email</th>
                                                    <th>Status</th>
                                                    <th class="text-end">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-gray-600 fw-semibold">
                                                @foreach ($role->users->take(10) as $user)
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="symbol symbol-35px me-3">
                                                                    <span
                                                                        class="symbol-label bg-light-primary text-primary fw-bold">
                                                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                                                    </span>
                                                                </div>
                                                                <span
                                                                    class="text-gray-800 fw-semibold">{{ $user->name }}</span>
                                                            </div>
                                                        </td>
                                                        <td>{{ $user->email }}</td>
                                                        <td>
                                                            <span
                                                                class="badge badge-light-{{ $user->is_active ? 'success' : 'danger' }}">
                                                                {{ $user->is_active ? 'Active' : 'Inactive' }}
                                                            </span>
                                                        </td>
                                                        <td class="text-end">
                                                            <a href="{{ route('user.users.show', $user) }}"
                                                                class="btn btn-sm btn-light btn-active-light-primary">
                                                                View
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @if ($role->users->count() > 10)
                                        <div class="text-center mt-4">
                                            <span class="text-muted fs-7">Showing 10 of {{ $role->users->count() }}
                                                users</span>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                        <!--end::Users Card-->
                    </div>
                    <!--end::Right Column-->
                </div>
            </div>
        </div>
        <!--end::Content-->
    </div>
@endsection
