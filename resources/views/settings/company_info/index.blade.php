@extends('template.index')



@section('content')
<div class="d-sm-flex align-items-start justify-content-between mb-2">
    <h1>Company Info</h1>
</div>

<div class="col-12 col-xl-10 col-xxl-8">
    <div class="card">
        <div class="card-body">
            <div class="container-fluid">
                <form id="form-company-info" class="ajax-submit-updated" method="POST" action="{{ url('/settings/company') }}" data-message="Successfully updated company info.">
                    @csrf
                    @method('PUT')
                    @if(isset($_GET['success']))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ $_GET['success'] }}
                            {{-- {{ session()->get('success') }} --}}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    
                    <div class="form-group row">
                        <div class="col-12 col-lg-8 mb-3 mb-lg-0">
                            <h5>Company Information:</h5>
                            <div class="form-group row">
                                <label for="c_name" class="col-4 col-form-label text-left">Company Name<span class="text-danger ml-1">*</span></label>
                                <div class="col-8 col-lg-7">
                                    <input required class="form-control" id="c_name" name='name' value="{{ $accounting_system->name }}">
                                    <p class="text-danger error-message error-message-name" style="display:none"></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="c_address" class="col-4 col-form-label text-left">Address</label>
                                <div class="col-8 col-lg-7">
                                    <input class="form-control" id="c_address" name='address' value="{{ $accounting_system->address }}">
                                    <p class="text-danger error-message error-message-address" style="display:none"></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="c_po_box" class="col-4 col-form-label text-left">PO Box</label>
                                <div class="col-8 col-lg-7">
                                    <input class="form-control" id="c_po_box" name='po_box' value="{{ $accounting_system->po_box }}">
                                    <p class="text-danger error-message error-message-po_box" style="display:none"></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="c_postal_code" class="col-4 col-form-label text-left">Postal Code</label>
                                <div class="col-8 col-lg-7">
                                    <input class="form-control" id="c_postal_code" name='postal_code' value="{{ $accounting_system->postal_code }}">
                                    <p class="text-danger error-message error-message-postal_code" style="display:none"></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="c_city" class="col-4 col-form-label text-left">City<span class="text-danger ml-1">*</span></label>
                                <div class="col-8 col-lg-7">
                                    <input required class="form-control" id="c_city" name='city' value={{ $accounting_system->city }}>
                                    <p class="text-danger error-message error-message-city" style="display:none"></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="c_country" class="col-4 col-form-label text-left">Country</label>
                                <div class="col-8 col-lg-7">
                                    <input class="form-control" id="c_country" name='country' value="{{ $accounting_system->country }}">
                                    <p class="text-danger error-message error-message-country" style="display:none"></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="c_vat_number" class="col-4 col-form-label text-left">VAT Number</label>
                                <div class="col-8 col-lg-7">
                                    <input class="form-control" id="c_vat_number" name='vat_number' value="{{ $accounting_system->vat_number }}">
                                    <p class="text-danger error-message error-message-vat_number" style="display:none"></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="c_tin_number" class="col-4 col-form-label text-left">TIN Number<span class="text-danger ml-1">*</span></label>
                                <div class="col-8 col-lg-7">
                                    <input required class="form-control" id="c_tin_number" name='tin_number' value="{{ $accounting_system->tin_number }}">
                                    <p class="text-danger error-message error-message-tin_number" style="display:none"></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="c_business_type" class="col-4 col-form-label text-left">Business Type<span class="text-danger ml-1">*</span></label>
                                <div class="col-8 col-lg-7">
                                    <select required class="form-control" id="c_business_type" name='business_type'>
                                        <option value="" hidden selected disabled>Select Business Type</option>
                                        <option value="Sole Proprietorship" @if($accounting_system->business_type == 'Sole Proprietorship') selected='selected' @endif>Sole Proprietorship</option>
                                        <option value="Partnership" @if($accounting_system->business_type == 'Partnership') selected='selected' @endif>Partnership</option>
                                        <option value="PLC" @if($accounting_system->business_type == 'PLC') selected='selected' @endif>PLC</option>
                                        <option value="Share Company" @if($accounting_system->business_type == 'Share Company') selected='selected' @endif>Share Company</option>
                                    </select>
                                    <p class="text-danger error-message error-message-business_type" style="display:none"></p>
                                </div>
                            </div>
                            
                        </div>
                        <div class="col-12 col-lg-4">
                            <h5>Contact Information:</h5>
                            <div class="form-group row">
                                <label for="c_mobile_number" class="col-4 col-form-label text-left">Mobile #<span class="text-danger ml-1">*</span></label>
                                <div class="col-8 col-lg-7">
                                    <input required class="form-control" id="c_mobile_number" name='mobile_number' value="{{ $accounting_system->mobile_number }}">
                                    <p class="text-danger error-message error-message-mobile_number" style="display:none"></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="c_telephone_1" class="col-4 col-form-label text-left">Telephone # 1</label>
                                <div class="col-8 col-lg-7">
                                    <input class="form-control" id="c_telephone_1" name='telephone_1' value="{{ $accounting_system->telephone_1 }}">
                                    <p class="text-danger error-message error-message-telephone_1" style="display:none"></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="c_telephone_2" class="col-4 col-form-label text-left">Telephone # 2</label>
                                <div class="col-8 col-lg-7">
                                    <input class="form-control" id="c_telephone_2" name='telephone_2' value="{{ $accounting_system->telephone_2 }}">
                                    <p class="text-danger error-message error-message-telephone_2" style="display:none"></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="c_fax" class="col-4 col-form-label text-left">Fax</label>
                                <div class="col-8 col-lg-7">
                                    <input class="form-control" id="c_fax" name='fax' value="{{ $accounting_system->fax }}">
                                    <p class="text-danger error-message error-message-fax" style="display:none"></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="c_website" class="col-4 col-form-label text-left">Website</label>
                                <div class="col-8 col-lg-7">
                                    <input class="form-control" id="c_website" name='website' value="{{ $accounting_system->website }}">
                                    <p class="text-danger error-message error-message-website" style="display:none"></p>
                                </div>
                            </div>

                            <h5>Contact Person:</h5>
                            <div class="form-group row">
                                <label for="c_contact_person" class="col-4 col-form-label text-left">Name<span class="text-danger ml-1">*</span></label>
                                <div class="col-8 col-lg-7">
                                    <input required class="form-control" id="c_contact_person" name='contact_person' value="{{ $accounting_system->contact_person }}">
                                    <p class="text-danger error-message error-message-contact_person" style="display:none"></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="c_contact_person_position" class="col-4 col-form-label text-left">Position<span class="text-danger ml-1">*</span></label>
                                <div class="col-8 col-lg-7">
                                    <input required class="form-control" id="c_contact_person_position" name='contact_person_position' value="{{ $accounting_system->contact_person_position }}">
                                    <p class="text-danger error-message error-message-contact_person_position" style="display:none"></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="c_contact_person_mobile_number" class="col-4 col-form-label text-left">Mobile #<span class="text-danger ml-1">*</span></label>
                                <div class="col-8 col-lg-7">
                                    <input required class="form-control" id="c_contact_person_mobile_number" name='contact_person_mobile_number' value="{{ $accounting_system->contact_person_mobile_number }}">
                                    <p class="text-danger error-message error-message-contact_person_mobile_number" style="display:none"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </form>
                <button type="submit" form="form-company-info" class="btn btn-primary" id="btn-save-accounting-system">Save Company Info</button>
    
            </div>
        </div>
    </div>                   
</div>
@endsection
