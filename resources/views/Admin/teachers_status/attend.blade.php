@extends('Layouts.admin')
@section('content')
<main role="main" class="main-content">
        <div class="container-fluid">
          <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="mb-2 page-title">جدول حضور المدربين </h2>
                <div class="row my-4">
                    <div class="col-md-12">
                        <div class="card shadow">
                            <div class="card-body">
                                <table class="table" id="attendanceTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>اسم المدرب</th>
                                            <th>اسم المادة </th>
                                            <th> القسم </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($attends as $attend)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$attend->teacher->name}}</td>
                                            <td>{{$attend->attendance->subject_name}}</td>
                                            <td>{{$attend->attendance->department}}</td>
                                     

                                   

                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

          </div> <!-- .row -->
        </div> <!-- .container-fluid -->
    </main> <!-- main -->
@endsection
