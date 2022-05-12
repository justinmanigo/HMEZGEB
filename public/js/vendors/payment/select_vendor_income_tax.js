var income_tax_select_vendor_elm = document.querySelector('#it_vendor');

// initialize Tagify on the above input node reference
var income_tax_select_vendor_tagify = new Tagify(income_tax_select_vendor_elm, {
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

income_tax_select_vendor_tagify.on('dropdown:show dropdown:updated', onDropdownShow)
income_tax_select_vendor_tagify.on('dropdown:select', onIncomeTaxVendorSelectSuggestion)
income_tax_select_vendor_tagify.on('input', onIncomeTaxVendorInput)
income_tax_select_vendor_tagify.on('remove', onIncomeTaxVendorRemove)

var addAllSuggestionsElm;

function onDropdownShow(e){
    var dropdownContentElm = e.detail.income_tax_select_vendor_tagify.DOM.dropdown.content;
}

function onIncomeTaxVendorSelectSuggestion(e){
    // checks for data of selected vendor
    console.log(e.detail.data);

    $("#it_vendor_id").val(e.detail.data.value)
    $("#it_address").val(e.detail.data.address)
    $("#it_contact_person").val(e.detail.data.contact_person)
    $("#it_telephone_number").val(e.detail.data.telephone_one)
}

function onIncomeTaxVendorRemove(e){
    $("#it_vendor_id").val("")
    $("#it_address").val("")
    $("#it_contact_person").val("")
    $("#it_telephone_number").val("")
}

function onIncomeTaxVendorInput(e) {
    var value = e.detail.value
    income_tax_select_vendor_tagify.whitelist = null // reset the whitelist

    // https://developer.mozilla.org/en-US/docs/Web/API/AbortController/abort
    controller && controller.abort()
    controller = new AbortController()

    // show loading animation and hide the suggestions dropdown
    income_tax_select_vendor_tagify.loading(true).dropdown.hide()

    fetch('/select/search/vendor/' + value, {signal:controller.signal})
        .then(RES => RES.json())
        .then(function(newWhitelist){
            income_tax_select_vendor_tagify.whitelist = newWhitelist // update whitelist Array in-place
            income_tax_select_vendor_tagify.loading(false).dropdown.show(value) // render the suggestions dropdown
        })
}