var purchaseorder_select_vendor_elm = document.querySelector('#po_vendor');

// initialize Tagify on the above input node reference
var purchaseorder_select_vendor_tagify = new Tagify(purchaseorder_select_vendor_elm, {
    tagTextProp: 'name', // very important since a custom template is used with this property as text
    enforceWhitelist: true,
    mode : "select",
    skipInvalid: false, // do not remporarily add invalid tags
    dropdown: {
        closeOnSelect: true,
        enabled: 0,
        classname: 'vendors-list',
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

purchaseorder_select_vendor_tagify.on('dropdown:show dropdown:updated', onDropdownShow)
purchaseorder_select_vendor_tagify.on('dropdown:select', onPurchaseOrderVendorSelectSuggestion)
purchaseorder_select_vendor_tagify.on('input', onPurchaseOrderVendorInput)
purchaseorder_select_vendor_tagify.on('remove', onPurchaseOrderVendorRemove)

var addAllSuggestionsElm;

function onDropdownShow(e){
    var dropdownContentElm = e.detail.purchaseorder_select_vendor_tagify.DOM.dropdown.content;
}

function onPurchaseOrderVendorSelectSuggestion(e){
    // checks for data of selected vendor
    console.log(e.detail.data);

    $("#po_vendor_id").val(e.detail.data.value)
    $("#po_address").val(e.detail.data.address)
    $("#po_contact_person").val(e.detail.data.contact_person)
    $("#po_telephone_number").val(e.detail.data.telephone_one)
}

function onPurchaseOrderVendorRemove(e){
    $("#po_vendor_id").val("")
    $("#po_address").val("")
    $("#po_contact_person").val("")
    $("#po_telephone_number").val("")
}

function onPurchaseOrderVendorInput(e) {
    var value = e.detail.value
    purchaseorder_select_vendor_tagify.whitelist = null // reset the whitelist

    // https://developer.mozilla.org/en-US/docs/Web/API/AbortController/abort
    controller && controller.abort()
    controller = new AbortController()

    // show loading animation and hide the suggestions dropdown
    purchaseorder_select_vendor_tagify.loading(true).dropdown.hide()

    fetch('/select/search/vendor/' + value, {signal:controller.signal})
        .then(RES => RES.json())
        .then(function(newWhitelist){
            purchaseorder_select_vendor_tagify.whitelist = newWhitelist // update whitelist Array in-place
            purchaseorder_select_vendor_tagify.loading(false).dropdown.show(value) // render the suggestions dropdown
        })
}