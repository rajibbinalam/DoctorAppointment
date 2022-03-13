@extends('layout.master')
@section('content')
    <div class="card mt-5">
        <div class="card-header">
            <div class="card-title">Edit : {{$data->name}}</div>
        </div>
        <div class="card-body">
            <form action="{{route('doctor.DocUpdate',$data->id)}}" method="post" id="addNewDoc">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp" value="{{$data->name}}">
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" class="form-control" name="phone" id="phone" value="{{$data->phone}}">
                </div>
                <div class="mb-3">
                    <label for="dept" class="form-label">Department</label>
                    <select class="form-select" id="dept" name="department_id" aria-label="Default select example">
                        <option selected>Choose...</option>
                        @foreach ($depts as $dept)
                            <option value="{{$dept->id}}" @if($data->department_id == $dept->id) selected @else @endif>{{$dept->name}}</option>
                        @endforeach
                        
                    </select>
                </div>
                <div class="mb-3">
                    <label for="fee" class="form-label">Fee</label>
                    <input type="text" class="form-control" name="fee" id="fee" value="{{$data->fee}}">
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{route('doctor.index')}}" class="btn btn-secondary">Back</a>
            </form>
            
        </div>
    </div>


@endsection
