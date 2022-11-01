

var addAllSuggestionsElm;


function onExpenseCashAccountDropdownShow(e){
    var dropdownContentElm = e.detail.tagify.DOM.dropdown.content;
}

function onExpenseCashAccountSelectSuggestion(e){
    // checks for data of selected employee
    console.log(e.detail.data);
}

function onExpenseCashAccountRemove(e){

}

function onExpenseCashAccountInput(e) {
    var value = e.detail.value;
    var tagify = e.detail.tagify;
    tagify.whitelist = null // reset the whitelist

    // https://developer.mozilla.org/en-US/docs/Web/API/AbortController/abort
    controller && controller.abort()
    controller = new AbortController()

    // show loading animation and hide the suggestions dropdown
    tagify.loading(true).dropdown.hide()

    fetch('/ajax/settings/coa/cash/search/' + value, {signal:controller.signal})
        .then(RES => RES.json())
        .then(function(newWhitelist){
            tagify.whitelist = newWhitelist // update whitelist Array in-place
            tagify.loading(false).dropdown.show(value) // render the suggestions dropdown
        })
}

/**
 * Items
 */
// This array lists down the items within the Expense.
var Expense_items = [];

// This variable counts how many instances of Expense items are made.
// This ensures that there will be no conflict ids on Expense item elements.
var Expense_count = 0;

// Create a Expense item entry when document is fully loaded or when add entry button is clicked.
$(document).ready(createExpenseItemEntry());
$(document).on('click', '.expense_add_item_entry', function(){
    createExpenseItemEntry()
})

// Delete the Expense item entry when the row's delete button is clicked.
$(document).on('click', '.expense_item_delete', function (event) {
    removeExpenseItemEntry( $(this)[0].dataset.id )
    $(this).parents('tr').remove();

    // If there are no longer item entries in table, generate a new one.
    if(Expense_items.length < 1) createExpenseItemEntry();

    calculateExpenseSubTotal();
    calculateExpenseGrandTotal();
});

// Set events of quantity field.
$(document).on('change', '.expense_item_quantity', function(event) {
    id = $(this)[0].dataset.id;
    quantity = $(this)[0].value;
    sale_price = $(`#expense_item_price_${id}`).val()
    console.log(sale_price)

    // Update item total
    $(`#expense_item_total_${id}`).val(parseFloat(parseFloat(sale_price) * parseFloat(quantity)).toFixed(2))

    calculateExpenseSubTotal();
    calculateExpenseGrandTotal();
});

