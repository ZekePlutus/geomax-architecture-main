@extends('layout50.master')

@section('title', 'Users')

@section('content')
<!--begin::Toolbar-->
<div class="d-flex flex-wrap flex-stack mb-6">
    <!--begin::Title-->
    <h3 class="fw-bold my-2">
        Users
        <span class="fs-6 text-gray-500 fw-semibold ms-1">({{ $users->count() }})</span>
    </h3>
    <!--end::Title-->
    
    <!--begin::Actions-->
    <div class="d-flex flex-wrap my-2">
        <!--begin::Filter Status-->
        <div class="me-4">
            <select class="form-select form-select-sm form-select-solid w-125px" id="statusFilter" onchange="window.location.href=this.value">
                <option value="{{ route('user.users.index') }}" {{ $activeOnly === null ? 'selected' : '' }}>All Status</option>
                <option value="{{ route('user.users.index', ['active_only' => 1]) }}" {{ $activeOnly === true ? 'selected' : '' }}>Active</option>
                <option value="{{ route('user.users.index', ['active_only' => 0]) }}" {{ $activeOnly === false ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
        <!--end::Filter Status-->
        
        <!--begin::View Toggle-->
        <div class="btn-group me-4" role="group">
            <button type="button" class="btn btn-sm btn-icon btn-light-primary" id="viewGrid" data-bs-toggle="tooltip" title="Grid View">
                <i class="ki-outline ki-element-11 fs-4"></i>
            </button>
            <button type="button" class="btn btn-sm btn-icon btn-light" id="viewList" data-bs-toggle="tooltip" title="List View">
                <i class="ki-outline ki-row-horizontal fs-4"></i>
            </button>
        </div>
        <!--end::View Toggle-->
        
        <!--begin::Add User-->
        <a href="{{ route('user.users.create') }}" class="btn btn-sm btn-primary">
            <i class="ki-outline ki-plus fs-5"></i>
            Add User
        </a>
        <!--end::Add User-->
    </div>
    <!--end::Actions-->
</div>
<!--end::Toolbar-->

{{-- Flash Messages --}}
@if (session('success'))
    <div class="alert alert-success d-flex align-items-center p-5 mb-6">
        <i class="ki-outline ki-shield-tick fs-2hx text-success me-4"></i>
        <div class="d-flex flex-column">
            <span>{{ session('success') }}</span>
        </div>
        <button type="button" class="btn-close position-absolute end-0 top-50 translate-middle-y me-5" data-bs-dismiss="alert"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger d-flex align-items-center p-5 mb-6">
        <i class="ki-outline ki-shield-cross fs-2hx text-danger me-4"></i>
        <div class="d-flex flex-column">
            <span>{{ session('error') }}</span>
        </div>
        <button type="button" class="btn-close position-absolute end-0 top-50 translate-middle-y me-5" data-bs-dismiss="alert"></button>
    </div>
@endif

@if ($users->isEmpty())
    <!--begin::Empty State-->
    <div class="card">
        <div class="card-body p-0">
            <div class="text-center px-4 py-15">
                <div class="symbol symbol-100px symbol-circle mb-7 bg-light-primary">
                    <span class="symbol-label">
                        <i class="ki-outline ki-people fs-1 text-primary"></i>
                    </span>
                </div>
                <h2 class="fw-bold mb-3">No Users Found</h2>
                <p class="text-gray-500 fs-6 mb-7">
                    Get started by creating your first user account.
                </p>
                <a href="{{ route('user.users.create') }}" class="btn btn-primary">
                    <i class="ki-outline ki-plus fs-5 me-1"></i>
                    Create First User
                </a>
            </div>
        </div>
    </div>
    <!--end::Empty State-->
@else
    <!--begin::Grid View-->
    <div id="gridView" class="row g-6 g-xl-9">
        @foreach ($users as $user)
        <div class="col-md-6 col-xl-4">
            <!--begin::Card-->
            <div class="card border-hover-primary h-100">
                <!--begin::Card header-->
                <div class="card-header border-0 pt-9">
                    <!--begin::Card Title-->
                    <div class="card-title m-0">
                        <!--begin::Avatar-->
                        <div class="symbol symbol-50px symbol-circle w-50px bg-light-{{ $user->is_active ? 'success' : 'warning' }}">
                            <span class="symbol-label fs-2 fw-bold text-{{ $user->is_active ? 'success' : 'warning' }}">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </span>
                        </div>
                        <!--end::Avatar-->
                    </div>
                    <!--end::Card Title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <span class="badge badge-light-{{ $user->is_active ? 'success' : 'warning' }} fw-bold px-4 py-3">
                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body p-9">
                    <!--begin::Name-->
                    <div class="fs-3 fw-bold text-gray-900">
                        <a href="{{ route('user.users.show', $user->id) }}" class="text-gray-900 text-hover-primary">
                            {{ $user->name }}
                        </a>
                    </div>
                    <!--end::Name-->
                    <!--begin::Email-->
                    <p class="text-gray-500 fw-semibold fs-6 mt-1 mb-5">
                        {{ $user->email }}
                    </p>
                    <!--end::Email-->
                    <!--begin::Info-->
                    <div class="d-flex flex-wrap mb-5">
                        <!--begin::Type-->
                        <div class="border border-gray-300 border-dashed rounded min-w-100px py-3 px-4 me-3 mb-3">
                            <div class="fs-7 text-gray-500 fw-semibold">Type</div>
                            <div class="fs-6 fw-bold text-gray-700">{{ ucwords(str_replace('_', ' ', $user->userType?->name ?? 'N/A')) }}</div>
                        </div>
                        <!--end::Type-->
                        <!--begin::Last Login-->
                        <div class="border border-gray-300 border-dashed rounded min-w-100px py-3 px-4 mb-3">
                            <div class="fs-7 text-gray-500 fw-semibold">Last Login</div>
                            <div class="fs-6 fw-bold text-gray-700">{{ $user->last_login_at?->diffForHumans() ?? 'Never' }}</div>
                        </div>
                        <!--end::Last Login-->
                    </div>
                    <!--end::Info-->
                    <!--begin::Roles-->
                    <div class="mb-0">
                        @forelse ($user->roles as $role)
                            <span class="badge badge-light-{{ $role->is_system ? 'primary' : 'info' }} fs-8 fw-semibold me-1">
                                {{ $role->name }}
                            </span>
                        @empty
                            <span class="text-gray-500 fs-7">No roles assigned</span>
                        @endforelse
                    </div>
                    <!--end::Roles-->
                </div>
                <!--end::Card body-->
                <!--begin::Card footer-->
                <div class="card-footer d-flex flex-stack pt-0 border-0">
                    <a href="{{ route('user.users.show', $user->id) }}" class="btn btn-sm btn-light btn-active-light-primary">
                        <i class="ki-outline ki-eye fs-5 me-1"></i>View
                    </a>
                    <div class="d-flex">
                        <a href="{{ route('user.users.edit', $user->id) }}" class="btn btn-sm btn-icon btn-light-primary me-2" data-bs-toggle="tooltip" title="Edit">
                            <i class="ki-outline ki-pencil fs-5"></i>
                        </a>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-icon btn-light" type="button" data-bs-toggle="dropdown">
                                <i class="ki-outline ki-dots-horizontal fs-5"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-150px py-4">
                                <li class="menu-item px-3">
                                    <a class="menu-link px-3" href="{{ route('user.users.permissions', $user->id) }}">
                                        <i class="ki-outline ki-security-user fs-5 me-2"></i>Permissions
                                    </a>
                                </li>
                                <li class="menu-item px-3">
                                    <a class="menu-link px-3" href="{{ route('user.users.restrictions', $user->id) }}">
                                        <i class="ki-outline ki-shield-tick fs-5 me-2"></i>Restrictions
                                    </a>
                                </li>
                                <li class="menu-item px-3">
                                    @if ($user->is_active)
                                        <form action="{{ route('user.users.deactivate', $user->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="menu-link px-3 w-100 border-0 bg-transparent text-start">
                                                <i class="ki-outline ki-cross-circle fs-5 me-2 text-warning"></i>
                                                <span class="text-warning">Deactivate</span>
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('user.users.activate', $user->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="menu-link px-3 w-100 border-0 bg-transparent text-start">
                                                <i class="ki-outline ki-check-circle fs-5 me-2 text-success"></i>
                                                <span class="text-success">Activate</span>
                                            </button>
                                        </form>
                                    @endif
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!--end::Card footer-->
            </div>
            <!--end::Card-->
        </div>
        @endforeach
    </div>
    <!--end::Grid View-->

    <!--begin::List View-->
    <div id="listView" class="card" style="display: none;">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    <i class="ki-outline ki-magnifier fs-3 position-absolute ms-5"></i>
                    <input type="text" class="form-control form-control-solid w-250px ps-13" placeholder="Search users..." id="searchUsers"/>
                </div>
                <!--end::Search-->
            </div>
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body py-4">
            <!--begin::Table-->
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="usersTable">
                <thead>
                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                        <th class="min-w-200px">User</th>
                        <th class="min-w-125px">Type</th>
                        <th class="min-w-150px">Roles</th>
                        <th class="min-w-125px">Last Login</th>
                        <th class="min-w-100px">Status</th>
                        <th class="text-end min-w-100px">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 fw-semibold">
                    @foreach ($users as $user)
                    <tr>
                        <!--begin::User-->
                        <td class="d-flex align-items-center">
                            <!--begin::Avatar-->
                            <div class="symbol symbol-circle symbol-45px overflow-hidden me-3">
                                <div class="symbol-label bg-light-{{ $user->is_active ? 'success' : 'warning' }}">
                                    <span class="fs-5 fw-bold text-{{ $user->is_active ? 'success' : 'warning' }}">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </span>
                                </div>
                            </div>
                            <!--end::Avatar-->
                            <!--begin::User details-->
                            <div class="d-flex flex-column">
                                <a href="{{ route('user.users.show', $user->id) }}" class="text-gray-800 text-hover-primary mb-1">
                                    {{ $user->name }}
                                </a>
                                <span class="text-gray-500 fs-7">{{ $user->email }}</span>
                            </div>
                            <!--end::User details-->
                        </td>
                        <!--end::User-->
                        <!--begin::Type-->
                        <td>
                            <span class="badge badge-light-dark fs-7">
                                {{ ucwords(str_replace('_', ' ', $user->userType?->name ?? 'N/A')) }}
                            </span>
                        </td>
                        <!--end::Type-->
                        <!--begin::Roles-->
                        <td>
                            @forelse ($user->roles as $role)
                                <span class="badge badge-light-{{ $role->is_system ? 'primary' : 'info' }} fs-8 me-1">
                                    {{ $role->name }}
                                </span>
                            @empty
                                <span class="text-gray-500">—</span>
                            @endforelse
                        </td>
                        <!--end::Roles-->
                        <!--begin::Last Login-->
                        <td>
                            <span class="text-gray-600">{{ $user->last_login_at?->diffForHumans() ?? 'Never' }}</span>
                        </td>
                        <!--end::Last Login-->
                        <!--begin::Status-->
                        <td>
                            @if ($user->is_active)
                                <span class="badge badge-light-success fs-7 fw-bold">Active</span>
                            @else
                                <span class="badge badge-light-warning fs-7 fw-bold">Inactive</span>
                            @endif
                        </td>
                        <!--end::Status-->
                        <!--begin::Actions-->
                        <td class="text-end">
                            <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                Actions
                                <i class="ki-outline ki-down fs-5 ms-1"></i>
                            </a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-150px py-4" data-kt-menu="true">
                                <div class="menu-item px-3">
                                    <a href="{{ route('user.users.show', $user->id) }}" class="menu-link px-3">
                                        <i class="ki-outline ki-eye fs-5 me-2"></i>View
                                    </a>
                                </div>
                                <div class="menu-item px-3">
                                    <a href="{{ route('user.users.edit', $user->id) }}" class="menu-link px-3">
                                        <i class="ki-outline ki-pencil fs-5 me-2"></i>Edit
                                    </a>
                                </div>
                                <div class="menu-item px-3">
                                    <a href="{{ route('user.users.permissions', $user->id) }}" class="menu-link px-3">
                                        <i class="ki-outline ki-security-user fs-5 me-2"></i>Permissions
                                    </a>
                                </div>
                                <div class="menu-item px-3">
                                    <a href="{{ route('user.users.restrictions', $user->id) }}" class="menu-link px-3">
                                        <i class="ki-outline ki-shield-tick fs-5 me-2"></i>Restrictions
                                    </a>
                                </div>
                                <div class="separator my-2"></div>
                                <div class="menu-item px-3">
                                    @if ($user->is_active)
                                        <form action="{{ route('user.users.deactivate', $user->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="menu-link px-3 w-100 border-0 bg-transparent text-start text-warning">
                                                <i class="ki-outline ki-cross-circle fs-5 me-2"></i>Deactivate
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('user.users.activate', $user->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="menu-link px-3 w-100 border-0 bg-transparent text-start text-success">
                                                <i class="ki-outline ki-check-circle fs-5 me-2"></i>Activate
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                            <!--end::Menu-->
                        </td>
                        <!--end::Actions-->
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <!--end::Table-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::List View-->
@endif
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const gridView = document.getElementById('gridView');
    const listView = document.getElementById('listView');
    const gridBtn = document.getElementById('viewGrid');
    const listBtn = document.getElementById('viewList');
    
    // Load saved preference
    const savedView = localStorage.getItem('usersViewMode') || 'grid';
    if (savedView === 'list') {
        showListView();
    }
    
    gridBtn?.addEventListener('click', function() {
        showGridView();
        localStorage.setItem('usersViewMode', 'grid');
    });
    
    listBtn?.addEventListener('click', function() {
        showListView();
        localStorage.setItem('usersViewMode', 'list');
    });
    
    function showGridView() {
        gridView.style.display = '';
        listView.style.display = 'none';
        gridBtn.classList.remove('btn-light');
        gridBtn.classList.add('btn-light-primary');
        listBtn.classList.remove('btn-light-primary');
        listBtn.classList.add('btn-light');
    }
    
    function showListView() {
        gridView.style.display = 'none';
        listView.style.display = '';
        listBtn.classList.remove('btn-light');
        listBtn.classList.add('btn-light-primary');
        gridBtn.classList.remove('btn-light-primary');
        gridBtn.classList.add('btn-light');
    }
    
    // Search functionality for list view
    const searchInput = document.getElementById('searchUsers');
    searchInput?.addEventListener('keyup', function() {
        const value = this.value.toLowerCase();
        const rows = document.querySelectorAll('#usersTable tbody tr');
        rows.forEach(function(row) {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(value) ? '' : 'none';
        });
    });
});
</script>
@endpush
