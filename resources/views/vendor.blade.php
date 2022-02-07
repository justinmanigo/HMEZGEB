@extends('template.index')

@push('styles')
 {{-- <link rel="stylesheet" href="{{asset('css/.css')}}" /> --}}
 
@endpush

@section('content')

<div class="wrapper">

<div class="d-sm-flex align-items-start justify-content-between mb-2">
    <h1 class="h3 mb-0 text-gray-800">Vendors</h1>

        <div class="col-xl-3 col-md-6 mb-4 border-1">
        <div class="card border-left-primary shadow h-100 pt-2">
            <div class="col mr-2">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1 text-center">
                Account Payable 
                </div>
            </div>
            <div class="card-body">
                <div class="row no-gutters d-flex align-items-center justify-content-around">
                        <div class="h6 mb-0">
                           <span class="font-weight-bold text-gray-800">$40,000</span><br>
                           <small>Active</small>
                        </div>
                        <div class="h6 mb-0">
                           <span class="font-weight-bold text-danger">$3,500</span><br>
                           <small>Over Due</small>
                        </div>
                </div>
            </div>
        </div>
    </div>
<!--sample comment--->
</div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex align-items-center  justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary pr-3">List of Vendors</h6>

    <!--------BUTTONS---->
    <div class="d-flex justify-content-around">
    <!--------add vendor modal---->
        <div id="contact"><button type="button" class="btn btn-info btn" data-toggle="modal" data-target="#contact-modal">Add vendor</button></div>
        <div id="contact-modal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header d-flex">
                        <h3>Add Vendor</h3>
                        <a class="close" data-dismiss="modal">×</a>
                    </div>
                    <form id="contactForm" name="contact" role="form">
                        <div class="modal-body h6">				
                            <div class="form-group">
                                <label for="name">Vendor name:</label>
                                <input type="text" name="name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="email">Address:</label>
                                <input type="text" name="address" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="email">City:</label>
                                <input type="text" name="city" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="email">Country:</label>
                                <input type="text" name="country" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="email">TIN number:</label>
                                <input type="text" name="tinNum" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="email">Phone number 1:</label>
                                <input type="text" name="phone1" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="email">Phone number 2:</label>
                                <input type="text" name="phone2" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="email">FAX:</label>
                                <input type="text" name="fax" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="email">Mobile number:</label>
                                <input type="text" name="mobile_num" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="email">Contact Person:</label>
                                <input type="text" name="contact_person" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" name="email" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="email">Website:</label>
                                <input type="text" name="website" class="form-control">
                            </div>
                            {{-- <div class="form-group">
                                <label for="message">Message</label>
                                <textarea name="message" class="form-control"></textarea>
                            </div>					 --}}
                        </div>
                        <div class="modal-footer">					
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-success" id="submit">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <!--------end of add vendor modal---->
    <div id="contact"><button type="button" class="btn btn-info btn mx-1" data-toggle="modal" data-target="#import">Import</button></div>
    <div id="contact"><button type="button" class="btn btn-info btn mx-1" data-toggle="modal" data-target="#import">Export</button></div>
    <div id="contact"><button type="button" class="btn btn-info btn mx-1" data-toggle="modal" data-target="#import">Download file</button></div>
    </div>         
</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" style="width: 100%" id="dataTables" cellspacing="100">
                    <thead>
                        <tr>
                            <th>VendorID</th>
                            <th>Vendor Name</th>
                            <th>TIN No.</th>
                            <th>Address</th>
                            <th>Contact Person</th>
                            <th>Phone No.</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>VendorID</th>
                            <th>Vendor Name</th>
                            <th>TIN No.</th>
                            <th>Address</th>
                            <th>Contact Person</th>
                            <th>Phone No.</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <tr>
                            <td>0001</td>
                            <td>PocketDevs</td>
                            <td>123523765</td>
                            <td>Cebu City, Philippines</td>
                            <td>Justin Manigo</td>
                            <td>09208765910</td>
                        </tr>
                        <tr>
                            <td>0002</td>
                            <td>Pocketteams</td>
                            <td>053678123</td>
                            <td>Brgy. Langkiwa, Binan City, Laguna</td>
                            <td>Lester Fong</td>
                            <td>09124561120</td>
                        </tr>
                        <tr>
                            <td>0003</td>
                            <td>Aircon Supplier</td>
                            <td>012354323</td>
                            <td>66</td>
                            <td>2009/01/12</td>
                            <td>$86,000</td>
                        </tr>
                        <tr>
                            <td>0004</td>
                            <td>Globe Telco.</td>
                            <td>071437625</td>
                            <td>22</td>
                            <td>2012/03/29</td>
                            <td>$433,060</td>
                        </tr>
                        <tr>
                            <td>0005</td>
                            <td>Meralco</td>
                            <td>067853123</td>
                            <td>33</td>
                            <td>2008/11/28</td>
                            <td>$162,700</td>
                        </tr>
                        <tr>
                            <td>0006</td>
                            <td>Tiktok</td>
                            <td>068234765</td>
                            <td>61</td>
                            <td>2012/12/02</td>
                            <td>$372,000</td>
                        </tr>
                        <tr>
                            <td>0007</td>
                            <td>Mcdonals</td>
                            <td>056123654</td>
                            <td>59</td>
                            <td>2012/08/06</td>
                            <td>$137,500</td>
                        </tr>
                        <tr>
                            <td>0008</td>
                            <td>Mang Inasar</td>
                            <td>023476523</td>
                            <td>55</td>
                            <td>2010/10/14</td>
                            <td>$327,900</td>
                        </tr>
                        <tr>
                            <td>0007</td>
                            <td>Jollibee</td>
                            <td>067834215</td>
                            <td>39</td>
                            <td>2009/09/15</td>
                            <td>$205,500</td>
                        </tr>
                        <tr>
                            <td>0008</td>
                            <td>Chooks To Go</td>
                            <td>165235643</td>
                            <td>23</td>
                            <td>2008/12/13</td>
                            <td>$103,600</td>
                        </tr>
                        <tr>
                            <td>0009</td>
                            <td>Angels burger</td>
                            <td>634123862</td>
                            <td>30</td>
                            <td>2008/12/19</td>
                            <td>$90,560</td>
                        </tr>
                        <tr>
                            <td>0010</td>
                            <td>Aircon Supplier</td>
                            <td>034568722</td>
                            <td>22</td>
                            <td>2013/03/03</td>
                            <td>$342,000</td>
                        </tr>
                        <tr>
                            <td>0011</td>
                            <td>Google</td>
                            <td>078236542</td>
                            <td>36</td>
                            <td>2008/10/16</td>
                            <td>$470,600</td>
                        </tr>
                        <tr>
                            <td>00127</td>
                            <td>Senior Marketing Designer</td>
                            <td>078923123</td>
                            <td>43</td>
                            <td>2012/12/18</td>
                            <td>$313,500</td>
                        </tr>
                        <tr>
                            <td>0013</td>
                            <td>Regional Director</td>
                            <td>543123876</td>
                            <td>19</td>
                            <td>2010/03/17</td>
                            <td>$385,750</td>
                        </tr>
                        <tr>
                            <td>0014</td>
                            <td>Marketing Designer</td>
                            <td>194234756</td>
                            <td>66</td>
                            <td>2012/11/27</td>
                            <td>$198,500</td>
                        </tr>
                        <tr>
                            <td>0015</td>
                            <td>Chief Financial Officer (CFO)</td>
                            <td>867213567</td>
                            <td>64</td>
                            <td>2010/06/09</td>
                            <td>$725,000</td>
                        </tr>
                        <tr>
                            <td>0015</td>
                            <td>Systems Administrator</td>
                            <td>321654876</td>
                            <td>59</td>
                            <td>2009/04/10</td>
                            <td>$237,500</td>
                        </tr>
                        <tr>
                            <td>0015</td>
                            <td>Software Engineer</td>
                            <td>071236432</td>
                            <td>41</td>
                            <td>2012/10/13</td>
                            <td>$132,000</td>
                        </tr>
                        <tr>
                            <td>0015</td>
                            <td>Personnel Lead</td>
                            <td>333556771</td>
                            <td>35</td>
                            <td>2012/09/26</td>
                            <td>$217,500</td>
                        </tr>
                        <tr>
                            <td>0015</td>
                            <td>Development Lead</td>
                            <td>165479123</td>
                            <td>30</td>
                            <td>2011/09/03</td>
                            <td>$345,000</td>
                        </tr>
                        <tr>
                            <td>0015</td>
                            <td>Chief Marketing Officer (CMO)</td>
                            <td>110122581</td>
                            <td>40</td>
                            <td>2009/06/25</td>
                            <td>$675,000</td>
                        </tr>
                        <tr>
                            <td>0015</td>
                            <td>Pre-Sales Support</td>
                            <td>339123874</td>
                            <td>21</td>
                            <td>2011/12/12</td>
                            <td>$106,450</td>
                        </tr>
                        <tr>
                            <td>0015</td>
                            <td>Sales Assistant</td>
                            <td>003213523</td>
                            <td>23</td>
                            <td>2010/09/20</td>
                            <td>$85,600</td>
                        </tr>
                        <tr>
                            <td>0015</td>
                            <td>Chief Executive Officer (CEO)</td>
                            <td>876123400</td>
                            <td>47</td>
                            <td>2009/10/09</td>
                            <td>$1,200,000</td>
                        </tr>
                        <tr>
                            <td>0015</td>
                            <td>Developer</td>
                            <td>Edinburgh</td>
                            <td>42</td>
                            <td>2010/12/22</td>
                            <td>$92,575</td>
                        </tr>
                        <tr>
                            <td>0015</td>
                            <td>Regional Director</td>
                            <td>Singapore</td>
                            <td>28</td>
                            <td>2010/11/14</td>
                            <td>$357,650</td>
                        </tr>
                        <tr>
                            <td>0015</td>
                            <td>Software Engineer</td>
                            <td>San Francisco</td>
                            <td>28</td>
                            <td>2011/06/07</td>
                            <td>$206,850</td>
                        </tr>
                        <tr>
                            <td>0015</td>
                            <td>Chief Operating Officer (COO)</td>
                            <td>San Francisco</td>
                            <td>48</td>
                            <td>2010/03/11</td>
                            <td>$850,000</td>
                        </tr>
                        <tr>
                            <td>0015</td>
                            <td>Regional Marketing</td>
                            <td>Tokyo</td>
                            <td>20</td>
                            <td>2011/08/14</td>
                            <td>$163,000</td>
                        </tr>
                        <tr>
                            <td>0015</td>
                            <td>Integration Specialist</td>
                            <td>Sidney</td>
                            <td>37</td>
                            <td>2011/06/02</td>
                            <td>$95,400</td>
                        </tr>
                        <tr>
                            <td>0015</td>
                            <td>Developer</td>
                            <td>London</td>
                            <td>53</td>
                            <td>2009/10/22</td>
                            <td>$114,500</td>
                        </tr>
                        <tr>
                            <td>0015</td>
                            <td>Technical Author</td>
                            <td>London</td>
                            <td>27</td>
                            <td>2011/05/07</td>
                            <td>$145,000</td>
                        </tr>
                        <tr>
                            <td>0015</td>
                            <td>Team Leader</td>
                            <td>San Francisco</td>
                            <td>22</td>
                            <td>2008/10/26</td>
                            <td>$235,500</td>
                        </tr>
                        <tr>
                            <td>0015</td>
                            <td>Post-Sales support</td>
                            <td>Edinburgh</td>
                            <td>46</td>
                            <td>2011/03/09</td>
                            <td>$324,050</td>
                        </tr>
                        <tr>
                            <td>0015</td>
                            <td>Marketing Designer</td>
                            <td>San Francisco</td>
                            <td>47</td>
                            <td>2009/12/09</td>
                            <td>$85,675</td>
                        </tr>
                        <tr>
                            <td>0015</td>
                            <td>Office Manager</td>
                            <td>San Francisco</td>
                            <td>51</td>
                            <td>2008/12/16</td>
                            <td>$164,500</td>
                        </tr>
                        <tr>
                            <td>0015</td>
                            <td>Secretary</td>
                            <td>San Francisco</td>
                            <td>41</td>
                            <td>2010/02/12</td>
                            <td>$109,850</td>
                        </tr>
                        <tr>
                            <td>0015</td>
                            <td>Financial Controller</td>
                            <td>San Francisco</td>
                            <td>62</td>
                            <td>2009/02/14</td>
                            <td>$452,500</td>
                        </tr>
                        <tr>
                            <td>0015</td>
                            <td>Office Manager</td>
                            <td>London</td>
                            <td>37</td>
                            <td>2008/12/11</td>
                            <td>$136,200</td>
                        </tr>
                        <tr>
                            <td>0015</td>
                            <td>Director</td>
                            <td>New York</td>
                            <td>65</td>
                            <td>2008/09/26</td>
                            <td>$645,750</td>
                        </tr>
                        <tr>
                            <td>0015</td>
                            <td>Support Engineer</td>
                            <td>Singapore</td>
                            <td>64</td>
                            <td>2011/02/03</td>
                            <td>$234,500</td>
                        </tr>
                        <tr>
                            <td>0015</td>
                            <td>Software Engineer</td>
                            <td>London</td>
                            <td>38</td>
                            <td>2011/05/03</td>
                            <td>$163,500</td>
                        </tr>
                        <tr>
                            <td>0015</td>
                            <td>Support Engineer</td>
                            <td>Tokyo</td>
                            <td>37</td>
                            <td>2009/08/19</td>
                            <td>$139,575</td>
                        </tr>
                        <tr>
                            <td>0015</td>
                            <td>Developer</td>
                            <td>New York</td>
                            <td>61</td>
                            <td>2013/08/11</td>
                            <td>$98,540</td>
                        </tr>
                        <tr>
                            <td>0015</td>
                            <td>Support Engineer</td>
                            <td>San Francisco</td>
                            <td>47</td>
                            <td>2009/07/07</td>
                            <td>$87,500</td>
                        </tr>
                        <tr>
                            <td>0015</td>
                            <td>Data Coordinator</td>
                            <td>Singapore</td>
                            <td>64</td>
                            <td>2012/04/09</td>
                            <td>$138,575</td>
                        </tr>
                        <tr>
                            <td>0015</td>
                            <td>Software Engineer</td>
                            <td>New York</td>
                            <td>63</td>
                            <td>2010/01/04</td>
                            <td>$125,250</td>
                        </tr>
                        <tr>
                            <td>0015</td>
                            <td>Software Engineer</td>
                            <td>San Francisco</td>
                            <td>56</td>
                            <td>2012/06/01</td>
                            <td>$115,000</td>
                        </tr>
                        <tr>
                            <td>0015</td>
                            <td>Junior Javascript Developer</td>
                            <td>Edinburgh</td>
                            <td>43</td>
                            <td>2013/02/01</td>
                            <td>$75,650</td>
                        </tr>
                        <tr>
                            <td>0015</td>
                            <td>Sales Assistant</td>
                            <td>New York</td>
                            <td>46</td>
                            <td>2011/12/06</td>
                            <td>$145,600</td>
                        </tr>
                        <tr>
                            <td>0015</td>
                            <td>Regional Director</td>
                            <td>London</td>
                            <td>47</td>
                            <td>2011/03/21</td>
                            <td>$356,250</td>
                        </tr>
                        <tr>
                            <td>0015</td>
                            <td>Systems Administrator</td>
                            <td>London</td>
                            <td>21</td>
                            <td>2009/02/27</td>
                            <td>$103,500</td>
                        </tr>
                        <tr>
                            <td>0015</td>
                            <td>Developer</td>
                            <td>San Francisco</td>
                            <td>30</td>
                            <td>2010/07/14</td>
                            <td>$86,500</td>
                        </tr>
                        <tr>
                            <td>0015</td>
                            <td>Regional Director</td>
                            <td>Edinburgh</td>
                            <td>51</td>
                            <td>2008/11/13</td>
                            <td>$183,000</td>
                        </tr>
                        <tr>
                            <td>0015</td>
                            <td>Javascript Developer</td>
                            <td>Singapore</td>
                            <td>29</td>
                            <td>2011/06/27</td>
                            <td>$183,000</td>
                        </tr>
                        <tr>
                            <td>0015</td>
                            <td>Customer Support</td>
                            <td>New York</td>
                            <td>27</td>
                            <td>2011/01/25</td>
                            <td>$112,000</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection