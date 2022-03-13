@extends('layout.master')
@section('content')
    <div class="card mt-5">
        <div class="card-header d-flex justify-content-between">
            <div class="card-title">All Appointments</div>
            <form class="d-flex" action="">
                <input class="form-control me-2" type="search" name="search" value="{{$search}}" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">SL</th>
                        <th scope="col">App. No</th>
                        <th scope="col">App. Date</th>
                        <th scope="col">Doc. Name</th>
                        <th scope="col">Patient</th>
                        <th scope="col">Payment</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($appoints as $appoint)
                        <tr>
                            <th scope="row">{{ $loop->index + 1 }}</th>
                            <td>{{ $appoint->appointment_no }}</td>
                            <td>{{ $appoint->appointment_date }}</td>
                            <td>{{ $appoint->docName->name }}</td>
                            <td>{{ $appoint->patient_name }} <small style="color: rgb(0, 191, 255); cursor: pointer;">
                                    {{ $appoint->patient_phone }}</small></td>
                            <td>{{ $appoint->paid_amount }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-end">
                {{ $appoints->links() }}
            </div>
        </div>
    </div>
@endsection
