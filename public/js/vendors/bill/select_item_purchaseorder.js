// This array lists down the items within the purchaseorder.
var purchaseorder_items = []; 

// This variable counts how many instances of purchaseorder items are made.
// This ensures that there will be no conflict ids on purchaseorder item elements.
var purchaseorder_count = 0; 

// Create a purchaseorder item entry when document is fully loaded or when add entry button is clicked.
$(document).ready(createPurchaseOrderItemEntry());
$(document).on('click', '.po_add_item_entry', function(){
    createPurchaseOrderItemEntry()
})

// Delete the purchaseorder item entry when the row's delete button is clicked.
$(document).on('click', '.po_item_delete', function (event) {
    removePurchaseOrderItemEntry( $(this)[0].dataset.id )
    $(this).parents('tr').remove();

    // If there are no longer item entries in table, generate a new one.
    if(purchaseorder_items.length < 1) createPurchaseOrderItemEntry();
});

// Set events of quantity field.
$(document).on('change', '.po_item_quantity', function(event) {
    id = $(this)[0].dataset.id;
    quantity = $(this)[0].value;
    sale_price = $(`#po_item_price_${id}`).val()
    console.log(sale_price)
    
    // Update item total
    $(`#po_item_total_${id}`).val(parseFloat(parseFloat(sale_price) * parseFloat(quantity)).toFixed(2))

    // Update overall total
    item_idx = getPurchaseOrderItemIndex(id);
    purchaseorder_items[item_idx].total_price = sale_price * quantity;
    calculatePurchaseOrderSubTotal();
    calculatePurchaseOrderGrandTotal();
});

// Creates a PurchaseOrder Item Entry on the Table.
function createPurchaseOrderItemEntry() 
{
    // Increment purchaseorder_count to avoid element conflicts.
    purchaseorder_count++;

    // <tr> template
    let inner = `
    <tr data-id="${purchaseorder_count}" id="po_item_entry_${purchaseorder_count}">
        <td>
            <div class="input-group">
                <input data-id="${purchaseorder_count}" id="po_item_${purchaseorder_count}" class="po_item" name='item[]'>
                <input type="hidden" name="item_id[]" value="">
            </div>
        </td>
        <td>
            <input type="number" data-id="${purchaseorder_count}" id="po_item_quantity_${purchaseorder_count}" class="form-control po_item_quantity" name="quantity[]" placeholder="0" min="1" disabled>
        </td>
        <td>
            <input type="text" id="po_item_price_${purchaseorder_count}" class="form-control inputPrice text-right" name="price[]" placeholder="0.00" disabled>
        </td>
        <td>
            <select id="po_item_tax_${purchaseorder_count}" class="form-control" name="tax[]">
                <option>Sales Tax (15%)</option>
            </select>
        </td>
        <td>
            <input type="text" id="po_item_total_${purchaseorder_count}" class="form-control text-right" name="total[]" placeholder="0.00" disabled>
        </td>
        <td>
            <button type="button" data-id="${purchaseorder_count}" id="po_item_delete_${purchaseorder_count}" class="btn btn-icon btn-danger po_item_delete" data-toggle="tooltip" data-placement="bottom" title="Edit">
                <span class="icon text-white-50">
                    <i class="fas fa-trash"></i>
                </span>
            </button>
            <button type="button" class="btn btn-small btn-icon btn-primary po_add_item_entry" data-toggle="tooltip" data-placement="bottom" title="Edit">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
            </button>
        </td>
    </tr>
    `

    // Append template to the table.
    $("#po_items").append(inner)

    // Create new tagify instance of item selector of newly created row.
    let elm = document.querySelector(`#po_item_${purchaseorder_count}`);
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
    elm_tagify.on('dropdown:show dropdown:updated', onPurchaseOrderItemDropdownShow)
    elm_tagify.on('dropdown:select', onPurchaseOrderItemSelectSuggestion)
    elm_tagify.on('input', onPurchaseOrderItemInput)
    elm_tagify.on('remove', onPurchaseOrderItemRemove)

    // Push item to array purchaseorder_items
    let item_entry = {
        "entry_id": purchaseorder_count,
        "tagify": elm_tagify,
        "sale_price": 0,
        "total_price": 0,
        "value": null,
    }

    purchaseorder_items.push(item_entry);
    console.log(purchaseorder_items);
}

