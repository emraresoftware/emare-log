@extends('layouts.app')
@section('title', 'E-Fatura Hataları')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0"><i class="fas fa-list me-2"></i>E-Fatura Hataları</h1>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped datatable" id="dataTable">
                    <thead class="table-dark">
                        <tr>
                                <th>#</th>
                                <th>Fatura No</th>
                                <th>Müşteri</th>
                                <th>Hata Kodu</th>
                                <th>Hata Mesajı</th>
                                <th>Tarih</th>
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