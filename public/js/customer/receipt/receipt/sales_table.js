let sales_fetch_url = "/ajax/customer/receipt/sale/search";
let sales_list = $("#sales-list");
let sales_prev = $("#sales-prev");
let sales_next = $("#sales-next");
let sales_search_input = $('#sales-search-input');
let sales_search_submit = $('#sales-search-submit');
let sales_page_number_label = $('#sales-page-number-label');

let sales_page_number_current = 1;
let sales_page_number_max = 1;

$(document).ready(function(){
    sale_search();
});

$(document).on('submit', '#sales-search-form', function(e){
    e.preventDefault();
    // get input
    let query = sales_search_input.val();
    sale_search(query);
});

$(document).on('click', '#sales-prev', function(e){
    e.preventDefault();
    // get input
    let query = sales_search_input.val();
    sale_search(query, sales_page_number_current - 1);
});

$(document).on('click', '#sales-next', function(e){
    e.preventDefault();
    // get input
    let query = sales_search_input.val();
    sale_search(query, sales_page_number_current + 1);
});

function sale_search(query = "", page = 1)
{
    console.log("sale_search")
    sales_page_number_current = 0;
    sales_page_number_max = 0;
    sales_list.html("");
    sales_prev.prop("disabled", true);
    sales_next.prop("disabled", true);
    sales_search_submit.prop("disabled", true);
    sales_page_number_label.text(`Page ${sales_page_number_current} of ${sales_page_number_max}`);

    const jqxhr = $.get({ url: `${sales_fetch_url}/${query}?page=${page}` });
    jqxhr.done(function(res){
        console.log(res);

        if(res.sales.data.length == 0)
        {
            let row = `
                <tr>
                    <td colspan="6" class="text-center">No sales found.</td>
                </tr>
            `;
            sales_list.append(row);
        }
        else
        {
            // populate sales list
            for(let i = 0; i < res.sales.data.length; i++)
            {
                /** to add later: partially void, fully void */
                let sale = res.sales.data[i];
                let row = `
                    <tr class="hoverable" data-href="#">
                        <td>${sale.id}</td>
                        <td>${sale.date}</td>
                        <td>
                        ${sale.grand_total >= sale.total_amount_received
                            ? `<span class="badge badge-success">Paid</span>`
                            : sale.grand_total > 0 && sale.grand_total > sale.total_amount_received
                                ? `<span class="badge badge-warning">Partially Paid</span>`
                                : `<span class="badge badge-danger">Unpaid</span>`
                        }
                        </td>
                        <td class="text-right">${parseFloat(sale.grand_total).toFixed(2)}</td>
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
                    </tr>
                `;
                sales_list.append(row);

                // focus input
                sales_search_input.focus();
            }
        }




        // get max page number
        sales_page_number_max = res.sales.last_page;
        // get current page number
        sales_page_number_current = res.sales.current_page;
        // update page number label
        sales_page_number_label.text(`Page ${sales_page_number_current} of ${sales_page_number_max}`);
        // enable/disable prev button
        sales_prev.prop("disabled", sales_page_number_current == 1);
        // enable/disable next button
        sales_next.prop("disabled", sales_page_number_current == sales_page_number_max);
        // enable search button
        sales_search_submit.prop("disabled", false);
    });

    jqxhr.fail(function(res){
        console.log(res);
    });
}
