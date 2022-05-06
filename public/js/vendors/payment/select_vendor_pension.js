var pension_select_vendor_elm = document.querySelector('#p_vendor');

// initialize Tagify on the above input node reference
var pension_select_vendor_tagify = new Tagify(pension_select_vendor_elm, {
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

pension_select_vendor_tagify.on('dropdown:show dropdown:updated', onDropdownShow)
pension_select_vendor_tagify.on('dropdown:select', onPensionVendorSelectSuggestion)
pension_select_vendor_tagify.on('input', onPensionVendorInput)
pension_select_vendor__vendortagify.on('remove', onPensionVendorRemove)

var addAllSuggestionsElm;

function onDropdownShow(e){
    var dropdownContentElm = e.detail.pension_select_vendor_tagify.DOM.dropdown.content;
}

function onPensionVendorSelectSuggestion(e){
    // checks for data of selected vendor
    console.log(e.detail.data);

    $("#p_vendor_id").val(e.detail.data.value)
    $("#p_address").val(e.detail.data.address)
    $("#p_contact_person").val(e.detail.data.contact_person)
    $("#p_telephone_number").val(e.detail.data.telephone_one)
}

function onPensionVendorRemove(e){
    $("#p_vendor_id").val("")
    $("#p_address").val("")
    $("#p_contact_person").val("")
    $("#p_telephone_number").val("")
}

function onPensionVendorInput(e) {
    var value = e.detail.value
    pension_select_vendor_tagify.whitelist = null // reset the whitelist

    // https://developer.mozilla.org/en-US/docs/Web/API/AbortController/abort
    controller && controller.abort()
    controller = new AbortController()

    // show loading animation and hide the suggestions dropdown
    pension_select_vendor_tagify.loading(true).dropdown.hide()

    fetch('/select/search/vendor/' + value, {signal:controller.signal})
        .then(RES => RES.json())
        .then(function(newWhitelist){
            pension_select_vendor_tagify.whitelist = newWhitelist // update whitelist Array in-place
            pension_select_vendor_tagify.loading(false).dropdown.show(value) // render the suggestions dropdown
        })
}