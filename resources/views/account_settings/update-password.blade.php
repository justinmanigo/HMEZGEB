@extends('template.subscription')

@section('content')

<div class="container">
    <div class="row">
        <div class="card">
            <div class="card-body">
                <h4>Update Your Password</h4>
                <p>Before you continue on your next task, we humbly ask you to update your password.</p>
                <p>This is a security measure to prevent unauthorized access to your account.</p>
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
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" id="btn_submit_form_password" form="form_password" data-submit="1">Update Password</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(".account-update").submit(function(e){
    console.log(e);
    e.preventDefault();

    // Initialize and get input elements, submit button, and close button.
    // error ids must match ff format: err_{form_name}_{input_field}
    // for submit btns: btn_submit_{form_name}, include data-submit='1' attr
    // for close btns: btn_close_{form_name}, include data-close='1' attr
    // both input and error elements must have data-field bearing the input name.
    var elm_errors = [], btn_submit, btn_close;

    for(i = 0; i < e.target.length; i++)
    {
        let elm_data = e.target[i].dataset;
        if(elm_data.field != undefined) {
            console.log(elm_data.field);
            console.log(`#err_${e.target.id}_${elm_data.field}`);
            elm_errors.push($(`#err_${e.target.id}_${elm_data.field}`));
        }
        if(elm_data.close != undefined) {
            btn_close = $(`#btn_close_${e.target.id}`)
        }
        if(elm_data.submit != undefined) {
            btn_submit = $(`#btn_submit_${e.target.id}`)
        }
    }

    // Hide error elements and disable submit btn.
    hideErrors(elm_errors);
    disableButton(btn_submit);

    console.log("Creating request.");
    // Create request
    var request = $.ajax({
        url: `/ajax/account/update/${e.target.dataset.update}`,
        method: "POST",
        data: $(`#form_${e.target.dataset.update}`).serialize()
    });

    // If request has successfully processed.
    request.done(function(res, status, jqXHR) {
        console.log("Request successful.");
        console.log(res);
        if(res == '1') {
            window.location.href = '/switch';
        }
    });

    // If request has errors (including validation errors).
    request.fail(function(jqXHR, status, error){
        console.log("Request failed.");
        console.log(jqXHR);
        showErrors(elm_errors, jqXHR.responseJSON.errors);
    });

    // The following always executes regardless of status.
    request.always(function(){
        enableButton(btn_submit);
    });
});

function hideErrors(errors_dom)
{
    errors_dom.forEach(function(e){
        e.hide();
    });
}

function showErrors(elm_errors, errors)
{
    error_list = Object.keys(errors);
    elm_errors.forEach(function(e){
        err = e[0].dataset.field;
        if(errorInArray(error_list, err)) {
            e.show().html(errors[err][0]);
        }
    });
}

function errorInArray(error_list, err)
{
    var res = false;
    error_list.forEach(function(e){
        if(e == err) {
            res = true;
        }
    });
    return res;
}

function enableButton(btn) {
    btn.removeAttr('disabled');
}

function disableButton(btn) {
    btn.attr('disabled', true);
}

function showSuccessAlert(msg) {
    $("#alert-success").show();
    $("#alert-success-content").html(msg);
}

function capitalizeFirstLetter(string) {
    return string[0].toUpperCase() + string.slice(1);
}
</script>
@endpush
