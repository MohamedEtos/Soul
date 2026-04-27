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
                            <h2 class="content-header-title float-left mb-0">الاقمشة</h2>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">قائمه الاقمشة</a>
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

                    <!-- dataTable starts -->

                    <div class="table-responsive">
                        <table class="table data-thumb-view">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>#</th>
                                    <th>الاسم</th>
                                    <th>شحن مجاني</th>
                                    <th>سعر الشحن</th>
                                    <th>حذف</th>
                                </tr>
                            </thead>
                            <tbody>

                            @foreach ($shaping_coast as $coast)
                                <tr>
                                    <td></td>
                                    <td class="Category-id id{{ $coast->id }}">{{$coast->id}}</td>
                                    <td class="Category-name name{{ $coast->id }}">{{$coast->name_ar}}</td>
                                    <td class="free-shipping-cell" data-id="{{ $coast->id }}">
                                        <button
                                            type="button"
                                            class="btn btn-sm toggle-free-shipping {{ $coast->free_shipping ? 'btn-success' : 'btn-secondary' }}"
                                            data-id="{{ $coast->id }}"
                                            data-free-shipping="{{ $coast->free_shipping ? 1 : 0 }}">
                                            <span class="free-shipping-text-{{ $coast->id }}">
                                                {{ $coast->free_shipping ? 'مجاني' : 'غير مجاني' }}
                                            </span>
                                        </button>
                                    </td>
                                    <td class="Category-price price{{ $coast->id }}">
                                        <input
                                            type="number"
                                            step="0.01"
                                            min="0"
                                            class="form-control form-control-sm shipping-cost-input"
                                            value="{{ $coast->shipping_cost }}"
                                            data-id="{{ $coast->id }}"
                                            data-original-value="{{ $coast->shipping_cost }}"
                                            style="width: 120px; display: inline-block;">
                                        <span class="shipping-cost-text-{{ $coast->id }}"> ج.م</span>
                                    </td>
                                    <td>
                                        <div class="danger" data-id="{{ $coast->id }}">
                                            <i class="feather icon-trash text-danger" style="cursor: pointer; font-size: 1.2rem;"></i>
                                        </div>
                                    </td>


                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- dataTable ends -->






                    <!-- add new sidebar starts -->
                <form action="{{Route('store_shaping_coast')}}" id='CategoryForm' method='POST' enctype="multipart/form-data">
                        @csrf
                    <div class="add-new-data-sidebar">

                        <div class="overlay-bg"></div>
                        <div class="add-new-data">
                            <div class="div mt-2 px-2 d-flex new-data-title justify-content-between">
                                <div>
                                    <h4 class="text-uppercase">اضافه محافظة</h4>
                                </div>
                                <div class="hide-data-sidebar">
                                    <i class="feather icon-x"></i>
                                </div>
                            </div>
                            <div class="data-items pb-3">
                                <div class="data-fields px-2 mt-3">
                                    <div class="row">
                                        <div class="col-sm-12 data-field-col">
                                            <label for="name_ar">الاسم بالعربية</label>
                                            <input type="text" name="name_ar" class="form-control" id="name_ar" required>
                                        </div>
                                        <div class="col-sm-12 data-field-col">
                                            <label for="name_en">الاسم بالانجليزية</label>
                                            <input type="text" name="name_en" class="form-control" id="name_en" required>
                                        </div>
                                        <div class="col-sm-12 data-field-col">
                                            <label for="shipping_cost">سعر الشحن</label>
                                            <input type="number" name="shipping_cost" class="form-control" id="shipping_cost" step="0.01" min="0" required>
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

            <!-- Modal -->

            <form action="" class="modal fade text-left" method="POST" id="danger" tabindex="-1" role="dialog" aria-labelledby="myModalLabel120" aria-hidden="true">
                @csrf
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-danger white">
                            <h5 class="modal-title" id="myModalLabel120">تاكيد الحذف</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                             هل انت متاكد من عملية الحذف ؟
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

    {{-- toastr for notifications --}}
    <script src="{{ asset('admin/vendors/js/extensions/toastr.min.js') }}"></script>

<script>

