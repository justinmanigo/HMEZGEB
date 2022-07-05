var bill_select_vendor_elm = document.querySelector('#b_vendor');
var bill_vendor_id = undefined; // used to enable proforma field

// initialize Tagify on the above input node reference
var bill_select_vendor_tagify = new Tagify(bill_select_vendor_elm, {
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

bill_select_vendor_tagify.on('dropdown:show dropdown:updated', onDropdownShow)
bill_select_vendor_tagify.on('dropdown:select', onBillVendorSelectSuggestion)
bill_select_vendor_tagify.on('input', onBillVendorInput)
bill_select_vendor_tagify.on('remove', onBillVendorRemove)

var addAllSuggestionsElm;

function onDropdownShow(e){
    var dropdownContentElm = e.detail.bill_select_vendor_tagify.DOM.dropdown.content;
}

function onBillVendorSelectSuggestion(e){
    // checks for data of selected vendor
    console.log(e.detail.data);

    bill_vendor_id = e.detail.data.value;

    $("#b_vendor_id").val(e.detail.data.value)
    $("#b_address").val(e.detail.data.address)
    $("#b_contact_person").val(e.detail.data.contact_person)
    $("#b_telephone_number").val(e.detail.data.telephone_one)
}

function onBillVendorRemove(e){
    $("#b_vendor_id").val("")
    $("#b_address").val("")
    $("#b_contact_person").val("")
    $("#b_telephone_number").val("")
}

function onBillVendorInput(e) {
    var value = e.detail.value
    bill_select_vendor_tagify.whitelist = null // reset the whitelist

    // https://developer.mozilla.org/en-US/docs/Web/API/AbortController/abort
    controller && controller.abort()
    controller = new AbortController()

    // show loading animation and hide the suggestions dropdown
    bill_select_vendor_tagify.loading(true).dropdown.hide()

    fetch('/select/search/vendor/' + value, {signal:controller.signal})
        .then(RES => RES.json())
        .then(function(newWhitelist){
            bill_select_vendor_tagify.whitelist = newWhitelist // update whitelist Array in-place
            bill_select_vendor_tagify.loading(false).dropdown.show(value) // render the suggestions dropdown
        })
}