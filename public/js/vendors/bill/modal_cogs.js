

var addAllSuggestionsElm;


function onCOGSCashAccountDropdownShow(e){
    var dropdownContentElm = e.detail.tagify.DOM.dropdown.content;
}

function onCOGSCashAccountSelectSuggestion(e){
    // checks for data of selected employee
    console.log(e.detail.data);
}

function onCOGSCashAccountRemove(e){

}

function onCOGSCashAccountInput(e) {
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
 * This is for the COGS - Tax Field
 */
var COGcogs_select_tax_elm = document.querySelector(`#cogs_tax`);
var COGcogs_tax_percentage = 0.00;

var COGcogs_select_tax_tagify = new Tagify(COGcogs_select_tax_elm, {
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

COGcogs_select_tax_tagify.on('dropdown:show dropdown:updated', onTaxCOGSDropdownShow)
COGcogs_select_tax_tagify.on('dropdown:select', onTaxCOGSSelectSuggestion)
COGcogs_select_tax_tagify.on('input', onTaxCOGSInput)
COGcogs_select_tax_tagify.on('remove', onTaxCOGSRemove)

function onTaxCOGSDropdownShow(e) {
    // var dropdownContentElm = e.detail.receipt_select_item_tagify.DOM.dropdown.content;
}

function onTaxCOGSSelectSuggestion(e) {
    id = e.detail.tagify.DOM.originalInput.dataset.id;
    // $(`#r_item_tax_percentage_${id}`).val(e.detail.data.percentage);

    let price_amount = parseFloat($('#cogs_price_amount').val());
    COGcogs_tax_percentage = parseFloat(e.detail.data.percentage) / 100;
    let tax_amount = price_amount * COGcogs_tax_percentage;

    console.log(price_amount);
    console.log(tax_amount);

    $("#cogs_tax_amount").val(tax_amount.toFixed(2));

    calculateCOGSGrandTotal()
}

function onTaxCOGSRemove(e) {
    id = e.detail.tagify.DOM.originalInput.dataset.id;
    // $(`#r_item_tax_percentage_${id}`).val(0);
    let price_amount = parseFloat($('#cogs_price_amount').val());
    COGcogs_tax_percentage = 0.00;
    let tax_amount = 0.00;

    $("#cogs_tax_amount").val(tax_amount.toFixed(2));

    calculateCOGSGrandTotal()
}

function onTaxCOGSInput(e) {
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

function calculateCOGSGrandTotal()
{
    let price_amount = parseFloat($('#cogs_price_amount').val());
    let tax_amount = parseFloat($('#cogs_tax_amount').val());
    let discount_amount = parseFloat($('#cogs_discount_amount').val());

    let sub_total = price_amount + tax_amount;
    let grand_total = sub_total - discount_amount;

    $("#cogs_sub_total").val(sub_total.toFixed(2));
    $("#cogs_grand_total").val(grand_total.toFixed(2));

    // Check if total_amount_received > grand_total
    let total_amount_received = parseFloat($('#cogs_total_amount_received').val());
    if(total_amount_received >= grand_total)
    {
        $('#cogs_total_amount_received').val(grand_total.toFixed(2));
        $('#cogs_payment_type').val('cash');
    }
    else if(grand_total > total_amount_received)
    {
        $('#cogs_payment_type').val('credit');
    }
}

// If the cogs_price_amount is updated, then update the grand total
$('#cogs_price_amount').on('change', function(){
    let price_amount = parseFloat($('#cogs_price_amount').val());
    // console.log(COGcogs_select_cash_account_tagify)
    let tax_amount = price_amount * COGcogs_tax_percentage;
    $("#cogs_tax_amount").val(tax_amount.toFixed(2));
    calculateCOGSGrandTotal();
});

// If the cogs_discount_amount is updated, then update the grand total
$('#cogs_discount_amount').on('change', function(){
    let discount_amount = parseFloat($('#cogs_discount_amount').val());
    // console.log(COGcogs_select_cash_account_tagify)
    calculateCOGSGrandTotal();
});

// If withholding_check is checked, enable withholding_amount
$('#cogs_withholding_toggle').change(function() {
    if($(this).is(":checked")) {
        $('#cogs_withholding_amount').prop('disabled', false);
        $('#cogs_withholding_required').removeClass('d-none');
    } else {
        $('#cogs_withholding_amount').prop('disabled', true);
        $('#cogs_withholding_required').addClass('d-none');
    }
});

// If cogs_payment_type is selected and the value is 'cash', then
// match the cogs_grand_total with cogs_total_amount_received
$('#cogs_payment_type').on('change', function(){
    if($(this).val() == 'cash') {
        $('#cogs_total_amount_received').val($('#cogs_grand_total').val());
    } else {
        $('#cogs_total_amount_received').val(0);
    }
});

$('#cogs_total_amount_received').on('change', function(){
    // If cogs_total_amount_received is changed, check if it is greater than cogs_grand_total
    let total_amount_received = parseFloat($('#cogs_total_amount_received').val());
    let grand_total = parseFloat($('#cogs_grand_total').val());

    // If cogs_total_amount_received >= cogs_grand_total, auto set cogs_payment_type to 'cash'.
    // Also match total_amount_received to grand_total
    if(total_amount_received >= grand_total) {
        $('#cogs_total_amount_received').val(grand_total);
        $('#cogs_payment_type').val('cash');
    }
    else {
        $('#cogs_payment_type').val('credit');
    }

});
