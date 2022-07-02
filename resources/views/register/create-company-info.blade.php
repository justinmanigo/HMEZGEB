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
                                        <div class="col-6 col-lg-3 mb-3 mb-lg-0">
                                            <div id="step-indicator-1" class="card border-success">
                                                <div class="card-body">
                                                    <div class="icon text-success"><strong>Step 1</strong></div>
                                                    <div class="text">Accounting System Information</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-lg-3 mb-3 mb-lg-0">
                                            <div id="step-indicator-2" class="card">
                                                <div class="card-body">
                                                    <div class="icon"><strong>Step 2</strong></div>
                                                    <div class="text">Accounting Year & Calendar</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-lg-3 mb-3 mb-lg-0">
                                            <div id="step-indicator-3" class="card">
                                                <div class="card-body">
                                                    <div class="icon"><strong>Step 3</strong></div>
                                                    <div class="text">Accounting System Payment</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-lg-3 mb-3 mb-lg-0">
                                            <div id="step-indicator-4" class="card">
                                                <div class="card-body">
                                                    <div class="icon"><strong>Step 4</strong></div>
                                                    <div class="text">Accounting System Confirmation</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Company Information -->
                                    <div id="onboarding-step1" style="display:block">
                                        <form action="" method="POST" id="form-onboarding-step1">
                                            @csrf

                                            <div class="text-center">
                                                <p>You successfully created a user account. Now it's time to create an accounting system for your company. Let's start by filling out your company's information.</p>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 col-lg-6 mb-3">
                                                    <h4>Company Details</h4>
                                                    <div class="form-group">
                                                        <label for="ci-name">Company Name</label>
                                                        <input type="text" class="form-control" id="ci-name" name="name" required>
                                                        <p class="text-danger error-message error-message-name" style="display:none"></p>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="ci-vat_number">VAT Number</label>
                                                        <input type="text" class="form-control" id="ci-vat_number" name="vat_number" required>
                                                        <p class="text-danger error-message error-message-vat_number" style="display:none"></p>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="ci-tin_number">TIN Number</label>
                                                        <input type="text" class="form-control" id="ci-tin_number" name="tin_number" required>
                                                        <p class="text-danger error-message error-message-tin_number" style="display:none"></p>
                                                    </div>
                                                    <!-- Select Business Type -->
                                                    <div class="form-group">
                                                        <label for="ci-business_type">Business Type</label>
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
                                                        <input type="text" class="form-control" id="ci-address" name="address" required>
                                                        <p class="text-danger error-message error-message-address" style="display:none"></p>
                                                    </div>
                                                    <!-- PO_Box -->
                                                    <div class="form-group">
                                                        <label for="ci-po_box">PO Box</label>
                                                        <input type="text" class="form-control" id="ci-po_box" name="po_box" required>
                                                        <p class="text-danger error-message error-message-po_box" style="display:none"></p>
                                                    </div>
                                                    <!-- City -->
                                                    <div class="form-group">
                                                        <label for="ci-city">City</label>
                                                        <input type="text" class="form-control" id="ci-city" name="city" required>
                                                        <p class="text-danger error-message error-message-city" style="display:none"></p>
                                                    </div>
                                                    <!-- Country -->
                                                    <div class="form-group">
                                                        <label for="ci-country">Country</label>
                                                        <input type="text" class="form-control" id="ci-country" name="country" required>
                                                        <p class="text-danger error-message error-message-country" style="display:none"></p>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-6">
                                                    <h4>Company Contact Details</h4>
                                                    <!-- Mobile Number -->
                                                    <div class="form-group">
                                                        <label for="ci-mobile_number">Mobile Number</label>
                                                        <input type="text" class="form-control" id="ci-mobile_number" name="mobile_number" required>
                                                        <p class="text-danger error-message error-message-mobile_number" style="display:none"></p>
                                                    </div>
                                                    <!-- Telephone 1 -->
                                                    <div class="form-group">
                                                        <label for="ci-telephone_1">Telephone 1</label>
                                                        <input type="text" class="form-control" id="ci-telephone_1" name="telephone_1" required>
                                                        <p class="text-danger error-message error-message-telephone_1" style="display:none"></p>
                                                    </div>
                                                    <!-- Telephone 2 -->
                                                    <div class="form-group">
                                                        <label for="ci-telephone_2">Telephone 2</label>
                                                        <input type="text" class="form-control" id="ci-telephone_2" name="telephone_2" required>
                                                        <p class="text-danger error-message error-message-telephone_2" style="display:none"></p>
                                                    </div>
                                                    <!-- Fax -->
                                                    <div class="form-group">
                                                        <label for="ci-fax">Fax</label>
                                                        <input type="text" class="form-control" id="ci-fax" name="fax" required>
                                                        <p class="text-danger error-message error-message-fax" style="display:none"></p>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="ci-website">Website</label>
                                                        <input type="text" class="form-control" id="ci-website" name="website" required>
                                                        <p class="text-danger error-message error-message-website" style="display:none"></p>
                                                    </div>
                                                    <hr>
                                                    <h4>Company Contact Person</h4>
                                                    <!-- Contact Person -->
                                                    <div class="form-group">
                                                        <label for="ci-contact_person">Name</label>
                                                        <input type="text" class="form-control" id="ci-contact_person" name="contact_person" required>
                                                        <p class="text-danger error-message error-message-contact_person" style="display:none"></p>
                                                    </div>
                                                    <!-- Contact Person Position -->
                                                    <div class="form-group">
                                                        <label for="ci-contact_person_position">Position</label>
                                                        <input type="text" class="form-control" id="ci-contact_person_position" name="contact_person_position" required>
                                                        <p class="text-danger error-message error-message-contact_person_position" style="display:none"></p>
                                                    </div>
                                                    <!-- Contact Person Mobile Number -->
                                                    <div class="form-group">
                                                        <label for="ci-contact_person_mobile_number">Mobile Number</label>
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
                                        <button id="btn-next-step2" type="button" class="btn btn-primary btn-next" style="width:30%">
                                            Next Step
                                        </button>
                                        <button id="btn-previous-step2" type="button" class="btn btn-outline-secondary btn-previous">
                                            Previous Step
                                        </button>
                                    </div>

                                    <!-- Payment Method -->
                                    <div id="onboarding-step3" style="display:none">
                                        <button id="btn-next-step3" type="button" class="btn btn-primary btn-next" style="width:30%">
                                            Next Step
                                        </button>
                                        <button id="btn-previous-step3" type="button" class="btn btn-outline-secondary btn-previous">
                                            Previous Step
                                        </button>
                                    </div>

                                    <!-- Confirmation -->
                                    <div id="onboarding-step4" style="display:none">
                                        <button id="btn-submit-step4" type="submit" class="btn btn-primary btn-submit" style="width:30%">
                                            Submit & Finish
                                        </button>
                                        <button id="btn-previous-step4" type="button" class="btn btn-outline-secondary btn-previous">
                                            Previous Step
                                        </button>
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
        // Step 1 to Step 2
        $(document).on('submit', `#form-onboarding-step1`, function(e){
            console.log('clicked btn next step1')
            e.preventDefault();
            $(`.error-message`).hide();
            var form = $(this);
            var formData = form.serialize();
            var url = form.attr('action');
            var method = form.attr('method');
            // var request = $.ajax({
            //     url: url,
            //     type: method,
            //     data: formData,
            //     dataType: 'json',
            // });

            // request.done(function(data){
                // if(data.success){
                    $('#onboarding-step1').hide();
                    $('#onboarding-step2').show();

                    $('#step-indicator-1').removeClass('border-success');
                    $('#step-indicator-1 .icon').removeClass('text-success');

                    $('#step-indicator-2').addClass('border-success');
                    $('#step-indicator-2 .icon').addClass('text-success');
                    
                // }
                // else{
                //     $.each(data.errors, function(key, value){
                //         console.log(key, value);
                //         $(`.error-message-${key}`).text(value);
                //         $(`.error-message-${key}`).show();
                //     });
                // }
            // });
        });

        // Step 2 to Step 3
        $(document).on('click', '#btn-next-step2', function(e) {
            console.log('clicked btn next step2')
            e.preventDefault();
            $(`.error-message`).hide();

                    $('#onboarding-step2').hide();
                    $('#onboarding-step3').show();

                    $('#step-indicator-2').removeClass('border-success');
                    $('#step-indicator-2 .icon').removeClass('text-success');

                    $('#step-indicator-3').addClass('border-success');
                    $('#step-indicator-3 .icon').addClass('text-success');
        });

        // Step 3 to Step 4
        $(document).on('click', '#btn-next-step3', function(e) {
            console.log('clicked btn next step3')
            e.preventDefault();
            $(`.error-message`).hide();

                    $('#onboarding-step3').hide();
                    $('#onboarding-step4').show();

                    $('#step-indicator-3').removeClass('border-success');
                    $('#step-indicator-3 .icon').removeClass('text-success');

                    $('#step-indicator-4').addClass('border-success');
                    $('#step-indicator-4 .icon').addClass('text-success');
        });

        // Step 4 to Step 3
        $(document).on('click', '#btn-previous-step4', function(e) {
            console.log('clicked btn prev step4')
            e.preventDefault();

            $('#onboarding-step4').hide();
            $('#onboarding-step3').show();

            $('#step-indicator-4').removeClass('border-success');
            $('#step-indicator-4 .icon').removeClass('text-success');

            $('#step-indicator-3').addClass('border-success');
            $('#step-indicator-3 .icon').addClass('text-success');
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