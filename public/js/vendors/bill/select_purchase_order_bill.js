var bill_select_po_elm = document.querySelector('#b_purchase_order');

// initialize Tagify on the above input node reference
var bill_select_po = new Tagify(bill_select_po_elm, {
    tagTextProp: 'value', // very important since a custom template is used with this property as text
    enforceWhitelist: true,
    mode : "select",
    skipInvalid: false, // do not remporarily add invalid tags
    dropdown: {
        closeOnSelect: true,
        enabled: 0,
        classname: 'customer-list',
        searchKeys: ['value', 'due_date']  // very important to set by which keys to search for suggesttions when typing
    },
    templates: {
        tag: purchaseOrderTagTemplate,
        dropdownItem: purchaseOrderSuggestionItemTemplate
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

// bill_select_po.on('dropdown:show dropdown:updated', onDropdownShow)
bill_select_po.on('dropdown:select', onBillPurchaseOrderSelectSuggestion)
bill_select_po.on('input', onBillPurchaseOrderInput)
bill_select_po.on('remove', onBillPurchaseOrderRemove)

var addAllSuggestionsElm;

// function onDropdownShow(e){
//     var dropdownContentElm = e.detail.bill_select_po.DOM.dropdown.content;
// }

function onBillPurchaseOrderSelectSuggestion(e){
    // checks for data of selected customer
    console.log(e.detail.data);
    let po_id = e.detail.data.value;

    request = $.get(`/ajax/vendor/bill/purchase-order/get/${po_id}`);
    
    request.done(function(response, textStatus, jqXHR){
        console.log(response);
        // Clear item list
        $("#b_items").html("");

        // Create receipt item entries bearing values from proforma.
        response.bill_items.forEach(function(item){
            // console.log(item);

            createBillItemEntry(item);
        });

        // Compute subtotal & grandtotal
        calculateBillSubTotal();
        calculateBillGrandTotal();
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

function onBillPurchaseOrderRemove(e){
    // $("#r_customer_id").html("")
    // $("#r_tin_number").html("")
    // $("#r_contact_person").html("")
    // $("#r_mobile_number").html("")
}

function onBillPurchaseOrderInput(e) {
    tagify = e.detail.tagify;
    var value = e.detail.value
    tagify.whitelist = null // reset the whitelist

    // https://developer.mozilla.org/en-US/docs/Web/API/AbortController/abort
    controller && controller.abort()
    controller = new AbortController()

    if(bill_vendor_id != undefined)
    {
        // show loading animation and hide the suggestions dropdown
        tagify.loading(true).dropdown.hide()
    
        fetch(`/ajax/vendor/bill/purchase-order/search/${bill_vendor_id}/${value}`, {signal:controller.signal})
            .then(RES => RES.json())
            .then(function(newWhitelist){
                tagify.whitelist = newWhitelist // update whitelist Array in-place
                tagify.loading(false).dropdown.show(value) // render the suggestions dropdown
            })
    }

}