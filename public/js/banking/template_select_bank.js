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
            <strong class="text-left">${tagData.chart_of_account_no} - ${tagData.account_name}</strong><br>
            <p style="font-size:14px;line-height:normal">
                Branch: <b>${tagData.bank_branch}</b><br>
                Type: <b>${tagData.bank_account_type == 'savings' ? 'Savings Account' : 'Checking Account'}</b><br>
                Acct No.: <b>${tagData.bank_account_number}</b><br>
            </p>
        </div>
    `
}