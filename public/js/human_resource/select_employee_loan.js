// This array lists down the employee within the loan.
var loan_employee = [];

// This variable counts how many instances of loan employee are made.
// This ensures that there will be no conflict ids on loan employee elements.
var loan_count = 0;

// Create a loan employee entry when document is fully loaded or when add entry button is clicked.
$(document).ready(createEmployeeEntry());
$(document).on("click", ".l_add_employee_entry", function () {
    createEmployeeEntry();
});

// Delete the loan employee entry when the row's delete button is clicked.
$(document).on("click", ".l_employee_delete", function (event) {
    removeEmployeeEntry($(this)[0].dataset.id);
    $(this).parents("tr").remove();

    // If there are no longer employee entries in table, generate a new one.
    if (loan_employee.length < 1) createEmployeeEntry();
});

// Creates a loan  Entry on the Table.
function createEmployeeEntry() {
    // Increment loan_count to avoid element conflicts.
    loan_count++;

    // <tr> template
    let inner = `
        <tr data-id="${loan_count}" id="l_employee_entry_${loan_count}">
        <td>
            <div class="input-group">
                <input data-id="${loan_count}" id="l_employee_${loan_count}" class="l_employee" name='employee[]'>
                <input type="hidden" name="employee_id[]" value="">
            </div>
        </td>
        <td>
            <input type="text" data-id="${loan_count}" id="l_loan_${loan_count}" class="form-control" name="loan[]" required>
        </td>
        <td>
            <select data-id="${loan_count}" id="l_paid_in_${loan_count}" class="form-control" name="paid_in[]" required>
                <option value="">-Select Paid In-</option>
                <option value="1 Month">1 Month</option>
                <option value="3 Months">3 Months</option>
                <option value="6 Months">6 Months</option>
                <option value="9 Months">9 Months</option>
                <option value="12 Months">12 Months</option>
                <option value="18 Months">18 Months</option>
                <option value="24 Months">24 Months</option>
                <option value="30 Months">30 Months</option>
                <option value="36 Months">36 Months</option>
            </select>
        </td>
        <td>
            <button type="button" data-id="${loan_count}" id="l_employee_delete_${loan_count}" class="btn btn-icon btn-danger l_employee_delete" data-toggle="tooltip" data-placement="bottom" title="Edit">
                <span class="icon text-white-50">
                    <i class="fas fa-trash"></i>
                </span>
            </button>
            <button type="button" class="btn btn-small btn-icon btn-primary l_add_employee_entry" data-toggle="tooltip" data-placement="bottom" title="Edit">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
            </button>
        </td>
    </tr>
    `;

    // Append template to the table.
    $("#l_entries").append(inner);

    // Create new tagify instance of employee selector of newly created row.
    let elm = document.querySelector(`#l_employee_${loan_count}`);
    let elm_tagify = new Tagify(elm, {
        tagTextProp: "first_name", // very important since a custom template is used with this property as text
        enforceWhitelist: true,
        mode: "select",
        skipInvalid: false, // do not remporarily add invalid tags
        dropdown: {
            closeOnSelect: true,
            enabled: 0,
            classname: "employees-list",
            searchKeys: ["first_name"], // very important to set by which keys to search for suggesttions when typing
        },
        templates: {
            tag: employeeTagTemplate,
            dropdownItem: employeeSuggestionItemTemplate,
        },
        whitelist: [],
    });

    // Set events of tagify instance.
    // elm_tagify.on('dropdown:show dropdown:updated', onLoanDropdownShow)
    elm_tagify.on("dropdown:select", onLoanSelectSuggestion);
    elm_tagify.on("input", onLoanInput);
    elm_tagify.on("remove", onLoanRemove);

    // Push employee to array loan_employee
    let employee_entry = {
        entry_id: loan_count,
        tagify: elm_tagify,
        value: null,
    };

    loan_employee.push(employee_entry);
    console.log(loan_employee);
}

// Removes a loan  Entry from the Table.
function removeEmployeeEntry(entry_id) {
    for (let i = 0; i < loan_employee.length; i++) {
        if (loan_employee[i].entry_id == entry_id) {
            console.log("Removing entry " + entry_id);
            loan_employee.splice(i, 1);
            return true;
        }
    }
    return false;
}

// Gets the loan employee entry from the table.
function getLoanEntry(entry_id) {
    for (let i = 0; i < loan_employee.length; i++) {
        if (loan_employee[i].entry_id == entry_id) {
            console.log("Found entry.");
            return loan_employee[i];
        }
    }
    return undefined;
}

// Gets the loan employee index from the table.
function getLoanIndex(entry_id) {
    for (let i = 0; i < loan_employee.length; i++) {
        if (loan_employee[i].entry_id == entry_id) {
            console.log("Found entry.");
            return i;
        }
    }
    return undefined;
}
/** === Tagify Related Functions === */

// function onLoanDropdownShow(e) {
//     var dropdownContentElm = e.detail.loan_select_employee_tagify.DOM.dropdown.content;
// }

function onLoanSelectSuggestion(e) {
    id = e.detail.tagify.DOM.originalInput.dataset.id;
    // Check employee entry
    console.log(employee_entry);
}

function onLoanRemove(e) {
    id = e.detail.tagify.DOM.originalInput.dataset.id;
}

function onLoanInput(e) {
    console.log(e.detail);
    console.log(e.detail.tagify.DOM.originalInput.dataset.id);

    var entry_id = e.detail.tagify.DOM.originalInput.dataset.id;
    var value = e.detail.value;
    var tagify;

    console.log(loan_employee);
    entry_obj = getLoanEntry(entry_id);

    console.log("Obtained value from array");
    console.log(tagify);

    entry_obj.tagify.whitelist = null; // reset the whitelist

    // https://developer.mozilla.org/en-US/docs/Web/API/AbortController/abort
    controller && controller.abort();
    controller = new AbortController();

    // show loading animation and hide the suggestions dropdown
    entry_obj.tagify.loading(true).dropdown.hide();

    fetch("/select/search/employee/" + value, {
        signal: controller.signal,
    })
        .then((RES) => RES.json())
        .then(function (newWhitelist) {
            entry_obj.tagify.whitelist = newWhitelist; // update whitelist Array in-place
            entry_obj.tagify.loading(false).dropdown.show(value); // render the suggestions dropdown
        });
}
