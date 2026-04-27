@forelse ($notifications as $order)
    <a class="d-flex justify-content-between" href="{{ route('Orders') }}">
        <div class="media d-flex align-items-start">
            <div class="media-left"><i class="feather icon-shopping-cart font-medium-5 primary"></i></div>
            <div class="media-body">
                <h6 class="primary media-heading">طلب جديد #{{ $order->order_number }}</h6>
                <small class="notification-text"> القيمة: {{ $order->total }} ج.م</small>
            </div><small>
                <time class="media-meta" datetime="{{ $order->created_at }}">{{ $order->created_at->diffForHumans() }}</time></small>
        </div>
    </a>
@empty
    <div class="p-2 text-center">لا توجد إشعارات جديدة</div>
@endforelse
