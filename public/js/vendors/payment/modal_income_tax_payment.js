var itp_current_account_balance = 0.00
var itp_income_tax_amount = 0.00
var itp_balance_after_transaction = 0.00

function onIncomeTaxPaymentCashAccountDropdownShow(e){
    var dropdownContentElm = e.detail.tagify.DOM.dropdown.content;
}

function onIncomeTaxPaymentCashAccountSelectSuggestion(e){
    // checks for data of selected employee
    console.log(e.detail.data);

    const formatter = new Intl.NumberFormat('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    });

    itp_current_account_balance = parseFloat(e.detail.data.balance_if_debit);
    itp_balance_after_transaction = itp_current_account_balance - itp_income_tax_amount;

    $('#itp_cash_account_current_balance').html(formatter.format(itp_current_account_balance));
    $('#itp_income_tax_amount').html(formatter.format(itp_income_tax_amount));
    $('#itp_cash_account_balance_after_transaction').html(formatter.format(itp_balance_after_transaction));

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

function onIncomeTaxPaymentCashAccountRemove(e){
    const formatter = new Intl.NumberFormat('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    });

    itp_current_account_balance = 0.00
    itp_balance_after_transaction = itp_current_account_balance - itp_income_tax_amount;

    $('#itp_cash_account_current_balance').html(formatter.format(itp_current_account_balance));
    $('#itp_income_tax_amount').html(formatter.format(itp_income_tax_amount));
    $('#itp_cash_account_balance_after_transaction').html(formatter.format(itp_balance_after_transaction));
}

function onIncomeTaxPaymentCashAccountInput(e) {
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

 var income_tax_payment_select_period_elm = document.querySelector('#itp_payroll_period');

// initialize Tagify on the above input node reference

var income_tax_payment_select_cash_account_tagify = new Tagify(income_tax_payment_select_period_elm, {
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


income_tax_payment_select_cash_account_tagify.on('dropdown:show dropdown:updated', onIncomeTaxPaymentPeriodDropdownShow)
income_tax_payment_select_cash_account_tagify.on('dropdown:select', onIncomeTaxPaymentPeriodSelectSuggestion)
income_tax_payment_select_cash_account_tagify.on('input', onIncomeTaxPaymentPeriodInput)
income_tax_payment_select_cash_account_tagify.on('remove', onIncomeTaxPaymentPeriodRemove)

var addAllSuggestionsElm;

function onIncomeTaxPaymentPeriodDropdownShow(e){
    var dropdownContentElm = e.detail.tagify.DOM.dropdown.content;
}

function onIncomeTaxPaymentPeriodSelectSuggestion(e){
    // checks for data of selected employee
    console.log(e.detail.data);

    const formatter = new Intl.NumberFormat('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    });

    itp_income_tax_amount = parseFloat(e.detail.data.balance);
    itp_balance_after_transaction = itp_current_account_balance - itp_income_tax_amount;

    $('#itp_cash_account_current_balance').html(formatter.format(itp_current_account_balance));
    $('#itp_income_tax_amount').html(formatter.format(itp_income_tax_amount));
    $('#itp_cash_account_balance_after_transaction').html(formatter.format(itp_balance_after_transaction));

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

 function onIncomeTaxPaymentPeriodRemove(e){
    const formatter = new Intl.NumberFormat('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    });

    itp_income_tax_amount = 0.00;
    itp_balance_after_transaction = itp_current_account_balance - itp_income_tax_amount;

    $('#itp_cash_account_current_balance').html(formatter.format(itp_current_account_balance));
    $('#itp_income_tax_amount').html(formatter.format(itp_income_tax_amount));
    $('#itp_cash_account_balance_after_transaction').html(formatter.format(itp_balance_after_transaction));
 }

function onIncomeTaxPaymentPeriodInput(e) {
    var value = e.detail.value;
    var tagify = e.detail.tagify;
    tagify.whitelist = null // reset the whitelist

    // https://developer.mozilla.org/en-US/docs/Web/API/AbortController/abort
    controller && controller.abort()
    controller = new AbortController()

    // show loading animation and hide the suggestions dropdown
    tagify.loading(true).dropdown.hide()

    fetch('/ajax/vendors/payments/incometax/unpaid/search/' + value, {signal:controller.signal})
        .then(RES => RES.json())
        .then(function(newWhitelist){
            tagify.whitelist = newWhitelist // update whitelist Array in-place
            tagify.loading(false).dropdown.show(value) // render the suggestions dropdown
        })
}
