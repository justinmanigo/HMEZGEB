// This array lists down the items within the proforma.
var proforma_items = []; 

// This variable counts how many instances of proforma items are made.
// This ensures that there will be no conflict ids on proforma item elements.
var proforma_count = 0; 

// Create a proforma item entry when document is fully loaded or when add entry button is clicked.
$(document).ready(createproformaItemEntry());
$(document).on('click', '.p_add_item_entry', function(){
    createproformaItemEntry()
})

// Delete the proforma item entry when the row's delete button is clicked.
$(document).on('click', '.p_item_delete', function (event) {
    removeproformaItemEntry( $(this)[0].dataset.id )
    $(this).parents('tr').remove();

    // If there are no longer item entries in table, generate a new one.
    if(proforma_items.length < 1) createproformaItemEntry();
});

// Set events of quantity field.
$(document).on('change', '.p_item_quantity', function(event) {
    id = $(this)[0].dataset.id;
    quantity = $(this)[0].value;
    sale_price = $(`#p_item_price_${id}`).val()
    console.log(sale_price)
    
    // Update item total
    $(`#p_item_total_${id}`).val(parseFloat(parseFloat(sale_price) * parseFloat(quantity)).toFixed(2))

    // Update overall total
    calculateproformaSubTotal();
    calculateproformaGrandTotal();
});

// Creates a proforma Item Entry on the Table.
function createproformaItemEntry() 
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
            </div>
        </td>
        <td>
            <input type="number" data-id="${proforma_count}" id="p_item_quantity_${proforma_count}" class="form-control p_item_quantity" name="quantity[]" placeholder="0" min="1" disabled>
        </td>
        <td>
            <input type="text" id="p_item_price_${proforma_count}" class="form-control inputPrice text-right" name="price[]" placeholder="0.00" disabled>
        </td>
        <td>
            <select id="p_item_tax_${proforma_count}" class="form-control" name="tax[]">
                <option>Sales Tax (15%)</option>
            </select>
        </td>
        <td>
            <input type="text" id="p_item_total_${proforma_count}" class="form-control text-right p_item_total" name="total[]" placeholder="0.00" disabled>
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

    // Create new tagify instance of item selector of newly created row.
    let elm = document.querySelector(`#p_item_${proforma_count}`);
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
    elm_tagify.on('dropdown:show dropdown:updated', onproformaItemDropdownShow)
    elm_tagify.on('dropdown:select', onproformaItemSelectSuggestion)
    elm_tagify.on('input', onproformaItemInput)
    elm_tagify.on('remove', onproformaItemRemove)

    // Push item to array proforma_items
    let item_entry = {
        "entry_id": proforma_count,
        "tagify": elm_tagify,
        "value": null,
    }

    proforma_items.push(item_entry);
    console.log(proforma_items);
}

// Removes a proforma Item Entry from the Table.
function removeproformaItemEntry(entry_id)
{
    
    $(`#p_sub_total`).val(parseFloat($(`#p_sub_total`).val() - $(`#p_item_total_${entry_id}`).val()).toFixed(2))
    $(`#p_grand_total`).val(parseFloat($(`#p_grand_total`).val() - $(`#p_item_total_${entry_id}`).val()).toFixed(2))

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
function getproformaItemEntry(entry_id)
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
function getproformaItemIndex(entry_id)
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
function calculateproformaSubTotal()
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

function calculateproformaGrandTotal()
{
    grandtotal = 0;
    item_total_prices = document.querySelectorAll(".p_item_total");
    console.log("Calculate Proforma Grandtotal:");
    console.log(item_total_prices);

    item_total_prices.forEach(function(item_total_price){
        console.log(item_total_price.value);
        grandtotal += item_total_price.value != '' ? parseFloat(item_total_price.value) : 0;
    });

    $(`#p_grand_total`).val(parseFloat(grandtotal).toFixed(2))
}

/** === Tagify Related Functions === */

function onproformaItemDropdownShow(e) {
    console.log("onproformaItemDropdownShow")
    var dropdownContentElm = e.detail.proforma_select_item_tagify.DOM.dropdown.content;
}

function onproformaItemSelectSuggestion(e) {
    id = e.detail.tagify.DOM.originalInput.dataset.id;
    
    $(`#p_item_quantity_${id}`).val(1).removeAttr('disabled')
    $(`#p_item_price_${id}`).val(parseFloat(e.detail.data.sale_price).toFixed(2))
    $(`#p_item_total_${id}`).val(parseFloat(e.detail.data.sale_price * 1).toFixed(2))

    item_total = e.detail.data.sale_price * e.detail.data.quantity;
    console.log(parseFloat(item_total).toFixed(2));
    console.log($(`#p_sub_total`).val())
    console.log()
    
    // Recalculate total
    calculateproformaSubTotal();
    calculateproformaGrandTotal();
}

function onproformaItemRemove(e) {
    id = e.detail.tagify.DOM.originalInput.dataset.id;
    
    //Subtract total when x is clicked in tagify
    $(`#p_sub_total`).val(parseFloat($(`#p_sub_total`).val() - $(`#p_item_total_${id}`).val()).toFixed(2))
    $(`#p_grand_total`).val(parseFloat($(`#p_grand_total`).val() - $(`#p_item_total_${id}`).val()).toFixed(2))
    $(`#p_item_quantity_${id}`).attr('disabled', 'disabled')

    $(`#p_item_quantity_${id}`).val("0")
    $(`#p_item_price_${id}`).val("0.00")
    $(`#p_item_total_${id}`).val("0.00")

}

function onproformaItemInput(e) {
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