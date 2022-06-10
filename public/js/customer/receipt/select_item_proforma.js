// This array lists down the items within the proforma.
var proforma_items = []; 

// This variable counts how many instances of proforma items are made.
// This ensures that there will be no conflict ids on proforma item elements.
var proforma_count = 0; 

// Create a proforma item entry when document is fully loaded or when add entry button is clicked.
$(document).ready(createProformaItemEntry());
$(document).on('click', '.p_add_item_entry', function(){
    createProformaItemEntry()
})

// Delete the proforma item entry when the row's delete button is clicked.
$(document).on('click', '.p_item_delete', function (event) {
    removeProformaItemEntry( $(this)[0].dataset.id )
    $(this).parents('tr').remove();

    // If there are no longer item entries in table, generate a new one.
    if(proforma_items.length < 1) createProformaItemEntry();

    calculateProformaSubTotal();
    calculateProformaGrandTotal();
});

// Set events of quantity field.
$(document).on('change', '.p_item_quantity', function(event) {
    id = $(this)[0].dataset.id;
    quantity = $(this)[0].value;
    sale_price = $(`#p_item_price_${id}`).val()
    console.log(sale_price)
    
    // Update item total
    $(`#p_item_total_${id}`).val(parseFloat(parseFloat(sale_price) * parseFloat(quantity)).toFixed(2))

    calculateProformaSubTotal();
    calculateProformaGrandTotal();
});

// Creates a Proforma Item Entry on the Table.
function createProformaItemEntry(item = undefined) 
{
    // Increment proforma_count to avoid element conflicts.
    proforma_count++;

    // <tr> template
    let inner = `
    <tr data-id="${proforma_count}" id="p_item_entry_${proforma_count}">
        <td>
            <div class="input-group">
                <input data-id="${proforma_count}" id="p_item_${proforma_count}" class="p_item" name='item[]'>
                <input type="hidden" name="item_id[]" value="">
                <p class="error-message error-message-item text-danger" style="display:none"></p>
            </div>
        </td>
        <td>
            <input type="number" data-id="${proforma_count}" id="p_item_quantity_${proforma_count}" class="form-control p_item_quantity" name="quantity[]" placeholder="0" min="1" disabled>
            <p class="error-message error-message-quantity text-danger" style="display:none"></p>
        </td>
        <td>
            <input type="text" id="p_item_price_${proforma_count}" class="form-control inputPrice p_item_price text-right" name="price[]" value="0.00" disabled>
            <p class="error-message error-message-price text-danger" style="display:none"></p>
        </td>
        <td>
            <input data-id="${proforma_count}" id="p_item_tax_${proforma_count}" class="p_tax" name='tax[]'>
            <input id="p_item_tax_percentage_${proforma_count}" class="p_item_tax_percentage" type="hidden" name="tax_percentage[]" value="0">
            <p class="error-message error-message-tax text-danger" style="display:none"></p>
        </td>
        <td>
            <input type="text" id="p_item_total_${proforma_count}" class="form-control text-right p_item_total" name="total[]" placeholder="0.00" disabled>
            <p class="error-message error-message-total text-danger" style="display:none"></p>
        </td>
        <td>
            <button type="button" data-id="${proforma_count}" id="p_item_delete_${proforma_count}" class="btn btn-icon btn-danger p_item_delete" data-toggle="tooltip" data-placement="bottom" title="Edit">
                <span class="icon text-white-50">
                    <i class="fas fa-trash"></i>
                </span>
            </button>
            <button type="button" class="btn btn-small btn-icon btn-primary p_add_item_entry" data-toggle="tooltip" data-placement="bottom" title="Edit">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
            </button>
        </td>
    </tr>
    `

    // Append template to the table.
    $("#p_items").append(inner)

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
        
        
        $(`#p_item_${proforma_count}`).val(item.inventory.item_name);
        $(`#p_item_quantity_${proforma_count}`).val(item.quantity).removeAttr('disabled');
        $(`#p_item_price_${proforma_count}`).val(parseFloat(item.inventory.sale_price).toFixed(2))
        $(`#p_item_total_${proforma_count}`).val(parseFloat(item.inventory.sale_price * item.quantity).toFixed(2))
        
    }

    // Create new tagify instance of item selector of newly created row.
    let inventory_item_elm = document.querySelector(`#p_item_${proforma_count}`);
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
    inventory_item_tagify.on('dropdown:show dropdown:updated', onProformaItemDropdownShow)
    inventory_item_tagify.on('dropdown:select', onProformaItemSelectSuggestion)
    inventory_item_tagify.on('input', onProformaItemInput)
    inventory_item_tagify.on('remove', onProformaItemRemove)

    // Create new tagify instance of item selector of newly created row.
    let tax_elm = document.querySelector(`#p_item_tax_${proforma_count}`);
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

    $(`#p_item_tax_${proforma_count}`).attr('disabled', 'disabled').parents('td').find('.tagify').attr('disabled', 'disabled')

    // Set events of tagify instance.
    tax_tagify.on('dropdown:show dropdown:updated', onTaxProformaDropdownShow)
    tax_tagify.on('dropdown:select', onTaxProformaSelectSuggestion)
    tax_tagify.on('input', onTaxProformaInput)
    tax_tagify.on('remove', onTaxProformaRemove)

    // Push item to array proforma_items
    let item_entry = {
        "entry_id": proforma_count,
        "tagify": inventory_item_tagify,
        "tax": tax_tagify,
        "value": null,
    }

    proforma_items.push(item_entry);
    console.log(proforma_items);
}

// Removes a Proforma Item Entry from the Table.
function removeProformaItemEntry(entry_id)
{
    for(let i = 0; i < proforma_items.length; i++)
    {
        if(proforma_items[i].entry_id == entry_id)
        {   
            console.log("Removing entry " + entry_id);
            proforma_items.splice(i, 1);
            return true;
        }
    }   
    return false;
}