// Creates a Expense Item Entry on the Table.
function createExpenseItemEntry(item = undefined)
{
    // Increment Expense_count to avoid element conflicts.
    Expense_count++;

    // <tr> template
    let inner = `
    <tr data-id="${Expense_count}" id="expense_item_entry_${Expense_count}">
        <td>
            <div class="input-group">
                <input data-id="${Expense_count}" id="expense_item_${Expense_count}" class="expense_item" name='item[]'>
                <input type="hidden" name="item_id[]" value="">
                <p class="error-message error-message-item text-danger" style="display:none"></p>
            </div>
        </td>
        <td>
            <input type="text" id="expense_item_price_${Expense_count}" class="form-control inputPrice expense_item_price text-right" name="price[]" value="0.00" required>
            <p class="error-message error-message-price text-danger" style="display:none"></p>
        </td>
        <td>
            <input data-id="${Expense_count}" id="expense_item_tax_${Expense_count}" class="expense_tax" name='tax[]'>
            <input id="expense_item_tax_percentage_${Expense_count}" class="expense_item_tax_percentage" type="hidden" name="tax_percentage[]" value="0">
            <p class="error-message error-message-tax text-danger" style="display:none"></p>
        </td>
        <td>
            <input type="text" id="expense_item_total_${Expense_count}" class="form-control text-right expense_item_total" name="total[]" placeholder="0.00" disabled>
            <p class="error-message error-message-total text-danger" style="display:none"></p>
        </td>
        <td>
            <button type="button" data-id="${Expense_count}" id="expense_item_delete_${Expense_count}" class="btn btn-icon btn-danger expense_item_delete" data-toggle="tooltip" data-placement="bottom" title="Edit">
                <span class="icon text-white-50">
                    <i class="fas fa-trash"></i>
                </span>
            </button>
            <button type="button" class="btn btn-small btn-icon btn-primary expense_add_item_entry" data-toggle="tooltip" data-placement="bottom" title="Edit">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
            </button>
        </td>
    </tr>
    `

    // Append template to the table.
    $("#expense_items").append(inner)

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


        $(`#expense_item_${Expense_count}`).val(item.inventory.item_name);
        $(`#expense_item_quantity_${Expense_count}`).val(item.quantity).removeAttr('disabled');
        $(`#expense_item_price_${Expense_count}`).val(parseFloat(item.inventory.sale_price).toFixed(2))
        $(`#expense_item_total_${Expense_count}`).val(parseFloat(item.inventory.sale_price * item.quantity).toFixed(2))

    }

    // Create new tagify instance of item selector of newly created row.
    let inventory_item_elm = document.querySelector(`#expense_item_${Expense_count}`);
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
    inventory_item_tagify.on('dropdown:show dropdown:updated', onExpenseItemDropdownShow)
    inventory_item_tagify.on('dropdown:select', onExpenseItemSelectSuggestion)
    inventory_item_tagify.on('input', onExpenseItemInput)
    inventory_item_tagify.on('remove', onExpenseItemRemove)

    // Create new tagify instance of item selector of newly created row.
    let tax_elm = document.querySelector(`#expense_item_tax_${Expense_count}`);
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

    $(`#expense_item_tax_${Expense_count}`).attr('disabled', 'disabled').parents('td').find('.tagify').attr('disabled', 'disabled')

    // Set events of tagify instance.
    tax_tagify.on('dropdown:show dropdown:updated', onTaxExpenseDropdownShow)
    tax_tagify.on('dropdown:select', onTaxExpenseSelectSuggestion)
    tax_tagify.on('input', onTaxExpenseInput)
    tax_tagify.on('remove', onTaxExpenseRemove)

    // Push item to array Expense_items
    let item_entry = {
        "entry_id": Expense_count,
        "tagify": inventory_item_tagify,
        "tax": tax_tagify,
        "value": null,
    }

    Expense_items.push(item_entry);
    console.log(Expense_items);
}

// Removes a Expense Item Entry from the Table.
function removeExpenseItemEntry(entry_id)
{
    for(let i = 0; i < Expense_items.length; i++)
    {
        if(Expense_items[i].entry_id == entry_id)
        {
            console.log("Removing entry " + entry_id);
            Expense_items.splice(i, 1);
            return true;
        }
    }
    return false;
}

// Gets the Expense item entry from the table.
function getExpenseItemEntry(entry_id)
{
    for(let i = 0; i < Expense_items.length; i++)
    {
        if(Expense_items[i].entry_id == entry_id)
        {
            console.log("Found entry.");
            return Expense_items[i];
        }
    }
    return undefined;
}

// Gets the Expense item index from the table.
function getExpenseItemIndex(entry_id)
{
    for(let i = 0; i < Expense_items.length; i++)
    {
        if(Expense_items[i].entry_id == entry_id)
        {
            console.log("Found entry.");
            return i;
        }
    }
    return undefined;
}

/** === Calculation Functions === */
function calculateExpenseSubTotal()
{
    subtotal = 0;
    item_total_prices = document.querySelectorAll(".expense_item_total");
    console.log("Calculate Expense Subtotal:");
    console.log(item_total_prices);

    item_total_prices.forEach(function(item_total_price){
        console.log(item_total_price.value);
        subtotal += item_total_price.value != '' ? parseFloat(item_total_price.value) : 0;
    });

    $(`#expense_sub_total`).val(parseFloat(subtotal).toFixed(2))
}

function calculateExpenseTaxTotal()
{
    tax_total = 0;
    console.log(`Attempt to Calculate Tax Total`);

    tax_percentages = document.querySelectorAll(".expense_item_tax_percentage");
    item_prices = document.querySelectorAll(".expense_item_price")
    item_quantities = document.querySelectorAll(".expense_item_quantity")

    for(i = 0; i < item_prices.length; i++)
    {
        tax_total += (parseFloat(item_prices[i].value) * parseFloat(tax_percentages[i].value) / 100) * parseInt(item_quantities[i].value);
    }

    console.log("Tax Total: " + tax_total);
    $(`.expense_tax_total`).val(parseFloat(tax_total).toFixed(2))

    return tax_total;
}

