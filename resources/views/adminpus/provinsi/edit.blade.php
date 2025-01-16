// resources/views/adminpus/provinsi/edit.blade.php
@extends('adminpus.index')

@section('content')
<div class="pagetitle">
    <h1>Edit Provinsi</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('provinsi.index') }}">Provinsi</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Form Edit Provinsi</h5>

            <form action="{{ route('provinsi.update', $provinsi->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="mb-3">
                    <label for="nama_provinsi" class="form-label">Nama Provinsi</label>
                    <input type="text" name="nama_provinsi" class="form-control" value="{{ old('nama_provinsi', $provinsi->nama_provinsi) }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('provinsi.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</section>
@endsection
