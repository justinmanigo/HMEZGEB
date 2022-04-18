// This array lists down the rule within the payroll.
var payroll_rule = [];

// This variable counts how many instances of payroll rule are made.
// This ensures that there will be no conflict ids on payroll rule elements.
var payroll_count = 0;

// Create a payroll rule entry when document is fully loaded or when add entry button is clicked.
$(document).ready(createRuleEntry());
$(document).on("click", ".pr_add_rule_entry", function () {
    createRuleEntry();
});

// Delete the payroll rule entry when the row's delete button is clicked.
$(document).on("click", ".pr_rule_delete", function (event) {
    removeRuleEntry($(this)[0].dataset.id);
    $(this).parents("tr").remove();

    // If there are no longer rule entries in table, generate a new one.
    if (payroll_rule.length < 1) createRuleEntry();
});

// Delete the payroll rule entry when the row's delete button is clicked.
$(document).on("click", "#ot_default", function (event) {
    defaultOverTimeRules();
});

$(document).on("click", "#it_default", function (event) {
    defaultIncomeTaxRules();
});

// Returns government rules for income tax values
function defaultIncomeTaxRules() {

    // Reset variables;
    payroll_count = 6;
    entry_id=0;
    payroll_rule = [];
    
    // Values for the government rules
    let inner = `
         <tr data-id="1" id="pr_rule_entry_1">
         <td>
            
             IF Taxable Income >
       
         </td>
         <td>
             <input type="number" data-id="1" id="pr_rule_income_1" class="form-control" name="income[]" required value="10900">
         </td>
            <td>
            Taxable Income
        </td>
             <td>
             <input type="number" data-id="1" id="pr_rule_rate_1" class="form-control" name="rate[]" required value="35">
         </td>
         <td>
         <input type="number" data-id="1" id="pr_rule_deduction_1" class="form-control" name="deduction[]" required value="1500">
     </td>
         <td>
             <button type="button" data-id="1" id="pr_rule_delete_1" class="btn btn-icon btn-danger pr_rule_delete" data-toggle="tooltip" data-placement="bottom" title="Edit">
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
     
     <tr data-id="2" id="pr_rule_entry_2">
         <td>
            
             IF Taxable Income >
       
         </td>
         <td>
             <input type="number" data-id="2" id="pr_rule_income_2" class="form-control" name="income[]" required value="7800">
         </td>
         <td>
            Taxable Income
         </td>
             <td>
             <input type="number" data-id="2" id="pr_rule_rate_2" class="form-control" name="rate[]" required value="30">
         </td>
         <td>
         <input type="number" data-id="2" id="pr_rule_deduction_2" class="form-control" name="deduction[]" required value="955">
     </td>
         <td>
             <button type="button" data-id="2" id="pr_rule_delete_2" class="btn btn-icon btn-danger pr_rule_delete" data-toggle="tooltip" data-placement="bottom" title="Edit">
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
     
     <tr data-id="3" id="pr_rule_entry_3">
         <td>
            
             IF Taxable Income >
       
         </td>
         <td>
             <input type="text" data-id="3" id="pr_rule_income_3" class="form-control" name="income[]" required value="5250">
         </td>
         <td>
            Taxable Income
         </td>
             <td>
             <input type="text" data-id="3" id="pr_rule_rate_3" class="form-control" name="rate[]" required value="25">
         </td>
         <td>
         <input type="text" data-id="3" id="pr_rule_deduction_3" class="form-control" name="deduction[]" required value="565">
     </td>
         <td>
             <button type="button" data-id="3" id="pr_rule_delete_3" class="btn btn-icon btn-danger pr_rule_delete" data-toggle="tooltip" data-placement="bottom" title="Edit">
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

     <tr data-id="4" id="pr_rule_entry_4">
         <td>
            
             IF Taxable Income >
       
         </td>
         <td>
             <input type="text" data-id="4" id="pr_rule_income_4" class="form-control" name="income[]" required value="3200">
         </td>
         <td>
            Taxable Income
         </td>
             <td>
             <input type="text" data-id="4" id="pr_rule_rate_4" class="form-control" name="rate[]" required value="20">
         </td>
         <td>
         <input type="text" data-id="4" id="pr_rule_deduction_4" class="form-control" name="deduction[]" required value="302.5">
     </td>
         <td>
             <button type="button" data-id="4" id="pr_rule_delete_4" class="btn btn-icon btn-danger pr_rule_delete" data-toggle="tooltip" data-placement="bottom" title="Edit">
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

     <tr data-id="5" id="pr_rule_entry_5">
         <td>
            
             IF Taxable Income >
       
         </td>
         <td>
             <input type="text" data-id="5" id="pr_rule_income_5" class="form-control" name="income[]" required value="1650">
         </td>
         <td>
            Taxable Income
         </td>
             <td>
             <input type="text" data-id="5" id="pr_rule_rate_5" class="form-control" name="rate[]" required value="15">
         </td>
         <td>
         <input type="text" data-id="5" id="pr_rule_deduction_5" class="form-control" name="deduction[]" required value="142.5">
     </td>
         <td>
             <button type="button" data-id="5" id="pr_rule_delete_5" class="btn btn-icon btn-danger pr_rule_delete" data-toggle="tooltip" data-placement="bottom" title="Edit">
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

     <tr data-id="6" id="pr_rule_entry_6">
         <td>
            
             IF Taxable Income >
       
         </td>
         <td>
             <input type="text" data-id="6" id="pr_rule_income_6" class="form-control" name="income[]" required value="600">
         </td>
         <td>
            Taxable Income
         </td>
             <td>
             <input type="text" data-id="6" id="pr_rule_rate_6" class="form-control" name="rate[]" required value="10">
         </td>
         <td>
         <input type="text" data-id="6" id="pr_rule_deduction_6" class="form-control" name="deduction[]" required value="60">
     </td>
         <td>
             <button type="button" data-id="6" id="pr_rule_delete_6" class="btn btn-icon btn-danger pr_rule_delete" data-toggle="tooltip" data-placement="bottom" title="Edit">
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

    // Loop through the default values
    for(var j = 1; j < 7; j++){
        let rule_entry = {
            entry_id: j,
            value: null,
        };
        payroll_rule.push(rule_entry);
        console.log(rule_entry);
    }
    // Append template to the table.
    $("#pr_entries").empty().append(inner);
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
function createRuleEntry() {
    // Increment payroll_count to avoid element conflicts.
    payroll_count++;

    // <tr> template
    let inner = `
        <tr data-id="${payroll_count}" id="pr_rule_entry_${payroll_count}">
        <td>
           
            IF Taxable Income >
      
        </td>
        <td>
            <input type="number" data-id="${payroll_count}" id="pr_rule_income_${payroll_count}" class="form-control" name="income[]" required>
        </td>
            <td>
            Taxable Income 
        </td>
            <td>
            <input type="number" data-id="${payroll_count}" id="pr_rule_rate_${payroll_count}" class="form-control" name="rate[]" required>
        </td>
        <td>
        <input type="number" data-id="${payroll_count}" id="pr_rule_deduction_${payroll_count}" class="form-control" name="deduction[]" required>
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

    let rule_entry = {
        entry_id: payroll_count,
        value: null,
    };

    payroll_rule.push(rule_entry);
    console.log(rule_entry);
    // Append template to the table.
    $("#pr_entries").append(inner);
}

// Removes a payroll  Entry from the Table.
function removeRuleEntry(entry_id) {
    for (let i = 0; i < payroll_rule.length; i++) {
        if (payroll_rule[i].entry_id == entry_id) {
            console.log("Removing entry " + entry_id);
            payroll_rule.splice(i, 1);
            return true;
        }
    }
    return false;
}

// Gets the payroll rule entry from the table.
function getOvertimeEntry(entry_id) {
    for (let i = 0; i < payroll_rule.length; i++) {
        if (payroll_rule[i].entry_id == entry_id) {
            console.log("Found entry.");
            return payroll_rule[i];
        }
    }
    return undefined;
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
