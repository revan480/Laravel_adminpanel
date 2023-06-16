<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Models\Room;
use App\Models\Patient;
use App\Models\Doctor;
/**
 * Class CheckoutController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CheckoutController extends Controller
{
    public function index()
    {
        $patientsQuery = Patient::query();
        $total_bill = $patientsQuery->sum('price');
        $doctors = Doctor::all();
        $patients = Patient::paginate(50);
        $rooms = Room::all();
        $packets = DB::table('packets')->get();
        $packet_id = DB::table('packets')->where('name', 'Yoxdur')->first()->id;
        $bill_id = DB::table('bills')->where('type', 'Nəğd')->first()->id;
        $bills = DB::table('bills')->get();

        return view ('admin.checkout', compact('doctors', 'patients', 'rooms', 'packets', 'packet_id', 'bill_id', 'bills', 'total_bill'));
    }
    public function show(Request $request)
    {
        $doctors = Doctor::all();
        $rooms = Room::all();
        $packets = DB::table('packets')->get();
        $packet_id = DB::table('packets')->where('name', 'Yoxdur')->first()->id;
        $bill_id = DB::table('bills')->where('type', 'Nəğd')->first()->id;
        $bills = DB::table('bills')->get();

        $patientsQuery = Patient::query();


        if ($request->filled('room_selector')) {
            $room = Room::where('number', $request->room_selector)->first();
            if ($room) {
                $patientsQuery->where('room_id', $room->id);
            }
        }

        if ($request->filled('doctor_name')) {
            $doctor = Doctor::where('name', $request->doctor_name)->first();
            if ($doctor) {
                $patientsQuery->where('doctor_id', $doctor->id);
            }
        }

        if ($request->filled('packet')) {
            $packet = DB::table('packets')->where('name', $request->packet)->first();
            if ($packet) {
                $patientsQuery->where('packet_id', $packet->id);
            }
        }

        if ($request->filled('card')) {
            $patientsQuery->whereHas('bill', function ($query) use ($request) {
                $query->where('bill_name', $request->card);
            });
        }

        if ($request->filled('fromDate')) {
            $patientsQuery->whereDate('date', '>=', $request->fromDate);
        }

        if ($request->filled('untilDate')) {
            $patientsQuery->whereDate('date', '<=', $request->untilDate);
        }

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $patientsQuery->where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', '%'.$searchTerm.'%')
                    ->orWhere('surname', 'like', '%'.$searchTerm.'%')
                    ->orWhere('phone', 'like', '%'.$searchTerm.'%')
                    ->orWhere('area', 'like', '%'.$searchTerm.'%');
            });
        }

        $patients = $patientsQuery->paginate(50)->appends($request->except('page'));
        $total_bill = $patients->sum('price');

        return view('admin.checkout', compact('patients', 'doctors', 'rooms', 'packets', 'packet_id', 'bill_id', 'bills', 'total_bill'));
    }

}
