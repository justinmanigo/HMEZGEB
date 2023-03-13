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

    if(action == "void" && page == "receipts") {
        console.log("void");
        voidModal(id, type);
    }
    else if(action == "reactivate" && page == "receipts") {
        console.log("void");
        reactivateModal(id, type);
    }
});

$(document).on('click', '.actions a', function(e){
    e.stopPropagation();
});
