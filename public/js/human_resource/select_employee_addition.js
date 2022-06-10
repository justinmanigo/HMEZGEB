// This array lists down the employee within the addition.
var addition_employee = []; 

// This variable counts how many instances of addition employee are made.
// This ensures that there will be no conflict ids on addition employee elements.
var addition_count = 0; 

// Create a addition employee entry when document is fully loaded or when add entry button is clicked.
$(document).ready(createEmployeeEntry());
$(document).on('click', '.a_add_employee_entry', function(){
    createEmployeeEntry()
})

// Delete the addition employee entry when the row's delete button is clicked.
$(document).on('click', '.a_employee_delete', function (event) {
    removeEmployeeEntry( $(this)[0].dataset.id )
    $(this).parents('tr').remove();

    // If there are no longer employee entries in table, generate a new one.
    if(addition_employee.length < 1) createEmployeeEntry();
});

// Creates a addition  Entry on the Table.
function createEmployeeEntry() 
{
    // Increment addition_count to avoid element conflicts.
    addition_count++;

    // <tr> template
    let inner = `
        <tr data-id="${addition_count}" id="a_employee_entry_${addition_count}">
        <td>
            <div class="input-group">
                <input data-id="${addition_count}" id="a_employee_${addition_count}" class="a_employee form-control" name='employee[]' required>
                <input type="hidden" name="employee_id[]" value="">
            </div>
        </td>
        <td>
            <input type="number" min="0" title="Invalid input" placeholder="0.00" data-id="${addition_count}" id="a_price_${addition_count}" class="form-control" name="price[]" required>
        </td>
        <td>
            <button type="button" data-id="${addition_count}" id="a_employee_delete_${addition_count}" class="btn btn-icon btn-danger a_employee_delete" data-toggle="tooltip" data-placement="batom" title="Edit">
                <span class="icon text-white-50">
                    <i class="fas fa-trash"></i>
                </span>
            </button>
            <button type="button" class="btn btn-small btn-icon btn-primary a_add_employee_entry" data-toggle="tooltip" data-placement="batom" title="Edit">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
            </button>
        </td>
    </tr>
    `

    // Append template to the table.
    $("#a_entries").append(inner)

    // Create new tagify instance of employee selector of newly created row.
    let elm = document.querySelector(`#a_employee_${addition_count}`);
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
    // elm_tagify.on('dropdown:show dropdown:updated', onAdditionDropdownShow)
    elm_tagify.on('dropdown:select', onAdditionSelectSuggestion)
    elm_tagify.on('input', onAdditionInput)
    elm_tagify.on('remove', onAdditionRemove)

    // Push employee to array addition_employee
    let employee_entry = {
        "entry_id": addition_count,
        "tagify": elm_tagify,
        "value": null,
    }

    addition_employee.push(employee_entry);
    console.log(addition_employee);
}

// Removes a addition  Entry from the Table.
function removeEmployeeEntry(entry_id)
{
    
    for(let i = 0; i < addition_employee.length; i++)
    {
        if(addition_employee[i].entry_id == entry_id)
        {   
            console.log("Removing entry " + entry_id);
            addition_employee.splice(i, 1);
            return true;
        }
    }   
    return false;
}

// Gets the addition employee entry from the table.
function getAdditionEntry(entry_id)
{
    for(let i = 0; i < addition_employee.length; i++)
    {
        if(addition_employee[i].entry_id == entry_id)
        {
            console.log("Found entry.");
            return addition_employee[i];
        }
    }   
    return undefined;
}

// Gets the addition employee index from the table.
function getAdditionIndex(entry_id)
{
    for(let i = 0; i < addition_employee.length; i++)
    {
        if(addition_employee[i].entry_id == entry_id)
        {
            console.log("Found entry.");
            return i;
        }
    }   
    return undefined;
}
/** === Tagify Related Functions === */

// function onAdditionDropdownShow(e) {
//     var dropdownContentElm = e.detail.addition_select_employee_tagify.DOM.dropdown.content;
// }

function onAdditionSelectSuggestion(e) {
    id = e.detail.tagify.DOM.originalInput.dataset.id;
    // Check employee entry
    console.log(employee_entry)
}

function onAdditionRemove(e) {
    id = e.detail.tagify.DOM.originalInput.dataset.id;
 
}

function onAdditionInput(e) {
    console.log(e.detail);
    console.log(e.detail.tagify.DOM.originalInput.dataset.id)
    
    var entry_id = e.detail.tagify.DOM.originalInput.dataset.id
    var value = e.detail.value;
    var tagify;

    console.log(addition_employee);
    entry_obj = getAdditionEntry(entry_id);

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