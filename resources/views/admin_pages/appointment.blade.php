<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

    <h2>All Appointments</h2>

    @foreach ($appointments as $appointment)
        <div>
            <p>Barber: {{ $appointment->barber->name }}</p>
            <p>Date and Time: {{ $appointment->date }} {{ $appointment->start_time }} - {{ $appointment->end_time }}</p>
            <p>Total Price: RM{{ $appointment->total_price }}</p>
            <p>Customer: {{ $appointment->customer->name }} (Phone: {{ $appointment->customer->phone_number }})</p>
            <p>Services:
                @foreach ($appointment->services as $service)
                    {{ $service->name }} - RM{{ $service->price }} - {{ $service->duration_minutes }} minutes<br>
                @endforeach
            </p>
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