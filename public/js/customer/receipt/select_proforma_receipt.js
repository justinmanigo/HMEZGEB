var receipt_select_proforma_elm = document.querySelector('#r_proforma');

// initialize Tagify on the above input node reference
var receipt_select_proforma_tagify = new Tagify(receipt_select_proforma_elm, {
    tagTextProp: 'value', // very important since a custom template is used with this property as text
    enforceWhitelist: true,
    mode : "select",
    skipInvalid: false, // do not remporarily add invalid tags
    dropdown: {
        closeOnSelect: true,
        enabled: 0,
        classname: 'receipts-proforma-list',
        searchKeys: ['value', 'due_date']  // very important to set by which keys to search for suggesttions when typing
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

// receipt_select_proforma_tagify.on('dropdown:show dropdown:updated', onDropdownShow)
receipt_select_proforma_tagify.on('dropdown:select', onReceiptProformaSelectSuggestion)
receipt_select_proforma_tagify.on('input', onReceiptProformaInput)
receipt_select_proforma_tagify.on('remove', onReceiptProformaRemove)

var addAllSuggestionsElm;

function onDropdownShow(e){
    var dropdownContentElm = e.detail.receipt_select_proforma_tagify.DOM.dropdown.content;
}

function onReceiptProformaSelectSuggestion(e){
    // checks for data of selected customer
    console.log(e.detail.data);
    let proforma_id = e.detail.data.value;

    request = $.get(`/ajax/customer/receipt/proforma/get/${proforma_id}`);
    
    request.done(function(response, textStatus, jqXHR){
        console.log(response);
        // Clear item list
        $("#r_items").html("");

        // Create receipt item entries bearing values from proforma.
        response.receipt_items.forEach(function(item){
            // console.log(item);

            createReceiptItemEntry(item);
        });

        // Compute subtotal & grandtotal
        calculateReceiptSubTotal();
        calculateReceiptGrandTotal();
    });
    
    request.fail(function(jqXHR, textStatus, errorThrown){
        console.log(jqXHR);
        console.log(errorThrown);
    });

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
    tagify = e.detail.tagify;
    var value = e.detail.value
    tagify.whitelist = null // reset the whitelist

    // https://developer.mozilla.org/en-US/docs/Web/API/AbortController/abort
    controller && controller.abort()
    controller = new AbortController()

    if(receipt_customer_id != undefined)
    {
        // show loading animation and hide the suggestions dropdown
        tagify.loading(true).dropdown.hide()
    
        fetch(`/ajax/customer/receipt/proforma/search/${receipt_customer_id}/${value}`, {signal:controller.signal})
            .then(RES => RES.json())
            .then(function(newWhitelist){
                tagify.whitelist = newWhitelist // update whitelist Array in-place
                tagify.loading(false).dropdown.show(value) // render the suggestions dropdown
            })
    }

}