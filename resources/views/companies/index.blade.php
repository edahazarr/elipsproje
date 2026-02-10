<x-app-layout>
    <div class="d-flex justify-content-between mb-3">
        <h2>Şirketler</h2>
        <a href="{{ route('companies.create') }}" class="btn btn-primary">Yeni Şirket</a>
    </div>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Ad</th>
                <th>Durum</th>
                <th>İşlemler</th>
            </tr>
        </thead>
        <tbody>
            @foreach($companies as $company)
            <tr>
                <td>{{ $company->id }}</td>
                <td>{{ $company->name }}</td>
                <td>{{ $company->is_active ? 'Aktif' : 'Pasif' }}</td>
                <td>
                    <a href="{{ route('companies.edit', $company) }}" class="btn btn-sm btn-info">Düzenle</a>

                    <form method="POST" action="{{ route('companies.toggle', $company) }}" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button class="btn btn-sm btn-warning">
                            {{ $company->is_active ? 'Pasif Yap' : 'Aktif Yap' }}
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</x-app-layout>
