@extends('layout50.master')

@section('title', 'Access Restrictions - ' . $user->name)

@section('content')
<div class="d-flex flex-column flex-column-fluid">
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Access Restrictions</h1>
                <x-breadcrumb :items="[
                    ['label' => 'Users', 'url' => route('user.users.index')],
                    ['label' => $user->name, 'url' => route('user.users.show', $user->id)],
                    ['label' => 'Restrictions']
                ]" />
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

            @if(session('error'))
            <div class="alert alert-danger d-flex align-items-center p-5 mb-5">
                <i class="ki-duotone ki-shield-cross fs-2hx text-danger me-4">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
                <div class="d-flex flex-column">
                    <span>{{ session('error') }}</span>
                </div>
            </div>
            @endif

            <div class="row g-5 g-xl-8">
                <!--begin::Left Column - Restrictions-->
                <div class="col-xl-8">
                    <!--begin::Add Restriction Card-->
                    <div class="card card-flush mb-5 mb-xl-8">
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
                                        <h3 class="fw-bold mb-0">Add New Restriction</h3>
                                        <span class="text-muted fs-7">Select restriction type to limit {{ $user->name }}'s access</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed p-6 mb-6">
                                <i class="ki-duotone ki-information fs-2tx text-warning me-4">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>
                                <div class="d-flex flex-stack flex-grow-1">
                                    <div class="fw-semibold">
                                        <div class="fs-6 text-gray-700">
                                            Restrictions limit what resources a user can access. Select a restriction type and 
                                            configure the specific values to apply limits on vehicles, locations, time windows, or sub-accounts.
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <form action="{{ route('user.users.restrictions.add', $user->id) }}" method="POST" id="addRestrictionForm">
                                @csrf
                                <input type="hidden" name="restriction_type" id="selectedRestrictionType" value="{{ old('restriction_type') }}">
                                
                                <h6 class="fw-semibold text-gray-600 mb-4">SELECT RESTRICTION TYPE</h6>
                                <div class="row g-4 mb-6">
                                    @php
                                        $restrictionIcons = [
                                            'vehicle' => ['icon' => 'ki-car', 'color' => 'primary', 'desc' => 'Limit access to specific vehicles only'],
                                            'geofence' => ['icon' => 'ki-geolocation', 'color' => 'success', 'desc' => 'Restrict to specific geographic zones'],
                                            'time' => ['icon' => 'ki-time', 'color' => 'info', 'desc' => 'Set time-based access windows'],
                                            'sub_account' => ['icon' => 'ki-people', 'color' => 'warning', 'desc' => 'Limit to specific sub-accounts'],
                                        ];
                                    @endphp
                                    @foreach ($restrictionTypes as $value => $label)
                                    @php $iconData = $restrictionIcons[$value] ?? ['icon' => 'ki-shield', 'color' => 'secondary', 'desc' => '']; @endphp
                                    <div class="col-md-6">
                                        <label class="d-flex flex-stack cursor-pointer p-4 border border-dashed border-gray-300 rounded-3 hover-border-{{ $iconData['color'] }} restriction-card" data-type="{{ $value }}">
                                            <span class="d-flex align-items-center">
                                                <span class="symbol symbol-50px me-4">
                                                    <span class="symbol-label bg-light-{{ $iconData['color'] }}">
                                                        <i class="ki-duotone {{ $iconData['icon'] }} fs-1 text-{{ $iconData['color'] }}">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                            <span class="path3"></span>
                                                        </i>
                                                    </span>
                                                </span>
                                                <span class="d-flex flex-column">
                                                    <span class="fw-bold fs-6">{{ $label }}</span>
                                                    <span class="fs-7 text-muted">{{ $iconData['desc'] }}</span>
                                                </span>
                                            </span>
                                            <span class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input restriction-radio" 
                                                       type="radio" 
                                                       name="restriction_type_radio" 
                                                       value="{{ $value }}"
                                                       {{ old('restriction_type') == $value ? 'checked' : '' }}>
                                            </span>
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                                @error('restriction_type')
                                    <div class="text-danger small mb-4">{{ $message }}</div>
                                @enderror

                                <!--begin::Dynamic Value Input-->
                                <div id="restrictionValueSection" style="display: {{ old('restriction_type') ? 'block' : 'none' }};">
                                    <div class="separator separator-dashed my-6"></div>
                                    <h6 class="fw-semibold text-gray-600 mb-4">CONFIGURE RESTRICTION VALUE</h6>
                                    
                                    <!--begin::Vehicle Input-->
                                    <div class="restriction-input" id="vehicleInput" style="display: none;">
                                        <label class="form-label fs-6 fw-semibold">Vehicle IDs</label>
                                        <input type="text" class="form-control form-control-lg" name="vehicle_ids" 
                                               placeholder="Enter vehicle IDs separated by commas (e.g., 101, 102, 103)">
                                        <div class="form-text">Specify which vehicles this user can access</div>
                                    </div>
                                    
                                    <!--begin::Geofence Input-->
                                    <div class="restriction-input" id="geofenceInput" style="display: none;">
                                        <label class="form-label fs-6 fw-semibold">Geofence Zone</label>
                                        <select class="form-select form-select-lg" name="geofence_zone">
                                            <option value="">Select a zone</option>
                                            <option value="north">North Zone</option>
                                            <option value="south">South Zone</option>
                                            <option value="east">East Zone</option>
                                            <option value="west">West Zone</option>
                                            <option value="central">Central Zone</option>
                                        </select>
                                        <div class="form-text">Restrict user to specific geographic zone</div>
                                    </div>
                                    
                                    <!--begin::Time Input-->
                                    <div class="restriction-input" id="timeInput" style="display: none;">
                                        <div class="row g-4">
                                            <div class="col-md-6">
                                                <label class="form-label fs-6 fw-semibold">Start Time</label>
                                                <input type="time" class="form-control form-control-lg" name="time_start" value="06:00">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fs-6 fw-semibold">End Time</label>
                                                <input type="time" class="form-control form-control-lg" name="time_end" value="18:00">
                                            </div>
                                        </div>
                                        <div class="form-text mt-2">User can only access the system during these hours</div>
                                    </div>
                                    
                                    <!--begin::Sub-Account Input-->
                                    <div class="restriction-input" id="subAccountInput" style="display: none;">
                                        <label class="form-label fs-6 fw-semibold">Sub-Account IDs</label>
                                        <input type="text" class="form-control form-control-lg" name="sub_account_ids" 
                                               placeholder="Enter sub-account IDs separated by commas">
                                        <div class="form-text">Limit user to specific sub-accounts only</div>
                                    </div>
                                    
                                    <!--begin::JSON Fallback-->
                                    <div class="restriction-input" id="jsonInput" style="display: none;">
                                        <label class="form-label fs-6 fw-semibold">Restriction Value (JSON)</label>
                                        <textarea class="form-control" name="restriction_value_json" rows="4" 
                                                  placeholder='{"ids": [1, 2, 3]}'>{{ old('restriction_value') }}</textarea>
                                        <div class="form-text">Enter restriction configuration in JSON format</div>
                                    </div>
                                    
                                    <input type="hidden" name="restriction_value" id="restrictionValueHidden">
                                </div>
                                <!--end::Dynamic Value Input-->

                                <div class="separator separator-dashed my-6"></div>
                                
                                <button type="submit" class="btn btn-warning" id="addRestrictionBtn" disabled>
                                    <i class="ki-duotone ki-shield-cross fs-3 me-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>Add Restriction
                                </button>
                            </form>
                        </div>
                    </div>
                    <!--end::Add Restriction Card-->

                    <!--begin::Current Restrictions Card-->
                    <div class="card card-flush">
                        <div class="card-header border-0 pt-6">
                            <div class="card-title">
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-45px w-45px bg-light-danger me-4">
                                        <span class="symbol-label">
                                            <i class="ki-duotone ki-lock-2 fs-2 text-danger">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                            </i>
                                        </span>
                                    </div>
                                    <div>
                                        <h3 class="fw-bold mb-0">Active Restrictions</h3>
                                        <span class="text-muted fs-7">{{ $user->restrictions->count() }} restriction(s) currently applied</span>
                                    </div>
                                </div>
                            </div>
                            @if($user->restrictions->count() > 0)
                            <div class="card-toolbar">
                                <span class="badge badge-light-danger fs-7">{{ $user->restrictions->count() }} Active</span>
                            </div>
                            @endif
                        </div>
                        <div class="card-body pt-0">
                            @if($user->restrictions->isEmpty())
                                <div class="d-flex flex-column align-items-center py-10">
                                    <div class="symbol symbol-100px mb-5">
                                        <span class="symbol-label bg-light-success">
                                            <i class="ki-duotone ki-shield-tick fs-3x text-success">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                        </span>
                                    </div>
                                    <h4 class="fw-bold text-gray-800 mb-2">No Restrictions</h4>
                                    <p class="text-muted text-center mb-0">
                                        This user has full access with no restrictions.<br>
                                        Add restrictions above to limit their access.
                                    </p>
                                </div>
                            @else
                                <div class="row g-4">
                                    @foreach ($user->restrictions as $restriction)
                                    @php 
                                        $iconData = $restrictionIcons[$restriction->restriction_type] ?? ['icon' => 'ki-shield', 'color' => 'secondary', 'desc' => '']; 
                                    @endphp
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center p-4 border border-dashed border-gray-300 rounded-3 position-relative">
                                            <span class="symbol symbol-50px me-4">
                                                <span class="symbol-label bg-light-{{ $iconData['color'] }}">
                                                    <i class="ki-duotone {{ $iconData['icon'] }} fs-1 text-{{ $iconData['color'] }}">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                    </i>
                                                </span>
                                            </span>
                                            <div class="flex-grow-1">
                                                <span class="fw-bold fs-6 d-block mb-1">
                                                    {{ $restrictionTypes[$restriction->restriction_type] ?? ucwords(str_replace('_', ' ', $restriction->restriction_type)) }}
                                                </span>
                                                <span class="fs-7 text-muted d-block mb-1">
                                                    @if(is_array($restriction->restriction_value))
                                                        @if(isset($restriction->restriction_value['ids']))
                                                            IDs: {{ implode(', ', $restriction->restriction_value['ids']) }}
                                                        @elseif(isset($restriction->restriction_value['zone']))
                                                            Zone: {{ ucfirst($restriction->restriction_value['zone']) }}
                                                        @elseif(isset($restriction->restriction_value['hours']))
                                                            Hours: {{ $restriction->restriction_value['hours'] }}
                                                        @else
                                                            {{ json_encode($restriction->restriction_value) }}
                                                        @endif
                                                    @else
                                                        {{ $restriction->restriction_value }}
                                                    @endif
                                                </span>
                                                <span class="badge badge-light-secondary fs-8">Added {{ $restriction->created_at->diffForHumans() }}</span>
                                            </div>
                                            <form action="{{ route('user.users.restrictions.remove', [$user->id, $restriction->id]) }}" 
                                                  method="POST" 
                                                  class="position-absolute top-0 end-0 mt-2 me-2">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-icon btn-light-danger"
                                                        onclick="return confirm('Remove this restriction?')"
                                                        title="Remove restriction">
                                                    <i class="ki-duotone ki-trash fs-4">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                        <span class="path4"></span>
                                                        <span class="path5"></span>
                                                    </i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                    <!--end::Current Restrictions Card-->
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
                                <h3 class="fw-bold mb-0">Restriction Summary</h3>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="d-flex flex-column">
                                @php
                                    $vehicleCount = $user->restrictions->where('restriction_type', 'vehicle')->count();
                                    $geofenceCount = $user->restrictions->where('restriction_type', 'geofence')->count();
                                    $timeCount = $user->restrictions->where('restriction_type', 'time')->count();
                                    $subAccountCount = $user->restrictions->where('restriction_type', 'sub_account')->count();
                                @endphp
                                <div class="d-flex justify-content-between align-items-center py-3 border-bottom">
                                    <span class="d-flex align-items-center">
                                        <i class="ki-duotone ki-car text-primary fs-4 me-2"><span class="path1"></span><span class="path2"></span></i>
                                        <span class="text-muted fs-7">Vehicle</span>
                                    </span>
                                    <span class="fw-bold fs-6 {{ $vehicleCount > 0 ? 'text-danger' : 'text-success' }}">{{ $vehicleCount }}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center py-3 border-bottom">
                                    <span class="d-flex align-items-center">
                                        <i class="ki-duotone ki-geolocation text-success fs-4 me-2"><span class="path1"></span><span class="path2"></span></i>
                                        <span class="text-muted fs-7">Geofence</span>
                                    </span>
                                    <span class="fw-bold fs-6 {{ $geofenceCount > 0 ? 'text-danger' : 'text-success' }}">{{ $geofenceCount }}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center py-3 border-bottom">
                                    <span class="d-flex align-items-center">
                                        <i class="ki-duotone ki-time text-info fs-4 me-2"><span class="path1"></span><span class="path2"></span></i>
                                        <span class="text-muted fs-7">Time</span>
                                    </span>
                                    <span class="fw-bold fs-6 {{ $timeCount > 0 ? 'text-danger' : 'text-success' }}">{{ $timeCount }}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center py-3">
                                    <span class="d-flex align-items-center">
                                        <i class="ki-duotone ki-people text-warning fs-4 me-2"><span class="path1"></span><span class="path2"></span></i>
                                        <span class="text-muted fs-7">Sub-Account</span>
                                    </span>
                                    <span class="fw-bold fs-6 {{ $subAccountCount > 0 ? 'text-danger' : 'text-success' }}">{{ $subAccountCount }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Summary Card-->

                    <!--begin::Actions Card-->
                    <div class="card card-flush">
                        <div class="card-body">
                            <div class="d-flex flex-column gap-3">
                                <a href="{{ route('user.users.permissions', $user->id) }}" class="btn btn-primary">
                                    <i class="ki-duotone ki-security-user fs-3 me-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>Module Permissions
                                </a>
                                <a href="{{ route('user.users.show', $user->id) }}" class="btn btn-light">
                                    View Profile
                                </a>
                                <div class="separator separator-dashed my-2"></div>
                                <a href="{{ route('user.users.edit', $user->id) }}" class="btn btn-light-primary">
                                    <i class="ki-duotone ki-pencil fs-3 me-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>Edit Profile
                                </a>
                            </div>
                        </div>
                    </div>
                    <!--end::Actions Card-->
                </div>
                <!--end::Right Column-->
            </div>
        </div>
    </div>
    <!--end::Content-->
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const restrictionCards = document.querySelectorAll('.restriction-card');
    const restrictionRadios = document.querySelectorAll('.restriction-radio');
    const valueSection = document.getElementById('restrictionValueSection');
    const selectedTypeInput = document.getElementById('selectedRestrictionType');
    const addBtn = document.getElementById('addRestrictionBtn');
    const form = document.getElementById('addRestrictionForm');
    
    const inputMappings = {
        'vehicle': 'vehicleInput',
        'geofence': 'geofenceInput',
        'time': 'timeInput',
        'sub_account': 'subAccountInput'
    };

    function updateCardStyles() {
        restrictionCards.forEach(card => {
            const radio = card.querySelector('.restriction-radio');
            const type = card.dataset.type;
            const colorClass = {
                'vehicle': 'primary',
                'geofence': 'success',
                'time': 'info',
                'sub_account': 'warning'
            }[type] || 'secondary';
            
            if (radio.checked) {
                card.classList.add('border-' + colorClass, 'bg-light-' + colorClass);
                card.classList.remove('border-gray-300');
            } else {
                card.classList.remove('border-primary', 'border-success', 'border-info', 'border-warning', 
                                      'bg-light-primary', 'bg-light-success', 'bg-light-info', 'bg-light-warning');
                card.classList.add('border-gray-300');
            }
        });
    }

    function showValueInput(type) {
        // Hide all inputs
        document.querySelectorAll('.restriction-input').forEach(el => el.style.display = 'none');
        
        // Show the appropriate input
        if (type && inputMappings[type]) {
            document.getElementById(inputMappings[type]).style.display = 'block';
            valueSection.style.display = 'block';
            addBtn.disabled = false;
        } else if (type) {
            document.getElementById('jsonInput').style.display = 'block';
            valueSection.style.display = 'block';
            addBtn.disabled = false;
        } else {
            valueSection.style.display = 'none';
            addBtn.disabled = true;
        }
    }

    // Handle card clicks
    restrictionCards.forEach(card => {
        card.addEventListener('click', function(e) {
            if (e.target.type !== 'radio') {
                const radio = this.querySelector('.restriction-radio');
                radio.checked = true;
                radio.dispatchEvent(new Event('change'));
            }
        });
    });

    // Handle radio changes
    restrictionRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            selectedTypeInput.value = this.value;
            updateCardStyles();
            showValueInput(this.value);
        });
        
        // Initialize if already checked
        if (radio.checked) {
            selectedTypeInput.value = radio.value;
            updateCardStyles();
            showValueInput(radio.value);
        }
    });

    // Form submission - build JSON value
    form.addEventListener('submit', function(e) {
        const type = selectedTypeInput.value;
        let value = {};
        
        try {
            switch(type) {
                case 'vehicle':
                    const vehicleIds = document.querySelector('input[name="vehicle_ids"]').value;
                    value = { ids: vehicleIds.split(',').map(id => parseInt(id.trim())).filter(id => !isNaN(id)) };
                    break;
                case 'geofence':
                    const zone = document.querySelector('select[name="geofence_zone"]').value;
                    value = { zone: zone };
                    break;
                case 'time':
                    const start = document.querySelector('input[name="time_start"]').value;
                    const end = document.querySelector('input[name="time_end"]').value;
                    value = { hours: start + '-' + end };
                    break;
                case 'sub_account':
                    const subIds = document.querySelector('input[name="sub_account_ids"]').value;
                    value = { ids: subIds.split(',').map(id => parseInt(id.trim())).filter(id => !isNaN(id)) };
                    break;
                default:
                    const jsonInput = document.querySelector('textarea[name="restriction_value_json"]').value;
                    value = JSON.parse(jsonInput);
            }
            
            document.getElementById('restrictionValueHidden').value = JSON.stringify(value);
        } catch (err) {
            e.preventDefault();
            alert('Invalid input. Please check your values.');
        }
    });

    // Initialize styles
    updateCardStyles();
});
</script>
@endpush

<style>
.restriction-card {
    transition: all 0.2s ease;
}
.restriction-card:hover {
    box-shadow: 0 0.5rem 1.5rem 0.5rem rgba(0, 0, 0, 0.075);
    transform: translateY(-2px);
}
</style>
