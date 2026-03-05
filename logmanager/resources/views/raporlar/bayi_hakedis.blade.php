@extends('layouts.app')
@section('title', 'Bayi Hakediş Raporu')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0"><i class="fas fa-list me-2"></i>Bayi Hakediş Raporu</h1>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped datatable" id="dataTable">
                    <thead class="table-dark">
                        <tr>
                                <th>#</th>
                                <th>Bayi</th>
                                <th>Dönem</th>
                                <th>Tahsilat</th>
                                <th>Komisyon %</th>
                                <th>Hakediş</th>
                                <th>Ödeme Durumu</th>
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