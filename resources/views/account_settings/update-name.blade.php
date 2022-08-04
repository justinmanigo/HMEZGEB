@extends('template.subscription')

@push('styles')
<style>
    .table-employee-content { 
        /** Equivalent to pt-3 */
        padding-top:1rem!important;
    }

    #thead-actions {
        /** Fixed width, increase if adding addt. buttons **/
        width:120px;
    }

    #account-header-grid {
        display:grid;
        gap:16px;
        grid-template-columns:128px auto;
        margin-bottom:24px;
    }

    #account-picture-128 {
        width:128px;
        border-radius:100%;
    }

    #account-name-header {
        margin-top:16px;
        margin-bottom:0px;
        font-size:36px;
    }

    .account-h2 {
        font-size:20px;
        font-weight: 700;
    }

    .card-content-grid-header-2 {
        display:grid;
        gap:16px;
        grid-template-columns:auto 128px;
    }

    .card-content-grid-header-3 {
        display:grid;
        gap:16px;
        grid-template-columns:144px auto 128px;
        grid-template-areas:
            "header content btn";
    }

    .card-content-header {
        grid-area: header;
    }

    .card-content-value {
        grid-area: content;
    }

    .card-content-btn {
        grid-area: btn;
    }

    @media (max-width:991px) {
        #account-header-grid {
            grid-template-columns:auto;
        }

        #account-picture-128 {
            margin:0 auto;
            display:block;
        }

        #account-name-header {
            margin-top:0px;
            text-align:center;
        }

        #account-edit-photo-btn {
            display:block;
            margin:0 auto;
        }

        .card-content-grid-header-3 {
            display:grid;
            gap:16px;
            grid-template-columns:auto 128px;
            grid-template-areas:
                "header btn"
                "content content";
        }
    }
</style>

<script src="https://unpkg.com/@yaireo/tagify"></script>
<script src="https://unpkg.com/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
<link href="https://unpkg.com/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />

@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script> 
@endpush

@section('content')

<div class="container">
    <div class="row">
        <div class="card">
            <div class="card-body">
                <h4>Update Your Profile Name</h4>
                <p>Before you continue on your next task, we humbly ask you to update your profile name.</p>
                <p>Your profile name currently uses the default `New User` which makes your collaborators unable to identify you./p>
                <p class="alert alert-warning"><strong>Note: </strong>You cannot update your name again.</p>
                <form id="form_name" data-update="name" data-issensitive="0" class="account-update" method="post">
                    @csrf
                    @method('put')
                    <div class="form-group row">
                        <label for="firstName" class="col-12 col-lg-6 col-form-label">First Name<span class="text-danger ml-1">*</span></label>
                        <div class="col-12 col-lg-6">
                            <input type="text" class="form-control" id="firstName" name="firstName" data-field="firstName" required>
                        </div>
                        <p id="err_form_name_firstName" data-field="firstName"  class="text-danger col-12 mt-1 mb-0" style="display:none"></p>
                    </div>
                    <div class="form-group row">
                        <label for="lastName" class="col-12 col-lg-6 col-form-label">Last Name<span class="text-danger ml-1">*</span></label>
                        <div class="col-12 col-lg-6">
                            <input type="text" class="form-control" id="lastName" name="lastName" data-field="lastName" required>
                        </div>
                        <p id="err_form_name_lastName" data-field="lastName"  class="text-danger col-12 mt-1 mb-0" style="display:none"></p>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" id="btn_submit_form_name" form="form_name" data-submit="1">Update Name</button>
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