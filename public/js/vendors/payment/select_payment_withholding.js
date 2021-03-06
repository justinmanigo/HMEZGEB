// This array lists down the items within the payment.
var withholdings_to_pay = []; 

// This variable counts how many instances of payment items are made.
// This ensures that there will be no conflict ids on payment item elements.
// var withholdings_to_pay_count = 0; 

function createWithholdingToPayEntry(data)
{
    console.log(data)
    // Increment withholdings_to_pay_count to avoid element conflicts.
    // withholdings_to_pay_count++;
    
    amount_due = data.grand_total - data.amount_received;

    // <tr> template
    let inner = `
    <tr>
        <td>
            <input type="text" class="form-control-plaintext" id="w_payment_reference_id_${data.payment_reference_id}" name="payment_reference_id[]" value="${data.payment_reference_id}" readonly>
        </td>
        <td>
            <input type="date" class="form-control" id="w_date_due_${data.payment_reference_id}" name="date_due[]" value="${data.due_date}" disabled>
        </td>
        <td>
        <input type="number" step="0.01" min="0" class="form-control-plaintext text-right inputPrice w_amount_paid" data-id="${data.payment_reference_id} " id="w_amount_paid_${data.payment_reference_id}" name="amount_paid[]" placeholder="0.00" value="${data.withholding}" readonly>
    </td>
        <td class="table-item-content">
            <div class="form-check">
                <input type="checkbox" data-id="${data.payment_reference_id}" class="form-check-input" id="w_is_paid_${data.payment_reference_id}" name="is_paid[]" value="${data.payment_reference_id}">
            </div>
        </td>
    </tr>
    `;
    
    // Append template to the table.
    $("#w_withholdings_to_pay").append(inner)
    computeTotalAmountReceivedWithholding();
}

// compute all w_amount_paid and print in w_total_amount_received
function computeTotalAmountReceivedWithholding()
{
    let total = 0;
    $(".w_amount_paid").each(function() {
        if ($(this).val() != "") {
            total += parseFloat($(this).val());
        }
    });
    $("#w_total_amount_received").val(total.toFixed(2));
}
