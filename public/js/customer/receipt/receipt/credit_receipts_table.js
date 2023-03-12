let credit_receipts_fetch_url = "/ajax/customer/receipt/credit-receipt/search";
let credit_receipts_list = $("#credit-receipts-list");
let credit_receipts_prev = $("#credit-receipts-prev");
let credit_receipts_next = $("#credit-receipts-next");
let credit_receipts_search_input = $('#credit-receipts-search-input');
let credit_receipts_search_submit = $('#credit-receipts-search-submit');
let credit_receipts_page_number_label = $('#credit-receipts-page-number-label');

let credit_receipts_page_number_current = 1;
let credit_receipts_page_number_max = 1;

$(document).ready(function(){
    credit_receipt_search();
});

$(document).on('submit', '#credit-receipts-search-form', function(e){
    e.preventDefault();
    // get input
    let query = credit_receipts_search_input.val();
    credit_receipt_search(query);
});

$(document).on('click', '#credit-receipts-prev', function(e){
    e.preventDefault();
    // get input
    let query = credit_receipts_search_input.val();
    credit_receipt_search(query, credit_receipts_page_number_current - 1);
});

$(document).on('click', '#credit-receipts-next', function(e){
    e.preventDefault();
    // get input
    let query = credit_receipts_search_input.val();
    credit_receipt_search(query, credit_receipts_page_number_current + 1);
});

function credit_receipt_search(query = "", page = 1)
{
    console.log("credit_receipt_search")
    credit_receipts_page_number_current = 0;
    credit_receipts_page_number_max = 0;
    credit_receipts_list.html("");
    credit_receipts_prev.prop("disabled", true);
    credit_receipts_next.prop("disabled", true);
    credit_receipts_search_submit.prop("disabled", true);
    credit_receipts_page_number_label.text(`Page ${credit_receipts_page_number_current} of ${credit_receipts_page_number_max}`);

    const jqxhr = $.get({ url: `${credit_receipts_fetch_url}/${query}?page=${page}` });
    jqxhr.done(function(res){
        console.log(res);

        if(res.credit_receipts.data.length == 0)
        {
            let row = `
                <tr>
                    <td colspan="6" class="text-center">No credit_receipts found.</td>
                </tr>
            `;
            credit_receipts_list.append(row);
        }
        else
        {
            // populate credit_receipts list
            for(let i = 0; i < res.credit_receipts.data.length; i++)
            {
                /** to add later: partially void, fully void */
                let credit_receipt = res.credit_receipts.data[i];
                let row = `
                    <tr class="hoverable" data-href="#">
                        <td>${credit_receipt.id}</td>
                        <td>${credit_receipt.date}</td>
                        <td>${credit_receipt.customer_name}</a></td>
                        <td>
                        ${credit_receipt.grand_total >= credit_receipt.total_amount_received
                            ? `<span class="badge badge-success">Paid</span>`
                            : credit_receipt.grand_total > 0 && credit_receipt.grand_total > credit_receipt.total_amount_received
                                ? `<span class="badge badge-warning">Partially Paid</span>`
                                : `<span class="badge badge-danger">Unpaid</span>`
                        }
                        </td>
                        <td class="text-right">${parseFloat(credit_receipt.grand_total).toFixed(2)}</td>
                        <td class="actions">
                            <a href="#" class="btn btn-sm btn-primary disabled">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="#" class="btn btn-sm btn-primary disabled">
                                <i class="fa fa-print"></i>
                            </a>
                            <a href="#" class="btn btn-sm btn-primary disabled">
                                <i class="fa fa-envelope"></i>
                            </a>
                        </td>
                        ${!credit_receipt.is_void ? `
                        <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-void-confirmation" onclick="voidModal(${credit_receipt.id}, 'credit_receipt')">
                            <span class="icon text-white-50">
                                <i class="fas fa-ban"></i>
                            </span>
                        </button>
                        `
                        : `
                        <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-reactivate-confirmation" onclick="reactivateModal(${credit_receipt.id}, 'credit_receipt')">
                            <span class="icon text-white-50">
                                <i class="fas fa-check"></i>
                            </span>
                        </button>
                        `}
                    </tr>
                `;
                credit_receipts_list.append(row);

                // focus input
                credit_receipts_search_input.focus();
            }
        }




        // get max page number
        credit_receipts_page_number_max = res.credit_receipts.last_page;
        // get current page number
        credit_receipts_page_number_current = res.credit_receipts.current_page;
        // update page number label
        credit_receipts_page_number_label.text(`Page ${credit_receipts_page_number_current} of ${credit_receipts_page_number_max}`);
        // enable/disable prev button
        credit_receipts_prev.prop("disabled", credit_receipts_page_number_current == 1);
        // enable/disable next button
        credit_receipts_next.prop("disabled", credit_receipts_page_number_current == credit_receipts_page_number_max);
        // enable search button
        credit_receipts_search_submit.prop("disabled", false);
    });

    jqxhr.fail(function(res){
        console.log(res);
    });
}
