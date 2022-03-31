var proforma_items = [];
var proforma_count = 0;

$(document).ready(function () {
    // console.log(proforma_items.length)
    // Create first <tr> for proforma items
    createproformaItemEntry()
});

function createproformaItemEntry() 
{
    proforma_count++;
    let inner = `
    <tr data-id="${proforma_count}" id="p_item_entry_${proforma_count}">
        <td>
            <div class="input-group">
                <input data-id="${proforma_count}" id="p_item_${proforma_count}" class="p_item" name='item[]'>
                <input type="hidden" name="item_id[]" value="">
            </div>
        </td>
        <td>
            <input type="number" id="p_item_quantity_${proforma_count}" class="form-control" name="quantity[]" placeholder="0" disabled>
        </td>
        <td>
            <input type="text" id="p_item_price_${proforma_count}" class="form-control inputPrice text-right" name="price[]" placeholder="0.00" disabled>
        </td>
        <td>
            <select id="p_item_tax_${proforma_count}" class="form-control" name="tax[]">
                <option>Sales Tax (15%)</option>
            </select>
        </td>
        <td>
            <input type="text" id="p_item_total_${proforma_count}" class="form-control text-right" name="total[]" placeholder="0.00" disabled>
        </td>
        <td>
            <button type="button" data-id="${proforma_count}" id="p_item_delete_${proforma_count}" class="btn btn-icon btn-danger p_item_delete" data-toggle="tooltip" data-placement="bottom" title="Delete">
                <span class="icon text-white-50">
                    <i class="fas fa-trash"></i>
                </span>
            </button>
            <button type="button" class="btn btn-small btn-icon btn-primary p_add_item_entry" data-toggle="tooltip" data-placement="bottom" title="Edit">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
            </button>
        </td>
    </tr>
    `

    $("#p_items").append(inner)

    let elm = document.querySelector(`#p_item_${proforma_count}`);
    let elm_tagify = new Tagify(elm, {
        tagTextProp: 'name', // very important since a custom template is used with this property as text
        enforceWhitelist: true,
        mode: "select",
        skipInvalid: false, // do not remporarily add invalid tags
        dropdown: {
            closeOnSelect: true,
            enabled: 0,
            classname: 'item-list',
            searchKeys: ['name', 'email'] // very important to set by which keys to search for suggesttions when typing
        },
        templates: {
            tag: ItemTagTemplate,
            dropdownItem: ItemSuggestionItemTemplate
        },
        whitelist: [],
        // whitelist: [
        //     {
        //         "value": 1,
        //         "name": "Justinian Hattersley",
        //         "avatar": "https://i.pravatar.cc/80?img=1",
        //         "email": "jhattersley0@ucsd.edu"
        //     },
        //     {
        //         "value": 2,
        //         "name": "Antons Esson",
        //         "avatar": "https://i.pravatar.cc/80?img=2",
        //         "email": "aesson1@ning.com"
        //     },
        // ]
    })

    elm_tagify.on('dropdown:show dropdown:updated', onproformaItemDropdownShow)
    elm_tagify.on('dropdown:select', onproformaItemSelectSuggestion)
    elm_tagify.on('input', onproformaItemInput)
    elm_tagify.on('remove', onproformaItemRemove)

    // Push item to array proforma_items
    let item_entry = {
        "entry_id": proforma_count,
        "tagify": elm_tagify,
        "price": 0,
        "value": null,
    }

    proforma_items.push(item_entry);
    console.log(proforma_items);
}
// add table row for proforma item
$(document).on('click', '.p_add_item_entry', function () {
    createproformaItemEntry()
})


$(document).on('click', '.p_item_delete', function (event) {
    console.log($(this)[0].dataset.id)
    removeproformaItemEntry( $(this)[0].dataset.id )
    console.log("Check if its successfully removed.");
    console.log(proforma_items);

    $(this).parents('tr').remove();

    if(proforma_items.length < 1)
    {
        console.log("No items left. Generating new one.");
        createproformaItemEntry();
    }
});




// var proforma_select_item_elm = document.querySelector('#p_item');

