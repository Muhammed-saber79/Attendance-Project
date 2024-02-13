@extends('Layouts.admin')

@section('title')
    معاملات الإداريين
@endsection

@section('content')
    <main role="main" class="main-content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12">
                    <h2 class="mb-2 page-title">معاملات الإداريين في حالة الغياب</h2>
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
                                            <th>تاريخ الغياب</th>
                                            <th>حالة التواصل</th>
                                            <th>تاريخ الإرسال</th>
                                            <th>الصورة الشخصية</th>
                                            <th>الإجراء</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @forelse($absentEmployees as $absent)
                                            @php
                                                $empData = \App\Models\Employee::with(['messages'])->find($absent->employee_id);
                                            @endphp
                                            <tr>
                                                <td>{{ @$absent->employee->number }}</td>
                                                <td>{{ @$absent->employee->name }}</td>
                                                <td>{{ @$absent->employee->department }}</td>
                                                <td>{{ @$absent->employee->phone }}</td>
                                                <td>{{ @$absent->employee->email }}</td>
                                                <td>{{ @$absent->created_at->format('d-m-Y') }}</td>
                                                <td>
                                                    @if(@$absent->is_replied)
                                                        <span class="text-success">تم إرسال اشعار</span>
                                                    @else
                                                        <span class="text-warning">لم يتم إرسال اشعار</span>
                                                    @endif
                                                </td>

                                                @if(@$absent->is_replied)
                                                    @php
                                                        $message = $empData->messages()->where('type', 'notification')->whereDate('created_at', '>=', now()->subDays(2))->first();
                                                    @endphp
                                                    <td class="text-info">{{ $message->created_at->diffForHumans() }}</td>
                                                @else
                                                    <td class="text-info">لم يحدد بعد</td>
                                                @endif

                                                <td>
                                                    <img src="{{ @$empData->getFirstMediaUrl('image', 'thumb') }}" width="75px" alt="صورة الموظف">
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <span class="text-muted sr-only">الإجراء</span>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" data-toggle="modal" data-target="#editEmployeeModal_{{ @$empData->id }}">اشعار حسم</a>
                                                        <a class="dropdown-item" href="" @if(@$absent->is_replied) data-toggle="modal" data-target="#decideEmployee_-{{ @$empData->id }}" @endif>قرار حسم</a>
                                                    </div>
                                                </td>

                                                <!-- Modal for edit employee data -->
                                                <div class="modal fade" id="editEmployeeModal_{{ @$empData->id }}" tabindex="-1" role="dialog" aria-labelledby="editEmployeeModal_{{ @$empData->id }}" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="editEmployeeModal_{{ @$empData->id }}">إرسال إشعار حسم</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('admin.messages.notifyEmployee', @$empData->id) }}" method="post" id="editTemplateForm_{{ @$empData->id }}">
                                                                    @csrf
                                                                    <div class="form-group">
                                                                        <label for="title">عنوان الرسالة:</label>
                                                                        <input type="text" class="form-control" id="title" name="title" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="description">محتوى الرسالة:</label>
                                                                        <textarea class="form-control" id="description" name="description" required></textarea>
                                                                    </div>
                                                                    <input type="hidden" name="type" value="notification">
                                                                </form>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                                                                <button type="submit" class="btn btn-primary" form="editTemplateForm_{{ @$empData->id }}">إرسال</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Modal for delete an employee -->
                                                <div class="modal fade" id="decideEmployee_-{{ @$empData->id }}" tabindex="-1" role="dialog" aria-labelledby="decideEmployee_-{{ @$empData->id }}" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="addTemplateModalLabel">إرسال قرار حسم</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('admin.messages.decideEmployee', @$empData->id) }}" method="post" id="decideEmployee_{{ @$empData->id }}">
                                                                    @csrf
                                                                    <div class="form-group">
                                                                        <label for="title">عنوان الرسالة:</label>
                                                                        <input type="text" class="form-control" id="title" name="title" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="description">محتوى الرسالة:</label>
                                                                        <textarea class="form-control" id="description" name="description" required></textarea>
                                                                    </div>
                                                                    <input type="hidden" name="type" value="decision">
                                                                </form>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                                                                <button type="submit" class="btn btn-primary" form="decideEmployee_{{ @$absent->id }}">إرسال</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

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
