<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PatientRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PatientCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PatientCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Patient::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/patient');
        CRUD::setEntityNameStrings('patient', 'patients');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('id');
        CRUD::column('name');
        CRUD::column('surname');
        CRUD::column('phone');
        CRUD::column('area');
        CRUD::column('price');
        CRUD::addColumn(
            [
                'name' => 'doctor_id',
                'type' => 'select',
                'label' => 'Doctor',
                'entity' => 'doctor',
                'attribute' => 'name',
                'model' => 'App\Models\Doctor',
            ]
        );
        CRUD::addColumn(
            [
                'name' => 'room_id',
                'type' => 'select',
                'label' => 'Room',
                'entity' => 'room',
                'attribute' => 'number',
                'model' => 'App\Models\Room',
            ]
        );
        CRUD::addColumn(
            [
                'name' => 'bill_id',
                'type' => 'select',
                'label' => 'Bill',
                'entity' => 'bill',
                'attribute' => 'type',
                'model' => 'App\Models\Bill',
            ]
        );
        CRUD::addColumn([
            'name' => 'packet_id',
            'type' => 'select',
            'label' => 'Packet',
            'entity' => 'packet',
            'attribute' => 'name',
            'model' => 'App\Models\Packet',
        ]);
        CRUD::column('feedback');
        CRUD::column('date');

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::field('name');
        CRUD::field('surname');
        CRUD::field('phone');
        CRUD::field('area');
        CRUD::field('price');
        CRUD::field('doctor_id');
        // CRUD::field('room_id');
        // CRUD::field('bill_id');
        CRUD::field('feedback');
        CRUD::field('date');

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
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
