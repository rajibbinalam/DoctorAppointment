<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request){
        $search = $request->search;
        if($search != ""){
            $docSearch = Doctor::where('name','LIKE',"%$search%")->get();
            $appoints = Appointment::where('appointment_no' ,'LIKE',"%$search%")->orWhere('appointment_date' ,'LIKE',"%$search%")->orWhere('patient_name' ,'LIKE',"%$search%")->orWhere('patient_phone' ,'LIKE',"%$search%")->Paginate(5);
        }else{
            $appoints = Appointment::orderBy('appointment_date','desc')->Paginate(5);
        }
        return view('home',compact('appoints','search'));
    }
}
