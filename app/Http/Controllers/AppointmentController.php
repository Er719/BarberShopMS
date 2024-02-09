<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Barber;
use App\Models\Customer;
use App\Models\Services;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Redirect;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.   
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $appointments = Appointment::with('barber', 'services', 'customer')->get();
        return view('admin_pages.appointment', compact('appointments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $barbers = Barber::all();
        $services = Services::all();

        return view('customer_pages.booking', compact('barbers', 'services'));
    }


    public function store(Request $request)
    {   
        // Validate the form data
        $validatedData = $request->validate([
            'services_id' => 'required|exists:services,id',
            'barber_id' => 'required|exists:barbers,id',
            'customer_name' => 'required|string',
            'customer_phone' => 'required|string',
            'datetime' => 'required|date',
        ]);

        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        // Check if the selected date is not in the past
        $selectedDate = Carbon::createFromFormat('Y-m-d\TH:i', $validatedData['datetime'])->startOfDay();
        $today = Carbon::now()->startOfDay();

        if ($selectedDate->lt($today)) {
            throw ValidationException::withMessages(['datetime' => 'Appointments cannot be made for a past date.']);
        }

        // Check if the new appointment time is available within the time period of existing appointments
        $newDateTime = Carbon::createFromFormat('Y-m-d\TH:i', $validatedData['datetime']);

        $existingAppointments = Appointment::where('barber_id', $validatedData['barber_id'])
            ->where('date', $newDateTime->format('Y-m-d')) // Compare with date
            ->where(function ($query) use ($newDateTime) {
                $query->where(function ($q) use ($newDateTime) {
                    $q->where('start_time', '<=', $newDateTime->format('H:i:s'))
                        ->where('end_time', '>', $newDateTime->format('H:i:s'));
                })->orWhere(function ($q) use ($newDateTime) {
                    $q->where('start_time', '<', $newDateTime->addMinutes(1)->format('H:i:s'))
                        ->where('end_time', '>=', $newDateTime->subMinutes(1)->format('H:i:s'));
                });
            })->exists();

        if ($existingAppointments) {
            throw ValidationException::withMessages(['datetime' => 'This time slot is already booked.']);
        }
        // Extract date and time
        $dateTime = Carbon::createFromFormat('Y-m-d\TH:i', $validatedData['datetime']);
        $date = $dateTime->format('Y-m-d');
        $start_time = $dateTime->format('H:i');

        // Fetch selected services
        $selectedServices = Services::find($validatedData['services_id']);

        // Calculate total price
        $totalPrice = $selectedServices->sum('price');

        // Calculate total duration
        $totalDuration = $selectedServices->sum('duration_minutes'); // Assuming 'duration' is in minutes

        // Calculate end time
        $endDateTime = $dateTime->copy()->addMinutes($totalDuration);
        $end_time = $endDateTime->format('H:i');

        // Create customer
        $customer = Customer::create([
            'name' => $validatedData['customer_name'],
            'phone_number' => $validatedData['customer_phone'],
        ]);

        // Create appointment
        $appointment = Appointment::create([
            'barber_id' => $validatedData['barber_id'],
            'customer_id' => $customer->id,
            'date' => $date,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'total_price' => $totalPrice
        ]);
        // Flash success message to the session
        Session::flash('success', 'Appointment created successfully! Your code is: '. $appointment->appointment_code);

        // Attach selected services to the appointment
        $appointment->services()->attach($validatedData['services_id']);

        return redirect('/booking/confirm');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($code)
    {
        $appointment = Appointment::where('appointment_code', $code)->firstOrFail();
        return view('appointments.show', compact('appointment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($code)
    {
        $appointment = Appointment::where('appointment_code', $code)->firstOrFail();
        return view('appointments.edit', compact('appointment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $code)
    {
        $appointment = Appointment::where('appointment_code', $code)->firstOrFail();

        return redirect('appointments.editByCode', $code);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($code)
    {
        return redirect('home');
    }

    public function viewAppointments()
    {
        return view('customer_pages.view');
    }

    public function showByCode(Request $request)
    {
        $appointment_code = $request->input('appointment_code');
        $appointment = Appointment::where('appointment_code', $appointment_code)->first();

        return view('customer_pages.view', compact('appointment'));
    }

    public function editByCode($code)
    {
        $appointment = Appointment::where('appointment_code', $code)->firstOrFail();
        $barbers = Barber::all();
        $services = Services::all();
        return view('customer_pages.edit', compact('appointment', 'barbers', 'services'));
    }

    public function updateByCode(Request $request, $code)
    {
        $validatedData = $request->validate([
            'barber_id' => 'required|exists:barbers,id',
            'services' => 'required|array',
            'services.*' => 'required|exists:services,id',
            'customer_name' => 'required|string',
            'customer_phone' => 'required|string',
            'datetime' => 'required|date',
        ]);

        //Find the appointment based on the appointment code
        $appointment = Appointment::where('appointment_code', $code)->firstOrFail();

        // Check if the selected date is not in the past
        $selectedDate = Carbon::createFromFormat('Y-m-d\TH:i', $validatedData['datetime'])->startOfDay();
        $today = Carbon::now()->startOfDay();

        if ($selectedDate->lt($today)) {
            throw ValidationException::withMessages(['datetime' => 'Appointments cannot be made for a past date.']);
        }
        // Check if the new appointment time is available within the time period of existing appointments
        $newDateTime = Carbon::createFromFormat('Y-m-d\TH:i', $validatedData['datetime']);

        $existingAppointments = Appointment::where('id', '<>', $appointment->id)
            ->where('barber_id', $validatedData['barber_id'])
            ->where('date', $newDateTime->format('Y-m-d')) // Compare with date
            ->where(function ($query) use ($newDateTime) {
                $query->where(function ($q) use ($newDateTime) {
                    $q->where('start_time', '<=', $newDateTime->format('H:i:s'))
                        ->where('end_time', '>', $newDateTime->format('H:i:s'));
                })->orWhere(function ($q) use ($newDateTime) {
                    $q->where('start_time', '<', $newDateTime->addMinutes(1)->format('H:i:s'))
                        ->where('end_time', '>=', $newDateTime->subMinutes(1)->format('H:i:s'));
                });
            })->exists();

        if ($existingAppointments) {
            throw ValidationException::withMessages(['datetime' => 'This time slot is already booked.']);
        }

        // Extract date and time from the updated data
        $dateTime = Carbon::createFromFormat('Y-m-d\TH:i', $validatedData['datetime']);
        $date = $dateTime->format('Y-m-d');
        $start_time = $dateTime->format('H:i');

        // Update the basic appointment data
        $appointment->update([
            'barber_id' => $validatedData['barber_id'],
            'datetime' => $validatedData['datetime'],
            'date' => $date, // Update date
            'start_time' => $start_time, // Update start time
        ]);

        // Update the associated customer data
        $appointment->customer->update([
            'name' => $validatedData['customer_name'],
            'phone_number' => $validatedData['customer_phone'],
        ]);

        // Sync the associated services using the services relationship
        $appointment->services()->sync($validatedData['services']);

        // Recalculate total price, total duration, and end time
        $dateTime = Carbon::createFromFormat('Y-m-d\TH:i', $validatedData['datetime']);
        $totalDuration = $appointment->services->sum('duration_minutes'); // Assuming 'duration' is in minutes

        $endDateTime = $dateTime->copy()->addMinutes($totalDuration);
        $end_time = $endDateTime->format('H:i');

        $appointment->update([
            'total_price' => $appointment->services->sum('price'),
            'end_time' => $end_time,
        ]);

        return redirect('/appointments/view');
    }
}
