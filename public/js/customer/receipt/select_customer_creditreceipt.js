var creditreceipt_select_customer_elm = document.querySelector('#cr_customer');

// initialize Tagify on the above input node reference
var creditreceipt_select_customer_tagify = new Tagify(creditreceipt_select_customer_elm, {
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
        tag: customerTagTemplate,
        dropdownItem: customerSuggestionItemTemplate
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

creditreceipt_select_customer_tagify.on('dropdown:show dropdown:updated', onDropdownShow)
creditreceipt_select_customer_tagify.on('dropdown:select', onCreditReceiptCustomerSelectSuggestion)
creditreceipt_select_customer_tagify.on('input', onCreditReceiptCustomerInput)
creditreceipt_select_customer_tagify.on('remove', onCreditReceiptCustomerRemove)

var addAllSuggestionsElm;

function onDropdownShow(e){
    var dropdownContentElm = e.detail.creditreceipt_select_customer_tagify.DOM.dropdown.content;
}

function onCreditReceiptCustomerSelectSuggestion(e){
    // checks for data of selected customer
    console.log(e.detail.data);

    $("#cr_customer_id").val(e.detail.data.value)
    $("#cr_tin_number").val(e.detail.data.tin_number)
    $("#cr_contact_person").val(e.detail.data.contact_person)
    $("#cr_mobile_number").val(e.detail.data.mobile_number)

    // Get data from server.
    var request = $.ajax({
        url: "/ajax/customer/receipts/topay/" + e.detail.data.value,
        method: "GET",
    });
        
    request.done(function(res, status, jqXHR ) {
        console.log(res);
        for(i = 0; i < res.length; i++)
        {
            createReceiptToPayEntry(res[i]);
        }
        // $("#form-tax").show();
        // $("#modal-tax-spinner").hide();
        // $("#t_submit_btn").removeAttr("disabled");
        // console.log("Request successful.");
        // console.log(res);
        // $("#t_name").val(res.name);
        // $("#t_percentage").val(res.percentage);
    });
    
    request.fail(function(jqXHR, status, error) {
        console.log("Request failed.");
    });
}

function onCreditReceiptCustomerRemove(e){
    $("#cr_customer_id").val("")
    $("#cr_tin_number").val("")
    $("#cr_contact_person").val("")
    $("#cr_mobile_number").val("")

    // Reset <tr>
    $("#cr_receipts_to_pay").html("");
    $("#cr_total_amount_received").val("");
}

function onCreditReceiptCustomerInput(e) {
    var value = e.detail.value
    creditreceipt_select_customer_tagify.whitelist = null // reset the whitelist

    // https://developer.mozilla.org/en-US/docs/Web/API/AbortController/abort
    controller && controller.abort()
    controller = new AbortController()

    // show loading animation and hide the suggestions dropdown
    creditreceipt_select_customer_tagify.loading(true).dropdown.hide()

    fetch('/select/search/customer/' + value, {signal:controller.signal})
        .then(RES => RES.json())
        .then(function(newWhitelist){
            creditreceipt_select_customer_tagify.whitelist = newWhitelist // update whitelist Array in-place
            creditreceipt_select_customer_tagify.loading(false).dropdown.show(value) // render the suggestions dropdown
        })
}