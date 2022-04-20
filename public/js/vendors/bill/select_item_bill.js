// This array lists down the items within the bill.
var bill_items = []; 

// This variable counts how many instances of bill items are made.
// This ensures that there will be no conflict ids on bill item elements.
var bill_count = 0; 

// Create a bill item entry when document is fully loaded or when add entry button is clicked.
$(document).ready(createBillItemEntry());
$(document).on('click', '.b_add_item_entry', function(){
    createBillItemEntry()
})

// Delete the bill item entry when the row's delete button is clicked.
$(document).on('click', '.b_item_delete', function (event) {
    removeBillItemEntry( $(this)[0].dataset.id )
    $(this).parents('tr').remove();

    // If there are no longer item entries in table, generate a new one.
    if(bill_items.length < 1) createBillItemEntry();
});

// Set events of quantity field.
$(document).on('change', '.b_item_quantity', function(event) {
    id = $(this)[0].dataset.id;
    quantity = $(this)[0].value;
    sale_price = $(`#b_item_price_${id}`).val()
    console.log(sale_price)
    
    // Update item total
    $(`#b_item_total_${id}`).val(parseFloat(parseFloat(sale_price) * parseFloat(quantity)).toFixed(2))

    // Update overall total
    item_idx = getBillItemIndex(id);
    bill_items[item_idx].total_price = sale_price * quantity;
    calculateBillSubTotal();
    calculateBillGrandTotal();
});

// Creates a Bill Item Entry on the Table.
function createBillItemEntry() 
{
    // Increment bill_count to avoid element conflicts.
    bill_count++;

    // <tr> template
    let inner = `
    <tr data-id="${bill_count}" id="b_item_entry_${bill_count}">
        <td>
            <div class="input-group">
                <input data-id="${bill_count}" id="b_item_${bill_count}" class="b_item" name='item[]'>
                <input type="hidden" name="item_id[]" value="">
            </div>
        </td>
        <td>
            <input type="number" data-id="${bill_count}" id="b_item_quantity_${bill_count}" class="form-control b_item_quantity" name="quantity[]" placeholder="0" min="1" disabled>
        </td>
        <td>
            <input type="text" id="b_item_price_${bill_count}" class="form-control inputPrice text-right" name="price[]" placeholder="0.00" disabled>
        </td>
        <td>
            <select id="b_item_tax_${bill_count}" class="form-control" name="tax[]">
                <option>Sales Tax (15%)</option>
            </select>
        </td>
        <td>
            <input type="text" id="b_item_total_${bill_count}" class="form-control text-right" name="total[]" placeholder="0.00" disabled>
        </td>
        <td>
            <button type="button" data-id="${bill_count}" id="b_item_delete_${bill_count}" class="btn btn-icon btn-danger b_item_delete" data-toggle="tooltip" data-placement="bottom" title="Edit">
                <span class="icon text-white-50">
                    <i class="fas fa-trash"></i>
                </span>
            </button>
            <button type="button" class="btn btn-small btn-icon btn-primary b_add_item_entry" data-toggle="tooltip" data-placement="bottom" title="Edit">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
            </button>
        </td>
    </tr>
    `

    // Append template to the table.
    $("#b_items").append(inner)

    // Create new tagify instance of item selector of newly created row.
    let elm = document.querySelector(`#b_item_${bill_count}`);
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
    elm_tagify.on('dropdown:show dropdown:updated', onBillItemDropdownShow)
    elm_tagify.on('dropdown:select', onBillItemSelectSuggestion)
    elm_tagify.on('input', onBillItemInput)
    elm_tagify.on('remove', onBillItemRemove)

    // Push item to array bill_items
    let item_entry = {
        "entry_id": bill_count,
        "tagify": elm_tagify,
        "sale_price": 0,
        "total_price": 0,
        "value": null,
    }

    bill_items.push(item_entry);
    console.log(bill_items);
}

