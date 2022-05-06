// This variable counts how many instances of payroll rule are made.
// This ensures that there will be no conflict ids on payroll rule elements.
var payroll_count = 0;

// Create a payroll rule entry when document is fully loaded or when add entry button is clicked.
$(document).ready(function(){
    // Update payroll count
    currentEntries = document.querySelectorAll('#pr_entries tr');
    payroll_count = currentEntries.length;
});

$(document).on("click", ".pr_add_rule_entry", function () {
    createRuleEntry();
});

// Delete the payroll rule entry when the row's delete button is clicked.
$(document).on("click", ".pr_rule_delete", function (event) {
    $(this).parents("tr").remove();

    // If there are no longer rule entries in table, generate a new one.
    if (document.querySelectorAll('#pr_entries tr').length < 1) createRuleEntry();
});

// Delete the payroll rule entry when the row's delete button is clicked.
$(document).on("click", "#ot_default", function (event) {
    defaultOverTimeRules();
});

$(document).on("click", "#it_default", function (event) {
    defaultIncomeTaxRules();
});

// Returns government rules for income tax values
function defaultIncomeTaxRules() 
{
    let payroll_rules = [
        {
            'income': 10900,
            'rate': 35,
            'deduction': 1500,
        },
        {
            'income': 7800,
            'rate': 30,
            'deduction': 955,
        },
        {
            'income': 5250,
            'rate': 25,
            'deduction': 565,
        },
        {
            'income': 3200,
            'rate': 20,
            'deduction': 302.5,
        },
        {
            'income': 1650,
            'rate': 15,
            'deduction': 142.5,
        },
        {
            'income': 600,
            'rate': 10,
            'deduction': 60,
        },
    ];

    $("#pr_entries").empty();

    payroll_rules.forEach(function(item){
        createRuleEntry(item);
    });
}

//Returns government rules for overtime
function defaultOverTimeRules() {
    $("#working_days").val("26");
    $("#working_hours").val("8");
    $("#day_rate").val("1.25");
    $("#night_rate").val("1.50");
    $("#holiday_weekend_rate").val("2.00");
}

// Creates a payroll  Entry on the Table.
function createRuleEntry(item = null) {
    // Increment payroll_count to avoid element conflicts.
    payroll_count++;

    // <tr> template
    let inner = `
        <tr data-id="${payroll_count}" id="pr_rule_entry_${payroll_count}">
        <td>
            <div class="d-flex justify-content-between">
                <p>IF Taxable Income</p> >
            </div>
        </td>
        <td>
            <div class="d-flex justify-content-between">
                <input type="text" data-id="${payroll_count}" id="pr_rule_income_${payroll_count}" class="form-control" name="income[]" required>
            </div>
        </td>
        <td>
            <div class="d-flex justify-content-between">
                <p>Taxable Income</p> * 
            </div>
        </td>
        <td>
            <div class="d-flex justify-content-between">
                    <input type="text" data-id="${payroll_count}" id="pr_rule_rate_${payroll_count}" class="form-control" name="rate[]" style="width:90%"  required>
            -
            </div>
        </td>
        <td>
        <input type="text" data-id="${payroll_count}" id="pr_rule_deduction_${payroll_count}" class="form-control" name="deduction[]" required>
    </td>
        <td>
            <button type="button" data-id="${payroll_count}" id="pr_rule_delete_${payroll_count}" class="btn btn-icon btn-danger pr_rule_delete" data-toggle="tooltip" data-placement="bottom" title="Edit">
                <span class="icon text-white-50">
                    <i class="fas fa-trash"></i>
                </span>
            </button>
            <button type="button" class="btn btn-small btn-icon btn-primary pr_add_rule_entry" data-toggle="tooltip" data-placement="bottom" title="Edit">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
            </button>
        </td>
    </tr>
    `;

    $("#pr_entries").append(inner);

    if(item !== undefined) {
        $(`#pr_rule_income_${payroll_count}`).val(item.income);
        $(`#pr_rule_rate_${payroll_count}`).val(item.rate);
        $(`#pr_rule_deduction_${payroll_count}`).val(item.deduction);
    }
}

// Gets the payroll rule index from the table.
function getOvertimeIndex(entry_id) {
    for (let i = 0; i < payroll_rule.length; i++) {
        if (payroll_rule[i].entry_id == entry_id) {
            console.log("Found entry.");
            return i;
        }
    }
    return undefined;
}
