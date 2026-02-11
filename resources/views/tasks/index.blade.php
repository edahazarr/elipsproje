<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">
            Görevler — {{ $project->name }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container">

            {{-- ÜST BAR --}}
            <div class="d-flex align-items-center justify-content-between gap-3 mb-3">
                <a href="{{ route('projects.index') }}" class="btn btn-link p-0">
                    ← Projelere Dön
                </a>

                <a href="{{ route('projects.tasks.create', $project) }}" class="btn btn-primary">
                    + Yeni Görev
                </a>
            </div>

            <div class="row g-3">

                {{-- YAPILACAK --}}
                <div class="col-12 col-md-4">
                    <div class="card border-0 bg-light">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0">Yapılacak</h5>
                                <span class="badge bg-secondary">{{ $todoTasks->count() }}</span>
                            </div>

                            @forelse($todoTasks as $task)
                                <div class="card shadow-sm mb-3">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between gap-2">
                                            <div class="fw-semibold">{{ $task->title }}</div>
                                            <a class="small" href="{{ route('projects.tasks.edit', [$project, $task]) }}">
                                                Düzenle
                                            </a>
                                        </div>
                                         <div class="mt-2 d-flex gap-2">
        @if($task->priority === 'high')
            <span class="badge bg-danger">High</span>
        @elseif($task->priority === 'medium')
            <span class="badge bg-warning text-dark">Medium</span>
        @else
            <span class="badge bg-secondary">Low</span>
        @endif

        @if($task->tag)
            <span class="badge bg-info text-dark">
                {{ ucfirst($task->tag) }}
            </span>
        @endif
    </div>

                                        @if($task->description)
                                            <div class="text-muted small mt-2">{{ $task->description }}</div>
                                        @endif

                                        @if($task->due_date)
                                            <div class="text-muted small mt-2">📅 {{ $task->due_date }}</div>
                                        @endif

                                        @if($task->assignees && $task->assignees->count())
    <div class="text-muted small mt-2">
        👥 {{ $task->assignees->pluck('name')->join(', ') }}
    </div>
@endif


                                        <div class="d-flex gap-2 mt-3">
                                            <form method="POST" action="{{ route('projects.tasks.move', [$project, $task]) }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="doing">
                                                <button class="btn btn-sm btn-outline-primary" type="submit">
                                                    Yapılıyor
                                                </button>
                                            </form>

                                            <form method="POST" action="{{ route('projects.tasks.move', [$project, $task]) }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="done">
                                                <button class="btn btn-sm btn-outline-success" type="submit">
                                                    Bitti
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-muted">Görev yok</div>
                            @endforelse

                        </div>
                    </div>
                </div>

                {{-- YAPILIYOR --}}
                <div class="col-12 col-md-4">
                    <div class="card border-0 bg-light">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0">Yapılıyor</h5>
                                <span class="badge bg-info">{{ $doingTasks->count() }}</span>
                            </div>

                            @forelse($doingTasks as $task)
                                <div class="card shadow-sm mb-3">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between gap-2">
                                            <div class="fw-semibold">{{ $task->title }}</div>
                                            <a class="small" href="{{ route('projects.tasks.edit', [$project, $task]) }}">
                                                Düzenle
                                            </a>
                                        </div>
                                         <div class="mt-2 d-flex gap-2">
        @if($task->priority === 'high')
            <span class="badge bg-danger">High</span>
        @elseif($task->priority === 'medium')
            <span class="badge bg-warning text-dark">Medium</span>
        @else
            <span class="badge bg-secondary">Low</span>
        @endif

        @if($task->tag)
            <span class="badge bg-info text-dark">
                {{ ucfirst($task->tag) }}
            </span>
        @endif
    </div>

                                        @if($task->assignees && $task->assignees->count())
    <div class="text-muted small mt-2">
        👥 {{ $task->assignees->pluck('name')->join(', ') }}
    </div>
@endif


                                        <div class="d-flex gap-2 mt-3">
                                            <form method="POST" action="{{ route('projects.tasks.move', [$project, $task]) }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="done">
                                                <button class="btn btn-sm btn-outline-success" type="submit">
                                                    Bitti
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-muted">Görev yok</div>
                            @endforelse

                        </div>
                    </div>
                </div>

                {{-- BİTTİ --}}
                <div class="col-12 col-md-4">
                    <div class="card border-0 bg-light">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0">Bitti</h5>
                                <span class="badge bg-success">{{ $doneTasks->count() }}</span>
                            </div>

                            @forelse($doneTasks as $task)
                                <div class="card shadow-sm mb-3">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between gap-2">
                                            <div class="fw-semibold">{{ $task->title }}</div>
                                            <a class="small" href="{{ route('projects.tasks.edit', [$project, $task]) }}">
                                                Düzenle
                                            </a>

                                        </div>
                                         <div class="mt-2 d-flex gap-2">
        @if($task->priority === 'high')
            <span class="badge bg-danger">High</span>
        @elseif($task->priority === 'medium')
            <span class="badge bg-warning text-dark">Medium</span>
        @else
            <span class="badge bg-secondary">Low</span>
        @endif

        @if($task->tag)
            <span class="badge bg-info text-dark">
                {{ ucfirst($task->tag) }}
            </span>
        @endif
    </div>
                                        @if($task->assignees && $task->assignees->count())
    @php
        $names = $task->assignees->pluck('name');
        $firstTwo = $names->take(2)->join(', ');
        $remaining = $names->count() - 2;
    @endphp

    <div class="text-muted small mt-2">
        👥 {{ $firstTwo }}@if($remaining > 0) <span class="text-muted"> +{{ $remaining }}</span>@endif
    </div>
@endif


                                    </div>
                                </div>
                            @empty
                                <div class="text-muted">Görev yok</div>
                            @endforelse

                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
