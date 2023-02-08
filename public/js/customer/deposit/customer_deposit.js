var elm_d_bank_account = document.querySelector("#d_bank_account");
counter = 0;
// initialize Tagify on the above input node reference
var tagify_d_bank_account = new Tagify(elm_d_bank_account, {
    tagTextProp: "account_name", // very important since a custom template is used with this property as text
    enforceWhitelist: true,
    mode: "select",
    skipInvalid: false, // do not remporarily add invalid tags
    dropdown: {
        closeOnSelect: true,
        enabled: 0,
        classname: "bank-list",
        searchKeys: [
            "account_name",
            "bank_account_number",
            "bank_branch",
            "chart_of_account_no",
        ], // very important to set by which keys to search for suggesttions when typing
    },
    templates: {
        tag: bankTagTemplate,
        dropdownItem: bankSuggestionItemTemplate,
    },
    whitelist: [],
    // whitelist: [
    //     {
    //         "value": 1,
    //         "name": "Justinian Hattersley",
    //         "avatar": "https://i.pravatar.cc/80?img=1",
    //         "email": "jhattersley0@ucsd.edu"
    //     },
    // ]
});

// tagify_d_bank_account.on("dropdown:select", onBankSelectSuggestion);
tagify_d_bank_account.on("input", onBankInput);

function createRecordsToDeposit(f) {
    console.log(f);
    // counter for ids

    counter++;

    // tr template
    let inner = `
     <tr data-id="${counter}" id="b_item_entry_${counter}">
        <td>${f.date}</td>
        <td>
            ${f.receipt_type == "receipt" ? `Receipt for <b>${f.customer_name}</b>` : `Sale`}
        </td>
        <td>${f.receipt_type == "receipt" ? f.payment_method : "cash"}</td>
        <td>${f.value}</td>
        <td class="text-right">Birr ${parseFloat(f.total_amount_received).toFixed(2)}</td>
        <td>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" onchange="handleCheck(this,'${f.receipt_type == "receipt" ? f.payment_method : "cash"}',${f.total_amount_received})" id="${f.value}" name="is_deposited[]" value="${f.value}">
            </div>
        </td>
    </tr>
     `;
    // append to table
    $("#deposit-list").append(inner);
}

function getReceipts() {
    $("#deposit-list").empty();
    // Get data from server.
    var request = $.ajax({
        url: "/ajax/customer/deposit/receipts/undeposited/get",
        method: "GET",
    });

    request.done(function (res, status, jqXHR) {
        console.log(res);
        for (i = 0; i < res.length; i++) {
            createRecordsToDeposit(res[i]);
        }
    });

    request.fail(function (jqXHR, status, error) {
        console.log(error);
    });
}

function onBankInput(e) {
    var value = e.detail.value;
    tagify_d_bank_account.whitelist = null; // reset the whitelist

    // https://developer.mozilla.org/en-US/docs/Web/API/AbortController/abort
    controller && controller.abort();
    controller = new AbortController();

    // show loading animation and hide the suggestions dropdown
    tagify_d_bank_account.loading(true).dropdown.hide();

    fetch("/ajax/customer/deposit/bank/search/" + value, {
        signal: controller.signal,
    })
        .then((RES) => RES.json())
        .then(function (newWhitelist) {
            tagify_d_bank_account.whitelist = newWhitelist; // update whitelist Array in-place
            tagify_d_bank_account.loading(false).dropdown.show(value); // render the suggestions dropdown
        });
}
// checking if checkbox is checked and compute total amount
totalAmount = 0;
function handleCheck(checkbox, paymentMethod, totalAmountReceived) {
    if (checkbox.checked) {
        if (paymentMethod == "cash") {
            totalAmount += totalAmountReceived;
            $("#d_total_cash").val(`Birr ${parseFloat(totalAmount).toFixed(2)}`);
        }
        else if (paymentMethod == "cheque") {
            totalAmount += totalAmountReceived;
            $("#d_total_cheque").val(`Birr ${parseFloat(totalAmount).toFixed(2)}`);
        }
        else{
            totalAmount += totalAmountReceived;
            $("#d_total_other").val(`Birr ${parseFloat(totalAmount).toFixed(2)}`);
        }
        $("#d_total_deposit").val(`Birr ${parseFloat(totalAmount).toFixed(2)}`);
    } 
    else {
        if (paymentMethod == "cash") {
            totalAmount -= totalAmountReceived;
            $("#d_total_cash").val(`Birr ${parseFloat(totalAmount).toFixed(2)}`);
        }
        else if (paymentMethod == "cheque") {
            totalAmount -= totalAmountReceived;
            $("#d_total_cheque").val(`Birr ${parseFloat(totalAmount).toFixed(2)}`);
        }
        else{
            totalAmount -= totalAmountReceived;
            $("#d_total_other").val(`Birr ${parseFloat(totalAmount).toFixed(2)}`);
        }
        $("#d_total_deposit").val(`Birr ${parseFloat(totalAmount).toFixed(2)}`);
    }
}

$("#modal-deposit-button").click(function () {
    getReceipts();
})