/**
 * User Module JavaScript
 * 
 * Self-contained JS for the User module.
 * 
 * GOVERNANCE COMPLIANCE:
 * - NO frontend validation logic - all validation is handled by backend
 * - This file only handles UI interactions and server communication
 * - Form submissions are sent to the backend for validation
 * - Backend validation errors are displayed via server response
 */

(function () {
    'use strict';

    /**
     * User Module namespace
     */
    window.UserModule = window.UserModule || {};

    /**
     * Initialize the User module
     */
    UserModule.init = function () {
        this.initFormSubmission();
        this.initStatusToggle();
        this.initRoleSelection();
        this.initRestrictionManagement();
        this.initUserSearch();
        this.initPasswordToggle();
        this.initErrorDisplay();
    };

    /**
     * Initialize form submission handling
     * Forms submit to backend - validation is server-side only
     */
    UserModule.initFormSubmission = function () {
        const forms = document.querySelectorAll('.user-form');

        forms.forEach(form => {
            form.addEventListener('submit', function (e) {
                // Show loading state, let form submit to backend for validation
                UserModule.setFormLoading(form, true);
            });
        });
    };

    /**
     * Set form loading state
     */
    UserModule.setFormLoading = function (form, isLoading) {
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.disabled = isLoading;
            if (isLoading) {
                submitBtn.dataset.originalText = submitBtn.textContent;
                submitBtn.textContent = 'Processing...';
            } else if (submitBtn.dataset.originalText) {
                submitBtn.textContent = submitBtn.dataset.originalText;
            }
        }
    };

    /**
     * Initialize display of backend validation errors
     * Errors are rendered server-side, this just handles UX enhancements
     */
    UserModule.initErrorDisplay = function () {
        // Focus first input with error
        const firstError = document.querySelector('.user-form-input--error, .is-invalid');
        if (firstError) {
            firstError.focus();
        }

        // Clear error styling on input change
        const inputs = document.querySelectorAll('.user-form-input');
        inputs.forEach(input => {
            input.addEventListener('input', function () {
                input.classList.remove('user-form-input--error', 'is-invalid');
                const errorEl = input.parentElement?.querySelector('.user-form-error, .invalid-feedback');
                if (errorEl) {
                    errorEl.style.display = 'none';
                }
            });
        });
    };

    /**
     * Initialize status toggle (activate/deactivate)
     */
    UserModule.initStatusToggle = function () {
        const toggleButtons = document.querySelectorAll('[data-user-toggle-status]');

        toggleButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                const userId = button.dataset.userId;
                const currentStatus = button.dataset.currentStatus;
                const newStatus = currentStatus === 'active' ? 'deactivate' : 'activate';

                if (confirm(`Are you sure you want to ${newStatus} this user?`)) {
                    UserModule.toggleUserStatus(userId, newStatus);
                }
            });
        });
    };

    /**
     * Toggle user status via AJAX
     */
    UserModule.toggleUserStatus = function (userId, action) {
        const url = `/users/${userId}/${action}`;
        const csrf = document.querySelector('meta[name="csrf-token"]')?.content;

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf,
                'Accept': 'application/json'
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                } else {
                    alert(data.message || 'Failed to update user status');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while updating user status');
            });
    };

    /**
     * Initialize role selection with mutual exclusivity handling
     */
    UserModule.initRoleSelection = function () {
        const roleCheckboxes = document.querySelectorAll('.role-checkbox input[type="checkbox"]');

        roleCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                // Check for mutual exclusivity rules if needed
                const mutuallyExclusive = checkbox.dataset.mutuallyExclusive;
                if (mutuallyExclusive && checkbox.checked) {
                    const exclusiveRoles = mutuallyExclusive.split(',');
                    exclusiveRoles.forEach(roleId => {
                        const otherCheckbox = document.querySelector(
                            `.role-checkbox input[value="${roleId}"]`
                        );
                        if (otherCheckbox) {
                            otherCheckbox.checked = false;
                        }
                    });
                }
            });
        });
    };

    /**
     * Initialize restriction management
     */
    UserModule.initRestrictionManagement = function () {
        const restrictionForm = document.querySelector('.restriction-form');
        const removeButtons = document.querySelectorAll('.restriction-remove');

        // Handle restriction type change
        const typeSelect = document.querySelector('select[name="restriction_type"]');
        if (typeSelect) {
            typeSelect.addEventListener('change', function () {
                UserModule.updateRestrictionValueField(typeSelect.value);
            });
        }

        // Handle restriction removal
        removeButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const restrictionId = button.dataset.restrictionId;
                const userId = button.dataset.userId;

                if (confirm('Are you sure you want to remove this restriction?')) {
                    UserModule.removeRestriction(userId, restrictionId);
                }
            });
        });
    };

    /**
     * Update restriction value field based on type
     */
    UserModule.updateRestrictionValueField = function (type) {
        const valueContainer = document.querySelector('.restriction-value-container');
        if (!valueContainer) return;

        let inputHtml = '';

        switch (type) {
            case 'vehicle':
                inputHtml = `
                    <label class="user-form-label">Vehicle IDs</label>
                    <input type="text" name="restriction_value[vehicle_ids]" 
                           class="user-form-input" 
                           placeholder="Enter vehicle IDs (comma-separated)">
                `;
                break;
            case 'geofence':
                inputHtml = `
                    <label class="user-form-label">Geofence IDs</label>
                    <input type="text" name="restriction_value[geofence_ids]" 
                           class="user-form-input" 
                           placeholder="Enter geofence IDs (comma-separated)">
                `;
                break;
            case 'time':
                inputHtml = `
                    <label class="user-form-label">Start Time</label>
                    <input type="time" name="restriction_value[start_time]" 
                           class="user-form-input">
                    <label class="user-form-label" style="margin-top: 0.5rem;">End Time</label>
                    <input type="time" name="restriction_value[end_time]" 
                           class="user-form-input">
                `;
                break;
            case 'sub_account':
                inputHtml = `
                    <label class="user-form-label">Sub-Account IDs</label>
                    <input type="text" name="restriction_value[sub_account_ids]" 
                           class="user-form-input" 
                           placeholder="Enter sub-account IDs (comma-separated)">
                `;
                break;
            default:
                inputHtml = `
                    <label class="user-form-label">Value</label>
                    <input type="text" name="restriction_value[value]" 
                           class="user-form-input" 
                           placeholder="Enter restriction value">
                `;
        }

        valueContainer.innerHTML = inputHtml;
    };

    /**
     * Remove a restriction via AJAX
     */
    UserModule.removeRestriction = function (userId, restrictionId) {
        const url = `/users/${userId}/restrictions/${restrictionId}`;
        const csrf = document.querySelector('meta[name="csrf-token"]')?.content;

        fetch(url, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf,
                'Accept': 'application/json'
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const item = document.querySelector(
                        `.restriction-item[data-restriction-id="${restrictionId}"]`
                    );
                    if (item) {
                        item.remove();
                    }
                } else {
                    alert(data.message || 'Failed to remove restriction');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while removing restriction');
            });
    };

    /**
     * Initialize user search functionality
     */
    UserModule.initUserSearch = function () {
        const searchInput = document.querySelector('.user-search-input');
        if (!searchInput) return;

        let debounceTimer;

        searchInput.addEventListener('input', function () {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                const query = searchInput.value.trim();
                if (query.length >= 2 || query.length === 0) {
                    UserModule.filterUsers(query);
                }
            }, 300);
        });
    };

    /**
     * Filter users based on search query
     */
    UserModule.filterUsers = function (query) {
        const userRows = document.querySelectorAll('.user-table tbody tr, .user-card');
        const lowerQuery = query.toLowerCase();

        userRows.forEach(row => {
            const name = row.querySelector('.user-name')?.textContent?.toLowerCase() || '';
            const email = row.querySelector('.user-email')?.textContent?.toLowerCase() || '';

            const matches = !query || name.includes(lowerQuery) || email.includes(lowerQuery);
            row.style.display = matches ? '' : 'none';
        });
    };

    /**
     * Initialize password visibility toggle
     */
    UserModule.initPasswordToggle = function () {
        const toggleButtons = document.querySelectorAll('.password-toggle');

        toggleButtons.forEach(button => {
            button.addEventListener('click', function () {
                const input = button.previousElementSibling;
                if (input && input.type === 'password') {
                    input.type = 'text';
                    button.textContent = 'Hide';
                } else if (input) {
                    input.type = 'password';
                    button.textContent = 'Show';
                }
            });
        });
    };

    /**
     * Bulk user actions
     */
    UserModule.bulkAction = function (action) {
        const checkedUsers = document.querySelectorAll('.user-checkbox:checked');
        const userIds = Array.from(checkedUsers).map(cb => cb.value);

        if (userIds.length === 0) {
            alert('Please select at least one user');
            return;
        }

        const confirmMessage = `Are you sure you want to ${action} ${userIds.length} user(s)?`;
        if (!confirm(confirmMessage)) return;

        const csrf = document.querySelector('meta[name="csrf-token"]')?.content;

        fetch(`/users/bulk/${action}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ user_ids: userIds })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                } else {
                    alert(data.message || `Failed to ${action} users`);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert(`An error occurred during bulk ${action}`);
            });
    };

    // Initialize on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => UserModule.init());
    } else {
        UserModule.init();
    }

})();
