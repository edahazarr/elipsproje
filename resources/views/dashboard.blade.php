<x-app-layout>
    <h1 class="mb-4">Dashboard</h1>

    <div class="row">
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Toplam Şirket</h5>
                    <p class="card-text fs-4">{{ $totalCompanies }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Aktif Şirket</h5>
                    <p class="card-text fs-4">{{ $activeCompanies }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-info mb-3">
                <div class="card-body">
                    <h5 class="card-title">Toplam Kullanıcı</h5>
                    <p class="card-text fs-4">{{ $totalUsers }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">Aktif Kullanıcı</h5>
                    <p class="card-text fs-4">{{ $activeUsers }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
