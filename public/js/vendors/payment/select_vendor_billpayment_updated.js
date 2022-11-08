var billpayment_select_vendor_elm = document.querySelector('#b_vendor');
var billpayment_select_bill_elm = document.querySelector('#b_bill');

// initialize Tagify on the above input node reference
var billpayment_select_vendor_tagify = new Tagify(billpayment_select_vendor_elm, {
    tagTextProp: 'name', // very important since a custom template is used with this property as text
    enforceWhitelist: true,
    mode : "select",
    skipInvalid: false, // do not remporarily add invalid tags
    dropdown: {
        closeOnSelect: true,
        enabled: 0,
        classname: 'customers-list',
        searchKeys: ['name', 'email']  // very important to set by which keys to search for suggesttions when typing
    },
    templates: {
        tag: vendorTagTemplate,
        dropdownItem: vendorSuggestionItemTemplate
    },
    whitelist: [],
    // whitelist: [
    //     {
    //         "value": 1,
    //         "name": "Justinian Hattersley",
    //         "avatar": "https://i.pravatar.cc/80?img=1",
    //         "email": "jhattersley0@ucsd.edu"
    //     },
    //     {
    //         "value": 2,
    //         "name": "Antons Esson",
    //         "avatar": "https://i.pravatar.cc/80?img=2",
    //         "email": "aesson1@ning.com"
    //     },
    // ]
})

billpayment_select_vendor_tagify.on('dropdown:show dropdown:updated', onDropdownShow)
billpayment_select_vendor_tagify.on('dropdown:select', onBillPaymentVendorSelectSuggestion)
billpayment_select_vendor_tagify.on('input', onBillPaymentVendorInput)
billpayment_select_vendor_tagify.on('remove', onBillPaymentVendorRemove)

//

// initialize Tagify on the above input node reference
var billpayment_select_bill_tagify = new Tagify(billpayment_select_bill_elm, {
    tagTextProp: 'name', // very important since a custom template is used with this property as text
    enforceWhitelist: true,
    mode : "select",
    skipInvalid: false, // do not remporarily add invalid tags
    dropdown: {
        closeOnSelect: true,
        enabled: 0,
        classname: 'customers-list',
        searchKeys: ['name', 'email']  // very important to set by which keys to search for suggesttions when typing
    },
    templates: {
        tag: billTagTemplate,
        dropdownItem: billSuggestionItemTemplate
    },
    whitelist: [],
    // whitelist: [
    //     {
    //         "value": 1,
    //         "name": "Justinian Hattersley",
    //         "avatar": "https://i.pravatar.cc/80?img=1",
    //         "email": "jhattersley0@ucsd.edu"
    //     },
    //     {
    //         "value": 2,
    //         "name": "Antons Esson",
    //         "avatar": "https://i.pravatar.cc/80?img=2",
    //         "email": "aesson1@ning.com"
    //     },
    // ]
})

billpayment_select_bill_tagify.on('dropdown:show dropdown:updated', onDropdownShow)
billpayment_select_bill_tagify.on('dropdown:select', onBPBillSelectSuggestion)
billpayment_select_bill_tagify.on('input', onBPBillInput)
billpayment_select_bill_tagify.on('remove', onBPBillSelectSuggestion)

var addAllSuggestionsElm;

function onDropdownShow(e){
    // var dropdownContentElm = e.detail.billpayment_select_vendor_tagify.DOM.dropdown.content;
}

function onBillPaymentVendorSelectSuggestion(e){
    // checks for data of selected vendor
    console.log(e.detail.data);

    $("#b_vendor_id").val(e.detail.data.value)
    $("#b_tin_number").html(e.detail.data.tin_number)
    $("#b_contact_person").html(e.detail.data.contact_person)
    $("#b_mobile_number").html(e.detail.data.mobile_number)

    // Get data from server.
    var request = $.ajax({
        url: "/ajax/vendor/bills/topay/" + e.detail.data.value,
        method: "GET",
    });

    request.done(function(res, status, jqXHR ) {
        console.log("Get bills to pay.");
        console.log(res);

        billpayment_select_bill_tagify.whitelist = res;
    });

    request.fail(function(jqXHR, status, error) {
        console.log("Request failed.");
    });
}

function onBillPaymentVendorRemove(e){
    $("#b_vendor_id").val("")
    $("#b_tin_number").html("")
    $("#b_contact_person").html("")
    $("#b_mobile_number").html("")

    billpayment_select_bill_tagify.whitelist = [];

    $("#b-r-remove").click();

    // Reset <tr>
    // $("#b_bills_to_pay").html("");
    // $("#b_total_amount_received").val("");
}

function onBillPaymentVendorInput(e) {
    var value = e.detail.value
    billpayment_select_vendor_tagify.whitelist = null // reset the whitelist

    // https://developer.mozilla.org/en-US/docs/Web/API/AbortController/abort
    controller && controller.abort()
    controller = new AbortController()

    // show loading animation and hide the suggestions dropdown
    billpayment_select_vendor_tagify.loading(true).dropdown.hide()

    fetch('/select/search/vendor/' + value, {signal:controller.signal})
        .then(RES => RES.json())
        .then(function(newWhitelist){
            billpayment_select_vendor_tagify.whitelist = newWhitelist // update whitelist Array in-place
            billpayment_select_vendor_tagify.loading(false).dropdown.show(value) // render the suggestions dropdown
        })
}

//

function onBPBillSelectSuggestion(e){
    // checks for data of selected vendor
    console.log(e.detail.data);

    $("#b_bill_due_date").html(e.detail.data.due_date)
    $("#b_bill_to_pay").html(e.detail.data.balance)
}

function onBPBillRemove(e){
    $("#b_bill_due_date").html("")
    $("#b_bill_to_pay").html("")

    // Reset <tr>
    $("#b_bills_to_pay").html("");
    $("#b_total_amount_received").val("");
}

function onBPBillInput(e) {

}
