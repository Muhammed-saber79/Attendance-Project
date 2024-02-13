@extends('Layouts.admin')
@section('content')
<main role="main" class="main-content">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-12">
        <h2 class="mb-2 page-title">جدول المدرسين </h2>
        <div class="row my-4">
          <div class="col-md-12">

            <div class="card shadow">
              <div class="card-body">

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
