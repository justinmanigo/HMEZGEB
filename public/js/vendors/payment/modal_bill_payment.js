/**
 * These are functions for cash_account field
 */
function onBillPaymentCashAccountDropdownShow(e){
    var dropdownContentElm = e.detail.tagify.DOM.dropdown.content;
}

function onBillPaymentCashAccountSelectSuggestion(e){
    // checks for data of selected employee
    console.log(e.detail.data);
}

function onBillPaymentCashAccountRemove(e){

}

function onBillPaymentCashAccountInput(e) {
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
