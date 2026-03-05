@extends('layouts.app')
@section('title', 'Personel Hakediş')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0"><i class="fas fa-list me-2"></i>Personel Hakediş</h1>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped datatable" id="dataTable">
                    <thead class="table-dark">
                        <tr>
                                <th>#</th>
                                <th>Personel</th>
                                <th>Dönem</th>
                                <th>Maaş</th>
                                <th>Prim</th>
                                <th>Kesinti</th>
                                <th>Net Ödeme</th>
                                <th>Durum</th>
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