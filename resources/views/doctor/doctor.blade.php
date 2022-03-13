@extends('layout.master')
@section('content')
    <button type="button" class="btn btn-primary float-right mt-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Add New Doctor
    </button>
    @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
        @if (session()->has('error'))
            <div class="alert alert-danger">
                {{ session()->get('error') }}
            </div>
        @endif
    <div class="card mt-4">
        <div class="card-header">
            <div class="card-title">All Doctors</div>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">SL</th>
                        <th scope="col">Name</th>
                        <th scope="col">Dept</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Fee</th>
                        <th scope="col" style="width: 160px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($docs as $doc)
                        <tr>
                        <th scope="row">{{$loop->index+1}}</th>
                        <td>{{$doc->name}}</td>
                        <td>{{$doc->dept->name}}</td>
                        <td>{{$doc->phone}}</td>
                        <td>{{$doc->fee}}</td>
                        <td style="width: 160px;">
                            <a href="{{route('doctor.DocEdit',$doc->id)}}" class="btn btn-primary">Edit</a>
                            <a href="{{route('doctor.DocDelete',$doc->id)}}" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                    
                </tbody>
            </table>
            <div class="d-flex justify-content-end">
                {{ $docs->links() }}
            </div>
        </div>
    </div>

    <!-- Button trigger modal -->


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New Doctor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('doctor.insert')}}" method="post" id="addNewDoc">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp" placeholder="Doctor Name">
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" name="phone" id="phone" placeholder="Number">
                        </div>
                        <div class="mb-3">
                            <label for="dept" class="form-label">Department</label>
                            <select class="form-select" id="dept" name="department_id" aria-label="Default select example">
                                <option selected>Choose...</option>
                                @foreach ($depts as $dept)
                                    <option value="{{$dept->id}}">{{$dept->name}}</option>
                                @endforeach
                                
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="fee" class="form-label">Fee</label>
                            <input type="text" class="form-control" name="fee" id="fee" placeholder="Doctor Fee">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="addNewDoc" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection
