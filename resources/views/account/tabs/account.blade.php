<div id="account-header-grid">
    <div>
        <img id="account-picture-128" src="{{ asset('img/blank.jpg') }}">
    </div>
    <div>
        <p id="account-name-header">Xyber Pastoril</p>
        <button id="account-edit-photo-btn" type="button" class="btn btn-sm btn-primary">Edit Photo</button>
    </div>
</div>

<hr>

<div class="row">
    <div class="col-12 col-lg-6 mb-3 mb-lg-0">
        <div class="card mb-3">
            <div class="card-body">
                <div class="card-content-grid-header-3">
                    <div class="card-content-header">
                        <p class="account-h2 m-0">Username</p>
                    </div>
                    <div class="card-content-value">
                        <p id="content_current_username" class="mt-1 mb-0">xyberpastoril</p>
                    </div>
                    <div class="card-content-btn">
                        <button type="button" class="btn btn-sm btn-primary btn-block" data-toggle="modal" data-target="#modal-username">Edit Username</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <div class="card-content-grid-header-3">
                    <div class="card-content-header">
                        <p class="account-h2 m-0">Email</p>
                    </div>
                    <div class="card-content-value">
                        <p id="content_current_email" class="mt-1 mb-0">xyber.pastoril@proton.me</p>
                    </div>
                    <div class="card-content-btn">
                        <button type="button" class="btn btn-sm btn-primary btn-block" data-toggle="modal" data-target="#modal-email">Edit Email</button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-body">
                <div class="card-content-grid-header-3">
                    <div class="card-content-header">
                        <p class="account-h2 m-0">Password</p>
                    </div>
                    <div class="card-content-value">
                        <p id="content_current_password" class="mt-1 mb-0">Last updated: May 1, 2022</p>
                    </div>
                    <div class="card-content-btn">
                        <button type="button" class="btn btn-sm btn-primary btn-block" data-toggle="modal" data-target="#modal-password">Edit Password</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6 mb-3 mb-lg-0">
        
        
        <div class="card mb-3">
            <div class="card-body">
                <div class="card-content-grid-header-2">
                    <div>
                        <p class="account-h2">Two Factor Authentication<span class="text-danger ml-3"><i>(Coming Soon)</i></span></p>
                    </div>
                    <div>
                        <button type="button" class="btn btn-sm btn-primary btn-block" disabled>Setup 2FA</button>
                    </div>
                </div>
                <p>
                    Two Factor Authentication adds an additional layer of protection to your account by asking for your password and a verification code from your authentication app of your choice.
                </p>
                
            </div>
        </div>
    </div>
</div>

{{-- Modals --}}
{{-- New Username --}}
<div class="modal fade" id="modal-username" tabindex="-1" role="dialog" aria-labelledby="modal-username-label" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-username-label">Edit Username</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="modal-username-spinner" class="spinner-border text-center p-5" role="status" style="display:none">
                    <span class="sr-only">Loading...</span>
                </div>
                <form id="form_username" data-update="username" class="account-update" method="post">
                    @csrf
                    @method('put')
                    <div class="form-group row">
                        <label for="u_username" class="col-12 col-lg-6 col-form-label">New Username<span class="text-danger ml-1">*</span></label>
                        <div class="col-12 col-lg-6">
                            <input type="text" class="form-control" id="u_username" name="username" data-field="username" required>
                        </div>
                        <p id="err_form_username_username" data-field="username" class="text-danger col-12 mt-1 mb-0" style="display:none"></p>
                    </div>
                    <div class="form-group row">
                        <label for="u_username_confirm" class="col-12 col-lg-6 col-form-label">Confirm Username<span class="text-danger ml-1">*</span></label>
                        <div class="col-12 col-lg-6">
                            <input type="text" class="form-control" id="u_username_confirm" name="confirm_username" data-field="confirm_username" required>
                        </div>
                        <p id="err_form_username_confirm_username" data-field="confirm_username"  class="text-danger col-12 mt-1 mb-0" style="display:none"></p>
                    </div>
                    <div class="form-group row">
                        <label for="u_username_password" class="col-12 col-lg-6 col-form-label">Confirm Password<span class="text-danger ml-1">*</span></label>
                        <div class="col-12 col-lg-6">
                            <input type="password" class="form-control" id="u_username_password" name="confirm_password" data-field="confirm_password" required>
                        </div>
                        <p id="err_form_username_confirm_password" data-field="confirm_password"  class="text-danger col-12 mt-1 mb-0" style="display:none"></p>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="btn_close_form_username" form="form_username" data-close="1" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" id="btn_submit_form_username" form="form_username" data-submit="1">Update Username</button>
            </div>
        </div>
    </div>
