<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
            Yeni Proje
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">

                <form method="POST" action="{{ route('projects.store') }}">
                    @csrf

                    <div>
                        <label>Ad</label>
                        <input name="name" style="width:100%;border:1px solid #ccc;padding:8px;">
                    </div>

                    <div style="margin-top:15px;">
                        <label>Açıklama</label>
                        <textarea name="description" style="width:100%;border:1px solid #ccc;padding:8px;"></textarea>
                    </div>

                    <div style="margin-top:15px;">
                        <label>Başlangıç Tarihi</label>
                        <input type="date" name="start_date" style="width:100%;border:1px solid #ccc;padding:8px;">
                    </div>

                    <div style="margin-top:15px;">
                        <label>Bitiş Tarihi</label>
                        <input type="date" name="end_date" style="width:100%;border:1px solid #ccc;padding:8px;">
                    </div>

                    <div style="margin-top:20px;">
                        <button type="submit"
                            style="background:#2563eb;color:white;padding:10px 20px;border:none;border-radius:6px;">
                            Kaydet
                        </button>

                        <a href="{{ route('projects.index') }}"
                           style="margin-left:10px;">
                            Geri
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
