<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">Projeler</h2>
    </x-slot>

    <div class="py-4">
        <div class="container">

            <div class="d-flex justify-content-end mb-3">
                <a href="{{ route('projects.create') }}" class="btn btn-primary">
                    + Yeni Proje
                </a>
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
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
