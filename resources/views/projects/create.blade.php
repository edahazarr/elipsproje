<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">Yeni Proje</h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-6">

                    <div class="card shadow-sm">
                        <div class="card-body">

                            <form method="POST" action="{{ route('projects.store') }}">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label">Ad</label>
                                    <input name="name"
                                           value="{{ old('name') }}"
                                           class="form-control @error('name') is-invalid @enderror"
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Açıklama</label>
                                    <textarea name="description"
                                              class="form-control @error('description') is-invalid @enderror"
                                              rows="4">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Başlangıç Tarihi</label>
                                    <input type="date"
                                           name="start_date"
                                           value="{{ old('start_date') }}"
                                           class="form-control @error('start_date') is-invalid @enderror">
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Bitiş Tarihi</label>
                                    <input type="date"
                                           name="end_date"
                                           value="{{ old('end_date') }}"
                                           class="form-control @error('end_date') is-invalid @enderror">
                                    @error('end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">Kaydet</button>
                                    <a href="{{ route('projects.index') }}" class="btn btn-secondary">Geri</a>
                                </div>
                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
