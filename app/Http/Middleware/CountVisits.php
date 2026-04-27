<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Visit;
use Illuminate\Support\Facades\Http;

class CountVisits
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // 1️⃣ تجاهل أي request مالوش route
        if (!$request->route()) {
            return $response;
        }

        // 2️⃣ تجاهل الملفات الثابتة
        if ($this->isStaticFile($request)) {
            return $response;
        }

        // 2.5️⃣ تجاهل admin routes
        if ($request->is('admin/*') || $request->is('admin')) {
            return $response;
        }

        $ip    = $request->ip();
        $agent = $request->userAgent();

        // 3️⃣ تجاهل localhost
        if (in_array($ip, ['127.0.0.1', '::1'])) {
            return $response;
        }

        // 4️⃣ تجاهل البوتس
        if ($this->isBot($agent)) {
            return $response;
        }

        // 5️⃣ تجاهل IPs الداتا سنتر
        if ($this->isDataCenterIp($ip)) {
            return $response;
        }

        // 6️⃣ Get session ID first
        $sessionId = $request->session()->getId();

        // 🛡️ الحماية الجديدة: التحقق من وجود الكوكيز فعليًا في الهيدر
        // البوتات غالبًا بتبعت ريكويست من غير كوكيز حتى لو السيرفر عمل Set-Cookie
        if (!$request->hasCookie(config('session.cookie'))) {
            return $response;
        }
        
        // تجاهل زيارة اذا الـ user ماعندوش session حقيقية (الكوكيز غير مفعلة غالباً، أو زائر سريع)
        if (!$sessionId || strlen($sessionId) < 8) {
            // احتمال كبير انه بوت أو زائر وهمي، تجاهل الزيارة
            return $response;
        }

        // 🛡️ الحماية الجديدة: المتصفحات الحقيقية دايما بتبعت Accept-Language
        if (!$request->header('Accept-Language')) {
             return $response;
        }

        // 7️⃣ زيارة واحدة فقط لكل IP + session في اليوم (تعزيز الدقة)
        $alreadyVisited = Visit::where('ip_address', $ip)
            ->where('session_id', $sessionId)
            ->whereDate('created_at', today())
            ->exists();

        if ($alreadyVisited) {
            return $response;
        }

        // ======================
        // 🌍 Geo Location
        // ======================
        $country = null;
        $city    = null;

        // فلترة اي IPs محمية/داخلية/private (مثل 10.* أو 192.168.* أو 172.16-31.*)
        if ($this->isPrivateIp($ip)) {
            return $response;
        }

        try {
            $res = Http::timeout(2)
                ->acceptJson()
                ->get("http://ip-api.com/json/{$ip}");

            if (method_exists($res, 'successful') && $res->successful()) {
                $data = method_exists($res, 'json') ? $res->json() : [];
                $country = $data['country'] ?? null;
                $city    = $data['city'] ?? null;
            }
        } catch (\Exception $e) {
            // تجاهل الخطأ
        }

     
        Visit::create([
            'ip_address'  => $ip,
            'user_agent'  => $agent,
            'url'         => $request->fullUrl(),
            'session_id'  => $sessionId,
            'referrer'    => $request->has('fbclid') ? 'facebook.com' : $request->headers->get('referer'),
            'device_type' => $this->deviceType($agent),
            'browser'     => $this->browser($agent),
            'platform'    => $this->platform($agent),
            'country'     => $country,
            'city'        => $city,
            'created_at'  => now(),
        ]);

        return $response;
    }

    // ======================
    // Helpers
    // ======================

    private function isStaticFile(Request $request): bool
    {
        $ext = pathinfo($request->path(), PATHINFO_EXTENSION);

        return in_array($ext, [
            'css','js','png','jpg','jpeg','gif','svg','ico',
            'woff','woff2','ttf','eot','map'
        ]);
    }

    private function isBot(?string $agent): bool
    {
        if (!$agent) return true;

        // Reject short user agents
        if (strlen($agent) < 20) {
            return true;
        }

        $bots = [
            'bot','crawl','spider','slurp',
            'google','bing','yandex','baidu',
            'facebook','telegram','whatsapp',
            'discord','axios','curl','wget',
            'python','http-client','guzzle','libwww',
            'scrappy','headless','selenium','phantom',
            'puppet','mediapartners','ahrefs','semrush',
            'mj12bot','dotbot','exabot','ia_archiver'
        ];

        $agent = strtolower($agent);

        foreach ($bots as $bot) {
            if (str_contains($agent, $bot)) {
                return true;
            }
        }

        return false;
    }

    private function isDataCenterIp(string $ip): bool
    {
        return str_starts_with($ip, '3.')
            || str_starts_with($ip, '18.')
            || str_starts_with($ip, '35.')
            || str_starts_with($ip, '52.')
            || str_starts_with($ip, '2600:')
            || str_starts_with($ip, '2a03:');
    }

    // فلترة أي IP من النوع private/internal
    private function isPrivateIp(string $ip): bool
    {
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            // IPv4 رينجات الـ
            if (
                str_starts_with($ip, '10.') ||
                str_starts_with($ip, '192.168.') ||
                preg_match('/^172\.(1[6-9]|2[0-9]|3[0-1])\./', $ip)
            ) {
                return true;
            }
        }
        if ($ip === '::1' || str_starts_with($ip, 'fd') || str_starts_with($ip, 'fe80:')) {
            return true; // IPv6 لوكال أو يونيكاست
        }
        return false;
    }

    private function deviceType(string $agent): string
    {
        return preg_match('/mobile|android|iphone|ipad/i', $agent)
            ? 'mobile'
            : 'desktop';
    }

    private function browser(string $agent): string
    {
        return match (true) {
            str_contains($agent, 'Chrome')  => 'Chrome',
            str_contains($agent, 'Firefox') => 'Firefox',
            str_contains($agent, 'Safari') && !str_contains($agent, 'Chrome') => 'Safari',
            str_contains($agent, 'Edge')    => 'Edge',
            default => 'Other',
        };
    }

    private function platform(string $agent): string
    {
        return match (true) {
            str_contains($agent, 'Windows') => 'Windows',
            str_contains($agent, 'Android') => 'Android',
            str_contains($agent, 'iPhone'),
            str_contains($agent, 'iPad')    => 'iOS',
            str_contains($agent, 'Mac')     => 'MacOS',
            default => 'Other',
        };
    }
}
