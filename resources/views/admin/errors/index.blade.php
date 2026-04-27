@extends('admin.layout.master')

@section('css')
    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/vendors/css/tables/datatable/datatables.min.css') }}">
    <!-- END: Vendor CSS-->


@endsection

@section('content')
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">تقارير الأخطاء</h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">الرئيسية</a></li>
                                <li class="breadcrumb-item active">سجل الأخطاء</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-body">
            <section id="basic-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">قائمة أخطاء النظام</h4>
                                <form action="{{ route('admin.errors.clear') }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف جميع السجلات؟');">
                                    @csrf
                                    <button type="submit" class="btn btn-danger waves-effect waves-light">
                                        <i class="feather icon-trash-2"></i> مسح جميع السجلات
                                    </button>
                                </form>
                            </div>
                            <div class="card-content">
                                <div class="card-body card-dashboard">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered text-center">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>الرسالة</th>
                                                    <th>الملف</th>
                                                    <th>الرابط</th>
                                                    <th>الوقت</th>
                                                    <th>الإجراءات</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($errorLogs as $error)
                                                <tr>
                                                    <td>{{ $error->id }}</td>
                                                    <td class="text-left" style="max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                                        {{ $error->message }}
                                                    </td>
                                                    <td style="direction: ltr;">{{ basename($error->file) }}:{{ $error->line }}</td>
                                                    <td>{{ $error->url }}</td>
                                                    <td>{{ $error->created_at->diffForHumans() }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#errorModal{{ $error->id }}">
                                                            <i class="feather icon-eye"></i>
                                                        </button>
                                                        <a href="{{ route('admin.errors.destroy', $error->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('حذف هذا السجل؟')">
                                                            <i class="feather icon-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>

                                                <!-- Modal -->
                                                <div class="modal fade" id="errorModal{{ $error->id }}" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel{{ $error->id }}" aria-hidden="true">
                                                    <div class="modal-dialog modal-xl" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-danger white">
                                                                <h5 class="modal-title" id="errorModalLabel{{ $error->id }}">تفاصيل الخطأ #{{ $error->id }}</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body text-left" style="direction: ltr;">
                                                                <div class="alert alert-danger">
                                                                    <strong>Message:</strong> {{ $error->message }}
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <p><strong>Code:</strong> {{ $error->code }}</p>
                                                                        <p><strong>File:</strong> {{ $error->file }}</p>
                                                                        <p><strong>Line:</strong> {{ $error->line }}</p>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <p><strong>URL:</strong> {{ $error->url }}</p>
                                                                        <p><strong>Method:</strong> {{ $error->method }}</p>
                                                                        <p><strong>IP:</strong> {{ $error->ip }}</p>
                                                                        <p><strong>User ID:</strong> {{ $error->user_id ?? 'Guest' }}</p>
                                                                        <p><strong>User Agent:</strong> {{ $error->user_agent }}</p>
                                                                    </div>
                                                                </div>
                                                                <hr>
                                                                <h5>Stack Trace:</h5>
                                                                <pre style="background: #f8f9fa; padding: 15px; border-radius: 5px; max-height: 400px; overflow: auto; font-size: 12px;">{{ $error->trace }}</pre>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div class="d-flex justify-content-center">
                                            {{ $errorLogs->links() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection

@section('script')

@endsection
