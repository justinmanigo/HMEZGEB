var elm_d_bank_account = document.querySelector('#d_bank_account');

// initialize Tagify on the above input node reference
var tagify_d_bank_account = new Tagify(elm_d_bank_account, {
    tagTextProp: 'account_name', // very important since a custom template is used with this property as text
    enforceWhitelist: true,
    mode : "select",
    skipInvalid: false, // do not remporarily add invalid tags
    dropdown: {
        closeOnSelect: true,
        enabled: 0,
        classname: 'bank-list',
        searchKeys: ['account_name', 'bank_account_number', 'bank_branch', 'chart_of_account_no']  // very important to set by which keys to search for suggesttions when typing
    },
    templates: {
        tag: bankTagTemplate,
        dropdownItem: bankSuggestionItemTemplate
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

tagify_d_bank_account.on('dropdown:show dropdown:updated', onDropdownShow)
// tagify_d_bank_account.on('dropdown:select', onReceiptCustomerSelectSuggestion)
tagify_d_bank_account.on('input', onReceiptCustomerInput)
// tagify_d_bank_account.on('remove', onReceiptCustomerRemove)

var addAllSuggestionsElm;

function onDropdownShow(e){
    // var dropdownContentElm = e.detail.tagify_d_bank_account.DOM.dropdown.content;
}

function onReceiptCustomerSelectSuggestion(e){
    // checks for data of selected customer
    // console.log(e.detail.data);

    // $("#r_customer_id").val(e.detail.data.value)
    // $("#r_tin_number").val(e.detail.data.tin_number)
    // $("#r_contact_person").val(e.detail.data.contact_person)
    // $("#r_mobile_number").val(e.detail.data.mobile_number)
}

function onReceiptCustomerRemove(e){
    // $("#r_customer_id").val("")
    // $("#r_tin_number").val("")
    // $("#r_contact_person").val("")
    // $("#r_mobile_number").val("")
}

function onReceiptCustomerInput(e) {
    var value = e.detail.value
    tagify_d_bank_account.whitelist = null // reset the whitelist

    // https://developer.mozilla.org/en-US/docs/Web/API/AbortController/abort
    controller && controller.abort()
    controller = new AbortController()

    // show loading animation and hide the suggestions dropdown
    tagify_d_bank_account.loading(true).dropdown.hide()

    fetch('/ajax/customer/deposit/bank/search/' + value, {signal:controller.signal})
        .then(RES => RES.json())
        .then(function(newWhitelist){
            tagify_d_bank_account.whitelist = newWhitelist // update whitelist Array in-place
            tagify_d_bank_account.loading(false).dropdown.show(value) // render the suggestions dropdown
        })
}