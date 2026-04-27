@extends('admin.layout.master')
@section('css')

    <link rel="apple-touch-icon" href="{{ asset('admin/images/ico/apple-icon-120.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('admin/images/ico/favicon.ico') }}">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/vendors/css/file-uploaders/dropzone.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/vendors/css/tables/datatable/datatables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/vendors/css/tables/datatable/extensions/dataTables.checkboxes.css') }}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css-rtl/plugins/file-uploaders/dropzone.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css-rtl/pages/data-list-view.css') }}">
    <!-- END: Page CSS-->



@endsection


@section('content')



    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-left mb-0">الاقسام</h2>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">قائمه الاقسام</a>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="content-body">
                <!-- Data list view starts -->
                <section id="data-thumb-view" class="data-thumb-view-header">
                    <div class="action-btns d-none">
                        <div class="btn-dropdown mr-1 mb-1">
                            <div class="btn-group dropdown actions-dropodown">
                                <button type="button" class="btn btn-white px-1 py-1 dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Actions
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#"><i class="feather icon-trash"></i>Delete</a>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- dataTable starts -->

                    <div class="table-responsive">
                        <table class="table data-thumb-view">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>الصوره</th>
                                    <th>الاسم</th>
                                    <th>meta_title</th>
                                    <th>meta_description</th>
                                    <th>اجراء</th>
                                </tr>
                            </thead>
                            <tbody>

                            @foreach ($Categorylist as $Category)
                                <tr>
                                    <td></td>
                                    <td class="product-img "><img src="{{ asset($Category->catimg) }}" alt="Img placeholder">
                                    </td>
                                    <td class="Category-name name{{ $Category->id }}">{{$Category->name}}</td>
                                    <td class="Category-category meta_title{{ $Category->id }}"> {{ $Category->meta_title }} </td>

                                    <td class="Category-stock meta_description{{ $Category->id }}"> {{ $Category->meta_description }} </td>
                                    <td class="Category-action">
                                    <span class="action-edit" data-id="{{ $Category->id }}">
                                        <i class="feather icon-edit"></i>
                                    </span>
                                    <span class='del' data-toggle="modal" data-id_del="{{ $Category->id }}" data-target="#danger">
                                        <i class="feather icon-trash"  ></i>
                                    </span>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- dataTable ends -->






                    <!-- add new sidebar starts -->
                <form action='{{ Route('add_Category') }}' id='CategoryForm' method='POST' enctype="multipart/form-data">
                        @csrf
                    <input type="hidden"  name="Category_id" value='' id="Category_id">
                    <div class="add-new-data-sidebar">

                        <div class="overlay-bg"></div>
                        <div class="add-new-data">
                            <div class="div mt-2 px-2 d-flex new-data-title justify-content-between">
                                <div>
                                    <h4 class="text-uppercase">اضافه منتج</h4>
                                </div>
                                <div class="hide-data-sidebar">
                                    <i class="feather icon-x"></i>
                                </div>
                            </div>
                            <div class="data-items pb-3">
                                <div class="data-fields px-2 mt-3">
                                    <div class="row">
                                        <div class="col-sm-12 data-field-col">
                                            <label for="data-name">الاسم</label>
                                            <input type="text" name="name" class="form-control" id="data-name">
                                        </div>



                                        <div class="col-sm-12 data-field-col">
                                            <label for="data-price">meta_title</label>
                                            <input type="text" name='meta_title' class="form-control" id="meta_title">
                                        </div>
                                        <div class="col-sm-12 data-field-col">
                                            <label for="data-price">meta_description</label>
                                            <input type="text" name='meta_description'class="form-control" id="meta_description">
                                        </div>

                                        <div class="col-sm-12 data-field-col data-list-upload">
                                            <fieldset class="form-group">
                                                <label for="basicInputFile">الصوره الاساسيه</label>
                                                <input type="file" value='' id="data-catimg" name='catimg' class="form-control-file" id="basicInputFile">
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="add-data-footer d-flex justify-content-around px-3 mt-2">
                                <div class="add-data-btn">
                                    <button class="btn btn-primary">تاكيد</button>
                                </div>
                                <div class="cancel-data-btn">
                                    <button class="btn btn-outline-danger">الغاء</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>


                    <!-- add new sidebar ends -->
                </section>
                <!-- Data list view end -->

            </div>
        </div>
    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

        {{-- modals  --}}

        <div class="modal-danger mr-1 mb-1 d-inline-block">
            <!-- Modal -->

            <form action="" class="modal fade text-left" method="POST" id="danger" tabindex="-1" role="dialog" aria-labelledby="myModalLabel120" aria-hidden="true">
                @csrf
                <input name="CategoryId" id="catId" type="hidden" value="">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-danger white">
                            <h5 class="modal-title" id="myModalLabel120">تاكيد الحذف</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            هل انت متاكد من حذف القسم اذا حذفت القسم فسيتم حذف المنتجات بداخله  !
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" data-dismiss="modal">الغاء</button>
                            <input  type="submit" value='تاكيد' class="btn btn-outline-danger" >
                        </div>
                    </div>
                </div>
            </form>
        </div>




@endsection




@section('script')


    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset('admin/vendors/js/extensions/dropzone.min.js') }}"></script>
    <script src="{{ asset('admin/vendors/js/tables/datatable/datatables.min.js') }}"></script>
    <script src="{{ asset('admin/vendors/js/tables/datatable/datatables.buttons.min.js') }}"></script>
    <script src="{{ asset('admin/vendors/js/tables/datatable/datatables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('admin/vendors/js/tables/datatable/buttons.bootstrap.min.js') }}"></script>
    <script src="{{ asset('admin/vendors/js/tables/datatable/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('admin/vendors/js/tables/datatable/datatables.checkboxes.min.js') }}"></script>
    <!-- END: Page Vendor JS-->




    <!-- BEGIN: Page JS-->
    <script src="{{ asset('admin/js/scripts/ui/data-list-view.js') }}"></script>
    <script src="{{ asset('admin/js/scripts/ui/edit-view.js') }}"></script>
    <!-- END: Page JS-->


    {{-- modals --}}
    <script src="{{ asset('admin/js/scripts/modal/components-modal.js') }}"></script>


<script>

$(document).ready(function() {
  "use strict"

    $('.del').on("click",function(){
        let CategoryId = $(this).data('id_del');
        // on del
        $('#danger').attr(
            'action',
            "{{ route('DelCat', ':id') }}".replace(':id', CategoryId)
        );
        $('#catId').val(CategoryId);


    });


      // On Edit
    $('.action-edit').on("click",function(e){
        e.stopPropagation();
        let CategoryId = $(this).data('id');


        $('#data-name').val($('.name'+CategoryId).text());
        $('#meta_title').val($('.meta_title'+CategoryId).text());
        $('#meta_description').val($('.meta_description'+CategoryId).text());

        // تغيير action
            $('#CategoryForm').attr(
            'action',
            "{{ route('updateCat', ':id') }}".replace(':id', CategoryId)
            );

        // وضع id المنتج
        $('#Category_id').val(CategoryId);

        // تغيير العنوان
        $('.new-data-title h4').text('تعديل القسم');

        // تغيير زر التأكيد
        $('.add-data-btn button').text('تعديل');

        // إظهار الفورم لو مخفي
        $('.add-new-data-sidebar').addClass('show');

        $('input[name="name"]').val();

    });

});



</script>





@endsection
