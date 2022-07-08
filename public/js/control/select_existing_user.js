var user_select_elm = document.querySelector('#e_user');

// initialize Tagify on the above input node reference
var user_select_tagify = new Tagify(user_select_elm, {
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
        tag: userTagTemplate,
        dropdownItem: userSuggestionItemTemplate
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

user_select_tagify.on('dropdown:show dropdown:updated', onUserDropdownShow)
user_select_tagify.on('dropdown:select', onUserSelectSuggestion)
user_select_tagify.on('input', onUserInput)
user_select_tagify.on('remove', onUserCustomerRemove)

var addAllSuggestionsElm;

function onUserDropdownShow(e){
    // var dropdownContentElm = e.detail.user_select_tagify.DOM.dropdown.content;
}

function onUserSelectSuggestion(e){

}

function onUserCustomerRemove(e){

}

function onUserInput(e) {
    var value = e.detail.value
    user_select_tagify.whitelist = null // reset the whitelist

    // https://developer.mozilla.org/en-US/docs/Web/API/AbortController/abort
    controller && controller.abort()
    controller = new AbortController()

    // show loading animation and hide the suggestions dropdown
    user_select_tagify.loading(true).dropdown.hide()

    fetch('/ajax/control/user/search/' + value, {signal:controller.signal})
        .then(RES => RES.json())
        .then(function(newWhitelist){
            user_select_tagify.whitelist = newWhitelist // update whitelist Array in-place
            user_select_tagify.loading(false).dropdown.show(value) // render the suggestions dropdown
        })
}