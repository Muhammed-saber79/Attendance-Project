@extends('Layouts.admin')

@section('title')
    معاملات الإداريين
@endsection

@section('content')
    <main role="main" class="main-content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12">
                    <h2 class="mb-2 page-title">معاملات الإداريين في حالة التأخير</h2>
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
                                            <th>تاريخ التأخير</th>
                                            <th>وقت التأخير</th>
                                            <th>حالة التواصل</th>
                                            <th>تاريخ الإرسال</th>
                                            <th>الملفات</th>
                                            <th>الصورة الشخصية</th>
                                            <th>الإجراء</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @forelse($lateEmployees as $late)
                                            @php
                                                $empData = \App\Models\Employee::with(['messages'])->find($late->employee_id);
                                            @endphp
                                            <tr>
                                                <td>{{ @$late->employee->number }}</td>
                                                <td>{{ @$late->employee->name }}</td>
                                                <td>{{ @$late->employee->department }}</td>
                                                <td>{{ @$late->employee->phone }}</td>
                                                <td>{{ @$late->employee->email }}</td>
                                                <td>{{ @$late->created_at->format('d-m-Y') }}</td>
                                                <td>
                                                    <span>من: {{ @$late->from }}</span>
                                                    <span>إلى: {{ @$late->to }}</span>
                                                </td>
                                                <td>
                                                    @if(@$late->is_replied)
                                                        <span class="text-success">تم إرسال اشعار</span>
                                                    @else
                                                        <span class="text-warning">لم يتم إرسال اشعار</span>
                                                    @endif
                                                </td>

                                                @if(@$late->is_replied)
                                                    @php
                                                        $message = $empData->messages()->where('type', 'accountability')->orWhere('type', 'notification')->whereDate('created_at', '>=', now()->subDays(2))->first();
                                                    @endphp
                                                    <td class="text-info">{{ $message->created_at->diffForHumans() }}</td>
                                                @else
                                                    <td class="text-info">لم يحدد بعد</td>
                                                @endif

                                                @if(@$late->employee->attachments()->count() > 0)
                                                    <td class="text-primary">
                                                        <a href="{{ route('admin.messages.employee', $late->employee->id) }}">
                                                            أرشيف الملفات
                                                        </a>
                                                    </td>
                                                @else
                                                    <td class="text-primary-light">لا يوجد ملفات</td>
                                                @endif

                                                <td>
                                                    <img src="{{ @$empData->getFirstMediaUrl('image', 'thumb') }}" width="75px" alt="صورة الموظف">
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <span class="text-muted sr-only">الإجراء</span>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" data-toggle="modal" data-target="#accountEmployeeModal_{{ @$empData->id }}">مسائلة</a>
                                                        <a class="dropdown-item" data-toggle="modal" data-target="#editEmployeeModal_{{ @$empData->id }}">اشعار حسم</a>
                                                        <a class="dropdown-item" href="" @if(@$late->is_replied) data-toggle="modal" data-target="#decideEmployee_{{ @$empData->id }}" @endif>قرار حسم</a>
                                                        <a class="dropdown-item" href="" @if(@$late->is_replied) data-toggle="modal" data-target="#sendEmail_{{ @$empData->id }}" @endif>إرسال رد على الايميل</a>
                                                    </div>
                                                </td>

                                                <!-- Modal for sending Accountability -->
                                                <div class="modal fade" id="accountEmployeeModal_{{ @$empData->id }}" tabindex="-1" role="dialog" aria-labelledby="accountEmployeeModal_{{ @$empData->id }}" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="accountEmployeeModal_{{ @$empData->id }}">إرسال مسائلة</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('admin.messages.accountEmployee', @$empData->id) }}" method="post" id="accountEmployeeForm_{{ @$empData->id }}">
                                                                    @csrf
                                                                    <h5>تأكيد طباعة المسائلة في ملف pdf, يرجى العلم بأنه سوف يتم تخزين الملف في أرشيف الملفات الخاص بالموظف</h5>
                                                                    <input type="hidden" name="type" value="accountability">

                                                                    {{--
                                                                    <div class="form-group">
                                                                        <label for="title">عنوان الرسالة:</label>
                                                                        <input type="text" class="form-control" id="title" name="title" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="description">محتوى الرسالة:</label>
                                                                        <textarea class="form-control" id="description" name="description" required></textarea>
                                                                    </div>
                                                                    <div class="form-group d-flex align-items-center">
                                                                        <label>طباعة المسائلة pdf:</label>
                                                                        <div class="d-flex flex-row justify-content-between mx-auto">
                                                                            <div class="mx-5">
                                                                                <input type="radio" class="mx-1" id="yes" name="pdf" value="yes" required>
                                                                                <span>نعم</span>
                                                                            </div>
                                                                            <div class="mx-5">
                                                                                <input type="radio" class="mx-1" id="no" name="pdf" value="no" required>
                                                                                <span>لا</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    --}}
                                                                </form>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                                                                <button type="submit" class="btn btn-primary" form="accountEmployeeForm_{{ @$empData->id }}">إرسال</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Modal for sending Notification -->
                                                <div class="modal fade" id="editEmployeeModal_{{ @$empData->id }}" tabindex="-1" role="dialog" aria-labelledby="editEmployeeModal_{{ @$empData->id }}" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="editEmployeeModal_{{ @$empData->id }}">طباعة إشعار حسم</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('admin.messages.notifyEmployee', @$empData->id) }}" method="post" id="editTemplateForm_{{ @$empData->id }}">
                                                                    @csrf
                                                                    <h5>تأكيد طباعة إشعار الحسم في ملف pdf, يرجى العلم بأنه سوف يتم تخزين الملف في أرشيف الملفات الخاص بالموظف</h5>
                                                                    <input type="hidden" name="type" value="notification">

                                                                    {{--
                                                                    <div class="form-group">
                                                                        <label for="title">عنوان الرسالة:</label>
                                                                        <input type="text" class="form-control" id="title" name="title" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="description">محتوى الرسالة:</label>
                                                                        <textarea class="form-control" id="description" name="description" required></textarea>
                                                                    </div>
                                                                    <div class="form-group d-flex align-items-center">
                                                                        <label>طباعة المسائلة pdf:</label>
                                                                        <div class="d-flex flex-row justify-content-between mx-auto">
                                                                            <div class="mx-5">
                                                                                <input type="radio" class="mx-1" id="yes" name="pdf" value="yes" required>
                                                                                <span>نعم</span>
                                                                            </div>
                                                                            <div class="mx-5">
                                                                                <input type="radio" class="mx-1" id="no" name="pdf" value="no" required>
                                                                                <span>لا</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    --}}
                                                                </form>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                                                                <button type="submit" class="btn btn-primary" form="editTemplateForm_{{ @$empData->id }}">إرسال</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Modal for sending Decision -->
                                                <div class="modal fade" id="decideEmployee_{{ @$empData->id }}" tabindex="-1" role="dialog" aria-labelledby="decideEmployee_{{ @$empData->id }}" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="addTemplateModalLabel">طباعة قرار حسم</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('admin.messages.decideEmployee', @$empData->id) }}" method="post" id="decideForm_{{ @$empData->id }}">
                                                                    @csrf
                                                                    <h5>تأكيد طباعة قرار الحسم في ملف pdf, يرجى العلم بأنه سوف يتم تخزين الملف في أرشيف الملفات الخاص بالموظف</h5>
                                                                    <input type="hidden" name="type" value="decision">

                                                                    {{--
                                                                    <div class="form-group">
                                                                        <label for="title">عنوان الرسالة:</label>
                                                                        <input type="text" class="form-control" id="title" name="title" required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="description">محتوى الرسالة:</label>
                                                                        <textarea class="form-control" id="description" name="description" required></textarea>
                                                                    </div>
                                                                    <div class="form-group d-flex align-items-center">
                                                                        <label>طباعة المسائلة pdf:</label>
                                                                        <div class="d-flex flex-row justify-content-between mx-auto">
                                                                            <div class="mx-5">
                                                                                <input type="radio" class="mx-1" id="yes" name="pdf" value="yes" required>
                                                                                <span>نعم</span>
                                                                            </div>
                                                                            <div class="mx-5">
                                                                                <input type="radio" class="mx-1" id="no" name="pdf" value="no" required>
                                                                                <span>لا</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    --}}
                                                                </form>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                                                                <button type="submit" class="btn btn-primary" form="decideForm_{{ @$empData->id }}">إرسال</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Modal for sending Email -->
                                                <div class="modal fade" id="sendEmail_{{ @$empData->id }}" tabindex="-1" role="dialog" aria-labelledby="sendEmail_{{ @$empData->id }}" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="addTemplateModalLabel">إرسال رد عبر البريد الإلكتروني</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('admin.messages.replyToEmail', @$empData->id) }}" method="post" enctype="multipart/form-data" id="emailForm_{{ @$empData->id }}">
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
                                                                <button type="submit" class="btn btn-primary" form="emailForm_{{ @$empData->id }}">إرسال</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </tr>
                                        @empty
                                            <tr>
                                                <td style="color: red; text-align: center" colspan="11">لا يوجد إداريين مسجلين تأخير بالمنصة حتى الان</td>
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
