// 1. Add .ajax-submit-updated class as one of the form's class names.
// 2. Add data-message attribute to the said form for the success message.
// 3. Error elements shall have classes text-danger, error-message, and error-message-{field-name}.

$(".ajax-submit-updated").submit(function(e){
    console.log(`Submitting form ${e.target.id}`);
    console.log(e);
    e.preventDefault();

    submitButtonElement = $(`button[form="${e.target.id}"]`);
    console.log("Submit button element");
    console.log(submitButtonElement);

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

        let currentLink = window.location.href;
        // Remove query string on currentLink
        currentLink = currentLink.split("?");
        // Redirect using currentLink with new query string
        if(e.target.dataset.noreload != undefined)
        {
            window.toast(e.target.dataset.message);
            enableSubmitButtonUpdated(submitButtonElement);
            if(e.target.dataset.onsuccess != undefined && e.target.dataset.onsuccessparam != undefined) {
                // call function based from dataset.table
                window[e.target.dataset.onsuccess]("", e.target.dataset.onsuccessparam);
            }

            // close current modal
            if(e.target.dataset.modal != undefined) {
                $(`#${e.target.dataset.modal}`).modal('hide');
            }
        }
        else if(e.originalEvent.submitter.dataset.new != undefined)
        {
            window.location.href = `${currentLink[0]}?success=${e.target.dataset.message}&new=${e.originalEvent.submitter.dataset.new}`;
        }
        else {
            window.location.href = `${currentLink[0]}?success=${e.target.dataset.message}`;
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
            // closeButtonElement.click();
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

function generateAlert(message, bgColor) {
    let alert = `
        <div class="alert alert-${bgColor} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    `;
    return alert;
}
