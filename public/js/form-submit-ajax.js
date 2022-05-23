// 1. Add .ajax-submit class as one of the form's class names.
// 2. Error elements must have an id with following format:
//      #error-{form-name}-{input-field}
// 3. Error elements should also have a data-field bearing the related input's name.
// 4. Submit button must have an id with following format:
//      #submit-{form-name}
// 5. Close button must have an id with following format:
//      #close-{form-name}

$(".ajax-submit").submit(function(e){
    console.log(`Submitting form ${e.target.id}`);
    console.log(e);
    e.preventDefault();

    var errorTextElements = [], submitButtonElement, closeButtonElement;
    
    console.log(`Getting errorTextElements, submitButtonElement, and closeButtonElement`);
    console.log(e.target);
    for(i = 0; i < e.target.length; i++)
    {
        let name = e.target[i].name;
        let data = e.target[i].dataset;
        if(name != undefined && name != '' && name != '_token' && name != '_method')
        {
            console.log(`Found input element: ${name}`);
            errorTextElements.push($(`#error-${e.target.id}-${name}`));
        }
    }

    closeButtonElement = $(`#close-${e.target.id}`);
    submitButtonElement = $(`#submit-${e.target.id}`);

    // Hide error elements and disable submit button.
    hideFormErrors(errorTextElements);
    disableSubmitButton(submitButtonElement);

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
        generateAlert(res, 'alert-success');

        console.log("TEST");

        if(e.target.dataset.model != undefined)
        {
            request = window[e.target.dataset.model + 'Table'].requestData();
            processRequest(request, window[e.target.dataset.model + 'Table']);
        }
        if(e.target.dataset.reload != undefined)
        {
            window.location.reload();
        }
    });

    // If request has errors (e.g. validation errors).
    request.fail(function(jqXHR, status, error){
        console.log(`Request for ${e.target.id} has failed.`);
        console.log(jqXHR);

        if(jqXHR.status != 422)
        {
            console.log(jqXHR.responseJSON.message);
            generateAlert(jqXHR.responseJSON.message, 'alert-danger');
            closeButtonElement.click();
        }
        else
        {
            console.log(jqXHR.responseJSON.errors);
            showFormErrors(errorTextElements, jqXHR.responseJSON.errors);
        }

    });

    // The following always executes regardless of status.
    request.always(function() {
        enableSubmitButton(submitButtonElement);
    });
});

function hideFormErrors(errorTextElements)
{
    errorTextElements.forEach(function(e){
        e.hide();
    });
}

function showFormErrors(errorTextElements, errors)
{
    error_list = Object.keys(errors);
    errorTextElements.forEach(function(e){
        err = e[0].dataset.field;
        if(isErrorInArray(error_list, err)){
            e.show().html(errors[err][0]);
        }
    });
}

function isErrorInArray(error_list, err)
{
    var res = false;
    error_list.forEach(function(e){
        if(e == err) res = true;
    });
    return res;
}

function enableSubmitButton(btn) {
    btn.removeAttr('disabled');
}

function disableSubmitButton(btn) {
    btn.attr('disabled', true);
}

function generateAlert(res, alert_color)
{
    var inner = `
    <div class="alert ${alert_color} alert-dismissible fade show" role="alert">
        ${res}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    `;

    $("#alert-container").append(inner);
}