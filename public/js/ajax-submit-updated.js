// 1. Add .ajax-submit-updated class as one of the form's class names.
// 2. Add data-message attribute to the said form for the success message.
// 3. Error elements shall have classes text-danger, error-message, and error-message-{field-name}.

$(".ajax-submit-updated").submit(function(e){
    console.log(`Submitting form ${e.target.id}`);
    console.log(e);
    e.preventDefault();

    closeButtonElement = $(`#${e.target.id}[type=button]`);
    submitButtonElement = $(`#${e.target.id}[type=submit]`);

    // Hide error elements and disable submit button.
    hideFormErrorsUpdated();
    disableSubmitButtonUpdated(submitButtonElement);

    console.log(`Creating a POST request from ${e.target.id}`);
    console.log($(`#${e.target.id}`).serialize());

    // Creating a request
    var request = $.ajax({
        url: e.target.action,
        method: e.target.method,
        data: $(`#${e.target.id}`).serialize(),
    });

    // If request has been successfully processed.
    request.done(function(res, status, jqXhr) {
        console.log(`Request for ${e.target.id} has successfully been made.`);
        console.log(res);

        closeButtonElement.click();
        // Get current link
        let currentLink = window.location.href;
        // Redirect using currentLink with new query string
        window.location.href = `${currentLink}?success=${e.target.dataset.message}`;
        // generateToast(res, 'bg-success');

        console.log("TEST");

        if(e.target.dataset.model != undefined)
        {
            request = window[e.target.dataset.model + 'Table'].requestData();
            processRequestReceivedProducts(request, window[e.target.dataset.model + 'Table']);
        }
    });

    // If request has errors (e.g. validation errors).
    request.fail(function(jqXHR, status, error){
        console.log(`Request for ${e.target.id} has failed.`);
        console.log(jqXHR);

        if(jqXHR.status != 422)
        {
            console.log(jqXHR.responseJSON.message);
            // generateToast(jqXHR.responseJSON.message, 'bg-danger');
            closeButtonElement.click();
        }
        else
        {
            console.log(jqXHR.responseJSON.errors);
            showFormErrorsUpdated(jqXHR.responseJSON.errors, e.target.id);
        }

    });

    // The following always executes regardless of status.
    request.always(function() {
        enableSubmitButtonUpdated(submitButtonElement);
    });
});

function hideFormErrorsUpdated()
{
    console.log("Attempting to hide errors.");
    $(`.error-message`).hide();
}

function showFormErrorsUpdated(errors, formName)
{
    error_list = Object.keys(errors);
    console.log("Show form errors");
    console.log(error_list);
    console.log(errors);

    error_list.forEach(function(e){
        let err = e;
        err = err.split(".");
        if(Array.isArray(err)) {
            if(err.length == 2) {
                let errElm = $(`#${formName} .error-message-${err[0]}`);
                errElm[parseInt(err[1])].innerHTML = errors[e];
                errElm[parseInt(err[1])].style = "display: flex";
            }
            else {
                let errElm = $(`#${formName} .error-message-${err[0]}`);      
                errElm.show().html(errors[e]);
            }
        }
    });
}
function enableSubmitButtonUpdated(btn) {
    btn.removeAttr('disabled');
}

function disableSubmitButtonUpdated(btn) {
    btn.attr('disabled', true);
}