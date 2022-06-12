var controller;

var tagify_defaults_elms = document.querySelectorAll('.tagify-defaults');
var tagify_defaults = [];

var coa_whitelist = [];
var request = $.ajax({
    url: '/ajax/settings/coa/search/',
    type: 'GET',
    dataType: 'json'
});

request.done(function(data) {
    console.log(data);
    coa_whitelist = data;
});

request.fail(function(jqXHR, textStatus) {
    console.log('Request failed: ' + textStatus);
});

request.always(function() {
    tagify_defaults_elms.forEach(function(elm){

        var tagify = new Tagify(elm, {
            tagTextProp: 'label', // very important since a custom template is used with this property as text
            enforceWhitelist: true,
            mode : "select",
            skipInvalid: false, // do not remporarily add invalid tags
            dropdown: {
                closeOnSelect: true,
                enabled: 0,
                classname: 'customers-list',
                searchKeys: ['label']  // very important to set by which keys to search for suggesttions when typing
            },
            templates: {
                tag: coaTagTemplate,
                dropdownItem: coaSuggestionItemTemplate
            },
            whitelist: coa_whitelist,
        });
    
        tagify.on('dropdown:show dropdown:updated', onDefaultsDropdownShow);
        tagify.on('dropdown:select', onDefaultsSelectSuggestion);
        tagify.on('input', onDefaultsInput);
        tagify.on('remove', onDefaultsRemove);
    
        tagify_defaults.push(tagify);
    
    });
})

function onDefaultsDropdownShow(e) {
    var tagify = e.detail.tagify;
}

function onDefaultsSelectSuggestion(e) {
    var tagify = e.detail.tagify;
}

function onDefaultsInput(e) {
    var tagify = e.detail.tagify;
    var value = e.detail.value;
    
    tagify.whitelist = null // reset the whitelist

    // https://developer.mozilla.org/en-US/docs/Web/API/AbortController/abort
    controller && controller.abort()
    controller = new AbortController()

    // show loading animation and hide the suggestions dropdown
    tagify.loading(true).dropdown.hide()

    fetch(`/ajax/settings/coa/search/${value}`, {signal:controller.signal})
        .then(RES => RES.json())
        .then(function(newWhitelist){
            tagify.whitelist = newWhitelist // update whitelist Array in-place
            tagify.loading(false).dropdown.show(value) // render the suggestions dropdown
        })
}

function onDefaultsRemove(e) {
    var tagify = e.detail.tagify;
}

function coaTagTemplate(tagData)
{
    return `
        <tag title="${tagData.account_name}"
                contenteditable='false'
                spellcheck='false'
                tabIndex="-1"
                class="tagify__tag ${tagData.class ? tagData.class : ""}"
                ${this.getAttributes(tagData)}>
            <x title='' class='tagify__tag__removeBtn' role='button' aria-label='remove tag'></x>
            <div>
                <div class='tagify__tag__avatar-wrap'>
                    <img onerror="this.style.visibility='hidden'" src="${tagData.avatar}">
                </div>
                <span class='tagify__tag-text'>${tagData.label}</span>
            </div>
        </tag>
    `
}

function coaSuggestionItemTemplate(tagData)
{
    return `
    <div ${this.getAttributes(tagData)}
        class='tagify__dropdown__item ${tagData.class ? tagData.class : ""}'
        tabindex="0"
        role="option">
        ${ tagData.avatar ? `
        <div class='tagify__dropdown__item__avatar-wrap'>
            <img onerror="this.style.visibility='hidden'" src="${tagData.avatar}">
        </div>` : ''
        }
        <strong>${tagData.account_name}</strong><br>
        <span>${tagData.chart_of_account_no} | ${tagData.category} | ${tagData.type}</span>
    </div>
`
}