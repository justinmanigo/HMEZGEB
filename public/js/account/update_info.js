// When the alert success `close` button is clicked.
$("#alert-success button").click(function(){
    $("#alert-success").hide();
});

// When the update username form is submitted.
$(".account-update").submit(function(e){
    e.preventDefault();
    
    // Initialize and get input elements, submit button, and close button.
    // error ids must match ff format: err_{form_name}_{input_field}
    // for submit btns: btn_submit_{form_name}
    // for close btns: btn_close_{form_name}
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

    // Create request
    var request = $.ajax({
        url: `ajax/account/update/${e.target.dataset.update}`,
        method: "POST",
        data: $(`#form_${e.target.dataset.update}`).serialize()
    });

    // If request has successfully processed.
    request.done(function(res, status, jqXHR) {
        if(res == '1') {
            btn_close.click();
            showSuccessAlert("Username successfully updated.");
        }
    });

    // If request has errors (including validation errors).
    request.fail(function(jqXHR, status, error){
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