<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <nav class="mb-6">
                <ul class="flex space-x-4">
                    <li><a href="#paginas" class="text-blue-600 hover:text-blue-800 font-semibold">Pagina's</a></li>
                    <li><a href="#projecten" class="text-gray-600 hover:text-gray-800">Projecten</a></li>
                </ul>
            </nav>

            <!-- Pagina's Sectie -->
            <div id="paginas" class="bg-white shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Pagina's Beheren</h3>
                        <button onclick="togglePageForm()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                            + Nieuwe Pagina
                        </button>
                    </div>

                    <!-- Formulier voor nieuwe pagina -->
                    <div id="pageForm" class="hidden mb-6 p-4 bg-gray-50 rounded-lg">
                        <form id="createPageForm" action="{{ route('pages.store') }}" method="POST">
                            @csrf
                            <div class="grid grid-cols-1 gap-4 mb-4">
                                <div>
                                    <label for="title" class="block text-sm font-medium text-gray-700">Titel *</label>
                                    <input type="text" name="title" id="title" required
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="slug" class="block text-sm font-medium text-gray-700">Slug</label>
                                    <input type="text" name="slug" id="slug"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                           placeholder="Laat leeg voor automatische generatie">
                                </div>
                                <div>
                                    <label for="content" class="block text-sm font-medium text-gray-700">Inhoud *</label>
                                    <textarea name="content" id="content" rows="6" required
                                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="seo_title" class="block text-sm font-medium text-gray-700">SEO Titel</label>
                                        <input type="text" name="seo_title" id="seo_title"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>
                                    <div>
                                        <label for="status" class="block text-sm font-medium text-gray-700">Status *</label>
                                        <select name="status" id="status" required
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="draft">Draft</option>
                                            <option value="published">Published</option>
                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <label for="seo_description" class="block text-sm font-medium text-gray-700">SEO Beschrijving</label>
                                    <textarea name="seo_description" id="seo_description" rows="2"
                                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                                </div>
                            </div>
                            <div class="flex justify-end space-x-2">
                                <button type="button" onclick="togglePageForm()" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                                    Annuleren
                                </button>
                                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm font-medium hover:bg-indigo-700">
                                    Opslaan
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Bestaande pagina's overzicht -->
                    <div class="overflow-x-auto">
                        @if($pages->count() > 0)
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Titel</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Slug</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aangemaakt</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acties</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($pages as $page)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $page->title }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $page->slug }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $page->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                    {{ $page->status === 'published' ? 'Published' : 'Draft' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $page->created_at->format('d-m-Y') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <button onclick="editPage({{ $page->id }})" class="text-indigo-600 hover:text-indigo-900 mr-3">Bewerken</button>
                                                <form action="{{ route('pages.destroy', $page) }}" method="POST" class="inline" onsubmit="return confirm('Weet je zeker dat je deze pagina wilt verwijderen?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Verwijderen</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="text-gray-500 text-center py-4">Nog geen pagina's aangemaakt.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Projecten Sectie (placeholder) -->
            <div id="projecten" class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Projecten Beheren</h3>
                    <p class="text-gray-500">Projecten beheer komt later...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Pagina Bewerken</h3>
                    <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600">&times;</button>
                </div>
                <form id="editPageForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 gap-4 mb-4">
                        <div>
                            <label for="edit_title" class="block text-sm font-medium text-gray-700">Titel *</label>
                            <input type="text" name="title" id="edit_title" required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label for="edit_slug" class="block text-sm font-medium text-gray-700">Slug</label>
                            <input type="text" name="slug" id="edit_slug"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label for="edit_content" class="block text-sm font-medium text-gray-700">Inhoud *</label>
                            <textarea name="content" id="edit_content" rows="6" required
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="edit_seo_title" class="block text-sm font-medium text-gray-700">SEO Titel</label>
                                <input type="text" name="seo_title" id="edit_seo_title"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="edit_status" class="block text-sm font-medium text-gray-700">Status *</label>
                                <select name="status" id="edit_status" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="draft">Draft</option>
                                    <option value="published">Published</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label for="edit_seo_description" class="block text-sm font-medium text-gray-700">SEO Beschrijving</label>
                            <textarea name="seo_description" id="edit_seo_description" rows="2"
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                        </div>
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button type="button" onclick="closeEditModal()" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                            Annuleren
                        </button>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm font-medium hover:bg-indigo-700">
                            Bijwerken
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePageForm() {
            const form = document.getElementById('pageForm');
            form.classList.toggle('hidden');
            if (!form.classList.contains('hidden')) {
                document.getElementById('createPageForm').reset();
            }
        }

        function editPage(pageId) {
            // Fetch page data via AJAX or use data attributes
            // For now, we'll use a simple approach - you might want to fetch via API
            fetch(`/pages/${pageId}/edit`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('edit_title').value = data.title;
                    document.getElementById('edit_slug').value = data.slug;
                    document.getElementById('edit_content').value = data.content;
                    document.getElementById('edit_seo_title').value = data.seo_title || '';
                    document.getElementById('edit_seo_description').value = data.seo_description || '';
                    document.getElementById('edit_status').value = data.status;
                    document.getElementById('editPageForm').action = `/pages/${pageId}`;
                    document.getElementById('editModal').classList.remove('hidden');
                })
                .catch(() => {
                    // Fallback: redirect to edit page or show error
                    alert('Fout bij het laden van pagina gegevens');
                });
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        // Auto-generate slug from title
        document.getElementById('title')?.addEventListener('input', function() {
            const slugInput = document.getElementById('slug');
            if (!slugInput.value) {
                slugInput.value = this.value.toLowerCase()
                    .replace(/[^\w\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-');
            }
        });

        document.getElementById('edit_title')?.addEventListener('input', function() {
            const slugInput = document.getElementById('edit_slug');
            if (!slugInput.value) {
                slugInput.value = this.value.toLowerCase()
                    .replace(/[^\w\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-');
            }
        });
    </script>
</x-app-layout>
