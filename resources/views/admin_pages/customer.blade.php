<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

    <h2>All Customers</h2>

    @foreach ($customers as $customer)
        <div>
            <p>Name: {{ $customer->name }}</p>
            <p>Phone Number: {{ $customer->phone_number }}</p>
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