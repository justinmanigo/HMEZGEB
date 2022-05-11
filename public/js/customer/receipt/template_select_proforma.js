function proformaTagTemplate(tagData){
    return `
        <tag title="${tagData.value}"
                contenteditable='false'
                spellcheck='false'
                tabIndex="-1"
                class="tagify__tag ${tagData.class ? tagData.class : ""}"
                ${this.getAttributes(tagData)}>
            <x title='' id="r-proforma-remove" class='tagify__tag__removeBtn' role='button' aria-label='remove tag'></x>
            <div>
                <span class='tagify__tag-text'>Fs#${tagData.value}</span>
            </div>
        </tag>
    `
}

function proformaSuggestionItemTemplate(tagData){
    return `
        <div ${this.getAttributes(tagData)}
            class='tagify__dropdown__item ${tagData.class ? tagData.class : ""}'
            tabindex="0"
            role="option">
            <strong>Fs#${tagData.value}</strong><br>
            <small>Date: ${tagData.date}</small><br>
            <small>Amount: ${tagData.amount}</small>
        </div>
    `
}