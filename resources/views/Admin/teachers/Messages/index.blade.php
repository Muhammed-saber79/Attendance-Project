@extends('Layouts.admin')

@section('title')
    أرشيف ملفات المدرب
@endsection

@section('content')
    <main role="main" class="main-content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12">
                    <h2 class="mb-2 page-title">أرشيف ملفات المدرب</h2>
                    <div class="row my-4">
                        <!-- جدول صغير -->
                        <div class="col-md-12">
                            <div class="card shadow">
                                <div class="card-body">
                                    <!-- الجدول -->
                                    <table class="table datatables" id="dataTable-1">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>الملف</th>
                                                <th>نوع الملف</th>
                                                <th>تاريخ الانشاء</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @forelse($attachments as $attachment)
                                                <tr>
                                                    <td>{{ $attachment->id }}</td>
                                                    <td>
                                                        <a href="{{ $attachment->pdf }}">فتح الملف</a>
                                                    </td>
                                                    <td>
                                                        @if($attachment->message_type == 'accountability')
                                                            مسائلة
                                                        @elseif($attachment->message_type == 'notification')
                                                            اشعار حسم
                                                        @else
                                                            قرار حسم
                                                        @endif
                                                    </td>
                                                    <td>{{ $attachment->created_at }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td style="color: red; text-align: center" colspan="11">لا يوجد ملفات خاصة بالمدرب حتى الان</td>
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
