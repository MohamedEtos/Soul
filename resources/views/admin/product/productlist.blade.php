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
                            <h2 class="content-header-title float-left mb-0">المنتجات</h2>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">قائمه المنتجات</a>
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
                                    <form id="checkForm" action="{{ route('multideleteProducts') }}" method="post">
                                        @csrf
                                    <button type="submit" form="checkForm" id="checkbox_send" class="dropdown-item danger" href="#"><i class="feather icon-trash "></i>Delete</button>
                                    <div id="hiddenBox"></div>
                                    </form>

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
                                    <th>تفاصيل</th>
                                    <th>المشاهدات</th>
                                    <th>الحاله</th>
                                    <th>الكميه</th>
                                    <th>السعر</th>
                                    <th>اجراء</th>
                                </tr>
                            </thead>
                            <tbody>

                            @foreach ($Productlist as $Product)
                                <tr data-row_id="{{ $Product->id }}">
                                    <td></td>
                                    <td class="product-img "><img src="{{ asset($Product->product_img_p->mainImage) }}" alt="Img placeholder">
                                    </td>
                                    <td class="product-name name{{ $Product->id }}">{{$Product->name}}</td>
                                    <td class="product-category productDetalis{{ $Product->id }}"> {{ $Product->productDetalis }} </td>
                                    <td>
                                        {{ $Product->views }}
                                    </td>
                                    <td>
                                            <div class="chip toggle-status {{
                                                $Product->append == 1 && $Product->stock >= 5 ? 'chip-success' :
                                                ($Product->append == 0 ? 'chip-warning' :
                                                ($Product->stock < 5 ? 'chip-danger' : ''))
                                            }}" data-id="{{ $Product->id }}" style="cursor: pointer;">
                                            <div class="chip-body">
                                                <div class="chip-text">
                                                    {{
                                                        $Product->append == 1 && $Product->stock >= 5 ? 'نشط' :
                                                        ($Product->append == 0 ? 'متوقف' :
                                                        ($Product->stock < 5 ? 'المخزون اقل من 5' : ''))
                                                    }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="product-stock stock{{ $Product->id }}"> {{ $Product->stock }} </td>
                                    <td class="product-price price{{ $Product->id }}"> {{ $Product->price }} </td>
                                    <td class="product-action">
                                    <span class="action-edit" data-id="{{ $Product->id }}">
                                        <i class="feather icon-edit"></i>
                                    </span>
                                    <span class='del' data-id_del="{{ $Product->id }}">
                                        <i class="feather icon-trash"  ></i>
                                    </span>
                                    <!-- Hidden Meta Data for JS -->
                                    <span class="d-none meta_title{{ $Product->id }}">{{ $Product->meta_title }}</span>
                                    <span class="d-none meta_description{{ $Product->id }}">{{ $Product->meta_description }}</span>
                                    <span class="d-none meta_keywords{{ $Product->id }}">{{ $Product->meta_keywords }}</span>
                                    <!-- Hidden Data for Edit Form Population -->
                                    <span class="d-none cat{{ $Product->id }}">{{ $Product->cat_id }}</span>
                                    <span class="d-none fabric_type{{ $Product->id }}">{{ $Product->fabric_id }}</span>
                                    <span class="d-none sizes{{ $Product->id }}">{{ json_encode($Product->sizes) }}</span>
                                    <span class="d-none colors{{ $Product->id }}">{{ json_encode($Product->colors) }}</span>
                                    <span class="d-none alt1{{ $Product->id }}">{{ $Product->product_img_p->alt1 }}</span>
                                    <span class="d-none alt2{{ $Product->id }}">{{ $Product->product_img_p->alt2 }}</span>
                                    <span class="d-none alt3{{ $Product->id }}">{{ $Product->product_img_p->alt3 }}</span>
                                    <span class="d-none alt4{{ $Product->id }}">{{ $Product->product_img_p->alt4 }}</span>
                                    <span class="d-none alt5{{ $Product->id }}">{{ $Product->product_img_p->alt5 }}</span>
                                    <span class="d-none alt6{{ $Product->id }}">{{ $Product->product_img_p->alt6 }}</span>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- dataTable ends -->






                    <!-- add new sidebar starts -->
                <form action='{{ Route('add_product') }}' id='productForm' method='POST' enctype="multipart/form-data">
                        @csrf
                    <input type="hidden"  name="product_id" value='' id="product_id">
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
                                            <input required type="text" name="name" class="form-control" id="data-name">
                                        </div>
                                        <div class="col-sm-12 data-field-col">
                                            <label for="data-category"> القسم </label>
                                            <select class="form-control" name='cat' id="data-cat">
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-12 data-field-col">
                                            <label for="data-status">نوع القماش </label>
                                            <select class="form-control" name='fabric_type' id="data-fabric_type">
                                                @foreach ($fabrics as $fabric)
                                                    <option value="{{ $fabric->id }}">{{ $fabric->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-12 data-field-col">
                                            <label for="data-price">السعر</label>
                                            <input required type="number" name='price' class="form-control" id="data-price">
                                        </div>
                                        <div class="col-sm-12 data-field-col">
                                            <label for="data-price">تفاصيل</label>
                                            <input required type="text" name='desc' class="form-control" id="data-desc">
                                        </div>
                                        <div class="col-sm-12 data-field-col">
                                            <label for="data-price">الكميه المتاحه (الكلي)</label>
                                            <input required type="number" name='stock'class="form-control" id="data-stock">
                                        </div>

                                        <div class="col-sm-12 data-field-col">
                                            <h5 class="mb-1 mt-1">المقاسات (اختياري)</h5>
                                            <div id="sizes-container">
                                                <!-- Dynamic Size Inputs will be here -->
                                            </div>
                                            <button type="button" class="btn btn-sm btn-outline-primary mt-1" id="add-size-btn">اضافة مقاس</button>
                                        </div>

                                        <div class="col-sm-12 data-field-col">
                                            <h5 class="mb-1 mt-1">الالوان (اختياري)</h5>
                                            <div id="colors-container">
                                                <!-- Dynamic Color Inputs will be here -->
                                            </div>
                                            <button type="button" class="btn btn-sm btn-outline-primary mt-1" id="add-color-btn">اضافة لون</button>
                                        </div>

                                        <div class="col-sm-12 data-field-col data-list-upload">
                                            {{-- <form  class="dropzone dropzone-area" id="dataListUpload">
                                                <div class="dz-message">Upload Image</div>
                                            </form> --}}
                                                <fieldset class="form-group">
                                                    <label for="basicInputFile">الصوره الاساسيه</label>
                                                    <input type="file" value='' id="data-mainImage" name='mainImage' class="form-control-file" id="basicInputFile">
                                                </fieldset>

                                                <div class="col-sm-12 data-field-col">
                                                    <label for="data-price">تعريف الصوره 1</label>
                                                    <input  type="text" name='alt1'class="form-control" id="data-alt1">
                                                </div>

                                                <fieldset class="form-group">
                                                    <label for="basicInputFile">صوره ثانويه</label>
                                                    <input type="file" value='' id="data-img2" name='img2' class="form-control-file" id="basicInputFile">
                                                </fieldset>

                                                <div class="col-sm-12 data-field-col">
                                                    <label for="data-price">تعريف الصوره 2</label>
                                                    <input  type="text" name='alt2'class="form-control" id="data-alt2">
                                                </div>
                                                <fieldset class="form-group">
                                                    <label for="basicInputFile">صوره ثانويه</label>
                                                    <input type="file" value='' id="data-img3" name='img3' class="form-control-file" id="basicInputFile">
                                                </fieldset>
                                                <div class="col-sm-12 data-field-col">
                                                    <label for="data-price">تعريف الصوره 1</label>
                                                    <input  type="text" name='alt3'class="form-control" id="data-alt3">
                                                </div>
                                                <fieldset class="form-group">
                                                    <label for="basicInputFile">صوره ثانويه</label>
                                                    <input type="file" value='' id="data-img4" name='img4' class="form-control-file" id="basicInputFile">
                                                </fieldset>
                                                <div class="col-sm-12 data-field-col">
                                                    <label for="data-price">تعريف الصوره 4</label>
                                                    <input  type="text" name='alt4'class="form-control" id="data-alt4">
                                                </div>
                                                <fieldset class="form-group">
                                                    <label for="basicInputFile">صوره ثانويه 5</label>
                                                    <input type="file" value='' id="data-img5" name='img5' class="form-control-file" id="basicInputFile">
                                                </fieldset>
                                                <div class="col-sm-12 data-field-col">
                                                    <label for="data-price">تعريف الصوره 5</label>
                                                    <input  type="text" name='alt5'class="form-control" id="data-alt5">
                                                </div>
                                                <fieldset class="form-group">
                                                    <label for="basicInputFile">صوره ثانويه 6</label>
                                                    <input type="file" value='' id="data-img6" name='img6' class="form-control-file" id="basicInputFile">
                                                </fieldset>
                                                <div class="col-sm-12 data-field-col">
                                                    <label for="data-price">تعريف الصوره 6</label>
                                                    <input  type="text" name='alt6'class="form-control" id="data-alt6">
                                                </div>

                                                <div class="col-sm-12 data-field-col">
                                                    <h4 class="mb-1 mt-2">SEO Meta Data</h4>
                                                </div>
                                                <div class="col-sm-12 data-field-col">
                                                    <label for="meta_title">Meta Title</label>
                                                    <input type="text" name='meta_title' class="form-control" id="data-meta_title">
                                                </div>
                                                <div class="col-sm-12 data-field-col">
                                                    <label for="meta_description">Meta Description</label>
                                                    <textarea name='meta_description' class="form-control" id="data-meta_description"></textarea>
                                                </div>
                                                <div class="col-sm-12 data-field-col">
                                                    <label for="meta_keywords">Meta Keywords</label>
                                                    <input type="text" name='meta_keywords' class="form-control" id="data-meta_keywords" placeholder="keyword1, keyword2, ...">
                                                </div>
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
    <script src="{{ asset('store/vendor/sweetalert/sweetalert.min.js') }}"></script>
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

    // Size Management
    function addSizeRow(size = '', stock = '') {
        let row = `
            <div class="row size-row mb-1">
                <div class="col-5">
                    <input type="text" name="sizes[]" class="form-control form-control-sm" placeholder="المقاس" value="${size}">
                </div>
                <div class="col-5">
                    <input type="number" name="sizes_stock[]" class="form-control form-control-sm" placeholder="الكمية" value="${stock}">
                </div>
                <div class="col-2">
                    <button type="button" class="btn btn-danger btn-sm remove-size text-white">x</button>
                </div>
            </div>
        `;
        $('#sizes-container').append(row);
    }

    $('#add-size-btn').on('click', function() {
        addSizeRow();
    });

    $(document).on('click', '.remove-size', function() {
        $(this).closest('.size-row').remove();
    });


    $(document).on("click", ".del", function(e) {
        e.preventDefault();
        e.stopPropagation();
        let productId = $(this).data('id_del');
        
        if (!productId) {
            swal("خطأ", "لم يتم العثور على رقم المنتج", "error");
            return;
        }

        let deleteUrl = "{{ route('destroy', ':id') }}".replace(':id', productId);
        
        swal({
            title: "هل أنت متأكد من الحذف؟",
            text: "لن تتمكن من استرجاع هذا المنتج بعد الحذف!",
            icon: "warning",
            buttons: {
                cancel: {
                    text: "إلغاء",
                    value: null,
                    visible: true,
                    className: "btn-success",
                    closeModal: true,
                },
                confirm: {
                    text: "نعم، احذف",
                    value: true,
                    visible: true,
                    className: "btn-danger",
                    closeModal: true
                }
            },
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                // Create a temporary form to submit properly with CSRF token
                let form = $('<form>', {
                    'action': deleteUrl,
                    'method': 'POST'
                }).append($('<input>', {
                    'type': 'hidden',
                    'name': '_token',
                    'value': "{{ csrf_token() }}"
                }));
                
                $('body').append(form);
                form.submit();
            }
        });
    });


      // On Edit
    $(document).on("click", ".action-edit", function(e){
        e.stopPropagation();
        let productId = $(this).data('id');


        $('#data-name').val($('.name'+productId).text().trim());
        $('#data-price').val($('.price'+productId).text().trim());
        $('#data-stock').val($('.stock'+productId).text().trim());
        // $('#data-desc').val($('.desc'+productId).text().trim()); // Removed redundant call
        $('#data-fabric_type').val($('.fabric_type'+productId).text().trim());
        $('#data-cat').val($('.cat'+productId).text().trim());
        $('#data-cat').val($('.cat'+productId).text().trim());
        $('#data-desc').val($('.productDetalis'+productId).text().trim());

        // Populate Alt Texts
        $('#data-alt1').val($('.alt1'+productId).text().trim());
        $('#data-alt2').val($('.alt2'+productId).text().trim());
        $('#data-alt3').val($('.alt3'+productId).text().trim());
        $('#data-alt4').val($('.alt4'+productId).text().trim());
        $('#data-alt5').val($('.alt5'+productId).text().trim());
        $('#data-alt6').val($('.alt6'+productId).text().trim());

        // Populate Meta Data
        $('#data-meta_title').val($('.meta_title'+productId).text());
        $('#data-meta_description').val($('.meta_description'+productId).text());
        $('#data-meta_keywords').val($('.meta_keywords'+productId).text());

        // Populate Sizes
        $('#sizes-container').empty();
        let sizesJson = $('.sizes'+productId).text();
        if(sizesJson) {
            try {
                let sizes = JSON.parse(sizesJson);
                if(Array.isArray(sizes) && sizes.length > 0) {
                    sizes.forEach(function(s) {
                        addSizeRow(s.size, s.stock);
                    });
                }
            } catch(e) {
                console.error("Error parsing sizes JSON", e);
            }
        }

        // Populate Colors
        $('#colors-container').empty();
        let colorsJson = $('.colors'+productId).text();
        if(colorsJson) {
            try {
                let colors = JSON.parse(colorsJson);
                if(Array.isArray(colors) && colors.length > 0) {
                    colors.forEach(function(c) {
                        addColorRow(c.color, c.color_code, c.stock);
                    });
                }
            } catch(e) {
                console.error("Error parsing colors JSON", e);
            }
        }

        $(".add-new-data").addClass("show");
        $(".overlay-bg").addClass("show");





        // تغيير action
            $('#productForm').attr(
            'action',
            "{{ route('edit_product', ':id') }}".replace(':id', productId)
            );

        // وضع id المنتج
        $('#product_id').val(productId);

        // تغيير العنوان
        $('.new-data-title h4').text('تعديل منتج');

        // تغيير زر التأكيد
        $('.add-data-btn button').text('تعديل');

        // إظهار الفورم لو مخفي
        $('.add-new-data-sidebar').addClass('show');

        // Reset inputs if needed or handled by generic reset
    });

    // Reset form when sidebar is closed or new added (if click 'add new' not edit)
    // There is no explicit 'add new' button ID in the provided code, usually it's .add-new-data-btn in the template
    // But we need to clear sizes when opening form for new product (if that logic exists)
    
    // Assuming there is a trigger to open sidebar for ADD.  If logic is handled by template JS, we might need to hook into it.
    // Use .dt-buttons .add-new-data (class typically used in this template)
    $('.dt-buttons .add-new-data').on('click', function() {
         $('#sizes-container').empty();
         $('.new-data-title h4').text('اضافه منتج');
         $('.add-data-btn button').text('تاكيد');
         $('#productForm').attr('action', "{{ Route('add_product') }}");
         $('#product_id').val('');
    });
    // Fallback: observe if .add-new-data-sidebar gets class 'show' and title is 'اضافه منتج' ? 
    // Easier: Just clear sizes when the form is submitted or cancelled? 
    // The template likely clears inputs. We just need to ensure generic inputs are cleared.
    // Let's add a clear on the 'close' icon.
    $('.hide-data-sidebar, .cancel-data-btn').on('click', function() {
        $('#sizes-container').empty();
        $('#colors-container').empty();
    });

    // Color Management
    function addColorRow(color = '', code = '#000000', stock = '') {
        let row = `
            <div class="row color-row mb-1">
                <div class="col-4">
                    <input type="text" name="colors[]" class="form-control form-control-sm" placeholder="اللون" value="${color}">
                </div>
                <div class="col-2">
                    <input type="color" name="colors_code[]" class="form-control form-control-sm p-0" value="${code}" style="height: 30px;">
                </div>
                <div class="col-4">
                    <input type="number" name="colors_stock[]" class="form-control form-control-sm" placeholder="الكمية" value="${stock}">
                </div>
                <div class="col-2">
                    <button type="button" class="btn btn-danger btn-sm remove-color text-white">x</button>
                </div>
            </div>
        `;
        $('#colors-container').append(row);
    }

    $('#add-color-btn').on('click', function() {
        addColorRow();
    });

    $(document).on('click', '.remove-color', function() {
        $(this).closest('.color-row').remove();
    });
});

