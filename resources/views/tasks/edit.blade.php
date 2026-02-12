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

                            {{-- TASK UPDATE --}}
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

                            <hr class="my-4">

                            {{-- COMMENTS --}}
                            <h5 class="mb-3">Yorumlar</h5>

                            <form method="POST" action="{{ route('projects.tasks.comments.store', [$project, $task]) }}" class="mb-3">
                                @csrf

                                <textarea name="body"
                                          class="form-control @error('body') is-invalid @enderror"
                                          rows="3"
                                          placeholder="Yorum yaz...">{{ old('body') }}</textarea>

                                @error('body')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <div class="mt-2 d-flex justify-content-end">
                                    <button class="btn btn-primary btn-sm">Gönder</button>
                                </div>
                            </form>

                            @forelse($task->comments as $c)
                                <div class="border rounded p-2 mb-2">
                                    <div class="small text-muted d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>{{ $c->user->name }}</strong>
                                            <span class="ms-2">{{ $c->created_at->format('d.m.Y H:i') }}</span>
                                        </div>

                                        {{-- sadece yorum sahibi görsün --}}
                                        @if($c->user_id === auth()->id())
                                            <div class="d-flex gap-2">
                                                <form method="POST"
                                                      action="{{ route('projects.tasks.comments.destroy', [$project, $task, $c]) }}"
                                                      onsubmit="return confirm('Yorum silinsin mi?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-outline-danger btn-sm">Sil</button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="mt-1">{{ $c->body }}</div>
                                </div>
                            @empty
                                <div class="text-muted">Henüz yorum yok.</div>
                            @endforelse

                            <hr class="my-4">

                            {{-- ACTIVITY --}}
                            <h5 class="mb-3">Aktivite</h5>

                            @forelse($task->activities as $a)
                                @php
                                    $eventText = match($a->event) {
                                        'comment.created' => 'yorum ekledi',
                                        'comment.updated' => 'yorumu güncelledi',
                                        'comment.deleted' => 'yorumu sildi',
                                        'task.created'    => 'görev oluşturdu',
                                        'task.updated'    => 'görevi güncelledi',
                                        'task.moved'      => 'görev durumunu değiştirdi',
                                        default           => $a->event,
                                    };

                                    $p = $a->properties ?? [];
                                @endphp

                                <div class="border rounded p-2 mb-2 small">
                                    <div class="d-flex justify-content-between text-muted">
                                        <span>
                                            <strong>{{ $a->user?->name ?? 'Sistem' }}</strong>
                                            • {{ $eventText }}
                                        </span>
                                        <span>{{ $a->created_at->format('d.m.Y H:i') }}</span>
                                    </div>

                                    {{-- JSON basmak yerine özet --}}
                                    @if($a->event === 'comment.created')
                                        @if(!empty($p['comment']))
                                            <div class="mt-1">{{ $p['comment'] }}</div>
                                        @elseif(!empty($p['body']))
                                            <div class="mt-1">{{ $p['body'] }}</div>
                                        @endif

                                    @elseif($a->event === 'comment.updated')
                                        @if(!empty($p['old_body']) || !empty($p['new_body']))
                                            <div class="mt-1">
                                                @if(!empty($p['old_body']))
                                                    <div class="text-muted">Eski:</div>
                                                    <div>{{ $p['old_body'] }}</div>
                                                @endif
                                                @if(!empty($p['new_body']))
                                                    <div class="text-muted mt-2">Yeni:</div>
                                                    <div>{{ $p['new_body'] }}</div>
                                                @endif
                                            </div>
                                        @endif

                                    @elseif($a->event === 'comment.deleted')
                                        @if(!empty($p['body']))
                                            <div class="mt-1 text-muted">{{ $p['body'] }}</div>
                                        @endif
                                    @endif
                                </div>
                            @empty
                                <div class="text-muted">Aktivite yok.</div>
                            @endforelse

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
