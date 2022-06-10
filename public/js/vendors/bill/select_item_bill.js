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

    calculateBillSubTotal();
    calculateBillGrandTotal();
});

// Set events of quantity field.
$(document).on('change', '.b_item_quantity', function(event) {
    id = $(this)[0].dataset.id;
    quantity = $(this)[0].value;
    sale_price = $(`#b_item_price_${id}`).val();
    console.log(sale_price);
    
    // Update item total
    $(`#b_item_total_${id}`).val(parseFloat(parseFloat(sale_price) * parseFloat(quantity)).toFixed(2))

    calculateBillSubTotal();
    calculateBillGrandTotal();
});

// Creates a Bill Item Entry on the Table.
function createBillItemEntry(item = undefined) 
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
                <p class="error-message error-message-item text-danger" style="display:none"></p>
            </div>
        </td>
        <td>
            <input type="number" data-id="${bill_count}" id="b_item_quantity_${bill_count}" class="form-control b_item_quantity" name="quantity[]" placeholder="0" min="1" disabled required>
            <p class="error-message error-message-quantity text-danger" style="display:none"></p>
        </td>
        <td>
            <input type="text" id="b_item_price_${bill_count}" class="form-control inputPrice b_item_price text-right" name="price[]" value="0.00" disabled>
            <p class="error-message error-message-price text-danger" style="display:none"></p>
        </td>
        <td>
            <input data-id="${bill_count}" id="b_item_tax_${bill_count}" class="b_tax" name='tax[]'>
            <input id="b_item_tax_percentage_${bill_count}" class="b_item_tax_percentage" type="hidden" name="tax_percentage[]" value="0">
            <p class="error-message error-message-tax text-danger" style="display:none"></p>
        </td>
        <td>
            <input type="text" id="b_item_total_${bill_count}" class="form-control text-right b_item_total" name="total[]" placeholder="0.00" disabled>
            <p class="error-message error-message-total text-danger" style="display:none"></p>
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
        
        
        $(`#b_item_${bill_count}`).val(item.inventory.item_name);
        $(`#b_item_quantity_${bill_count}`).val(item.quantity).removeAttr('disabled');
        $(`#b_item_price_${bill_count}`).val(parseFloat(item.inventory.sale_price).toFixed(2))
        $(`#b_item_total_${bill_count}`).val(parseFloat(item.inventory.sale_price * item.quantity).toFixed(2))
        
    }

    // Create new tagify instance of item selector of newly created row.
    let inventory_item_elm = document.querySelector(`#b_item_${bill_count}`);
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
    inventory_item_tagify.on('dropdown:show dropdown:updated', onBillItemDropdownShow)
    inventory_item_tagify.on('dropdown:select', onBillItemSelectSuggestion)
    inventory_item_tagify.on('input', onBillItemInput)
    inventory_item_tagify.on('remove', onBillItemRemove)

    // Create new tagify instance of item selector of newly created row.
    let tax_elm = document.querySelector(`#b_item_tax_${bill_count}`);
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

    $(`#b_item_tax_${bill_count}`).attr('disabled', 'disabled').parents('td').find('.tagify').attr('disabled', 'disabled')

    // Set events of tagify instance.
    tax_tagify.on('dropdown:show dropdown:updated', onTaxDropdownShow)
    tax_tagify.on('dropdown:select', onTaxSelectSuggestion)
    tax_tagify.on('input', onTaxInput)
    tax_tagify.on('remove', onTaxRemove)

    // Push item to array bill_items
    let item_entry = {
        "entry_id": bill_count,
        "tagify": inventory_item_tagify,
        "tax": tax_tagify,
        "value": null,
    }

    bill_items.push(item_entry);
    console.log(bill_items);
}

// Removes a Bill Item Entry from the Table.
function removeBillItemEntry(entry_id)
{
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
    item_total_prices = document.querySelectorAll(".b_item_total");
    console.log("Calculate Bill Subtotal:");
    console.log(item_total_prices);

    item_total_prices.forEach(function(item_total_price){
        console.log(item_total_price.value);
        subtotal += item_total_price.value != '' ? parseFloat(item_total_price.value) : 0;
    });

    $(`#b_sub_total`).val(parseFloat(subtotal).toFixed(2))
}

