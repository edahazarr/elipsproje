<x-app-layout>
    <x-slot name="header">
    <div class="py-2">
        <h2 class="h4 fw-semibold mb-2">Projeler</h2>
    </div>
</x-slot>

   <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
    <div class="h5 fw-semibold text-muted mb-0">
    Toplam: {{ $totalCount }} Proje
</div>


    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
    
    <form method="GET" action="{{ route('projects.index') }}" class="d-flex flex-wrap gap-2 mt-2">
        <input
            type="text"
            name="q"
            value="{{ $q ?? '' }}"
            class="form-control"
            style="max-width: 240px;"
            placeholder="Proje adı ara...">

        <select name="status" class="form-select" style="max-width: 180px;">
            <option value="all" @selected(($status ?? 'all') === 'all')>Tümü</option>
            <option value="active" @selected(($status ?? 'all') === 'active')>Aktif</option>
            <option value="passive" @selected(($status ?? 'all') === 'passive')>Pasif</option>
        </select>

        <button class="btn btn-outline-primary" type="submit">Filtrele</button>
        <a class="btn btn-outline-secondary" href="{{ route('projects.index') }}">Temizle</a>
    </form>

    <a href="{{ route('projects.create') }}" class="btn btn-primary mt-2">
        + Yeni Proje
    </a>
</div>
</div>


            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card shadow-sm">
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 80px;">ID</th>
                                    <th>Ad</th>
                                    <th style="width: 120px;">Durum</th>
                                    <th style="width: 320px;">İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($projects as $project)
                                    <tr>
                                        <td>{{ $project->id }}</td>
                                        <td>
                                            <a href="{{ route('projects.tasks.index', $project) }}" class="fw-semibold">
                                                {{ $project->name }}
                                            </a>
                                        </td>
                                        <td>
                                            @if($project->is_active)
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-danger">Pasif</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex flex-wrap gap-2">
                                                <a class="btn btn-sm btn-outline-secondary"
                                                   href="{{ route('projects.edit', $project) }}">
                                                    Düzenle
                                                </a>

                                                <a class="btn btn-sm btn-outline-primary"
                                                   href="{{ route('projects.tasks.index', $project) }}">
                                                    Görevler
                                                </a>

                                                <form method="POST" action="{{ route('projects.toggle', $project) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button class="btn btn-sm btn-outline-dark" type="submit">
                                                        {{ $project->is_active ? 'Pasif Yap' : 'Aktif Yap' }}
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-muted py-4">
                                            Henüz proje yok.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="mt-3">
    {{ $projects->links() }}
</div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
