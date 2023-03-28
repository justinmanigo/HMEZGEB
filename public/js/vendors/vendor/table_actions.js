// Called from `hoverable.js`
function vendors_table_actions(id, type, action)
{
    // refer functions to vendors index
    if(action == "mail") {
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
    $('#specificStatement').attr('data-href', "/vendors/mail/statement/" + id);

    $('#specificStatement').attr('data-id', id).attr('href', '#').attr('data-type', type);
}

// Get id of transaction to print confirmation modal
function printModal(id, type){
    $('#print-deposit').attr('href', "/vendors/print/statement/" + id);
}

$(document).on('click', '#specificStatement', function(e){
    console.log("click #specificStatement");
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
            $('#modal-statement').modal('hide');

            window.toast(`A request to send ${type} email is successfully made.`);
        }
    });
})
