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

    calculateReceiptSubTotal();
    calculateReceiptGrandTotal();
});

// Set events of quantity field.
$(document).on('change', '.r_item_quantity', function(event) {
    id = $(this)[0].dataset.id;
    quantity = $(this)[0].value;
    sale_price = $(`#r_item_price_${id}`).val()
    console.log(sale_price)
    
    // Update item total
    $(`#r_item_total_${id}`).val(parseFloat(parseFloat(sale_price) * parseFloat(quantity)).toFixed(2))

    calculateReceiptSubTotal();
    calculateReceiptGrandTotal();
});

// Creates a Receipt Item Entry on the Table.
function createReceiptItemEntry(item = undefined) 
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
                <p class="error-message error-message-item text-danger" style="display:none"></p>
            </div>
        </td>
        <td>
            <input type="number" data-id="${receipt_count}" id="r_item_quantity_${receipt_count}" class="form-control r_item_quantity" name="quantity[]" placeholder="0" min="1" disabled>
            <p class="error-message error-message-quantity text-danger" style="display:none"></p>
        </td>
        <td>
            <input type="text" id="r_item_price_${receipt_count}" class="form-control inputPrice r_item_price text-right" name="price[]" value="0.00" disabled>
            <p class="error-message error-message-price text-danger" style="display:none"></p>
        </td>
        <td>
            <input data-id="${receipt_count}" id="r_item_tax_${receipt_count}" class="r_tax" name='tax[]'>
            <input id="r_item_tax_percentage_${receipt_count}" class="r_item_tax_percentage" type="hidden" name="tax_percentage[]" value="0">
            <p class="error-message error-message-tax text-danger" style="display:none"></p>
        </td>
        <td>
            <input type="text" id="r_item_total_${receipt_count}" class="form-control text-right r_item_total" name="total[]" placeholder="0.00" disabled>
            <p class="error-message error-message-total text-danger" style="display:none"></p>
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

    var whitelist = [];

    // Set values if item exists.
    if(item != undefined) {
        whitelist = [
            {
                "value": item.inventory.id,
                "name": item.inventory.item_name,
                "sale_price": item.inventory.sale_price,
                "quantity": item.quantity,
            },
        ];
        
        
        $(`#r_item_${receipt_count}`).val(item.inventory.item_name);
        $(`#r_item_quantity_${receipt_count}`).val(item.quantity).removeAttr('disabled');
        $(`#r_item_price_${receipt_count}`).val(parseFloat(item.inventory.sale_price).toFixed(2))
        $(`#r_item_total_${receipt_count}`).val(parseFloat(item.inventory.sale_price * item.quantity).toFixed(2))
        
    }

    // Create new tagify instance of item selector of newly created row.
    let inventory_item_elm = document.querySelector(`#r_item_${receipt_count}`);
    let inventory_item_tagify = new Tagify(inventory_item_elm, {
        tagTextProp: 'name', // very important since a custom template is used with this property as text
        enforceWhitelist: true,
        mode: "select",
        skipInvalid: false, // do not remporarily add invalid tags
        dropdown: {
            closeOnSelect: true,
            enabled: 0,
            classname: 'item-list',
            searchKeys: ['name'] // very important to set by which keys to search for suggesttions when typing
        },
        templates: {
            tag: ItemTagTemplate,
            dropdownItem: ItemSuggestionItemTemplate
        },
        whitelist: whitelist,
    });

    // Set events of tagify instance.
    inventory_item_tagify.on('dropdown:show dropdown:updated', onReceiptItemDropdownShow)
    inventory_item_tagify.on('dropdown:select', onReceiptItemSelectSuggestion)
    inventory_item_tagify.on('input', onReceiptItemInput)
    inventory_item_tagify.on('remove', onReceiptItemRemove)

    // Create new tagify instance of item selector of newly created row.
    let tax_elm = document.querySelector(`#r_item_tax_${receipt_count}`);
    let tax_tagify = new Tagify(tax_elm, {
        tagTextProp: 'label', // very important since a custom template is used with this property as text
        enforceWhitelist: true,
        mode: "select",
        skipInvalid: false, // do not remporarily add invalid tags
        dropdown: {
            closeOnSelect: true,
            enabled: 0,
            classname: 'tax-list',
            searchKeys: ['name'] // very important to set by which keys to search for suggesttions when typing
        },
        templates: {
            tag: TaxTagTemplate,
            dropdownItem: TaxSuggestionItemTemplate
        },
        whitelist: whitelist,
    });

    $(`#r_item_tax_${receipt_count}`).attr('disabled', 'disabled').parents('td').find('.tagify').attr('disabled', 'disabled')

    // Set events of tagify instance.
    tax_tagify.on('dropdown:show dropdown:updated', onTaxReceiptDropdownShow)
    tax_tagify.on('dropdown:select', onTaxReceiptSelectSuggestion)
    tax_tagify.on('input', onTaxReceiptInput)
    tax_tagify.on('remove', onTaxReceiptRemove)

    // Push item to array receipt_items
    let item_entry = {
        "entry_id": receipt_count,
        "tagify": inventory_item_tagify,
        "tax": tax_tagify,
        "value": null,
    }

    receipt_items.push(item_entry);
    console.log(receipt_items);
}

// Removes a Receipt Item Entry from the Table.
function removeReceiptItemEntry(entry_id)
{
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
    item_total_prices = document.querySelectorAll(".r_item_total");
    console.log("Calculate Receipt Subtotal:");
    console.log(item_total_prices);

    item_total_prices.forEach(function(item_total_price){
        console.log(item_total_price.value);
        subtotal += item_total_price.value != '' ? parseFloat(item_total_price.value) : 0;
    });

    $(`#r_sub_total`).val(parseFloat(subtotal).toFixed(2))
}

