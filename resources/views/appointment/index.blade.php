@extends('layout.master')
@section('content')
    <div class="row mt-5">
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
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('sessionData') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="apointment_date" class="form-label">Appointment Date</label>
                            <input type="date" class="form-control @error('apointment_date') is-invalid @enderror"
                                id="apointment_date" name="apointment_date">
                            @error('apointment_date')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="SelectDept" class="form-label">Select Deartment</label>
                            <select class="form-select @error('department') is-invalid @enderror" id="SelectDept"
                                name="department">
                                <option selected>Choose...</option>
                                @foreach ($depts as $dept)
                                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                @endforeach
                            </select>
                            @error('department')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="SelectDoctor" class="form-label">Select Doctor</label>
                            <select class="form-select @error('doctor') is-invalid @enderror" id="SelectDoctor"
                                name="doctor">
                            </select>
                            @error('doctor')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <small id="Available" style="display: none; color: rgb(0, 255, 21)"><strong>Available</strong></small>
                            <small id="DocNotAvailable" style="display: none; color: red">Not Available</small>
                        </div>
                        <div class="mb-3">
                            <label for="fee" class="form-label">Fee</label>
                            <input type="text" readonly class="form-control" id="fee" name="fee" placeholder="Fee">
                        </div>
                        
                        <button type="submit" id="AddDocAppointment" class="btn btn-success">Add</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">

                    <div class="pa-table mb-5">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">SL</th>
                                    <th scope="col">App. Date</th>
                                    <th scope="col">Doctor</th>
                                    <th scope="col">Fee</th>
                                    <th scope="col" style="width: 100px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $feess = '';
                                @endphp
                                @if (session()->has('data'))
                                    @foreach ($sesstionData as $sessData)
                                        @php
                                            $docName = App\Models\Doctor::where('id', $sessData['doctor'])->first();
                                        @endphp
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $sessData['app_date'] }}</td>
                                            <td>{{ $docName->name }}</td>
                                            <td>{{ $sessData['fee'] }}</td>
                                            @php
                                                $feess = (int) $feess + (int) $sessData['fee'];
                                            @endphp
                                            <td style="width: 100px;"><a href="" class="btn btn-danger">Delete</a></td>
                                        </tr>
                                    @endforeach
                                    <a href="{{ route('SessionDestroy') }}" class="btn btn-danger mb-1"
                                        style="float: right;">Clear</a>
                                @else
                                @endif

                            </tbody>
                        </table>
                    </div>
                    <div class="Pa-form mt-5">
                        <form action="{{ route('InsertAppointment') }}" method="post">
                            @csrf
                            <label for="" class="form-label"><b>Patient Information</b></label>
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <input type="text" class="form-control" id="patient_name" name="p_name"
                                        placeholder="Patient Name">
                                </div>
                                <div class="mb-3 col-md-6">
                                    <input type="text" class="form-control" id="patient_phone" name="p_phone"
                                        placeholder="Patient Phone">
                                </div>
                            </div>

                            <label for="" class="form-label"><b>Payment</b></label>
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <input type="text" readonly class="form-control" name="total_fee" id="fee"
                                        value="{{ $feess }}" placeholder="Total Amount">
                                </div>
                                <div class="mb-3 col-md-6">
                                    <input type="text" class="form-control" name="paid_amount" id="fee"
                                        value="{{ $feess }}" placeholder="Pain Amount">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('custom_script')
    <script>
        $("#SelectDept").on('change', function() {
            let deptId = $(this).val();
            // alert(a);
            let deptUrl = '/select-dept/' + deptId;
            // console.log(url);
            let html = '<option selected>Choose...</option>';
            $.ajax({
                url: deptUrl,
                type: 'GET',
                datatype: "JSON",
                success: function(data) {
                    $("#DocNotAvailable").hide();
                    $("#AddDocAppointment").show();
                    for (let i = 0; i < data.length; i++) {
                        html += `<option value="${data[i].id}">${data[i].name}</option>`
                    }
                    $("#SelectDoctor").html(html);
                },
                error: function(error) {
                    console.log(error);
                }
            })
        });
        $("#SelectDoctor").on('change', function() {
            let DocFee = $(this).val();
            let appointmentDate = $("#apointment_date").val();

            var appDate = [];
            $.ajax({
                url: '/select-Doc-fee/' + DocFee,
                type: 'GET',
                datatype: "JSON",
                success: function(data) {
                    $("#Available").show();
                    $("#DocNotAvailable").hide();
                    $("#AddDocAppointment").show();
                    $("#fee").val(data['docs'].fee);

                    for (let i = 0; i < data['appointment'].length; i++) {
                        let date = (data['appointment'][i].appointment_date);
                        if (date == appointmentDate) {
                            appDate.push(date);

                        }
                    }
                    if (appDate.length >= 2) {
                        $("#DocNotAvailable").show();
                        $("#AddDocAppointment").hide();
                        $("#Available").hide();
                    }
                }
            });

        });
        $("#apointment_date").on('change', function() {
            $("#SelectDept").val('');
            $("#SelectDoctor").val('');
            $("#DocNotAvailable").hide();
            $("#AddDocAppointment").show();
        });
    </script>
@endsection
