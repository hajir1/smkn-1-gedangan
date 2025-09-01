<?php

namespace App\Http\Middleware;

use App\Models\Article;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class ViewarticleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $slug = $request->route("slug");
        $article = Article::where("slug",$slug)->first();
       if ($article) {
            $ip = $request->ip(); // ambil IP user
            $date = now()->toDateString(); // format YYYY-MM-DD

            $cacheKey = "viewed_{$article->id}_{$ip}_{$date}";

            if (!Cache::has($cacheKey)) {
                $article->increment('view');
                Cache::put($cacheKey, true, now()->addDay()); // expired dalam 1 hari
            }
        }

        return $next($request);
    }
}
