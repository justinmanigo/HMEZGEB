function receiptTagTemplate(tagData){
    return `
        <tag title="${tagData.value}"
                contenteditable='false'
                spellcheck='false'
                tabIndex="-1"
                class="tagify__tag ${tagData.class ? tagData.class : ""}"
                ${this.getAttributes(tagData)}>
            <x id='cr-r-remove' title='' class='tagify__tag__removeBtn' role='button' aria-label='remove tag'></x>
            <div>
                <span class='tagify__tag-text'>${tagData.value}</span>
            </div>
        </tag>
    `
}

function receiptSuggestionItemTemplate(tagData){
    return `
        <div ${this.getAttributes(tagData)}
            class='tagify__dropdown__item ${tagData.class ? tagData.class : ""}'
            tabindex="0"
            role="option">
            <p class="m-0 p-0"><strong>Receipt # ${tagData.value}</strong></p><br>
            <small>${tagData.due_date} | Birr ${tagData.amount_to_pay}</small>
        </div>
    `
}