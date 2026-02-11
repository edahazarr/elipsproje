<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">
            Yeni Görev — {{ $project->name }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-6">

                    <div class="card shadow-sm">
                        <div class="card-body">

                            <form method="POST" action="{{ route('projects.tasks.store', $project) }}">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label">Başlık</label>
                                    <input
                                        name="title"
                                        value="{{ old('title') }}"
                                        class="form-control @error('title') is-invalid @enderror"
                                        required
                                    >
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Açıklama</label>
                                    <textarea
                                        name="description"
                                        class="form-control @error('description') is-invalid @enderror"
                                        rows="4"
                                    >{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Status zorunlu: default todo gönderelim --}}
                                <input type="hidden" name="status" value="todo">
                                <div class="mb-3">
    <label class="form-label">Atanan Kişiler</label>

    @php
        $selectedUserIds = old('user_ids', []);
    @endphp

    <select
        name="user_ids[]"
        class="form-select @error('user_ids') is-invalid @enderror"
        multiple
        size="6"
    >
        @foreach($users as $u)
            <option value="{{ $u->id }}" @selected(in_array($u->id, $selectedUserIds))>
                {{ $u->name }}
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


                                <div class="mb-4">
                                    <label class="form-label">Son Tarih</label>
                                    <input
                                        type="date"
                                        name="due_date"
                                        value="{{ old('due_date') }}"
                                        class="form-control @error('due_date') is-invalid @enderror"
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
    <option value="" @selected(old('priority') === null || old('priority') === '')>Seçiniz</option>
<option value="low" @selected(old('priority') === 'low')>Low</option>
<option value="medium" @selected(old('priority') === 'medium')>Medium</option>
<option value="high" @selected(old('priority') === 'high')>High</option>

</select>
@error('priority')
  <div class="invalid-feedback">{{ $message }}</div>
@enderror

</div>

<div class="mb-3">
    <label class="form-label">Etiket</label>
    <select name="tag" class="form-select">
        <option value="">Yok</option>
        <option value="bug">Bug</option>
        <option value="feature">Feature</option>
        <option value="urgent">Urgent</option>
    </select>
</div>


                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">Kaydet</button>

                                    <a href="{{ route('projects.show', $project) }}" class="btn btn-secondary">
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
