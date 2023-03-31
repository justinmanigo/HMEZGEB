let bills_fetch_url = "/ajax/vendor/bills/search";
let bills_list = $("#bills-list");
let bills_prev = $("#bills-prev");
let bills_next = $("#bills-next");
let bills_search_input = $('#bills-search-input');
let bills_search_submit = $('#bills-search-submit');
let bills_page_number_label = $('#bills-page-number-label');

let bills_page_number_current = 1;
let bills_page_number_max = 1;

$(document).ready(function(){
    bill_search();
});

$(document).on('submit', '#bills-search-form', function(e){
    e.preventDefault();
    // get input
    let query = bills_search_input.val();
    bill_search(query);
});

$(document).on('click', '#bills-prev', function(e){
    e.preventDefault();
    // get input
    let query = bills_search_input.val();
    bill_search(query, bills_page_number_current - 1);
});

$(document).on('click', '#bills-next', function(e){
    e.preventDefault();
    // get input
    let query = bills_search_input.val();
    bill_search(query, bills_page_number_current + 1);
});

async function bill_search(query = "", page = 1)
{
    console.log("bill_search")
    bills_page_number_current = 0;
    bills_page_number_max = 0;
    bills_list.html("");
    bills_prev.prop("disabled", true);
    bills_next.prop("disabled", true);
    bills_search_submit.prop("disabled", true);
    bills_page_number_label.text(`Page ${bills_page_number_current} of ${bills_page_number_max}`);

    const jqxhr = $.get({ url: `${bills_fetch_url}/${query}?page=${page}` });
    jqxhr.done(function(res){
        console.log(res);

        if(res.bills.data.length == 0)
        {
            let row = `
                <tr>
                    <td colspan="7" class="text-center">No bills found.</td>
                </tr>
            `;
            bills_list.append(row);
        }
        else
        {
            // populate bills list
            for(let i = 0; i < res.bills.data.length; i++)
            {
                /** to add later: partially void, fully void */
                let bill = res.bills.data[i];
                let parsed = parseBill(bill);
                let row = `
                    <tr class="hoverable" data-href="#">
                        <td>${bill.id}</td>
                        <td>${bill.date}</td>
                        <td>${parsed.description}</td>
                        <td>${parsed.type}</td>
                        <td>
                        ${bill.status == 'paid'
                            ? `<span class="badge badge-success">Paid</span>`
                            : bill.status == 'partially_paid'
                                ? `<span class="badge badge-warning">Partially Paid</span>`
                                : `<span class="badge badge-danger">Unpaid</span>`
                        }
                        </td>
                        <td class="text-right">${parseFloat(parsed.amount).toFixed(2)}</td>
                        <td class="actions">
                            <a href="#" class="btn btn-sm btn-primary disabled">
                                <i class="fa fa-eye"></i>
                            </a>
                            <button id="print-bill-${bill.id}" class="btn btn-primary btn-sm" disabled>
                                <span class="icon text-white-50">
                                    <i class="fas fa-print"></i>
                                </span>
                            </button>
                            <button id="mail-bill-${bill.id}" class="btn btn-primary btn-sm" disabled data-action="mail" data-page="receipts">
                                <span class="icon text-white-50">
                                    <i class="fas fa-envelope"></i>
                                </span>
                            </button>
                            ${!bill.is_void ? `
                            <button id="vr-bill-${bill.id}" class="btn btn-danger btn-sm" disabled >
                                <span class="icon text-white-50">
                                    <i class="fas fa-ban"></i>
                                </span>
                            </button>
                            `
                            : `
                            <button id="vr-bill-${bill.id}" class="btn btn-success btn-sm" disabled>
                                <span class="icon text-white-50">
                                    <i class="fas fa-check"></i>
                                </span>
                            </button>
                            `}
                        </td>
                    </tr>
                `;
                bills_list.append(row);

                // focus input
                bills_search_input.focus();
            }
        }




        // get max page number
        bills_page_number_max = res.bills.last_page;
        // get current page number
        bills_page_number_current = res.bills.current_page;
        // update page number label
        bills_page_number_label.text(`Page ${bills_page_number_current} of ${bills_page_number_max}`);
        // enable/disable prev button
        bills_prev.prop("disabled", bills_page_number_current == 1);
        // enable/disable next button
        bills_next.prop("disabled", bills_page_number_current == bills_page_number_max);
        // enable search button
        bills_search_submit.prop("disabled", false);
    });

    jqxhr.fail(function(res){
        console.log(res);
    });
}

function parseBill(bill)
{
    let description, type, amount;

    if(bill.type == 'cogs') {
        description = "A Cost of Goods";
        type = `<span class="badge badge-info">COGS</span>`;
        amount = bill.cost_of_goods_sold_amount;
    }
    else if(bill.type == 'expense') {
        description = `An Expense`;
        type = `<span class="badge badge-warning">Expense</span>`;
        amount = bill.expenses_amount;
    }
    else if(bill.type == 'bill') {
        description = `For ${bill.name}`;
        type = `<span class="badge badge-success">Bill</span>`;
        amount = bill.bill_amount;
    }
    else if(bill.type == 'purchase_order') {
        description = `For ${bill.name}`;
        type = `<span class="badge badge-danger">Purchase Order</span>`;
        amount = bill.purchase_order_amount;
    }
    else {
        description = `For ${bill.name}`;
        type = `<span class="badge badge-light">Other</span>`;
    }

    return {
        description: description,
        type: type,
        amount: amount
    }
}
