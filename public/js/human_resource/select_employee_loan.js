var loan_select_employee_elm = document.querySelector('#l_employee');

// initialize Tagify on the above input node reference
var loan_select_employee_tagify = new Tagify(loan_select_employee_elm, {
    tagTextProp: 'first_name', // very important since a custom template is used with this property as text
    enforceWhitelist: true,
    mode : "select",
    skipInvalid: false, // do not remporarily add invalid tags
    dropdown: {
        closeOnSelect: true,
        enabled: 0,
        classname: 'employees-list',
        searchKeys: ['first_name']  // very important to set by which keys to search for suggesttions when typing
    },
    templates: {
        tag: employeeTagTemplate,
        dropdownItem: employeeSuggestionItemTemplate
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

loan_select_employee_tagify.on('dropdown:show dropdown:updated', onDropdownShow)
loan_select_employee_tagify.on('dropdown:select', onLoanEmployeeSelectSuggestion)
loan_select_employee_tagify.on('input', onLoanEmployeeInput)
loan_select_employee_tagify.on('remove', onLoanEmployeeRemove)

var addAllSuggestionsElm;

function onDropdownShow(e){
    var dropdownContentElm = e.detail.loan_select_employee_tagify.DOM.dropdown.content;
}

function onLoanEmployeeSelectSuggestion(e){
    // checks for data of selected employee
    console.log(e.detail.data);

    $("#l_employee_id").val(e.detail.data.value)

}

function onLoanEmployeeRemove(e){
    $("#l_employee_id").val("")

}

function onLoanEmployeeInput(e) {
    var value = e.detail.value
    loan_select_employee_tagify.whitelist = null // reset the whitelist

    // https://developer.mozilla.org/en-US/docs/Web/API/AbortController/abort
    controller && controller.abort()
    controller = new AbortController()

    // show loading animation and hide the suggestions dropdown
    loan_select_employee_tagify.loading(true).dropdown.hide()

    fetch('/select/search/employee/' + value, {signal:controller.signal})
        .then(RES => RES.json())
        .then(function(newWhitelist){
            loan_select_employee_tagify.whitelist = newWhitelist // update whitelist Array in-place
            loan_select_employee_tagify.loading(false).dropdown.show(value) // render the suggestions dropdown
        })
}