<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>View Appointment</title>
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
    <section class="confirm-background">
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
        <div class="text-left">
            <h2 class="view-heading text-uppercase">View Your Appointments</h2>
        </div>
        <form method="POST" action="{{ route('appointments.showByCode') }}">
            @csrf
            <div class="form-group">
                <label for="appointment_code">Enter Appointment Code:</label>
                <input type="text" id="appointment_code" name="appointment_code" required>
            </div>
            <button type="view_submit">SUBMIT CODE</button>
        </form>
        <div class="view_appointment_container">
            <h2 class="appointment-heading text-uppercase">Your Appointment</h2>
            @if(isset($appointment))
                <table>
                    <thead>
                        <tr>
                            <th colspan="2">Your Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Name:</td>
                            <td>{{ $appointment->customer->name }}</td>
                        </tr>
                        <tr>
                            <td>Phone number:</td>
                            <td>{{ $appointment->customer->phone_number }}</td>
                        </tr>
                    </tbody>
                </table>
        
                <table>
                    <thead>
                        <tr>
                            <th colspan="2">Your Appointment Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Date:</td>
                            <td>{{ $appointment->date }}</td>
                        </tr>
                        <tr>
                            <td>Time:</td>
                            <td>{{ $appointment->start_time }} - {{ $appointment->end_time }}</td>
                        </tr>
                        <tr>
                            <td>Total Price:</td>
                            <td>RM {{ $appointment->total_price }}</td>
                        </tr>
                    </tbody>
                </table>
        
                <table>
                    <thead>
                        <tr>
                            <th>Service Name</th>
                            <th>Price</th>
                            <th>Duration</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointment->services as $service)
                            <tr>
                                <td>{{ $service->name }}</td>
                                <td>RM{{ $service->price }}</td>
                                <td>{{ $service->duration_minutes }} minutes</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <table>
                    <thead>
                        <tr>
                            <th colspan="2">Barber</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Name:</td>
                            <td>{{ $appointment->barber->name }}</td>
                        </tr>
                        <tr>
                            <td>Picture:</td>
                            <td><img class="barber-image mx-auto rounded-circle" src={{ asset('storage/' . $appointment->barber->image_path) }} alt="Barber Image" /></td>
                        </tr>
                    </tbody>
                </table>
                <a class="btn btn-primary btn-edit-xl text-uppercase" href="{{ route('appointments.editByCode', $appointment->appointment_code) }}">Edit Appointment</a>
            @endif
        </div>
        
    </section>
    <!-- Footer-->
    <footer class="footer py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4 text-lg-start">The Mark BarberShop 2024</div>
                <div class="col-lg-4 my-3 my-lg-0">
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a class="link-dark text-decoration-none me-3" href="#!">Privacy Policy</a>
                    <a class="link-dark text-decoration-none" href="#!">Terms of Use</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="/js/scripts.js"></script>
</body>
</html>