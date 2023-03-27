let deposits_fetch_url = "/ajax/customer/deposit/search";
let deposits_list = $("#deposits-list");
let deposits_prev = $("#deposits-prev");
let deposits_next = $("#deposits-next");
let deposits_search_input = $('#deposits-search-input');
let deposits_search_submit = $('#deposits-search-submit');
let deposits_page_number_label = $('#deposits-page-number-label');

let deposits_page_number_current = 1;
let deposits_page_number_max = 1;

$(document).ready(function(){
    deposits_search();
});

$(document).on('submit', '#deposits-search-form', function(e){
    e.preventDefault();
    // get input
    let query = deposits_search_input.val();
    deposits_search(query);
});

$(document).on('click', '#deposits-prev', function(e){
    e.preventDefault();
    // get input
    let query = deposits_search_input.val();
    deposits_search(query, deposits_page_number_current - 1);
});

$(document).on('click', '#deposits-next', function(e){
    e.preventDefault();
    // get input
    let query = deposits_search_input.val();
    deposits_search(query, deposits_page_number_current + 1);
});

function deposits_search(query = "", page = 1)
{
    console.log("deposits_search")
    deposits_page_number_current = 0;
    deposits_page_number_max = 0;
    deposits_list.html("");
    deposits_prev.prop("disabled", true);
    deposits_next.prop("disabled", true);
    deposits_search_submit.prop("disabled", true);
    deposits_page_number_label.text(`Page ${deposits_page_number_current} of ${deposits_page_number_max}`);

    const jqxhr = $.get({ url: `${deposits_fetch_url}/${query}?page=${page}` });
    jqxhr.done(function(res){
        console.log(res);

        if(res.deposits.data.length == 0)
        {
            let row = `
                <tr>
                    <td colspan="6" class="text-center">No deposits found.</td>
                </tr>
            `;
            deposits_list.append(row);
        }
        else
        {
            // populate deposits list
            for(let i = 0; i < res.deposits.data.length; i++)
            {
                let deposit = res.deposits.data[i];
                let row = `
                    <tr class="hoverable" data-href="/customers/deposits/${deposit.id}">
                        <td>${deposit.id}</td>
                        <td>${deposit.date}</td>
                        <td>${deposit.chart_of_account_no} - ${deposit.account_name}</td>
                        <td>
                            ${deposit.total_amount == deposit.total_void_amount
                                ? `<span class="badge badge-danger">Void</span>`
                                : deposit.void_amount > 0
                                    ? `<span class="badge badge-warning">Partially Void</span>`
                                    : `<span class="badge badge-success">Valid</span>`
                            }
                        </td>
                        <td class="text-right">${parseFloat(deposit.total_amount).toFixed(2)}</td>
                        <td class="actions">
                            <a href="/customers/deposits/${deposit.id}" class="btn btn-sm btn-primary">
                                <i class="fa fa-eye"></i>
                            </a>
                            <!-- <button id="mail-deposits-${deposit.id}" class="btn btn-primary btn-sm" data-type="deposits" data-id="${deposit.id}" data-action="print" data-page="deposits" disabled>
                                <span class="icon text-white-50">
                                    <i class="fas fa-print"></i>
                                </span>
                            </button> -->
                            <!-- <button id="mail-deposits-${deposit.id}" class="btn btn-primary btn-sm" data-type="deposits" data-id="${deposit.id}" data-action="mail" data-page="deposits" disabled>
                                <span class="icon text-white-50">
                                    <i class="fas fa-envelope"></i>
                                </span>
                            </button>-->
                        </td>
                    </tr>
                `;
                deposits_list.append(row);

                // focus input
                deposits_search_input.focus();
            }
        }




        // get max page number
        deposits_page_number_max = res.deposits.last_page;
        // get current page number
        deposits_page_number_current = res.deposits.current_page;
        // update page number label
        deposits_page_number_label.text(`Page ${deposits_page_number_current} of ${deposits_page_number_max}`);
        // enable/disable prev button
        deposits_prev.prop("disabled", deposits_page_number_current == 1);
        // enable/disable next button
        deposits_next.prop("disabled", deposits_page_number_current == deposits_page_number_max);
        // enable search button
        deposits_search_submit.prop("disabled", false);
    });

    jqxhr.fail(function(res){
        console.log(res);
    });
}