function calculateReceiptTaxTotal()
{
    tax_total = 0;
    console.log(`Attempt to Calculate Tax Total`);
    
    tax_percentages = document.querySelectorAll(".r_item_tax_percentage");
    item_prices = document.querySelectorAll(".r_item_price")

    for(i = 0; i < item_prices.length; i++)
    {
        tax_total += parseFloat(item_prices[i].value) * parseFloat(tax_percentages[i].value) / 100;
    }

    console.log("Tax Total: " + tax_total);
    $(`.r_tax_total`).val(parseFloat(tax_total).toFixed(2))

    return tax_total;
}

function calculateReceiptGrandTotal()
{
    tax_total = calculateReceiptTaxTotal();

    grandtotal = 0;
    item_total_prices = document.querySelectorAll(".r_item_total");
    console.log("Calculate Receipt Grandtotal:");
    console.log(item_total_prices);

    item_total_prices.forEach(function(item_total_price){
        console.log(item_total_price.value);
        grandtotal += item_total_price.value != '' ? parseFloat(item_total_price.value) : 0;
    });

    grandtotal += tax_total;

    $(`#r_grand_total`).val(parseFloat(grandtotal).toFixed(2))
}

/** === Tagify Related Functions for Receipt Items === */

function onReceiptItemDropdownShow(e) {
    // var dropdownContentElm = e.detail.receipt_select_item_tagify.DOM.dropdown.content;
}

function onReceiptItemSelectSuggestion(e) {
    id = e.detail.tagify.DOM.originalInput.dataset.id;
    
    $(`#r_item_quantity_${id}`).val(1).removeAttr('disabled')
    $(`#r_item_price_${id}`).val(parseFloat(e.detail.data.sale_price).toFixed(2))
    $(`#r_item_total_${id}`).val(parseFloat(e.detail.data.sale_price * 1).toFixed(2))
    // Remove the disabled attribute of nearby .tagify element
    $(`#r_item_tax_${id}`).removeAttr('disabled').parents('td').find('.tagify').removeAttr('disabled');
    
    if(e.detail.data.tax_id != null) setTaxReceiptWhitelist(e.detail.data, id);

    item_total = e.detail.data.sale_price * e.detail.data.quantity;
    
    // Recalculate total
    calculateReceiptSubTotal();
    calculateReceiptGrandTotal();
}

function onReceiptItemRemove(e) {
    id = e.detail.tagify.DOM.originalInput.dataset.id;
    
    //Subtract total when x is clicked in tagify
    $(`#r_sub_total`).val(parseFloat($(`#r_sub_total`).val() - $(`#r_item_total_${id}`).val()).toFixed(2))
    $(`#r_grand_total`).val(parseFloat($(`#r_grand_total`).val() - $(`#r_item_total_${id}`).val()).toFixed(2))
    $(`#r_item_quantity_${id}`).attr('disabled', 'disabled')
    $(`#r_item_tax_${id}`).attr('disabled', 'disabled').parents('td').find('.tagify').attr('disabled', 'disabled');

    getReceiptItemEntry(id).tax.removeTag(e.detail.tag.value);

    $(`#r_item_quantity_${id}`).val("0")
    $(`#r_item_price_${id}`).val("0.00")
    $(`#r_item_total_${id}`).val("0.00")

}

function onReceiptItemInput(e) {    
    var value = e.detail.value;
    var tagify = e.detail.tagify;

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

/** === Tagify Related Functions for Tax Items */

function onTaxReceiptDropdownShow(e) {
    // var dropdownContentElm = e.detail.receipt_select_item_tagify.DOM.dropdown.content;
}

function onTaxReceiptSelectSuggestion(e) {
    id = e.detail.tagify.DOM.originalInput.dataset.id;
    $(`#r_item_tax_percentage_${id}`).val(e.detail.data.percentage);

    calculateReceiptGrandTotal();
}

function onTaxReceiptRemove(e) {
    id = e.detail.tagify.DOM.originalInput.dataset.id;
    $(`#r_item_tax_percentage_${id}`).val(0);

    calculateReceiptGrandTotal();
}

function onTaxReceiptInput(e) {    
    var value = e.detail.value;
    var tagify = e.detail.tagify;

    tagify.whitelist = null // reset the whitelist

    // https://developer.mozilla.org/en-US/docs/Web/API/AbortController/abort
    controller && controller.abort()
    controller = new AbortController()

    // show loading animation and hide the suggestions dropdown
    tagify.loading(true).dropdown.hide()

    fetch('/ajax/settings/taxes/search/' + value, {
            signal: controller.signal
        })
        .then(RES => RES.json())
        .then(function (newWhitelist) {
            tagify.whitelist = newWhitelist // update whitelist Array in-place
            tagify.loading(false).dropdown.show(value) // render the suggestions dropdown
        })
}

function setTaxReceiptWhitelist(item, id)
{
    console.log(`Attempt to set tax whitelist.`);
    console.log(item);

    whitelist = [
        {
            'value': item.tax_id,
            'label': `${item.tax_name} (${item.tax_percentage}%)`,
            'name': item.tax_name,
            'percentage': item.tax_percentage,
        }
    ]

    tax = getReceiptItemEntry(id).tax
    tax.whitelist = whitelist;
    tax.addTags(whitelist[0].value);
    
    $(`#r_item_tax_${id}`).parents('td').find('span').html(whitelist[0].label);
    $(`#r_item_tax_${id}`).parents('td').find('tag').attr('percentage', whitelist[0].percentage);
    $(`#r_item_tax_percentage_${id}`).val(whitelist[0].percentage);
    
    console.log(tax);
}