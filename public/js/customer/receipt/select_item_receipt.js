var receipt_items = [];
var receipt_count = 0;

$(document).ready(function () {
    // console.log(receipt_items.length)
    // Create first <tr> for receipt items
    createReceiptItemEntry()
});

function createReceiptItemEntry() 
{
    receipt_count++;
    let inner = `
    <tr data-id="${receipt_count}" id="r_item_entry_${receipt_count}">
        <td>
            <div class="input-group">
                <input data-id="${receipt_count}" id="r_item_${receipt_count}" class="r_item" name='item[]'>
                <input type="hidden" name="item_id[]" value="">
            </div>
        </td>
        <td>
            <input type="number" id="r_item_quantity_${receipt_count}" class="form-control" name="quantity[]" placeholder="0" disabled>
        </td>
        <td>
            <input type="text" id="r_item_price_${receipt_count}" class="form-control inputPrice text-right" name="price[]" placeholder="0.00" disabled>
        </td>
        <td>
            <select id="r_item_tax_${receipt_count}" class="form-control" name="tax[]">
                <option>Sales Tax (15%)</option>
            </select>
        </td>
        <td>
            <input type="text" id="r_item_total_${receipt_count}" class="form-control text-right" name="total[]" placeholder="0.00" disabled>
        </td>
        <td>
            <button type="button" data-id="${receipt_count}" id="r_item_delete_${receipt_count}" class="btn btn-icon btn-danger r_item_delete" data-toggle="tooltip" data-placement="bottom" title="Edit">
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

    let elm = document.querySelector(`#r_item_${receipt_count}`);
    let elm_tagify = new Tagify(elm, {
        tagTextProp: 'name', // very important since a custom template is used with this property as text
        enforceWhitelist: true,
        mode: "select",
        skipInvalid: false, // do not remporarily add invalid tags
        dropdown: {
            closeOnSelect: true,
            enabled: 0,
            classname: 'item-list',
            searchKeys: ['name', 'email'] // very important to set by which keys to search for suggesttions when typing
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
        "entry_id": receipt_count,
        "tagify": elm_tagify,
        "price": 0,
        "value": null,
    }

    receipt_items.push(item_entry);
    console.log(receipt_items);
}
// add table row for receipt item
$(document).on('click', '.r_add_item_entry', function () {
    createReceiptItemEntry()
})


$(document).on('click', '.r_item_delete', function (event) {
    console.log($(this)[0].dataset.id)
    removeReceiptItemEntry( $(this)[0].dataset.id )
    console.log("Check if its successfully removed.");
    console.log(receipt_items);

    $(this).parents('tr').remove();

    if(receipt_items.length < 1)
    {
        // Convert to zero if no items in receipt
        $(`#r_sub_total`).val('0.00')
        $(`#r_grand_total`).val('0.00')
        console.log("No items left. Generating new one.");
        createReceiptItemEntry();
    }
});




// var receipt_select_item_elm = document.querySelector('#r_item');

// initialize Tagify on the above input node reference
// var receipt_select_item_tagify = new Tagify(receipt_select_item_elm, {
//     tagTextProp: 'name', // very important since a custom template is used with this property as text
//     enforceWhitelist: true,
//     mode: "select",
//     skipInvalid: false, // do not remporarily add invalid tags
//     dropdown: {
//         closeOnSelect: true,
//         enabled: 0,
//         classname: 'item-list',
//         searchKeys: ['name', 'email'] // very important to set by which keys to search for suggesttions when typing
//     },
//     templates: {
//         tag: ItemTagTemplate,
//         dropdownItem: ItemSuggestionItemTemplate
//     },
//     whitelist: [],
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
// })

// receipt_select_item_tagify.on('dropdown:show dropdown:updated', onReceiptItemDropdownShow)
// receipt_select_item_tagify.on('dropdown:select', onReceiptItemSelectSuggestion)
// receipt_select_item_tagify.on('input', onReceiptItemInput)
// receipt_select_item_tagify.on('remove', onReceiptItemRemove)

// var addAllSuggestionsElm;

function onReceiptItemDropdownShow(e) {
    console.log("onReceiptItemDropdownShow")
    var dropdownContentElm = e.detail.receipt_select_item_tagify.DOM.dropdown.content;
}

function onReceiptItemSelectSuggestion(e) {
    id = e.detail.tagify.DOM.originalInput.dataset.id;
    // console.log("onReceiptItemSelectSuggestion")
    // // checks for data of selected customer
    // console.log("Checks for data of selected customer");
    // console.log(e.detail.data);
    // console.log(e.detail.data.value.toString());
    // value = e.detail.data.value;

    // // checks for data of selected element
    // console.log("Get selected element instance.");
    // console.log(e.detail.tagify);
    // tagify = e.detail.tagify;

    // NOT WORKING ATM
    // tagify.removeTags(value.toString(), false, 500)

    // checks receipt items if value already exists in the list. if so,
    // it won't be added.
    // console.log("Checks receipt items if value already exists in the list. If so, it won't be added.")
    // console.log(receipt_items)
      
    $(`#r_item_quantity_${id}`).val(e.detail.data.quantity)
    $(`#r_item_price_${id}`).val(parseFloat(e.detail.data.sale_price).toFixed(2))
    $(`#r_item_total_${id}`).val(parseFloat(e.detail.data.sale_price * e.detail.data.quantity).toFixed(2))

    item_total = e.detail.data.sale_price * e.detail.data.quantity;
    console.log(parseFloat(item_total).toFixed(2));
    console.log($(`#r_sub_total`).val())
    console.log()
    
    // Add all item total to subtotal
    $(`#r_sub_total`).val(parseFloat(parseFloat($(`#r_sub_total`).val()) + parseFloat($(`#r_item_total_${id}`).val())).toFixed(2))
    $(`#r_grand_total`).val(parseFloat(parseFloat($(`#r_grand_total`).val()) + parseFloat($(`#r_item_total_${id}`).val())).toFixed(2))

}

function onReceiptItemRemove(e) {
    id = e.detail.tagify.DOM.originalInput.dataset.id;
    
    //Subtract total when x is clicked in tagify
    $(`#r_sub_total`).val(parseFloat($(`#r_sub_total`).val() - $(`#r_item_total_${id}`).val()).toFixed(2))
    $(`#r_grand_total`).val(parseFloat($(`#r_grand_total`).val() - $(`#r_item_total_${id}`).val()).toFixed(2))

    $(`#r_item_quantity_${id}`).val("0")
    $(`#r_item_price_${id}`).val("0.00")
    $(`#r_item_total_${id}`).val("0.00")

}

function onReceiptItemInput(e) {
    console.log(e.detail);
    console.log(e.detail.tagify.DOM.originalInput.dataset.id)
    
    var entry_id = e.detail.tagify.DOM.originalInput.dataset.id
    var value = e.detail.value;
    var tagify;

    console.log(receipt_items);
    entry_obj = getReceiptItemEntry(entry_id);
    // tagify = entry_obj.tagify;

    console.log("Obtained value from array");
    console.log(tagify);
    
    entry_obj.tagify.whitelist = null // reset the whitelist

    // https://developer.mozilla.org/en-US/docs/Web/API/AbortController/abort
    controller && controller.abort()
    controller = new AbortController()

    // show loading animation and hide the suggestions dropdown
    entry_obj.tagify.loading(true).dropdown.hide()

    fetch('/select/search/inventory/' + value, {
            signal: controller.signal
        })
        .then(RES => RES.json())
        .then(function (newWhitelist) {
            entry_obj.tagify.whitelist = newWhitelist // update whitelist Array in-place
            entry_obj.tagify.loading(false).dropdown.show(value) // render the suggestions dropdown
        })
}

function getReceiptItemEntry(entry_id)
{
    for(let i = 0; i < receipt_items.length; i++)
    {
        if(receipt_items[i].entry_id == entry_id)
        {
            console.log("Found entry.");
            return receipt_items[i];
        }
    }   
    return undefined;
}

function removeReceiptItemEntry(entry_id)
{
    //Subtract total when delete button is clicked
    // $(`#r_sub_total`).val(parseFloat($(`#r_sub_total`).val())-parseFloat($(`#r_item_total_${entry_id}`).val()))
    // $(`#r_grand_total`).val(parseFloat($(`#r_grand_total`).val())-parseFloat($(`#r_item_total_${entry_id}`).val()))
    $(`#r_sub_total`).val(parseFloat($(`#r_sub_total`).val() - $(`#r_item_total_${entry_id}`).val()).toFixed(2))
    $(`#r_grand_total`).val(parseFloat($(`#r_grand_total`).val() - $(`#r_item_total_${entry_id}`).val()).toFixed(2))

    for(let i = 0; i < receipt_items.length; i++)
    {
        if(receipt_items[i].entry_id == entry_id)
        {   
            console.log("Removing entry " + entry_id);
            receipt_items.splice(i, 1);
            return true;
        }
    }   
    return false;
}