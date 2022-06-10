function TaxTagTemplate(tagData){
    return `
        <tag title="${tagData.value}"
                contenteditable='false'
                spellcheck='false'
                tabIndex="-1"
                class="tagify__tag ${tagData.class ? tagData.class : ""}"
                ${this.getAttributes(tagData)}>
            <x title='' id="r-tax-remove" class='tagify__tag__removeBtn' role='button' aria-label='remove tag'></x>
            <div>
                <span class='tagify__tag-text'>Fs#${tagData.label}</span>
            </div>
        </tag>
    `
}

function TaxSuggestionItemTemplate(tagData){
    return `
        <div ${this.getAttributes(tagData)}
            class='tagify__dropdown__item ${tagData.class ? tagData.class : ""}'
            tabindex="0"
            role="option">
            <strong>${tagData.name}</strong><br>
            <small>${parseFloat(tagData.percentage).toFixed(2)}%</small><br>
        </div>
    `
}