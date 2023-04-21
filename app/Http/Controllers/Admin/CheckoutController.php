<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
/**
 * Class CheckoutController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CheckoutController extends Controller
{
    public function index()
    {
        return view('admin.checkout', [
            'title' => 'Checkout',
            'breadcrumbs' => [
                trans('backpack::crud.admin') => backpack_url('dashboard'),
                'Checkout' => false,
            ],
            'page' => 'resources/views/admin/checkout.blade.php',
            'controller' => 'app/Http/Controllers/Admin/CheckoutController.php',
            // Take rooms from table rooms
            'rooms' => DB::table('rooms')->select('number')->get(),
            // Take bill type
            'total_bill' => DB::table('patients')->sum('price'),
            // Take all info from patients table
            'patients' => DB::table('patients')->get(),
            // Take all info from docktors table
            'doctors' => DB::table('doctors')->get(),
            ]);
    }

    public function checkout(Request $request){
        // If request consist of only the room number show all patients with this room number
        if($request->room_selector != "-" && $request->checkin_date == null && $request->doctor_name == "-"){
            // Show patients within this room
            $patients = DB::table('patients')->where('room_number', $request->room_selector)->get();
            // Total bill for the given patients
            $total_bill = DB::table('patients')->where('room_number', $request->room_selector)->sum('price');
        }

        // If request consist of only the checkin date show all patients with this checkin date
        if($request->room_selector == "-" && $request->checkin_date != null && $request->doctor_name == "-"){
            // Show patients within this checkin date
            $patients = DB::table('patients')->where('created_at', $request->checkin_date)->get();
            // Total bill for the given patients
            $total_bill = DB::table('patients')->where('created_at', $request->checkin_date)->sum('price');
        }

        // If request consist of only the doctor name show all patients with this doctor name
        if($request->room_selector == "-" && $request->checkin_date == null && $request->doctor_name != "-"){
            // Show patients within this doctor name
            $patients = DB::table('patients')->where('doctor_name', $request->doctor_name)->get();
            // Total bill for the given patients
            $total_bill = DB::table('patients')->where('doctor_name', $request->doctor_name)->sum('price');
        }

        // If request consist of the room number and checkin date show all patients with this room number and checkin date
        if($request->room_selector != "-" && $request->checkin_date != null && $request->doctor_name == "-"){
            // Show patients within this room and checkin date
            $patients = DB::table('patients')->where('room_number', $request->room_selector)->where('created_at', $request->checkin_date)->get();
            // Total bill for the given patients
            $total_bill = DB::table('patients')->where('room_number', $request->room_selector)->where('created_at', $request->checkin_date)->sum('price');
        }

        // If request consist of the room number and doctor name show all patients with this room number and doctor name
        if($request->room_selector != "-" && $request->checkin_date == null && $request->doctor_name != "-"){
            // Show patients within this room and doctor name
            $patients = DB::table('patients')->where('room_number', $request->room_selector)->where('doctor_name', $request->doctor_name)->get();
            // Total bill for the given patients
            $total_bill = DB::table('patients')->where('room_number', $request->room_selector)->where('doctor_name', $request->doctor_name)->sum('price');
        }

        // If request consist of the checkin date and doctor name show all patients with this checkin date and doctor name
        if($request->room_selector == "-" && $request->checkin_date != null && $request->doctor_name != "-"){
            // Show patients within this checkin date and doctor name
            $patients = DB::table('patients')->where('created_at', $request->checkin_date)->where('doctor_name', $request->doctor_name)->get();
            // Total bill for the given patients
            $total_bill = DB::table('patients')->where('created_at', $request->checkin_date)->where('doctor_name', $request->doctor_name)->sum('price');
        }

        // If request consist of the room number, checkin date and doctor name show all patients with this room number, checkin date and doctor name

        if($request->room_selector != "-" && $request->checkin_date != null && $request->doctor_name != "-"){
            // Show patients within this room, checkin date and doctor name
            $patients = DB::table('patients')->where('room_number', $request->room_selector)->where('created_at', $request->checkin_date)->where('doctor_name', $request->doctor_name)->get();
            // Total bill for the given patients
            $total_bill = DB::table('patients')->where('room_number', $request->room_selector)->where('created_at', $request->checkin_date)->where('doctor_name', $request->doctor_name)->sum('price');
        }

        // Check if none of the inputs or selects are filled not allow to send the request
        if($request->room_selector == "-" && $request->checkin_date == null && $request->doctor_name == "-"){
            // Show patients within this room, checkin date and doctor name
            $patients = DB::table('patients')->get();
            // Total bill for the given patients
            $total_bill = DB::table('patients')->sum('price');
        }

        // Return
        return view('/admin/checkout', [
            'patients' => $patients,
            'rooms' => DB::table('rooms')->select('number')->get(),
            'doctors' => DB::table('doctors')->select('name')->get(),
            'total_bill' => $total_bill,
        ]);

    }
}
