/**
 * == ON FINISH LOAD ==
 */

var defaultsWhitelist;
var sales_select_cash_account_elm = document.querySelector('#s_cash_account');
var sales_select_cash_account_tagify;

var receipt_select_cash_account_elm = document.querySelector('#r_cash_account');
var receipt_select_cash_account_tagify;

var credit_receipt_select_cash_account_elm = document.querySelector('#cr_cash_account');
var credit_receipt_select_cash_account_tagify;

// Fetch the defaults for Customer
fetch('/ajax/settings/defaults')
.then(RES => RES.json())
.then(function (res) {
    console.log("Load defaults:")
    // console.log(res)

    console.log(res.receipt_cash_on_hand)
    defaultsWhitelist = [
        {
            "value": res.receipt_cash_on_hand.id,
            "chart_of_account_no": res.receipt_cash_on_hand.chart_of_account_no,
            "total_debit": res.receipt_cash_on_hand.total_debit,
            "total_credit": res.receipt_cash_on_hand.total_credit,
            "balance_if_debit": res.receipt_cash_on_hand.current_balance,
            "label": res.receipt_cash_on_hand.chart_of_account_no + " - " + res.receipt_cash_on_hand.account_name,
            "account_name": res.receipt_cash_on_hand.name,
        }
    ];

    // sales_select_cash_account_tagify.whitelist = newWhitelist // update whitelist Array in-place
    $(`#s_cash_account`).val(defaultsWhitelist[0].label);
    $(`#r_cash_account`).val(defaultsWhitelist[0].label);
    $(`#cr_cash_account`).val(defaultsWhitelist[0].label);

    // Sales

    sales_select_cash_account_tagify = new Tagify(sales_select_cash_account_elm, {
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

    sales_select_cash_account_tagify.on('dropdown:show dropdown:updated', onSalesCashAccountDropdownShow)
    sales_select_cash_account_tagify.on('dropdown:select', onSalesCashAccountSelectSuggestion)
    sales_select_cash_account_tagify.on('input', onSalesCashAccountInput)
    sales_select_cash_account_tagify.on('remove', onSalesCashAccountRemove)

    // Receipt

    receipt_select_cash_account_tagify = new Tagify(receipt_select_cash_account_elm, {
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

    receipt_select_cash_account_tagify.on('dropdown:show dropdown:updated', onReceiptCashAccountDropdownShow)
    receipt_select_cash_account_tagify.on('dropdown:select', onReceiptCashAccountSelectSuggestion)
    receipt_select_cash_account_tagify.on('input', onReceiptCashAccountInput)
    receipt_select_cash_account_tagify.on('remove', onReceiptCashAccountRemove)

    // Credit Receipt
    credit_receipt_select_cash_account_tagify = new Tagify(credit_receipt_select_cash_account_elm, {
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

    credit_receipt_select_cash_account_tagify.on('dropdown:show dropdown:updated', onCreditReceiptCashAccountDropdownShow)
    credit_receipt_select_cash_account_tagify.on('dropdown:select', onCreditReceiptCashAccountSelectSuggestion)
    credit_receipt_select_cash_account_tagify.on('input', onCreditReceiptCashAccountInput)
    credit_receipt_select_cash_account_tagify.on('remove', onCreditReceiptCashAccountRemove)
});
