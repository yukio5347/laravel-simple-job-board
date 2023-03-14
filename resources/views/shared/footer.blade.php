<footer class="bg-slate-800">
    <div class="grid grid-cols-2 gap-5 py-5 text-center md:grid-cols-4 md:container">
        <a href="{{ route('home') }}" class="text-sm text-center text-white">{{ __('Home') }}</a>
        <a href={{ route('jobs.index') }} class="text-sm text-center text-white">{{ __('Find Jobs') }}</a>
        <a href={{ route('jobs.create') }} class="text-sm text-center text-white">{{ __('Post a Job') }}</a>
        <a href={{ route('contact') }} class="text-sm text-center text-white">{{ __('Contact Us') }}</a>
    </div>
    <p class="py-3 text-xs text-white text-center border-t border-slate-500">&copy; {{ config('app.name') }}</p>
</footer>