// initialize Tagify on the above input node reference
// var proforma_select_item_tagify = new Tagify(proforma_select_item_elm, {
//     tagTextProp: 'name', // very important since a custom template is used with this property as text
//     enforceWhitelist: true,
//     mode: "select",
//     skipInvalid: false, // do not remporarily add invalid tags
//     dropdown: {
//         closeOnSelect: true,
//         enabled: 0,
//         classname: 'item-list',
//         searchKeys: ['name', 'email'] // very important to set by which keys to search for suggesttions when typing
//     },
//     templates: {
//         tag: ItemTagTemplate,
//         dropdownItem: ItemSuggestionItemTemplate
//     },
//     whitelist: [],
    // whitelist: [
    //     {
    //         "value": 1,
    //         "name": "Justinian Hattersley",
    //         "avatar": "https://i.pravatar.cc/80?img=1",
    //         "email": "jhattersley0@ucsd.edu"
    //     },
    //     {
    //         "value": 2,
    //         "name": "Antons Esson",
    //         "avatar": "https://i.pravatar.cc/80?img=2",
    //         "email": "aesson1@ning.com"
    //     },
    // ]
// })

// proforma_select_item_tagify.on('dropdown:show dropdown:updated', onproformaItemDropdownShow)
// proforma_select_item_tagify.on('dropdown:select', onproformaItemSelectSuggestion)
// proforma_select_item_tagify.on('input', onproformaItemInput)
// proforma_select_item_tagify.on('remove', onproformaItemRemove)

// var addAllSuggestionsElm;

function onproformaItemDropdownShow(e) {
    console.log("onproformaItemDropdownShow")
    var dropdownContentElm = e.detail.proforma_select_item_tagify.DOM.dropdown.content;
}

function onproformaItemSelectSuggestion(e) {
    // console.log("onproformaItemSelectSuggestion")
    // // checks for data of selected customer
    // console.log("Checks for data of selected customer");
    // console.log(e.detail.data);
    // console.log(e.detail.data.value.toString());
    // value = e.detail.data.value;

    // // checks for data of selected element
    // console.log("Get selected element instance.");
    // console.log(e.detail.tagify);
    // tagify = e.detail.tagify;

    // NOT WORKING ATM
    // tagify.removeTags(value.toString(), false, 500)

    // checks proforma items if value already exists in the list. if so,
    // it won't be added.
    // console.log("Checks proforma items if value already exists in the list. If so, it won't be added.")
    // console.log(proforma_items)

    $(`#p_item_quantity_${proforma_count}`).val(e.detail.data.quantity)
    $(`#p_item_price_${proforma_count}`).val(e.detail.data.sale_price)
    $(`#p_item_total_${proforma_count}`).val(e.detail.data.sale_price * e.detail.data.quantity)
    // Add all item total to subtotal
    $('#p_sub_total').val(parseFloat($('#p_sub_total').val()) + parseFloat(e.detail.data.sale_price * e.detail.data.quantity))
    // Add all item total to grand_total
    $(`#p_grand_total`).val(parseFloat($(`#p_grand_total`).val()) + parseFloat(e.detail.data.sale_price * e.detail.data.quantity))

}

function onproformaItemRemove(e) {
    $(`#p_item_quantity_${proforma_count}`).val("")
    $(`#p_item_price_${proforma_count}`).val("")
    $(`#p_item_total_${proforma_count}`).val("0.00")
    $('#p_sub_total').val("0.00")
    $(`#p_grand_total`).val("0.00")


}

function onproformaItemInput(e) {
    console.log(e.detail);
    console.log(e.detail.tagify.DOM.originalInput.dataset.id)
    
    var entry_id = e.detail.tagify.DOM.originalInput.dataset.id
    var value = e.detail.value;
    var tagify;

    console.log(proforma_items);
    entry_obj = getproformaItemEntry(entry_id);
    // tagify = entry_obj.tagify;

    console.log("Obtained value from array");
    console.log(tagify);
    
    entry_obj.tagify.whitelist = null // reset the whitelist

    // https://developer.mozilla.org/en-US/docs/Web/API/AbortController/abort
    controller && controller.abort()
    controller = new AbortController()

    // show loading animation and hide the suggestions dropdown
    entry_obj.tagify.loading(true).dropdown.hide()

    fetch('/select/search/inventory/' + value, {
            signal: controller.signal
        })
        .then(RES => RES.json())
        .then(function (newWhitelist) {
            entry_obj.tagify.whitelist = newWhitelist // update whitelist Array in-place
            entry_obj.tagify.loading(false).dropdown.show(value) // render the suggestions dropdown
        })
}

function getproformaItemEntry(entry_id)
{
    for(let i = 0; i < proforma_items.length; i++)
    {
        if(proforma_items[i].entry_id == entry_id)
        {
            console.log("Found entry.");
            return proforma_items[i];
        }
    }   
    return undefined;
}

function removeproformaItemEntry(entry_id)
{
    for(let i = 0; i < proforma_items.length; i++)
    {
        if(proforma_items[i].entry_id == entry_id)
        {
            console.log("Removing entry " + entry_id);
            proforma_items.splice(i, 1);
            return true;
        }
    }   
    return false;
}