<x-guest-layout>
    <div class="py-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-4 flex items-center justify-between">
                <h1 class="text-2xl font-semibold text-gray-900">
                    {{ $page->title }}
                </h1>
                <a href="{{ route('login') }}"
                   class="text-sm font-medium text-indigo-600 hover:text-indigo-800">
                    Inloggen
                </a>
            </div>

            <article class="bg-white shadow-sm sm:rounded-lg p-6">
                <header class="mb-6">
                    @if ($page->seo_description)
                        <p class="mt-2 text-gray-600">{{ $page->seo_description }}</p>
                    @endif
                </header>
                <div class="prose max-w-none">
                    {!! nl2br(e($page->content)) !!}
                </div>
            </article>
        </div>
    </div>
</x-guest-layout>
