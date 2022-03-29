var proforma_select_customer_elm = document.querySelector('#p_customer');

// initialize Tagify on the above input node reference
var proforma_select_customer_tagify = new Tagify(proforma_select_customer_elm, {
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

proforma_select_customer_tagify.on('dropdown:show dropdown:updated', onDropdownShow)
proforma_select_customer_tagify.on('dropdown:select', onProformaCustomerSelectSuggestion)
proforma_select_customer_tagify.on('input', onProformaCustomerInput)
proforma_select_customer_tagify.on('remove', onProformaCustomerRemove)

var addAllSuggestionsElm;

function onDropdownShow(e){
    var dropdownContentElm = e.detail.proforma_select_customer_tagify.DOM.dropdown.content;
}

function onProformaCustomerSelectSuggestion(e){
    // checks for data of selected customer
    console.log(e.detail.data);

    $("#p_customer_id").val(e.detail.data.value)
    $("#p_tin_number").val(e.detail.data.tin_number)
    $("#p_contact_person").val(e.detail.data.contact_person)

    // contact number seems to be missing in migration, so i'm skipping this
    // $("#p_contact_number").val(e.detail.data.contact_number)
}

function onProformaCustomerRemove(e){
    $("#p_customer_id").val("")
    $("#p_tin_number").val("")
    $("#p_contact_person").val("")
    $("#p_contact_number").val("")
}

function onProformaCustomerInput(e) {
    var value = e.detail.value
    proforma_select_customer_tagify.whitelist = null // reset the whitelist

    // https://developer.mozilla.org/en-US/docs/Web/API/AbortController/abort
    controller && controller.abort()
    controller = new AbortController()

    // show loading animation and hide the suggestions dropdown
    proforma_select_customer_tagify.loading(true).dropdown.hide()

    fetch('/select/search/customer/' + value, {signal:controller.signal})
        .then(RES => RES.json())
        .then(function(newWhitelist){
            proforma_select_customer_tagify.whitelist = newWhitelist // update whitelist Array in-place
            proforma_select_customer_tagify.loading(false).dropdown.show(value) // render the suggestions dropdown
        })
}