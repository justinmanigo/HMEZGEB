// Called from `hoverable.js`
function bill_payments_table_actions(id, type, action)
{
    // refer functions to receipt index
    if(action == "void") {
        console.log("void");
        voidModal(id, type);
    }
    else if(action == "reactivate") {
        console.log("void");
        reactivateModal(id, type);
    }
    else if(action == "mail") {
        console.log("mail");
        mailModal(id, type);
    }
    else if(action == "print") {
        console.log("print");
        printModal(id, type);
    }
}

/** ACTIONS */

// Get id of transaction to mail confirmation modal
function mailModal(id, type){
    // set attribute href of btn-send-mail
    if(type=="receipt")
    $('#btn-send-mail').attr('data-href', `/receipt/mail/${id}`);
    if(type=="advanceRevenue")
    $('#btn-send-mail').attr('data-href', `/receipt/advance-revenue/mail/${id}`);
    if(type=="creditReceipt")
    $('#btn-send-mail').attr('data-href', `/credit-receipt/mail/${id}`);
    if(type=="proforma")
    $('#btn-send-mail').attr('data-href', `/proforma/mail/${id}`);

    $('#btn-send-mail').attr('data-id', id).attr('href', '#').attr('data-type', type);
}

// Get id of transaction to print confirmation modal
function printModal(id, type){
    // set attribute href of print-receipt
    if(type=="receipt")
    $('#print-receipt').attr('href', `/receipt/print/${id}`);
    if(type=="advanceRevenue")
    $('#print-receipt').attr('href', `/receipt/advance-revenue/print/${id}`);
    if(type=="creditReceipt")
    $('#print-receipt').attr('href', `/credit-receipt/print/${id}`);
    if(type=="proforma")
    $('#print-receipt').attr('href', `/proforma/print/${id}`);
}

// Void record

function voidModal(id, type) {
    if(type=="receipt")
    $('#void-receipt').attr('data-href', `/receipt/void/${id}`);
    if(type=="advanceRevenue")
    $('#void-receipt').attr('data-href', `/receipt/advance-revenue/void/${id}`);
    if(type=="creditReceipt")
    $('#void-receipt').attr('data-href', `/credit-receipt/void/${id}`);
    if(type=="proforma")
    $('#void-receipt').attr('data-href', `/proforma/void/${id}`);
    if(type=="sale")
    $('#void-receipt').attr('data-href', `/customers/receipts/sales/void/${id}`);

    $('#void-receipt').attr('data-id', id).attr('href', '#').attr('data-type', type);
}

function reactivateModal(id, type)
{
    if(type=="receipt")
    $('#reactivate-receipt').attr('data-href', `/receipt/reactivate/${id}`);
    if(type=="advanceRevenue")
    $('#reactivate-receipt').attr('data-href', `/receipt/advance-revenue/reactivate/${id}`);
    if(type=="creditReceipt")
    $('#reactivate-receipt').attr('data-href', `/credit-receipt/reactivate/${id}`);
    if(type=="proforma")
    $('#reactivate-receipt').attr('data-href', `/proforma/reactivate/${id}`);
    if(type=="sale")
    $('#reactivate-receipt').attr('data-href', `/customers/receipts/sales/reactivate/${id}`);

    $('#reactivate-receipt').attr('data-id', id).attr('href', '#').attr('data-type', type);
}

$(document).on('click', '#btn-send-mail', function(e){
    e.preventDefault();

    var id = $(this).attr('data-id');
    var href = $(this).attr('data-href');
    var type = $(this).attr('data-type');

    // on success, close modal. nothing else.
    $.ajax({
        url: href,
        type: 'GET',
        success: function(result) {
            console.log(result);
            $('#modal-mail-confirmation').modal('hide');

            window.toast(`A request to send ${type} email is successfully made.`);
        }
    });
})

$(document).on('click', '#void-receipt', function(e){
    e.preventDefault();

    var id = $(this).attr('data-id');
    var href = $(this).attr('data-href');
    var type = $(this).attr('data-type');

    // on success, close modal, then toggle void button
    $.ajax({
        url: href,
        type: 'GET',
        success: function(result) {
            $('#modal-void-confirmation').modal('hide');
            // get parent of #vr-receipt-id
            let parent = $(`#vr-${type}-${id}`).parent();
            $(`#vr-${type}-${id}`).remove();

            // refer to receipts_table.js
            parent.append(`
            <button id="vr-${type}-${id}" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-reactivate-confirmation" data-type="${type}" data-id="${id}" data-action="reactivate" data-page="receipts")" >
                <span class="icon text-white-50">
                    <i class="fas fa-check"></i>
                </span>
            </button>
            `)

            if($('#void-receipt').attr('data-type') == 'receipt') {
                credit_receipt_search("", credit_receipts_page_number_current);
            }
            else if($('#void-receipt').attr('data-type') == 'creditReceipt'){
                receipt_search("", credit_receipts_page_number_current);
            }

            window.toast(`Successfully marked ${type} as void.`);

        },
        error: function(result) {
            console.log(result);

            window.toast(`An error occurred. See console for details.`);
        }
    });
})

$(document).on('click', '#reactivate-receipt', function(e){
    e.preventDefault();

    var id = $(this).attr('data-id');
    var href = $(this).attr('data-href');
    var type = $(this).attr('data-type');

    // on success, close modal, then toggle void button
    $.ajax({
        url: href,
        type: 'GET',
        success: function(result) {
            $('#modal-reactivate-confirmation').modal('hide');
            // get parent of #vr-receipt-id
            let parent = $(`#vr-${type}-${id}`).parent();
            $(`#vr-${type}-${id}`).remove();

            // refer to receipts_table.js
            parent.append(`
            <button id="vr-${type}-${id}" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-void-confirmation")" data-type="${type}" data-id="${id}" data-action="void" data-page="receipts">
                <span class="icon text-white-50">
                    <i class="fas fa-ban"></i>
                </span>
            </button>
            `)

            if($('#reactivate-receipt').attr('data-type') == 'receipt') {
                credit_receipt_search("", credit_receipts_page_number_current);
            }
            else if($('#reactivate-receipt').attr('data-type') == 'creditReceipt'){
                receipt_search("", credit_receipts_page_number_current);
            }

            window.toast(`Successfully marked ${type} as reactivated.`);
        },
        error: function(result) {
            console.log(result);

            window.toast(`An error occurred. See console for details.`);
        }
    });
})
