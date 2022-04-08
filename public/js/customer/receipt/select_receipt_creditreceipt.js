// This array lists down the items within the receipt.
var receipts_to_pay = []; 

// This variable counts how many instances of receipt items are made.
// This ensures that there will be no conflict ids on receipt item elements.
// var receipts_to_pay_count = 0; 

function createReceiptToPayEntry(data)
{
    console.log(data)
    // Increment receipts_to_pay_count to avoid element conflicts.
    // receipts_to_pay_count++;

    amount_due = data.grand_total - data.total_amount_received;

    // <tr> template
    let inner = `
    <tr>
        <td>
            <input type="text" class="form-control-plaintext" id="cr_receipt_reference_id_${data.receipt_reference_id}" name="receipt_reference_id[]" value="${data.receipt_reference_id}" readonly>
        </td>
        <td>
            <input type="date" class="form-control" id="cr_date_due_${data.receipt_reference_id}" name="date_due[]" value="${data.due_date}" disabled>
        </td>
        <td>
            <input type="text" class="form-control-plaintext inputPrice text-right" id="cr_amount_due_${data.receipt_reference_id}" name="amount_due[]" value="${amount_due}" readonly>
        </td>
        <td>
            <input type="text" class="form-control" id="cr_description_${data.receipt_reference_id}" name="description" placeholder="">
        </td>
        <td>
            <input type="number" step="0.01" min="0" class="form-control text-right inputPrice" id="cr_discount_${data.receipt_reference_id}" name="discount[]" placeholder="0.00">
        </td>
        <td>
            <input type="number" step="0.01" min="0" class="form-control text-right inputPrice cr_amount_paid" data-id="${data.receipt_reference_id} " id="cr_amount_paid_${data.receipt_reference_id}" name="amount_paid[]" placeholder="0.00">
        </td>
        <td class="table-item-content">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="cr_is_paid_${data.receipt_reference_id}" name="is_paid[]">
            </div>
        </td>
    </tr>
    `;

    // Append template to the table.
    $("#cr_receipts_to_pay").append(inner)
}

$(document).on('change', '.cr_amount_paid', function(){
    console.log($(this));
    // Check if the amount paid exceeds the supposed amount due?
    var id = $(this)[0].dataset.id;
    var amount_paid = parseFloat($(this)[0].value);
    var amount_due = parseFloat($(`#cr_amount_due_${id}`).val());
    if(amount_paid > amount_due)
        $(`#cr_amount_paid_${id}`).val(amount_due);

    // Compute total amount
    var total_amount = computeTotalAmountReceived();
    $("#cr_total_amount_received").val(parseFloat(total_amount).toFixed(2));
});

function computeTotalAmountReceived()
{
    var items = document.querySelectorAll(".cr_amount_paid");
    var total_amount = 0;

    items.forEach(function(item){
        total_amount += item.value != '' ? parseFloat(item.value) : 0;
    });

    return total_amount;
}