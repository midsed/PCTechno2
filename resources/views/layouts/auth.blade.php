<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PCTechno</title>

  {{-- Your main app assets --}}
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  {{-- Load your custom theme file --}}
  <link rel="stylesheet" href="{{ asset('css/pctechno.css') }}">
</head>
<body>
  @yield('content')
</body>
</html>
