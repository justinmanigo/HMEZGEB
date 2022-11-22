/**
 * This is for Withholding Payment - Cash Account Field
 */

var withholding_payment_select_cash_account_elm = document.querySelector('#wp_cash_account');

// initialize Tagify on the above input node reference

var withholding_payment_select_cash_account_tagify = new Tagify(withholding_payment_select_cash_account_elm, {
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


withholding_payment_select_cash_account_tagify.on('dropdown:show dropdown:updated', onWithholdingPaymentCashAccountDropdownShow)
withholding_payment_select_cash_account_tagify.on('dropdown:select', onWithholdingPaymentCashAccountSelectSuggestion)
withholding_payment_select_cash_account_tagify.on('input', onWithholdingPaymentCashAccountInput)
withholding_payment_select_cash_account_tagify.on('remove', onWithholdingPaymentCashAccountRemove)

var addAllSuggestionsElm;

function onWithholdingPaymentCashAccountDropdownShow(e){
    var dropdownContentElm = e.detail.tagify.DOM.dropdown.content;
}

function onWithholdingPaymentCashAccountSelectSuggestion(e){
    // checks for data of selected employee
    console.log(e.detail.data);
}

function onWithholdingPaymentCashAccountRemove(e){

}

function onWithholdingPaymentCashAccountInput(e) {
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
 * This is for withholding payment -- period selection UX
 */

var wp_payable = 0;
var wp_periods = [];

$(document).ready(function(){
    $('#modal-withholding-payment').on('shown.bs.modal', function(){
        console.log("Show withholding payment UI.");

        // Show loading
        $("#wp_footer").addClass("d-none");
        $("#wp_body_main").addClass("d-none");
        $("#wp_body_loading").removeClass("d-none");

        var request = $.ajax({
            url: "/ajax/vendors/payments/withholding/all/",
            method: "GET",
        });

        request.done(function(res, status, jqXHR ) {
            console.log(res);
            wp_periods = res;

            let inner = "";

            if (res.length > 0) {
                for (let i = 0; i < res.length; i++) {
                    inner += `
                        <tr>
                            <td>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input wp_period_checkbox" id="wp_period_${res[i].id}" value="${res[i].id}" data-period-number="${res[i].period_number}">
                                    <label class="custom-control-label" for="wp_period_${res[i].id}">Period # ${res[i].period_number}</label>
                                </div>
                            </td>
                            <td>${res[i].date_from} to ${res[i].date_to}</td>
                            <td>
                                <span class='badge badge-secondary'>N/A</span>
                            </td>
                            <td class="text-right">${parseFloat(res[i].total_withholdings).toFixed(2)}</td>
                        </tr>
                    `;
                }
            }

            $("#wp_periods").html(inner);
        });

        request.fail(function(jqXHR, status, error) {
            console.log("Error fetching withholding payables data.");
        });

        request.always(function(){
            $("#wp_footer").removeClass("d-none");
            $("#wp_body_main").removeClass("d-none");
            $("#wp_body_loading").addClass("d-none");
        });
    });

    $('#modal-withholding-payment').on('hidden.bs.modal', function(){
        console.log("Hide withholding payment UI.");
        $("#wp_footer").addClass("d-none");
        $("#wp_body_main").addClass("d-none");
        $("#wp_body_loading").removeClass("d-none");
    });

    $("#wp_select_all").on('click', function(){
        console.log("Clicked wp_select_all");

        let checked = $(this).prop('checked');
        $(".wp_period_checkbox").prop('checked', checked);

        // Get total withholding payables by iterating on wp_periods
        if (checked) {
            wp_payable = 0;
            for(i = 0; i < 12; i++) {
                wp_payable += parseFloat(wp_periods[i].total_withholdings);
            }
        } else {
            wp_payable = parseFloat(0);
        }

        $('#wp_total_withholding_payable').html(wp_payable.toFixed(2));
    });

    // set select all to neutral when not all buttons are clicked
    $("#wp_periods").on('click', '.wp_period_checkbox', function(){
        console.log("Clicked wp_period_checkbox");
        console.log($(this));

        // Check result of clicked checkbox
        let checked = $(this).prop('checked');

        // Depending on checked, deduct or add to wp_payable
        if (checked) {
            wp_payable += parseFloat(wp_periods[$(this).data('period-number') - 1].total_withholdings);
        } else {
            wp_payable -= parseFloat(wp_periods[$(this).data('period-number') - 1].total_withholdings);
        }

        $('#wp_total_withholding_payable').html(wp_payable.toFixed(2));

        // Check if all checkboxes are checked
        let all_checked = true;
        $(".wp_period_checkbox").each(function(){
            if (!$(this).prop('checked')) {
                all_checked = false;
            }
        });

        $("#wp_select_all").prop('checked', all_checked);
    });
});
