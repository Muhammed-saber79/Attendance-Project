@extends('Layouts.admin')

@section('title')
تحضير الإداريين
@endsection

@section('content')
<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="mb-2 page-title">جدول الحضور اليومي</h2>
                <p class="card-text">جدول لتسجيل حضور المدربين يومياً</p>
                <div class="row my-4">
                    <div class="col-md-12">
                        <div class="card shadow">
                            <div class="card-body">
                                <table class="table" id="attendanceTable">
                                    <thead>
                                        <tr>
                                            <th>رقم الموظف</th>
                                            <th>الاسم</th>
                                            <th>الإدارة التابع لها</th>
                                            <th>الهاتف</th>
                                            <th>البريد الإلكتروني</th>
                                            <th>الصورة الشخصية</th>
                                            <th>الإجراء</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($employees as $employee)
                                        @php
                                        $value ='';
                                        if (App\Models\EmployeeAbsence::where('employee_number', $employee->number)->whereDate('created_at', Date::now()->format('Y-m-d'))->first()) {
                                        $value = 'disabled';
                                        }
                                        @endphp
                                        <tr>
                                            <td>{{ @$employee->number }}</td>
                                            <td>{{ @$employee->name }}</td>
                                            <td>{{ @$employee->department }}</td>
                                            <td>{{ @$employee->phone }}</td>
                                            <td>{{ @$employee->email }}</td>
                                            <td>
                                                <img src="{{ @$employee->getFirstMediaUrl('image', 'thumb') }}" width="75px" alt="صورة الموظف">
                                            </td>
                                            <td id="parent-{{ @$employee->id }}">
                                                <button {{$value}} onclick="change_status(this)" class="btn btn-sm btn-success change_status" data-type="attend" data-employee_number="{{ @$employee->number }}" data-id="{{ @$employee->id }}">حضور</button>
                                                {{-- <button {{$value}} onclick="change_status(this)" class="btn btn-sm btn-warning change_status" data-type="late" data-employee_number="{{ @$employee->number }}" data-id="{{ @$employee->id }}">تاخير</button>--}}
                                                <button {{$value}} onclick="change_status(this)" class="btn btn-sm btn-danger change_status" data-type="absent" data-employee_number="{{ @$employee->number }}" data-id="{{ @$employee->id }}">غياب</button>

                                                <button {{$value}} class="btn btn-sm btn-warning" data-toggle="modal" data-target="#statusChangeModal-{{ @$employee->id }}">تاخير</button>
                                                <!-- Modal -->
                                                <div class="modal fade" id="statusChangeModal-{{ @$employee->id }}" tabindex="-1" role="dialog" aria-labelledby="statusChangeModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="statusChangeModalLabel">تغيير الحالة</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form id="statusChangeForm-{{ @$employee->id }}" onsubmit="submitForm(this, event)">
                                                                    <!-- Hidden inputs to hold employee data -->
                                                                    <input type="hidden" name="employee_number" id="employee_number" value="{{ @$employee->number }}">
                                                                    <input type="hidden" name="id" id="employee_id" value="{{ @$employee->id }}">
                                                                    <input type="hidden" name="type" id="type" value="late">
                                                                    <input type="hidden" name="elementId" id="elementId" value="parent-{{ @$employee->id }}">
                                                                    <input type="hidden" name="modalId" id="modalId" value="statusChangeModal-{{ @$employee->id }}">

                                                                    <div class="form-group">
                                                                        <label for="fromTime">بداية من الساعة: </label>
                                                                        <input oninput="limitTimeRange(this, '{{ "statusChangeForm-" . @$employee->id }}')" type="time" name="fromTime" id="fromTime" class="form-control"  min="00:00" max="23:59" required>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="toTime">إلى الساعة: </label>
                                                                        <input type="time" name="toTime" id="toTime" class="form-control" max="23:59" required>
                                                                    </div>

                                                                    <button type="submit" class="btn btn-primary">حفظ</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
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
    <div class="modal fade modal-notif modal-slide" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="defaultModalLabel">Notifications</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="list-group list-group-flush my-n3">
                        <div class="list-group-item bg-transparent">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="fe fe-box fe-24"></span>
                                </div>
                                <div class="col">
                                    <small><strong>Package has uploaded successfull</strong></small>
                                    <div class="my-0 text-muted small">Package is zipped and uploaded</div>
                                    <small class="badge badge-pill badge-light text-muted">1m ago</small>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item bg-transparent">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="fe fe-download fe-24"></span>
                                </div>
                                <div class="col">
                                    <small><strong>Widgets are updated successfull</strong></small>
                                    <div class="my-0 text-muted small">Just create new layout Index, form, table</div>
                                    <small class="badge badge-pill badge-light text-muted">2m ago</small>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item bg-transparent">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="fe fe-inbox fe-24"></span>
                                </div>
                                <div class="col">
                                    <small><strong>Notifications have been sent</strong></small>
                                    <div class="my-0 text-muted small">Fusce dapibus, tellus ac cursus commodo</div>
                                    <small class="badge badge-pill badge-light text-muted">30m ago</small>
                                </div>
                            </div> <!-- / .row -->
                        </div>
                        <div class="list-group-item bg-transparent">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="fe fe-link fe-24"></span>
                                </div>
                                <div class="col">
                                    <small><strong>Link was attached to menu</strong></small>
                                    <div class="my-0 text-muted small">New layout has been attached to the menu</div>
                                    <small class="badge badge-pill badge-light text-muted">1h ago</small>
                                </div>
                            </div>
                        </div> <!-- / .row -->
                    </div> <!-- / .list-group -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Clear All</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade modal-shortcut modal-slide" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="defaultModalLabel">Shortcuts</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body px-5">
                    <div class="row align-items-center">
                        <div class="col-6 text-center">
                            <div class="squircle bg-success justify-content-center">
                                <i class="fe fe-cpu fe-32 align-self-center text-white"></i>
                            </div>
                            <p>Control area</p>
                        </div>
                        <div class="col-6 text-center">
                            <div class="squircle bg-primary justify-content-center">
                                <i class="fe fe-activity fe-32 align-self-center text-white"></i>
                            </div>
                            <p>Activity</p>
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-6 text-center">
                            <div class="squircle bg-primary justify-content-center">
                                <i class="fe fe-droplet fe-32 align-self-center text-white"></i>
                            </div>
                            <p>Droplet</p>
                        </div>
                        <div class="col-6 text-center">
                            <div class="squircle bg-primary justify-content-center">
                                <i class="fe fe-upload-cloud fe-32 align-self-center text-white"></i>
                            </div>
                            <p>Upload</p>
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-6 text-center">
                            <div class="squircle bg-primary justify-content-center">
                                <i class="fe fe-users fe-32 align-self-center text-white"></i>
                            </div>
                            <p>Users</p>
                        </div>
                        <div class="col-6 text-center">
                            <div class="squircle bg-primary justify-content-center">
                                <i class="fe fe-settings fe-32 align-self-center text-white"></i>
                            </div>
                            <p>Settings</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main> <!-- main -->
