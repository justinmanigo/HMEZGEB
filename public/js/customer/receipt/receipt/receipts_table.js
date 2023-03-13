let receipts_fetch_url = "/ajax/customer/receipt/receipt/search";
let receipts_list = $("#receipts-list");
let receipts_prev = $("#receipts-prev");
let receipts_next = $("#receipts-next");
let receipts_search_input = $('#receipts-search-input');
let receipts_search_submit = $('#receipts-search-submit');
let receipts_page_number_label = $('#receipts-page-number-label');

let receipts_page_number_current = 1;
let receipts_page_number_max = 1;

$(document).ready(function(){
    receipt_search();
});

$(document).on('submit', '#receipts-search-form', function(e){
    e.preventDefault();
    // get input
    let query = receipts_search_input.val();
    receipt_search(query);
});

$(document).on('click', '#receipts-prev', function(e){
    e.preventDefault();
    // get input
    let query = receipts_search_input.val();
    receipt_search(query, receipts_page_number_current - 1);
});

$(document).on('click', '#receipts-next', function(e){
    e.preventDefault();
    // get input
    let query = receipts_search_input.val();
    receipt_search(query, receipts_page_number_current + 1);
});

function receipt_search(query = "", page = 1)
{
    console.log("receipt_search")
    receipts_page_number_current = 0;
    receipts_page_number_max = 0;
    receipts_list.html("");
    receipts_prev.prop("disabled", true);
    receipts_next.prop("disabled", true);
    receipts_search_submit.prop("disabled", true);
    receipts_page_number_label.text(`Page ${receipts_page_number_current} of ${receipts_page_number_max}`);

    const jqxhr = $.get({ url: `${receipts_fetch_url}/${query}?page=${page}` });
    jqxhr.done(function(res){
        console.log(res);

        if(res.receipts.data.length == 0)
        {
            let row = `
                <tr>
                    <td colspan="6" class="text-center">No receipts found.</td>
                </tr>
            `;
            receipts_list.append(row);
        }
        else
        {
            // populate receipts list
            for(let i = 0; i < res.receipts.data.length; i++)
            {
                /** to add later: partially void, fully void */
                let receipt = res.receipts.data[i];
                let row = `
                    <tr class="hoverable" data-href="#">
                        <td>${receipt.id}</td>
                        <td>${receipt.date}</td>
                        <td>${receipt.customer_name}</a></td>
                        <td>
                        ${receipt.grand_total >= receipt.total_amount_received
                            ? `<span class="badge badge-success">Paid</span>`
                            : receipt.grand_total > 0 && receipt.grand_total > receipt.total_amount_received
                                ? `<span class="badge badge-warning">Partially Paid</span>`
                                : `<span class="badge badge-danger">Unpaid</span>`
                        }
                        </td>
                        <td class="text-right">${parseFloat(receipt.grand_total).toFixed(2)}</td>
                        <td class="actions">
                            <a href="#" class="btn btn-sm btn-primary disabled">
                                <i class="fa fa-eye"></i>
                            </a>
                            <button id="mail-receipt-${receipt.id}" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-print-confirmation")" data-type="receipt" data-id="${receipt.id}" data-action="print" data-page="receipts">
                                <span class="icon text-white-50">
                                    <i class="fas fa-print"></i>
                                </span>
                            </button>
                            <button id="mail-receipt-${receipt.id}" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-mail-confirmation")" data-type="receipt" data-id="${receipt.id}" data-action="mail" data-page="receipts">
                                <span class="icon text-white-50">
                                    <i class="fas fa-envelope"></i>
                                </span>
                            </button>
                            ${!receipt.is_void ? `
                            <button id="vr-receipt-${receipt.id}" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-void-confirmation")" data-type="receipt" data-id="${receipt.id}" data-action="void" data-page="receipts">
                                <span class="icon text-white-50">
                                    <i class="fas fa-ban"></i>
                                </span>
                            </button>
                            `
                            : `
                            <button id="vr-receipt-${receipt.id}" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-reactivate-confirmation" data-type="receipt" data-id="${receipt.id}" data-action="reactivate" data-page="receipts")"}>
                                <span class="icon text-white-50">
                                    <i class="fas fa-check"></i>
                                </span>
                            </button>
                            `}
                        </td>
                    </tr>
                `;
                receipts_list.append(row);

                // focus input
                receipts_search_input.focus();
            }
        }




        // get max page number
        receipts_page_number_max = res.receipts.last_page;
        // get current page number
        receipts_page_number_current = res.receipts.current_page;
        // update page number label
        receipts_page_number_label.text(`Page ${receipts_page_number_current} of ${receipts_page_number_max}`);
        // enable/disable prev button
        receipts_prev.prop("disabled", receipts_page_number_current == 1);
        // enable/disable next button
        receipts_next.prop("disabled", receipts_page_number_current == receipts_page_number_max);
        // enable search button
        receipts_search_submit.prop("disabled", false);
    });

    jqxhr.fail(function(res){
        console.log(res);
    });
}
