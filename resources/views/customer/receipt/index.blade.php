@extends('template.index')

@push('styles')
    <style>
        .table-item-content { 
        /** Equivalent to pt-3 */
        padding-top:1rem!important;
        }

        .thead-actions {
            /** Fixed width, increase if adding addt. buttons **/
            width:120px;
        }
        .content-card {
            border-radius:0px 0px 5px 5px;
        }

        .inputPrice::-webkit-inner-spin-button, .inputTax::-webkit-inner-spin-button,
        .inputPrice::-webkit-outer-spin-button, .inputTax::-webkit-outer-spin-button {
            -webkit-appearance: none; 
            margin: 0; 
        }

        input[type="checkbox"], label {
            cursor: pointer;
        }

        /*
            TEMPORARY
        */
        /* Suggestions items */
        .tagify__dropdown.customers-list .tagify__dropdown__item{
            padding: .5em .7em;
            display: grid;
            grid-template-columns: auto 1fr;
            gap: 0 1em;
            grid-template-areas: "avatar name"
                                "avatar email";
        }

        .tagify__dropdown.customers-list .tagify__dropdown__item:hover .tagify__dropdown__item__avatar-wrap{
            transform: scale(1.2);
        }

        .tagify__dropdown.customers-list .tagify__dropdown__item__avatar-wrap{
            grid-area: avatar;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            overflow: hidden;
            background: #EEE;
            transition: .1s ease-out;
        }

        .tagify__dropdown.customers-list img{
            width: 100%;
            vertical-align: top;
        }

        .tagify__dropdown.customers-list strong{
            grid-area: name;
            width: 100%;
            align-self: center;
        }

        .tagify__dropdown.customers-list span{
            grid-area: email;
            width: 100%;
            font-size: .9em;
            opacity: .6;
        }

        .tagify__dropdown.customers-list .addAll{
            border-bottom: 1px solid #DDD;
            gap: 0;
        }


        /* Tags items */
         .tagify__tag{
            white-space: nowrap;
        }

         .tagify__tag:hover .tagify__tag__avatar-wrap{
            transform: scale(1.6) translateX(-10%);
        }

         .tagify__tag .tagify__tag__avatar-wrap{
            width: 16px;
            height: 16px;
            white-space: normal;
            border-radius: 50%;
            background: silver;
            margin-right: 5px;
            transition: .12s ease-out;
        }

         .tagify__tag img{
            width: 100%;
            vertical-align: top;
            pointer-events: none;
        }
    </style>

    <script src="https://unpkg.com/@yaireo/tagify"></script>
    <script src="https://unpkg.com/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
    <link href="https://unpkg.com/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
@endpush

@section('content')

