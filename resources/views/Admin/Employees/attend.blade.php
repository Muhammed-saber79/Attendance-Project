@extends('Layouts.admin')

@section('title')
    معاملات الإداريين
@endsection

@section('content')
    <main role="main" class="main-content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12">
                    <h2 class="mb-2 page-title">معاملات الإداريين في حالة الحضور</h2>
                    <div class="row my-4">
                        <!-- جدول صغير -->
                        <div class="col-md-12">
                            <div class="card shadow">
                                <div class="card-body">
                                    <!-- الجدول -->
                                    <table class="table datatables" id="dataTable-1">
                                        <thead>
                                        <tr>
                                            <th>رقم الموظف</th>
                                            <th>الاسم</th>
                                            <th>الإدارة التابع لها</th>
                                            <th>الهاتف</th>
                                            <th>البريد الإلكتروني</th>
                                            
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @forelse($attendEmployees as $attend)
                                            @php
                                                $empData = \App\Models\Employee::with(['messages'])->find($attend->employee_id);
                                            @endphp
                                            <tr>
                                                <td>{{ @$attend->employee->number }}</td>
                                                <td>{{ @$attend->employee->name }}</td>
                                                <td>{{ @$attend->employee->department }}</td>
                                                <td>{{ @$attend->employee->phone }}</td>
                                                <td>{{ @$attend->employee->email }}</td>
                                                

                                       
                                        

                                            </tr>
                                        @empty
                                            <tr>
                                                <td style="color: red; text-align: center" colspan="7">لا يوجد إداريين مسجلين بالمنصة حتى الان</td>
                                            </tr>
                                        @endforelse

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> <!-- الجدول البسيط -->
                    </div> <!-- نهاية القسم -->
                </div> <!-- .col-12 -->

            </div> <!-- .row -->
        </div> <!-- .container-fluid -->
    </main> <!-- main -->
@endsection
