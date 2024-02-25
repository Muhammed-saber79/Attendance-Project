@extends('Layouts.admin')
@section('content')
<main role="main" class="main-content">
        <div class="container-fluid">
          <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="mb-2 page-title">جدول غياب المدربين </h2>
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
                                            <th>تاريخ الغياب</th>
                                            <th>حالة التواصل</th>
                                            <th>تاريخ الإرسال</th>
                                            <th>الملفات</th>
                                            <th>الإجراء</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($absenses as $absense)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$absense->teacher->name}}</td>
                                            <td>{{$absense->attendance->subject_name}}</td>
                                            <td>{{$absense->attendance->department}}</td>
                                            <td>{{Carbon\Carbon::parse($absense->created_at)->format('Y-m-d')}}</td>

                                            <td>
                                                @if(@$absense->is_replied)
                                                    <span class="text-success">تم إرسال اشعار</span>
                                                @else
                                                    <span class="text-warning">لم يتم إرسال اشعار</span>
                                                @endif
                                            </td>

                                            @if(@$absense->is_replied)
                                                @php
                                                    $message = @$absense->teacher->messages()->where('type', 'accountability')->orWhere('type', 'notification')->whereDate('created_at', '>=', now()->subDays(2))->first();
                                                @endphp
                                                <td class="text-info">{{ optional($message->created_at)->diffForHumans() }}</td>
                                            @else
                                                <td class="text-info">لم يحدد بعد</td>
                                            @endif

                                            @if(@$absense->teacher->attachments()->count() > 0)
                                                <td class="text-primary">
                                                    <a href="{{ route('admin.messages.teacher', $absense->teacher->id) }}">
                                                        أرشيف الملفات
                                                    </a>
                                                </td>
                                            @else
                                                <td class="text-primary-light">لا يوجد ملفات</td>
                                            @endif

                                            <td>
                                                <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span class="text-muted sr-only">الإجراء</span>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" data-toggle="modal" data-target="#accountEmployeeModal_{{ @$absense->teacher->id }}">مسائلة</a>
                                                    <a class="dropdown-item" data-toggle="modal" data-target="#editEmployeeModal_{{ @$absense->teacher->id }}">اشعار حسم</a>
                                                    <a class="dropdown-item" href="" @if(@$absense->is_replied) data-toggle="modal" data-target="#decideEmployee_{{ @$absense->teacher->id }}" @endif>قرار حسم</a>
                                                    <a class="dropdown-item" href="" @if(@$absense->is_replied) data-toggle="modal" data-target="#sendEmail_{{ @$absense->teacher->id }}" @endif>إرسال رد على الايميل</a>
                                                </div>
                                            </td>

                                            <!-- Modal for sending Accountability -->
                                            <div class="modal fade" id="accountEmployeeModal_{{ @$absense->teacher->id }}" tabindex="-1" role="dialog" aria-labelledby="accountEmployeeModal_{{ @$absense->teacher->id }}" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="accountEmployeeModal_{{ @$absense->teacher->id }}">إرسال مسائلة</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('admin.messages.accountTeacher', @$absense->teacher->id) }}" method="post" id="accountEmployeeForm_{{ @$absense->teacher->id }}">
                                                                @csrf
                                                                <h5>تأكيد طباعة المسائلة في ملف pdf, يرجى العلم بأنه سوف يتم تخزين الملف في أرشيف الملفات الخاص بالموظف</h5>
                                                                <input type="hidden" name="type" value="accountability">
                                                            </form>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                                                            <button type="submit" class="btn btn-primary" form="accountEmployeeForm_{{ @$absense->teacher->id }}">إرسال</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal for sending Notification -->
                                            <div class="modal fade" id="editEmployeeModal_{{ @$absense->teacher->id }}" tabindex="-1" role="dialog" aria-labelledby="editEmployeeModal_{{ @$absense->teacher->id }}" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editEmployeeModal_{{ @$absense->teacher->id }}">طباعة إشعار حسم</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('admin.messages.notifyTeacher', @$absense->teacher->id) }}" method="post" id="editTemplateForm_{{ @$absense->teacher->id }}">
                                                                @csrf
                                                                <h5>تأكيد طباعة إشعار الحسم في ملف pdf, يرجى العلم بأنه سوف يتم تخزين الملف في أرشيف الملفات الخاص بالموظف</h5>
                                                                <input type="hidden" name="type" value="notification">
                                                            </form>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                                                            <button type="submit" class="btn btn-primary" form="editTemplateForm_{{ @$absense->teacher->id }}">إرسال</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal for sending Decision -->
                                            <div class="modal fade" id="decideEmployee_{{ @$absense->teacer->id }}" tabindex="-1" role="dialog" aria-labelledby="decideEmployee_{{ @$absense->teacer->id }}" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="addTemplateModalLabel">طباعة قرار حسم</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('admin.messages.decideTeacher', @$absense->teacher->id) }}" method="post" id="decideForm_{{ @$absense->teacer->id }}">
                                                                @csrf
                                                                <h5>تأكيد طباعة قرار الحسم في ملف pdf, يرجى العلم بأنه سوف يتم تخزين الملف في أرشيف الملفات الخاص بالموظف</h5>
                                                                <input type="hidden" name="type" value="decision">
                                                            </form>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                                                            <button type="submit" class="btn btn-primary" form="decideForm_{{ @$absense->teacer->id }}">إرسال</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal for sending Email -->
                                            <div class="modal fade" id="sendEmail_{{ @$absense->teacer->id }}" tabindex="-1" role="dialog" aria-labelledby="sendEmail_{{ @$absense->teacer->id }}" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="addTemplateModalLabel">إرسال رد عبر البريد الإلكتروني</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('admin.messages.replyToEmail', @$absense->teacher->id) }}" method="post" enctype="multipart/form-data" id="emailForm_{{ @$absense->teacer->id }}">
                                                                @csrf
                                                                <div class="form-group">
                                                                    <label for="title">عنوان الرسالة:</label>
                                                                    <input type="text" class="form-control" id="title" name="title" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="description">محتوى الرسالة:</label>
                                                                    <textarea class="form-control" id="description" name="description" required></textarea>
                                                                </div>
                                                                <input type="hidden" name="type" value="sendEmail">
                                                                <div class="form-group">
                                                                    <label for="type">نوع الرسالة:</label>
                                                                    <select name="type" id="type" class="form-control" required>
                                                                        <option value="accountability">مسائلة</option>
                                                                        <option value="notification">إشعار حسم</option>
                                                                        <option value="decision">قرار حسم</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="pdf">إرفاق ملف: </label>
                                                                    <input type="file" name="pdf" id="pdf" class="form-control" accept=".pdf, .docx">
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                                                            <button type="submit" class="btn btn-primary" form="emailForm_{{ @$absense->teacer->id }}">إرسال</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
