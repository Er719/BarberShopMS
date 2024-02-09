<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

    <h2>All Barbers</h2>

    @foreach ($barbers as $barber)
        <div>
            <p>Name: {{ $barber->name }}</p>
            <p>Picture: {{ $barber->image_path }}</p>
            <hr>
        </div>
    @endforeach

</body>
<div>
    <a href="{{ route('customer') }}">
        Customers
    </a>
</div>
<div>
    <a href="{{ route('appointment') }}">
        Appointment
    </a>
</div>
<div>
    <a href="{{ route('services') }}">
        Services
    </a>
</div>
<div>
    <a href="{{ route('barber') }}">
        Barbers
    </a>
</div>
</html>