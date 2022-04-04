var controller;
var coa_select_category_elm = document.querySelector("#coa_category");
var coa_select_category_default_items = [
    {
        'value': 1,
        'category': 'Cash on Hand',
        'type': 'Asset',
        'normal_balance': 'Debit',
    },
    {
        'value': 2,
        'category': 'Cash on Bank',
        'type': 'Asset',
        'normal_balance': 'Debit',
    },
    {
        'value': 3,
        'category': 'Account Receivable',
        'type': 'Asset',
        'normal_balance': 'Debit',
    },
    {
        'value': 4,
        'category': 'Sales',
        'type': 'Revenue',
        'normal_balance': 'Credit',
    },
    {
        'value': 5,
        'category': 'Other Current Liability',
        'type': 'Liability',
        'normal_balance': 'Credit',
    },
]

// initialize tagify
var coa_select_category_tagify = new Tagify(coa_select_category_elm, {
    tagTextProp: 'category', // very important since a custom template is used with this property as text
    enforceWhitelist: true,
    mode : "select",
    skipInvalid: false, // do not remporarily add invalid tags
    dropdown: {
        closeOnSelect: true,
        enabled: 0,
        classname: 'coa-list',
        searchKeys: ['category', 'type', 'normal_balance']  // very important to set by which keys to search for suggesttions when typing
    },
    templates: {
        tag: coaCategoryTagTemplate,
        dropdownItem: coaCategorySuggestionItemTemplate
    },
    // the entries below are intended to show up when there's no AJAX input.
    whitelist: coa_select_category_default_items,
});

coa_select_category_tagify.on('dropdown:show dropdown:updated', onCOASelectCategoryDropdownShow)
coa_select_category_tagify.on('dropdown:select', onCOASelectCategorySelectSuggestion)
coa_select_category_tagify.on('input', onCOASelectCategoryInput)
coa_select_category_tagify.on('remove', onCOASelectCategoryRemove)

function onCOASelectCategoryDropdownShow(e){
    // var dropdownContentElm = e.detail.coa_select_category_tagify.DOM.dropdown.content;
}

function onCOASelectCategorySelectSuggestion(e){
    // checks for data of selected customer
    coa_select_category_tagify.whitelist = coa_select_category_default_items;
    console.log(e.detail.data);
}

function onCOASelectCategoryRemove(e){
    coa_select_category_tagify.whitelist = coa_select_category_default_items;
}

function onCOASelectCategoryInput(e) {
    var value = e.detail.value
    console.log(value);
    coa_select_category_tagify.whitelist = null // reset the whitelist

    // https://developer.mozilla.org/en-US/docs/Web/API/AbortController/abort
    controller && controller.abort()
    controller = new AbortController()
    
    if(value != '')
    {
        // show loading animation and hide the suggestions dropdown
        coa_select_category_tagify.loading(true).dropdown.hide()
    
        fetch('/select/search/coa_categories/' + value, {signal:controller.signal})
            .then(RES => RES.json())
            .then(function(newWhitelist){
                coa_select_category_tagify.whitelist = newWhitelist // update whitelist Array in-place
                coa_select_category_tagify.loading(false).dropdown.show(value) // render the suggestions dropdown
            })
    }
    else {
        coa_select_category_tagify.whitelist = coa_select_category_default_items;
    }

}