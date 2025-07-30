<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SOMS - Account Settings</title>
    <link rel="stylesheet" href="../../public/assets/css/accountsettings_tk_admin.css">
</head>
<body>
    <section class="settings-section">
        <div class="container">
            <h2 class="section-title">Account Settings</h2>
            <div class="settings-container">
                <div class="settings-grid">
                    <!-- Profile Overview -->
                    <div class="settings-card">
                        <div class="card-header">
                            <div class="card-icon">👤</div>
                            <div>
                                <div class="card-title">Profile Overview</div>
                                <div class="card-subtitle">Your account information</div>
                            </div>
                        </div>
                        
                        <div class="profile-info">
                            <div class="profile-avatar" id="profileAvatar">JD</div>
                            <div class="profile-details">
                                <div class="profile-name" id="profileName">Name Here</div>
                                
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="displayName">Display Name</label>
                            <input type="text" id="displayName" class="form-input" value="" placeholder="Enter your display name">
                            <div class="form-help">This name will be visible as you login to the system</div>
                        </div>
                        
                        <div class="form-actions">
                            <button type="button" class="btn btn-primary" onclick="updateProfile()">
                                💾 Save Changes
                            </button>
                        </div>
                    </div>

                    <!-- Username Settings -->
                    <div class="settings-card">
                        <div class="card-header">
                            <div class="card-icon">🏷️</div>
                            <div>
                                <div class="card-title">Username</div>
                                <div class="card-subtitle">Change your unique username</div>
                            </div>
                        </div>
                        
                        <div id="usernameAlert" class="alert"></div>
                        
                        <div class="form-group">
                            <label class="form-label" for="currentUsername">Current Username</label>
                            <input type="text" id="currentUsername" class="form-input" value="username-here" readonly style="background: #F9FAFB;">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="newUsername">New Username</label>
                            <input type="text" id="newUsername" class="form-input" placeholder="Enter new username">
                            <div class="form-help">Username must be 3-20 characters, letters and numbers only</div>
                        </div>
                        
                        <div class="form-actions">
                            <button type="button" class="btn btn-primary" onclick="updateUsername()">
                                🔄 Update Username
                            </button>
                            
                        </div>
                    </div>

                    <!-- Password Settings -->
                    <div class="settings-card">
                        <div class="card-header">
                            <div class="card-icon">🔐</div>
                            <div>
                                <div class="card-title">Password & Security</div>
                                <div class="card-subtitle">Update your password to keep your account secure</div>
                            </div>
                        </div>
                        
                        <div id="passwordAlert" class="alert"></div>
                        
                        <div class="form-group">
                            <label class="form-label" for="currentPassword">Current Password</label>
                            <div class="input-wrapper">
                                <input type="password" id="currentPassword" class="form-input" placeholder="Enter current password">
                                <button type="button" class="toggle-password"
                                    onmousedown="revealPassword('currentPassword', true)"
                                    onmouseup="revealPassword('currentPassword', false)"
                                    onmouseleave="revealPassword('currentPassword', false)">
                                    👁️
                                </button>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="newPassword">New Password</label>
                            <div class="input-wrapper">
                                <input type="password" id="newPassword" class="form-input" placeholder="Enter new password" oninput="checkPasswordStrength()">
                                <button type="button" class="toggle-password"
                                    onmousedown="revealPassword('newPassword', true)"
                                    onmouseup="revealPassword('newPassword', false)"
                                    onmouseleave="revealPassword('newPassword', false)">
                                    👁️
                                </button>
                                <script>
                                    function revealPassword(inputId, show) {
                                        var input = document.getElementById(inputId);
                                        if (input) {
                                            input.type = show ? 'text' : 'password';
                                        }
                                    }
                                </script>
                            </div>
                            <div class="password-strength" id="passwordStrength" style="display: none;">
                                <div class="strength-meter">
                                    <div class="strength-fill" id="strengthFill"></div>
                                </div>
                                <div class="strength-text" id="strengthText"></div>
                            </div>
                            <div class="form-help">Password must be at least 8 characters with uppercase, lowercase, and numbers</div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="confirmPassword">Confirm New Password</label>
                            <div class="input-wrapper">
                                <input type="password" id="confirmPassword" class="form-input" placeholder="Re-enter new password">
                                <button type="button" class="toggle-password"
                                    onmousedown="revealPassword('confirmPassword', true)"
                                    onmouseup="revealPassword('confirmPassword', false)"
                                    onmouseleave="revealPassword('confirmPassword', false)">
                                    👁️
                                </button>
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <button type="button" class="btn btn-primary" onclick="updatePassword()">
                                🔒 Update Password
                            </button>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</body>
</html>