var proforma_select_customer_elm = document.querySelector('#r_proforma');

// initialize Tagify on the above input node reference
var proforma_select_customer_tagify = new Tagify(proforma_select_customer_elm, {
    tagTextProp: 'reference_number', // very important since a custom template is used with this property as text
    enforceWhitelist: true,
    mode : "select",
    skipInvalid: false, // do not remporarily add invalid tags
    dropdown: {
        closeOnSelect: true,
        enabled: 0,
        classname: 'receipts-proforma-list',
        searchKeys: ['value', ]  // very important to set by which keys to search for suggesttions when typing
    },
    templates: {
        tag: proformaTagTemplate,
        dropdownItem: proformaSuggestionItemTemplate
    },
    whitelist: [],
    // whitelist: [
    //     {
    //         "value": 1,
    //         "name": "Justinian Hattersley",
    //         "avatar": "https://i.pravatar.cc/80?img=1",
    //         "email": "jhattersley0@ucsd.edu"
    //     },
    // ]
})

// proforma_select_customer_tagify.on('dropdown:show dropdown:updated', onDropdownShow)
proforma_select_customer_tagify.on('dropdown:select', onReceiptProformaSelectSuggestion)
proforma_select_customer_tagify.on('input', onReceiptProformaInput)
proforma_select_customer_tagify.on('remove', onReceiptProformaRemove)

var addAllSuggestionsElm;

function onDropdownShow(e){
    var dropdownContentElm = e.detail.proforma_select_customer_tagify.DOM.dropdown.content;
}

function onReceiptProformaSelectSuggestion(e){
    // checks for data of selected customer
    console.log(e.detail.data);

    // $("#r_customer_id").html(e.detail.data.value)
    // $("#r_tin_number").html(e.detail.data.tin_number)
    // $("#r_contact_person").html(e.detail.data.contact_person)
    // $("#r_mobile_number").html(e.detail.data.mobile_number)
}

function onReceiptProformaRemove(e){
    // $("#r_customer_id").html("")
    // $("#r_tin_number").html("")
    // $("#r_contact_person").html("")
    // $("#r_mobile_number").html("")
}

function onReceiptProformaInput(e) {
    var value = e.detail.value
    proforma_select_customer_tagify.whitelist = null // reset the whitelist

    // https://developer.mozilla.org/en-US/docs/Web/API/AbortController/abort
    controller && controller.abort()
    controller = new AbortController()

    if(receipt_customer_id != undefined)
    {
        // show loading animation and hide the suggestions dropdown
        proforma_select_customer_tagify.loading(true).dropdown.hide()
    
        fetch(`/ajax/customer/receipt/proforma/search/${receipt_customer_id}/${value}`, {signal:controller.signal})
            .then(RES => RES.json())
            .then(function(newWhitelist){
                proforma_select_customer_tagify.whitelist = newWhitelist // update whitelist Array in-place
                proforma_select_customer_tagify.loading(false).dropdown.show(value) // render the suggestions dropdown
            })
    }

}