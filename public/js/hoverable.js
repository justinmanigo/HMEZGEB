$(document).on('click', '.hoverable', function(e){
    e.preventDefault();
    console.log("clicked .hoverable");
    window.location.href = $(this).data('href');
});

$(document).on('click', '.actions button', function(e){
    e.stopPropagation();
});

$(document).on('click', '.actions a', function(e){
    e.stopPropagation();
});
