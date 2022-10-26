/**
 * This is for Sales - Cash Account Field
 */

var sales_select_cash_account_elm = document.querySelector('#s_cash_account');

// initialize Tagify on the above input node reference

var sales_select_cash_account_tagify = new Tagify(sales_select_cash_account_elm, {
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
})


sales_select_cash_account_tagify.on('dropdown:show dropdown:updated', onSalesCashAccountDropdownShow)
sales_select_cash_account_tagify.on('dropdown:select', onSalesCashAccountSelectSuggestion)
sales_select_cash_account_tagify.on('input', onSalesCashAccountInput)
sales_select_cash_account_tagify.on('remove', onSalesCashAccountRemove)

var addAllSuggestionsElm;

function onSalesCashAccountDropdownShow(e){
    var dropdownContentElm = e.detail.tagify.DOM.dropdown.content;
}

function onSalesCashAccountSelectSuggestion(e){
    // checks for data of selected employee
    console.log(e.detail.data);
}

function onSalesCashAccountRemove(e){
    
}

function onSalesCashAccountInput(e) {
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
 * This is for the Sales - Tax Field
 */
var sales_select_tax_elm = document.querySelector(`#s_tax`);
var sales_select_tax_tagify = new Tagify(sales_select_tax_elm, {
    tagTextProp: 'label', // very important since a custom template is used with this property as text
    enforceWhitelist: true,
    mode: "select",
    skipInvalid: false, // do not remporarily add invalid tags
    dropdown: {
        closeOnSelect: true,
        enabled: 0,
        classname: 'customer-list',
        searchKeys: ['name'] // very important to set by which keys to search for suggesttions when typing
    },
    templates: {
        tag: TaxTagTemplate,
        dropdownItem: TaxSuggestionItemTemplate
    },
    whitelist: [],
});

sales_select_tax_tagify.on('dropdown:show dropdown:updated', onTaxSalesDropdownShow)
sales_select_tax_tagify.on('dropdown:select', onTaxSalesSelectSuggestion)
sales_select_tax_tagify.on('input', onTaxSalesInput)
sales_select_tax_tagify.on('remove', onTaxSalesRemove)

function onTaxSalesDropdownShow(e) {
    // var dropdownContentElm = e.detail.receipt_select_item_tagify.DOM.dropdown.content;
}

function onTaxSalesSelectSuggestion(e) {
    id = e.detail.tagify.DOM.originalInput.dataset.id;
    // $(`#r_item_tax_percentage_${id}`).val(e.detail.data.percentage);

    calculateReceiptGrandTotal();
}

function onTaxSalesRemove(e) {
    id = e.detail.tagify.DOM.originalInput.dataset.id;
    // $(`#r_item_tax_percentage_${id}`).val(0);

    calculateReceiptGrandTotal();
}

function onTaxSalesInput(e) {    
    var value = e.detail.value;
    var tagify = e.detail.tagify;

    tagify.whitelist = null // reset the whitelist

    // https://developer.mozilla.org/en-US/docs/Web/API/AbortController/abort
    controller && controller.abort()
    controller = new AbortController()

    // show loading animation and hide the suggestions dropdown
    tagify.loading(true).dropdown.hide()

    fetch('/ajax/settings/taxes/search/' + value, {
            signal: controller.signal
        })
        .then(RES => RES.json())
        .then(function (newWhitelist) {
            tagify.whitelist = newWhitelist // update whitelist Array in-place
            tagify.loading(false).dropdown.show(value) // render the suggestions dropdown
        })
}