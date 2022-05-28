// This array lists down the items within the debits sections of the table.
var debit_items = [];
var credit_items = [];

// This array lists down the items within the credits section of the table.
var debit_count = 0;
var credit_count = 0;

// When ready, create entries for debits and credits.
$(document).ready(function(){
    createEntry('debit');
    createEntry('credit');
});

// When add entry button for debit is clicked.
$(document).on('click', '.jv_debit_add', function(){
    createEntry('debit');
});

// When add entry button for credit is clicked.
$(document).on('click', '.jv_credit_add', function(){
    createEntry('credit');
});

// When delete entry button for debit is clicked.
$(document).on('click', '.jv_debit_delete', function(e){
    removeEntry('debit', $(this)[0].dataset.id)
    $(this).parents('tr').remove();

    // If there are no longer entries in table, generate a new one.
    if(debit_items.length < 1) createEntry('debit');
});

// When delete entry button for credit is clicked.
$(document).on('click', '.jv_credit_delete', function(e){
    removeEntry('credit', $(this)[0].dataset.id)
    $(this).parents('tr').remove();

    // If there are no longer entries in table, generate a new one.
    if(credit_items.length < 1) createEntry('credit');
});

// Create Entry
function createEntry(type)
{
    // Increment count to avoid element conflicts.
    if(type == 'debit')
    {
        debit_count++;
        count = debit_count;
    }
    else if(type == 'credit') 
    {
        credit_count++;
        count = credit_count;
    }

    // <tr> template
    let inner = `
    <tr>
        <td>
            <input id="jv_${type}_account_${count}" data-id="${count}" data-type="${type}" class="jv_${type}_account" name='${type}_accounts[]'>
            <p class="text-danger error-message error-message-${type}_accounts" style="display:none"></p>
        </td>
        <td>
            <input id="jv_${type}_description_${count}" type="text" class="form-control" name="${type}_description[]" placeholder="" disabled>
            <p class="text-danger error-message error-message-${type}_description" style="display:none"></p>
        </td>
    `

    if(type == 'debit')
    {
        inner += `
        <td>
            <input id="jv_${type}_amount_${count}" type="number" min="0.00" step="0.01" data-type="${type}" class="form-control inputPrice text-right jv_amount jv_debit" name="${type}_amount[]" placeholder="0.00" required disabled>
            <p class="text-danger error-message error-message-${type}_amount" style="display:none"></p>
        </td>
        <td></td>
        `;
    }
    else if(type == 'credit')
    {
        inner += `
        <td></td>
        <td>
            <input id="jv_${type}_amount_${count}" type="number" min="0.00" step="0.01" data-type="${type}" class="form-control inputPrice text-right jv_amount jv_credit" name="${type}_amount[]" placeholder="0.00" required disabled>
            <p class="text-danger error-message error-message-${type}_amount" style="display:none"></p>
        </td>
        `;
    }

    inner += `
        <td>
            <button type="button" data-id="${count}" id="jv_${type}_delete_${count}" class="btn btn-icon btn-danger jv_${type}_delete" data-toggle="tooltip" data-placement="bottom" title="Delete">
                <span class="icon text-white-50">
                    <i class="fas fa-trash"></i>
                </span>
            </button>
            <button type="button" class="btn btn-small btn-icon btn-primary jv_${type}_add" data-toggle="tooltip" data-placement="bottom" title="Add">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
            </button>
        </td>
    </tr>
    `;

    // Append template to the table.
    if(type == 'debit') $("#jv_debits").append(inner);
    else if(type == 'credit') $("#jv_credits").append(inner);

    // Create new tagify instance for the selection of COA
    let elm = document.querySelector(`#jv_${type}_account_${count}`);
    let elm_tagify = createTagifyInstance(elm);

    // Push item to array debit_items
    let item = {
        "item_id": count,
        "tagify": elm_tagify,
    }

    if(type == 'debit') debit_items.push(item);
    else if(type == 'credit') credit_items.push(item);
}

// Remove entry
function removeEntry(type, id)
{
    var items;
    if(type == 'debit') items = debit_items;
    else if(type == 'credit') items = credit_items;

    for(let i = 0; i < items.length; i++)
    {
        if(id == items[i].item_id)
        {
            if(type == 'debit') debit_items.splice(i, 1);
            else if(type == 'credit') credit_items.splice(i, 1);
            return true;
        }
    }
    return false;
}

