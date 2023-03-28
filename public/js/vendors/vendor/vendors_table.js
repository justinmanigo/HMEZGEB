let vendors_fetch_url = "/ajax/vendors/vendor/search";
let vendors_list = $("#vendors-list");
let vendors_prev = $("#vendors-prev");
let vendors_next = $("#vendors-next");
let vendors_search_input = $('#vendors-search-input');
let vendors_search_submit = $('#vendors-search-submit');
let vendors_page_number_label = $('#vendors-page-number-label');

let vendors_page_number_current = 1;
let vendors_page_number_max = 1;

$(document).ready(function(){
    vendors_search();
});

$(document).on('submit', '#vendors-search-form', function(e){
    e.preventDefault();
    // get input
    let query = vendors_search_input.val();
    vendors_search(query);
});

$(document).on('click', '#vendors-prev', function(e){
    e.preventDefault();
    // get input
    let query = vendors_search_input.val();
    vendors_search(query, vendors_page_number_current - 1);
});

$(document).on('click', '#vendors-next', function(e){
    e.preventDefault();
    // get input
    let query = vendors_search_input.val();
    vendors_search(query, vendors_page_number_current + 1);
});

function vendors_search(query = "", page = 1)
{
    console.log("vendors_search")
    vendors_page_number_current = 0;
    vendors_page_number_max = 0;
    vendors_list.html("");
    vendors_prev.prop("disabled", true);
    vendors_next.prop("disabled", true);
    vendors_search_submit.prop("disabled", true);
    vendors_page_number_label.text(`Page ${vendors_page_number_current} of ${vendors_page_number_max}`);

    const jqxhr = $.get({ url: `${vendors_fetch_url}/${query}?page=${page}` });
    jqxhr.done(function(res){
        console.log(res);

        if(res.vendors.data.length == 0)
        {
            let row = `
                <tr>
                    <td colspan="5" class="text-center">No vendors found.</td>
                </tr>
            `;
            vendors_list.append(row);
        }
        else
        {
            // populate vendors list
            for(let i = 0; i < res.vendors.data.length; i++)
            {
                /** to add later: partially void, fully void */
                let vendor = res.vendors.data[i];
                let row = `
                    <tr class="hoverable" data-href="#">
                        <td>${vendor.id}</td>
                        <td>${vendor.name}<small class="badge badge-primary ml-2" style="font-weight:400!important">${vendor.label}</small></td>
                        <td>${vendor.tin_number}</td>
                        <td class="text-right">${parseFloat(vendor.balance.balance).toFixed(2)}</td>
                        <td class="actions">
                            <!--<a href="#" class="btn btn-sm btn-primary disabled">
                                <i class="fa fa-eye"></i>
                            </a>-->
                            <a href="/vendors/vendors/${vendor.id}/edit" class="btn btn-sm btn-primary">
                                <i class="fa fa-pen"></i>
                            </a>
                            <button id="mail-vendors-${vendor.id}" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-print" data-type="vendors" data-id="${vendor.id}" data-action="print" data-page="vendors">
                                <span class="icon text-white-50">
                                    <i class="fas fa-print"></i>
                                </span>
                            </button>
                            <button id="mail-vendors-${vendor.id}" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-statement" data-type="vendors" data-id="${vendor.id}" data-action="mail" data-page="vendors">
                                <span class="icon text-white-50">
                                    <i class="fas fa-envelope"></i>
                                </span>
                            </button>
                        </td>
                    </tr>
                `;
                vendors_list.append(row);

                // focus input
                vendors_search_input.focus();
            }
        }




        // get max page number
        vendors_page_number_max = res.vendors.last_page;
        // get current page number
        vendors_page_number_current = res.vendors.current_page;
        // update page number label
        vendors_page_number_label.text(`Page ${vendors_page_number_current} of ${vendors_page_number_max}`);
        // enable/disable prev button
        vendors_prev.prop("disabled", vendors_page_number_current == 1);
        // enable/disable next button
        vendors_next.prop("disabled", vendors_page_number_current == vendors_page_number_max);
        // enable search button
        vendors_search_submit.prop("disabled", false);
    });

    jqxhr.fail(function(res){
        console.log(res);
    });
}
