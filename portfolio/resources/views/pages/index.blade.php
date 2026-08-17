<x-guest-layout>
    <div class="py-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-4 flex items-center justify-between">
                <h1 class="text-2xl font-semibold text-gray-900">
                    Pagina's
                </h1>
                <a href="{{ route('login') }}"
                   class="text-sm font-medium text-indigo-600 hover:text-indigo-800">
                    Inloggen
                </a>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                @if($pages->count())
                    <ul class="divide-y divide-gray-200">
                        @foreach($pages as $page)
                            <li class="py-3 flex items-center justify-between">
                                <div>
                                    <a href="{{ route('pages.public.show', $page->slug) }}"
                                       class="text-lg font-medium text-indigo-600 hover:text-indigo-800">
                                        {{ $page->title }}
                                    </a>
                                    @if($page->seo_description)
                                        <p class="text-sm text-gray-500 mt-1">
                                            {{ $page->seo_description }}
                                        </p>
                                    @endif
                                </div>
                                <span class="text-xs text-gray-400">
                                    {{ $page->updated_at->format('d-m-Y') }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-500 text-center">
                        Er zijn nog geen gepubliceerde pagina's.
                    </p>
                @endif
            </div>
        </div>
    </div>
</x-guest-layout>

