var pp_current_account_balance = 0.00
var pp_payroll_amount = 0.00
var pp_balance_after_transaction = 0.00

/**
 * This is for Payroll Payment Cash Account Field
 */

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


payroll_payment_select_cash_account_tagify.on('dropdown:show dropdown:updated', onPayrollPaymentCashAccountDropdownShow)
payroll_payment_select_cash_account_tagify.on('dropdown:select', onPayrollPaymentCashAccountSelectSuggestion)
payroll_payment_select_cash_account_tagify.on('input', onPayrollPaymentCashAccountInput)
payroll_payment_select_cash_account_tagify.on('remove', onPayrollPaymentCashAccountRemove)

var addAllSuggestionsElm;

function onPayrollPaymentCashAccountDropdownShow(e){
    var dropdownContentElm = e.detail.tagify.DOM.dropdown.content;
}

function onPayrollPaymentCashAccountSelectSuggestion(e){
    // checks for data of selected employee
    console.log(e.detail.data);

    const formatter = new Intl.NumberFormat('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    });

    pp_current_account_balance = parseFloat(e.detail.data.balance_if_debit);
    pp_balance_after_transaction = pp_current_account_balance - pp_payroll_amount;

    $('#pp_cash_account_current_balance').html(formatter.format(pp_current_account_balance));
    $('#pp_payroll_amount').html(formatter.format(pp_payroll_amount));
    $('#pp_cash_account_balance_after_transaction').html(formatter.format(pp_balance_after_transaction));

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

function onPayrollPaymentCashAccountRemove(e){
    const formatter = new Intl.NumberFormat('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    });

    pp_current_account_balance = 0.00
    pp_balance_after_transaction = pp_current_account_balance - pp_payroll_amount;

    $('#pp_cash_account_current_balance').html(formatter.format(pp_current_account_balance));
    $('#pp_payroll_amount').html(formatter.format(pp_payroll_amount));
    $('#pp_cash_account_balance_after_transaction').html(formatter.format(pp_balance_after_transaction));
}

function onPayrollPaymentCashAccountInput(e) {
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

/**
 * This is for Payroll Payment Period Field
 */

 var payroll_payment_select_period_elm = document.querySelector('#pp_payroll_period');

// initialize Tagify on the above input node reference

var payroll_payment_select_cash_account_tagify = new Tagify(payroll_payment_select_period_elm, {
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
        tag: payrollPeriodTagTemplate,
        dropdownItem: payrollPeriodSuggestionItemTemplate
    },
    whitelist: [],
}
)
 
 
payroll_payment_select_cash_account_tagify.on('dropdown:show dropdown:updated', onPayrollPaymentPeriodDropdownShow)
payroll_payment_select_cash_account_tagify.on('dropdown:select', onPayrollPaymentPeriodSelectSuggestion)
payroll_payment_select_cash_account_tagify.on('input', onPayrollPaymentPeriodInput)
payroll_payment_select_cash_account_tagify.on('remove', onPayrollPaymentPeriodRemove)

var addAllSuggestionsElm;

function onPayrollPaymentPeriodDropdownShow(e){
    var dropdownContentElm = e.detail.tagify.DOM.dropdown.content;
}

function onPayrollPaymentPeriodSelectSuggestion(e){
    // checks for data of selected employee
    console.log(e.detail.data);

    const formatter = new Intl.NumberFormat('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    });

    pp_payroll_amount = parseFloat(e.detail.data.balance);
    pp_balance_after_transaction = pp_current_account_balance - pp_payroll_amount;

    $('#pp_cash_account_current_balance').html(formatter.format(pp_current_account_balance));
    $('#pp_payroll_amount').html(formatter.format(pp_payroll_amount));
    $('#pp_cash_account_balance_after_transaction').html(formatter.format(pp_balance_after_transaction));

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
 
 function onPayrollPaymentPeriodRemove(e){
    const formatter = new Intl.NumberFormat('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    });

    pp_payroll_amount = 0.00;
    pp_balance_after_transaction = pp_current_account_balance - pp_payroll_amount;

    $('#pp_cash_account_current_balance').html(formatter.format(pp_current_account_balance));
    $('#pp_payroll_amount').html(formatter.format(pp_payroll_amount));
    $('#pp_cash_account_balance_after_transaction').html(formatter.format(pp_balance_after_transaction));
 }
 
function onPayrollPaymentPeriodInput(e) {
    var value = e.detail.value;
    var tagify = e.detail.tagify;
    tagify.whitelist = null // reset the whitelist

    // https://developer.mozilla.org/en-US/docs/Web/API/AbortController/abort
    controller && controller.abort()
    controller = new AbortController()

    // show loading animation and hide the suggestions dropdown
    tagify.loading(true).dropdown.hide()

    fetch('/ajax/hr/payrolls/unpaid/search/' + value, {signal:controller.signal})
        .then(RES => RES.json())
        .then(function(newWhitelist){
            tagify.whitelist = newWhitelist // update whitelist Array in-place
            tagify.loading(false).dropdown.show(value) // render the suggestions dropdown
        })
}