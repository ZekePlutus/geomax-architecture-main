{{--
    Role Creation Modal

    Include this partial in any view where role creation is needed.

    Usage:
    @include('user::roles.partials.create-modal')

    Then add a button to trigger:
    <button type="button" data-bs-toggle="modal" data-bs-target="#createRoleModal">
        Create Role
    </button>

    JavaScript events:
    - 'roleCreated': Fired when a role is successfully created
      document.addEventListener('roleCreated', function(e) {
          console.log(e.detail.role); // The created role
      });
--}}

@php
    $modalPermissions =
        $permissions ??
        \App\Modules\Core\User\Models\Permission::active()
            ->orderBy('key')
            ->get()
            ->groupBy(fn($p) => explode('.', $p->key)[0]);
@endphp

<!--begin::Modal - Create Role-->
<div class="modal fade" id="createRoleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <form id="createRoleForm" action="{{ route('user.roles.store') }}" method="POST">
                @csrf
                <!--begin::Modal header-->
                <div class="modal-header">
                    <h2 class="fw-bold">Create New Role</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <i class="ki-outline ki-cross fs-1"></i>
                    </div>
                </div>
                <!--end::Modal header-->

                <!--begin::Modal body-->
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <div class="row g-5">
                        <!--begin::Left Column - Role Info-->
                        <div class="col-lg-4">
                            <div class="fv-row mb-7">
                                <label class="required fs-6 fw-semibold mb-2">Role Name</label>
                                <input type="text" class="form-control form-control-solid" name="name"
                                    placeholder="e.g., Sales Manager" required />
                                <div class="text-muted fs-7 mt-2">A descriptive name for this role</div>
                            </div>

                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-semibold mb-2">Description</label>
                                <textarea class="form-control form-control-solid" name="description" rows="4"
                                    placeholder="Describe what this role is for..."></textarea>
                                <div class="text-muted fs-7 mt-2">Optional description to help identify this role's
                                    purpose</div>
                            </div>

                            <!--begin::Quick Stats-->
                            <div class="d-flex align-items-center bg-light-primary rounded p-4">
                                <i class="ki-outline ki-key fs-2 text-primary me-3"></i>
                                <div>
                                    <span class="fs-4 fw-bold text-gray-800" id="modalSelectedCount">0</span>
                                    <span class="text-muted fs-7 d-block">Permissions selected</span>
                                </div>
                            </div>
                            <!--end::Quick Stats-->
                        </div>
                        <!--end::Left Column-->

                        <!--begin::Right Column - Permissions-->
                        <div class="col-lg-8">
                            <div class="d-flex justify-content-between align-items-center mb-5">
                                <label class="fs-6 fw-semibold">Select Permissions</label>
                                <div>
                                    <button type="button" class="btn btn-sm btn-light-primary" id="modalSelectAll">
                                        <i class="ki-outline ki-check-square fs-5 me-1"></i>All
                                    </button>
                                    <button type="button" class="btn btn-sm btn-light" id="modalDeselectAll">
                                        <i class="ki-outline ki-cross-square fs-5 me-1"></i>None
                                    </button>
                                </div>
                            </div>

                            @if ($modalPermissions->isEmpty())
                                <div class="text-center text-muted py-10">
                                    <i class="ki-outline ki-information-5 fs-3x text-gray-400 mb-3"></i>
                                    <p>No permissions available. Permissions are registered by modules.</p>
                                </div>
                            @else
                                <div class="accordion accordion-flush" id="modalPermissionsAccordion">
                                    @foreach ($modalPermissions as $module => $modulePermissions)
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button
                                                    class="accordion-button {{ $loop->first ? '' : 'collapsed' }} fs-6 fw-semibold py-4"
                                                    type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#modal_module_{{ $module }}">
                                                    <span class="d-flex align-items-center">
                                                        <i class="ki-outline ki-cube-2 fs-4 me-2 text-primary"></i>
                                                        {{ ucfirst($module) }}
                                                        <span
                                                            class="badge badge-light-primary ms-2">{{ $modulePermissions->count() }}</span>
                                                    </span>
                                                </button>
                                            </h2>
                                            <div id="modal_module_{{ $module }}"
                                                class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}"
                                                data-bs-parent="#modalPermissionsAccordion">
                                                <div class="accordion-body py-4">
                                                    <div class="d-flex justify-content-end mb-3">
                                                        <button type="button"
                                                            class="btn btn-sm btn-light-primary modal-select-module"
                                                            data-module="{{ $module }}">
                                                            Select All {{ ucfirst($module) }}
                                                        </button>
                                                    </div>
                                                    <div class="row g-3">
                                                        @foreach ($modulePermissions as $permission)
                                                            <div class="col-md-6">
                                                                <label
                                                                    class="form-check form-check-custom form-check-solid form-check-sm">
                                                                    <input
                                                                        class="form-check-input modal-permission-checkbox"
                                                                        type="checkbox" name="permissions[]"
                                                                        value="{{ $permission->id }}"
                                                                        data-module="{{ $module }}">
                                                                    <span class="form-check-label d-flex flex-column">
                                                                        <span
                                                                            class="fw-semibold text-gray-800">{{ $permission->name }}</span>
                                                                        <span
                                                                            class="text-muted fs-8">{{ $permission->key }}</span>
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
                        <!--end::Right Column-->
                    </div>
                </div>
                <!--end::Modal body-->

                <!--begin::Modal footer-->
                <div class="modal-footer flex-center">
                    <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="createRoleSubmit">
                        <span class="indicator-label">Create Role</span>
                        <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
                <!--end::Modal footer-->
            </form>
        </div>
    </div>
