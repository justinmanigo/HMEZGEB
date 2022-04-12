// This array lists down the employee within the deduction.
var deduction_employee = []; 

// This variable counts how many instances of deduction employee are made.
// This ensures that there will be no conflict ids on deduction employee elements.
var deduction_count = 0; 

// Create a deduction employee entry when document is fully loaded or when add entry button is clicked.
$(document).ready(createEmployeeEntry());
$(document).on('click', '.d_add_employee_entry', function(){
    createEmployeeEntry()
})

// Delete the deduction employee entry when the row's delete button is clicked.
$(document).on('click', '.d_employee_delete', function (event) {
    removeEmployeeEntry( $(this)[0].dataset.id )
    $(this).parents('tr').remove();

    // If there are no longer employee entries in table, generate a new one.
    if(deduction_employee.length < 1) createEmployeeEntry();
});

// Creates a deduction  Entry on the Table.
function createEmployeeEntry() 
{
    // Increment deduction_count to avoid element conflicts.
    deduction_count++;

    // <tr> template
    let inner = `
        <tr data-id="${deduction_count}" id="d_employee_entry_${deduction_count}">
        <td>
            <div class="input-group">
                <input data-id="${deduction_count}" id="d_employee_${deduction_count}" class="d_employee" name='employee[]'>
                <input type="hidden" name="employee_id[]" value="">
            </div>
        </td>
        <td>
            <input type="text" placeholder="0.00" data-id="${deduction_count}" id="d_price_${deduction_count}" class="form-control" name="price[]" required>
        </td>
        <td>
            <button type="button" data-id="${deduction_count}" id="d_employee_delete_${deduction_count}" class="btn btn-icon btn-danger d_employee_delete" data-toggle="tooltip" data-placement="batom" title="Edit">
                <span class="icon text-white-50">
                    <i class="fas fa-trash"></i>
                </span>
            </button>
            <button type="button" class="btn btn-small btn-icon btn-primary d_add_employee_entry" data-toggle="tooltip" data-placement="batom" title="Edit">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
            </button>
        </td>
    </tr>
    `

    // Append template to the table.
    $("#d_entries").append(inner)

    // Create new tagify instance of employee selector of newly created row.
    let elm = document.querySelector(`#d_employee_${deduction_count}`);
    let elm_tagify = new Tagify(elm, {
        tagTextProp: 'first_name', // very important since a custom template is used with this property as text
        enforceWhitelist: true,
        mode: "select",
        skipInvalid: false, // do na remporarily add invalid tags
        dropdown: {
            closeOnSelect: true,
            enabled: 0,
            classname: 'employees-list',
            searchKeys: ['first_name'] // very important to set by which keys to search for suggesttions when typing
        },
        templates: {
            tag: employeeTagTemplate,
            dropdownItem: employeeSuggestionItemTemplate
        },
        whitelist: [],
    })

    // Set events of tagify instance.
    // elm_tagify.on('dropdown:show dropdown:updated', onDeductionDropdownShow)
    elm_tagify.on('dropdown:select', onDeductionSelectSuggestion)
    elm_tagify.on('input', onDeductionInput)
    elm_tagify.on('remove', onDeductionRemove)

    // Push employee to array deduction_employee
    let employee_entry = {
        "entry_id": deduction_count,
        "tagify": elm_tagify,
        "value": null,
    }

    deduction_employee.push(employee_entry);
    console.log(deduction_employee);
}

// Removes a deduction  Entry from the Table.
function removeEmployeeEntry(entry_id)
{
    
    for(let i = 0; i < deduction_employee.length; i++)
    {
        if(deduction_employee[i].entry_id == entry_id)
        {   
            console.log("Removing entry " + entry_id);
            deduction_employee.splice(i, 1);
            return true;
        }
    }   
    return false;
}

// Gets the deduction employee entry from the table.
function getDeductionEntry(entry_id)
{
    for(let i = 0; i < deduction_employee.length; i++)
    {
        if(deduction_employee[i].entry_id == entry_id)
        {
            console.log("Found entry.");
            return deduction_employee[i];
        }
    }   
    return undefined;
}

// Gets the deduction employee index from the table.
function getDeductionIndex(entry_id)
{
    for(let i = 0; i < deduction_employee.length; i++)
    {
        if(deduction_employee[i].entry_id == entry_id)
        {
            console.log("Found entry.");
            return i;
        }
    }   
    return undefined;
}
/** === Tagify Related Functions === */

// function onDeductionDropdownShow(e) {
//     var dropdownContentElm = e.detail.deduction_select_employee_tagify.DOM.dropdown.content;
// }

function onDeductionSelectSuggestion(e) {
    id = e.detail.tagify.DOM.originalInput.dataset.id;
    // Check employee entry
    console.log(employee_entry)
}

function onDeductionRemove(e) {
    id = e.detail.tagify.DOM.originalInput.dataset.id;
 
}

function onDeductionInput(e) {
    console.log(e.detail);
    console.log(e.detail.tagify.DOM.originalInput.dataset.id)
    
    var entry_id = e.detail.tagify.DOM.originalInput.dataset.id
    var value = e.detail.value;
    var tagify;

    console.log(deduction_employee);
    entry_obj = getDeductionEntry(entry_id);

    console.log("Obtained value from array");
    console.log(tagify);
    
    entry_obj.tagify.whitelist = null // reset the whitelist

    // https://developer.mozilla.org/en-US/docs/Web/API/AbortController/abort
    controller && controller.abort()
    controller = new AbortController()

    // show loading animation and hide the suggestions dropdown
    entry_obj.tagify.loading(true).dropdown.hide()

    fetch('/select/search/employee/' + value, {
            signal: controller.signal
        })
        .then(RES => RES.json())
        .then(function (newWhitelist) {
            entry_obj.tagify.whitelist = newWhitelist // update whitelist Array in-place
            entry_obj.tagify.loading(false).dropdown.show(value) // render the suggestions dropdown
        })
}