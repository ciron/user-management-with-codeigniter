<?= $this->extend('user/layouts/master') ?>

<?= $this->section('title') ?>My Profile<?= $this->endSection() ?>

<?= $this->section('page-title') ?>My Profile<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
<i class="fas fa-home"></i> / Profile / Personal Information
<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .profile-wrapper {
        max-width: 1000px;
        margin: 30px auto;
        padding: 0 20px;
    }
    
    .profile-cover {
        height: 140px;
        background: var(--primary-gradient);
        border-radius: 1rem 1rem 0 0;
    }
    
    .profile-header-content {
        display: flex;
        align-items: flex-end;
        gap: 30px;
        padding: 0 30px;
        margin-top: -60px;
        margin-bottom: 30px;
        flex-wrap: wrap;
    }
    
    .profile-avatar-wrapper {
        position: relative;
    }
    
    .profile-avatar-large {
        width: 120px;
        height: 120px;
        background: var(--primary-gradient);
        border-radius: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 3.5rem;
        border: 5px solid white;
        box-shadow: 0 20px 30px -10px rgba(102, 126, 234, 0.4);
        transition: transform 0.3s ease;
    }
    
    .profile-avatar-large:hover {
        transform: scale(1.05);
    }
    
    .profile-title-section {
        flex: 1;
        padding-bottom: 15px;
    }
    
    .profile-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(59, 130, 246, 0.1);
        color: #1d4ed8;
        padding: 8px 18px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.9rem;
        border: 1px solid rgba(59, 130, 246, 0.2);
    }
    
    .stat-item {
        background: white;
        padding: 8px 16px;
        border-radius: 30px;
        border: 1px solid #eef2f8;
        font-size: 0.9rem;
        color: #64748b;
    }
    
    .stat-item i {
        color: #3b82f6;
        margin-right: 6px;
    }
    
    .info-card {
        background: #f8fafc;
        border-radius: 20px;
        padding: 20px;
        margin-bottom: 30px;
        border: 1px solid #eef2f8;
    }
    
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
    }
    
    .info-item {
        background: white;
        padding: 15px 20px;
        border-radius: 16px;
        border: 1px solid #eef2f8;
    }
    
    .info-item-label {
        font-size: 0.75rem;
        color: #64748b;
        margin-bottom: 5px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    
    .info-item-value {
        font-weight: 600;
        color: #1e293b;
        font-size: 1.1rem;
    }
    
    .alert-message {
        border-radius: 60px;
        border-left-width: 4px;
        border-left-style: solid;
        animation: slideDown 0.3s ease;
    }
    
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .form-control, .input-group-text {
        border-radius: 20px;
        padding: 12px 20px;
        border: 2px solid #e2e8f0;
    }
    
    .form-control:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
    }
    
    .form-control[readonly] {
        background: #f8fafc;
        border-color: #e2e8f0;
        color: #64748b;
        cursor: not-allowed;
    }
    
    .input-group-text {
        background: transparent;
        border-right: none;
    }
    
    .input-group .form-control {
        border-left: none;
        padding-left: 0;
    }
    
    .btn-update {
        background: var(--primary-gradient);
        border: none;
        color: white;
        font-weight: 600;
        padding: 12px 30px;
        border-radius: 60px;
        transition: all 0.3s ease;
        box-shadow: 0 10px 25px -5px rgba(102, 126, 234, 0.4);
    }
    
    .btn-update:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 30px -5px rgba(102, 126, 234, 0.5);
        color: white;
    }
    
    .btn-cancel {
        background: white;
        border: 2px solid #e2e8f0;
        color: #64748b;
        font-weight: 600;
        padding: 12px 30px;
        border-radius: 60px;
        transition: all 0.3s ease;
    }
    
    .btn-cancel:hover {
        background: #f8fafc;
        border-color: #94a3b8;
        color: #475569;
    }
    
    .password-section {
        background: #f8fafc;
        border-radius: 20px;
        padding: 20px;
        margin: 30px 0;
        border: 1px solid #eef2f8;
    }
    
    /* Fixed password toggle position */
    .password-wrapper {
        position: relative;
        width: 100%;
    }
    
    .password-wrapper .form-control {
        padding-right: 45px; /* Make space for the icon */
    }
    
    .password-toggle {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #94a3b8;
        z-index: 10;
        background: transparent;
        padding: 5px;
        transition: color 0.2s ease;
    }
    
    .password-toggle:hover {
        color: #3b82f6;
    }
    
    .password-strength {
        height: 5px;
        border-radius: 10px;
        margin-top: 8px;
        transition: all 0.3s ease;
        background: #e2e8f0;
    }
    
    .strength-weak {
        width: 33.33%;
        background: #ef4444;
    }
    
    .strength-medium {
        width: 66.66%;
        background: #f59e0b;
    }
    
    .strength-strong {
        width: 100%;
        background: #10b981;
    }
    
    /* Textarea styling */
    textarea.form-control {
        min-height: 100px;
        resize: vertical;
    }
    
    @media (max-width: 768px) {
        .profile-header-content {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        
        .profile-title-section {
            text-align: center;
        }
        
        .profile-stats {
            justify-content: center;
        }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="profile-wrapper">
    <!-- Main Profile Card -->
    <div class="card border-0 shadow-lg overflow-hidden">
        <!-- Cover Image -->
        <div class="profile-cover"></div>
        
        <!-- Profile Header -->
        <div class="profile-header-content">
            <div class="profile-title-section">
                <div class="d-flex align-items-center gap-3 flex-wrap mb-2">
                    <h2 class="display-6 fw-bold mb-0"><?= htmlspecialchars($userName) ?></h2>
                    <span class="profile-badge">
                        <i class="fas fa-shield-alt"></i>
                        <span><?= ucfirst($userRole ?? 'user') ?></span>
                    </span>
                </div>
            </div>
        </div>

        <!-- Profile Content -->
        <div class="card-body">
            <!-- Additional Info Card -->
            <div class="info-card">
                <div class="info-card-title d-flex align-items-center gap-2 mb-3">
                    <i class="fas fa-id-card text-primary fs-5"></i>
                    <span class="fw-semibold">Account Information</span>
                </div>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-item-label">Account Status</div>
                        <div class="info-item-value">
                            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">
                                <i class="fas fa-circle fa-2xs me-1"></i> <?= $userstatus ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Profile Form -->
            <form id="profileForm" method="POST" action="<?= base_url('user/updateProfile') ?>">
                <?= csrf_field() ?>
                
                <div class="d-flex align-items-center gap-2 mb-4">
                    <i class="fas fa-user-edit text-primary fs-4"></i>
                    <h5 class="fw-semibold mb-0">Edit Personal Information</h5>
                </div>

                <div class="row g-4">
                    <!-- Full name -->
                    <div class="col-12">
                        <label class="form-label fw-semibold text-uppercase small">
                            <i class="fas fa-user-circle text-primary me-2"></i>Full name
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-transparent">
                                <i class="fas fa-user text-muted"></i>
                            </span>
                            <input type="text" class="form-control" name="name" 
                                   value="<?= htmlspecialchars($userName) ?>" 
                                   placeholder="Enter your full name" required>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-uppercase small">
                            <i class="fas fa-envelope text-primary me-2"></i>Email address
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-transparent">
                                <i class="fas fa-envelope text-muted"></i>
                            </span>
                            <input type="email" class="form-control" name="email" 
                                   value="<?= htmlspecialchars($userEmail) ?>" 
                                   placeholder="your@email.com" readonly>
                        </div>
                        <div class="form-text text-muted small mt-2">
                            <i class="fas fa-lock me-1"></i> Email cannot be changed
                        </div>
                    </div>

                    <!-- Phone -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-uppercase small">
                            <i class="fas fa-phone-alt text-primary me-2"></i>Phone number
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-transparent">
                                <i class="fas fa-phone-alt text-muted"></i>
                            </span>
                            <input type="tel" class="form-control" name="phone" 
                                   value="<?= htmlspecialchars($userPhone) ?>" 
                                   placeholder="+1 (555) 000-9999">
                        </div>
                    </div>

                    <!-- Address Field (Textarea) -->
                    <div class="col-12">
                        <label class="form-label fw-semibold text-uppercase small">
                            <i class="fas fa-map-marker-alt text-primary me-2"></i>Address
                        </label>
                        <textarea class="form-control" name="address" 
                                  placeholder="Enter your complete address" 
                                  rows="3"><?= htmlspecialchars($userAddress ?? '') ?></textarea>
                        <div class="form-text text-muted small mt-2">
                            <i class="fas fa-info-circle me-1"></i> 
                            Enter your street address, city, state, and zip code
                        </div>
                    </div>
                </div>

                <!-- Password Update Section -->
                <div class="password-section">
                    <div class="row g-4">
                        <!-- New Password -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-uppercase small">
                                <i class="fas fa-key text-primary me-2"></i>New Password
                            </label>
                            <div class="password-wrapper">
                                <div class="input-group">
                                    <span class="input-group-text bg-transparent">
                                        <i class="fas fa-lock text-muted"></i>
                                    </span>
                                    <input type="password" class="form-control" name="password" 
                                           id="password" placeholder="Enter new password">
                                </div>
                                <i class="fas fa-eye password-toggle" id="togglePassword"></i>
                            </div>
                            <div class="password-strength" id="passwordStrength"></div>
                            <div class="form-text text-muted small mt-2">
                                <i class="fas fa-info-circle me-1"></i> 
                                Min 8 characters with 1 letter & 1 number
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-uppercase small">
                                <i class="fas fa-check-circle text-primary me-2"></i>Confirm Password
                            </label>
                            <div class="password-wrapper">
                                <div class="input-group">
                                    <span class="input-group-text bg-transparent">
                                        <i class="fas fa-lock text-muted"></i>
                                    </span>
                                    <input type="password" class="form-control" name="confirm_password" 
                                           id="confirm_password" placeholder="Confirm new password">
                                </div>
                                <i class="fas fa-eye password-toggle" id="toggleConfirmPassword"></i>
                            </div>
                            <div class="form-text small mt-2" id="passwordMatchMsg">
                                <i class="fas fa-circle me-1"></i> 
                                Passwords must match
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hidden inputs -->
                <input type="hidden" name="role" value="<?= $userRole ?? 'user' ?>">
                <input type="hidden" name="userId" value="<?= $user['id'] ?? '' ?>">

                <!-- Action Buttons -->
                <div class="d-flex justify-content-end gap-3 border-top pt-4">
                    <button type="button" class="btn btn-danger px-4" onclick="window.history.back()">
                        <i class="fas fa-times me-2"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-success px-5" id="submitBtn">
                        <i class="fas fa-pen-to-square me-2"></i>Update Profile
                        <i class="fas fa-arrow-right ms-2 fa-sm"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // Password visibility toggle - Fixed position
    $('#togglePassword').click(function() {
        const passwordField = $('#password');
        const type = passwordField.attr('type') === 'password' ? 'text' : 'password';
        passwordField.attr('type', type);
        $(this).toggleClass('fa-eye fa-eye-slash');
    });

    $('#toggleConfirmPassword').click(function() {
        const confirmField = $('#confirm_password');
        const type = confirmField.attr('type') === 'password' ? 'text' : 'password';
        confirmField.attr('type', type);
        $(this).toggleClass('fa-eye fa-eye-slash');
    });

    // Password strength checker
    $('#password').on('input', function() {
        const password = $(this).val();
        const strengthBar = $('#passwordStrength');
        
        if (password.length === 0) {
            strengthBar.removeClass().addClass('password-strength');
            return;
        }
        
        // Check password strength
        const hasLetter = /[a-zA-Z]/.test(password);
        const hasNumber = /[0-9]/.test(password);
        const length = password.length;
        
        if (length < 6) {
            strengthBar.removeClass().addClass('password-strength strength-weak');
        } else if (length >= 6 && length < 8 && (hasLetter || hasNumber)) {
            strengthBar.removeClass().addClass('password-strength strength-medium');
        } else if (length >= 8 && hasLetter && hasNumber) {
            strengthBar.removeClass().addClass('password-strength strength-strong');
        } else {
            strengthBar.removeClass().addClass('password-strength strength-weak');
        }
    });

    // Password match checker
    function checkPasswordMatch() {
        const password = $('#password').val();
        const confirm = $('#confirm_password').val();
        const msg = $('#passwordMatchMsg');
        
        if (confirm.length === 0) {
            msg.html('<i class="fas fa-circle me-1"></i> Confirm your password');
            msg.removeClass('text-success text-danger').addClass('text-muted');
            return true;
        }
        
        if (password === confirm) {
            msg.html('<i class="fas fa-check-circle me-1"></i> Passwords match');
            msg.removeClass('text-muted text-danger').addClass('text-success');
            return true;
        } else {
            msg.html('<i class="fas fa-times-circle me-1"></i> Passwords do not match');
            msg.removeClass('text-muted text-success').addClass('text-danger');
            return false;
        }
    }

    $('#password, #confirm_password').on('keyup', checkPasswordMatch);

    // Form submission handling
    $('#profileForm').on('submit', function(e) {
        e.preventDefault();
        
        // Validate name
        const nameInput = $('input[name="name"]').val().trim();
        if (nameInput.length < 3) {
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: 'Name must be at least 3 characters long',
                confirmButtonColor: '#3b82f6',
                timer: 3000,
                timerProgressBar: true
            });
            return;
        }

        // Validate password if provided
        const password = $('#password').val();
        const confirmPassword = $('#confirm_password').val();
        
        if (password || confirmPassword) {
            // Check if passwords match
            if (password !== confirmPassword) {
                Swal.fire({
                    icon: 'error',
                    title: 'Password Mismatch',
                    text: 'Password and confirm password do not match',
                    confirmButtonColor: '#3b82f6'
                });
                return;
            }
            
            // Check password strength
            if (password.length > 0 && password.length < 8) {
                Swal.fire({
                    icon: 'error',
                    title: 'Weak Password',
                    text: 'Password must be at least 8 characters long',
                    confirmButtonColor: '#3b82f6'
                });
                return;
            }
            
            const hasLetter = /[a-zA-Z]/.test(password);
            const hasNumber = /[0-9]/.test(password);
            
            if (password.length > 0 && (!hasLetter || !hasNumber)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Weak Password',
                    text: 'Password must contain at least one letter and one number',
                    confirmButtonColor: '#3b82f6'
                });
                return;
            }
        }

        // Show loading state
        Swal.fire({
            title: 'Updating Profile...',
            html: 'Please wait while we update your information',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Get form data
        var formData = new FormData(this);

        // AJAX request
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message || 'Profile updated successfully',
                        confirmButtonColor: '#3b82f6',
                        timer: 3000,
                        timerProgressBar: true
                    }).then(() => {
                        // Update the displayed name in the header if it changed
                        if (response.newName) {
                            $('h2.display-6').text(response.newName);
                        }
                        // Clear password fields
                        $('#password, #confirm_password').val('');
                        // Update password strength indicator
                        $('#passwordStrength').removeClass().addClass('password-strength');
                        $('#passwordMatchMsg').html('<i class="fas fa-circle me-1"></i> Passwords must match');
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: response.message || 'Failed to update profile',
                        confirmButtonColor: '#3b82f6'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
                console.error('Response:', xhr.responseText);
                
                let errorMessage = 'An error occurred while updating your profile';
                
                // Try to parse error response
                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response.message) {
                        errorMessage = response.message;
                    } else if (response.error) {
                        errorMessage = response.error;
                    }
                } catch (e) {
                    if (xhr.status === 0) {
                        errorMessage = 'Network error. Please check your connection.';
                    } else if (xhr.status === 404) {
                        errorMessage = 'API endpoint not found';
                    } else if (xhr.status === 500) {
                        errorMessage = 'Server error. Please try again later.';
                    }
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: errorMessage,
                    confirmButtonColor: '#3b82f6'
                });
            }
        });
    });

    // Flash messages
    <?php if (session()->getFlashdata('success')): ?>
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: '<?= session()->getFlashdata('success') ?>',
        confirmButtonColor: '#3b82f6',
        timer: 3000,
        timerProgressBar: true
    });
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
    Swal.fire({
        icon: 'error',
        title: 'Error!',
        text: '<?= session()->getFlashdata('error') ?>',
        confirmButtonColor: '#3b82f6'
    });
    <?php endif; ?>
});

// Cancel confirmation
$(document).on('click', '.btn-cancel', function(e) {
    e.preventDefault();
    Swal.fire({
        title: 'Are you sure?',
        text: "Any unsaved changes will be lost!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3b82f6',
        cancelButtonColor: '#ef4444',
        confirmButtonText: 'Yes, go back'
    }).then((result) => {
        if (result.isConfirmed) {
            window.history.back();
        }
    });
});
</script>
<?= $this->endSection() ?>