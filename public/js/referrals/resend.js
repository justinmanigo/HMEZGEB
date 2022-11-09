// Resending email
$(document).on('click', '.btn-resend-invitation', function(e){
    e.preventDefault();
    var id = $(this).data('id');
    var _token = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: '/ajax/referrals/resend/' + id,
        type: 'POST',
        data: {
            id: id,
            _token: _token
        },
        success: function(data) {
            console.log(data);
            if (data.success) {
                alert(data.message);
            } else {
                alert(data.message);
            }
        },
        error: function(data) {
            alert(data.error);
        }
    });
});
