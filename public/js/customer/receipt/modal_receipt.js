/**
 * These are functions for cash_account field
 */
function onReceiptCashAccountDropdownShow(e){
    var dropdownContentElm = e.detail.tagify.DOM.dropdown.content;
}

function onReceiptCashAccountSelectSuggestion(e){
    // checks for data of selected employee
    console.log(e.detail.data);
}

function onReceiptCashAccountRemove(e){

}

function onReceiptCashAccountInput(e) {
    var value = e.detail.value;
    var tagify = e.detail.tagify;
    tagify.whitelist = null // reset the whitelist

    // https://developer.mozilla.org/en-US/docs/Web/API/AbortController/abort
    controller && controller.abort()
    controller = new AbortController()

    // show loading animation and hide the suggestions dropdown
    tagify.loading(true).dropdown.hide()

    fetch('/ajax/settings/coa/cash/search/' + value, {signal:controller.signal})
        .then(RES => RES.json())
        .then(function(newWhitelist){
            tagify.whitelist = newWhitelist // update whitelist Array in-place
            tagify.loading(false).dropdown.show(value) // render the suggestions dropdown
        })
}

/** Auxilary Functions */

// If withholding_check is checked, enable withholding_amount
$('#b_withholding_toggle').change(function() {
    if($(this).is(":checked")) {
        $('#b_withholding').prop('disabled', false);
        $('#b_withholding_required').removeClass('d-none');
    } else {
        $('#b_withholding').prop('disabled', true);
        $('#b_withholding_required').addClass('d-none');
    }
});
