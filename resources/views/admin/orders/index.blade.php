@extends('admin.layout.master')
@section('css')

    <link rel="apple-touch-icon" href="{{ asset('admin/images/ico/apple-icon-120.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('admin/images/ico/favicon.ico') }}">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('admin/vendors/css/file-uploaders/dropzone.min.css') }}"> --}}
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
                                    <form id="checkForm" action="{{ route('multideleteOrders') }}" method="post">
                                        @csrf
                                    <button type="submit" form="checkForm" id="checkbox_send" class="dropdown-item danger" href="#"><i class="feather icon-trash "></i>Delete</button>
                                    <div id="hiddenBox"></div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- dataTable starts -->

                    <div class="table-responsive" >
                        <table class="table data-thumb-view">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>id</th>
                                    <th>ip المستخدم</th>
                                    <th>رقم التلفون </th>
                                    <th> رقم الطلب</th>
                                    <th>اسم المنتج</th>
                                    <th>المشرتيات</th>
                                    <th>الشحن</th>
                                    <th>الاجمالي</th>
                                    <th>المحافظه</th>
                                    <th>التاريخ</th>
                                    <th>اجراء</th>
                                </tr>
                            </thead>
                            <tbody>


                            @foreach ($Orderlist as $Order)
                                <tr class="trRow"  data-id_row="{{ $Order->id }}" data-toggle="modal" data-target="#xlarge">
                                    <td data-id_check="{{ $Order->id }}" class="stopevent"></td>
                                        <input type="hidden"  class="full_name" value="{{ $Order->address->full_name ?? 'No Data' }}">
                                        <input type="hidden"  class="phone_modeal" value="{{ $Order->address->phone  ?? 'No Data'}}">
                                        <input type="hidden"  class="area_modal" value="{{ $Order->address->area  ?? 'No Data'}}">
                                        <input type="hidden"  class="floor_number_modal" value="{{ $Order->address->floor_number ?? 'No Data'}}">
                                        <input type="hidden"  class="building_modal" value="{{ $Order->address->building ?? 'No Data' }}">
                                        <input type="hidden"  class="address_modal" value="{{ $Order->address->address  ?? 'No Data'}}">
                                        <input type="hidden" class="status_modal" value="{{ $Order->payment_status == 'notaccepted' ? 'غير مؤكد' : 'تم ارسال رساله التاكيد' }}">
                                        @php
                                            $firstItem = $Order->items->first();
                                            $imagePath = $firstItem && $firstItem->product && $firstItem->product->product_img_p 
                                                ? asset($firstItem->product->product_img_p->mainImage) 
                                                : asset('store/images/product-13.avif');
                                        @endphp
                                        <input type="hidden" class="product_image" value="{{ $imagePath }}">
                                    
                                    

                                    <td class="product-name name">{{$Order->id  ?? 'No Data' }}</td>
                                    <td class="product-name name">{{$Order->user_ip ?? 'No Data'}}</td>

                                    <td class="product-category productDetalis">
                                         <form id="whatsapp-{{ $Order->id }}" action="{{ route('Send_whatsapp') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $Order->id }}">
                                         </form>

@php
$whatsappUrl = "https://wa.me/2" . ($Order->address->phone ?? 'No Data') . "?text=" . urlencode(
"مرحبا
{$Order->address->full_name}

شكرا لطلبك من LunaBlu|لونا بلوe
رقم طلبك هو: {$Order->order_number}

العنوان : {$Order->address->address} .  {$Order->address->area} . {$Order->address->governorate}

طلبك هو:
" .
collect($Order->items)->map(function($item, $i){
    return ($i+1) . " - " . $item->product->name .
        " ( {$item->quantity} × {$item->price} ) = " .
        ($item->quantity * $item->price) . " ج.م";
})->implode("\n") . "

--------------------
اجمالي الطلب: {$Order->total} ج.م
"
);
@endphp

@if($Order->payment_status == 'notaccepted')
    <button type="button" class="btn btn-success" onclick="sendWhatsAppAndUpdate('{{ $Order->id }}', '{{ $whatsappUrl }}')">إرسال رسالة التأكيد</button>
