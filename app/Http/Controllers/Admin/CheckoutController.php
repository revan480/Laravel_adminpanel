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
            //  Take all info from bills table
            'bills' => DB::table('bills')->get()
            ]);
    }

    public function checkout(Request $request){
        // dd($request);
        // If request consist of only the room number show all patients with this room number
        if($request->room_selector != "-" && $request->doctor_name == "-" &&
            $request->fromDate == null && $request->untilDate == null && $request->card =='-'){
            // Show patients within this room
            $patients = DB::table('patients')->where('room_number', $request->room_selector)->get();
            // Total bill for the given patients
            $total_bill = DB::table('patients')->where('room_number', $request->room_selector)->sum('price');
        }

        // If request consist of only fromDate and untilDate show all patients from fromDate date until untilDate date
        elseif($request->room_selector == "-" && $request->doctor_name == "-" &&
            $request->fromDate != null && $request->untilDate != null && $request->card=='-'){
            // Show patients within this room
            $patients = DB::table('patients')->whereBetween('date', [date('Y-m-d', strtotime($request->fromDate. ' - 1 days')), date('Y-m-d', strtotime($request->untilDate. ' + 1 days'))])->get();
            // Total bill for the given patients
            $total_bill = DB::table('patients')->whereBetween('date', [date('Y-m-d', strtotime($request->fromDate. ' - 1 days')), date('Y-m-d', strtotime($request->untilDate. ' + 1 days'))])->sum('price');
        }

        // If request consist of only the card number show all patients with this card number
        elseif($request->room_selector == "-" && $request->doctor_name == "-" &&
            $request->fromDate == null && $request->untilDate == null && $request->card!='-'){
            // Show patients within this room
            $patients = DB::table('patients')->where('bill_type', $request->card)->get();
            // Total bill for the given patients
            $total_bill = DB::table('patients')->where('bill_type', $request->card)->sum('price');
        }

        // If request consist of only the room number and fromDate and untilDate show all patients with this room number and fromDate and untilDate
        elseif($request->room_selector != "-" && $request->doctor_name == "-" &&
            $request->fromDate != null && $request->untilDate != null && $request->card=='-'){
            // Show patients within this room
            $patients = DB::table('patients')->where('room_number', $request->room_selector)->whereBetween('date', [date('Y-m-d', strtotime($request->fromDate. ' - 1 days')), date('Y-m-d', strtotime($request->untilDate. ' + 1 days'))])->get();
            // Total bill for the given patients
            $total_bill = DB::table('patients')->where('room_number', $request->room_selector)->whereBetween('date', [date('Y-m-d', strtotime($request->fromDate. ' - 1 days')), date('Y-m-d', strtotime($request->untilDate. ' + 1 days'))])->sum('price');
        }

        // If request consist of only the room number and card number show all patients with this room number and card number
        elseif($request->room_selector != "-" && $request->doctor_name == "-" &&
            $request->fromDate == null && $request->untilDate == null && $request->card!='-'){
            // Show patients within this room
            $patients = DB::table('patients')->where('room_number', $request->room_selector)->where('bill_type', $request->card)->get();
            // Total bill for the given patients
            $total_bill = DB::table('patients')->where('room_number', $request->room_selector)->where('bill_type', $request->card)->sum('price');
        }

        // If request consist of only the fromDate and untilDate and card number show all patients with this fromDate and untilDate and card number
        elseif($request->room_selector == "-" && $request->doctor_name == "-" &&
            $request->fromDate != null && $request->untilDate != null && $request->card!='-'){
            // Show patients within this room
            $patients = DB::table('patients')->whereBetween('date', [date('Y-m-d', strtotime($request->fromDate. ' - 1 days')), date('Y-m-d', strtotime($request->untilDate. ' + 1 days'))])->where('bill_type', $request->card)->get();
            // Total bill for the given patients
            $total_bill = DB::table('patients')->whereBetween('date', [date('Y-m-d', strtotime($request->fromDate. ' - 1 days')), date('Y-m-d', strtotime($request->untilDate. ' + 1 days'))])->where('bill_type', $request->card)->sum('price');
        }

        // If request consist of only the doctor name show all patients with this doctor name
        elseif($request->room_selector == "-" && $request->doctor_name != "-" &&
            $request->fromDate == null && $request->untilDate == null && $request->card == "-"){
            // Show patients within this room
            $patients = DB::table('patients')->where('doctor_name', $request->doctor_name)->get();
            // Total bill for the given patients
            $total_bill = DB::table('patients')->where('doctor_name', $request->doctor_name)->sum('price');
        }

        // If request consist of only the room number and doctor name show all patients with this room number and doctor name

        elseif($request->room_selector != "-" && $request->doctor_name != "-" &&
            $request->fromDate == null && $request->untilDate==null && $request->card == "-"){
            // Show patients within this room
            $patients = DB::table('patients')->where('room_number', $request->room_selector)->where('doctor_name', $request->doctor_name)->get();
            // Total bill for the given patients
            $total_bill = DB::table('patients')->where('room_number', $request->room_selector)->where('doctor_name', $request->doctor_name)->sum('price');
        }

        // If request consist of only the fromDate and untilDate and doctor name show all patients with this fromDate and untilDate and doctor name
        elseif($request->room_selector == "-" && $request->doctor_name != "-" &&
            $request->fromDate != null && $request->untilDate!=null && $request->card == "-"){
            // Show patients within this room
            $patients = DB::table('patients')->whereBetween('date', [date('Y-m-d', strtotime($request->fromDate. ' - 1 days')), date('Y-m-d', strtotime($request->untilDate. ' + 1 days'))])->where('doctor_name', $request->doctor_name)->get();
            // Total bill for the given patients
            $total_bill = DB::table('patients')->whereBetween('date', [date('Y-m-d', strtotime($request->fromDate. ' - 1 days')), date('Y-m-d', strtotime($request->untilDate. ' + 1 days'))])->where('doctor_name', $request->doctor_name)->sum('price');
        }

        // If request consist of only the card number and doctor name show all patients with this card number and doctor name
        elseif($request->room_selector == "-" && $request->doctor_name != "-" &&
            $request->fromDate == null && $request->untilDate==null && $request->card!='-'){
            // Show patients within this room
            $patients = DB::table('patients')->where('bill_type', $request->card)->where('doctor_name', $request->doctor_name)->get();
            // Total bill for the given patients
            $total_bill = DB::table('patients')->where('bill_type', $request->card)->where('doctor_name', $request->doctor_name)->sum('price');
        }

        // If request consist of only the room number and fromDate and untilDate and doctor name show all patients with this room number and fromDate and untilDate and doctor name
        elseif($request->room_selector != "-" && $request->doctor_name != "-" &&
            $request->fromDate != null && $request->untilDate!=null && $request->card == "-"){
            // Show patients within this room
            $patients = DB::table('patients')->where('room_number', $request->room_selector)->whereBetween('date', [date('Y-m-d', strtotime($request->fromDate. ' - 1 days')), date('Y-m-d', strtotime($request->untilDate. ' + 1 days'))])->where('doctor_name', $request->doctor_name)->get();
            // Total bill for the given patients
            $total_bill = DB::table('patients')->where('room_number', $request->room_selector)->whereBetween('date', [date('Y-m-d', strtotime($request->fromDate. ' - 1 days')), date('Y-m-d', strtotime($request->untilDate. ' + 1 days'))])->where('doctor_name', $request->doctor_name)->sum('price');
        }

        // If request consist of only the room number and card number and doctor name show all patients with this room number and card number and doctor name
        elseif($request->room_selector != "-" && $request->doctor_name != "-" &&
            $request->fromDate == null && $request->untilDate==null && $request->card!='-'){
            // Show patients within this room
            $patients = DB::table('patients')->where('room_number', $request->room_selector)->where('bill_type', $request->card)->where('doctor_name', $request->doctor_name)->get();
            // Total bill for the given patients
            $total_bill = DB::table('patients')->where('room_number', $request->room_selector)->where('bill_type', $request->card)->where('doctor_name', $request->doctor_name)->sum('price');
        }

        // If request consist of only the fromDate and untilDate and card number and doctor name show all patients with this fromDate and untilDate and card number and doctor name
        elseif($request->room_selector == "-" && $request->doctor_name != "-" &&
            $request->fromDate != null && $request->untilDate!=null && $request->card!='-'){
            // Show patients within this room
            $patients = DB::table('patients')->whereBetween('date', [date('Y-m-d', strtotime($request->fromDate. ' - 1 days')), date('Y-m-d', strtotime($request->untilDate. ' + 1 days'))])->where('bill_type', $request->card)->where('doctor_name', $request->doctor_name)->get();
            // Total bill for the given patients
            $total_bill = DB::table('patients')->whereBetween('date', [date('Y-m-d', strtotime($request->fromDate. ' - 1 days')), date('Y-m-d', strtotime($request->untilDate. ' + 1 days'))])->where('bill_type', $request->card)->where('doctor_name', $request->doctor_name)->sum('price');
        }

        // If request consist of only the room number and fromDate and untilDate and card number and doctor name show all patients with this room number and fromDate and untilDate and card number and doctor name
        elseif($request->room_selector != "-" && $request->doctor_name != "-" &&
            $request->fromDate != null && $request->untilDate!= null && $request->card!='-'){
            // Show patients within this room
            $patients = DB::table('patients')->where('room_number', $request->room_selector)->whereBetween('date', [date('Y-m-d', strtotime($request->fromDate. ' - 1 days')), date('Y-m-d', strtotime($request->untilDate. ' + 1 days'))])->where('bill_type', $request->card)->where('doctor_name', $request->doctor_name)->get();
            // Total bill for the given patients
            $total_bill = DB::table('patients')->where('room_number', $request->room_selector)->whereBetween('date', [date('Y-m-d', strtotime($request->fromDate. ' - 1 days')), date('Y-m-d', strtotime($request->untilDate. ' + 1 days'))])->where('bill_type', $request->card)->where('doctor_name', $request->doctor_name)->sum('price');
        }

        // Else show all
        else{
            // Show all patients
            $patients = DB::table('patients')->get();
            // Total bill for the given patients
            $total_bill = DB::table('patients')->sum('price');
        }

        // Return
        return view('/admin/checkout', [
            'patients' => $patients,
            'rooms' => DB::table('rooms')->select('number')->get(),
            'doctors' => DB::table('doctors')->select('name')->get(),
            'bills' => DB::table('bills')->get(),
            'total_bill' => $total_bill,
        ]);
    }
}
