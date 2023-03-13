let proformas_fetch_url = "/ajax/customer/receipt/proforma/search";
let proformas_list = $("#proformas-list");
let proformas_prev = $("#proformas-prev");
let proformas_next = $("#proformas-next");
let proformas_search_input = $('#proformas-search-input');
let proformas_search_submit = $('#proformas-search-submit');
let proformas_page_number_label = $('#proformas-page-number-label');

let proformas_page_number_current = 1;
let proformas_page_number_max = 1;

$(document).ready(function(){
    proforma_search();
});

$(document).on('submit', '#proformas-search-form', function(e){
    e.preventDefault();
    // get input
    let query = proformas_search_input.val();
    proforma_search(query);
});

$(document).on('click', '#proformas-prev', function(e){
    e.preventDefault();
    // get input
    let query = proformas_search_input.val();
    proforma_search(query, proformas_page_number_current - 1);
});

$(document).on('click', '#proformas-next', function(e){
    e.preventDefault();
    // get input
    let query = proformas_search_input.val();
    proforma_search(query, proformas_page_number_current + 1);
});

function proforma_search(query = "", page = 1)
{
    console.log("proforma_search")
    proformas_page_number_current = 0;
    proformas_page_number_max = 0;
    proformas_list.html("");
    proformas_prev.prop("disabled", true);
    proformas_next.prop("disabled", true);
    proformas_search_submit.prop("disabled", true);
    proformas_page_number_label.text(`Page ${proformas_page_number_current} of ${proformas_page_number_max}`);

    const jqxhr = $.get({ url: `${proformas_fetch_url}/${query}?page=${page}` });
    jqxhr.done(function(res){
        console.log(res);

        if(res.proformas.data.length == 0)
        {
            let row = `
                <tr>
                    <td colspan="7" class="text-center">No proformas found.</td>
                </tr>
            `;
            proformas_list.append(row);
        }
        else
        {
            // populate proformas list
            for(let i = 0; i < res.proformas.data.length; i++)
            {
                /** to add later: partially void, fully void */

                let proforma = res.proformas.data[i];
                const dueDate = new Date(res.proformas.data[i].due_date);
                const now = new Date();
                const diffInMs = dueDate - now;
                const diffInDays = Math.ceil(diffInMs / (1000 * 60 * 60 * 24));
                const formattedDueDate = dueDate.toLocaleDateString('en-US', {month: 'short', day: 'numeric', year: 'numeric'});

                let row = `
                    <tr class="hoverable" data-href="/customers/receipts/proformas/${proforma.id}">
                        <td>${proforma.id}</td>
                        <td>${proforma.date}</td>
                        <td>${proforma.customer_name}</a></td>
                        <td>
                        ${proforma.grand_total >= proforma.total_amount_received
                            ? `<span class="badge badge-success">Paid</span>`
                            : proforma.grand_total > 0 && proforma.grand_total > proforma.total_amount_received
                                ? `<span class="badge badge-warning">Partially Paid</span>`
                                : `<span class="badge badge-danger">Unpaid</span>`
                        }
                        </td>
                        <td class="text-right">${diffInDays < 0
                            ? `
                                <span title="${formattedDueDate}" class="badge badge-danger">Expired</span>
                            `
                            : `
                                <span title="${formattedDueDate}" class="badge badge-success">in ${diffInDays} days</span>
                        `}</td>
                        <td class="text-right">${parseFloat(proforma.grand_total).toFixed(2)}</td>
                        <td class="actions">
                            <a href="#" class="btn btn-sm btn-primary disabled">
                                <i class="fa fa-eye"></i>
                            </a>
                            <button id="mail-proforma-${proforma.proforma_id}" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-print-confirmation")" data-type="proforma" data-id="${proforma.proforma_id}" data-action="print" data-page="receipts">
                                <span class="icon text-white-50">
                                    <i class="fas fa-print"></i>
                                </span>
                            </button>
                            <button id="mail-proforma-${proforma.proforma_id}" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-mail-confirmation")" data-type="proforma" data-id="${proforma.proforma_id}" data-action="mail" data-page="receipts">
                                <span class="icon text-white-50">
                                    <i class="fas fa-envelope"></i>
                                </span>
                            </button>
                            ${!proforma.is_void ? `
                            <button id="vr-proforma-${proforma.proforma_id}" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-void-confirmation")" data-type="proforma" data-id="${proforma.proforma_id}" data-action="void" data-page="receipts">
                                <span class="icon text-white-50">
                                    <i class="fas fa-ban"></i>
                                </span>
                            </button>
                            `
                            : `
                            <button id="vr-proforma-${proforma.proforma_id}" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-reactivate-confirmation" data-type="proforma" data-id="${proforma.proforma_id}" data-action="reactivate" data-page="receipts")"}>
                                <span class="icon text-white-50">
                                    <i class="fas fa-check"></i>
                                </span>
                            </button>
                            `}
                        </td>
                    </tr>
                `;
                proformas_list.append(row);

                // focus input
                proformas_search_input.focus();
            }
        }




        // get max page number
        proformas_page_number_max = res.proformas.last_page;
        // get current page number
        proformas_page_number_current = res.proformas.current_page;
        // update page number label
        proformas_page_number_label.text(`Page ${proformas_page_number_current} of ${proformas_page_number_max}`);
        // enable/disable prev button
        proformas_prev.prop("disabled", proformas_page_number_current == 1);
        // enable/disable next button
        proformas_next.prop("disabled", proformas_page_number_current == proformas_page_number_max);
        // enable search button
        proformas_search_submit.prop("disabled", false);
    });

    jqxhr.fail(function(res){
        console.log(res);
    });
}
