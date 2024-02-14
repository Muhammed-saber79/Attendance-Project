@extends('Layouts.admin')
@section('content')
<main role="main" class="main-content">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-12">
        <h2 class="mb-2 page-title">جدول المدربين </h2>
        <div class="row my-4">
          <div class="col-md-12">

            <div class="card shadow">
              <div class="card-body">

                <table class="table data-table" id="teachersTable">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>الصورة </th>
                      <th>اسم المدرب</th>
                      <th>رقم المدرب </th>
                      <th>القسم</th>
                      <th>رقم الهاتف</th>
                      <th>البريد الالكتروني</th>

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

  @foreach($data as $line)
  <!-- Modal for adding a new email template -->
  <div class="modal fade" id="editTeacher{{$line->id}}" tabindex="-1" role="dialog" aria-labelledby="addTemplateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addTemplateModalLabel">تعديل بيانات المدرب </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="addTemplateForm" action="{{route('admin.teachers.update', $line->id)}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
              <label for="templateName">الاسم :</label>
              <input type="text" class="form-control" id="file" name="name" value="{{$line->name}}" required>
            </div>
            <div class="form-group">
              <label for="templateName">رقم الهاتف :</label>
              <input type="text" class="form-control" id="file" name="phone" value="{{$line->phone}}">
            </div>
            <div class="form-group">
              <label for="templateName">البريد الالكتروني :</label>
              <input type="text" class="form-control" id="file" name="email" value="{{$line->email}}">
            </div>
            <div class="form-group">
              <label for="templateName">الصورة :</label>
              <input type="file" class="form-control" id="file" name="image">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
              <button type="submit" class="btn btn-primary" form="addTemplateForm">تعديل</button>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>
  @endforeach





</main> <!-- main -->

<script>
  function yassin() {
    test()
  }
</script>

@endsection

@section('scripts')
<script type="text/javascript">
  $(function() {
    var table = $('#teachersTable').DataTable({
      processing: true,
      serverSide: true,
      ajax: "{{ route('admin.teachers.index') }}",
      columns: [
        {
          data: 'id',
          name: 'id'
        },
        {
          data: 'image',
          name: 'image',
          render: function(data, type, full, meta) {
            // Assuming 'profile_picture' is a media field
            return '<img src="' + data + '" alt="Profile Picture" style="width: 50px; height: 50px;">';
          }
        },
        

        {
          data: 'name',
          name: 'name'
        },
        {
          data: 'number',
          name: 'number'
        },
        {
          data: 'department',
          name: 'department'
        },
        {
          data: 'phone',
          name: 'phone'
        },
        {
          data: 'email',
          name: 'email'
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
<<<<<<< HEAD



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


=======
  function change_status(element) {
    var dataType = $(element).data('type');
    var dataId = $(element).data('id');
    var teacher_number = $(element).data('teacher_number');
>>>>>>> 61cabe8574e3a964355000216ea24481016c365b

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
</script>
@endsection
