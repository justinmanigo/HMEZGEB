/**
 * == ON FINISH LOAD ==
 */

var defaultsWhitelist;

var bill_payment_select_cash_account_elm = document.querySelector('#b_cash_account');
var bill_payment_select_cash_account_tagify;

var withholding_payment_select_cash_account_elm = document.querySelector('#wp_cash_account');
var withholding_payment_select_cash_account_tagify;

var payroll_payment_select_cash_account_elm = document.querySelector('#pp_cash_account');
var payroll_payment_select_cash_account_tagify;

var income_tax_payment_select_cash_account_elm = document.querySelector('#itp_cash_account');
var income_tax_payment_select_cash_account_tagify;

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

    $(`#b_cash_account`).val(defaultsWhitelist[0].label);
    $(`#wp_cash_account`).val(defaultsWhitelist[0].label);
    $(`#pp_cash_account`).val(defaultsWhitelist[0].label);
    $(`#itp_cash_account`).val(defaultsWhitelist[0].label);

    // Bill

    bill_payment_select_cash_account_tagify = new Tagify(bill_payment_select_cash_account_elm, {
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

    bill_payment_select_cash_account_tagify.on('dropdown:show dropdown:updated', onBillPaymentCashAccountDropdownShow)
    bill_payment_select_cash_account_tagify.on('dropdown:select', onBillPaymentCashAccountSelectSuggestion)
    bill_payment_select_cash_account_tagify.on('input', onBillPaymentCashAccountInput)
    bill_payment_select_cash_account_tagify.on('remove', onBillPaymentCashAccountRemove)

    // Withholding
    withholding_payment_select_cash_account_tagify = new Tagify(withholding_payment_select_cash_account_elm, {
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

    withholding_payment_select_cash_account_tagify.on('dropdown:show dropdown:updated', onWithholdingPaymentCashAccountDropdownShow)
    withholding_payment_select_cash_account_tagify.on('dropdown:select', onWithholdingPaymentCashAccountSelectSuggestion)
    withholding_payment_select_cash_account_tagify.on('input', onWithholdingPaymentCashAccountInput)
    withholding_payment_select_cash_account_tagify.on('remove', onWithholdingPaymentCashAccountRemove)

    // Payroll
    payroll_payment_select_cash_account_tagify = new Tagify(payroll_payment_select_cash_account_elm, {
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

    payroll_payment_select_cash_account_tagify.on('dropdown:show dropdown:updated', onPayrollPaymentCashAccountDropdownShow)
    payroll_payment_select_cash_account_tagify.on('dropdown:select', onPayrollPaymentCashAccountSelectSuggestion)
    payroll_payment_select_cash_account_tagify.on('input', onPayrollPaymentCashAccountInput)
    payroll_payment_select_cash_account_tagify.on('remove', onPayrollPaymentCashAccountRemove)

    // Income Tax
    income_tax_payment_select_cash_account_tagify = new Tagify(income_tax_payment_select_cash_account_elm, {
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

    income_tax_payment_select_cash_account_tagify.on('dropdown:show dropdown:updated', onIncomeTaxPaymentCashAccountDropdownShow)
    income_tax_payment_select_cash_account_tagify.on('dropdown:select', onIncomeTaxPaymentCashAccountSelectSuggestion)
    income_tax_payment_select_cash_account_tagify.on('input', onIncomeTaxPaymentCashAccountInput)
    income_tax_payment_select_cash_account_tagify.on('remove', onIncomeTaxPaymentCashAccountRemove)
});
