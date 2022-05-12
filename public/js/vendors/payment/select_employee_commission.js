var commission_select_employee_elm = document.querySelector('#c_employee');

// initialize Tagify on the above input node reference

var commission_select_employee_tagify = new Tagify(commission_select_employee_elm, {
    tagTextProp: 'first_name', // very important since a custom template is used with this property as text
    enforceWhitelist: true,
    mode : "select",
    skipInvalid: false, // do not remporarily add invalid tags
    dropdown: {
        closeOnSelect: true,
        enabled: 0,
        classname: 'employees-list',
        searchKeys: ['first_name'] // very important to set by which keys to search for suggesttions when typing
    },
    templates: {
        tag: employeeTagTemplate,
        dropdownItem: employeeSuggestionItemTemplate
    },
    whitelist: [],
}
)


commission_select_employee_tagify.on('dropdown:show dropdown:updated', onDropdownShow)
commission_select_employee_tagify.on('dropdown:select', onWithholdingVendorSelectSuggestion)
commission_select_employee_tagify.on('input', onWithholdingVendorInput)
commission_select_employee_tagify.on('remove', onWithholdingVendorRemove)

var addAllSuggestionsElm;

function onDropdownShow(e){
    var dropdownContentElm = e.detail.commission_select_employee_tagify.DOM.dropdown.content;
}

function onWithholdingVendorSelectSuggestion(e){
    // checks for data of selected employee
    console.log(e.detail.data);

    $("#c_employee_id").val(e.detail.data.value)
    $("#c_employee").val(e.detail.data.name)
    $("#c_tin_number").val(e.detail.data.tin_number)


    // Get data from server.
    var request = $.ajax({
        url: "/ajax/employee/commission/topay/" + e.detail.data.value,
        method: "GET",
    });
        
    request.done(function(res, status, jqXHR ) {
        console.log(res);
        for(i = 0; i < res.length; i++)
        {   
            createWithholdingToPayEntry(res[i]);
        }
    });
    
    request.fail(function(jqXHR, status, error) {
        console.log(error);
    });
}

function onWithholdingVendorRemove(e){
    $("#c_employee_id").val("")
    $("#c_tin_number").val("")
}

function onWithholdingVendorInput(e) {
    var value = e.detail.value
    commission_select_employee_tagify.whitelist = null // reset the whitelist

    // https://developer.mozilla.org/en-US/docs/Web/API/AbortController/abort
    controller && controller.abort()
    controller = new AbortController()

    // show loading animation and hide the suggestions dropdown
    commission_select_employee_tagify.loading(true).dropdown.hide()

    fetch('/select/search/employee/' + value, {signal:controller.signal})
        .then(RES => RES.json())
        .then(function(newWhitelist){
            commission_select_employee_tagify.whitelist = newWhitelist // update whitelist Array in-place
            commission_select_employee_tagify.loading(false).dropdown.show(value) // render the suggestions dropdown
        })
}