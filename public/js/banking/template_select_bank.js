function bankTagTemplate(tagData){
    return `
        <tag title="${tagData.bank_account_number}"
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
                <span class='tagify__tag-text'>${tagData.chart_of_account_no} - ${tagData.account_name}</span>
            </div>
        </tag>
    `
}

function bankSuggestionItemTemplate(tagData){
    return `
        <div ${this.getAttributes(tagData)}
            class='tagify__dropdown__item ${tagData.class ? tagData.class : ""}'
            tabindex="0"
            role="option">
            <strong class="text-left">${tagData.chart_of_account_no} - ${tagData.account_name} (${tagData.bank_account_type == 'savings' ? 'Savings Account' : 'Checking Account'})</strong><br>
            <small>
                Acct No.: <b>${tagData.bank_account_number}</b><br>
            </small>
        </div>
    `
}