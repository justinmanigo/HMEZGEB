var bank_select_from = document.querySelector('#gs_bank_account');

//BANK FROM
var bank_select_bank_tagify_from = new Tagify(bank_select_from, {
    tagTextProp: 'account_name', // very important since a custom template is used with this property as text
    enforceWhitelist: true,
    mode : "select",
    skipInvalid: false, // do not remporarily add invalid tags
    dropdown: {
        closeOnSelect: true,
        enabled: 0,
        classname: 'customers-list',
        searchKeys: ['account_name', 'chart_of_account_no', 'bank_branch', 'bank_account_number']  // very important to set by which keys to search for suggestions when typing
    },
    templates: {
        tag: bankTagTemplate,
        dropdownItem: bankSuggestionItemTemplate
    },
    whitelist: [],
})

bank_select_bank_tagify_from.on('dropdown:show dropdown:updated', onDropdownShowFrom)
bank_select_bank_tagify_from.on('dropdown:select', onBankSelectSuggestionFrom)
bank_select_bank_tagify_from.on('input', onBankInputFrom)
bank_select_bank_tagify_from.on('remove', onBankRemoveFrom)

var addAllSuggestionsElm;

function onDropdownShowFrom(e){
    var dropdownContentElm = e.detail.bank_select_bank_tagify_from.DOM.dropdown.content;
}

function onBankSelectSuggestionFrom(e){
    // checks for data of selected bank
    console.log(e.detail.data);
    bank_bank_id = e.detail.data.value;

    // $("#t_bank_id_from").val(e.detail.data.value)
}

function onBankRemoveFrom(e){
    // $("#t_bank_id_from").val("")
}

function onBankInputFrom(e) {
    var value = e.detail.value
    bank_select_bank_tagify_from.whitelist = null // reset the whitelist

    // https://developer.mozilla.org/en-US/docs/Web/API/AbortController/abort
    controller && controller.abort()
    controller = new AbortController()

    // show loading animation and hide the suggestions dropdown
    bank_select_bank_tagify_from.loading(true).dropdown.hide()

    fetch('/ajax/search/bank/' + value, {signal:controller.signal})
        .then(RES => RES.json())
        .then(function(newWhitelist){
            bank_select_bank_tagify_from.whitelist = newWhitelist // update whitelist Array in-place
            bank_select_bank_tagify_from.loading(false).dropdown.show(value) // render the suggestions dropdown
        })
}