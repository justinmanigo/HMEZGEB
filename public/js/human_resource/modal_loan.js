/**
 * This is for Payroll Payment Cash Account Field
 */

var loan_select_cash_account_elm = document.querySelector('#l_cash_account');

// initialize Tagify on the above input node reference

var loan_select_cash_account_tagify = new Tagify(loan_select_cash_account_elm, {
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


loan_select_cash_account_tagify.on('dropdown:show dropdown:updated', onLoanCashAccountDropdownShow)
loan_select_cash_account_tagify.on('dropdown:select', onLoanCashAccountSelectSuggestion)
loan_select_cash_account_tagify.on('input', onLoanCashAccountInput)
loan_select_cash_account_tagify.on('remove', onLoanCashAccountRemove)

var addAllSuggestionsElm;

function onLoanCashAccountDropdownShow(e){
    var dropdownContentElm = e.detail.tagify.DOM.dropdown.content;
}

function onLoanCashAccountSelectSuggestion(e){
    // checks for data of selected employee
    console.log(e.detail.data);

    // const formatter = new Intl.NumberFormat('en-US', {
    //     minimumFractionDigits: 2,
    //     maximumFractionDigits: 2,
    // });

    // l_current_account_balance = parseFloat(e.detail.data.balance_if_debit);
    // l_balance_after_transaction = l_current_account_balance - l_payroll_amount;

    // $('#l_cash_account_current_balance').html(formatter.format(l_current_account_balance));
    // $('#l_payroll_amount').html(formatter.format(l_payroll_amount));
    // $('#l_cash_account_balance_after_transaction').html(formatter.format(l_balance_after_transaction));

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

function onLoanCashAccountRemove(e){
    // const formatter = new Intl.NumberFormat('en-US', {
    //     minimumFractionDigits: 2,
    //     maximumFractionDigits: 2,
    // });

    // l_current_account_balance = 0.00
    // l_balance_after_transaction = l_current_account_balance - l_payroll_amount;

    // $('#l_cash_account_current_balance').html(formatter.format(l_current_account_balance));
    // $('#l_payroll_amount').html(formatter.format(l_payroll_amount));
    // $('#l_cash_account_balance_after_transaction').html(formatter.format(l_balance_after_transaction));
}

function onLoanCashAccountInput(e) {
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