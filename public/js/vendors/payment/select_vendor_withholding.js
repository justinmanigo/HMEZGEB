var withholding_select_vendor_elm = document.querySelector('#w_vendor');

// initialize Tagify on the above input node reference
var withholding_select_vendor_tagify = new Tagify(withholding_select_vendor_elm, {
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

withholding_select_vendor_tagify.on('dropdown:show dropdown:updated', onDropdownShow)
withholding_select_vendor_tagify.on('dropdown:select', onWithholdingVendorSelectSuggestion)
withholding_select_vendor_tagify.on('input', onWithholdingVendorInput)
withholding_select_vendor_tagify.on('remove', onWithholdingVendorRemove)

var addAllSuggestionsElm;

function onDropdownShow(e){
    var dropdownContentElm = e.detail.withholding_select_vendor_tagify.DOM.dropdown.content;
}

function onWithholdingVendorSelectSuggestion(e){
    // checks for data of selected vendor
    console.log(e.detail.data);

    $("#w_vendor_id").val(e.detail.data.value)
    $("#w_address").val(e.detail.data.address)
    $("#w_contact_person").val(e.detail.data.contact_person)
    $("#w_telephone_number").val(e.detail.data.telephone_one)
}

function onWithholdingVendorRemove(e){
    $("#w_vendor_id").val("")
    $("#w_address").val("")
    $("#w_contact_person").val("")
    $("#w_telephone_number").val("")
}

function onWithholdingVendorInput(e) {
    var value = e.detail.value
    withholding_select_vendor_tagify.whitelist = null // reset the whitelist

    // https://developer.mozilla.org/en-US/docs/Web/API/AbortController/abort
    controller && controller.abort()
    controller = new AbortController()

    // show loading animation and hide the suggestions dropdown
    withholding_select_vendor_tagify.loading(true).dropdown.hide()

    fetch('/select/search/vendor/' + value, {signal:controller.signal})
        .then(RES => RES.json())
        .then(function(newWhitelist){
            withholding_select_vendor_tagify.whitelist = newWhitelist // update whitelist Array in-place
            withholding_select_vendor_tagify.loading(false).dropdown.show(value) // render the suggestions dropdown
        })
}