$(document).on('click', '.toggle-status', function(e) {
    e.preventDefault();
    e.stopPropagation();
    var chip = $(this);
    var productId = chip.data('id');
    var chipText = chip.find('.chip-text');

    $.ajax({
        url: "{{ route('product.toggle_status', ':id') }}".replace(':id', productId),
        method: 'POST',
        data: {
            _token: "{{ csrf_token() }}"
        },
        success: function(response) {
            if (response.success) {
                // Remove old classes
                chip.removeClass('chip-success chip-warning chip-danger');

                // Apply new class and text based on logic
                if (response.append == 0) {
                    chip.addClass('chip-warning');
                    chipText.text('متوقف');
                } else if (response.stock < 5) {
                    chip.addClass('chip-danger');
                    chipText.text('المخزون اقل من 5');
                } else {
                    chip.addClass('chip-success');
                    chipText.text('نشط');
                }
                
                // Show toast notification
                if (response.append == 0) {
                     toastr.warning(response.message, 'تنبيه');
                } else {
                     toastr.success(response.message, 'تمت العملية');
                }
            }
        },
        error: function(xhr) {
            console.error(xhr.responseText);
            toastr.error('حدث خطأ أثناء تحديث الحالة', 'خطأ');
        }
    });
});


// Bulk Delete - Handle checkbox change events
$(document).ready(function() {
    "use strict"



    // Bulk Delete Confirmation
    $('#checkForm').on('submit', function(e) {
        e.preventDefault(); // Prevent default submission
        
        let form = $(this);
        let box = $('#hiddenBox');
        box.empty(); // Clear previous values

        // Collect all checked checkboxes (current page)
        // Note: For multi-page selection with server-side processing or specific DataTables logic, 
        // one might need to access the DataTable API. For client-side DOM:
        $('.dt-checkboxes:checked').each(function () {
            let id = $(this).closest('tr').data('row_id'); 
            if (id) {
                box.append(`<input type="hidden" name="ids[]" value="${id}">`);
            }
        });

        // Check if we have any inputs in the box
        let selectedCount = box.find('input').length;
        
        if (selectedCount === 0) {
            swal("تنبيه", "الرجاء اختيار منتج واحد على الأقل للحذف", "warning");
            return false;
        }
        
        swal({
            title: "هل أنت متأكد من الحذف؟",
            text: `سيتم حذف ${selectedCount} منتج/منتجات`,
            icon: "warning",
            buttons: {
                cancel: {
                    text: "إلغاء",
                    value: null,
                    visible: true,
                    className: "btn-success",
                    closeModal: true,
                },
                confirm: {
                    text: "تأكيد الحذف",
                    value: true,
                    visible: true,
                    className: "btn-danger",
                    closeModal: true
                }
            },
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                form.off('submit').submit(); // Remove handler and submit
            }
        });
    });
});


</script>





@endsection