<div class="row">

    {{-- Main Content Section --}}
    <div class="col-xl-10 col-lg-9 col-12">
        {{-- Button Group Navigation --}}
        <div class="btn-group mb-3" role="group" aria-label="Button group with nested dropdown">
            <div class="btn-group" role="group">
                <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="icon text-white-50">
                        <i class="fas fa-pen"></i>
                    </span>
                    <span class="text">New</span>
                </button>
                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                    <a role="button" class="dropdown-item" data-toggle="modal" data-target="#modal-receipt">Receipt</a>
                    <a role="button" class="dropdown-item" data-toggle="modal" data-target="#modal-advance-revenue">Advance Revenue</a>
                    <a role="button" class="dropdown-item" data-toggle="modal" data-target="#modal-credit-receipt">Credit Receipt</a>
                    <a role="button" class="dropdown-item" data-toggle="modal" data-target="#modal-proforma">Proforma</a>
                </div>
            </div>
            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modal-import">
                <span class="icon text-white-50">
                    <i class="fas fa-file-import"></i>
                </span>
                <span class="text">Import</span>
            </button>
            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modal-export">
                <span class="icon text-white-50">
                    <i class="fas fa-download"></i>
                </span>
                <span class="text">Export</span>
            </button>
            <button type="button" class="btn btn-secondary">
                <span class="icon text-white-50">
                    <i class="fas fa-download"></i>
                </span>
                <span class="text">Download Excel Format</span>
            </button>    
        </div>

        {{-- Tab Navigation --}}
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="transactions-tab" data-toggle="tab" href="#transactions" role="tab" aria-controls="transactions" aria-selected="true">Transactions</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="proforma-tab" data-toggle="tab" href="#proforma" role="tab" aria-controls="proforma" aria-selected="false">Proforma</a>
            </li>
        </ul>

        {{-- Tab Contents --}}
        <div class="card" class="content-card">
            <div class="card-body tab-content" id="myTabContent">
                {{-- Transaction Contents --}}
                <div class="tab-pane fade show active" id="transactions" role="tabpanel" aria-labelledby="transactions-tab">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTables" width="100%" cellspacing="0">
                            <thead>
                                <th id="thead-actions">Actions</th>
                                <th>Date</th>
                                <th>Reference #</th>
                                <th>Type</th>
                                <th>Customer Name</th>
                                <th>Status</th>
                                <th>Amount</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <button type="button" class="btn btn-small btn-icon btn-primary" data-toggle="tooltip" data-placement="bottom" title="Edit">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-pen"></i>
                                            </span>
                                        </button>
                                        <button type="button" class="btn btn-small btn-icon btn-danger" data-toggle="tooltip" data-placement="bottom" title="Delete">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-trash"></i>
                                            </span>
                                        </button>
                                    </td>
                                    <td class="table-item-content">02-Mar-2022</td>
                                    <td class="table-item-content">Fs#10107</td>
                                    <td class="table-item-content"><span class="badge badge-success">Receipt</span></td>
                                    <td class="table-item-content">PocketDevs</td>
                                    <td class="table-item-content"><span class="badge badge-success">Paid</span></td>
                                    <td class="table-item-content">1,000.00</td>
                                </tr>
                                <tr>
                                    <td>
                                        <button type="button" class="btn btn-small btn-icon btn-primary" data-toggle="tooltip" data-placement="bottom" title="Edit">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-pen"></i>
                                            </span>
                                        </button>
                                        <button type="button" class="btn btn-small btn-icon btn-danger" data-toggle="tooltip" data-placement="bottom" title="Delete">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-trash"></i>
                                            </span>
                                        </button>
                                    </td>
                                    <td class="table-item-content">02-Mar-2022</td>
                                    <td class="table-item-content">Fs#10107</td>
                                    <td class="table-item-content"><span class="badge badge-danger">Credit Receipt</span></td>
                                    <td class="table-item-content">PocketDevs</td>
                                    <td class="table-item-content"><span class="badge badge-danger">Unpaid</span></td>
                                    <td class="table-item-content">1,000.00</td>
                                </tr>
                                <tr>
                                    <td>
                                        <button type="button" class="btn btn-small btn-icon btn-primary" data-toggle="tooltip" data-placement="bottom" title="Edit">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-pen"></i>
                                            </span>
                                        </button>
                                        <button type="button" class="btn btn-small btn-icon btn-danger" data-toggle="tooltip" data-placement="bottom" title="Delete">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-trash"></i>
                                            </span>
                                        </button>
                                    </td>
                                    <td class="table-item-content">02-Mar-2022</td>
                                    <td class="table-item-content">Fs#10107</td>
                                    <td class="table-item-content"><span class="badge badge-primary">Advance Receipt</span></td>
                                    <td class="table-item-content">PocketDevs</td>
                                    <td class="table-item-content"><span class="badge badge-warning">Partially Paid</span></td>
                                    <td class="table-item-content">1,000.00</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- Proforma Contents --}}
                <div class="tab-pane fade" id="proforma" role="tabpanel" aria-labelledby="proforma-tab">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTables2" width="100%" cellspacing="0">
                            <thead>
                                <th id="thead-actions">Actions</th>
                                <th>Date</th>
                                <th>Reference #</th>
                                <th>Customer Name</th>
                                <th>Amount</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <button type="button" class="btn btn-small btn-icon btn-primary" data-toggle="tooltip" data-placement="bottom" title="Edit">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-pen"></i>
                                            </span>
                                        </button>
                                        <button type="button" class="btn btn-small btn-icon btn-danger" data-toggle="tooltip" data-placement="bottom" title="Delete">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-trash"></i>
                                            </span>
                                        </button>
                                    </td>
                                    <td class="table-item-content">02-Mar-2022</td>
                                    <td class="table-item-content">Fs#10107</td>
                                    <td class="table-item-content">PocketDevs</td>
                                    <td class="table-item-content">1,000.00</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Sidebar Content --}}
    <div class="col-xl-2 col-lg-3 d-none d-lg-block">
        <h4 class="">Account Receivable</h4>
        {{-- Account Receivable Active --}}
        <div class="mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Birr 40,000</div>
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                2 Active</div>
                        </div>
                        <div class="col-auto">
                            {{-- <i class="fas fa-dollar-sign fa-2x text-gray-300"></i> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Account Receivable Overdue --}}
        <div class="mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Birr 215,000</div>
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                5 Over Due</div>
                        </div>
                        <div class="col-auto">
                            {{-- <i class="fas fa-dollar-sign fa-2x text-gray-300"></i> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>



{{-- Modals --}}

{{-- 
    KNOWN POTENTIAL PROBLEMS:
    > Modal Contents have similar IDs for its contents.
    POTENTIAL SOLUTIONS:
    > Update form on button click via JS.
--}}

{{-- New Receipt --}}
<div class="modal fade" id="modal-receipt" tabindex="-1" role="dialog" aria-labelledby="modal-receipt-label" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-receipt-label">New Receipt</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @include('customer.receipt.forms.receipt')
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" form="form-receipt">Save Receipt</button>
            </div>
        </div>
    </div>
</div>

{{-- New Advance Revenue --}}
<div class="modal fade" id="modal-advance-revenue" tabindex="-1" role="dialog" aria-labelledby="modal-advance-revenue-label" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-advance-revenue-label">New Advance Revenue</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @include('customer.receipt.forms.advance_revenue')
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" form="form-advance-revenue">Save Advance Revenue</button>
            </div>
        </div>
    </div>
</div>

{{-- New Credit Receipt --}}
<div class="modal fade" id="modal-credit-receipt" tabindex="-1" role="dialog" aria-labelledby="modal-credit-receipt-label" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-credit-receipt-label">New Credit Receipt</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @include('customer.receipt.forms.credit_receipt')
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" form="form-credit-receipt">Save Credit Receipt</button>
            </div>
        </div>
    </div>
</div>

{{-- New Proforma --}}
<div class="modal fade" id="modal-proforma" tabindex="-1" role="dialog" aria-labelledby="modal-proforma-label" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-proforma-label">New Proforma</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @include('customer.receipt.forms.proforma')
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" form="form-proforma">Save Proforma</button>
            </div>
        </div>
    </div>
</div>

{{-- Import --}}
<div class="modal fade" id="modal-import" tabindex="-1" role="dialog" aria-labelledby="modal-import-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-import-label">Import Receipts</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-import" method="post" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label for="i_file" class="col-sm-4 col-form-label">File<span class="text-danger ml-1">*</span></label>
                        <div class="col-sm-8">
                            <input type="file" id="i_file" name="file" class="mt-1" required>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="form-import">Import Receipts</button>
            </div>
        </div>
    </div>
</div>

{{-- Export --}}
<div class="modal fade" id="modal-export" tabindex="-1" role="dialog" aria-labelledby="modal-export-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-export-label">Export Receipts</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-export" method="post" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label for="e_file_type" class="col-sm-4 col-form-label">File Type<span class="text-danger ml-1">*</span></label>
                        <div class="col-sm-8">
                            <select class="form-control" id="e_file_type" name="file_type" required>
                                <option>HTML</option>
                                <option>PDF</option>
                                <option>CSV</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="form-export">Export Receipts</button>
            </div>
        </div>
    </div>
</div>

{{-- STACK 2 > Select Customer --}}
{{-- To be planned carefully on how can this be implemented across 4 receipt types/modals. --}}
<div class="modal fade" id="modal-select-customer" tabindex="-1" role="dialog" aria-labelledby="modal-receipt-label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-receipt-label">Select Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @include('customer.receipt.forms.select_customer')
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="sc_btn_select_customer">Select Customer</button>
            </div>
        </div>
    </div>
</div>

{{-- STACK 2 > Select Item (Inventory) --}}
{{-- To be planned carefully on how can this be implemented across 3 receipt types/modals. --}}
<div class="modal fade" id="modal-select-item" tabindex="-1" role="dialog" aria-labelledby="modal-receipt-label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-receipt-label">Select Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @include('customer.receipt.forms.select_item')
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="si_btn_select_item">Select Item</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#dataTables').DataTable();
        $('#dataTables2').DataTable();
        $('.dataTables_filter').addClass('pull-right');
    });
    // https://www.mockaroo.com/


    var inputElm = document.querySelector('input[name=customer]');
    var customer_id;

    function tagTemplate(tagData){
        return `
            <tag title="${tagData.email}"
                    contenteditable='false'
                    spellcheck='false'
                    tabIndex="-1"
                    class="tagify__tag ${tagData.class ? tagData.class : ""}"
                    ${this.getAttributes(tagData)}>
                <x title='' class='tagify__tag__removeBtn' role='button' aria-label='remove tag'></x>
                <div>
                    <div class='tagify__tag__avatar-wrap'>
                        <img onerror="this.style.visibility='hidden'" src="${tagData.avatar}">
                    </div>
                    <span class='tagify__tag-text'>${tagData.name}</span>
                </div>
            </tag>
        `
    }

    function suggestionItemTemplate(tagData){
        return `
            <div ${this.getAttributes(tagData)}
                class='tagify__dropdown__item ${tagData.class ? tagData.class : ""}'
                tabindex="0"
                role="option">
                ${ tagData.avatar ? `
                <div class='tagify__dropdown__item__avatar-wrap'>
                    <img onerror="this.style.visibility='hidden'" src="${tagData.avatar}">
                </div>` : ''
                }
                <strong>${tagData.name}</strong>
                <span>${tagData.email}</span>
            </div>
        `
    }

    // initialize Tagify on the above input node reference
    var tagify = new Tagify(inputElm, {
        tagTextProp: 'name', // very important since a custom template is used with this property as text
        enforceWhitelist: true,
        mode : "select",
        skipInvalid: false, // do not remporarily add invalid tags
        dropdown: {
            closeOnSelect: true,
            enabled: 0,
            classname: 'customers-list',
            searchKeys: ['name', 'email']  // very important to set by which keys to search for suggesttions when typing
        },
        templates: {
            tag: tagTemplate,
            dropdownItem: suggestionItemTemplate
        },
        whitelist: [
            {
                "value": 1,
                "name": "Justinian Hattersley",
                "avatar": "https://i.pravatar.cc/80?img=1",
                "email": "jhattersley0@ucsd.edu"
            },
            {
                "value": 2,
                "name": "Antons Esson",
                "avatar": "https://i.pravatar.cc/80?img=2",
                "email": "aesson1@ning.com"
            },
            {
                "value": 3,
                "name": "Ardeen Batisse",
                "avatar": "https://i.pravatar.cc/80?img=3",
                "email": "abatisse2@nih.gov"
            },
            {
                "value": 4,
                "name": "Graeme Yellowley",
                "avatar": "https://i.pravatar.cc/80?img=4",
                "email": "gyellowley3@behance.net"
            },
            {
                "value": 5,
                "name": "Dido Wilford",
                "avatar": "https://i.pravatar.cc/80?img=5",
                "email": "dwilford4@jugem.jp"
            },
            {
                "value": 6,
                "name": "Celesta Orwin",
                "avatar": "https://i.pravatar.cc/80?img=6",
                "email": "corwin5@meetup.com"
            },
            {
                "value": 7,
                "name": "Sally Main",
                "avatar": "https://i.pravatar.cc/80?img=7",
                "email": "smain6@techcrunch.com"
            },
            {
                "value": 8,
                "name": "Grethel Haysman",
                "avatar": "https://i.pravatar.cc/80?img=8",
                "email": "ghaysman7@mashable.com"
            },
            {
                "value": 9,
                "name": "Marvin Mandrake",
                "avatar": "https://i.pravatar.cc/80?img=9",
                "email": "mmandrake8@sourceforge.net"
            },
            {
                "value": 10,
                "name": "Corrie Tidey",
                "avatar": "https://i.pravatar.cc/80?img=10",
                "email": "ctidey9@youtube.com"
            },
            {
                "value": 11,
                "name": "foo",
                "avatar": "https://i.pravatar.cc/80?img=11",
                "email": "foo@bar.com"
            },
            {
                "value": 12,
                "name": "foo",
                "avatar": "https://i.pravatar.cc/80?img=12",
                "email": "foo.aaa@foo.com"
            },
        ]
    })

    tagify.on('dropdown:show dropdown:updated', onDropdownShow)
    tagify.on('dropdown:select', onSelectSuggestion)

    var addAllSuggestionsElm;

    function onDropdownShow(e){
        var dropdownContentElm = e.detail.tagify.DOM.dropdown.content;

        // if( tagify.suggestedListItems.length > 1 ){
            // addAllSuggestionsElm = getAddAllSuggestionsElm();

            // insert "addAllSuggestionsElm" as the first element in the suggestions list
            // dropdownContentElm.insertBefore(addAllSuggestionsElm, dropdownContentElm.firstChild)
        // }
    }

    function onSelectSuggestion(e){
        // to get id of value
        console.log(e.detail.data.value);
        customer_id = e.detail.data.value;

        // you can call ajax to get the customer data
    }

    // create a "add all" custom suggestion element every time the dropdown changes
    // function getAddAllSuggestionsElm(){
    //     // suggestions items should be based on "dropdownItem" template
    //     return tagify.parseTemplate('dropdownItem', [{
    //             class: "addAll",
    //             name: "Add all",
    //             email: tagify.whitelist.reduce(function(remainingSuggestions, item){
    //                 return tagify.isTagDuplicate(item.value) ? remainingSuggestions : remainingSuggestions + 1
    //             }, 0) + " Members"
    //         }]
    //     )
    // }
</script>

@endsection