<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Doctor;
use App\Models\Department;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {

        $sesstionData = $request->session()->get('data');
        // dd($sesstionData[0]['fee']);
        // dd(count($sesstionData));
        $depts = Department::all();
        return view('appointment.index', compact('depts', 'sesstionData'));
    }
    public function selectDept($id)
    {
        $dept = Department::findOrFail($id);
        $doctors = Doctor::where('department_id', $dept->id)->get();
        return response()->json($doctors);
    }
    public function selectDocFee($id)
    {
        $data['docs'] = Doctor::findOrFail($id);
        $data['appointment'] = Appointment::where('doctor_id', $data['docs']->id)->get(['id', 'appointment_date']);
        return response()->json($data);
    }

    public function SessionData(Request $request)
    {
        $request->validate([
            'apointment_date' => 'required',
            'department' => 'required',
            'doctor' => 'required',
            'fee' => 'required'
        ]);
        $data['app_date'] = $request->apointment_date;
        $data['department'] = $request->department;
        $data['doctor'] = $request->doctor;
        $data['fee'] = $request->fee;
        // dd($data);
        if ($request->session()->has('data')) {
            $request->session()->push('data', $data);
        } else {
            $request->session()->put('data', [$data]);
        }
        return back();
    }


    public function SessionDestroy(Request $request)
    {
        // if ($request->session()->has('data')) {
        //     return $request->session()->get('data');
        // } else {
        //     return "No Data";
        // }
        $request->session()->forget('data');
        return redirect()->route('appointment.index');
    }





    //==================  Insert Appointment
    public function InsertAppointment(Request $request)
    {
        $request->validate([
            'p_name' => 'required',
            'p_phone' => 'required',
            'total_fee' => 'required',
            'paid_amount' => 'required',
        ]);

        $sesData = $request->session()->get('data');
        $i = 1;
        if (($request->paid_amount) == ($request->total_fee)) {

            if (count($sesData) > 1) {
                foreach ($sesData as $Appointment) {
                    $data = new Appointment();
                    $data->appointment_no = time() . ($data->id) . ++$i;
                    $data->appointment_date = $Appointment['app_date'];
                    $data->doctor_id = $Appointment['doctor'];
                    $data->patient_name = $request->p_name;
                    $data->patient_phone = $request->p_phone;
                    $data->total_fee = $Appointment['fee'];
                    $data->paid_amount = $request->paid_amount;
                    $data->save();
                }
            } else {
                $data = new Appointment();
                $data->appointment_no = time() . ($data->id) . ++$i;
                $data->appointment_date = $sesData[0]['app_date'];
                $data->doctor_id = $sesData[0]['doctor'];
                $data->patient_name = $request->p_name;
                $data->patient_phone = $request->p_phone;
                $data->total_fee = $sesData[0]['fee'];
                $data->paid_amount = $request->paid_amount;
                $data->save();
            }
            $request->session()->forget('data');
            return back()->with('success','Appontment Listed');
        }else{
            return back()->with('error','Total Fee & Paid Amount is not Equal');
        }
    }
}
