{{-- Müşteri Filtreleri Partial --}}
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('musteriler.index') }}" id="filterForm">
            <div class="row g-3 align-items-end">
                <div class="col-md-2">
                    <label for="durum" class="form-label">Durum</label>
                    <select class="form-select" id="durum" name="durum">
                        <option value="">Tümü</option>
                        <option value="aktif" {{ request('durum') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="pasif" {{ request('durum') === 'pasif' ? 'selected' : '' }}>Pasif</option>
                        <option value="iptal" {{ request('durum') === 'iptal' ? 'selected' : '' }}>İptal</option>
                        <option value="dondurulmus" {{ request('durum') === 'dondurulmus' ? 'selected' : '' }}>Dondurulmuş</option>
                        <option value="potansiyel" {{ request('durum') === 'potansiyel' ? 'selected' : '' }}>Potansiyel</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="tarife_id" class="form-label">Tarife</label>
                    <select class="form-select select2" id="tarife_id" name="tarife_id">
                        <option value="">Tüm Tarifeler</option>
                        @foreach($tarifeler ?? [] as $tarife)
                            <option value="{{ $tarife->id }}" {{ request('tarife_id') == $tarife->id ? 'selected' : '' }}>{{ $tarife->ad }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="bolge_id" class="form-label">Bölge</label>
                    <select class="form-select select2" id="bolge_id" name="bolge_id">
                        <option value="">Tüm Bölgeler</option>
                        @foreach($bolgeler ?? [] as $bolge)
                            <option value="{{ $bolge->id }}" {{ request('bolge_id') == $bolge->id ? 'selected' : '' }}>{{ $bolge->ad }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="arama" class="form-label">Arama</label>
                    <input type="text" class="form-control" id="arama" name="arama" value="{{ request('arama') }}" placeholder="Abone no, ad soyad, TC, IP...">
                </div>
                <div class="col-md-2">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-fill">
                            <i class="fas fa-search me-1"></i> Filtrele
                        </button>
                        <a href="{{ route('musteriler.index') }}" class="btn btn-outline-secondary" title="Sıfırla">
                            <i class="fas fa-undo"></i>
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
