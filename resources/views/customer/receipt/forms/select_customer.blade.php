
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
                @foreach($customers as $customer)
                <tr>
                    <td>
                        <input type="radio" name="id" id="sc_customers" value="{{$customer->id}}">
                    </td>
                    <td><label for="sc_customers">{{$customer->name}} </label></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
