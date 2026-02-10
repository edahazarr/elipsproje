<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
            Görev Düzenle — {{ $project->name }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">

                <form method="POST" action="{{ route('projects.tasks.update', [$project, $task]) }}">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block mb-1 text-sm text-gray-600">Başlık</label>
                        <input name="title" class="w-full border rounded p-2" value="{{ old('title', $task->title) }}" required>
                        @error('title') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="mt-4">
    <label class="block mb-1 text-sm text-gray-600">Atanan Kullanıcı</label>
    <select name="assigned_user_id" class="w-full border rounded p-2">
        <option value="">— Seçilmedi —</option>
        @foreach($users as $user)
            <option value="{{ $user->id }}"
                @selected(old('assigned_user_id', $task->assigned_user_id) == $user->id)>
                {{ $user->name }}
            </option>
        @endforeach
    </select>
    @error('assigned_user_id')
        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
    @enderror
</div>


                    <div class="mt-4">
                        <label class="block mb-1 text-sm text-gray-600">Açıklama</label>
                        <textarea name="description" class="w-full border rounded p-2" rows="4">{{ old('description', $task->description) }}</textarea>
                    </div>

                    <div class="mt-4">
                        <label class="block mb-1 text-sm text-gray-600">Durum</label>
                        <select name="status" class="w-full border rounded p-2" required>
                            <option value="todo" @selected(old('status', $task->status)==='todo')>Yapılacak</option>
                            <option value="doing" @selected(old('status', $task->status)==='doing')>Yapılıyor</option>
                            <option value="done" @selected(old('status', $task->status)==='done')>Bitti</option>
                        </select>
                    </div>

                    <div class="mt-4">
                        <label class="block mb-1 text-sm text-gray-600">Son Tarih</label>
                        <input type="date" name="due_date" class="w-full border rounded p-2"
                               value="{{ old('due_date', $task->due_date) }}">
                    </div>

                    <div class="mt-6 flex gap-3">
                        <button type="submit"
                                style="background:#2563eb; color:white; padding:10px 16px; border-radius:6px; text-decoration:none; font-weight:bold;">
                            Güncelle
                        </button>

                        <a class="px-4 py-2 border rounded" href="{{ route('projects.tasks.index', $project) }}">Geri</a>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
