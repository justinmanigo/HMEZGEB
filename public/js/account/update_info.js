// When the alert success `close` button is clicked.
$("#alert-success button").click(function(){
    $("#alert-success").hide();
});

// When the update username form is submitted.
$("#form-username").submit(function(e){
    e.preventDefault();

    // Initialize variables of error elements & submit btn.
    var u_username = $("#u_username_error");
    var u_username_confirm = $("#u_username_confirm_error");
    var u_username_password = $("#u_username_password_error");
    var u_username_submit_btn = $("#u_username_submit_btn");

    // Hide error elements and disable submit btn.
    u_username.hide();
    u_username_confirm.hide();
    u_username_password.hide();
    u_username_submit_btn.attr("disabled", true);

    // Create request
    var request = $.ajax({
        url: 'ajax/account/update/username',
        method: "POST",
        data: $("#form-username").serialize()
    });

    // If request has successfully processed.
    request.done(function(res, status, jqXHR) {
        if(res == '1') {
            $("#u_username_close_btn").click();
            $("#alert-success").show();
            $("#alert-success-content").html("Username successfully updated.");
        }
    });

    // If request has errors (including validation errors).
    request.fail(function(jqXHR, status, error){
        console.log("Request to update username failed.");
        console.log(jqXHR.responseJSON.errors);

        if(jqXHR.responseJSON.errors.username != undefined) {
            u_username.show().html(jqXHR.responseJSON.errors.username[0]);
        }
        if(jqXHR.responseJSON.errors.confirm_username != undefined) {
            u_username_confirm.show().html(jqXHR.responseJSON.errors.confirm_username[0]);
        }
        if(jqXHR.responseJSON.errors.confirm_password != undefined) {
            u_username_password.show().html(jqXHR.responseJSON.errors.confirm_password[0]);
        }
        console.log(status);
    });

    // The following always executes regardless of status.
    request.always(function(){
        u_username_submit_btn.removeAttr('disabled');
    });
});