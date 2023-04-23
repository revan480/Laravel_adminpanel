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
            'rooms' => DB::table('rooms')->get(),
            // Take doctors from table doctors
            'doctors' => DB::table('doctors')->get(),
            // Take patients from table patients
            'patients' => DB::table('patients')->get(),
            // Take total bill from table patients
            'total_bill' => DB::table('patients')->sum('price'),
            // Take bill from table bills
            'bills' => DB::table('bills')->get(),
            // Take packets from table packets
            'packets' => DB::table('packets')->get(),
            ]);
    }

    public function checkout(Request $request){
        // dd($request);
        // if request consist of only the room number show all patients with this room number
        if($request->room_selector != "-" && $request->doctor_name == "-" &&
            $request->fromDate == null && $request->untilDate == null && $request->card =='-' && $request->packet == '-'){
                // Join two tables patients and rooms
                $patients = DB::table('patients')->join('rooms', 'patients.room_id', '=', 'rooms.id')->select('patients.*', 'rooms.id')->where('rooms.id', $request->room_selector)->get();

                // Get total bill
                $total_bill = 0;
                foreach($patients as $patient){
                    $total_bill += $patient->price;
                }
        }

        // elseif request consist of only the doctor name show all patients with this doctor name
        elseif($request->room_selector == "-" && $request->doctor_name != "-" &&
            $request->fromDate == null && $request->untilDate == null && $request->card =='-' && $request->packet == '-'){
                // Join two tables patients and doctors
                $patients = DB::table('patients')->join('doctors', 'patients.doctor_id', '=', 'doctors.id')->select('patients.*', 'doctors.id')->where('doctors.id', $request->doctor_name)->get();

                // Get total bill
                $total_bill = 0;
                foreach($patients as $patient){
                    $total_bill += $patient->price;
                }
        }

        // elseif request consist of only the card number show all patients with this card number
        elseif($request->room_selector == "-" && $request->doctor_name == "-" &&
            $request->fromDate == null && $request->untilDate == null && $request->card !='-' && $request->packet == '-'){
                // Join two tables patients and bills
                $patients = DB::table('patients')->join('bills', 'patients.bill_id', '=', 'bills.id')->select('patients.*', 'bills.id')->where('bills.id', $request->card)->get();

                // Get total bill
                $total_bill = 0;
                foreach($patients as $patient){
                    $total_bill += $patient->price;
                }
        }

        // elseif request consist of only the packet name show all patients with this packet name
        elseif($request->room_selector == "-" && $request->doctor_name == "-" &&
            $request->fromDate == null && $request->untilDate == null && $request->card =='-' && $request->packet != '-'){
                // Join two tables patients and packets
                $patients = DB::table('patients')->join('packets', 'patients.packet_id', '=', 'packets.id')->select('patients.*', 'packets.id')->where('packets.id', $request->packet)->get();

                // Get total bill
                $total_bill = 0;
                foreach($patients as $patient){
                    $total_bill += $patient->price;
                }
        }

        // elseif request consist of only the from date show all patients with this from date
        // elseif($request->room_selector == "-" && $request->doctor_name == "-" &&
        //     $request->fromDate != null && $request->untilDate == null && $request->card =='-' && $request->packet == '-'){
        //         // Join two tables patients and bills
        //         $patients = DB::table('patients')->join('bills', 'patients.bill_id', '=', 'bills.id')->select('patients.*', 'bills.id')->where('bills.date', '>=', $request->fromDate)->get();

        //         // Get total bill
        //         $total_bill = 0;
        //         foreach($patients as $patient){
        //             $total_bill += $patient->price;
        //         }
        // }

        // elseif request consist of only the until date show all patients with this until date
        // elseif($request->room_selector == "-" && $request->doctor_name == "-" &&
        //     $request->fromDate == null && $request->untilDate != null && $request->card =='-' && $request->packet == '-'){
        //         // Join two tables patients and bills
        //         $patients = DB::table('patients')->join('bills', 'patients.bill_id', '=', 'bills.id')->select('patients.*', 'bills.id')->where('bills.date', '<=', $request->untilDate)->get();

        //         // Get total bill
        //         $total_bill = 0;
        //         foreach($patients as $patient){
        //             $total_bill += $patient->price;
        //         }
        // }

        // elseif request consist of only the from date and until date show all patients with this from date and until date
        elseif($request->room_selector == "-" && $request->doctor_name == "-" &&
            $request->fromDate != null && $request->untilDate != null && $request->card =='-' && $request->packet == '-'){
                // Join two tables patients and bills
                $patients = DB::table('patients')->join('bills', 'patients.bill_id', '=', 'bills.id')->select('patients.*', 'bills.id')->whereBetween('patients.date', [date('Y-m-d', strtotime($request->fromDate, '+1 day')), date('Y-m-d', strtotime($request->untilDate, '-1 day'))])->get();

                // Get total bill
                $total_bill = 0;
                foreach($patients as $patient){
                    $total_bill += $patient->price;
                }
        }

        // elseif request consist of only the room number and doctor name show all patients with this room number and doctor name
        elseif($request->room_selector != "-" && $request->doctor_name != "-" &&
            $request->fromDate == null && $request->untilDate == null && $request->card =='-' && $request->packet == '-'){
                // Join three tables patients, rooms and doctors
                $patients = DB::table('patients')->join('rooms', 'patients.room_id', '=', 'rooms.id')->join('doctors', 'patients.doctor_id', '=', 'doctors.id')->select('patients.*', 'rooms.id', 'doctors.id')->where('rooms.id', $request->room_selector)->where('doctors.id', $request->doctor_name)->get();

                // Get total bill
                $total_bill = 0;
                foreach($patients as $patient){
                    $total_bill += $patient->price;
                }
        }

        // elseif request consist of only the room number and card number show all patients with this room number and card number
        elseif($request->room_selector != "-" && $request->doctor_name == "-" &&
            $request->fromDate == null && $request->untilDate == null && $request->card !='-' && $request->packet == '-'){
                // Join three tables patients, rooms and bills
                $patients = DB::table('patients')->join('rooms', 'patients.room_id', '=', 'rooms.id')->join('bills', 'patients.bill_id', '=', 'bills.id')->select('patients.*', 'rooms.id', 'bills.id')->where('rooms.id', $request->room_selector)->where('bills.id', $request->card)->get();

                // Get total bill
                $total_bill = 0;
                foreach($patients as $patient){
                    $total_bill += $patient->price;
                }
        }

        // elseif request consist of only the room number and packet name show all patients with this room number and packet name
        elseif($request->room_selector != "-" && $request->doctor_name == "-" &&
            $request->fromDate == null && $request->untilDate == null && $request->card =='-' && $request->packet != '-'){
                // Join three tables patients, rooms and packets
                $patients = DB::table('patients')->join('rooms', 'patients.room_id', '=', 'rooms.id')->join('packets', 'patients.packet_id', '=', 'packets.id')->select('patients.*', 'rooms.id', 'packets.id')->where('rooms.id', $request->room_selector)->where('packets.id', $request->packet)->get();

                // Get total bill
                $total_bill = 0;
                foreach($patients as $patient){
                    $total_bill += $patient->price;
                }
        }

        // elseif request consist of only the room number and fromDate and untilDate show all patients with this room number and within this date range
        elseif($request->room_selector != "-" && $request->doctor_name == "-" &&
            $request->fromDate != null && $request->untilDate != null && $request->card =='-' && $request->packet == '-'){
                // Join three tables patients, rooms and bills
                $patients = DB::table('patients')->join('rooms', 'patients.room_id', '=', 'rooms.id')->join('bills', 'patients.bill_id', '=', 'bills.id')->select('patients.*', 'rooms.id', 'bills.id')->where('rooms.id', $request->room_selector)->whereBetween('patients.date', [date('Y-m-d', strtotime($request->fromDate, '+1 day')), date('Y-m-d', strtotime($request->untilDate, '-1 day'))])->get();

                // Get total bill
                $total_bill = 0;
                foreach($patients as $patient){
                    $total_bill += $patient->price;
                }
        }

        // elseif request consist of only the doctor name and card name show all patients with this doctor name and card name
        elseif($request->room_selector == "-" && $request->doctor_name != "-" &&
            $request->fromDate == null && $request->untilDate == null && $request->card !='-' && $request->packet == '-'){
                // Join three tables patients, doctors and bills
                $patients = DB::table('patients')->join('doctors', 'patients.doctor_id', '=', 'doctors.id')->join('bills', 'patients.bill_id', '=', 'bills.id')->select('patients.*', 'doctors.id', 'bills.id')->where('doctors.id', $request->doctor_name)->where('bills.id', $request->card)->get();

                // Get total bill
                $total_bill = 0;
                foreach($patients as $patient){
                    $total_bill += $patient->price;
                }
        }

        // elseif request consist of only the doctor name and packet name show all patients with this doctor name and packet name
        elseif($request->room_selector == "-" && $request->doctor_name != "-" &&
            $request->fromDate == null && $request->untilDate == null && $request->card =='-' && $request->packet != '-'){
                // Join three tables patients, doctors and packets
                $patients = DB::table('patients')->join('doctors', 'patients.doctor_id', '=', 'doctors.id')->join('packets', 'patients.packet_id', '=', 'packets.id')->select('patients.*', 'doctors.id', 'packets.id')->where('doctors.id', $request->doctor_name)->where('packets.id', $request->packet)->get();

                // Get total bill
                $total_bill = 0;
                foreach($patients as $patient){
                    $total_bill += $patient->price;
                }
        }

        // elseif request consist of only the doctor name and fromDate and untilDate show all patients with this doctor name and within this date range
        elseif($request->room_selector == "-" && $request->doctor_name != "-" &&
            $request->fromDate != null && $request->untilDate != null && $request->card =='-' && $request->packet == '-'){
                // Join three tables patients, doctors and bills
                $patients = DB::table('patients')->join('doctors', 'patients.doctor_id', '=', 'doctors.id')->join('bills', 'patients.bill_id', '=', 'bills.id')->select('patients.*', 'doctors.id', 'bills.id')->where('doctors.id', $request->doctor_name)->whereBetween('patients.date', [date('Y-m-d', strtotime($request->fromDate, '+1 day')), date('Y-m-d', strtotime($request->untilDate, '-1 day'))])->get();

                // Get total bill
                $total_bill = 0;
                foreach($patients as $patient){
                    $total_bill += $patient->price;
                }
        }

        // elseif request consist of only the card number and packet name show all patients with this card number and packet name
        elseif($request->room_selector == "-" && $request->doctor_name == "-" &&
            $request->fromDate == null && $request->untilDate == null && $request->card !='-' && $request->packet != '-'){
                // Join three tables patients, bills and packets
                $patients = DB::table('patients')->join('bills', 'patients.bill_id', '=', 'bills.id')->join('packets', 'patients.packet_id', '=', 'packets.id')->select('patients.*', 'bills.id', 'packets.id')->where('bills.id', $request->card)->where('packets.id', $request->packet)->get();

                // Get total bill
                $total_bill = 0;
                foreach($patients as $patient){
                    $total_bill += $patient->price;
                }
        }

        // elseif request consist of only the card number and fromDate and untilDate show all patients with this card number and within this date range
        elseif($request->room_selector == "-" && $request->doctor_name == "-" &&
            $request->fromDate != null && $request->untilDate != null && $request->card !='-' && $request->packet == '-'){
                // Join three tables patients, bills and packets
                $patients = DB::table('patients')->join('bills', 'patients.bill_id', '=', 'bills.id')->select('patients.*', 'bills.id')->where('bills.id', $request->card)->whereBetween('patients.date', [date('Y-m-d', strtotime($request->fromDate, '+1 day')), date('Y-m-d', strtotime($request->untilDate, '-1 day'))])->get();

                // Get total bill
                $total_bill = 0;
                foreach($patients as $patient){
                    $total_bill += $patient->price;
                }
        }

        // elseif request consist of only the packet name and fromDate and untilDate show all patients with this packet name and within this date range
        elseif($request->room_selector == "-" && $request->doctor_name == "-" &&
            $request->fromDate != null && $request->untilDate != null && $request->card =='-' && $request->packet != '-'){
                // Join three tables patients, bills and packets
                $patients = DB::table('patients')->join('packets', 'patients.packet_id', '=', 'packets.id')->join('bills', 'patients.bill_id', '=', 'bills.id')->select('patients.*', 'packets.id', 'bills.id')->where('packets.id', $request->packet)->whereBetween('patients.date', [date('Y-m-d', strtotime($request->fromDate, '+1 day')), date('Y-m-d', strtotime($request->untilDate, '-1 day'))])->get();

                // Get total bill
                $total_bill = 0;
                foreach($patients as $patient){
                    $total_bill += $patient->price;
                }
        }

        // elseif request consist of only the room number and doctor name and card name
        elseif($request->room_selector != "-" && $request->doctor_name != "-" &&
            $request->fromDate == null && $request->untilDate == null && $request->card !='-' && $request->packet == '-'){
                // Join three tables patients, doctors and bills
                $patients = DB::table('patients')->join('doctors', 'patients.doctor_id', '=', 'doctors.id')->join('bills', 'patients.bill_id', '=', 'bills.id')->join('rooms', 'patients.room_id', '=', 'rooms.id')->select('patients.*', 'doctors.id', 'bills.id', 'rooms.id')->where('doctors.id', $request->doctor_name)->where('bills.id', $request->card)->where('rooms.id', $request->room_selector)->get();

                // Get total bill
                $total_bill = 0;
                foreach($patients as $patient){
                    $total_bill += $patient->price;
                }
        }

        // elseif request consist of only the room number and doctor name and packet name
        elseif($request->room_selector != "-" && $request->doctor_name != "-" &&
            $request->fromDate == null && $request->untilDate == null && $request->card =='-' && $request->packet != '-'){
                // Join three tables patients, doctors and packets
                $patients = DB::table('patients')->join('doctors', 'patients.doctor_id', '=', 'doctors.id')->join('packets', 'patients.packet_id', '=', 'packets.id')->join('rooms', 'patients.room_id', '=', 'rooms.id')->select('patients.*', 'doctors.id', 'packets.id', 'rooms.id')->where('doctors.id', $request->doctor_name)->where('packets.id', $request->packet)->where('rooms.id', $request->room_selector)->get();

                // Get total bill
                $total_bill = 0;
                foreach($patients as $patient){
                    $total_bill += $patient->price;
                }
        }

        // elseif request consist of only the room number and doctor name and fromDate and untilDate
        elseif($request->room_selector != "-" && $request->doctor_name != "-" &&
            $request->fromDate != null && $request->untilDate != null && $request->card =='-' && $request->packet == '-'){
                // Join three tables patients, doctors and bills
                $patients = DB::table('patients')->join('doctors', 'patients.doctor_id', '=', 'doctors.id')->join('bills', 'patients.bill_id', '=', 'bills.id')->join('rooms', 'patients.room_id', '=', 'rooms.id')->select('patients.*', 'doctors.id', 'bills.id', 'rooms.id')->where('doctors.id', $request->doctor_name)->whereBetween('patients.date', [date('Y-m-d', strtotime($request->fromDate, '+1 day')), date('Y-m-d', strtotime($request->untilDate, '-1 day'))])->where('rooms.id', $request->room_selector)->get();

                // Get total bill
                $total_bill = 0;
                foreach($patients as $patient){
                    $total_bill += $patient->price;
                }
        }

        // elseif request consist of only the room number and doctor name and fromDate and untilDate and card name
        elseif($request->room_selector != "-" && $request->doctor_name != "-" &&
            $request->fromDate != null && $request->untilDate != null && $request->card !='-' && $request->packet == '-'){
                // Join three tables patients, doctors and bills
                $patients = DB::table('patients')->join('doctors', 'patients.doctor_id', '=', 'doctors.id')->join('bills', 'patients.bill_id', '=', 'bills.id')->join('rooms', 'patients.room_id', '=', 'rooms.id')->select('patients.*', 'doctors.id', 'bills.id', 'rooms.id')->where('doctors.id', $request->doctor_name)->where('bills.id', $request->card)->whereBetween('patients.date', [date('Y-m-d', strtotime($request->fromDate, '+1 day')), date('Y-m-d', strtotime($request->untilDate, '-1 day'))])->where('rooms.id', $request->room_selector)->get();

                // Get total bill
                $total_bill = 0;
                foreach($patients as $patient){
                    $total_bill += $patient->price;
                }
        }

        // elseif request consist of only the room number and doctor name and fromDate and untilDate and packet name
        elseif($request->room_selector != "-" && $request->doctor_name != "-" &&
            $request->fromDate != null && $request->untilDate != null && $request->card =='-' && $request->packet != '-'){
                // Join three tables patients, doctors and packets
                $patients = DB::table('patients')->join('doctors', 'patients.doctor_id', '=', 'doctors.id')->join('packets', 'patients.packet_id', '=', 'packets.id')->join('bills', 'patients.bill_id', '=', 'bills.id')->join('rooms', 'patients.room_id', '=', 'rooms.id')->select('patients.*', 'doctors.id', 'packets.id', 'bills.id', 'rooms.id')->where('doctors.id', $request->doctor_name)->where('packets.id', $request->packet)->whereBetween('patients.date', [date('Y-m-d', strtotime($request->fromDate, '+1 day')), date('Y-m-d', strtotime($request->untilDate, '-1 day'))])->where('rooms.id', $request->room_selector)->get();

                // Get total bill
                $total_bill = 0;
                foreach($patients as $patient){
                    $total_bill += $patient->price;
                }
        }

        // elseif request consist of only the room number and doctor name and fromDate and untilDate and card name and packet name
        elseif($request->room_selector != "-" && $request->doctor_name != "-" &&
            $request->fromDate != null && $request->untilDate != null && $request->card !='-' && $request->packet != '-'){
                // Join three tables patients, doctors and bills
                $patients = DB::table('patients')->join('doctors', 'patients.doctor_id', '=', 'doctors.id')->join('bills', 'patients.bill_id', '=', 'bills.id')->join('packets', 'patients.packet_id', '=', 'packets.id')->join('rooms', 'patients.room_id', '=', 'rooms.id')->select('patients.*', 'doctors.id', 'bills.id', 'packets.id', 'rooms.id')->where('doctors.id', $request->doctor_name)->where('bills.id', $request->card)->where('packets.id', $request->packet)->whereBetween('patients.date', [date('Y-m-d', strtotime($request->fromDate, '+1 day')), date('Y-m-d', strtotime($request->untilDate, '-1 day'))])->where('rooms.id', $request->room_selector)->get();

                // Get total bill
                $total_bill = 0;
                foreach($patients as $patient){
                    $total_bill += $patient->price;
                }
        }

        // elseif request consist of only the doctor name and card name and packet name
        elseif($request->room_selector == "-" && $request->doctor_name != "-" &&
            $request->fromDate == null && $request->untilDate == null && $request->card !='-' && $request->packet != '-'){
                // Join three tables patients, doctors and bills
                $patients = DB::table('patients')->join('doctors', 'patients.doctor_id', '=', 'doctors.id')->join('bills', 'patients.bill_id', '=', 'bills.id')->join('packets', 'patients.packet_id', '=', 'packets.id')->select('patients.*', 'doctors.id', 'bills.id', 'packets.id')->where('doctors.id', $request->doctor_name)->where('bills.id', $request->card)->where('packets.id', $request->packet)->get();

                // Get total bill
                $total_bill = 0;
                foreach($patients as $patient){
                    $total_bill += $patient->price;
                }
        }

        // elseif request consist of only the doctor name and card name and fromDate and untilDate
        elseif($request->room_selector == "-" && $request->doctor_name != "-" &&
            $request->fromDate != null && $request->untilDate != null && $request->card !='-' && $request->packet == '-'){
                // Join three tables patients, doctors and bills
                $patients = DB::table('patients')->join('doctors', 'patients.doctor_id', '=', 'doctors.id')->join('bills', 'patients.bill_id', '=', 'bills.id')->select('patients.*', 'doctors.id', 'bills.id')->where('doctors.id', $request->doctor_name)->where('patients.id', $request->card)->whereBetween('patients.date', [date('Y-m-d', strtotime($request->fromDate, '+1 day')), date('Y-m-d', strtotime($request->untilDate, '-1 day'))])->get();

                // Get total bill
                $total_bill = 0;
                foreach($patients as $patient){
                    $total_bill += $patient->price;
                }
        }

        // elseif request consist of only the doctor name and packet name and fromDate and untilDate
        elseif($request->room_selector == "-" && $request->doctor_name != "-" &&
            $request->fromDate != null && $request->untilDate != null && $request->card =='-' && $request->packet != '-'){
                // Join three tables patients, doctors and packets
                $patients = DB::table('patients')->join('doctors', 'patients.doctor_id', '=', 'doctors.id')->join('packets', 'patients.packet_id', '=', 'packets.id')->join('bills', 'patients.bill_id', '=', 'bills.id')->select('patients.*', 'doctors.id', 'packets.id', 'bills.id')->where('doctors.id', $request->doctor_name)->where('packets.id', $request->packet)->whereBetween('patients.date', [date('Y-m-d', strtotime($request->fromDate, '+1 day')), date('Y-m-d', strtotime($request->untilDate, '-1 day'))])->get();

                // Get total bill
                $total_bill = 0;
                foreach($patients as $patient){
                    $total_bill += $patient->price;
                }
        }

        // If none of them is seleted show all patients
        else{
            $patients = DB::table('patients')->join('doctors', 'patients.doctor_id', '=', 'doctors.id')->join('bills', 'patients.bill_id', '=', 'bills.id')->join('packets', 'patients.packet_id', '=', 'packets.id')->join('rooms', 'patients.room_id', '=', 'rooms.id')->select('patients.*', 'doctors.id', 'bills.id', 'packets.id', 'rooms.id')->get();

            // Get total bill
            $total_bill = 0;
            foreach($patients as $patient){
                $total_bill += $patient->price;
            }
        }

        // Return
        return view('/admin/checkout', [
            'patients' => $patients,
            'rooms' => DB::table('rooms')->get(),
            'doctors' => DB::table('doctors')->get(),
            'bills' => DB::table('bills')->get(),
            'packets' => DB::table('packets')->get(),
            'total_bill' => $total_bill,
        ]);
    }
}
