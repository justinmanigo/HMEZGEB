let other_payments_fetch_url = "/ajax/vendor/payments/other/search";
let other_payments_list = $("#other-payments-list");
let other_payments_prev = $("#other-payments-prev");
let other_payments_next = $("#other-payments-next");
let other_payments_search_input = $('#other-payments-search-input');
let other_payments_search_submit = $('#other-payments-search-submit');
let other_payments_page_number_label = $('#other-payments-page-number-label');

let other_payments_page_number_current = 1;
let other_payments_page_number_max = 1;

$(document).ready(function(){
    other_payment_search();
});

$(document).on('submit', '#other-payments-search-form', function(e){
    e.preventDefault();
    // get input
    let query = other_payments_search_input.val();
    other_payment_search(query);
});

$(document).on('click', '#other-payments-prev', function(e){
    e.preventDefault();
    // get input
    let query = other_payments_search_input.val();
    other_payment_search(query, other_payments_page_number_current - 1);
});

$(document).on('click', '#other-payments-next', function(e){
    e.preventDefault();
    // get input
    let query = other_payments_search_input.val();
    other_payment_search(query, other_payments_page_number_current + 1);
});

async function other_payment_search(query = "", page = 1)
{
    console.log("other_payment_search")
    other_payments_page_number_current = 0;
    other_payments_page_number_max = 0;
    other_payments_list.html("");
    other_payments_prev.prop("disabled", true);
    other_payments_next.prop("disabled", true);
    other_payments_search_submit.prop("disabled", true);
    other_payments_page_number_label.text(`Page ${other_payments_page_number_current} of ${other_payments_page_number_max}`);

    const jqxhr = $.get({ url: `${other_payments_fetch_url}/${query}?page=${page}` });
    jqxhr.done(function(res){
        console.log(res);

        if(res.other_payments.data.length == 0)
        {
            let row = `
                <tr>
                    <td colspan="6" class="text-center">No other payments found.</td>
                </tr>
            `;
            other_payments_list.append(row);
        }
        else
        {
            // populate other_payments list
            for(let i = 0; i < res.other_payments.data.length; i++)
            {
                /** to add later: partially void, fully void */
                let other_payment = res.other_payments.data[i];
                let parsed = parseOtherPayment(other_payment);
                let row = `
                    <tr class="hoverable" data-href="#">
                        <td>${other_payment.id}</td>
                        <td>${other_payment.date}</td>
                        <td>${parsed.description}</td>
                        <td>${parsed.type}</td>
                        <td>
                        ${other_payment.status == 'paid'
                            ? `<span class="badge badge-success">Paid</span>`
                            : other_payment.status == 'partially_paid'
                                ? `<span class="badge badge-warning">Partially Paid</span>`
                                : `<span class="badge badge-danger">Unpaid</span>`
                        }
                        </td>
                        <td class="text-right">${parseFloat(parsed.amount).toFixed(2)}</td>
                        <td class="actions">
                            <a href="#" class="btn btn-sm btn-primary disabled">
                                <i class="fa fa-eye"></i>
                            </a>
                            <button id="print-other_payment-${other_payment.id}" class="btn btn-primary btn-sm" disabled>
                                <span class="icon text-white-50">
                                    <i class="fas fa-print"></i>
                                </span>
                            </button>
                            <button id="mail-other_payment-${other_payment.id}" class="btn btn-primary btn-sm" disabled data-action="mail" data-page="receipts">
                                <span class="icon text-white-50">
                                    <i class="fas fa-envelope"></i>
                                </span>
                            </button>
                            ${!other_payment.is_void ? `
                            <button id="vr-other_payment-${other_payment.id}" class="btn btn-danger btn-sm" disabled >
                                <span class="icon text-white-50">
                                    <i class="fas fa-ban"></i>
                                </span>
                            </button>
                            `
                            : `
                            <button id="vr-other_payment-${other_payment.id}" class="btn btn-success btn-sm" disabled>
                                <span class="icon text-white-50">
                                    <i class="fas fa-check"></i>
                                </span>
                            </button>
                            `}
                        </td>
                    </tr>
                `;
                other_payments_list.append(row);

                // focus input
                other_payments_search_input.focus();
            }
        }




        // get max page number
        other_payments_page_number_max = res.other_payments.last_page;
        // get current page number
        other_payments_page_number_current = res.other_payments.current_page;
        // update page number label
        other_payments_page_number_label.text(`Page ${other_payments_page_number_current} of ${other_payments_page_number_max}`);
        // enable/disable prev button
        other_payments_prev.prop("disabled", other_payments_page_number_current == 1);
        // enable/disable next button
        other_payments_next.prop("disabled", other_payments_page_number_current == other_payments_page_number_max);
        // enable search button
        other_payments_search_submit.prop("disabled", false);
    });

    jqxhr.fail(function(res){
        console.log(res);
    });
}

function parseOtherPayment(payment)
{
    let description, type, amount;

    if(payment.type == 'vat_payment') {
        description = "";
        type = `<span class="badge badge-info">VAT</span>`;
        amount = payment.vat_amount;
    }
    else if(payment.type == 'withholding_payment') {
        description = `For Period # ${payment.wp_period_number} - ${payment.wp_date_from} to ${payment.wp_date_to}`;
        type = `<span class="badge badge-warning">Withholding</span>`;
        amount = payment.withholding_amount;
    }
    else if(payment.type == 'payroll_payment') {
        description = `For Period # ${payment.pp_period_number} - ${payment.pp_date_from} to ${payment.pp_date_to}`;
        type = `<span class="badge badge-success">Payroll</span>`;
        amount = payment.payroll_amount;
    }
    else if(payment.type == 'income_tax_payment') {
        description = `For Period # ${payment.itp_period_number} - ${payment.itp_date_from} to ${payment.itp_date_to}`;
        type = `<span class="badge badge-danger">Income Tax</span>`;
        amount = payment.income_tax_amount;
    }
    else if(payment.type == 'pension_payment') {
        description = "";
        type = `<span class="badge badge-primary">Pension</span>`;
        amount = payment.pension_amount;
    }
    else if(payment.type == 'commission_payment') {
        description = "";
        type = `<span class="badge badge-secondary">Commission</span>`;
        amount = payment.commission_amount;
    }
    else {
        description = `For ${payment.name}`;
        type = `<span class="badge badge-light">Other</span>`;
    }

    return {
        description: description,
        type: type,
        amount: amount
    }
}
