<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Visit;
use App\Models\Product;
use App\Models\Orders;
use Carbon\Carbon;
use DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {


    $vistorsChart = collect(range(6, 0))->map(function ($i) {
        return Visit::whereDate(
            'created_at',
            Carbon::today()->subDays($i)
        )->count();
    })->values();

    $vistorsHoursChart = collect(range(5, 0))->map(function ($i) {
        $start = Carbon::now()->subHours($i + 1);
        $end   = Carbon::now()->subHours($i);

        return Visit::whereBetween('created_at', [$start, $end])->count();
    })->values();



    $ordersChart = collect(range(6, 0))->map(function ($i) {
        return Orders::whereDate(
            'created_at',
            Carbon::today()->subDays($i)
        )->count();
    })->values();

    $ProductChart = collect(range(6, 0))->map(function ($i) {
        return product::whereDate(
            'created_at',
            Carbon::today()->subDays($i)
        )->count();
    })->values();

    // ////////////////////مبيعات الاشهر السابقة والحالية


        function sumSalesBetween(Order $model, Carbon $start, Carbon $endExclusive): float
        {
            return (float) Order::where('status', 'completed') // عدّل حسب نظامك
                ->whereBetween('created_at', [$start, $endExclusive->copy()->subSecond()]) // inclusive workaround
                ->sum('total'); // عدّل اسم العمود
        }

        $now = Carbon::now();

        $ranges = [
            [1, 5],
            [5, 9],
            [9, 13],
            [13, 17],
            [17, 21],
            [21, 26],
            [26, 31],
        ];

        // -------- This Month --------
        $thisStart = $now->copy()->startOfMonth();
        $thisEndMonthDay = $now->copy()->endOfMonth()->day;

        $thisMonthSeries = collect($ranges)->map(function ($r) use ($thisStart, $thisEndMonthDay) {
            [$fromDay, $toDay] = $r;

            // clamp لنهاية الشهر لو الشهر 30/28
            $fromDay = min($fromDay, $thisEndMonthDay);
            $toDay   = min($toDay, $thisEndMonthDay + 1); // +1 عشان endExclusive

            $start = $thisStart->copy()->day($fromDay)->startOfDay();
            $endExclusive = $thisStart->copy()->day(min($toDay, $thisEndMonthDay + 1))->startOfDay();

            // لو start >= end (مثلاً الشهر 28 يوم والبكت خارج الشهر) رجّع 0
            if ($start->gte($endExclusive)) return 0;

            return (float) Orders::where('payment_status', 'accepted')
                ->where('created_at', '>=', $start)
                ->where('created_at', '<', $endExclusive) // endExclusive صح
                ->sum('total');
        })->values();

        // -------- Last Month --------
        $lastStart = $now->copy()->subMonthNoOverflow()->startOfMonth();
        $lastEndMonthDay = $now->copy()->subMonthNoOverflow()->endOfMonth()->day;

        $lastMonthSeries = collect($ranges)->map(function ($r) use ($lastStart, $lastEndMonthDay) {
            [$fromDay, $toDay] = $r;

            $fromDay = min($fromDay, $lastEndMonthDay);
            $toDay   = min($toDay, $lastEndMonthDay + 1);

            $start = $lastStart->copy()->day($fromDay)->startOfDay();
            $endExclusive = $lastStart->copy()->day(min($toDay, $lastEndMonthDay + 1))->startOfDay();

            if ($start->gte($endExclusive)) return 0;

            return (float) Orders::where('payment_status', 'accepted')
                ->where('created_at', '>=', $start)
                ->where('created_at', '<', $endExclusive)
                ->sum('total');
        })->values();


        // Totals فوق (الشهر الحالي/السابق)
        $thisMonthTotal = (float) Orders::where('payment_status', 'accepted')
            ->where('created_at', '>=', $thisStart->copy()->startOfDay())
            ->where('created_at', '<=', $now->copy()->endOfDay())
            ->sum('total');

        $lastMonthTotal = (float) Orders::where('payment_status', 'accepted')
            ->whereBetween('created_at', [$lastStart->copy()->startOfDay(), $lastStart->copy()->endOfMonth()->endOfDay()])
            ->sum('total');



    // ////////////////////مبيعات الاشهر السابقة والحالية نهايه

    // العملاء الجدد والمستمرين

        $months = collect(range(11, 0))->map(fn($i) => Carbon::now()->subMonths($i)->startOfMonth());

    $labels = $months->map(fn($m) => $m->format('M'))->values();

    $newClients = $months->map(function ($m) {
        $start = $m->copy()->startOfMonth();
        $end   = $m->copy()->endOfMonth();

        // IP أول ظهور له داخل نفس الشهر = جديد
        return DB::table('visits')
            ->select('ip_address', DB::raw('MIN(created_at) as first_seen'))
            ->groupBy('ip_address')
            ->havingBetween('first_seen', [$start, $end])
            ->count();
    })->values();

    $retainedClients = $months->map(function ($m) {
        $start = $m->copy()->startOfMonth();
        $end   = $m->copy()->endOfMonth();

        // ip_address زار الشهر ده + كان موجود قبل بداية الشهر = retained
        $visitedThisMonth = DB::table('visits')
            ->whereBetween('created_at', [$start, $end])
            ->distinct()
            ->pluck('ip_address');

        if ($visitedThisMonth->isEmpty()) return 0;

        return DB::table('visits')
            ->whereIn('ip_address', $visitedThisMonth)
            ->where('created_at', '<', $start)
            ->distinct('ip_address')
            ->count('ip_address');
    })->values();


    // اجهزه الزوار

        $from = now()->subDays(30);

        // إجمالي الزيارات آخر 7 أيام
        $total = DB::table('visits')
            ->where('created_at', '>=', $from)
            ->count();

        // توزيع الأجهزة
        $rows = DB::table('visits')
            ->select('device_type', DB::raw('COUNT(*) as cnt'))
            ->where('created_at', '>=', $from)
            ->groupBy('device_type')
            ->get();

        // قيم افتراضية (لو جهاز مش موجود يرجع 0)
        $percent = [
            'desktop' => 0.0,
            'mobile'  => 0.0,
            'tablet'  => 0.0,
        ];

        if ($total > 0) {
            foreach ($rows as $r) {
                $key = strtolower($r->device_type);
                if (array_key_exists($key, $percent)) {
                    $percent[$key] = round(($r->cnt / $total) * 100, 1);
                }
            }
        }

        // نفس ترتيب الشارت
        $DeviceSessionchart = [
            'series' => [
                $percent['desktop'],
                $percent['mobile'],
                $percent['tablet'],
            ],
            'labels' => ['Desktop', 'Mobile', 'Tablet'],

            // لو مش جاهزة للمقارنة سيبيها صفر أو احذفيها
            'comparedResult' => [0, 0, 0],

            // معلومات إضافية لو محتاجاها في الواجهة
            'total' => $total,
            'range' => 'Last 7 Days',
        ];


        // حساب الزوار من اي موقع قاديمن في الشارت

    $days = (int) ($request->get('days', 7));
    $top  = (int) ($request->get('top', 10)); // عدد المصادر اللي هنعرضها

    $from = now()->subDays($days)->startOfDay();
    $to   = now()->endOfDay();

    $yourDomain = 'unabl.store'; // <-- غيّره لدومينك

    // مهم: غيّر اسم العمود هنا حسب جدولك (referer/referrer)
    $rows = DB::table('visits')
        ->select('referrer', DB::raw('COUNT(*) as c'))
        ->whereBetween('created_at', [$from, $to])
        ->groupBy('referrer')
        ->get();

    $bucket = []; // label => count

    foreach ($rows as $r) {
        $ref = trim((string) $r->referrer);
        $count = (int) $r->c;

        $label = $this->sourceLabelFromRef($ref, $yourDomain);
        $bucket[$label] = ($bucket[$label] ?? 0) + $count;
    }

    // رتّب من الأكبر للأصغر
    arsort($bucket);

    // Top N + تجميع الباقي في Other
    $topItems = array_slice($bucket, 0, $top, true);
    $restSum  = array_sum(array_slice($bucket, $top));

    if ($restSum > 0) {
        $topItems['Other'] = ($topItems['Other'] ?? 0) + $restSum;
    }



        $count_vistors = Visit::distinct('ip_address')->count('ip_address');
        $today_vistors = Visit::whereDate('created_at', now())->distinct('ip_address')->count('ip_address');
        $product_count = Product::count();
        $orders_count = Orders::count();
        // Visit::where('url', 'products')->count();اذا كنت تريد حساب صفحه معينه



        return view('admin.index', [
            'count_vistors' => $count_vistors,
            'today_vistors' => $today_vistors,
            'product_count' => $product_count,
            'orders_count' => $orders_count,

            // charts
            'vistorsChart' => $vistorsChart,
            'ordersChart' => $ordersChart,
            'ProductChart' => $ProductChart,
            'vistorsHoursChart' => $vistorsHoursChart,

            'thisMonthSeries'=>$thisMonthSeries,
            'lastMonthSeries'=>$lastMonthSeries,
            'thisMonthTotal'=>$thisMonthTotal,
            'lastMonthTotal'=>$lastMonthTotal,

            'retainedClients'=>$retainedClients,
            'newClients'=>$newClients,
            'DeviceSessionchart'=>$DeviceSessionchart,
            'trafficSourcesLabels' => array_keys($topItems),
            'trafficSourcesSeries' => array_values($topItems),
            'trafficTotal' => array_sum($topItems),
            'trafficrange' => ['from' => $from->toDateTimeString(), 'to' => $to->toDateTimeString()],



        ]);

    }




    private function sourceLabelFromRef(string $ref, string $yourDomain): string
    {
        if ($ref === '' || $ref === '-' || strtolower($ref) === 'null') {
            return 'Direct';
        }

        $host = parse_url($ref, PHP_URL_HOST);
        if (!$host) return 'Direct';

        $host = strtolower($host);
        $host = preg_replace('/^www\./', '', $host);

        // Internal
        if (str_contains($host, $yourDomain)) {
            return 'Internal';
        }

        // Known platforms (زود براحتك)
        if (str_contains($host, 'google.')) return 'Google';
        if (str_contains($host, 'facebook.') || str_contains($host, 'fb.') || str_contains($host, 'fbcdn.')) return 'Facebook';
        if (str_contains($host, 'instagram.')) return 'Instagram';
        if (str_contains($host, 'tiktok.')) return 'TikTok';
        if (str_contains($host, 'youtube.')) return 'YouTube';
        if (str_contains($host, 'linkedin.')) return 'LinkedIn';
        if (str_contains($host, 'twitter.') || str_contains($host, 'x.com') || str_contains($host, 't.co')) return 'X (Twitter)';
        if (str_contains($host, 'bing.')) return 'Bing';
        if (str_contains($host, 'duckduckgo.')) return 'DuckDuckGo';
        if (str_contains($host, 'yahoo.')) return 'Yahoo';
        if (str_contains($host, 'telegram.')) return 'Telegram';
        if (str_contains($host, 'whatsapp.')) return 'WhatsApp';

        // fallback: الدومين نفسه (ده اللي “يزود عدد المواقع” فعليًا)
        return $host;
    }



}








