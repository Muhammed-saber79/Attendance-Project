@extends('Layouts.admin')

@section('title')
    تحضير الإداريين
@endsection

@section('content')
    <main role="main" class="main-content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12">
                    <h2 class="mb-2 page-title">قائمة الإداريين</h2>
                    <div class="row my-4">
                        <div class="col-md-12 my-3 d-flex justify-content-end">
                            <a href="" class="btn btn-primary" data-toggle="modal" data-target="#addEmployeeModal">تسجيل موظف جديد</a>
                        </div>
                        <!-- Modal for adding a new employee -->
                        <div class="modal fade" id="addEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="addTemplateModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addTemplateModalLabel">تسجيل موظف جديد</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('admin.employees.store') }}" method="post" enctype="multipart/form-data" id="addTemplateForm">
                                            @csrf
                                            <div class="form-group">
                                                <label for="number">رقم الموظف:</label>
                                                <input type="number" class="form-control" id="number" name="number" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="name">الإسم:</label>
                                                <input type="text" class="form-control" id="name" name="name" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="department">الإدارة التابع لها:</label>
                                                <input type="text" class="form-control" id="department" name="department" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="phone">الهاتف:</label>
                                                <input type="number" pattern="[0-9]{11}" class="form-control" id="phone" name="phone" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="email">البريد الإلكتروني:</label>
                                                <input type="email" class="form-control" id="email" name="email" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="image">الصورة الشخصية:</label>
                                                <input type="file" class="form-control" id="image" name="image" required>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                                        <button type="submit" class="btn btn-primary" form="addTemplateForm">إضافة</button>
                                    </div>
                                </div>
                            </div>
                        </div>

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
                                            <th>الصورة الشخصية</th>
                                            <th>الإجراء</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                            @forelse($employees as $employee)
                                                <tr>
                                                    <td>{{ @$employee->number }}</td>
                                                    <td>{{ @$employee->name }}</td>
                                                    <td>{{ @$employee->department }}</td>
                                                    <td>{{ @$employee->phone }}</td>
                                                    <td>{{ @$employee->email }}</td>
                                                    <td>
                                                        <img src="{{ @$employee->getFirstMediaUrl('image', 'thumb') }}" width="75px" alt="صورة الموظف">
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <span class="text-muted sr-only">الإجراء</span>
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" data-toggle="modal" data-target="#editEmployeeModal_{{ @$employee->id }}">تعديل</a>
                                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#deleteEmployeeModal-{{ @$employee->id }}">حذف</a>
                                                        </div>
                                                    </td>

                                                    <!-- Modal for edit employee data -->
                                                    <div class="modal fade" id="editEmployeeModal_{{ @$employee->id }}" tabindex="-1" role="dialog" aria-labelledby="editEmployeeModal_{{ @$employee->id }}" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="editEmployeeModal_{{ @$employee->id }}">تحديث بيانات الموظف</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form action="{{ route('admin.employees.update', $employee->id) }}" method="post" enctype="multipart/form-data" id="editTemplateForm_{{ @$employee->id }}">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <div class="form-group">
                                                                            <label for="number">رقم الموظف:</label>
                                                                            <input type="number" class="form-control" id="number" name="number" value="{{ $employee->number }}" required>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="name">الإسم:</label>
                                                                            <input type="text" class="form-control" id="name" name="name" value="{{ $employee->name }}" required>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="department">الإدارة التابع لها:</label>
                                                                            <input type="text" class="form-control" id="department" name="department" value="{{ $employee->department }}" required>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="phone">الهاتف:</label>
                                                                            <input type="number" pattern="[0-9]{11}" class="form-control" id="phone" name="phone" value="{{ $employee->phone }}" required>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="email">البريد الإلكتروني:</label>
                                                                            <input type="email" class="form-control" id="email" name="email" value="{{ $employee->email }}" required>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="image">الصورة الشخصية:</label>
                                                                            <input type="file" class="form-control" id="image" name="image">
                                                                            <img class="my-2" src="{{ @$employee->getFirstMediaUrl('image', 'thumb') }}" width="75px" alt="صورة الموظف">
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                                                                    <button type="submit" class="btn btn-primary" form="editTemplateForm_{{ @$employee->id }}">تحديث</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Modal for delete an employee -->
                                                    <div class="modal fade" id="deleteEmployeeModal-{{ @$employee->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteEmployeeModal-{{ @$employee->id }}" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="addTemplateModalLabel">حذف بيانات موظف</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <h1 class="text-center">هل انت متأكد من حذف بيانات الموظف ؟</h1>
                                                                    <form action="{{ route('admin.employees.destroy', $employee->id) }}" method="post" enctype="multipart/form-data" id="deleteTemplateForm_{{ @$employee->id }}">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                    </form>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                                                                    <button type="submit" class="btn btn-primary" form="deleteTemplateForm_{{ @$employee->id }}">حذف</button>
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
