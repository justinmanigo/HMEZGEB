$(document).on('click', '.hoverable', function(e){
    e.preventDefault();
    console.log("clicked .hoverable");
    window.location.href = $(this).data('href');
});
