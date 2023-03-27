$(document).on('click', '.hoverable', function(e){
    e.preventDefault();
    console.log("clicked .hoverable");
    window.location.href = $(this).data('href');
});

$(document).on('click', '.actions button', function(e){
    e.stopPropagation();

    let action = $(this).data('action');
    let id = $(this).data('id');
    let type = $(this).data('type');
    let page = $(this).data('page');

    console.log(`clicked .actions button: ${action} ${id} ${type}`);

    // refer to receipt/index
    if(page == "receipts") {
        // require public/js/customer/receipt/receipt/table_actions.js
        window.receipts_table_actions(id, type, action);
    }
    else if(page == "customers") {
        window.customers_table_actions(id, type, action);
    }
});

$(document).on('click', '.actions a', function(e){
    e.stopPropagation();
});
