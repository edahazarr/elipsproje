<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">
            Proje Düzenle
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-6">

                    <div class="card shadow-sm">
                        <div class="card-body">

                            <form method="POST" action="{{ route('projects.update', $project) }}">
                                @csrf
                                @method('PUT')

                                <!-- Proje adı -->
                                <div class="mb-3">
                                    <label class="form-label">Ad</label>
                                    <input name="name"
                                           class="form-control @error('name') is-invalid @enderror"
                                           value="{{ old('name', $project->name) }}"
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Açıklama -->
                                <div class="mb-3">
                                    <label class="form-label">Açıklama</label>
                                    <textarea name="description"
                                              class="form-control"
                                              rows="4">{{ old('description', $project->description) }}</textarea>
                                </div>

                                <!-- Tarihler -->
                                <div class="mb-3">
                                    <label class="form-label">Başlangıç Tarihi</label>
                                    <input type="date"
                                           name="start_date"
                                           class="form-control"
                                           value="{{ old('start_date', $project->start_date) }}">
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Bitiş Tarihi</label>
                                    <input type="date"
                                           name="end_date"
                                           class="form-control"
                                           value="{{ old('end_date', $project->end_date) }}">
                                </div>

                                <!-- GÜNCELLE BUTONU -->
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-success">
                                        Güncelle
                                    </button>
                                    <a class="btn btn-secondary"
                                       href="{{ route('projects.index') }}">
                                        Geri
                                    </a>
                                </div>

                            </form>

                            <hr class="my-4">

                            <!-- PROJE ÜYELERİ -->
                            <h5 class="mb-3">Proje Üyeleri</h5>

                            <!-- ÜYE EKLEME FORMU -->
                            <form method="POST"
                                  action="{{ route('projects.users.assign', $project) }}"
                                  class="row g-2 align-items-end">
                                @csrf

                                <div class="col">
                                    <label class="form-label " style="color:white;">Kullanıcı seç</label>
                                    <select name="user_id"
                                            class="form-select"
                                            required>
                                        @foreach(\App\Models\User::where('company_id', auth()->user()->company_id)->orderBy('name')->get() as $u)
                                            <option value="{{ $u->id }}">
                                                {{ $u->name }} ({{ $u->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-auto">
                                    <button type="submit"
                                            class="btn btn-primary">
                                        Ata
                                    </button>
                                </div>
                            </form>

                            <!-- ÜYE LİSTESİ -->
                            <div class="mt-4">
                                @forelse($project->users as $member)
                                    <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                                        <div>
                                            {{ $member->name }} - {{ $member->email }}
                                        </div>
                                        <form method="POST"
                                              action="{{ route('projects.users.remove', [$project, $member]) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" type="submit">
                                                Çıkar
                                            </button>
                                        </form>
                                    </div>
                                @empty
                                    <div class="text-muted mt-2">
                                        Bu projeye henüz kullanıcı atanmadı.
                                    </div>
                                @endforelse
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