$(document).ready(function() {
  "use strict"

    // Toggle free shipping
    $(document).on('click', '.toggle-free-shipping', function(e) {
        e.preventDefault();
        e.stopPropagation();

        const button = $(this);
        const coastId = button.data('id');
        const currentStatus = button.data('free-shipping');
        const formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');

        // Disable button during request
        button.prop('disabled', true);

        fetch("{{ route('toggle_free_shipping', ':id') }}".replace(':id', coastId), {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update button appearance
                if (data.free_shipping) {
                    button.removeClass('btn-secondary').addClass('btn-success');
                    button.find('.free-shipping-text-' + coastId).text('مجاني');
                    button.data('free-shipping', 1);
                } else {
                    button.removeClass('btn-success').addClass('btn-secondary');
                    button.find('.free-shipping-text-' + coastId).text('غير مجاني');
                    button.data('free-shipping', 0);
                }
                // Show success notification
                toastr.success(data.message, 'تمت العملية');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            toastr.error('حدث خطأ أثناء التحديث', 'خطأ');
        })
        .finally(() => {
            // Re-enable button
            button.prop('disabled', false);
        });
    });

    // Update shipping cost on Enter key
    $(document).on('keypress', '.shipping-cost-input', function(e) {
        if (e.which === 13 || e.keyCode === 13) { // Enter key
            e.preventDefault();
            e.stopPropagation();

            const input = $(this);
            const coastId = input.data('id');
            const newValue = parseFloat(input.val());
            const originalValue = parseFloat(input.data('original-value'));

            // Validate input
            if (isNaN(newValue) || newValue < 0) {
                toastr.warning('يرجى إدخال قيمة صحيحة', 'تحذير');
                input.val(originalValue);
                input.blur();
                return;
            }

            // If value hasn't changed, just blur
            if (newValue === originalValue) {
                input.blur();
                return;
            }

            // Disable input during request
            input.prop('disabled', true);

            const formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('shipping_cost', newValue);

            fetch("{{ route('update_shipping_cost', ':id') }}".replace(':id', coastId), {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update original value
                    input.data('original-value', data.shipping_cost);
                    input.val(parseFloat(data.shipping_cost).toFixed(2));

                    // Show success notification
                    toastr.success(data.message, 'تمت العملية');
                } else {
                    // Revert to original value on error
                    input.val(originalValue);
                    toastr.error('حدث خطأ أثناء التحديث', 'خطأ');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Revert to original value on error
                input.val(originalValue);
                toastr.error('حدث خطأ أثناء التحديث', 'خطأ');
            })
            .finally(() => {
                // Re-enable input and blur
                input.prop('disabled', false);
                input.blur();
            });
        }
    });

    // Update shipping cost on blur (optional - when user clicks outside)
    $(document).on('blur', '.shipping-cost-input', function(e) {
        const input = $(this);
        const coastId = input.data('id');
        const newValue = parseFloat(input.val());
        const originalValue = parseFloat(input.data('original-value'));

        // Validate input
        if (isNaN(newValue) || newValue < 0) {
            input.val(originalValue);
            return;
        }

        // If value hasn't changed, do nothing
        if (newValue === originalValue) {
            return;
        }

        // Disable input during request
        input.prop('disabled', true);

        const formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('shipping_cost', newValue);

        fetch("{{ route('update_shipping_cost', ':id') }}".replace(':id', coastId), {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update original value
                input.data('original-value', data.shipping_cost);
                input.val(parseFloat(data.shipping_cost).toFixed(2));

                // Show success notification
                toastr.success(data.message, 'تمت العملية');
            } else {
                // Revert to original value on error
                input.val(originalValue);
                toastr.error('حدث خطأ أثناء التحديث', 'خطأ');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // Revert to original value on error
            input.val(originalValue);
            toastr.error('حدث خطأ أثناء التحديث', 'خطأ');
        })
        .finally(() => {
            // Re-enable input
            input.prop('disabled', false);
        });
    });



      // On Edit
    $('.action-edit').on("click",function(e){
        e.stopPropagation();
        let CategoryId = $(this).data('id');


        $('#data-name').val($('.name'+CategoryId).text());
        $('#data-price').val($('.price'+CategoryId).text());
        $('#data-stock').val($('.stock'+CategoryId).text());
        $('#data-desc').val($('.desc'+CategoryId).text());
        $('#data-fabric_type').val($('.fabric_type'+CategoryId).text());
        $('#data-cat').val($('.cat'+CategoryId).text());
        $('#data-desc').val($('.productDetalis'+CategoryId).text());
        $(".add-new-data").addClass("show");
        $(".overlay-bg").addClass("show");





        // تغيير action
            $('#productForm').attr(
            'action',
            "{{ route('edit_product', ':id') }}".replace(':id', CategoryId)
            );

        // وضع id المنتج
        $('#product_id').val(CategoryId);

        // تغيير العنوان
        $('.new-data-title h4').text('تعديل منتج');

        // تغيير زر التأكيد
        $('.add-data-btn button').text('تعديل');

        // إظهار الفورم لو مخفي
        $('.add-new-data-sidebar').addClass('show');

        $('input[name="name"]').val();

    });

    // Delete Confirmation
    $('.danger').on("click", function(e) {
        e.stopPropagation();
        let id = $(this).data('id');

        // Update form action
        $('#danger').attr('action', "{{ route('delete_shaping_coast', ':id') }}".replace(':id', id));

        // Show modal
        $('#danger').modal('show');
    });

});



</script>





@endsection
