<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Edit Appointment</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="/assets/favicon.ico" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="/css/styles.css" rel="stylesheet" />
    </head>
<body>
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-black fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="#page-top"><img src="/assets/img/navbar-logo.svg" alt="..." /></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fas fa-bars ms-1"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('create') }}">Book Appointment</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('appointments.viewAppointments') }}">View Appointment</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <section>
        <div class = "container">
            <div class="text-left">
                <h2 class="section-heading text-uppercase">Edit Appointment</h2>
            </div>
            <form action="{{ route('appointments.updateByCode', $appointment->appointment_code) }}" method="post">
                @csrf
                @method('PUT')

                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <label for="barber_id">Select Barber:</label>
                <select name="barber_id" id="barber_id" required>
                    @foreach($barbers as $barber)
                        <option value="{{ $barber->id }}" {{ $barber->id == $appointment->barber_id ? 'selected' : '' }}>
                            {{ $barber->name }}
                        </option>
                    @endforeach
                </select><br>

                <label>Select Services:</label><br>
                @foreach($services as $service)
                    <input type="checkbox" class="serviceCheckbox" name="services[]" value="{{ $service->id }}"
                        {{ in_array($service->id, $appointment->services->pluck('id')->toArray()) ? 'checked' : '' }}>
                    <label>{{ $service->name }} - RM{{ $service->price }} -{{ $service->duration_minutes }} minutes</label><br>
                @endforeach

                <label for="customer_name">Customer Name:</label>
                <input type="text" name="customer_name" value="{{ $appointment->customer->name }}" required><br>

                <label for="customer_phone">Customer Phone:</label>
                <input type="text" name="customer_phone" value="{{ $appointment->customer->phone_number }}" required><br>

                <label for="datetime">Select Date and Time:</label>
                <input type="datetime-local" name="datetime" value="{{ \Carbon\Carbon::parse($appointment->datetime)->format('Y-m-d\TH:i') }}" required><br>

                <label for="appointment_code">Appointment Code:</label>
                <input type="text" name="appointment_code" value="{{ $appointment->appointment_code }}" readonly><br>

                <!-- Display the calculated values -->
                <div id="totalPrice">Total Price: RM0.00</div>
                <div id="totalDuration">Total Duration: 0 minutes</div>

                <!-- Display selected services -->
                <div id="selectedServices">Selected Services:</div>

                <input type="submit" value="Update Appointment">
            </div>
        </section>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Get all service checkboxes
                var serviceCheckboxes = document.querySelectorAll('.serviceCheckbox');
        
                // Add event listener for each checkbox
                serviceCheckboxes.forEach(function(checkbox) {
                    checkbox.addEventListener('change', calculateTotal);
                });
        
                function calculateTotal() {
                    // Get all checked checkboxes
                    var checkedCheckboxes = document.querySelectorAll('.serviceCheckbox:checked');
                    var totalPrice = 0;
                    var totalDuration = 0;
                    var selectedServices = [];
        
                    // Calculate total price and duration
                    checkedCheckboxes.forEach(function(checkbox) {
                        var price = parseFloat(checkbox.nextElementSibling.textContent.split(' - ')[1].replace('RM', ''));
                        var duration = parseInt(checkbox.nextElementSibling.textContent.split(' - ')[1].split(' ')[1]);
        
                        totalPrice += price;
                        totalDuration += duration;
        
                        // Add selected service details
                        selectedServices.push({
                            name: checkbox.nextElementSibling.textContent.split(' - ')[0],
                            price: price,
                            duration: duration
                        });
                    });
        
                    // Update the total price and duration on the page
                    document.getElementById('totalPrice').textContent = 'Total Price: RM' + totalPrice.toFixed(2);
                    document.getElementById('totalDuration').textContent = 'Total Duration: ' + totalDuration + ' minutes';
        
                    // Update selected services on the page
                    var selectedServicesDiv = document.getElementById('selectedServices');
                    selectedServicesDiv.innerHTML = 'Selected Services:';
                    selectedServices.forEach(function(service) {
                        var serviceDetails = document.createElement('div');
                        serviceDetails.textContent = `${service.name} - RM${service.price}  ${service.duration} minutes`;
                        selectedServicesDiv.appendChild(serviceDetails);
                    });
                }
        
                // Trigger initial calculation
                calculateTotal();
            });
        </script>
        
    </form>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="/js/scripts.js"></script>
</body>
</html>