</div>
<!--end::Modal - Create Role-->

@once
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const modal = document.getElementById('createRoleModal');
                const form = document.getElementById('createRoleForm');
                const submitBtn = document.getElementById('createRoleSubmit');
                const countEl = document.getElementById('modalSelectedCount');

                // Update count
                const updateCount = () => {
                    const count = document.querySelectorAll('.modal-permission-checkbox:checked').length;
                    if (countEl) countEl.textContent = count;
                };

                // Select All
                document.getElementById('modalSelectAll')?.addEventListener('click', function() {
                    document.querySelectorAll('.modal-permission-checkbox').forEach(cb => cb.checked = true);
                    updateCount();
                });

                // Deselect All
                document.getElementById('modalDeselectAll')?.addEventListener('click', function() {
                    document.querySelectorAll('.modal-permission-checkbox').forEach(cb => cb.checked = false);
                    updateCount();
                });

                // Select Module
                document.querySelectorAll('.modal-select-module').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const module = this.dataset.module;
                        document.querySelectorAll(`.modal-permission-checkbox[data-module="${module}"]`)
                            .forEach(cb => cb.checked = true);
                        updateCount();
                    });
                });

                // Update count on checkbox change
                document.querySelectorAll('.modal-permission-checkbox').forEach(cb => {
                    cb.addEventListener('change', updateCount);
                });

                // Reset form when modal is closed
                modal?.addEventListener('hidden.bs.modal', function() {
                    form.reset();
                    updateCount();
                });

                // Handle form submission via AJAX
                form?.addEventListener('submit', function(e) {
                    e.preventDefault();

                    // Show loading state
                    submitBtn.setAttribute('data-kt-indicator', 'on');
                    submitBtn.disabled = true;

                    const formData = new FormData(form);

                    fetch(form.action, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Close modal
                                bootstrap.Modal.getInstance(modal).hide();

                                // Dispatch custom event with role data
                                document.dispatchEvent(new CustomEvent('roleCreated', {
                                    detail: {
                                        role: data.role
                                    }
                                }));

                                // Show success message
                                if (typeof Swal !== 'undefined') {
                                    Swal.fire({
                                        text: data.message,
                                        icon: 'success',
                                        confirmButtonText: 'OK'
                                    });
                                } else {
                                    alert(data.message);
                                }
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            if (typeof Swal !== 'undefined') {
                                Swal.fire({
                                    text: 'An error occurred. Please try again.',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            } else {
                                alert('An error occurred. Please try again.');
                            }
                        })
                        .finally(() => {
                            submitBtn.removeAttribute('data-kt-indicator');
                            submitBtn.disabled = false;
                        });
                });
            });
        </script>
    @endpush
@endonce
