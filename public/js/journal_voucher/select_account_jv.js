// This array lists down the items within the debits sections of the table.
var debit_items = [];
var credit_items = [];

// This array lists down the items within the credits section of the table.
var debit_count = 0;
var credit_count = 0;

// When ready, create entries for debits and credits.
$(document).ready(function(){
    createDebitEntry();
    createCreditEntry();
});

// When add entry button for debit is clicked.
$(document).on('click', '.jv_debit_add', function(){
    createDebitEntry();
});

// When add entry button for credit is clicked.
$(document).on('click', '.jv_credit_add', function(){
    createCreditEntry();
});

// Create Debit
function createDebitEntry()
{
    // Increment count to avoid element conflicts.
    debit_count++;

    // <tr> template
    let inner = `
    <tr>
        <td>
            <input id="jv_debit_account_${debit_count}" data-id="${debit_count}" class="jv_debit_account" name='debit_accounts[]'>
        </td>
        <td>
            <input id="jv_debit_description_${debit_count}" type="text" class="form-control" name="debit_description[]" placeholder="">
        </td>
        <td>
            <input id="jv_debit_amount_${debit_count}" type="number" min="0.00" step="0.01" class="form-control inputPrice text-right" name="debit_amount[]" placeholder="0.00" required>
        </td>
        <td></td>
        <td>
            <button type="button" data-id="${debit_count}" id="jv_debit_delete_${debit_count}" class="btn btn-icon btn-danger jv_debit_delete" data-toggle="tooltip" data-placement="bottom" title="Delete">
                <span class="icon text-white-50">
                    <i class="fas fa-trash"></i>
                </span>
            </button>
            <button type="button" class="btn btn-small btn-icon btn-primary jv_debit_add" data-toggle="tooltip" data-placement="bottom" title="Add">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
            </button>
        </td>
    </tr>
    `;

    // Append template to the table.
    $("#jv_debits").append(inner);

    // Create new tagify instance for the selection of COA
    let elm = document.querySelector(`#jv_debit_account_${debit_count}`);
    let elm_tagify = createTagifyInstance(elm);

    // Push item to array debit_items
    let item = {
        "item_id": debit_count,
        "tagify": elm_tagify,
    }

    debit_items.push(item);
}

// Create Credit
function createCreditEntry()
{
    // Increment count to avoid element conflicts.
    credit_count++;

    // <tr> template
    let inner = `
    <tr>
        <td>
            <input id="jv_credit_account_${credit_count}" data-id="${credit_count}" class="jv_credit_account" name='credit_accounts[]'>
        </td>
        <td>
            <input id="jv_credit_description_${credit_count}" type="text" class="form-control" name="credit_description[]" placeholder="">
        </td>
        <td></td>
        <td>
            <input id="jv_credit_amount_${credit_count}" type="number" min="0.00" step="0.01" class="form-control inputPrice text-right" name="credit_amount[]" placeholder="0.00" required>
        </td>
        <td>
            <button type="button" data-id="${credit_count}" id="jv_credit_delete_${credit_count}" class="btn btn-icon btn-danger jv_credit_delete" data-toggle="tooltip" data-placement="bottom" title="Delete">
                <span class="icon text-white-50">
                    <i class="fas fa-trash"></i>
                </span>
            </button>
            <button type="button" class="btn btn-small btn-icon btn-primary jv_credit_add" data-toggle="tooltip" data-placement="bottom" title="Add">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
            </button>
        </td>
    </tr>
    `;

    // Append template to the table.
    $("#jv_credits").append(inner);

    // Create new tagify instance for the selection of COA
    let elm = document.querySelector(`#jv_credit_account_${credit_count}`);
    let elm_tagify = createTagifyInstance(elm);

    // Push item to array debit_items
    let item = {
        "item_id": debit_count,
        "tagify": elm_tagify,
    }

    credit_items.push(item);
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