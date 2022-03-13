<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index(){
        $docs = Doctor::orderBy('id','desc')->paginate(4);
        $depts = Department::orderBy('id','desc')->get();
        // dd($docs);
        return view('doctor.doctor',compact('docs','depts'));
    }
    public function insert(Request $request){
        $request->validate([
            'name'=>'required',
            'department_id'=>'required',
            'fee'=>'required'
        ]);
        // dd($request->all());
        $data = new Doctor();
        $data->name = $request->name;
        $data->department_id = $request->department_id;
        $data->phone = $request->phone;
        $data->fee = $request->fee;
        $data->save();
        return back()->with('success','Doctor Added Success');
    }
    public function DocEdit($id){
        $data = Doctor::findOrFail($id);
        $depts = Department::orderBy('id','desc')->get();
        return view('doctor.edit',compact('data','depts'));
    }
    public function DocUpdate(Request $request, $id){
        $request->validate([
            'name'=>'required',
            'department_id'=>'required',
            'fee'=>'required'
        ]);
        $data = Doctor::findOrFail($id);
        $data->name = $request->name;
        $data->department_id = $request->department_id;
        $data->phone = $request->phone;
        $data->fee = $request->fee;
        $data->save();
        return redirect()->route('doctor.index')->with('success','Doctor Update Success');
    }
    public function DocDelete($id){
        Doctor::findOrFail($id)->delete();
        return back()->with('success','Doctor Delete Success');
    }
}
