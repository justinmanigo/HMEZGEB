// When the alert success `close` button is clicked.
$("#alert-success button").click(function(){
    $("#alert-success").hide();
});

// When the update username form is submitted.
$("#form-username").submit(function(e){
    e.preventDefault();

    // Link error elements & submit btn to a variable.
    var error_text_elements = [
        $("#u_username_error"), 
        $("#u_username_confirm_error"), 
        $("#u_username_password_error")
    ];
    var btn_submit = $("#u_username_submit_btn");
    var btn_close = $("#u_username_close_btn");

    // Hide error elements and disable submit btn.
    hideErrors(error_text_elements);
    disableButton(btn_submit);

    // Create request
    var request = $.ajax({
        url: 'ajax/account/update/username',
        method: "POST",
        data: $("#form-username").serialize()
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
        showErrors(error_text_elements, jqXHR.responseJSON.errors);
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

function showErrors(errors_dom, errors)
{
    error_list = Object.keys(errors);

    errors_dom.forEach(function(e){
        err = e[0].dataset.error;
                if(errorInArray(error_list, err)) {
            e.show().html(errors[err][0]);
        }
    });   
}

function errorInArray(error_list, err)
{
    console.log("Check if error is in array.");
    var res = false;
    error_list.forEach(function(e){
        // console.log(`${e} == ${err}? = ${e == err}`);
        if(e == err) {
            res = true;
        }
    });
    // console.log("Result: " + res);
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