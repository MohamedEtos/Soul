@extends('store.layouts.master')
@section('head')
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"/>
<link rel="stylesheet" href="{{ asset('store/css/successOrder.css') }}"/>
@endsection

@section('content')

  <!-- Bootstrap 4 -->



<canvas id="glowFx"></canvas>
<canvas id="fx"></canvas>

<div class="wrap">
  <div class="cardx">
    <div class="d-flex align-items-start justify-content-between flex-wrap">
      <div>
        <h1 class="title">تم تأكيد طلبك 🎉</h1>
        {{-- <p class="subtitle">اضغط على صندوق الهدية… هتشوف شرايط وفرحة محترمة 😄</p> --}}
      </div>
      <div class="text-left">
        <h2 class="badge badge-pill badge-light" id="orderNo">{{$order->order_number}}</h2>
      </div>
    </div>

    <div class="scene">
      <div class="halo"></div>

      <div class="gift idle" id="gift" aria-label="Gift Box">
        <div class="lid">
          <div class="bowWrap">
            <div class="bow left"></div>
            <div class="bow right"></div>
            <div class="knot"></div>
          </div>
        </div>

        <div class="box">
          <div class="stripe-v"></div>
          <div class="stripe-h"></div>
        </div>
      </div>

      <div class="msg" id="msg">
        <div class="badge-successx">✅ <span>نجاح</span> • <span>Order Placed</span></div>
        <h3>الطلب اتسجل بنجاح!</h3>
        <p class="h4 mt-2">هنبدأ تجهيز الأوردر فورًا — شكراً ليك 💚</p>

        <p class="text-muted mt-3">
             سيتم تحويلك للصفحة الرئيسية خلال
        <span id="counter">5</span>
        ثواني
        </p>

      </div>
    </div>

    <div class="footer-actions">
      {{-- <button class="btn btn-success btnx" id="btnReplay">إعادة الأنيميشن</button> --}}
      <a  href="{{ route('product') }}" class="btn btn-outline-light w-75 btnx" id="btnGo">تابع التسوق</a>
      {{-- <button class="btn btn-outline-warning btnx" id="btnTrack">تتبع الطلب</button> --}}
    </div>

    {{-- <div class="hint">ملاحظة: الأنيميشن شغال Canvas بالكامل — سريع وخفيف</div> --}}
    {{-- <div class="small-note">Bootstrap 4 + Confetti + Streamers + Spark Trails (Vanilla JS)</div> --}}
  </div>
</div>






@endsection

@section('script')

<script src="{{ asset('store/js/successOrder.js') }}"></script>
<script>
    (function ($) {
    "use strict";
        var headerDesktop = $('.container-menu-desktop');
        $(headerDesktop).addClass('fix-menu-desktop');
    })(jQuery);

        /*==================================================================
    [ +/- num product ]*/
     $('.btn-num-product-down').on('click', function(){
         var numProduct = Number($(this).next().val());
         if(numProduct > 0) $(this).next().val(numProduct - 1);
     });

     $('.btn-num-product-up').on('click', function(){
         var numProduct = Number($(this).prev().val());
         $(this).prev().val(numProduct + 1);
     });



</script>




@endsection
