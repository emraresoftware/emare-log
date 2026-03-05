@extends('layouts.app')
@section('title', 'E-Devlet Başvuruları')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0"><i class="fas fa-list me-2"></i>E-Devlet Başvuruları</h1>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped datatable" id="dataTable">
                    <thead class="table-dark">
                        <tr>
                                <th>#</th>
                                <th>TC Kimlik</th>
                                <th>Ad Soyad</th>
                                <th>Başvuru No</th>
                                <th>Tarih</th>
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