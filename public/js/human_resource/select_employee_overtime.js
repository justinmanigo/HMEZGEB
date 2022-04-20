// This array lists down the employee within the overtime.
var overtime_employee = []; 

// This variable counts how many instances of overtime employee are made.
// This ensures that there will be no conflict ids on overtime employee elements.
var overtime_count = 0; 

// Create a overtime employee entry when document is fully loaded or when add entry button is clicked.
$(document).ready(createEmployeeEntry());
$(document).on('click', '.ot_add_employee_entry', function(){
    createEmployeeEntry()
})

// Delete the overtime employee entry when the row's delete button is clicked.
$(document).on('click', '.ot_employee_delete', function (event) {
    removeEmployeeEntry( $(this)[0].dataset.id )
    $(this).parents('tr').remove();

    // If there are no longer employee entries in table, generate a new one.
    if(overtime_employee.length < 1) createEmployeeEntry();
});

// Creates a overtime  Entry on the Table.
function createEmployeeEntry() 
{
    // Increment overtime_count to avoid element conflicts.
    overtime_count++;

    // <tr> template
    let inner = `
        <tr data-id="${overtime_count}" id="ot_employee_entry_${overtime_count}">
        <td>
            <div class="input-group">
                <input data-id="${overtime_count}" id="ot_employee_${overtime_count}" class="ot_employee" name='employee[]'>
                <input type="hidden" name="employee_id[]" value="">
            </div>
        </td>
        <td>
            <input type="time" data-id="${overtime_count}" id="ot_employee_from_${overtime_count}" class="form-control" name="from[]" required>
        </td>
            <td>
            <input type="time" data-id="${overtime_count}" id="ot_employee_to_${overtime_count}" class="form-control" name="to[]" required>
        </td>
        <td>
            <button type="button" data-id="${overtime_count}" id="ot_employee_delete_${overtime_count}" class="btn btn-icon btn-danger ot_employee_delete" data-toggle="tooltip" data-placement="bottom" title="Edit">
                <span class="icon text-white-50">
                    <i class="fas fa-trash"></i>
                </span>
            </button>
            <button type="button" class="btn btn-small btn-icon btn-primary ot_add_employee_entry" data-toggle="tooltip" data-placement="bottom" title="Edit">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
            </button>
        </td>
    </tr>
    `

    // Append template to the table.
    $("#ot_entries").append(inner)

    // Create new tagify instance of employee selector of newly created row.
    let elm = document.querySelector(`#ot_employee_${overtime_count}`);
    let elm_tagify = new Tagify(elm, {
        tagTextProp: 'first_name', // very important since a custom template is used with this property as text
        enforceWhitelist: true,
        mode: "select",
        skipInvalid: false, // do not remporarily add invalid tags
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
    // elm_tagify.on('dropdown:show dropdown:updated', onOvertimeDropdownShow)
    elm_tagify.on('dropdown:select', onOvertimeSelectSuggestion)
    elm_tagify.on('input', onOvertimeInput)
    elm_tagify.on('remove', onOvertimeRemove)

    // Push employee to array overtime_employee
    let employee_entry = {
        "entry_id": overtime_count,
        "tagify": elm_tagify,
        "value": null,
    }

    overtime_employee.push(employee_entry);
    console.log(overtime_employee);
}

// Removes a overtime  Entry from the Table.
function removeEmployeeEntry(entry_id)
{
    
    for(let i = 0; i < overtime_employee.length; i++)
    {
        if(overtime_employee[i].entry_id == entry_id)
        {   
            console.log("Removing entry " + entry_id);
            overtime_employee.splice(i, 1);
            return true;
        }
    }   
    return false;
}

// Gets the overtime employee entry from the table.
function getOvertimeEntry(entry_id)
{
    for(let i = 0; i < overtime_employee.length; i++)
    {
        if(overtime_employee[i].entry_id == entry_id)
        {
            console.log("Found entry.");
            return overtime_employee[i];
        }
    }   
    return undefined;
}

// Gets the overtime employee index from the table.
function getOvertimeIndex(entry_id)
{
    for(let i = 0; i < overtime_employee.length; i++)
    {
        if(overtime_employee[i].entry_id == entry_id)
        {
            console.log("Found entry.");
            return i;
        }
    }   
    return undefined;
}
/** === Tagify Related Functions === */

// function onOvertimeDropdownShow(e) {
//     var dropdownContentElm = e.detail.overtime_select_employee_tagify.DOM.dropdown.content;
// }

function onOvertimeSelectSuggestion(e) {
    id = e.detail.tagify.DOM.originalInput.dataset.id;
    // Check employee entry
    console.log(employee_entry)
}

function onOvertimeRemove(e) {
    id = e.detail.tagify.DOM.originalInput.dataset.id;
 
}

function onOvertimeInput(e) {
    console.log(e.detail);
    console.log(e.detail.tagify.DOM.originalInput.dataset.id)
    
    var entry_id = e.detail.tagify.DOM.originalInput.dataset.id
    var value = e.detail.value;
    var tagify;

    console.log(overtime_employee);
    entry_obj = getOvertimeEntry(entry_id);

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