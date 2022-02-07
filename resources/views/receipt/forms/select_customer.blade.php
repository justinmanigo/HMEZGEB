<form id="form-select-customer" method="post" enctype="multipart/form-data">

    <div class="form-group row">
        <div class="input-group col-12">
            <div class="input-group-prepend">
                <input type="text" id="sc_search_query" class="form-control" placeholder="John Doe" name="search_query">
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
                <td>Customer Name</td>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <input type="radio" name="sc_customer" id="sc_customer_1" value="1">
                    </td>
                    <td><label for="sc_customer_1">PocketDevs</label></td>
                </tr>
                <tr>
                    <td>
                        <input type="radio" name="sc_customer" id="sc_customer_2" value="2">
                    </td>
                    <td><label for="sc_customer_2">Fullstack HQ</label></td>
                </tr>
            </tbody>
        </table>
    </div>

</form>