@else
    <button type="button" class="btn btn-success" onclick="sendWhatsAppAndUpdate('{{ $Order->id }}', '{{ $whatsappUrl }}')">إعادة الإرسال</button>
@endif
                                    </td>



                                        </td>
                                    <td class="product-category order_number"> {{ $Order->order_number }} </td>

                                    <td class="product-category product_name">
                                            @foreach ( $Order->items as $item )
                                                  {{ $loop->iteration }} - {{ $item->product->name }}  ( {{ $item->quantity }} * {{ $item->price }} ) = {{ $item->quantity * $item->price }} ج.م
                                            <br class="mt-1">

                                        @endforeach
                                    </td>
                                    <td class="product-category subtotal"> {{ $Order->subtotal }} ج.م </td>
                                    <td class="product-category shipping_cost"> {{ $Order->shipping_cost }} </td>
                                    <td class="product-category total_modal"> {{ $Order->total }} </td>
                                    <td class="product-category governorate"> {{ $Order->address->governorate }} </td>
                                    <td class="product-category created_at"> {{ $Order->created_at->diffForHumans() }} </td>

                                    <td class="product-action">
                                    {{-- <span class="action-edit" data-id="{{ $Order->id }}">
                                        <i class="feather icon-edit"></i>
                                    </span> --}}
                                    <span class='del text-danger' data-toggle="modal" data-id_del="{{ $Order->id }}" data-target="#danger">
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
                <form action='{{ Route('StoreOrder')}}'  method='POST' enctype="multipart/form-data">
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
                                        <!-- ===== Template مخفي للـ options من الداتا بيز ===== -->
                                        <select id="productOptionsTemplate" class="d-none">
                                            <option selected disabled value="">اختر المنتج</option>
                                            @foreach ($ProductList as $product)
                                                <option value="{{ $product->id }}">
                                                    {{ $product->name . " - " . $product->slug }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <!-- ===== أول صف في الفاتورة ===== -->
                                        <div class="invoice-item border rounded p-2 mt-2">

                                            <div class="col-sm-12 data-field-col">
                                                <label>الاسم</label>
                                                <select name="items[0][product_id]" class="form-control item-product">
                                                    <option selected disabled value="">اختر المنتج</option>
                                                    @foreach ($ProductList as $product)
                                                        <option value="{{ $product->id }}">
                                                            {{ $product->name . " - " . $product->slug }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-sm-12 data-field-col">
                                                <label>السعر</label>
                                                <input required type="number" name="items[0][price]" class="form-control item-price" value="0" min="0" step="0.01">
                                            </div>

                                            <div class="col-sm-12 data-field-col">
                                                <label>الكميه</label>
                                                <input required type="number" name="items[0][qty]" class="form-control item-qty" value="1" min="0" step="1">
                                            </div>

                                            <!-- في أول صف مش لازم زر حذف -->
                                        </div>

                                        <!-- زر إضافة منتج -->
                                        <div class="col-sm-12 data-field-col mt-2">
                                            <button type="button" id="addItemBtn" class="btn btn-outline-primary w-100">
                                                + إضافة منتج
                                            </button>
                                        </div>

                                        <!-- هنا هتتضاف الصفوف الجديدة -->
                                        <div id="itemsContainer"></div>

                                        <div class="border-top mb-2 pt-2 col-sm-12 data-field-col"></div>

                                        <div class="col-sm-12 data-field-col">
                                            <label for="shipping__coast">تكلفة الشحن</label>
                                        <select name="shipping__coast" id="shipping_coast" class="form-control">
                                            @foreach ($Shaping_CoastList as $Shaping_Coast)
                                                <option
                                                    value="{{ $Shaping_Coast->id }}"
                                                    data-cost="{{ $Shaping_Coast->shipping_cost }}"
                                                >
                                                    {{ $Shaping_Coast->name_ar . " - " . $Shaping_Coast->shipping_cost }}
                                                </option>
                                            @endforeach

                                            {{-- <option value="0" data-cost="0">شحن مجاني</option> --}}
                                        </select>
                                        </div>

                                        <!-- خصم على الفاتورة -->
                                        <div class="col-sm-12 data-field-col">
                                            <label for="descount">خصم علي الفاتوره</label>
                                            <input required type="number" name="descount" class="form-control" id="descount" value="0" min="0" step="0.01">
                                        </div>

                                        <!-- الإجمالي -->
                                        <div class="col-sm-12 data-field-col">
                                            <label for="total">الاجمالي</label>
                                            <input required type="number" name="total" class="form-control" id="total" value="0" readonly>
                                        </div>

                                        <!-- (اختياري) الإجمالي قبل الخصم للعرض -->
                                        <div class="col-sm-12 data-field-col mt-2">
                                            <small class="">الإجمالي قبل الخصم: <span id="subtotalView">0.00</span></small>
                                        </div>

                                        <div class="border-top mb-1 pt-1 col-sm-12 data-field-col"></div>

                                        <div class="col-sm-12 data-field-col">
                                            <label for="customer">اسم العميل</label>
                                            <input required type="text" name='customer'class="form-control" id="customer">
                                        </div>
                                        <div class="col-sm-12 data-field-col">
                                            <label for="phone">رقم التلفون</label>
                                            <input required type="number" name='phone'class="form-control" id="phone_modeal">
                                        </div>

                                        <div class="col-sm-12 data-field-col">
                                            <label for="area">المنطقه</label>
                                            <input required type="text" name='area'class="form-control" id="area">
                                        </div>

                                        <div class="col-sm-12 data-field-col">
                                            <label for="address">العنوان</label>
                                            <input required type="text" name='address'class="form-control" id="address">
                                        </div>

                                        <div class="col-sm-12 data-field-col">
                                            <label for="bilding">رقم المبني</label>
                                            <input required type="text" name='bilding'class="form-control" id="bilding">
                                        </div>

                                        <div class="col-sm-12 data-field-col">
                                            <label for="floor_number">الدور  </label>
                                            <input required type="text" name='floor_number'class="form-control" id="floor_number">
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
                <input name="productId" id="prod_id" type="hidden" value="">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-danger white">
                            <h5 class="modal-title" id="myModalLabel120">تاكيد الحذف</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            هل انت متاكد من حذف المنتج !
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" data-dismiss="modal">الغاء</button>
                            <input  type="submit" value='تاكيد' class="btn btn-outline-danger" >
                        </div>
                    </div>
                </div>
            </form>



            <div class="modal-size-xl mr-1 mb-1 d-inline-block">
                <!-- Button trigger modal -->


                <!-- Modal -->
                <div class="modal fade text-left" id="xlarge" tabindex="-1" role="dialog" aria-labelledby="myModalLabel16" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel16">تفاصيل الطلب</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                    <div class="row">
                                        <div class="col-1" >
                                            <img id="modal_product_image" class=" mt-1 w-100 " src="{{ asset('store/images/product-13.avif') }}" alt="">
                                        </div>
                                        <div class="col-5">
                                            <div> #:<span id="order_number"></span></div>
                                            <div>اسم العميل:<span id="full_name"></span></div>
                                            <div>رقم التلفون:<span id="phone_modeal"></span></div>
                                            <div> المحافظه:<span id="governorate"></span></div>
                                            <div> المنطقه:<span id="area_modal"></span></div>
                                            <div> العنوان:<span id="address_modal"></span></div>
                                            <div> عقار:<span id="building_modal"></span></div>
                                            <div> الدور:<span id="floor_number_modal"></span></div>
                                        </div>
                                        <div class="col-5">
                                            <div> المنتج:

                                                <div><span id="product_name"></span></div>

                                            </div>
                                            <div> قيمه الطلب:<span id="subtotal" class="fw-bold"></span></div>
                                            <div>  الشحن:<span id="shipping_cost"></span></div>
                                            <div class="border-top mb-1 pt-1 h6">  المجموع:<b id="total_modal"></b></div>

                                        </div>
                                    </div>
                                    <div class="row mt-1">
                                        <div class="col-4">
                                            ملاحظات:<span id="note"></span>
                                        </div>
                                        <div class="col-4">
                                            تاريخ الطلب:<span id="created_at" class="text-info"></span>
                                        </div>
                                        <div class="col-4">
                                             الحاله:<span id="status" class="">تم ارسال رساله التاكيد</span>
                                        </div>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Accept</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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

    <script src="{{ asset('admin/js/orders/orders.js') }}"></script>
    <script src="{{ asset('admin/js/orders/GetProductInfo.js') }}"></script>

<script>







$(document).ready(function() {
  "use strict"

    $(document).on('change', '.dt-checkboxes', function (e) {
        e.stopPropagation();

        let box = $('#hiddenBox');
        box.empty(); // مهم جدًا

        // جمع الـ selected مرة واحدة
        $('.dt-checkboxes:checked').each(function () {
            let id = $(this).closest('tr').data('id_row'); // أو $(this).val()
            box.append(`<input type="hidden" name="ids[]" value="${id}">`);
        });

    });

    // عشان الموديل ميفتح لما اعمل شيك
    $(document).on('click', '.stopevent', function (e) {
    e.stopPropagation();

    });





    $('.del').on("click",function(){


        let productId = $(this).data('id_del');
        // on del
        $('#danger').attr(
            'action',
            "{{ route('destroyOrder', ':id') }}".replace(':id', productId)
        );
        $('#prod_id').val(productId);

    });

    // $('.trRow').on("click",function(){
    //     let id_send = $(this).data('id_send');
    //     $('#danger').attr(
    //         'action',
    //         "{{ route('destroy', ':id') }}".replace(':id', productId)
    //     );
    //     $('#prod_id').val(productId);


    // });





      // On Edit
    $('.action-edit').on("click",function(e){
        e.stopPropagation()
        let productId = $(this).data('row_id');


        $('#data-name').val($('.name'+productId).text());
        $('#data-price').val($('.price'+productId).text());
        $('#data-stock').val($('.stock'+productId).text());
        $('#data-desc').val($('.desc'+productId).text());
        $('#data-fabric_type').val($('.fabric_type'+productId).text());
        $('#data-cat').val($('.cat'+productId).text());
        $('#data-desc').val($('.productDetalis'+productId).text());
        $(".add-new-data").addClass("show");
        $(".overlay-bg").addClass("show");





        // تغيير action
            // $('#productForm').attr(
            // 'action',
            // "{{ route('edit_product', ':id') }}".replace(':id', productId)
            // );

        // وضع id المنتج
        $('#product_id').val(productId);

        // تغيير العنوان
        $('.new-data-title h4').text('تعديل منتج');

        // تغيير زر التأكيد
        $('.add-data-btn button').text('تعديل');

        // إظهار الفورم لو مخفي
        $('.add-new-data-sidebar').addClass('show');

        $('input[name="name"]').val();

    });

});

// Function to send WhatsApp and update order status
function sendWhatsAppAndUpdate(orderId, whatsappUrl) {
    // Get the form
    const form = document.getElementById('whatsapp-' + orderId);
    const formData = new FormData(form);

    // Open WhatsApp immediately
    window.open(whatsappUrl, '_blank');

    // Send AJAX request to update order status
    fetch("{{ route('Send_whatsapp') }}", {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        // Check if response is JSON
        const contentType = response.headers.get("content-type");
        if (contentType && contentType.includes("application/json")) {
            return response.json();
        } else {
            // If redirect or HTML, just resolve
            return { success: true };
        }
    })
    .then(data => {
        // Reload the page to show updated status after a short delay
        setTimeout(() => {
            window.location.reload();
        }, 500);
    })
    .catch(error => {
        console.error('Error:', error);
        // Still reload to ensure status is updated
        setTimeout(() => {
            window.location.reload();
        }, 500);
    });
}

</script>





@endsection
