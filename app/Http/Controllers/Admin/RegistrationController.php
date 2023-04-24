<?php

namespace App\Http\Controllers\Admin;

use App\Models\Patient;
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
            'doctors' => DB::table('doctors')->get(),
            'rooms' => DB::table('rooms')->get(),
            'bills' => DB::table('bills')->get(),
            'packets' => DB::table('packets')->get(),
        ]);
    }

    // Register function
    public function store(Request $request){

        // dd($request);
        $request->validate([
            'name' => 'required',
            'surname' => 'required',
            'phone' => 'required',
            'area' => 'required',
            'price' => 'required',
            'doctor' => 'required',
            'room' => 'required',
            'bill' => 'required',
            'packet' => 'nullable',
            'feedback' => 'nullable',
        ]);

        // Add all the information to the tables using DB
        DB::table('patients')->insert([
            'name' => $request->name,
            'surname' => $request->surname,
            'phone' => $request->phone,
            'area' => $request->area,
            'price' => $request->price,
            'doctor_id' => $request->doctor,
            'room_id' => $request->room,
            'bill_id' => $request->bill,
            'packet_id' => $request->packet == null ? 4 : $request->packet,
            'feedback' => $request->feedback,
            'date' => $request->date,
        ]);

        return redirect()->route('page.registration.index')->with('success', 'Patient registered successfully!');
    }
}