</div>

{{-- Update Email --}}
<div class="modal fade" id="modal-email" tabindex="-1" role="dialog" aria-labelledby="modal-email-label" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-email-label">Edit Email</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="modal-email-spinner" class="spinner-border text-center p-5" role="status" style="display:none">
                    <span class="sr-only">Loading...</span>
                </div>
                <form id="form_email" data-update="email" class="account-update" method="post">
                    @csrf
                    @method('put')
                    <div class="form-group row">
                        <label for="u_email" class="col-12 col-lg-6 col-form-label">New Email<span class="text-danger ml-1">*</span></label>
                        <div class="col-12 col-lg-6">
                            <input type="email" class="form-control" id="u_email" name="email" data-field="email" required>
                        </div>
                        <p id="err_form_email_email" data-field="email"  class="text-danger col-12 mt-1 mb-0" style="display:none"></p>
                    </div>
                    <div class="form-group row">
                        <label for="u_email_confirm" class="col-12 col-lg-6 col-form-label">Confirm Email<span class="text-danger ml-1">*</span></label>
                        <div class="col-12 col-lg-6">
                            <input type="email" class="form-control" id="u_email_confirm" name="confirm_email" data-field="confirm_email" required>
                        </div>
                        <p id="err_form_email_confirm_email" data-field="confirm_email"  class="text-danger col-12 mt-1 mb-0" style="display:none"></p>
                    </div>
                    <div class="form-group row">
                        <label for="u_email_password" class="col-12 col-lg-6 col-form-label">Confirm Password<span class="text-danger ml-1">*</span></label>
                        <div class="col-12 col-lg-6">
                            <input type="password" class="form-control" id="u_email_password" name="confirm_password" data-field="confirm_password" required>
                        </div>
                        <p id="err_form_email_confirm_password" data-field="confirm_password"  class="text-danger col-12 mt-1 mb-0" style="display:none"></p>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="btn_close_form_email" form="form_email" data-close="1" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" id="btn_submit_form_email" form="form_email" data-submit="1">Update Email</button>
            </div>
        </div>
    </div>
</div>

{{-- Update Password --}}
<div class="modal fade" id="modal-password" tabindex="-1" role="dialog" aria-labelledby="modal-password-label" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-password-label">Edit Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="modal-password-spinner" class="spinner-border text-center p-5" role="status" style="display:none">
                    <span class="sr-only">Loading...</span>
                </div>
                <form id="form_password" data-update="password" data-issensitive="1" class="account-update" method="post">
                    @csrf
                    @method('put')
                    <div class="form-group row">
                        <label for="u_password_old" class="col-12 col-lg-6 col-form-label">Old Password<span class="text-danger ml-1">*</span></label>
                        <div class="col-12 col-lg-6">
                            <input type="password" class="form-control" id="u_password_old" name="old_password" data-field="old_password" required>
                        </div>
                        <p id="err_form_password_old_password" data-field="old_password"  class="text-danger col-12 mt-1 mb-0" style="display:none"></p>
                    </div>
                    <div class="form-group row">
                        <label for="u_password_new" class="col-12 col-lg-6 col-form-label">New Password<span class="text-danger ml-1">*</span></label>
                        <div class="col-12 col-lg-6">
                            <input type="password" class="form-control" id="u_password_new" name="new_password" data-field="new_password" required>
                        </div>
                        <p id="err_form_password_new_password" data-field="new_password"  class="text-danger col-12 mt-1 mb-0" style="display:none"></p>
                    </div>
                    <div class="form-group row">
                        <label for="u_password_confirm" class="col-12 col-lg-6 col-form-label">Confirm New Password<span class="text-danger ml-1">*</span></label>
                        <div class="col-12 col-lg-6">
                            <input type="password" class="form-control" id="u_password_confirm" name="confirm_new_password" data-field="confirm_new_password" required>
                        </div>
                        <p id="err_form_password_confirm_new_password" data-field="confirm_new_password"  class="text-danger col-12 mt-1 mb-0" style="display:none"></p>
                    </div>
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="btn_close_form_password" data-dismiss="modal" data-close="1" form="form_password">Cancel</button>
                <button type="submit" class="btn btn-primary" id="btn_submit_form_password" form="form_password" data-submit="1">Update Password</button>
            </div>
        </div>
    </div>
</div>