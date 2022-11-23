/** Auxilary Functions */

// If withholding_check is checked, enable withholding_amount
$('#b_withholding_toggle').change(function() {
    if($(this).is(":checked")) {
        $('#b_withholding').prop('disabled', false);
        $('#b_withholding_required').removeClass('d-none');
    } else {
        $('#b_withholding').prop('disabled', true);
        $('#b_withholding_required').addClass('d-none');
    }
});
