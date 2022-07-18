var controller;
var coa_select_category_elm = document.querySelector("#coa_category");
var coa_select_category_default_items = [];
var coa_select_category_tagify;

var request = $.ajax({
    url: `/ajax/settings/coa_categories/search/`,
    method: "GET",
});

request.done(function(response, textStatus, jqXHR){
    console.log("Initial load of categories.")
    
    coa_select_category_default_items = response;

    console.log(coa_select_category_default_items);

    // initialize tagify
    coa_select_category_tagify = new Tagify(coa_select_category_elm, {
        tagTextProp: 'value', // very important since a custom template is used with this property as text
        enforceWhitelist: true,
        mode : "select",
        skipInvalid: true, // do not remporarily add invalid tags
        dropdown: {
            closeOnSelect: true,
            enabled: 0,
            classname: 'customer-list',
            searchKeys: ['value']  // very important to set by which keys to search for suggesttions when typing
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
});


function onCOASelectCategoryDropdownShow(e){
    coa_select_category_tagify.whitelist = coa_select_category_default_items;
    // var dropdownContentElm = e.detail.coa_select_category_tagify.DOM.dropdown.content;
}

function onCOASelectCategorySelectSuggestion(e){
    // checks for data of selected customer
    coa_select_category_tagify.whitelist = coa_select_category_default_items;
    console.log(e.detail.data);

    // If Cash, enable checkbox "Is this a Bank Account?"
    if(e.detail.data.value == 'Cash') 
        $("#coa_is_bank").removeAttr("disabled");
    else {
        if($('#coa_is_bank').is(":checked"))
            $("#coa_is_bank").click();
        $("#coa_is_bank").attr("disabled", true);
    }
}

function onCOASelectCategoryRemove(e){
    coa_select_category_tagify.whitelist = coa_select_category_default_items;
    
    if($('#coa_is_bank').is(":checked"))
        $("#coa_is_bank").click();
    $("#coa_is_bank").attr("disabled", true);
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
    
        fetch(`/ajax/settings/coa_categories/search/${value}`, {signal:controller.signal})
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

$("#coa_is_bank").change(function() {
    if(this.checked) {
        $(".coa_bank").show();
        $("#coa_bank_account_number").attr("disabled", false);
        $("#coa_bank_branch").attr("disabled", false);
        $("#coa_bank_account_type").attr("disabled", false);
    }
    else {
        $(".coa_bank").hide();
        $("#coa_bank_account_number").attr("disabled", true);
        $("#coa_bank_branch").attr("disabled", true);
        $("#coa_bank_account_type").attr("disabled", true);
    }
});