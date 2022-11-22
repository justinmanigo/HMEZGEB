var wp_payable = 0;
var wp_periods = [];

$(document).ready(function(){
    $('#modal-withholding-payment').on('shown.bs.modal', function(){
        console.log("Show withholding payment UI.");

        // Show loading
        $("#wp_footer").addClass("d-none");
        $("#wp_body_main").addClass("d-none");
        $("#wp_body_loading").removeClass("d-none");

        var request = $.ajax({
            url: "/ajax/vendors/payments/withholding/all/",
            method: "GET",
        });

        request.done(function(res, status, jqXHR ) {
            console.log(res);
            wp_periods = res;

            let inner = "";

            if (res.length > 0) {
                for (let i = 0; i < res.length; i++) {
                    inner += `
                        <tr>
                            <td>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input wp_period_checkbox" id="wp_period_${res[i].id}" value="${res[i].id}" data-period-number="${res[i].period_number}">
                                    <label class="custom-control-label" for="wp_period_${res[i].id}">Period # ${res[i].period_number}</label>
                                </div>
                            </td>
                            <td>${res[i].date_from} to ${res[i].date_to}</td>
                            <td>
                                <span class='badge badge-secondary'>N/A</span>
                            </td>
                            <td class="text-right">${res[i].total_withholdings}</td>
                        </tr>
                    `;
                }
            }

            $("#wp_periods").html(inner);
        });

        request.fail(function(jqXHR, status, error) {
            console.log("Error fetching withholding payables data.");
        });

        request.always(function(){
            $("#wp_footer").removeClass("d-none");
            $("#wp_body_main").removeClass("d-none");
            $("#wp_body_loading").addClass("d-none");
        });
    });

    $('#modal-withholding-payment').on('hidden.bs.modal', function(){
        console.log("Hide withholding payment UI.");
        $("#wp_footer").addClass("d-none");
        $("#wp_body_main").addClass("d-none");
        $("#wp_body_loading").removeClass("d-none");
    });

    $("#wp_select_all").on('click', function(){
        console.log("Clicked wp_select_all");

        let checked = $(this).prop('checked');
        $(".wp_period_checkbox").prop('checked', checked);

        // Get total withholding payables by iterating on wp_periods
        if (checked) {
            wp_payable = 0;
            for(i = 0; i < 12; i++) {
                wp_payable += parseFloat(wp_periods[i].total_withholdings);
            }
        } else {
            wp_payable = parseFloat(0);
        }

        $('#wp_total_withholding_payable').html(wp_payable.toFixed(2));
    });

    // set select all to neutral when not all buttons are clicked
    $("#wp_periods").on('click', '.wp_period_checkbox', function(){
        console.log("Clicked wp_period_checkbox");
        console.log($(this));

        // Check result of clicked checkbox
        let checked = $(this).prop('checked');

        // Depending on checked, deduct or add to wp_payable
        if (checked) {
            wp_payable += parseFloat(wp_periods[$(this).data('period-number') - 1].total_withholdings);
        } else {
            wp_payable -= parseFloat(wp_periods[$(this).data('period-number') - 1].total_withholdings);
        }

        $('#wp_total_withholding_payable').html(wp_payable.toFixed(2));

        // Check if all checkboxes are checked
        let all_checked = true;
        $(".wp_period_checkbox").each(function(){
            if (!$(this).prop('checked')) {
                all_checked = false;
            }
        });

        $("#wp_select_all").prop('checked', all_checked);
    });
});