// Get entry
function getEntryIndex(type, id)
{
    var items;
    if(type == 'debit') items = debit_items;
    else if(type == 'credit') items = credit_items;

    for(let i = 0; i < items.length; i++)
        if(id == items[i].item_id)
            return i;
    return undefined;
}

function createTagifyInstance(elm)
{
    let elm_tagify = new Tagify(elm, {
        tagTextProp: 'category', // very important since a custom template is used with this property as text
        enforceWhitelist: true,
        mode: "select",
        skipInvalid: false, // do not remporarily add invalid tags
        dropdown: {
            closeOnSelect: true,
            enabled: 0,
            classname: 'coa-list',
            searchKeys: ['category', 'chart_of_account_no', 'type'] // very important to set by which keys to search for suggesttions when typing
        },
        templates: {
            tag: chartOfAccountTagTemplate,
            dropdownItem: chartOfAccountSuggestionItemTemplate
        },
        whitelist: [],
    })

    // Set events of tagify instance.
    elm_tagify.on('dropdown:show dropdown:updated', onJournalVoucherAccountDropdownShow)
    elm_tagify.on('dropdown:select', onJournalVoucherAccountSelectSuggestion)
    elm_tagify.on('input', onJournalVoucherAccountInput)
    elm_tagify.on('remove', onJournalVoucherAccountRemove)

    return elm_tagify;
}

/** ===== Tagify Related Functions ===== **/

function onJournalVoucherAccountDropdownShow(e) {
    console.log("onJournalVoucherAccountDropdownShow")
    e.detail.tagify.loading(false);
    var dropdownContentElm = e.detail.tagify.DOM.dropdown.content;
}

function onJournalVoucherAccountSelectSuggestion(e) {
    console.log("select suggestion");
    var inputId = e.detail.tagify.DOM.originalInput.dataset.id;
    var inputType = e.detail.tagify.DOM.originalInput.dataset.type;

    $(`#jv_${inputType}_description_${inputId}`).removeAttr('disabled');
    $(`#jv_${inputType}_amount_${inputId}`).removeAttr('disabled');
}

function onJournalVoucherAccountRemove(e) {
    console.log("remove suggestion");
    var inputId = e.detail.tagify.DOM.originalInput.dataset.id;
    var inputType = e.detail.tagify.DOM.originalInput.dataset.type;

    $(`#jv_${inputType}_description_${inputId}`).attr('disabled', true);
    $(`#jv_${inputType}_amount_${inputId}`).attr('disabled', true);
}

function onJournalVoucherAccountInput(e) {  
    var value = e.detail.value;
    var tagify = e.detail.tagify;
    
    tagify.whitelist = null // reset the whitelist

    // https://developer.mozilla.org/en-US/docs/Web/API/AbortController/abort
    controller && controller.abort()
    controller = new AbortController()

    // show loading animation and hide the suggestions dropdown
    tagify.loading(true).dropdown.hide()

    fetch('/ajax/settings/coa/search/' + value, {
            signal: controller.signal
        })
        .then(RES => RES.json())
        .then(function (newWhitelist) {
            tagify.whitelist = newWhitelist // update whitelist Array in-place
            tagify.loading(false).dropdown.show(value) // render the suggestions dropdown
        })
}

/** JV Computation */

// When delete entry button for credit is clicked.
$(document).on('change', '.jv_amount', function(e){
    // Get type & value
    var type = $(this)[0].dataset.type;
    var value = $(this)[0].value;

    // Compute JV's Total Amount
    updateAndGetJVTotalAmount(type);
    
    setTimeout(function() {
        dc_match = checkDebitCreditMatch();
        accounts_filled = checkAccountsFilled();
        toggleJVSaveButton(dc_match, accounts_filled);
    }, 100);

    // // removeEntry('credit', $(this)[0].dataset.id)
    // $(this).parents('tr').remove();

    // // If there are no longer entries in table, generate a new one.
    // if(credit_items.length < 1) createEntry('credit');
});

function updateAndGetJVTotalAmount(type)
{
    var amounts, total_amount = 0;
    if(type == 'debit') amounts = document.querySelectorAll(".jv_debit");
    else if(type == 'credit') amounts = document.querySelectorAll(".jv_credit");

    amounts.forEach(function(amount){
        total_amount += amount.value != '' ? parseFloat(amount.value) : 0;
        console.log(amount.value);
    });
    console.log(`Total Amount of ${type}: ${total_amount}`);

    $(`#jv_${type}_total`).html(parseFloat(total_amount).toFixed(2));

    return total_amount;
}