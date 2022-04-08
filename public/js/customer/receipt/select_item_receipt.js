// This array lists down the items within the receipt.
var receipt_items = []; 

// This variable counts how many instances of receipt items are made.
// This ensures that there will be no conflict ids on receipt item elements.
var receipt_count = 0; 

// Create a receipt item entry when document is fully loaded or when add entry button is clicked.
$(document).ready(createReceiptItemEntry());
$(document).on('click', '.r_add_item_entry', function(){
    createReceiptItemEntry()
})

// Delete the receipt item entry when the row's delete button is clicked.
$(document).on('click', '.r_item_delete', function (event) {
    removeReceiptItemEntry( $(this)[0].dataset.id )
    $(this).parents('tr').remove();

    // If there are no longer item entries in table, generate a new one.
    if(receipt_items.length < 1) createReceiptItemEntry();
});

// Set events of quantity field.
$(document).on('change', '.r_item_quantity', function(event) {
    id = $(this)[0].dataset.id;
    quantity = $(this)[0].value;
    sale_price = $(`#r_item_price_${id}`).val()
    console.log(sale_price)
    
    // Update item total
    $(`#r_item_total_${id}`).val(parseFloat(parseFloat(sale_price) * parseFloat(quantity)).toFixed(2))

    // Update overall total
    item_idx = getReceiptItemIndex(id);
    receipt_items[item_idx].total_price = sale_price * quantity;
    calculateReceiptSubTotal();
    calculateReceiptGrandTotal();
});

// Creates a Receipt Item Entry on the Table.
function createReceiptItemEntry() 
{
    // Increment receipt_count to avoid element conflicts.
    receipt_count++;

    // <tr> template
    let inner = `
    <tr data-id="${receipt_count}" id="r_item_entry_${receipt_count}">
        <td>
            <div class="input-group">
                <input data-id="${receipt_count}" id="r_item_${receipt_count}" class="r_item" name='item[]'>
                <input type="hidden" name="item_id[]" value="">
            </div>
        </td>
        <td>
            <input type="number" data-id="${receipt_count}" id="r_item_quantity_${receipt_count}" class="form-control r_item_quantity" name="quantity[]" placeholder="0" min="1" disabled>
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

    // Append template to the table.
    $("#r_items").append(inner)

    // Create new tagify instance of item selector of newly created row.
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
    })

    // Set events of tagify instance.
    elm_tagify.on('dropdown:show dropdown:updated', onReceiptItemDropdownShow)
    elm_tagify.on('dropdown:select', onReceiptItemSelectSuggestion)
    elm_tagify.on('input', onReceiptItemInput)
    elm_tagify.on('remove', onReceiptItemRemove)

    // Push item to array receipt_items
    let item_entry = {
        "entry_id": receipt_count,
        "tagify": elm_tagify,
        "sale_price": 0,
        "total_price": 0,
        "value": null,
    }

    receipt_items.push(item_entry);
    console.log(receipt_items);
}

// Removes a Receipt Item Entry from the Table.
function removeReceiptItemEntry(entry_id)
{
    
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

// Gets the receipt item entry from the table.
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

// Gets the receipt item index from the table.
function getReceiptItemIndex(entry_id)
{
    for(let i = 0; i < receipt_items.length; i++)
    {
        if(receipt_items[i].entry_id == entry_id)
        {
            console.log("Found entry.");
            return i;
        }
    }   
    return undefined;
}

/** === Calculation Functions === */
function calculateReceiptSubTotal()
{
    subtotal = 0;
    for(i = 0; i < receipt_items.length; i++)
        subtotal += receipt_items[i].total_price;

    $(`#r_sub_total`).val(parseFloat(subtotal).toFixed(2))
}

function calculateReceiptGrandTotal()
{
    grandtotal = 0;
    for(i = 0; i < receipt_items.length; i++)
    grandtotal += receipt_items[i].total_price;

    $(`#r_grand_total`).val(parseFloat(grandtotal).toFixed(2))
}

/** === Tagify Related Functions === */

function onReceiptItemDropdownShow(e) {
    console.log("onReceiptItemDropdownShow")
    var dropdownContentElm = e.detail.receipt_select_item_tagify.DOM.dropdown.content;
}

function onReceiptItemSelectSuggestion(e) {
    id = e.detail.tagify.DOM.originalInput.dataset.id;
    
    $(`#r_item_quantity_${id}`).val(1).removeAttr('disabled')
    $(`#r_item_price_${id}`).val(parseFloat(e.detail.data.sale_price).toFixed(2))
    $(`#r_item_total_${id}`).val(parseFloat(e.detail.data.sale_price * 1).toFixed(2))

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
    $(`#r_item_quantity_${id}`).attr('disabled', 'disabled')

    $(`#r_item_quantity_${id}`).val("0")
    $(`#r_item_price_${id}`).val("0.00")
    $(`#r_item_total_${id}`).val("0.00")

}

function onReceiptItemInput(e) {
    // console.log(e.detail);
    // console.log(e.detail.tagify.DOM.originalInput.dataset.id)
    
    // var entry_id = e.detail.tagify.DOM.originalInput.dataset.id
    var value = e.detail.value;
    var tagify = e.detail.tagify;

    // console.log(receipt_items);
    // entry_obj = getReceiptItemEntry(entry_id);

    // console.log("Obtained value from array");
    // console.log(tagify);
    
    tagify.whitelist = null // reset the whitelist

    // https://developer.mozilla.org/en-US/docs/Web/API/AbortController/abort
    controller && controller.abort()
    controller = new AbortController()

    // show loading animation and hide the suggestions dropdown
    tagify.loading(true).dropdown.hide()

    fetch('/select/search/inventory/' + value, {
            signal: controller.signal
        })
        .then(RES => RES.json())
        .then(function (newWhitelist) {
            tagify.whitelist = newWhitelist // update whitelist Array in-place
            tagify.loading(false).dropdown.show(value) // render the suggestions dropdown
        })
}