// Removes a PurchaseOrder Item Entry from the Table.
function removePurchaseOrderItemEntry(entry_id)
{
    
    $(`#po_sub_total`).val(parseFloat($(`#po_sub_total`).val() - $(`#po_item_total_${entry_id}`).val()).toFixed(2))
    $(`#po_grand_total`).val(parseFloat($(`#po_grand_total`).val() - $(`#po_item_total_${entry_id}`).val()).toFixed(2))

    for(let i = 0; i < purchaseorder_items.length; i++)
    {
        if(purchaseorder_items[i].entry_id == entry_id)
        {   
            console.log("Removing entry " + entry_id);
            purchaseorder_items.splice(i, 1);
            return true;
        }
    }   
    return false;
}

// Gets the purchaseorder item entry from the table.
function getPurchaseOrderItemEntry(entry_id)
{
    for(let i = 0; i < purchaseorder_items.length; i++)
    {
        if(purchaseorder_items[i].entry_id == entry_id)
        {
            console.log("Found entry.");
            return purchaseorder_items[i];
        }
    }   
    return undefined;
}

// Gets the purchaseorder item index from the table.
function getPurchaseOrderItemIndex(entry_id)
{
    for(let i = 0; i < purchaseorder_items.length; i++)
    {
        if(purchaseorder_items[i].entry_id == entry_id)
        {
            console.log("Found entry.");
            return i;
        }
    }   
    return undefined;
}

/** === Calculation Functions === */
function calculatePurchaseOrderSubTotal()
{
    subtotal = 0;
    for(i = 0; i < purchaseorder_items.length; i++)
        subtotal += purchaseorder_items[i].total_price;

    $(`#po_sub_total`).val(parseFloat(subtotal).toFixed(2))
}

function calculatePurchaseOrderGrandTotal()
{
    grandtotal = 0;
    for(i = 0; i < purchaseorder_items.length; i++)
    grandtotal += purchaseorder_items[i].total_price;

    $(`#po_grand_total`).val(parseFloat(grandtotal).toFixed(2))
}

/** === Tagify Related Functions === */

function onPurchaseOrderItemDropdownShow(e) {
    console.log("onPurchaseOrderItemDropdownShow")
    var dropdownContentElm = e.detail.purchaseorder_select_item_tagify.DOM.dropdown.content;
}

function onPurchaseOrderItemSelectSuggestion(e) {
    id = e.detail.tagify.DOM.originalInput.dataset.id;
    
    $(`#po_item_quantity_${id}`).val(1).removeAttr('disabled')
    $(`#po_item_price_${id}`).val(parseFloat(e.detail.data.sale_price).toFixed(2))
    $(`#po_item_total_${id}`).val(parseFloat(e.detail.data.sale_price * 1).toFixed(2))

    item_total = e.detail.data.sale_price * e.detail.data.quantity;
    console.log(parseFloat(item_total).toFixed(2));
    console.log($(`#po_sub_total`).val())
    console.log()
    
    // Add all item total to subtotal
    $(`#po_sub_total`).val(parseFloat(parseFloat($(`#po_sub_total`).val()) + parseFloat($(`#po_item_total_${id}`).val())).toFixed(2))
    $(`#po_grand_total`).val(parseFloat(parseFloat($(`#po_grand_total`).val()) + parseFloat($(`#po_item_total_${id}`).val())).toFixed(2))

}

function onPurchaseOrderItemRemove(e) {
    id = e.detail.tagify.DOM.originalInput.dataset.id;
    
    //Subtract total when x is clicked in tagify
    $(`#po_sub_total`).val(parseFloat($(`#po_sub_total`).val() - $(`#po_item_total_${id}`).val()).toFixed(2))
    $(`#po_grand_total`).val(parseFloat($(`#po_grand_total`).val() - $(`#po_item_total_${id}`).val()).toFixed(2))
    $(`#po_item_quantity_${id}`).attr('disabled', 'disabled')

    $(`#po_item_quantity_${id}`).val("0")
    $(`#po_item_price_${id}`).val("0.00")
    $(`#po_item_total_${id}`).val("0.00")

}

function onPurchaseOrderItemInput(e) {
    console.log(e.detail);
    console.log(e.detail.tagify.DOM.originalInput.dataset.id)
    
    var entry_id = e.detail.tagify.DOM.originalInput.dataset.id
    var value = e.detail.value;
    var tagify;

    console.log(purchaseorder_items);
    entry_obj = getPurchaseOrderItemEntry(entry_id);

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