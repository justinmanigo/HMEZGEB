/**
 * == ON FINISH LOAD ==
 */

var defaultsWhitelist;
var cogs_select_cash_account_elm = document.querySelector('#cogs_cash_account');
var cogs_select_cash_account_tagify;

var expense_select_cash_account_elm = document.querySelector('#expense_cash_account');
var expense_select_cash_account_tagify;

var bill_select_cash_account_elm = document.querySelector('#b_cash_account');
var bill_select_cash_account_tagify;

// Fetch the defaults for Customer
fetch('/ajax/settings/defaults')
.then(RES => RES.json())
.then(function (res) {
    console.log("Load defaults:")
    // console.log(res)

    console.log(res.bill_cash_on_hand)
    defaultsWhitelist = [
        {
            "value": res.bill_cash_on_hand.id,
            "chart_of_account_no": res.bill_cash_on_hand.chart_of_account_no,
            "total_debit": res.bill_cash_on_hand.total_debit,
            "total_credit": res.bill_cash_on_hand.total_credit,
            "balance_if_debit": res.bill_cash_on_hand.current_balance,
            "label": res.bill_cash_on_hand.chart_of_account_no + " - " + res.bill_cash_on_hand.account_name,
            "account_name": res.bill_cash_on_hand.name,
        }
    ];

    // cogs_select_cash_account_tagify.whitelist = newWhitelist // update whitelist Array in-place
    $(`#cogs_cash_account`).val(defaultsWhitelist[0].label);
    $(`#expense_cash_account`).val(defaultsWhitelist[0].label);
    $(`#b_cash_account`).val(defaultsWhitelist[0].label);

    // COGS

    cogs_select_cash_account_tagify = new Tagify(cogs_select_cash_account_elm, {
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
        whitelist: defaultsWhitelist, // require `default_values.js`
    })

    cogs_select_cash_account_tagify.on('dropdown:show dropdown:updated', onCOGSCashAccountDropdownShow)
    cogs_select_cash_account_tagify.on('dropdown:select', onCOGSCashAccountSelectSuggestion)
    cogs_select_cash_account_tagify.on('input', onCOGSCashAccountInput)
    cogs_select_cash_account_tagify.on('remove', onCOGSCashAccountRemove)

    // Expense

    expense_select_cash_account_tagify = new Tagify(expense_select_cash_account_elm, {
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
        whitelist: defaultsWhitelist, // require `default_values.js`
    })

    expense_select_cash_account_tagify.on('dropdown:show dropdown:updated', onExpenseCashAccountDropdownShow)
    expense_select_cash_account_tagify.on('dropdown:select', onExpenseCashAccountSelectSuggestion)
    expense_select_cash_account_tagify.on('input', onExpenseCashAccountInput)
    expense_select_cash_account_tagify.on('remove', onExpenseCashAccountRemove)

    // Bill

    bill_select_cash_account_tagify = new Tagify(bill_select_cash_account_elm, {
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
        whitelist: defaultsWhitelist, // require `default_values.js`
    })

    bill_select_cash_account_tagify.on('dropdown:show dropdown:updated', onBillCashAccountDropdownShow)
    bill_select_cash_account_tagify.on('dropdown:select', onBillCashAccountSelectSuggestion)
    bill_select_cash_account_tagify.on('input', onBillCashAccountInput)
    bill_select_cash_account_tagify.on('remove', onBillCashAccountRemove)
});
