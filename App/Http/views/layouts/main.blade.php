<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
</head>
<body class="bg-slate-100">
    <div class="container mx-auto w-xl flex flex-col py-3">

        <div class="w-full flex flex-col border border-slate-300 border-b-slate-400  h-[198px]">
            <div class="row flex flex-row pt-2 h-full">
                @yield('topcontent')
            </div>
        </div>

        @yield('content')
    </div>
    
</body>
</html>