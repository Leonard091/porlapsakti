@extends('adminpus.index')

@section('content')
<div class="pagetitle">
    <h1>Provinsi</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('adminpus') }}">Home</a></li>
            <li class="breadcrumb-item active">Provinsi</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Data Provinsi</h5>
                    
                    <!-- Tombol Tambah Provinsi -->
                    <a href="{{ route('provinsi.create') }}" class="btn btn-success mb-3">
                        <i class="ri-add-circle-fill"></i> Tambah Provinsi
                    </a>

                    <!-- Tabel Data -->
                    <table class="table table-striped datatable" id="provinsiTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Provinsi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($provinces as $index => $province)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $province->nama_provinsi }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <!-- Tombol Edit -->
                                        <a href="{{ route('provinsi.edit', $province->id) }}" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" title="Edit">
                                            <i class="ri-edit-2-fill"></i>
                                        </a>
                                        <!-- Tombol Hapus -->
                                        <form action="{{ route('provinsi.destroy', $province->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus provinsi ini?')" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" title="Hapus">
                                                <i class="ri-delete-bin-2-fill"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- End Tabel Data -->
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Include DataTables CSS & JS -->


<script>
    $(document).ready(function() {
        $('#provinsiTable').DataTable({
            searching: true,   // Mengaktifkan fitur pencarian
            paging: true,      // Mengaktifkan fitur pagination
            ordering: true,    // Mengaktifkan fitur pengurutan
            language: {        // Menambahkan Bahasa Indonesia untuk UI
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data per halaman",
                zeroRecords: "Data tidak ditemukan",
                info: "Menampilkan _START_ hingga _END_ dari _TOTAL_ data",
                infoEmpty: "Tidak ada data yang tersedia",
                infoFiltered: "(difilter dari total _MAX_ data)",
                paginate: {
                    first: "Awal",
                    last: "Akhir",
                    next: "Berikutnya",
                    previous: "Sebelumnya"
                }
            }
        });
        
    });
</script>
@endsection
