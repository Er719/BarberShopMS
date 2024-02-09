<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Booking Appointment</title>
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
            <div class="container">
                <div class="text-left">
                    <h2 class="section-heading text-uppercase">Book Appointment</h2>
                </div>
                <form action="/appointments" method="post">
                    @csrf
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                        <div class="text-left">
                            <h2 class="section-subheading text-muted">Choose Services</h2>
                        </div>
                            @foreach($services as $service)
                                    <input type="checkbox" class="serviceCheckbox visually-hidden" name="services_id[]" value="{{ $service->id }}" data-name="{{ $service->name }}" data-price="{{ $service->price }}" data-duration="{{ $service->duration_minutes }}" id="serviceCheckbox{{ $service->id }}">
                                    <label class="btn btn-outline-primary service-label" for="serviceCheckbox{{ $service->id }}">
                                        <span>{{ $service->name }}</span><br>
                                        <span>RM{{ $service->price }}</span><br>
                                        <span>{{ $service->duration_minutes }} minutes</span>
                                    </label>
                            @endforeach  
                        <div class="text-left">
                            <h2 class="section-subheading text-muted">Choose Barber</h2>
                        </div>
                        @foreach($barbers as $barber)
                            <input type="radio" name="barber_id" value="{{ $barber->id }}" id="barber{{ $barber->id }}" class="barber-radio"
                                {{ $loop->first ? 'checked' : '' }}>
                            <label for="barber{{ $barber->id }}" class="barber-label">
                                <img class="barber-image mx-auto rounded-circle" src="/assets/img/team/1.jpg" alt="Barber Image" />
                                <div class="barber-info">
                                    <span>{{ $barber->name }}</span>
                                </div>
                            </label>
                        @endforeach
                        <div class="text-left">
                            <h2 class="section-subheading text-muted">Enter Your Details</h2>
                            <div class="form-group">
                                <label for="customer_name">Name</label>
                                <input type="text" class="form-control" id="customer_name" name="customer_name" aria-describedby="customerName" placeholder="Enter Name">
                            </div>
                        
                            <div class="form-group">
                                <label for="customer_phone">Phone Number</label>
                                <input type="text" class="form-control" id="customer_phone" name="customer_phone" placeholder="Enter Phone Number">
                            </div>
                        <div class="text-left">
                            <h2 class="section-subheading text-muted">Choose Date and Time</h2>
                        </div>
                        <label for="datetime">Select Date and Time:</label>
                        <input type="datetime-local" name="datetime" required><br>
                        
                    <input type="submit" value="Book Appointment">
                </form>
            </div>
        </section>
        
        <section>
            <div class="overview-container">
                <div id="selectedServices" class="info-container">
                    <strong>Selected Services:</strong>
                    <ul id="selectedServicesList"></ul>
                </div>

                <div id="selectedBarberInfo" class="info-container">
                    <strong>Selected Barber:</strong>
                    <p id="selectedBarberName"></p>
                    <img id="selectedBarberImage" class="barber-image" alt="Selected Barber Image">
                </div>
            
                <div id="totalDuration" class="info-container">
                    <strong>Total Duration:</strong> 0 minutes
                </div>
            
                <div id="dateTimeInfo" class="info-container">
                    <strong>Date and Time:</strong>
                    <p id="startDateTime"></p>
                    <p id="endDateTime"></p>
                </div>

                <div id="totalPrice" class="info-container">
                    <strong>Total Price:</strong> RM 0.00
                </div>

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
