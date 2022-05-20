<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PDF</title>
    <style>
        .center{
            text-align: center;
        }
        table{
            width: 100%;
            margin-top: 25px;
            border:1px solid black;
            border-collapse: collapse;
        }
        th,td{
            text-align:left;
            border: 1px solid black;
            border-collapse: collapse;
            padding: 2px;
        }
        .border-bottom{
            border-bottom: 1px solid black;
        }
        .blank_row
        {
            height: 15px ;

        }

    </style>
</head>

<body>
    <main>
    <h1 class="center">Hmezgeb</h1>
    {{-- section page title --}}
    <h3 class="center">@yield('page_title')</h3>
    {{-- section content --}}
    <p class="center">{{$request->date_from}} - {{$request->date_to}}</p>
        @yield('content')
    </main>


</body>
</html>