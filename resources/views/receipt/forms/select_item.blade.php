<form id="form-select-item" method="post" enctype="multipart/form-data">

    <div class="form-group row">
        <div class="input-group col-12">
            <div class="input-group-prepend">
                <input type="text" id="sc_search_query" class="form-control" placeholder="Product Name" name="search_query">
            </div>
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit" id="sc_btn_search">Search</button>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <td style="width:20px"></td>
                <td>Item Name</td>
                <td>Price</td>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <input type="radio" name="si_item" id="si_item_1" value="1">
                    </td>
                    <td><label for="si_item_1">Website Design</label></td>
                    <td><label for="si_item_2">Birr 8,000.00</label></td>
                </tr>
                <tr>
                    <td>
                        <input type="radio" name="si_item" id="si_item_2" value="2">
                    </td>
                    <td><label for="si_item_2">Mobile Application</label></td>
                    <td><label for="si_item_2">Birr 40,000.00</label></td>
                </tr>
            </tbody>
        </table>
    </div>

</form>