<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
            Kullanıcı Düzenle
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">

                <form method="POST" action="{{ route('users.update', $user) }}">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block mb-1 text-sm text-gray-600 dark:text-gray-300">Şirket</label>
                        <select name="company_id" class="w-full border rounded p-2">
                            <option value="">-</option>
                            @foreach($companies as $id => $name)
                                <option value="{{ $id }}" @selected($user->company_id == $id)>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                        @error('company_id') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="mt-4">
                        <label class="block mb-1 text-sm text-gray-600 dark:text-gray-300">Rol</label>
                        <select name="role" class="w-full border rounded p-2">
                            @foreach($roles as $role)
                                <option value="{{ $role }}" @selected($user->hasRole($role))>
                                    {{ $role }}
                                </option>
                            @endforeach
                        </select>
                        @error('role') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="mt-4">
                        <label class="block mb-1 text-sm text-gray-600 dark:text-gray-300">Durum</label>
                        <select name="is_active" class="w-full border rounded p-2">
                            <option value="1" @selected($user->is_active)>Aktif</option>
                            <option value="0" @selected(!$user->is_active)>Pasif</option>
                        </select>
                        @error('is_active') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="mt-6 flex gap-3">
                        <button class="px-4 py-2 bg-black text-white rounded" type="submit">
                            Güncelle
                        </button>

                        <a class="px-4 py-2 border rounded" href="{{ route('users.index') }}">
                            Geri
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
