@extends('Layouts.admin')

@section('title')
    جدول الحضور اليومي
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
                <div class="mb-3">
                  <button class="btn btn-primary mx-1" data-toggle="modal" data-target="#uploadExcel">رفع ملف اكسيل </button>
                  <button class="btn btn-danger mx-1" data-toggle="modal" data-target="#deleteAll">حذف كل البيانات</button>
                  <button class="btn btn-info mx-1" data-toggle="modal" data-target="#templateData">بيانات القالب الأساسي</button>
                </div>
                <table class="table data-table" id="attendence">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>اسم المدرب</th>
                      <th>رقم المدرب </th>
                      <th>الشعبة</th>
                      <th>المبنى</th>
                      <th>الغرفة</th>
                      <th>اليوم</th>
                      <th>وقت المحاضرة</th>
                      <th>رقم المحاضرة </th>
                      <th>اسم المقرر</th>
                      <th>الإجراء</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div> <!-- .row -->
  </div> <!-- .container-fluid -->


  <!-- Modal for adding a new email template -->
  <div class="modal fade" id="uploadExcel" tabindex="-1" role="dialog" aria-labelledby="addTemplateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h5 class="modal-title" id="addTemplateModalLabel">رفع ملف اكسيل</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="addTemplateForm" action="{{route('admin.teacher_attendence.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
              <label for="templateName">الملف :</label>
              <input type="file" class="form-control" id="file" name="file" required>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
              <button type="submit" class="btn btn-primary" form="addTemplateForm">إضافة</button>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>
  <div class="modal fade" id="deleteAll" tabindex="-1" role="dialog" aria-labelledby="addTemplateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-danger">
          <h5 class="modal-title" id="addTemplateModalLabel"> </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

            <div class="form-group">
              <h2>هل انت متاكد من حذف جميع البيانات ؟ </h2>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
              <a href="{{route('admin.delete_all')}}" class="btn btn-danger" form="addTemplateForm">حذف</a>
            </div>
        </div>

      </div>
    </div>
  </div>
  <div class="modal fade" id="templateData" tabindex="-1" role="dialog" aria-labelledby="addTemplateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <style>
              .pretty-card {
                  background-color: palegreen;
                  color: #0c5460;
                  border-radius: 5px;
                  padding: 10px;
                  margin-bottom: 10px;
                  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
              }
          </style>
        <div class="modal-header bg-info">
          <h5 class="modal-title" id="addTemplateModalLabel">البيانات الاساسية للقالب</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
              <div class="form-group d-flex flex-wrap justify-content-around">
                  <div class="pretty-card mx-1">
                      <span class="text-center">اسم المدرب</span>
                  </div>
                  <div class="pretty-card mx-1">
                      <span class="text-center">رقم المدرب</span>
                  </div>
                  <div class="pretty-card mx-1">
                      <span class="text-center">متبقي</span>
                  </div>
                  <div class="pretty-card mx-1">
                      <span class="text-center">مسجلين</span>
                  </div>
                  <div class="pretty-card mx-1">
                      <span class="text-center">سعة</span>
                  </div>
                  <div class="pretty-card mx-1">
                      <span class="text-center">قاعة</span>
                  </div>
                  <div class="pretty-card mx-1">
                      <span class="text-center">مبنى</span>
                  </div>
                  <div class="pretty-card mx-1">
                      <span class="text-center">نوع الجدولة</span>
                  </div>
                  <div class="pretty-card mx-1">
                      <span class="text-center">الوقت</span>
                  </div>
                  <div class="pretty-card mx-1">
                      <span class="text-center">اليوم</span>
                  </div>
                  <div class="pretty-card mx-1">
                      <span class="text-center">نوع الشعبة</span>
                  </div>
                  <div class="pretty-card mx-1">
                      <span class="text-center">ساعات الاتصال</span>
                  </div>
                  <div class="pretty-card mx-1">
                      <span class="text-center">ساعات المحاسبة</span>
                  </div>
                  <div class="pretty-card mx-1">
                      <span class="text-center">الرقم المرجعي</span>
                  </div>
                  <div class="pretty-card mx-1">
                      <span class="text-center">اسم المقرر</span>
                  </div>
                  <div class="pretty-card mx-1">
                      <span class="text-center">المقرر</span>
                  </div>
                  <div class="pretty-card mx-1">
                      <span class="text-center">القسم</span>
                  </div>
                  <div class="pretty-card mx-1">
                      <span class="text-center">جزء الفصل</span>
                  </div>
                  <div class="pretty-card mx-1">
                      <span class="text-center">الوحدة التدريبية</span>
                  </div>
                  <div class="pretty-card mx-1">
                      <span class="text-center">الفصل التدريبي</span>
                  </div>
              </div>
          </div>
        <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">حسنا</button>
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
<script type="text/javascript">
  $(function() {
    var table = $('#attendence').DataTable({
      processing: true,
      serverSide: true,
      ajax: "{{ route('admin.teacher_attendence.index') }}",
      columns: [{
          data: 'id',
          name: 'id'
        },
        {
          data: 'teacher_name',
          name: 'teacher_name'
        },
        {
          data: 'teacher_number',
          name: 'teacher_number'
        },
        {
          data: 'department',
          name: 'department'
        },
        {
          data: 'building',
          name: 'building'
        },
        {
          data: 'room',
          name: 'room'
        },
        {
          data: 'day',
          name: 'day'
        },
        {
          data: 'lecture_time',
          name: 'lecture_time'
        },
        {
          data: 'lecture_number',
          name: 'lecture_number'
        },
        {
          data: 'subject_name',
          name: 'subject_name'
        },
        {
          data: 'action',
          name: 'action',
          orderable: false,
          searchable: false
        },
      ]
    });

  });
</script>
<script>
  function change_status(element) {
    var dataType = $(element).data('type');
    var dataId = $(element).data('id');
    var teacher_number = $(element).data('teacher_number');

    // Make an AJAX call to the Laravel backend
    $.ajax({
      type: 'GET',
      url: '/admin/change_status', // Replace with your actual Laravel backend endpoint
      data: {
        type: dataType,
        id: dataId,
        teacher_number: teacher_number
      },
      success: function(response) {
        // Handle success response
        $(element).parent().find('button').prop('disabled', true);
        toastr.success('', 'Success');
        console.log(response);
      },
      error: function(error) {
        // Handle error
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
          url: '/admin/change_status',
          data: {
              type: dataType,
              id: dataId,
              teacher_number: employee_number,
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
