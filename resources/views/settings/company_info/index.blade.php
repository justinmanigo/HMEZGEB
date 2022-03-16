@extends('template.index')



@section('content')
<div class="d-sm-flex align-items-start justify-content-between mb-2">
    <h1>Company Info</h1>
</div>
<div class="card ">
    <div class="card-body">
        <div class="card mb-4 py-3 border-left-primary">
            <div class="card-body">
                <p><span class="m-0 font-weight-bold text-primary">Company Name:</span> Addis Moment Services</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Address 1</h6>
                    </div>
                    <div class="card-body">
                        Bole Michel, Opposite Kebe Pastery<br />
                        P.O.Box: 305<br />
                        Postal Code: 1000<br />
                        City, Country: Addis Ababa, Ethiopia
                    </div>
                </div>

            </div>

            <div class="col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Address 2 </h6>
                    </div>
                    <div class="card-body">
                        Kayo Boru Hotel, Ground Floor, G-01<br />
                        P.O.Box: 1578<br />
                        Postal Code: 1000<br />
                        City, Country: Adama, Ethiopia
                    </div>
                </div>
            </div>
        </div>
        <div class="col-auto mb-4">
            <div class="card shadow">
                <div class="card-body">
                    <p><span class=" font-weight-bold text-primary">Telephone:</span> +25194000777, +251940407777</p>
                    <p><span class=" font-weight-bold text-primary">Fax: </span>----------------</p>
                    <p><span class=" font-weight-bold text-primary">Tin#:</span> 0042101026</p>
                    <p><span class=" font-weight-bold text-primary"> VAT#: </span>10020878366</p>
                </div>
            </div>
        </div>
    </div>
</div>
<hr />

<div class="card mb-4 py-3 border-left-info">
    <div class="card-body">
        <p><span class=" font-weight-bold text-primary"> Contact Person: </span> Mohammed Ahmed</p>
        <p><span class=" font-weight-bold text-primary"> Position: </span> CEO</p>
        <p><span class=" font-weight-bold text-primary"> Mobile#: </span> 0943707030</p>
    </div>
</div>
<hr />
<div class="card mb-4 py-3 border-left-info">
    <div class="card-body">
        <p><span class=" font-weight-bold text-primary"> Business Type: </span> (Sole Proprietorship, Partnership, PLC,
            Share Company) [List Box]</p>
    </div>
</div>

@endsection
