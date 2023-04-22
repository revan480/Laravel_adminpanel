<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use BackPack\CRUD\app\Library\Widget;

/**
 * Class RegistrationController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class RegistrationController extends Controller
{
    public function index()
    {
        return view('admin.registration', [
            'title' => 'Registration',
            'breadcrumbs' => [
                trans('backpack::crud.admin') => backpack_url('dashboard'),
                'Registration' => false,
            ],
            'page' => 'resources/views/admin/registration.blade.php',
            'controller' => 'app/Http/Controllers/Admin/RegistrationController.php',
            'doctors' => DB::table('doctors')->select('name')->get(),
            'rooms' => DB::table('rooms')->select('number')->get(),
            'bills' => DB::table('bills')->select('name')->get(),

        ]);
    }

    // Register function
    public function store(Request $request){


        $request->validate([
            'name' => 'required',
            'surname' => 'required',
            'phone' => 'required',
            'area' => 'required',
            'price' => 'required',
            'doctor' => 'required',
            'room' => 'required',
            'bill' => 'required',
            'feedback' => 'nullable',
        ]);

        DB::table('patients')->insert([
            'name' => $request->name,
            'surname' => $request->surname,
            'phone' => $request->phone,
            'area' => $request->area,
            'price' => $request->price,
            'doctor_name' => $request->doctor,
            'room_number' => $request->room,
            'bill_type' => $request->bill,
            'feedback' => $request->feedback,
            'date' => $request->date,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('page.registration.index')->with('success', 'Patient registered successfully!');
    }
}
