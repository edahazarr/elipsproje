<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
            Şirket Düzenle
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">

                <form method="POST" action="{{ route('companies.update', $company) }}">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block mb-1 text-sm text-gray-600 dark:text-gray-300">Şirket Adı</label>
                        <input
                            type="text"
                            name="name"
                            class="w-full border rounded p-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white"
                            value="{{ old('name', $company->name) }}"
                            required
                        >
                        @error('name')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                     <div class="mt-6 d-flex gap-2">
    <button type="submit" class="btn btn-primary">
        Güncelle
    </button>

    <a href="{{ route('companies.index') }}" class="btn btn-secondary">
        Geri
    </a>
</div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
