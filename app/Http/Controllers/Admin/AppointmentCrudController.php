<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AppointmentRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Http\Models\Barber;
use App\Http\Models\Customer;

/**
 * Class AppointmentCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class AppointmentCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Appointment::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/appointment');
        CRUD::setEntityNameStrings('appointment', 'appointments');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        // CRUD::setFromDb(); // set columns from db columns.
        CRUD::column('id')->type('number')->label('Appointment ID');
        CRUD::column([
            'name' => 'customer',
            'label' => 'Customer',
            'type' => 'text',
            'value' => function ($entry) {
                return $entry->customer->name; // Assuming 'name' is the attribute to display
            },
        ]);
        CRUD::column([
            'name' => 'barber',
            'label' => 'Barber',
            'type' => 'text',
            'value' => function ($entry) {
                return $entry->barber->name; // Assuming 'name' is the attribute to display
            },
        ]);
         CRUD::column([
            'name' => 'services',
            'label' => 'Services',
            'type' => 'text',
            'value' => function ($entry) {
                return $entry->services->pluck('name')->implode(', '); // Assuming 'name' is the attribute to display
            },
        ]);
         CRUD::column('date')->type('date');
         CRUD::column('start_time')->type('time');
         CRUD::column('end_time')->type('time');
         CRUD::column('total_price')->type('number')->prefix('RM');
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(AppointmentRequest::class);
        CRUD::field('id')->type('number')->label('Appointment ID');
        CRUD::field([  // Select
            'label'     => "Customer",
            'type'      => 'select',
            'name'      => 'customer_id', // the db column for the foreign key
            'entity'    => 'customer',
            'model'     => "App\Models\Customer", // related model
            'attribute' => 'name', // foreign key attribute that is shown to user

         ]);

         CRUD::field([  // Select
            'label'     => "Barber",
            'type'      => 'select',
            'name'      => 'barber_id', // the db column for the foreign key
            'entity'    => 'barber',
            'model'     => "App\Models\Barber", // related model
            'attribute' => 'name', // foreign key attribute that is shown to user

         ]);
         CRUD::field([
            'name' => 'services',
            'label' => 'Services',
            'type' => 'select_multiple',
            'entity' => 'services',
            'attribute' => 'name', // Assuming 'name' is the attribute to display
        ]);
         CRUD::field('date')->type('date');
         CRUD::field('start_time')->type('time');
         CRUD::field('end_time')->type('time');
         CRUD::field('total_price')->type('number')->prefix('RM');
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
