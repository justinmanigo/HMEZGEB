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
            <input id="jv_${type}_account_${count}" data-id="${count}" class="jv_${type}_account" name='${type}_accounts[]'>
        </td>
        <td>
            <input id="jv_${type}_description_${count}" type="text" class="form-control" name="${type}_description[]" placeholder="">
        </td>
    `

    if(type == 'debit')
    {
        inner += `
        <td>
            <input id="jv_${type}_amount_${count}" type="number" min="0.00" step="0.01" class="form-control inputPrice text-right" name="${type}_amount[]" placeholder="0.00" required>
        </td>
        <td></td>
        `;
    }
    else if(type == 'credit')
    {
        inner += `
        <td></td>
        <td>
            <input id="jv_${type}_amount_${count}" type="number" min="0.00" step="0.01" class="form-control inputPrice text-right" name="${type}_amount[]" placeholder="0.00" required>
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

function createTagifyInstance(elm)
{
    let elm_tagify = new Tagify(elm, {
        tagTextProp: 'name', // very important since a custom template is used with this property as text
        enforceWhitelist: true,
        mode: "select",
        skipInvalid: false, // do not remporarily add invalid tags
        dropdown: {
            closeOnSelect: true,
            enabled: 0,
            classname: 'coa-list',
            searchKeys: ['name', 'chart_of_account_no'] // very important to set by which keys to search for suggesttions when typing
        },
        templates: {
            tag: chartOfAccountTagTemplate,
            dropdownItem: chartOfAccountSuggestionItemTemplate
        },
        whitelist: [],
    })

    // Set events of tagify instance.
    // elm_tagify.on('dropdown:show dropdown:updated', onJournalVoucherAccountDropdownShow)
    // elm_tagify.on('dropdown:select', onJournalVoucherAccountSelectSuggestion)
    // elm_tagify.on('input', onJournalVoucherAccountInput)
    // elm_tagify.on('remove', onJournalVoucherAccountRemove)

    return elm_tagify;
}