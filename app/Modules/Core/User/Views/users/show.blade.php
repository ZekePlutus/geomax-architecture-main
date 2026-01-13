@extends('layout50.master')

@section('title', $user->name)

@section('content')
<div class="d-flex flex-column flex-column-fluid">
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">User Profile</h1>
                <x-breadcrumb :items="[
                    ['label' => 'Users', 'url' => route('user.users.index')],
                    ['label' => $user->name]
                ]" />
            </div>
            <!--end::Page title-->
            <!--begin::Actions-->
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <a href="{{ route('user.users.index') }}" class="btn btn-sm fw-bold btn-secondary">
                    <i class="ki-duotone ki-arrow-left fs-4 me-1"></i>Back to List
                </a>
                <a href="{{ route('user.users.edit', $user->id) }}" class="btn btn-sm fw-bold btn-primary">
                    <i class="ki-duotone ki-pencil fs-4 me-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>Edit User
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

            <div class="row g-5 g-xl-8">
                <!--begin::Left Column-->
                <div class="col-xl-4">
                    <!--begin::Profile Card-->
                    <div class="card card-flush mb-5 mb-xl-8">
                        <div class="card-body text-center pt-10">
                            <div class="symbol symbol-150px symbol-circle mb-7">
                                <span class="symbol-label bg-light-primary fs-2x fw-bold text-primary">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </span>
                            </div>
                            <h3 class="fs-2 fw-bold mb-1">{{ $user->name }}</h3>
                            <p class="text-gray-500 fs-6 mb-4">{{ $user->email }}</p>
                            
                            <div class="d-flex flex-wrap justify-content-center gap-2 mb-5">
                                @if($user->userType)
                                <span class="badge badge-light-info fs-7 px-4 py-2">{{ $user->userType->name }}</span>
                                @endif
                                <span class="badge badge-light-{{ $user->is_active ? 'success' : 'danger' }} fs-7 px-4 py-2">
                                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>

                            @if($user->company)
                            <div class="d-flex align-items-center justify-content-center mb-5">
                                <i class="ki-duotone ki-office-bag fs-4 text-gray-500 me-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                <span class="text-gray-600">{{ $user->company->name }}</span>
                            </div>
                            @endif
                        </div>

                        <div class="card-footer border-0 pt-0">
                            <div class="d-flex flex-column gap-3">
                                @if ($user->is_active)
                                <form action="{{ route('user.users.deactivate', $user->id) }}" method="POST" class="w-100">
                                    @csrf
                                    <button type="submit" class="btn btn-light-danger w-100" 
                                            onclick="return confirm('Are you sure you want to deactivate this user?')">
                                        <i class="ki-duotone ki-cross-circle fs-3 me-1">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>Deactivate
                                    </button>
                                </form>
                                @else
                                <form action="{{ route('user.users.activate', $user->id) }}" method="POST" class="w-100">
                                    @csrf
                                    <button type="submit" class="btn btn-light-success w-100">
                                        <i class="ki-duotone ki-check-circle fs-3 me-1">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>Activate
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!--end::Profile Card-->

                    <!--begin::Details Card-->
                    <div class="card card-flush mb-5 mb-xl-8">
                        <div class="card-header border-0 pt-6">
                            <div class="card-title">
                                <h3 class="fw-bold mb-0">Details</h3>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="d-flex flex-column">
                                @if($user->phone)
                                <div class="d-flex justify-content-between py-4 border-bottom">
                                    <span class="text-gray-600 fs-6">Phone</span>
                                    <span class="fw-semibold fs-6 text-gray-800">{{ $user->phone }}</span>
                                </div>
                                @endif
                                <div class="d-flex justify-content-between py-4 border-bottom">
                                    <span class="text-gray-600 fs-6">Member Since</span>
                                    <span class="fw-semibold fs-6 text-gray-800">{{ $user->created_at ? $user->created_at->format('M d, Y') : 'N/A' }}</span>
                                </div>
                                <div class="d-flex justify-content-between py-4">
                                    <span class="text-gray-600 fs-6">Last Login</span>
                                    <span class="fw-semibold fs-6 text-gray-800">{{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Details Card-->
                </div>
                <!--end::Left Column-->

                <!--begin::Right Column-->
                <div class="col-xl-8">
                    <!--begin::Roles Card-->
                    <div class="card card-flush mb-5 mb-xl-8">
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
                                        <h3 class="fw-bold mb-0">Assigned Roles</h3>
                                        <span class="text-muted fs-7">User's access level and role assignments</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-toolbar">
                                <a href="{{ route('user.users.edit', $user->id) }}" class="btn btn-sm btn-light-primary">
                                    <i class="ki-duotone ki-pencil fs-4 me-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>Manage Roles
                                </a>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            @if ($user->roles->isEmpty())
                            <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed p-6">
                                <i class="ki-duotone ki-information fs-2tx text-warning me-4">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>
                                <div class="d-flex flex-stack flex-grow-1">
                                    <div class="fw-semibold">
                                        <div class="fs-6 text-gray-700">No roles have been assigned to this user yet.</div>
                                    </div>
                                </div>
                            </div>
                            @else
                            <div class="row g-4">
                                @foreach ($user->roles as $role)
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center p-4 border border-dashed border-gray-300 rounded">
                                        <span class="symbol symbol-40px me-4">
                                            <span class="symbol-label bg-light-{{ $role->is_system ? 'primary' : 'info' }}">
                                                <i class="ki-duotone ki-{{ $role->is_system ? 'crown' : 'user-tick' }} fs-3 text-{{ $role->is_system ? 'primary' : 'info' }}">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                </i>
                                            </span>
                                        </span>
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold fs-6">{{ $role->name }}</span>
                                            @if($role->is_system)
                                            <span class="badge badge-light-primary fs-8 w-50px">System</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <p class="text-muted small mt-4 mb-0">
                                <i class="ki-duotone ki-information fs-6 me-1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>
                                Roles represent intent. Effective permissions are resolved at runtime by the Execution Gate.
                            </p>
                            @endif
                        </div>
                    </div>
                    <!--end::Roles Card-->

                    <!--begin::Permissions Card-->
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
                                        <h3 class="fw-bold mb-0">Module Permissions</h3>
                                        <span class="text-muted fs-7">Control which modules this user can access</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-toolbar">
                                <a href="{{ route('user.users.permissions', $user->id) }}" class="btn btn-sm btn-light-info">
                                    <i class="ki-duotone ki-security-user fs-4 me-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>Manage Permissions
                                </a>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="notice d-flex bg-light-info rounded border-info border border-dashed p-6">
                                <i class="ki-duotone ki-abstract-26 fs-2tx text-info me-4">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                <div class="d-flex flex-stack flex-grow-1">
                                    <div class="fw-semibold">
                                        <div class="fs-6 text-gray-700">Configure which application modules this user can view and interact with.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Permissions Card-->

                    <!--begin::Restrictions Card-->
                    <div class="card card-flush">
                        <div class="card-header border-0 pt-6">
                            <div class="card-title">
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-45px w-45px bg-light-warning me-4">
                                        <span class="symbol-label">
                                            <i class="ki-duotone ki-shield-cross fs-2 text-warning">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                        </span>
                                    </div>
                                    <div>
                                        <h3 class="fw-bold mb-0">Restrictions</h3>
                                        <span class="text-muted fs-7">Access restrictions applied to this user</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-toolbar">
                                <a href="{{ route('user.users.restrictions', $user->id) }}" class="btn btn-sm btn-light-warning">
                                    <i class="ki-duotone ki-shield-cross fs-4 me-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>Manage
                                </a>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            @if ($user->restrictions->isEmpty())
                            <div class="notice d-flex bg-light-success rounded border-success border border-dashed p-6">
                                <i class="ki-duotone ki-check-circle fs-2tx text-success me-4">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                <div class="d-flex flex-stack flex-grow-1">
                                    <div class="fw-semibold">
                                        <div class="fs-6 text-gray-700">No restrictions have been applied to this user.</div>
                                    </div>
                                </div>
                            </div>
                            @else
                            <div class="table-responsive">
                                <table class="table table-row-bordered align-middle gy-4">
                                    <thead>
                                        <tr class="fw-bold text-muted">
                                            <th>Type</th>
                                            <th>Details</th>
                                            <th>Created</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($user->restrictions as $restriction)
                                        <tr>
                                            <td>
                                                <span class="badge badge-light-warning fs-7">
                                                    {{ ucwords(str_replace('_', ' ', $restriction->restriction_type)) }}
                                                </span>
                                            </td>
                                            <td class="text-gray-600">
                                                @if(is_array($restriction->restriction_value))
                                                    {{ count($restriction->restriction_value) }} item(s)
                                                @else
                                                    {{ json_encode($restriction->restriction_value) }}
                                                @endif
                                            </td>
                                            <td class="text-gray-500">
                                                {{ $restriction->created_at ? $restriction->created_at->format('M d, Y') : 'N/A' }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @endif
                        </div>
                    </div>
                    <!--end::Restrictions Card-->
                </div>
                <!--end::Right Column-->
            </div>
        </div>
    </div>
    <!--end::Content-->
</div>
@endsection
