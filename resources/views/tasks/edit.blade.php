<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">
            Görev Düzenle — {{ $project->name }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-6">

                    <div class="card shadow-sm">
                        <div class="card-body">

                            <form method="POST" action="{{ route('projects.tasks.update', [$project, $task]) }}">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label class="form-label">Başlık</label>
                                    <input
                                        name="title"
                                        class="form-control @error('title') is-invalid @enderror"
                                        value="{{ old('title', $task->title) }}"
                                        required
                                    >
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Atanan Kullanıcılar</label>

                                    @php
                                        $selectedUserIds = old(
                                            'user_ids',
                                            $task->assignees?->pluck('id')->toArray() ?? []
                                        );
                                    @endphp

                                    <select
                                        name="user_ids[]"
                                        class="form-select @error('user_ids') is-invalid @enderror"
                                        multiple
                                        size="6"
                                    >
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}"
                                                @selected(in_array($user->id, $selectedUserIds))>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <div class="form-text">Ctrl/⌘ ile çoklu seçim yapabilirsin.</div>

                                    @error('user_ids')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                    @error('user_ids.*')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Açıklama</label>
                                    <textarea
                                        name="description"
                                        class="form-control @error('description') is-invalid @enderror"
                                        rows="4"
                                    >{{ old('description', $task->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Durum</label>
                                    <select
                                        name="status"
                                        class="form-select @error('status') is-invalid @enderror"
                                        required
                                    >
                                        <option value="todo"  @selected(old('status', $task->status)==='todo')>Yapılacak</option>
                                        <option value="doing" @selected(old('status', $task->status)==='doing')>Yapılıyor</option>
                                        <option value="done"  @selected(old('status', $task->status)==='done')>Bitti</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Son Tarih</label>
                                    <input
                                        type="date"
                                        name="due_date"
                                        class="form-control @error('due_date') is-invalid @enderror"
                                        value="{{ old('due_date', $task->due_date) }}"
                                    >
                                    @error('due_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
    <label class="form-label">Öncelik</label>
    <select name="priority"
            class="form-select @error('priority') is-invalid @enderror"
            required>
        <option value="" @selected(old('priority', $task->priority) === null || old('priority', $task->priority) === '')>Seçiniz</option>
        <option value="low" @selected(old('priority', $task->priority) === 'low')>Low</option>
        <option value="medium" @selected(old('priority', $task->priority) === 'medium')>Medium</option>
        <option value="high" @selected(old('priority', $task->priority) === 'high')>High</option>
    </select>
    @error('priority')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Etiket</label>
    <select name="tag"
            class="form-select @error('tag') is-invalid @enderror">
        <option value="" @selected(old('tag', $task->tag) === null || old('tag', $task->tag) === '')>Yok</option>
        <option value="bug" @selected(old('tag', $task->tag) === 'bug')>Bug</option>
        <option value="feature" @selected(old('tag', $task->tag) === 'feature')>Feature</option>
        <option value="urgent" @selected(old('tag', $task->tag) === 'urgent')>Urgent</option>
    </select>
    @error('tag')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        Güncelle
                                    </button>

                                    <a href="{{ route('projects.tasks.index', $project) }}" class="btn btn-secondary">
                                        Geri
                                    </a>
                                </div>
                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
