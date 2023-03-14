<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $data = [];
        $locales = [config('app.locale'), config('app.fallback_locale')];

        foreach ($locales as $locale) {
            $path = lang_path("{$locale}.json");
            $content = file_get_contents($path);
            $data[$locale] = json_decode($content, true);
        }

        return array_merge(parent::share($request), [
            'appName' => config('app.name'),
            'message' => fn () => $request->session()->get('message'),
            'currency' => config('app.currency'),
            'translations' => [
                'locale' => config('app.locale'),
                'data' => $data,
            ],
            'auth' => [
                'user' => $request->user(),
            ],
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },
        ]);
    }
}
