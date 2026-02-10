<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
                Kullanıcılar
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                <table class="w-full">
                    <thead>
                        <tr class="text-left border-b">
                            <th class="py-2">ID</th>
                            <th class="py-2">Ad</th>
                            <th class="py-2">Email</th>
                            <th class="py-2">Şirket</th>
                            <th class="py-2">Rol</th>
                            <th class="py-2">Durum</th>
                            <th class="py-2">İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $u)
                            <tr class="border-b">
                                <td class="py-2">{{ $u->id }}</td>
                                <td class="py-2">{{ $u->name }}</td>
                                <td class="py-2">{{ $u->email }}</td>
                                <td class="py-2">{{ $u->company?->name ?? '-' }}</td>
                                <td class="py-2">{{ $u->getRoleNames()->join(', ') ?: '-' }}</td>
                                <td class="py-2">
                                    @if($u->is_active)
                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded">Aktif</span>
                                    @else
                                        <span class="px-2 py-1 bg-red-100 text-red-800 rounded">Pasif</span>
                                    @endif
                                </td>
                                <td class="py-2 flex gap-3">
    <a class="underline" href="{{ route('users.edit', $u) }}">Düzenle</a>

    <form method="POST" action="{{ route('users.toggle', $u) }}">
        @csrf
        @method('PATCH')
        <button class="underline" type="submit">
            {{ $u->is_active ? 'Pasif Yap' : 'Aktif Yap' }}
        </button>
    </form>
</td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @if($users->count() === 0)
                    <div class="text-gray-500 mt-4">Henüz kullanıcı yok.</div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
