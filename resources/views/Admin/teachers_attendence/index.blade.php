@extends('layouts.admin')
@section('content')
<main role="main" class="main-content">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-12">
        <h2 class="mb-2 page-title">جدول الحضور اليومي</h2>
        <p class="card-text">جدول لتسجيل حضور المدرسين يومياً</p>
        <div class="row my-4">
          <div class="col-md-12">

            <div class="card shadow">
              <div class="card-body">
                <div class="mb-3">
                  <button class="btn btn-primary" data-toggle="modal" data-target="#uploadExcel">رفع ملف اكسيل </button>
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
        <div class="modal-header">
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

<script>
  function yassin(){
    test()
  }
</script>

@endsection

@section('scripts')
<script type="text/javascript">
  $(function () {
    var table = $('#attendence').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.teacher_attendence.index') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'teacher_name', name: 'teacher_name'},
            {data: 'teacher_number', name: 'teacher_number'},
            {data: 'department', name: 'department'},
            {data: 'building', name: 'building'},
            {data: 'room', name: 'room'},
            {data: 'day', name: 'day'},
            {data: 'lecture_time', name: 'lecture_time'},
            {data: 'lecture_number', name: 'lecture_number'},
            {data: 'subject_name', name: 'subject_name'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
      
  });
</script>
<script>
 

        
           function change_status(element){
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
                    teacher_number:teacher_number
                },
                success: function (response) {
                    // Handle success response
                    $(element).parent().find('button').prop('disabled', true);
                    toastr.success('', 'Success');
                    console.log(response);
                },
                error: function (error) {
                    // Handle error
                    console.error(error);
                }
            });
          }
          


</script>
@endsection