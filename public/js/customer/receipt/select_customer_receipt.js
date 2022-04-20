var receipt_select_customer_elm = document.querySelector('#r_customer');
var receipt_customer_id = undefined; // used to enable proforma field

// initialize Tagify on the above input node reference
var receipt_select_customer_tagify = new Tagify(receipt_select_customer_elm, {
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

receipt_select_customer_tagify.on('dropdown:show dropdown:updated', onDropdownShow)
receipt_select_customer_tagify.on('dropdown:select', onReceiptCustomerSelectSuggestion)
receipt_select_customer_tagify.on('input', onReceiptCustomerInput)
receipt_select_customer_tagify.on('remove', onReceiptCustomerRemove)

var addAllSuggestionsElm;

function onDropdownShow(e){
    var dropdownContentElm = e.detail.receipt_select_customer_tagify.DOM.dropdown.content;
}

function onReceiptCustomerSelectSuggestion(e){
    // checks for data of selected customer
    console.log(e.detail.data);
    receipt_customer_id = e.detail.data.value;

    $("#r_customer_id").val(e.detail.data.value)
    $("#r_tin_number").val(e.detail.data.tin_number)
    $("#r_contact_person").val(e.detail.data.contact_person)
    $("#r_mobile_number").val(e.detail.data.mobile_number)
}

function onReceiptCustomerRemove(e){
    $("#r_customer_id").val("")
    $("#r_tin_number").val("")
    $("#r_contact_person").val("")
    $("#r_mobile_number").val("")
    $("#r-proforma-remove").click();

    if(proforma_select_customer_tagify !== undefined)
    {
        proforma_select_customer_tagify.whitelist = null; // reset the whitelist
    }
}

function onReceiptCustomerInput(e) {
    var value = e.detail.value
    receipt_select_customer_tagify.whitelist = null // reset the whitelist

    // https://developer.mozilla.org/en-US/docs/Web/API/AbortController/abort
    controller && controller.abort()
    controller = new AbortController()

    // show loading animation and hide the suggestions dropdown
    receipt_select_customer_tagify.loading(true).dropdown.hide()

    fetch('/select/search/customer/' + value, {signal:controller.signal})
        .then(RES => RES.json())
        .then(function(newWhitelist){
            receipt_select_customer_tagify.whitelist = newWhitelist // update whitelist Array in-place
            receipt_select_customer_tagify.loading(false).dropdown.show(value) // render the suggestions dropdown
        })
}