@endsection

@section('scripts')
<script>
    function change_status(element) {
        let dataType = $(element).data('type');
        let dataId = $(element).data('id');
        let employee_number = $(element).data('employee_number');

        $.ajax({
            type: 'GET',
            url: '/admin/employees-attendance/change_status',
            data: {
                type: dataType,
                id: dataId,
                employee_number: employee_number
            },
            success: function(response) {
                $(element).parent().find('button').attr('disabled', 'disabled');
                toastr.success('', 'Success');
            },
            error: function(error) {
                console.error(error);
            }
        });
    }

    function change_status_late(formData) {
        let dataType = formData.type;
        let dataId = formData.id;
        let employee_number = formData.employee_number;
        let element_id = formData.elementId;
        let modalId = formData.modalId;
        let from = formData.fromTime;
        let to = formData.toTime;

        $.ajax({
            type: 'GET',
            url: '/admin/employees-attendance/change_status',
            data: {
                type: dataType,
                id: dataId,
                employee_number: employee_number,
                from: from,
                to: to,
            },
            success: function(response) {
                $(`#${element_id}`).find('button').attr('disabled', 'disabled');
                $(`#${modalId}`).modal('hide');
                toastr.success('', 'Success');
            },
            error: function(error) {
                console.error(error);
            }
        });
    }

    function submitForm (element, event) {
        event.preventDefault();
        let formData = $(element).serializeArray(); // Serialize form data as an array
        let formDataObject = {};
        $.each(formData, function(index, field) {
            formDataObject[field.name] = field.value;
        });
        change_status_late(formDataObject);
    }

    function limitTimeRange(element, formId) {
        let timeValue = element.value;
        $(`#${formId}`).find('#toTime').prop('min', timeValue);
    }
</script>
@endsection
