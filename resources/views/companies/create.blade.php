<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">Yeni Şirket</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                <form method="POST" action="{{ route('companies.store') }}">
                    @csrf

                    <div>
                        <label class="block mb-1">Şirket Adı</label>
                        <input name="name" class="w-full rounded border p-2" value="{{ old('name') }}">
                        @error('name') <div class="text-red-600 mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="mt-4 flex gap-2">
                        <button class="px-4 py-2 bg-black text-white rounded" type="submit">Kaydet</button>
                        <a class="px-4 py-2 border rounded" href="{{ route('companies.index') }}">İptal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
