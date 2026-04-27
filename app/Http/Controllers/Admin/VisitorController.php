<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Visit;
use App\Models\VisitorActivity;


class VisitorController extends Controller
{
     public function index(Request $request)
    {
    $visitorsList = Visit::orderBy('id', 'desc')->get();
        return view('admin.visitors.visitorsList',[
            'visitorsList'=>$visitorsList,
        ]);
    }

    public function activities(Request $request)
    {
        $activitiesList = VisitorActivity::orderBy('id', 'desc')->get();
        return view('admin.visitors.activitiesList', [
            'activitiesList' => $activitiesList,
        ]);
    }

    public function storeActivity(Request $request)
    {
        $request->validate([
            'url' => 'required|string',
            'duration_seconds' => 'required|integer|min:0',
            'page_title' => 'nullable|string|max:255',
        ]);

        $sessionId = $request->session()->getId();
        $ip = $request->ip();

        // Get device info
        $agent = $request->userAgent();
        $deviceType = $this->deviceType($agent);
        $browser = $this->browser($agent);
        $platform = $this->platform($agent);

        // Geo Location
        $country = null;
        $city = null;

        try {
            $response = \Illuminate\Support\Facades\Http::get("http://ip-api.com/json/{$ip}");
            if ($response->successful()) {
                $data = $response->json();
                if ($data['status'] === 'success') {
                    $country = $data['country'] ?? null;
                    $city = $data['city'] ?? null;
                }
            }
        } catch (\Exception $e) {
            // Log error or ignore
        }

        VisitorActivity::create([
            'ip_address' => $ip,
            'session_id' => $sessionId,
            'url' => $request->url,
            'page_title' => $request->page_title,
            'referrer' => $request->filled('fbclid') ? 'facebook.com' : $request->headers->get('referer'),
            'duration_seconds' => $request->duration_seconds,
            'started_at' => $request->started_at ? now()->subSeconds($request->duration_seconds) : now()->subSeconds($request->duration_seconds),
            'ended_at' => now(),
            'device_type' => $deviceType,
            'browser' => $browser,
            'platform' => $platform,
            'country' => $country,
            'city' => $city,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم تسجيل النشاط بنجاح'
        ]);
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