function calculateExpenseGrandTotal()
{
    tax_total = calculateExpenseTaxTotal();

    grandtotal = 0;
    item_total_prices = document.querySelectorAll(".expense_item_total");
    console.log("Calculate Expense Grandtotal:");
    console.log(item_total_prices);

    item_total_prices.forEach(function(item_total_price){
        console.log(item_total_price.value);
        grandtotal += item_total_price.value != '' ? parseFloat(item_total_price.value) : 0;
    });

    grandtotal += tax_total;

    $(`#expense_grand_total`).val(parseFloat(grandtotal).toFixed(2))
}

/** === Tagify Related Functions for Expense Items === */

function onExpenseItemDropdownShow(e) {
    // var dropdownContentElm = e.detail.Expense_select_item_tagify.DOM.dropdown.content;
}

function onExpenseItemSelectSuggestion(e) {
    id = e.detail.tagify.DOM.originalInput.dataset.id;

    $(`#expense_item_quantity_${id}`).val(1).removeAttr('disabled')
    $(`#expense_item_price_${id}`).val(parseFloat(e.detail.data.sale_price).toFixed(2))
    $(`#expense_item_total_${id}`).val(parseFloat(e.detail.data.sale_price * 1).toFixed(2))
    // Remove the disabled attribute of nearby .tagify element
    $(`#expense_item_tax_${id}`).removeAttr('disabled').parents('td').find('.tagify').removeAttr('disabled');

    if(e.detail.data.tax_id != null) setTaxExpenseWhitelist(e.detail.data, id);

    item_total = e.detail.data.sale_price * e.detail.data.quantity;

    // Recalculate total
    calculateExpenseSubTotal();
    calculateExpenseGrandTotal();
}

function onExpenseItemRemove(e) {
    id = e.detail.tagify.DOM.originalInput.dataset.id;

    //Subtract total when x is clicked in tagify
    $(`#expense_sub_total`).val(parseFloat($(`#expense_sub_total`).val() - $(`#expense_item_total_${id}`).val()).toFixed(2))
    $(`#expense_grand_total`).val(parseFloat($(`#expense_grand_total`).val() - $(`#expense_item_total_${id}`).val()).toFixed(2))
    $(`#expense_item_quantity_${id}`).attr('disabled', 'disabled')
    $(`#expense_item_tax_${id}`).attr('disabled', 'disabled').parents('td').find('.tagify').attr('disabled', 'disabled');

    getExpenseItemEntry(id).tax.removeTag(e.detail.tag.value);

    $(`#expense_item_quantity_${id}`).val("0")
    $(`#expense_item_price_${id}`).val("0.00")
    $(`#expense_item_total_${id}`).val("0.00")

}

function onExpenseItemInput(e) {
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

function onTaxExpenseDropdownShow(e) {
    // var dropdownContentElm = e.detail.Expense_select_item_tagify.DOM.dropdown.content;
}

function onTaxExpenseSelectSuggestion(e) {
    id = e.detail.tagify.DOM.originalInput.dataset.id;
    $(`#expense_item_tax_percentage_${id}`).val(e.detail.data.percentage);

    calculateExpenseGrandTotal();
}

function onTaxExpenseRemove(e) {
    id = e.detail.tagify.DOM.originalInput.dataset.id;
    $(`#expense_item_tax_percentage_${id}`).val(0);

    calculateExpenseGrandTotal();
}

function onTaxExpenseInput(e) {
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

function setTaxExpenseWhitelist(item, id)
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

    tax = getExpenseItemEntry(id).tax
    tax.whitelist = whitelist;
    tax.addTags(whitelist[0].value);

    $(`#expense_item_tax_${id}`).parents('td').find('span').html(whitelist[0].label);
    $(`#expense_item_tax_${id}`).parents('td').find('tag').attr('percentage', whitelist[0].percentage);
    $(`#expense_item_tax_percentage_${id}`).val(whitelist[0].percentage);

    console.log(tax);
}
