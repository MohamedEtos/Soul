<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BlockBots
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userAgent = strtolower($request->header('User-Agent'));

        // 1. If User-Agent is empty, block it (harsh but safe for web browsers)
        if (empty($userAgent)) {
            // return response()->json(['message' => 'Bot Detected'], 403);
            abort(403, 'Access Denied');
        }

        // 2. Define Whitelist (Search Engines & Social Media)
        $whitelist = [
            'google',       // Googlebot, Google-Site-Verification
            'bing',         // Bingbot
            'yahoo',        // Slurp
            'duckduckgo',   // DuckDuckBot
            'baidu',        // Baiduspider
            'yandex',       // YandexBot
            'facebook',     // FacebookExternalHit
            'twitter',      // Twitterbot
            'whatsapp',     // WhatsApp
            'linkedin',     // LinkedInBot
            'instagram',    // Instagram
            'telegram',     // TelegramBot
            'pinterest',    // Pinterest
            'discord',      // Discordbot
            'tiktok',       // TikTok
        ];

        // 3. Define Blacklist Keywords (Generic bot terms)
        $botKeywords = [
            'bot',
            'crawl',
            'spider',
            'scrape',
            'headless',
            'python',
            'curl',
            'wget',
            'libwww',
            'httpclient',
            'axios',
            'node-fetch',
        ];

        // 4. Check if it's a known search engine/social bot first
        foreach ($whitelist as $allowed) {
            if (str_contains($userAgent, $allowed)) {
                return $next($request); // Allowed
            }
        }

        // 5. If not allowed, check if it's a generic bot
        foreach ($botKeywords as $keyword) {
            if (str_contains($userAgent, $keyword)) {
                 abort(403, 'Bot Detected');
            }
        }

        return $next($request);
    }
}
