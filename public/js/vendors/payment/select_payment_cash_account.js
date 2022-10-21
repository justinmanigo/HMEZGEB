var payroll_payment_select_cash_account_elm = document.querySelector('#pp_cash_account');

// initialize Tagify on the above input node reference

var payroll_payment_select_cash_account_tagify = new Tagify(payroll_payment_select_cash_account_elm, {
    tagTextProp: 'label', // very important since a custom template is used with this property as text
    enforceWhitelist: true,
    mode : "select",
    skipInvalid: false, // do not remporarily add invalid tags
    dropdown: {
        closeOnSelect: true,
        enabled: 0,
        classname: 'customer-list',
        searchKeys: ['label'] // very important to set by which keys to search for suggesttions when typing
    },
    templates: {
        tag: cashAccountTagTemplate,
        dropdownItem: cashAccountSuggestionItemTemplate
    },
    whitelist: [],
}
)


payroll_payment_select_cash_account_tagify.on('dropdown:show dropdown:updated', onPaymentCashAccountDropdownShow)
payroll_payment_select_cash_account_tagify.on('dropdown:select', onPaymentCashAccountSelectSuggestion)
payroll_payment_select_cash_account_tagify.on('input', onPaymentCashAccountInput)
payroll_payment_select_cash_account_tagify.on('remove', onPaymentCashAccountRemove)

var addAllSuggestionsElm;

function onPaymentCashAccountDropdownShow(e){
    var dropdownContentElm = e.detail.tagify.DOM.dropdown.content;
}

function onPaymentCashAccountSelectSuggestion(e){
    // checks for data of selected employee
    console.log(e.detail.data);

    // $("#c_employee_id").val(e.detail.data.value)
    // $("#c_employee").val(e.detail.data.name)
    // $("#c_tin_number").val(e.detail.data.tin_number)

    // Get data from server.
    // var request = $.ajax({
    //     url: "/ajax/employee/commission/topay/" + e.detail.data.value,
    //     method: "GET",
    // });
        
    // request.done(function(res, status, jqXHR ) {
    //     console.log(res);
    //     for(i = 0; i < res.length; i++)
    //     {   
    //         createWithholdingToPayEntry(res[i]);
    //     }
    // });
    
    // request.fail(function(jqXHR, status, error) {
    //     console.log(error);
    // });
}

function onPaymentCashAccountRemove(e){
    // $("#c_employee_id").val("")
    // $("#c_tin_number").val("")
}

function onPaymentCashAccountInput(e) {
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