// Removes a Bill Item Entry from the Table.
function removeBillItemEntry(entry_id)
{
    
    $(`#b_sub_total`).val(parseFloat($(`#b_sub_total`).val() - $(`#b_item_total_${entry_id}`).val()).toFixed(2))
    $(`#b_grand_total`).val(parseFloat($(`#b_grand_total`).val() - $(`#b_item_total_${entry_id}`).val()).toFixed(2))

    for(let i = 0; i < bill_items.length; i++)
    {
        if(bill_items[i].entry_id == entry_id)
        {   
            console.log("Removing entry " + entry_id);
            bill_items.splice(i, 1);
            return true;
        }
    }   
    return false;
}

// Gets the bill item entry from the table.
function getBillItemEntry(entry_id)
{
    for(let i = 0; i < bill_items.length; i++)
    {
        if(bill_items[i].entry_id == entry_id)
        {
            console.log("Found entry.");
            return bill_items[i];
        }
    }   
    return undefined;
}

// Gets the bill item index from the table.
function getBillItemIndex(entry_id)
{
    for(let i = 0; i < bill_items.length; i++)
    {
        if(bill_items[i].entry_id == entry_id)
        {
            console.log("Found entry.");
            return i;
        }
    }   
    return undefined;
}

/** === Calculation Functions === */
function calculateBillSubTotal()
{
    subtotal = 0;
    for(i = 0; i < bill_items.length; i++)
        subtotal += bill_items[i].total_price;

    $(`#b_sub_total`).val(parseFloat(subtotal).toFixed(2))
}

function calculateBillGrandTotal()
{
    grandtotal = 0;
    for(i = 0; i < bill_items.length; i++)
    grandtotal += bill_items[i].total_price;

    $(`#b_grand_total`).val(parseFloat(grandtotal).toFixed(2))
}

/** === Tagify Related Functions === */

function onBillItemDropdownShow(e) {
    console.log("onBillItemDropdownShow")
    var dropdownContentElm = e.detail.bill_select_item_tagify.DOM.dropdown.content;
}

function onBillItemSelectSuggestion(e) {
    id = e.detail.tagify.DOM.originalInput.dataset.id;
    
    $(`#b_item_quantity_${id}`).val(1).removeAttr('disabled')
    $(`#b_item_price_${id}`).val(parseFloat(e.detail.data.sale_price).toFixed(2))
    $(`#b_item_total_${id}`).val(parseFloat(e.detail.data.sale_price * 1).toFixed(2))

    item_total = e.detail.data.sale_price * e.detail.data.quantity;
    console.log(parseFloat(item_total).toFixed(2));
    console.log($(`#b_sub_total`).val())
    console.log()
    
    // Add all item total to subtotal
    $(`#b_sub_total`).val(parseFloat(parseFloat($(`#b_sub_total`).val()) + parseFloat($(`#b_item_total_${id}`).val())).toFixed(2))
    $(`#b_grand_total`).val(parseFloat(parseFloat($(`#b_grand_total`).val()) + parseFloat($(`#b_item_total_${id}`).val())).toFixed(2))

}

function onBillItemRemove(e) {
    id = e.detail.tagify.DOM.originalInput.dataset.id;
    
    //Subtract total when x is clicked in tagify
    $(`#b_sub_total`).val(parseFloat($(`#b_sub_total`).val() - $(`#b_item_total_${id}`).val()).toFixed(2))
    $(`#b_grand_total`).val(parseFloat($(`#b_grand_total`).val() - $(`#b_item_total_${id}`).val()).toFixed(2))
    $(`#b_item_quantity_${id}`).attr('disabled', 'disabled')

    $(`#b_item_quantity_${id}`).val("0")
    $(`#b_item_price_${id}`).val("0.00")
    $(`#b_item_total_${id}`).val("0.00")

}

function onBillItemInput(e) {
    console.log(e.detail);
    console.log(e.detail.tagify.DOM.originalInput.dataset.id)
    
    var entry_id = e.detail.tagify.DOM.originalInput.dataset.id
    var value = e.detail.value;
    var tagify;

    console.log(bill_items);
    entry_obj = getBillItemEntry(entry_id);

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