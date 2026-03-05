@extends('layouts.app')
@section('title', 'Teknik Servis Raporu')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0"><i class="fas fa-list me-2"></i>Teknik Servis Raporu</h1>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped datatable" id="dataTable">
                    <thead class="table-dark">
                        <tr>
                                <th>#</th>
                                <th>Tarih</th>
                                <th>Müşteri</th>
                                <th>Servis Tipi</th>
                                <th>Teknisyen</th>
                                <th>Durum</th>
                                <th>Süre</th>
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