// Gets the proforma item entry from the table.
function getProformaItemEntry(entry_id)
{
    for(let i = 0; i < proforma_items.length; i++)
    {
        if(proforma_items[i].entry_id == entry_id)
        {
            console.log("Found entry.");
            return proforma_items[i];
        }
    }   
    return undefined;
}

// Gets the proforma item index from the table.
function getProformaItemIndex(entry_id)
{
    for(let i = 0; i < proforma_items.length; i++)
    {
        if(proforma_items[i].entry_id == entry_id)
        {
            console.log("Found entry.");
            return i;
        }
    }   
    return undefined;
}

/** === Calculation Functions === */
function calculateProformaSubTotal()
{
    subtotal = 0;
    item_total_prices = document.querySelectorAll(".p_item_total");
    console.log("Calculate Proforma Subtotal:");
    console.log(item_total_prices);

    item_total_prices.forEach(function(item_total_price){
        console.log(item_total_price.value);
        subtotal += item_total_price.value != '' ? parseFloat(item_total_price.value) : 0;
    });

    $(`#p_sub_total`).val(parseFloat(subtotal).toFixed(2))
}

function calculateProformaTaxTotal()
{
    tax_total = 0;
    console.log(`Attempt to Calculate Tax Total`);
    
    tax_percentages = document.querySelectorAll(".p_item_tax_percentage");
    item_prices = document.querySelectorAll(".p_item_price")

    for(i = 0; i < item_prices.length; i++)
    {
        tax_total += parseFloat(item_prices[i].value) * parseFloat(tax_percentages[i].value) / 100;
    }

    console.log("Tax Total: " + tax_total);
    $(`.p_tax_total`).val(parseFloat(tax_total).toFixed(2))

    return tax_total;
}

function calculateProformaGrandTotal()
{
    tax_total = calculateProformaTaxTotal();

    grandtotal = 0;
    item_total_prices = document.querySelectorAll(".p_item_total");
    console.log("Calculate Proforma Grandtotal:");
    console.log(item_total_prices);

    item_total_prices.forEach(function(item_total_price){
        console.log(item_total_price.value);
        grandtotal += item_total_price.value != '' ? parseFloat(item_total_price.value) : 0;
    });

    grandtotal += tax_total;

    $(`#p_grand_total`).val(parseFloat(grandtotal).toFixed(2))
}

/** === Tagify Related Functions for Proforma Items === */

function onProformaItemDropdownShow(e) {
    // var dropdownContentElm = e.detail.proforma_select_item_tagify.DOM.dropdown.content;
}

function onProformaItemSelectSuggestion(e) {
    id = e.detail.tagify.DOM.originalInput.dataset.id;
    
    $(`#p_item_quantity_${id}`).val(1).removeAttr('disabled')
    $(`#p_item_price_${id}`).val(parseFloat(e.detail.data.sale_price).toFixed(2))
    $(`#p_item_total_${id}`).val(parseFloat(e.detail.data.sale_price * 1).toFixed(2))
    // Remove the disabled attribute of nearby .tagify element
    $(`#p_item_tax_${id}`).removeAttr('disabled').parents('td').find('.tagify').removeAttr('disabled');
    
    if(e.detail.data.tax_id != null) setTaxProformaWhitelist(e.detail.data, id);

    item_total = e.detail.data.sale_price * e.detail.data.quantity;
    
    // Recalculate total
    calculateProformaSubTotal();
    calculateProformaGrandTotal();
}

function onProformaItemRemove(e) {
    id = e.detail.tagify.DOM.originalInput.dataset.id;
    
    //Subtract total when x is clicked in tagify
    $(`#p_sub_total`).val(parseFloat($(`#p_sub_total`).val() - $(`#p_item_total_${id}`).val()).toFixed(2))
    $(`#p_grand_total`).val(parseFloat($(`#p_grand_total`).val() - $(`#p_item_total_${id}`).val()).toFixed(2))
    $(`#p_item_quantity_${id}`).attr('disabled', 'disabled')
    $(`#p_item_tax_${id}`).attr('disabled', 'disabled').parents('td').find('.tagify').attr('disabled', 'disabled');

    getProformaItemEntry(id).tax.removeTag(e.detail.tag.value);

    $(`#p_item_quantity_${id}`).val("0")
    $(`#p_item_price_${id}`).val("0.00")
    $(`#p_item_total_${id}`).val("0.00")

}

function onProformaItemInput(e) {    
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

function onTaxProformaDropdownShow(e) {
    // var dropdownContentElm = e.detail.proforma_select_item_tagify.DOM.dropdown.content;
}

function onTaxProformaSelectSuggestion(e) {
    id = e.detail.tagify.DOM.originalInput.dataset.id;
    $(`#p_item_tax_percentage_${id}`).val(e.detail.data.percentage);

    calculateProformaGrandTotal();
}

function onTaxProformaRemove(e) {
    id = e.detail.tagify.DOM.originalInput.dataset.id;
    $(`#p_item_tax_percentage_${id}`).val(0);

    calculateProformaGrandTotal();
}

function onTaxProformaInput(e) {    
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

function setTaxProformaWhitelist(item, id)
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

    tax = getProformaItemEntry(id).tax
    tax.whitelist = whitelist;
    tax.addTags(whitelist[0].value);
    
    $(`#p_item_tax_${id}`).parents('td').find('span').html(whitelist[0].label);
    $(`#p_item_tax_${id}`).parents('td').find('tag').attr('percentage', whitelist[0].percentage);
    $(`#p_item_tax_percentage_${id}`).val(whitelist[0].percentage);
    
    console.log(tax);
}