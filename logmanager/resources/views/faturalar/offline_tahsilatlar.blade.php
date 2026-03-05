@extends('layouts.app')
@section('title', 'Offline Tahsilat Dosyaları')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0"><i class="fas fa-list me-2"></i>Offline Tahsilat Dosyaları</h1>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped datatable" id="dataTable">
                    <thead class="table-dark">
                        <tr>
                                <th>#</th>
                                <th>Dosya Adı</th>
                                <th>Yükleme Tarihi</th>
                                <th>Kayıt Sayısı</th>
                                <th>Durum</th>
                                <th>İşlem</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection