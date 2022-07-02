<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>HMEZGEB - Login</title>

    <!-- Custom fonts for this template-->
     <!-- Custom fonts for this template-->
    <link rel="stylesheet" href="{{URL::asset('vendor/fontawesome-free/css/all.min.css')}}">  
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link rel="stylesheet" href="{{URL::asset('css/sb-admin-2.min.css')}}">  
    <style>
        .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active
        {
            color: #ffffff;
            background-color: #2653d4;
            border-color: #dddfeb #dddfeb #fff;
        }
    </style>



</head>

<body class="bg-gradient-primary">
     {{-- input company --}}
     <div class="container"  id="step2_1Container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-12">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->

                        
                        <div class="row">
                            @if (\Session::has('error'))
                            <div class="alert alert-danger">
                                {!! \Session::get('error') !!}
                            </div>
                            @endif
                    
                                    
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <h2 class="h4 text-gray-900 mb-4 text-center">Accounting System Onboarding</h2>
                                    <div id="step-indicator" class="row mb-3">
                                        <div class="col-12 col-lg-4 mb-3 mb-lg-0">
                                            <div id="step-indicator-1" class="card border-success">
                                                <div class="card-body">
                                                    <div class="icon text-success"><strong>Step 1</strong></div>
                                                    <div class="text">Accounting System Info</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 mb-3 mb-lg-0">
                                            <div id="step-indicator-2" class="card">
                                                <div class="card-body">
                                                    <div class="icon"><strong>Step 2</strong></div>
                                                    <div class="text">Accounting Year & Calendar</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 mb-3 mb-lg-0">
                                            <div id="step-indicator-3" class="card">
                                                <div class="card-body">
                                                    <div class="icon"><strong>Step 3</strong></div>
                                                    <div class="text">Accounting System Payment</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Company Information -->
                                    <div id="onboarding-step1" style="display:block">
                                        <form action="" method="POST" id="form-onboarding-step1">
                                            <div class="text-center">
                                                <p>You successfully created a user account. Now it's time to create an accounting system for your company. Let's start by filling out your company's information.</p>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 col-lg-6 mb-3">
                                                    <h4>Company Details</h4>
                                                    <div class="form-group">
                                                        <label for="ci-name">Company Name<span class="text-danger ml-1">*</span></label>
                                                        <input type="text" class="form-control" id="ci-name" name="name" required>
                                                        <p class="text-danger error-message error-message-name" style="display:none"></p>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="ci-vat_number">VAT Number</label>
                                                        <input type="text" class="form-control" id="ci-vat_number" name="vat_number">
                                                        <p class="text-danger error-message error-message-vat_number" style="display:none"></p>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="ci-tin_number">TIN Number<span class="text-danger ml-1">*</span></label>
                                                        <input type="text" class="form-control" id="ci-tin_number" name="tin_number" required>
                                                        <p class="text-danger error-message error-message-tin_number" style="display:none"></p>
                                                    </div>
                                                    <!-- Select Business Type -->
                                                    <div class="form-group">
                                                        <label for="ci-business_type">Business Type<span class="text-danger ml-1">*</span></label>
                                                        <select class="form-control" id="ci-business_type" name="business_type" required>
                                                            <option value="" hidden disabled selected>Select Business Type</option>
                                                            <option value="Sole Proprietorship">Sole Proprietorship</option>
                                                            <option value="Partnership">Partnership</option>
                                                            <option value="PLC">PLC</option>
                                                            <option value="Share Company">Share Company</option>
                                                        </select>
                                                        <p class="text-danger error-message error-message-business_type" style="display:none"></p>
                                                    </div>
                                                    <hr>
                                                    <h4>Company Address</h4>
                                                    <!-- Address -->
                                                    <div class="form-group">
                                                        <label for="ci-address">Address</label>
                                                        <input type="text" class="form-control" id="ci-address" name="address">
                                                        <p class="text-danger error-message error-message-address" style="display:none"></p>
                                                    </div>
                                                    <!-- PO_Box -->
                                                    <div class="form-group">
                                                        <label for="ci-po_box">PO Box</label>
                                                        <input type="text" class="form-control" id="ci-po_box" name="po_box">
                                                        <p class="text-danger error-message error-message-po_box" style="display:none"></p>
                                                    </div>
                                                    <!-- City -->
                                                    <div class="form-group">
                                                        <label for="ci-city">City<span class="text-danger ml-1">*</span></label>
                                                        <input type="text" class="form-control" id="ci-city" name="city" required>
                                                        <p class="text-danger error-message error-message-city" style="display:none"></p>
                                                    </div>
                                                    <!-- Country -->
                                                    <div class="form-group">
                                                        <label for="ci-country">Country</label>
                                                        <input type="text" class="form-control" id="ci-country" name="country">
                                                        <p class="text-danger error-message error-message-country" style="display:none"></p>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-6">
                                                    <h4>Company Contact Details</h4>
                                                    <!-- Mobile Number -->
                                                    <div class="form-group">
                                                        <label for="ci-mobile_number">Mobile Number<span class="text-danger ml-1">*</span></label>
                                                        <input type="text" class="form-control" id="ci-mobile_number" name="mobile_number" required>
                                                        <p class="text-danger error-message error-message-mobile_number" style="display:none"></p>
                                                    </div>
                                                    <!-- Telephone 1 -->
                                                    <div class="form-group">
                                                        <label for="ci-telephone_1">Telephone 1</label>
                                                        <input type="text" class="form-control" id="ci-telephone_1" name="telephone_1">
                                                        <p class="text-danger error-message error-message-telephone_1" style="display:none"></p>
                                                    </div>
                                                    <!-- Telephone 2 -->
                                                    <div class="form-group">
                                                        <label for="ci-telephone_2">Telephone 2</label>
                                                        <input type="text" class="form-control" id="ci-telephone_2" name="telephone_2">
                                                        <p class="text-danger error-message error-message-telephone_2" style="display:none"></p>
                                                    </div>
                                                    <!-- Fax -->
                                                    <div class="form-group">
                                                        <label for="ci-fax">Fax</label>
                                                        <input type="text" class="form-control" id="ci-fax" name="fax">
                                                        <p class="text-danger error-message error-message-fax" style="display:none"></p>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="ci-website">Website</label>
                                                        <input type="text" class="form-control" id="ci-website" name="website">
                                                        <p class="text-danger error-message error-message-website" style="display:none"></p>
                                                    </div>
                                                    <hr>
                                                    <h4>Company Contact Person</h4>
                                                    <!-- Contact Person -->
                                                    <div class="form-group">
                                                        <label for="ci-contact_person">Name<span class="text-danger ml-1">*</span></label>
                                                        <input type="text" class="form-control" id="ci-contact_person" name="contact_person" required>
                                                        <p class="text-danger error-message error-message-contact_person" style="display:none"></p>
                                                    </div>
                                                    <!-- Contact Person Position -->
                                                    <div class="form-group">
                                                        <label for="ci-contact_person_position">Position<span class="text-danger ml-1">*</span></label>
                                                        <input type="text" class="form-control" id="ci-contact_person_position" name="contact_person_position" required>
                                                        <p class="text-danger error-message error-message-contact_person_position" style="display:none"></p>
                                                    </div>
                                                    <!-- Contact Person Mobile Number -->
                                                    <div class="form-group">
                                                        <label for="ci-contact_person_mobile_number">Mobile Number<span class="text-danger ml-1">*</span></label>
                                                        <input type="text" class="form-control" id="ci-contact_person_mobile_number" name="contact_person_mobile_number" required>
                                                        <p class="text-danger error-message error-message-contact_person_mobile_number" style="display:none"></p>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <button id="btn-next-step1" type="submit" class="btn btn-primary btn-next" style="width:30%">
                                                Next Step
                                            </button>
                                            <button type="button-cancel-step1" class="btn btn-outline-secondary btn-cancel" disabled>
                                                Cancel
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Accounting Year & Calendar -->
                                    <div id="onboarding-step2" style="display:none">
                                        <form action="" method="POST" id="form-onboarding-step2">
                                            <div class="text-center">
                                                <p>Select a type of calendar and accounting year for this accounting system.</p>
                                            </div>

                                            <!-- Select Calendar Type -->
                                            <div class="form-group row">
                                                <label for="ci-calendar_type" class="col-lg-3">Calendar Type<span class="text-danger ml-1">*</span></label>
                                                <select class="form-control col-lg-6" id="ci-calendar_type" name="calendar_type" required>
                                                    <option value="" hidden disabled selected>Select Calendar Type</option>
                                                    <option value="gregorian">Gregorian Calendar</option>
                                                    <option value="ethiopian">Ethiopian Calendar</option>
                                                </select>
                                                <p class="text-danger error-message error-message-calendar_type" style="display:none"></p>
                                            </div>

                                            <!-- Select Accounting Year -->
                                            <div class="form-group row">
                                                <label for="ci-accounting_year" class="col-lg-3">Accounting Year<span class="text-danger ml-1">*</span></label>
                                                <select class="form-control col-lg-6" id="ci-accounting_year" name="accounting_year" required disabled>
                                                    <option value="" hidden disabled selected>Select Accounting Year</option>
                                                </select>
                                                <p class="text-danger error-message error-message-accounting_year" style="display:none"></p>
                                            </div>

                                            <button id="btn-next-step2" type="submit" class="btn btn-primary btn-next" style="width:30%">
                                                Next Step
                                            </button>
                                            <button id="btn-previous-step2" type="button" class="btn btn-outline-secondary btn-previous">
                                                Previous Step
                                            </button>
                                            
                                        </form>
                                    </div>

                                    <!-- Payment Method -->
                                    <div id="onboarding-step3" style="display:none">
                                        <form action="{{ url('/onboarding') }}" method="POST" id="form-onboarding-step3">
                                            @csrf
                                            <div class="text-center">
                                                <p>Select a payment method for this accounting system.</p>
                                            </div>

                                            <p class="text-danger error-message error-message-main" style="display:none"></p>

                                            <!-- Select Calendar Type -->
                                            <div class="form-group row">
                                                <label for="ci-payment_method" class="col-lg-3">Payment Method<span class="text-danger ml-1">*</span></label>
                                                <div class="col-lg-6">
                                                    <select class="form-control" id="ci-payment_method" name="payment_method" required>
                                                        <option value="" hidden disabled selected>Select Payment Method</option>
                                                        <option value="trial">Trial</option>
                                                        <option value="paid" disabled>Paid</option>
                                                    </select>
                                                </div>
                                                <p class="text-danger error-message error-message-payment_method" style="display:none"></p>
                                            </div>

                                            <!-- Enter Payment Confirmation Code -->
                                            <div class="form-group row">
                                                <label for="ci-payment_confirmation_code" class="col-lg-3">Payment Confirmation Code</label>
                                                <div class="col-lg-6">
                                                    <input type="text" class="form-control" id="ci-payment_confirmation_code" name="payment_confirmation_code" disabled>
                                                    <small class="text-muted">Payment Confirmation is not supported as of this time.</small>
                                                </div>
                                                <p class="text-danger error-message error-message-payment_confirmation_code" style="display:none"></p>
                                            </div>
                                        
                                            {{-- <button id="btn-next-step3" type="button" class="btn btn-primary btn-next" style="width:30%">
                                                Next Step
                                            </button> --}}
                                            <button id="btn-submit-step3" type="submit" class="btn btn-primary btn-submit" style="width:30%">
                                                Submit & Finish
                                            </button>
                                            <button id="btn-previous-step3" type="button" class="btn btn-outline-secondary btn-previous">
                                                Previous Step
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                            
                    </div>   
                </div>   
            </div>   
        </div>   
    </div>  

    <!-- Bootstrap core JavaScript-->
    <script src="{{URL::asset('vendor/jquery/jquery.min.js')}}"></script> 
    <script src="{{URL::asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script> 
	{{-- <script src="{{URL::asset(' ')}}"></script>  --}}
    <!-- Core plugin JavaScript-->
    <script src="{{URL::asset('vendor/jquery-easing/jquery.easing.min.js')}}"></script> 

    <!-- Custom scripts for all pages-->
    <script src="{{URL::asset('js/sb-admin-2.min.js')}}"></script> 

    <!-- Custom scripts for this page-->
    <script>
        var step1_formdata;
        var step2_formdata;

        // Step 1 to Step 2
        $(document).on('submit', `#form-onboarding-step1`, function(e){
            console.log('clicked btn next step1')
            e.preventDefault();
            var form = $(this);
            var formData = form.serialize();
            step1_formdata = formData;
            console.log(step1_formdata);
            
            $('#onboarding-step1').hide();
            $('#onboarding-step2').show();

            $('#step-indicator-1').removeClass('border-success');
            $('#step-indicator-1 .icon').removeClass('text-success');

            $('#step-indicator-2').addClass('border-success');
            $('#step-indicator-2 .icon').addClass('text-success');

        });

        // Step 2 on Select Calendar Type
        $(document).on('change', `#ci-calendar_type`, function(e){
            console.log('changed calendar type');

            var value = e.currentTarget.value
            var currentYear = new Date().getFullYear();

            console.log(currentYear);

            // clear options of accounting year
            $('#ci-accounting_year').find('option').remove();
            $('#ci-accounting_year').append(`<option value="" hidden disabled selected>Select Accounting Year</option>`)

            // add options based on selected calendar type
            if(value == 'gregorian') {
                for(i = 0; i < 7; i++) {
                    var year = currentYear - i;
                    $('#ci-accounting_year').append(`<option value="${year}">${year}</option>`).removeAttr('disabled');
                }
            }
            else if(value == 'ethiopian') {
                for(i = 0; i < 7; i++) {
                    var year = currentYear - i - 7;
                    $('#ci-accounting_year').append(`<option value=${year}">${year} (${year+7} - ${year+8})</option>`).removeAttr('disabled');
                }
            }
        });

        // Step 2 to Step 3
        $(document).on('submit', '#form-onboarding-step2', function(e) {
            console.log('clicked btn next step2')
            e.preventDefault();
            var form = $(this);
            var formData = form.serialize();
            step2_formdata = formData;
            console.log(`${step1_formdata}&${step2_formdata}`);

            $('#onboarding-step2').hide();
            $('#onboarding-step3').show();

            $('#step-indicator-2').removeClass('border-success');
            $('#step-indicator-2 .icon').removeClass('text-success');

            $('#step-indicator-3').addClass('border-success');
            $('#step-indicator-3 .icon').addClass('text-success');
        });

        // Step 3 Submit
        $(document).on('submit', '#form-onboarding-step3', function(e) {
            console.log('clicked btn submit step3')
            e.preventDefault();
            $('.error-message').hide();

            $('#btn-submit-step3').attr('disabled', 'true');

            var form = $(this);
            var formData = form.serialize();
            console.log(`${step1_formdata}&${step2_formdata}&${formData}`);

            var request = $.ajax({
                url: '/onboarding',
                type: 'POST',
                data: `${step1_formdata}&${step2_formdata}&${formData}`,
                dataType: "json"
            });

            request.done(function(data){
                console.log(data);
                if(data.success) {
                    // Redirect to /switch
                    window.location.href = '/switch';
                }
                else {
                    $('#btn-submit-step3').removeAttr('disabled');
                    $('.error-message-main').html(data.error);
                }
            });

            request.fail(function(response){
                console.log(response);
                $('#btn-submit-step3').removeAttr('disabled');
                $('.error-message-main').html(data.error);
            });
        });

        // Step 3 to Step 2
        $(document).on('click', '#btn-previous-step3', function(e) {
            console.log('clicked btn prev step3')
            e.preventDefault();

            $('#onboarding-step3').hide();
            $('#onboarding-step2').show();

            $('#step-indicator-3').removeClass('border-success');
            $('#step-indicator-3 .icon').removeClass('text-success');

            $('#step-indicator-2').addClass('border-success');
            $('#step-indicator-2 .icon').addClass('text-success');
        });

        // Step 2 to Step 1
        $(document).on('click', '#btn-previous-step2', function(e) {
            console.log('clicked btn prev step2')
            e.preventDefault();

            $('#onboarding-step2').hide();
            $('#onboarding-step1').show();

            $('#step-indicator-2').removeClass('border-success');
            $('#step-indicator-2 .icon').removeClass('text-success');

            $('#step-indicator-1').addClass('border-success');
            $('#step-indicator-1 .icon').addClass('text-success');
        });
    </script>
 

</body>

</html>