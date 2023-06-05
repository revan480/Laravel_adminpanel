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
        // dd(DB::table('patients')->get());
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
            // Take patients from table patients by using pagination so that patients would appear 10 by 10
            'patients' => DB::table('patients')->paginate(10),
            // Take total bill from table patients
            'total_bill' => DB::table('patients')->sum('price'),
            // Take bill from table bills
            'bills' => DB::table('bills')->get(),
            // Take packets from table packets
            'packets' => DB::table('packets')->get(),
            'bill_id' => DB::table('bills')->first()->id,
            'packet_id' => DB::table('packets')->first()->id,
            ]);
    }

    public function checkout(Request $request){
        // If request consists of only room show all patients that have this room id
        // dd($request);
        if($request->room_selector != '-' && $request->doctor_name == '-' && $request->card == '-' && $request->packet == '-' &&
        $request->fromDate == null && $request->untilDate == null){
            $patients = DB::table('patients')->join('doctors', 'patients.doctor_id', '=', 'doctors.id')->join('bills', 'patients.bill_id', '=', 'bills.id')->join('packets', 'patients.packet_id', '=', 'packets.id')->join('rooms', 'patients.room_id', '=', 'rooms.id')->select('doctors.id', 'bills.id', 'packets.id', 'rooms.id','patients.*')->where('patients.room_id', $request->room_selector)->get();

            // dd($patients);

            // Get total bill
            $total_bill = 0;
            foreach($patients as $patient){
                $total_bill += $patient->price;
            }
        }

        // If request consists of only doctor show all patients that have this doctor id
        else if($request->doctor_name != '-' && $request->room_selector == '-' && $request->card == '-' && $request->packet == '-' && $request->fromDate == null && $request->untilDate == null){
            $patients = DB::table('patients')->join('doctors', 'patients.doctor_id', '=', 'doctors.id')->join('bills', 'patients.bill_id', '=', 'bills.id')->join('packets', 'patients.packet_id', '=', 'packets.id')->join('rooms', 'patients.room_id', '=', 'rooms.id')->select('doctors.id', 'bills.id', 'packets.id', 'rooms.id','patients.*')->where('patients.doctor_id', $request->doctor_name)->get();

            // Get total bill
            $total_bill = 0;
            foreach($patients as $patient){
                $total_bill += $patient->price;
            }
        }

        // If request consists of only card show all patients that have this card id
        else if($request->card != '-' && $request->doctor_name == '-' && $request->room_selector == '-' && $request->packet == '-' && $request->fromDate == null && $request->untilDate == null){
            $patients = DB::table('patients')->join('doctors', 'patients.doctor_id', '=', 'doctors.id')->join('bills', 'patients.bill_id', '=', 'bills.id')->join('packets', 'patients.packet_id', '=', 'packets.id')->join('rooms', 'patients.room_id', '=', 'rooms.id')->select('doctors.id', 'bills.id', 'packets.id', 'rooms.id','patients.*')->where('patients.bill_id', $request->card)->get();

            // Get total bill
            $total_bill = 0;
            foreach($patients as $patient){
                $total_bill += $patient->price;
            }
        }

        // If request consists of only packet show all patients that have this packet id
        else if($request->packet != '-' && $request->doctor_name == '-' && $request->room_selector == '-' && $request->card == '-' && $request->fromDate == null && $request->untilDate == null){
            $patients = DB::table('patients')->join('doctors', 'patients.doctor_id', '=', 'doctors.id')->join('bills', 'patients.bill_id', '=', 'bills.id')->join('packets', 'patients.packet_id', '=', 'packets.id')->join('rooms', 'patients.room_id', '=', 'rooms.id')->select('doctors.id', 'bills.id', 'packets.id', 'rooms.id','patients.*')->where('patients.packet_id', $request->packet)->get();

            // Get total bill
            $total_bill = 0;
            foreach($patients as $patient){
                $total_bill += $patient->price;
            }
        }

        // If request consists of only fromDate and untilDate show all patients from fromDate until untilDate
        else if($request->fromDate != null && $request->untilDate != null && $request->doctor_name == '-' && $request->room_selector == '-' && $request->card == '-' && $request->packet == '-'){
            $patients = DB::table('patients')->join('doctors', 'patients.doctor_id', '=', 'doctors.id')->join('bills', 'patients.bill_id', '=', 'bills.id')->join('packets', 'patients.packet_id', '=', 'packets.id')->join('rooms', 'patients.room_id', '=', 'rooms.id')->select('doctors.id', 'bills.id', 'packets.id', 'rooms.id','patients.*')->whereBetween('patients.date', [date('Y-m-d', strtotime($request->fromDate . ' -1 day')), date('Y-m-d', strtotime($request->untilDate . ' +1 day'))])->get();
            // dd($request);
            // dd($patients);

            // Get total bill
            $total_bill = 0;
            foreach($patients as $patient){
                $total_bill += $patient->price;
            }
        }

        // If request consists of only room and doctor show all patients that have this room id and doctor id
        else if($request->room_selector != '-' && $request->doctor_name != '-' && $request->card == '-' && $request->packet == '-' && $request->fromDate == null && $request->untilDate == null){
            $patients = DB::table('patients')->join('doctors', 'patients.doctor_id', '=', 'doctors.id')->join('bills', 'patients.bill_id', '=', 'bills.id')->join('packets', 'patients.packet_id', '=', 'packets.id')->join('rooms', 'patients.room_id', '=', 'rooms.id')->select('doctors.id', 'bills.id', 'packets.id', 'rooms.id','patients.*')->where('patients.room_id', $request->room_selector)->where('patients.doctor_id', $request->doctor_name)->get();

            // Get total bill
            $total_bill = 0;
            foreach($patients as $patient){
                $total_bill += $patient->price;
            }
        }

        // If request consists of only room and card show all patients that have this room id and card id
        else if($request->room_selector != '-' && $request->card != '-' && $request->doctor_name == '-' && $request->packet == '-' && $request->fromDate == null && $request->untilDate == null){
            $patients = DB::table('patients')->join('doctors', 'patients.doctor_id', '=', 'doctors.id')->join('bills', 'patients.bill_id', '=', 'bills.id')->join('packets', 'patients.packet_id', '=', 'packets.id')->join('rooms', 'patients.room_id', '=', 'rooms.id')->select('doctors.id', 'bills.id', 'packets.id', 'rooms.id','patients.*')->where('patients.room_id', $request->room_selector)->where('patients.bill_id', $request->card)->get();

            // Get total bill
            $total_bill = 0;
            foreach($patients as $patient){
                $total_bill += $patient->price;
            }
        }

        // If request consists of only room and packet show all patients that have this room id and packet id
        else if($request->room_selector != '-' && $request->packet != '-' && $request->doctor_name == '-' && $request->card == '-' && $request->fromDate == null && $request->untilDate == null){
            $patients = DB::table('patients')->join('doctors', 'patients.doctor_id', '=', 'doctors.id')->join('bills', 'patients.bill_id', '=', 'bills.id')->join('packets', 'patients.packet_id', '=', 'packets.id')->join('rooms', 'patients.room_id', '=', 'rooms.id')->select('doctors.id', 'bills.id', 'packets.id', 'rooms.id','patients.*')->where('patients.room_id', $request->room_selector)->where('patients.packet_id', $request->packet)->get();

            // Get total bill
            $total_bill = 0;
            foreach($patients as $patient){
                $total_bill += $patient->price;
            }
        }

        // If request consists of only room and fromDate and untilDate show all patients from this room and within this date range
        else if($request->room_selector != '-' && $request->fromDate != null && $request->untilDate != null && $request->doctor_name == '-' && $request->card == '-' && $request->packet == '-'){
            $patients = DB::table('patients')->join('doctors', 'patients.doctor_id', '=', 'doctors.id')->join('bills', 'patients.bill_id', '=', 'bills.id')->join('packets', 'patients.packet_id', '=', 'packets.id')->join('rooms', 'patients.room_id', '=', 'rooms.id')->select('doctors.id', 'bills.id', 'packets.id', 'rooms.id','patients.*')->where('patients.room_id', $request->room_selector)->whereBetween('patients.date', [date('Y-m-d', strtotime($request->fromDate . ' -1 day')), date('Y-m-d', strtotime($request->untilDate . ' +1 day'))])->get();

            // Get total bill
            $total_bill = 0;
            foreach($patients as $patient){
                $total_bill += $patient->price;
            }
        }

        // If request consists of only doctor and card show all patients that have this doctor id and card id
        else if($request->doctor_name != '-' && $request->card != '-' && $request->room_selector == '-' && $request->packet == '-' && $request->fromDate == null && $request->untilDate == null){
            $patients = DB::table('patients')->join('doctors', 'patients.doctor_id', '=', 'doctors.id')->join('bills', 'patients.bill_id', '=', 'bills.id')->join('packets', 'patients.packet_id', '=', 'packets.id')->join('rooms', 'patients.room_id', '=', 'rooms.id')->select('doctors.id', 'bills.id', 'packets.id', 'rooms.id','patients.*')->where('patients.doctor_id', $request->doctor_name)->where('patients.bill_id', $request->card)->get();

            // Get total bill
            $total_bill = 0;
            foreach($patients as $patient){
                $total_bill += $patient->price;
            }
        }

        // If request consists of only doctor and packet show all patients that have this doctor id and packet id
        else if($request->doctor_name != '-' && $request->packet != '-' && $request->room_selector == '-' && $request->card == '-' && $request->fromDate == null && $request->untilDate == null){
            $patients = DB::table('patients')->join('doctors', 'patients.doctor_id', '=', 'doctors.id')->join('bills', 'patients.bill_id', '=', 'bills.id')->join('packets', 'patients.packet_id', '=', 'packets.id')->join('rooms', 'patients.room_id', '=', 'rooms.id')->select('doctors.id', 'bills.id', 'packets.id', 'rooms.id','patients.*')->where('patients.doctor_id', $request->doctor_name)->where('patients.packet_id', $request->packet)->get();

            // Get total bill
            $total_bill = 0;
            foreach($patients as $patient){
                $total_bill += $patient->price;
            }
        }

        // If request consists of only doctor and fromDate and untilDate show all patients from this doctor and within this date range
        else if($request->doctor_name != '-' && $request->fromDate != null && $request->untilDate != null && $request->room_selector == '-' && $request->card == '-' && $request->packet == '-'){
            $patients = DB::table('patients')->join('doctors', 'patients.doctor_id', '=', 'doctors.id')->join('bills', 'patients.bill_id', '=', 'bills.id')->join('packets', 'patients.packet_id', '=', 'packets.id')->join('rooms', 'patients.room_id', '=', 'rooms.id')->select('doctors.id', 'bills.id', 'packets.id', 'rooms.id','patients.*')->where('patients.doctor_id', $request->doctor_name)->whereBetween('patients.date', [date('Y-m-d', strtotime($request->fromDate . ' -1 day')), date('Y-m-d', strtotime($request->untilDate . ' +1 day'))])->get();

            // Get total bill
            $total_bill = 0;
            foreach($patients as $patient){
                $total_bill += $patient->price;
            }
        }

        // If request consists of only card and packet show all patients that have this card id and packet id
        else if($request->card != '-' && $request->packet != '-' && $request->room_selector == '-' && $request->doctor_name == '-' && $request->fromDate == null && $request->untilDate == null){
            $patients = DB::table('patients')->join('doctors', 'patients.doctor_id', '=', 'doctors.id')->join('bills', 'patients.bill_id', '=', 'bills.id')->join('packets', 'patients.packet_id', '=', 'packets.id')->join('rooms', 'patients.room_id', '=', 'rooms.id')->select('doctors.id', 'bills.id', 'packets.id', 'rooms.id','patients.*')->where('patients.bill_id', $request->card)->where('patients.packet_id', $request->packet)->get();

            // Get total bill
            $total_bill = 0;
            foreach($patients as $patient){
                $total_bill += $patient->price;
            }
        }

        // If request consists of only card and fromDate and untilDate show all patients that have this card id and within this date range
        else if($request->card != '-' && $request->fromDate != null && $request->untilDate != null && $request->room_selector == '-' && $request->doctor_name == '-' && $request->packet == '-'){
            $patients = DB::table('patients')->join('doctors', 'patients.doctor_id', '=', 'doctors.id')->join('bills', 'patients.bill_id', '=', 'bills.id')->join('packets', 'patients.packet_id', '=', 'packets.id')->join('rooms', 'patients.room_id', '=', 'rooms.id')->select('doctors.id', 'bills.id', 'packets.id', 'rooms.id','patients.*')->where('patients.bill_id', $request->card)->whereBetween('patients.date', [date('Y-m-d', strtotime($request->fromDate . ' -1 day')), date('Y-m-d', strtotime($request->untilDate . ' +1 day'))])->get();

            // Get total bill
            $total_bill = 0;
            foreach($patients as $patient){
                $total_bill += $patient->price;
            }
        }

        // If request consists of only packet and fromDate and untilDate show all patients that have this packet id and within this date range
        else if($request->packet != '-' && $request->fromDate != null && $request->untilDate != null && $request->room_selector == '-' && $request->doctor_name == '-' && $request->card == '-'){
            $patients = DB::table('patients')->join('doctors', 'patients.doctor_id', '=', 'doctors.id')->join('bills', 'patients.bill_id', '=', 'bills.id')->join('packets', 'patients.packet_id', '=', 'packets.id')->join('rooms', 'patients.room_id', '=', 'rooms.id')->select('doctors.id', 'bills.id', 'packets.id', 'rooms.id','patients.*')->where('patients.packet_id', $request->packet)->whereBetween('patients.date', [date('Y-m-d', strtotime($request->fromDate . ' -1 day')), date('Y-m-d', strtotime($request->untilDate . ' +1 day'))])->get();

            // Get total bill
            $total_bill = 0;
            foreach($patients as $patient){
                $total_bill += $patient->price;
            }
        }

        // If request consists of only room and doctor name and card show patients
        else if($request->room_selector != '-' && $request->doctor_name != '-' && $request->card != '-' && $request->packet == '-' && $request->fromDate == null && $request->untilDate == null){
            $patients = DB::table('patients')->join('doctors', 'patients.doctor_id', '=', 'doctors.id')->join('bills', 'patients.bill_id', '=', 'bills.id')->join('packets', 'patients.packet_id', '=', 'packets.id')->join('rooms', 'patients.room_id', '=', 'rooms.id')->select('doctors.id', 'bills.id', 'packets.id', 'rooms.id','patients.*')->where('patients.room_id', $request->room_selector)->where('patients.doctor_id', $request->doctor_name)->where('patients.bill_id', $request->card)->get();

            // Get total bill
            $total_bill = 0;
            foreach($patients as $patient){
                $total_bill += $patient->price;
            }
        }

        // If request consists of only room and doctor name and packet show patients
        else if($request->room_selector != '-' && $request->doctor_name != '-' && $request->packet != '-' && $request->card == '-' && $request->fromDate == null && $request->untilDate == null){
            $patients = DB::table('patients')->join('doctors', 'patients.doctor_id', '=', 'doctors.id')->join('bills', 'patients.bill_id', '=', 'bills.id')->join('packets', 'patients.packet_id', '=', 'packets.id')->join('rooms', 'patients.room_id', '=', 'rooms.id')->select('doctors.id', 'bills.id', 'packets.id', 'rooms.id','patients.*')->where('patients.room_id', $request->room_selector)->where('patients.doctor_id', $request->doctor_name)->where('patients.packet_id', $request->packet)->get();

            // Get total bill
            $total_bill = 0;
            foreach($patients as $patient){
                $total_bill += $patient->price;
            }
        }

        // If request consists of only room and doctor name and card and fromDate and untilDate show patients
        else if($request->room_selector != '-' && $request->doctor_name != '-' && $request->card != '-' && $request->packet == '-' && $request->fromDate != null && $request->untilDate != null){
            $patients = DB::table('patients')->join('doctors', 'patients.doctor_id', '=', 'doctors.id')->join('bills', 'patients.bill_id', '=', 'bills.id')->join('packets', 'patients.packet_id', '=', 'packets.id')->join('rooms', 'patients.room_id', '=', 'rooms.id')->select('doctors.id', 'bills.id', 'packets.id', 'rooms.id','patients.*')->where('patients.room_id', $request->room_selector)->where('patients.doctor_id', $request->doctor_name)->where('patients.bill_id', $request->card)->whereBetween('patients.date', [date('Y-m-d', strtotime($request->fromDate . ' -1 day')), date('Y-m-d', strtotime($request->untilDate . ' +1 day'))])->get();

            // Get total bill
            $total_bill = 0;
            foreach($patients as $patient){
                $total_bill += $patient->price;
            }
        }

        // If request consists of only doctor name and packet and card show patients
        else if($request->doctor_name != '-' && $request->packet != '-' && $request->card != '-' && $request->room_selector == '-' && $request->fromDate == null && $request->untilDate == null){
            $patients = DB::table('patients')->join('doctors', 'patients.doctor_id', '=', 'doctors.id')->join('bills', 'patients.bill_id', '=', 'bills.id')->join('packets', 'patients.packet_id', '=', 'packets.id')->join('rooms', 'patients.room_id', '=', 'rooms.id')->select('doctors.id', 'bills.id', 'packets.id', 'rooms.id','patients.*')->where('patients.doctor_id', $request->doctor_name)->where('patients.packet_id', $request->packet)->where('patients.bill_id', $request->card)->get();

            // Get total bill
            $total_bill = 0;
            foreach($patients as $patient){
                $total_bill += $patient->price;
            }
        }

        // If request consists of only doctor name and packet and fromDate and untilDate show patients
        else if($request->doctor_name != '-' && $request->packet != '-' && $request->fromDate != null && $request->untilDate != null && $request->card == '-' && $request->room_selector == '-'){
            $patients = DB::table('patients')->join('doctors', 'patients.doctor_id', '=', 'doctors.id')->join('bills', 'patients.bill_id', '=', 'bills.id')->join('packets', 'patients.packet_id', '=', 'packets.id')->join('rooms', 'patients.room_id', '=', 'rooms.id')->select('doctors.id', 'bills.id', 'packets.id', 'rooms.id','patients.*')->where('patients.doctor_id', $request->doctor_name)->where('patients.packet_id', $request->packet)->whereBetween('patients.date', [date('Y-m-d', strtotime($request->fromDate . ' -1 day')), date('Y-m-d', strtotime($request->untilDate . ' +1 day'))])->get();

            // Get total bill
            $total_bill = 0;
            foreach($patients as $patient){
                $total_bill += $patient->price;
            }
        }

        // If request consists of only packet and card and fromDate and untilDate show patients
        else if($request->packet != '-' && $request->card != '-' && $request->fromDate != null && $request->untilDate != null && $request->doctor_name == '-' && $request->room_selector == '-'){
            $patients = DB::table('patients')->join('doctors', 'patients.doctor_id', '=', 'doctors.id')->join('bills', 'patients.bill_id', '=', 'bills.id')->join('packets', 'patients.packet_id', '=', 'packets.id')->join('rooms', 'patients.room_id', '=', 'rooms.id')->select('doctors.id', 'bills.id', 'packets.id', 'rooms.id','patients.*')->where('patients.packet_id', $request->packet)->where('patients.bill_id', $request->card)->whereBetween('patients.date', [date('Y-m-d', strtotime($request->fromDate . ' -1 day')), date('Y-m-d', strtotime($request->untilDate . ' +1 day'))])->get();

            // Get total bill
            $total_bill = 0;
            foreach($patients as $patient){
                $total_bill += $patient->price;
            }
        }

        // If request room, doctor, card, packet
        else if($request->room_selector != '-' && $request->doctor_name != '-' && $request->card != '-' && $request->packet != '-' && $request->fromDate == null && $request->untilDate == null){
            $patients = DB::table('patients')->join('doctors', 'patients.doctor_id', '=', 'doctors.id')->join('bills', 'patients.bill_id', '=', 'bills.id')->join('packets', 'patients.packet_id', '=', 'packets.id')->join('rooms', 'patients.room_id', '=', 'rooms.id')->select('doctors.id', 'bills.id', 'packets.id', 'rooms.id','patients.*')->where('patients.room_id', $request->room_selector)->where('patients.doctor_id', $request->doctor_name)->where('patients.bill_id', $request->card)->where('patients.packet_id', $request->packet)->get();

            // Get total bill
            $total_bill = 0;
            foreach($patients as $patient){
                $total_bill += $patient->price;
            }
        }

        // If request room, doctor, card, packet, fromDate, untilDate
        else if($request->room_selector != '-' && $request->doctor_name != '-' && $request->card != '-' && $request->packet != '-' && $request->fromDate != null && $request->untilDate != null){
            $patients = DB::table('patients')->join('doctors', 'patients.doctor_id', '=', 'doctors.id')->join('bills', 'patients.bill_id', '=', 'bills.id')->join('packets', 'patients.packet_id', '=', 'packets.id')->join('rooms', 'patients.room_id', '=', 'rooms.id')->select('doctors.id', 'bills.id', 'packets.id', 'rooms.id','patients.*')->where('patients.room_id', $request->room_selector)->where('patients.doctor_id', $request->doctor_name)->where('patients.bill_id', $request->card)->where('patients.packet_id', $request->packet)->whereBetween('patients.date', [date('Y-m-d', strtotime($request->fromDate . ' -1 day')), date('Y-m-d', strtotime($request->untilDate . ' +1 day'))])->get();

            // Get total bill
            $total_bill = 0;
            foreach($patients as $patient){
                $total_bill += $patient->price;
            }
        }

        // If request room,doctor,card,fromDate and untilDate
        else if($request->room_selector != '-' && $request->doctor_name != '-' && $request->card != '-' && $request->fromDate != null && $request->untilDate != null && $request->packet == '-'){
            $patients = DB::table('patients')->join('doctors', 'patients.doctor_id', '=', 'doctors.id')->join('bills', 'patients.bill_id', '=', 'bills.id')->join('packets', 'patients.packet_id', '=', 'packets.id')->join('rooms', 'patients.room_id', '=', 'rooms.id')->select('doctors.id', 'bills.id', 'packets.id', 'rooms.id','patients.*')->where('patients.room_id', $request->room_selector)->where('patients.doctor_id', $request->doctor_name)->where('patients.bill_id', $request->card)->whereBetween('patients.date', [date('Y-m-d', strtotime($request->fromDate . ' -1 day')), date('Y-m-d', strtotime($request->untilDate . ' +1 day'))])->get();

            // Get total bill
            $total_bill = 0;
            foreach($patients as $patient){
                $total_bill += $patient->price;
            }
        }

        // If request room,doctor,packet,fromDate and untilDate
        else if($request->room_selector != '-' && $request->doctor_name != '-' && $request->packet != '-' && $request->fromDate != null && $request->untilDate != null && $request->card == '-'){
            $patients = DB::table('patients')->join('doctors', 'patients.doctor_id', '=', 'doctors.id')->join('bills', 'patients.bill_id', '=', 'bills.id')->join('packets', 'patients.packet_id', '=', 'packets.id')->join('rooms', 'patients.room_id', '=', 'rooms.id')->select('doctors.id', 'bills.id', 'packets.id', 'rooms.id','patients.*')->where('patients.room_id', $request->room_selector)->where('patients.doctor_id', $request->doctor_name)->where('patients.packet_id', $request->packet)->whereBetween('patients.date', [date('Y-m-d', strtotime($request->fromDate . ' -1 day')), date('Y-m-d', strtotime($request->untilDate . ' +1 day'))])->get();

            // Get total bill
            $total_bill = 0;
            foreach($patients as $patient){
                $total_bill += $patient->price;
            }
        }

        // If request room,card,packet,fromDate and untilDate
        else if($request->room_selector != '-' && $request->card != '-' && $request->packet != '-' && $request->fromDate != null && $request->untilDate != null && $request->doctor_name == '-'){
            $patients = DB::table('patients')->join('doctors', 'patients.doctor_id', '=', 'doctors.id')->join('bills', 'patients.bill_id', '=', 'bills.id')->join('packets', 'patients.packet_id', '=', 'packets.id')->join('rooms', 'patients.room_id', '=', 'rooms.id')->select('doctors.id', 'bills.id', 'packets.id', 'rooms.id','patients.*')->where('patients.room_id', $request->room_selector)->where('patients.bill_id', $request->card)->where('patients.packet_id', $request->packet)->whereBetween('patients.date', [date('Y-m-d', strtotime($request->fromDate . ' -1 day')), date('Y-m-d', strtotime($request->untilDate . ' +1 day'))])->get();

            // Get total bill
            $total_bill = 0;
            foreach($patients as $patient){
                $total_bill += $patient->price;
            }
        }

        // If request doctor,card,packet,fromDate and untilDate
        else if($request->doctor_name != '-' && $request->card != '-' && $request->packet != '-' && $request->fromDate != null && $request->untilDate != null && $request->room_selector == '-'){
            $patients = DB::table('patients')->join('doctors', 'patients.doctor_id', '=', 'doctors.id')->join('bills', 'patients.bill_id', '=', 'bills.id')->join('packets', 'patients.packet_id', '=', 'packets.id')->join('rooms', 'patients.room_id', '=', 'rooms.id')->select('doctors.id', 'bills.id', 'packets.id', 'rooms.id','patients.*')->where('patients.doctor_id', $request->doctor_name)->where('patients.bill_id', $request->card)->where('patients.packet_id', $request->packet)->whereBetween('patients.date', [date('Y-m-d', strtotime($request->fromDate . ' -1 day')), date('Y-m-d', strtotime($request->untilDate . ' +1 day'))])->get();

            // Get total bill
            $total_bill = 0;
            foreach($patients as $patient){
                $total_bill += $patient->price;
            }
        }

        // If request room,doctor,card,packet,fromDate and untilDate
        else if($request->room_selector != '-' && $request->doctor_name != '-' && $request->card != '-' && $request->packet != '-' && $request->fromDate != null && $request->untilDate != null){
            $patients = DB::table('patients')->join('doctors', 'patients.doctor_id', '=', 'doctors.id')->join('bills', 'patients.bill_id', '=', 'bills.id')->join('packets', 'patients.packet_id', '=', 'packets.id')->join('rooms', 'patients.room_id', '=', 'rooms.id')->select('doctors.id', 'bills.id', 'packets.id', 'rooms.id','patients.*')->where('patients.room_id', $request->room_selector)->where('patients.doctor_id', $request->doctor_name)->where('patients.bill_id', $request->card)->where('patients.packet_id', $request->packet)->whereBetween('patients.date', [date('Y-m-d', strtotime($request->fromDate . ' -1 day')), date('Y-m-d', strtotime($request->untilDate . ' +1 day'))])->get();

            // Get total bill
            $total_bill = 0;
            foreach($patients as $patient){
                $total_bill += $patient->price;
            }
        }


        // If none of them is seleted show all patients
        else{
            $patients = DB::table('patients')->join('doctors', 'patients.doctor_id', '=', 'doctors.id')->join('bills', 'patients.bill_id', '=', 'bills.id')->join('packets', 'patients.packet_id', '=', 'packets.id')->join('rooms', 'patients.room_id', '=', 'rooms.id')->select('doctors.id', 'bills.id', 'packets.id', 'rooms.id','patients.*')->get();

            // Get total bill
            $total_bill = 0;
            foreach($patients as $patient){
                $total_bill += $patient->price;
            }

        }
        dd($patients);



        // Return
        return view('admin.checkout', [
            'patients' => $patients,
            'rooms' => DB::table('rooms')->get(),
            'doctors' => DB::table('doctors')->get(),
            'bills' => DB::table('bills')->get(),
            'packets' => DB::table('packets')->get(),
            'total_bill' => $total_bill,
            'bill_id' => DB::table('bills')->first()->id,
            'packet_id' => DB::table('packets')->first()->id,
        ]);
    }
}
