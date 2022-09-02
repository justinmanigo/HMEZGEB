<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PDF</title>
    <style>
        .page-break {
            page-break-after: always;
        }

        table{
            width: 100%;
            margin-top: 25px;
            border-collapse: collapse;
        }

        .table-total {
            color:darkgreen;
        }

        .table-bordered th, .table-bordered td{
            border: 1px solid black;
            border-collapse: collapse;
            padding: 2px;
        }
        
        .table-padding-5 th, .table-padding-5 td{
            padding: 5px;
        }

        /* th,td{
            
        } */
        .border-bottom{
            border-bottom: 1px solid black;
        }
        .border-bottom-3{
            border-bottom: 3px solid black;
        }
        .border-right-3 {
            border-right: 3px solid black;
        }

        .blank_row
        {
            height: 15px ;
        }

        tfoot, .border-top-3
        {
            border-top:3px solid black;
        }

        .text-start
        {
            text-align:left;
        }

        .text-center{
            text-align: center;
        }

        .text-end
        {
            text-align:right;
        }

    </style>
    @stack('style')
</head>

<body>
    <main>
    <h1 class="text-center">Hmezgeb</h1>
    {{-- section page title --}}
    <h3 class="text-center">@yield('page_title')</h3>
    {{-- section content --}}
    <p class="text-center">{{$request->date_from}} - {{$request->date_to}}</p>
        @yield('content')
    </main>


</body>
</html>