function calculateBillTaxTotal()
{
    tax_total = 0;
    console.log(`Attempt to Calculate Tax Total`);
    
    tax_percentages = document.querySelectorAll(".b_item_tax_percentage");
    item_prices = document.querySelectorAll(".b_item_price")

    for(i = 0; i < item_prices.length; i++)
    {
        tax_total += parseFloat(item_prices[i].value) * parseFloat(tax_percentages[i].value) / 100;
    }

    console.log("Tax Total: " + tax_total);
    $(`.b_tax_total`).val(parseFloat(tax_total).toFixed(2))

    return tax_total;
}

function calculateBillGrandTotal()
{
    tax_total = calculateBillTaxTotal();

    grandtotal = 0;
    item_total_prices = document.querySelectorAll(".b_item_total");
    console.log("Calculate Bill Grandtotal:");
    console.log(item_total_prices);

    item_total_prices.forEach(function(item_total_price){
        console.log(item_total_price.value);
        grandtotal += item_total_price.value != '' ? parseFloat(item_total_price.value) : 0;
    });

    grandtotal += tax_total;

    $(`#b_grand_total`).val(parseFloat(grandtotal).toFixed(2))
}

/** === Tagify Related Functions for Bill Items === */

function onBillItemDropdownShow(e) {
    // var dropdownContentElm = e.detail.bill_select_item_tagify.DOM.dropdown.content;
}

function onBillItemSelectSuggestion(e) {
    id = e.detail.tagify.DOM.originalInput.dataset.id;
    
    $(`#b_item_quantity_${id}`).val(1).removeAttr('disabled')
    $(`#b_item_price_${id}`).val(parseFloat(e.detail.data.sale_price).toFixed(2))
    $(`#b_item_total_${id}`).val(parseFloat(e.detail.data.sale_price * 1).toFixed(2))
    // Remove the disabled attribute of nearby .tagify element
    $(`#b_item_tax_${id}`).removeAttr('disabled').parents('td').find('.tagify').removeAttr('disabled');
    
    if(e.detail.data.tax_id != null) setTaxWhitelist(e.detail.data, id);

    item_total = e.detail.data.sale_price * e.detail.data.quantity;
    
    // Recalculate total
    calculateBillSubTotal();
    calculateBillGrandTotal();
}

function onBillItemRemove(e) {
    id = e.detail.tagify.DOM.originalInput.dataset.id;
    
    //Subtract total when x is clicked in tagify
    $(`#b_sub_total`).val(parseFloat($(`#b_sub_total`).val() - $(`#b_item_total_${id}`).val()).toFixed(2))
    $(`#b_grand_total`).val(parseFloat($(`#b_grand_total`).val() - $(`#b_item_total_${id}`).val()).toFixed(2))
    $(`#b_item_quantity_${id}`).attr('disabled', 'disabled')
    $(`#b_item_tax_${id}`).attr('disabled', 'disabled').parents('td').find('.tagify').attr('disabled', 'disabled');

    getBillItemEntry(id).tax.removeTag(e.detail.tag.value);

    $(`#b_item_quantity_${id}`).val("0")
    $(`#b_item_price_${id}`).val("0.00")
    $(`#b_item_total_${id}`).val("0.00")

}

function onBillItemInput(e) {    
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

function onTaxDropdownShow(e) {
    // var dropdownContentElm = e.detail.bill_select_item_tagify.DOM.dropdown.content;
}

function onTaxSelectSuggestion(e) {
    id = e.detail.tagify.DOM.originalInput.dataset.id;
    $(`#b_item_tax_percentage_${id}`).val(e.detail.data.percentage);

    calculateBillGrandTotal();
}

function onTaxRemove(e) {
    id = e.detail.tagify.DOM.originalInput.dataset.id;
    $(`#b_item_tax_percentage_${id}`).val(0);

    calculateBillGrandTotal();
}

function onTaxInput(e) {    
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

function setTaxWhitelist(item, id)
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

    tax = getBillItemEntry(id).tax
    tax.whitelist = whitelist;
    tax.addTags(whitelist[0].value);
    
    $(`#b_item_tax_${id}`).parents('td').find('span').html(whitelist[0].label);
    $(`#b_item_tax_${id}`).parents('td').find('tag').attr('percentage', whitelist[0].percentage);
    $(`#b_item_tax_percentage_${id}`).val(whitelist[0].percentage);
    
    console.log(tax);
}