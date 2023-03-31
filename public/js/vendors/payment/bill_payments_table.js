let bill_payments_fetch_url = "/ajax/vendor/payments/bill/search";
let bill_payments_list = $("#bill-payments-list");
let bill_payments_prev = $("#bill-payments-prev");
let bill_payments_next = $("#bill-payments-next");
let bill_payments_search_input = $('#bill-payments-search-input');
let bill_payments_search_submit = $('#bill-payments-search-submit');
let bill_payments_page_number_label = $('#bill-payments-page-number-label');

let bill_payments_page_number_current = 1;
let bill_payments_page_number_max = 1;

$(document).ready(function(){
    bill_payment_search();
});

$(document).on('submit', '#bill-payments-search-form', function(e){
    e.preventDefault();
    // get input
    let query = bill_payments_search_input.val();
    bill_payment_search(query);
});

$(document).on('click', '#bill-payments-prev', function(e){
    e.preventDefault();
    // get input
    let query = bill_payments_search_input.val();
    bill_payment_search(query, bill_payments_page_number_current - 1);
});

$(document).on('click', '#bill-payments-next', function(e){
    e.preventDefault();
    // get input
    let query = bill_payments_search_input.val();
    bill_payment_search(query, bill_payments_page_number_current + 1);
});

function bill_payment_search(query = "", page = 1)
{
    console.log("bill_payment_search")
    bill_payments_page_number_current = 0;
    bill_payments_page_number_max = 0;
    bill_payments_list.html("");
    bill_payments_prev.prop("disabled", true);
    bill_payments_next.prop("disabled", true);
    bill_payments_search_submit.prop("disabled", true);
    bill_payments_page_number_label.text(`Page ${bill_payments_page_number_current} of ${bill_payments_page_number_max}`);

    const jqxhr = $.get({ url: `${bill_payments_fetch_url}/${query}?page=${page}` });
    jqxhr.done(function(res){
        console.log(res);

        if(res.bill_payments.data.length == 0)
        {
            let row = `
                <tr>
                    <td colspan="6" class="text-center">No bill payments found.</td>
                </tr>
            `;
            bill_payments_list.append(row);
        }
        else
        {
            // populate bill_payments list
            for(let i = 0; i < res.bill_payments.data.length; i++)
            {
                /** to add later: partially void, fully void */
                let bill_payment = res.bill_payments.data[i];
                let row = `
                    <tr class="hoverable" data-href="#">
                        <td>${bill_payment.id}</td>
                        <td>${bill_payment.date}</td>
                        <td>
                        ${bill_payment.status == 'paid'
                            ? `<span class="badge badge-success">Paid</span>`
                            : bill_payment.status == 'partially_paid'
                                ? `<span class="badge badge-warning">Partially Paid</span>`
                                : `<span class="badge badge-danger">Unpaid</span>`
                        }
                        </td>
                        <td class="text-right">${parseFloat(bill_payment.amount_paid).toFixed(2)}</td>
                        <td class="actions">
                            <a href="#" class="btn btn-sm btn-primary disabled">
                                <i class="fa fa-eye"></i>
                            </a>
                            <button id="print-bill_payment-${bill_payment.id}" class="btn btn-primary btn-sm" disabled>
                                <span class="icon text-white-50">
                                    <i class="fas fa-print"></i>
                                </span>
                            </button>
                            <button id="mail-bill_payment-${bill_payment.id}" class="btn btn-primary btn-sm" disabled data-action="mail" data-page="receipts">
                                <span class="icon text-white-50">
                                    <i class="fas fa-envelope"></i>
                                </span>
                            </button>
                            ${!bill_payment.is_void ? `
                            <button id="vr-bill_payment-${bill_payment.id}" class="btn btn-danger btn-sm" disabled >
                                <span class="icon text-white-50">
                                    <i class="fas fa-ban"></i>
                                </span>
                            </button>
                            `
                            : `
                            <button id="vr-bill_payment-${bill_payment.id}" class="btn btn-success btn-sm" disabled>
                                <span class="icon text-white-50">
                                    <i class="fas fa-check"></i>
                                </span>
                            </button>
                            `}
                        </td>
                    </tr>
                `;
                bill_payments_list.append(row);

                // focus input
                bill_payments_search_input.focus();
            }
        }




        // get max page number
        bill_payments_page_number_max = res.bill_payments.last_page;
        // get current page number
        bill_payments_page_number_current = res.bill_payments.current_page;
        // update page number label
        bill_payments_page_number_label.text(`Page ${bill_payments_page_number_current} of ${bill_payments_page_number_max}`);
        // enable/disable prev button
        bill_payments_prev.prop("disabled", bill_payments_page_number_current == 1);
        // enable/disable next button
        bill_payments_next.prop("disabled", bill_payments_page_number_current == bill_payments_page_number_max);
        // enable search button
        bill_payments_search_submit.prop("disabled", false);
    });

    jqxhr.fail(function(res){
        console.log(res);
    });
}
