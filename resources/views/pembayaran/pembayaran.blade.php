<x-layouts>
    <x-slot:title>{{ $title }}</x-slot:title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Bootstrap JS Bundle (termasuk Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <div class="bg-[#2D3748] py-16 sm:py-20">
        @if (session('status') && session('message'))
            <div class="alert alert-{{ session('status') }} alert-dismissible fade show mt-3" role="alert">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="container mx-auto px-6 lg:px-8 w-full">

            <!-- Tombol untuk menambah group -->
            <button type="button"
                class="text-right mb-8 text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-green-500 dark:hover:bg-green-600 dark:focus:ring-green-800"
                data-bs-toggle="modal" data-bs-target="#GroupModal">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                    class="size-6 mr-2 w-5 h-5">
                    <path
                        d="M12 4.5a.75.75 0 0 1 .75.75v6h6a.75.75 0 0 1 0 1.5h-6v6a.75.75 0 0 1-1.5 0v-6h-6a.75.75 0 0 1 0-1.5h6v-6A.75.75 0 0 1 12 4.5Z" />
                </svg>
                Tambah Group
            </button>

            <!-- Modal Daftar Group (Modal Pertama) -->
            <div class="modal fade" id="GroupModal" tabindex="-1" aria-labelledby="GroupModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content" style="background-color: #2D3748; color: #F7FAFC;">
                        <div class="modal-header" style="border-bottom: 1px solid #003366;">
                            <h5 class="modal-title" id="GroupModalLabel" style="color: #F7FAFC;">Groups</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Tabel dengan latar belakang gelap dan teks terang -->
                            <table class="table table-striped table-bordered table-hover"
                                style="background-color: #2D3748; color: #F7FAFC !important;">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th style="color: #F7FAFC !important;">Nama</th>
                                        <th style="color: #F7FAFC !important;">Deskripsi</th>
                                        <th style="color: #F7FAFC !important;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody style="background-color: #1A2634; color: #F7FAFC !important;">
                                    @foreach ($groups as $group)
                                        <tr id="group-row-{{ $group->id }}">
                                            <td style="color: #F7FAFC !important;">{{ $group->name }}</td>
                                            <td style="color: #F7FAFC !important;">{{ $group->description }}</td>
                                            <td style="color: #F7FAFC !important;">
                                                <!-- Form untuk menghapus group -->
                                                <form style="display: inline-block;">
                                                    <!-- Tombol untuk memicu modal konfirmasi hapus -->
                                                    <button type="button"
                                                        class="btn btn-danger btn-sm rounded-pill shadow-lg"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal{{ $group->id }}">
                                                        <i class="bi bi-trash"></i> Hapus
                                                    </button>
                                                </form>


                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>




                            <!-- Tombol untuk membuka modal tambah Group baru -->
                            <button type="button" class="btn" style="background-color: #38A169; color: white;"
                                data-bs-toggle="modal" data-bs-target="#addGroupModal">
                                Tambah Group Baru
                            </button>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Menampilkan Grup dalam bentuk card -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                @foreach ($groups as $group)
                    <div
                        class="bg-[#1A2634] border border-[#2D3748] rounded-lg shadow-lg hover:shadow-xl transition-all">
                        <!-- Bagian atas card -->
                        <div class="p-6">
                            <!-- Nama Grup -->
                            <h3 class="text-2xl font-bold text-[#F7FAFC] mb-3">{{ $group->name }}</h3>

                            <!-- Separator dengan garis tebal -->
                            <hr id="separator" class="border-4 rounded mb-10"
                                style="border-width: 1px; border-style: solid; border-color: #FF6347 !important;">

                            <!-- Deskripsi Grup -->
                            <p class="text-sm text-[#E2E8F0] leading-relaxed">{{ $group->description }}</p>

                            <!-- Tanggal Dibuat -->
                            <p class="text-xs text-[#A0AEC0] mt-4">
                                Dibuat pada:
                                {{ $group->created_at ? $group->created_at->format('d M Y') : 'Tanggal tidak tersedia' }}
                            </p>
                        </div>

                        <!-- Bagian bawah card -->

                        <div class="p-6 bg-[#2D3748] text-right">
                            <a href="{{ route('List Admin', ['group' => $group->name]) }}"
                                class="px-4 py-2 bg-[#FF6347] text-white rounded-lg hover:bg-[#003366] transition-all no-underline">
                                Lihat Group
                            </a>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
    <!-- Modal Konfirmasi Hapus -->
    @foreach ($groups as $group)
        <div class="modal fade" id="deleteModal{{ $group->id }}" tabindex="-1"
            aria-labelledby="deleteModalLabel{{ $group->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel{{ $group->id }}">Konfirmasi Hapus</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah Anda yakin ingin menghapus group "<strong>{{ $group->name }}</strong>"?
                    </div>
                    <div class="modal-footer">
                        <!-- Tombol Batal dengan Ikon -->
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle"></i> Batal
                        </button>

                        <!-- Form untuk menghapus group -->
                        <form id="deleteForm{{ $group->id }}" action="{{ route('group.destroy') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="group_id" value="{{ $group->id }}">
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach


    <!-- Modal Tambah Group Baru -->
    <div class="modal fade" id="addGroupModal" tabindex="-1" aria-labelledby="addGroupModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="background-color: #2D3748; color: #F7FAFC;">
                <div class="modal-header" style="border-bottom: 1px solid #003366;">
                    <h5 class="modal-title" id="addGroupModalLabel">Tambah Group Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Isi nama dan deskripsi Group baru</p>
                    <form action="{{ route('group.store', ['group' => $group->name]) }}" method="POST">
                        @csrf
                        <!-- Input untuk nama Group -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Group</label>
                            <input type="text" class="form-control" id="name" name="name" required
                                style="background-color: #1A2634; color: #F7FAFC; border: 1px solid #3182CE;">
                        </div>

                        <!-- Input untuk deskripsi Group -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi Group</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required
                                style="background-color: #1A2634; color: #F7FAFC; border: 1px solid #3182CE;"></textarea>
                        </div>

                        <!-- Tombol untuk menambah Group, berwarna hijau -->
                        <button type="submit" class="btn" style="background-color: #38A169; color: white;">Tambah
                            Group</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-layouts>
