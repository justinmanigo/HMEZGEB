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

    let price_amount = parseFloat($('#s_price_amount').val());
    let tax_amount = price_amount * (parseFloat(e.detail.data.percentage) / 100);

    console.log(price_amount);
    console.log(tax_amount);

    $("#s_tax_amount").val(tax_amount.toFixed(2));

    calculateSalesGrandTotal()
}

function onTaxSalesRemove(e) {
    id = e.detail.tagify.DOM.originalInput.dataset.id;
    // $(`#r_item_tax_percentage_${id}`).val(0);
    let price_amount = parseFloat($('#s_price_amount').val());
    let tax_amount = 0.00;

    $("#s_tax_amount").val(tax_amount.toFixed(2));

    calculateSalesGrandTotal()
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

/** 
 * Auxilary Functions 
 */

function calculateSalesGrandTotal()
{
    let price_amount = parseFloat($('#s_price_amount').val());
    let tax_amount = parseFloat($('#s_tax_amount').val());
    let grand_total = price_amount + tax_amount;

    $("#s_grand_total").val(grand_total.toFixed(2));
}

// If withholding_check is checked, enable withholding_amount
$('#s_withholding_toggle').change(function() {
    if($(this).is(":checked")) {
        $('#s_withholding_amount').prop('disabled', false);
        $('#s_withholding_required').removeClass('d-none');
    } else {
        $('#s_withholding_amount').prop('disabled', true);
        $('#s_withholding_required').addClass('d-none');

    }
});