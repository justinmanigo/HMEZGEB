let customers_fetch_url = "/ajax/customer/customer/search";
let customers_list = $("#customers-list");
let customers_prev = $("#customers-prev");
let customers_next = $("#customers-next");
let customers_search_input = $('#customers-search-input');
let customers_search_submit = $('#customers-search-submit');
let customers_page_number_label = $('#customers-page-number-label');

let customers_page_number_current = 1;
let customers_page_number_max = 1;

$(document).ready(function(){
    customers_search();
});

$(document).on('submit', '#customers-search-form', function(e){
    e.preventDefault();
    // get input
    let query = customers_search_input.val();
    customers_search(query);
});

$(document).on('click', '#customers-prev', function(e){
    e.preventDefault();
    // get input
    let query = customers_search_input.val();
    customers_search(query, customers_page_number_current - 1);
});

$(document).on('click', '#customers-next', function(e){
    e.preventDefault();
    // get input
    let query = customers_search_input.val();
    customers_search(query, customers_page_number_current + 1);
});

function customers_search(query = "", page = 1)
{
    console.log("customers_search")
    customers_page_number_current = 0;
    customers_page_number_max = 0;
    customers_list.html("");
    customers_prev.prop("disabled", true);
    customers_next.prop("disabled", true);
    customers_search_submit.prop("disabled", true);
    customers_page_number_label.text(`Page ${customers_page_number_current} of ${customers_page_number_max}`);

    const jqxhr = $.get({ url: `${customers_fetch_url}/${query}?page=${page}` });
    jqxhr.done(function(res){
        console.log(res);

        if(res.customers.data.length == 0)
        {
            let row = `
                <tr>
                    <td colspan="5" class="text-center">No customers found.</td>
                </tr>
            `;
            customers_list.append(row);
        }
        else
        {
            // populate customers list
            for(let i = 0; i < res.customers.data.length; i++)
            {
                /** to add later: partially void, fully void */
                let customer = res.customers.data[i];
                let row = `
                    <tr class="hoverable" data-href="#">
                        <td>${customer.id}</td>
                        <td>${customer.name}<small class="badge badge-primary ml-2" style="font-weight:400!important">${customer.label}</small></td>
                        <td>${customer.tin_number}</td>
                        <td class="text-right">${parseFloat(customer.balance.balance).toFixed(2)}</td>
                        <td class="actions">
                            <!--<a href="#" class="btn btn-sm btn-primary disabled">
                                <i class="fa fa-eye"></i>
                            </a>-->
                            <a href="#" class="btn btn-sm btn-primary disabled">
                                <i class="fa fa-pen"></i>
                            </a>
                            <button id="mail-customers-${customer.id}" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-print" data-type="customers" data-id="${customer.id}" data-action="print" data-page="customers">
                                <span class="icon text-white-50">
                                    <i class="fas fa-print"></i>
                                </span>
                            </button>
                            <button id="mail-customers-${customer.id}" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-statement" data-type="customers" data-id="${customer.id}" data-action="mail" data-page="customers">
                                <span class="icon text-white-50">
                                    <i class="fas fa-envelope"></i>
                                </span>
                            </button>
                        </td>
                    </tr>
                `;
                customers_list.append(row);

                // focus input
                customers_search_input.focus();
            }
        }




        // get max page number
        customers_page_number_max = res.customers.last_page;
        // get current page number
        customers_page_number_current = res.customers.current_page;
        // update page number label
        customers_page_number_label.text(`Page ${customers_page_number_current} of ${customers_page_number_max}`);
        // enable/disable prev button
        customers_prev.prop("disabled", customers_page_number_current == 1);
        // enable/disable next button
        customers_next.prop("disabled", customers_page_number_current == customers_page_number_max);
        // enable search button
        customers_search_submit.prop("disabled", false);
    });

    jqxhr.fail(function(res){
        console.log(res);
    });
}
