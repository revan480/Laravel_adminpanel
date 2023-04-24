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
        // dd($request->bill);

        $bill_id = DB::table('bills')->first()->id;
        $packet_id = DB::table('packets')->first()->id;
        // dd($request->bill);

        // Add to patients table
        $patient = new Patient();
        $patient->name = $request->name;
        $patient->surname = $request->surname;
        $patient->phone = $request->phone;
        $patient->area = $request->area;
        $patient->price = $request->price;
        $patient->doctor_id = $request->doctor;
        $patient->room_id = $request->room;
        // If $request->bill is equal to 1 write the value of bill_id
        // Else write the value of $request->bill
        // Since all the other field will have the value more that 1 we can use it
        // Also first raw should be Nəğd without any name in it
        $patient->bill_id = $request->bill == 1 ? $bill_id : $request->bill;
        $patient->packet_id = $request->packet == 1 ? $packet_id : $request->packet;
        $patient->feedback = $request->feedback;
        $patient->save();
        return redirect()->route('page.registration.index')->with('success', 'Patient registered successfully!');
    }
}
