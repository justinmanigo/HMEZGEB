// Called from `hoverable.js`
function bills_table_actions(id, type, action)
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
function mailModal(id,type){
    // set attribute href of btn-send-mail
    if(type == 'bill')
    $('#modal-mail-confirmation-btn').attr('data-href', `/bill/mail/${id}`);
    else if(type == 'purchase_order')
    $('#modal-mail-confirmation-btn').attr('data-href', `/purchaseOrder/mail/${id}`);

    $('#modal-mail-confirmation-btn').attr('data-id', id).attr('href', '#').attr('data-type', type);

}

// Get id of transaction to print confirmation modal
function printModal(id,type){
    // set attribute href of btn-send-mail
    if(type == 'bill')
    $('#modal-print-confirmation-btn').attr('href', `/bill/print/${id}`);
    else if(type == 'purchase_order')
    $('#modal-print-confirmation-btn').attr('href', `/purchaseOrder/print/${id}`);
}

// VOID
function voidModal(id,type){
    // set attribute href of btn-send-mail
    if(type == 'bill')
    $('#modal-void-confirmation-btn').attr('data-href', `/bill/void/${id}`);
    else if(type == 'purchase_order')
    $('#modal-void-confirmation-btn').attr('data-href', `/purchaseOrder/void/${id}`);

    $('#modal-void-confirmation-btn').attr('data-id', id).attr('href', '#').attr('data-type', type);
}

//  Reactivate
function reactivateModal(id,type){
    // set attribute href of btn-send-mail
    if(type == 'bill')
    $('#modal-reactivate-confirmation-btn').attr('data-href', `/bill/reactivate/${id}`);
    else if(type == 'purchase_order')
    $('#modal-reactivate-confirmation-btn').attr('data-href', `/purchaseOrder/reactivate/${id}`);

    $('#modal-reactivate-confirmation-btn').attr('data-id', id).attr('href', '#').attr('data-type', type);
}

$(document).on('click', '#modal-mail-confirmation-btn', function(e){
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

$(document).on('click', '#modal-void-confirmation-btn', function(e){
    e.preventDefault();

    var id = $(this).attr('data-id');
    var href = $(this).attr('data-href');
    var type = $(this).attr('data-type');

    // on success, close modal, then toggle void button
    $.ajax({
        url: href,
        type: 'GET',
        success: function(result) {
            console.log("Checking void result", result);
            $('#modal-void-confirmation').modal('hide');

            bill_search("", bills_page_number_current);

            window.toast(`Successfully marked ${type} as void.`);

        },
        error: function(result) {
            console.log(result);

            window.toast(`An error occurred. See console for details.`);
        }
    });
})

$(document).on('click', '#modal-reactivate-confirmation-btn', function(e){
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

            bill_search("", bills_page_number_current);

            window.toast(`Successfully marked ${type} as reactivated.`);
        },
        error: function(result) {
            console.log(result);

            window.toast(`An error occurred. See console for details.`);
        }
    });
})
