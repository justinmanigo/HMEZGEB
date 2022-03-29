var receipt_items = [];

$(document).ready(function () {
    // console.log(receipt_items.length)
    // Create first <tr> for receipt items
    createReceiptItemEntry()
    createReceiptItemEntry()
});  

function createReceiptItemEntry()
{
    // check length
    console.log(receipt_items.length)
    receipt_items.length++;

    // Create <tr> entry
    let inner = `
    <tr data-id="${receipt_items.length}" id="r_item_entry_${receipt_items.length}">
        <td>
            <div class="input-group">
                <input data-id="${receipt_items.length}" id="r_item_${receipt_items.length}" class="r_item" name='item[]'>
                <input type="hidden" name="item_id[]" value="">
            </div>
        </td>
        <td>
            <input type="number" id="r_item_quantity_${receipt_items.length}" class="form-control" name="quantity[]" placeholder="Enter Quantity" required>
        </td>
        <td>
            <input type="text" id="r_item_price_${receipt_items.length}" class="form-control inputPrice text-right" name="price[]" placeholder="0.00" disabled>
        </td>
        <td>
            <select id="r_item_tax_${receipt_items.length}" class="form-control" name="tax[]">
                <option>Sales Tax (15%)</option>
            </select>
        </td>
        <td>
            <input type="text" id="r_item_total_${receipt_items.length}" class="form-control text-right" name="total[]" placeholder="0.00" disabled>
        </td>
        <td>
            <button type="button" id="r_item_delete_${receipt_items.length}" class="btn btn-icon btn-danger" data-toggle="tooltip" data-placement="bottom" title="Edit">
                <span class="icon text-white-50">
                    <i class="fas fa-trash"></i>
                </span>
            </button>
            <button type="button" class="btn btn-small btn-icon btn-primary r_add_item_entry" data-toggle="tooltip" data-placement="bottom" title="Edit">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
            </button>
        </td>
    </tr>
    `

    $("#r_items").append(inner)

    let elm = document.querySelector(`#r_item_${receipt_items.length}`);
    let elm_tagify = new Tagify(elm, {
        tagTextProp: 'name', // very important since a custom template is used with this property as text
        enforceWhitelist: true,
        mode : "select",
        skipInvalid: false, // do not remporarily add invalid tags
        dropdown: {
            closeOnSelect: true,
            enabled: 0,
            classname: 'item-list',
            searchKeys: ['name', 'email']  // very important to set by which keys to search for suggesttions when typing
        },
        templates: {
            tag: ItemTagTemplate,
            dropdownItem: ItemSuggestionItemTemplate
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

    elm_tagify.on('dropdown:show dropdown:updated', onReceiptItemDropdownShow)
    elm_tagify.on('dropdown:select', onReceiptItemSelectSuggestion)
    elm_tagify.on('input', onReceiptItemInput)
    elm_tagify.on('remove', onReceiptItemRemove)

    // Push item to array receipt_items
    let item_entry = {
        "tagify": elm_tagify,
        "price": 0
    }

    receipt_items.push(item_entry);
}

var receipt_select_item_elm = document.querySelector('#r_item');

// initialize Tagify on the above input node reference
var receipt_select_item_tagify = new Tagify(receipt_select_item_elm, {
    tagTextProp: 'name', // very important since a custom template is used with this property as text
    enforceWhitelist: true,
    mode : "select",
    skipInvalid: false, // do not remporarily add invalid tags
    dropdown: {
        closeOnSelect: true,
        enabled: 0,
        classname: 'item-list',
        searchKeys: ['name', 'email']  // very important to set by which keys to search for suggesttions when typing
    },
    templates: {
        tag: ItemTagTemplate,
        dropdownItem: ItemSuggestionItemTemplate
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

receipt_select_item_tagify.on('dropdown:show dropdown:updated', onReceiptItemDropdownShow)
receipt_select_item_tagify.on('dropdown:select', onReceiptItemSelectSuggestion)
receipt_select_item_tagify.on('input', onReceiptItemInput)
receipt_select_item_tagify.on('remove', onReceiptItemRemove)

var addAllSuggestionsElm;

function onReceiptItemDropdownShow(e){
    var dropdownContentElm = e.detail.receipt_select_item_tagify.DOM.dropdown.content;
}

function onReceiptItemSelectSuggestion(e){
    // checks for data of selected customer
    console.log(e.detail.data);

    // $("#r_customer_id").val(e.detail.data.value)
    // $("#r_tin_number").val(e.detail.data.tin_number)
    // $("#r_contact_person").val(e.detail.data.contact_person)

    // contact number seems to be missing in migration, so i'm skipping this
    // $("#r_contact_number").val(e.detail.data.contact_number)
}

function onReceiptItemRemove(e){
    // $("#r_customer_id").val("")
    // $("#r_tin_number").val("")
    // $("#r_contact_person").val("")
    // $("#r_contact_number").val("")
}

function onReceiptItemInput(e) {
    id = e.detail.tagify.DOM.originalInput.dataset.id
    console.log(e.detail.tagify.DOM.originalInput.dataset.id)

    tagify = receipt_items[id].tagify;
    console.log(receipt_items[id].tagify)

    var value = e.detail.value
    console.log(value)
    tagify.whitelist = null // reset the whitelist

    // https://developer.mozilla.org/en-US/docs/Web/API/AbortController/abort
    controller && controller.abort()
    controller = new AbortController()

    // show loading animation and hide the suggestions dropdown
    tagify.loading(true).dropdown.hide()

    fetch('/select/search/inventory/' + value, {signal:controller.signal})
        .then(RES => RES.json())
        .then(function(newWhitelist){
            tagify.whitelist = newWhitelist // update whitelist Array in-place
            tagify.loading(false).dropdown.show(value) // render the suggestions dropdown
        })
}