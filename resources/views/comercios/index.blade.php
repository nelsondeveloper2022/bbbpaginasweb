@extends('layouts.app')

@section('title', 'Comercios con página web activa')
@section('description', 'Descubre comercios con su página web activa en nuestra plataforma.')

@push('styles')
<style>
.card-commerce { border: none; box-shadow: 0 8px 20px rgba(0,0,0,.06); border-radius: 14px; overflow: hidden; }
.card-commerce .thumb { height: 160px; background: #f8f9fa; display:flex; align-items:center; justify-content:center; }
.card-commerce .thumb img { max-height: 120px; max-width: 90%; object-fit: contain; }
.card-commerce .body { padding: 1rem 1rem 1.25rem; }
.card-commerce .name { font-weight: 700; font-size: 1.1rem; margin-bottom: .25rem; }
.card-commerce .desc { color: #6c757d; font-size: .95rem; height: 48px; overflow: hidden; }
.search-bar { background: #fff; box-shadow: 0 6px 18px rgba(0,0,0,.05); border-radius: 12px; padding: 1rem; }
</style>
@endpush

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Comercios con página web activa</h1>
        <a href="{{ route('home') }}" class="btn btn-outline-secondary">Volver al inicio</a>
    </div>

    <form method="GET" action="{{ route('comercios.index') }}" class="search-bar mb-4">
        <div class="row g-2 align-items-end">
            <div class="col-md-6">
                <label class="form-label">Buscar</label>
                <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Nombre del comercio...">
            </div>
            <div class="col-md-3">
                <label class="form-label">Categoría</label>
                <input type="text" name="categoria" value="{{ request('categoria') }}" class="form-control" placeholder="Categoría">
            </div>
            <div class="col-md-3">
                <label class="form-label">Ciudad</label>
                <input type="text" name="ciudad" value="{{ request('ciudad') }}" class="form-control" placeholder="Ciudad">
            </div>
            <div class="col-12 mt-2">
                <button class="btn btn-primary">
                    <i class="bi bi-search me-1"></i> Buscar
                </button>
                <a href="{{ route('comercios.index') }}" class="btn btn-outline-secondary ms-2">Limpiar</a>
            </div>
        </div>
    </form>

    @if($comercios->count())
        <div class="row g-4">
            @foreach($comercios as $empresa)
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card-commerce">
                        <div class="thumb">
                            @if($empresa->landing && $empresa->landing->logo_url)
                                <img src="{{ asset('storage/' . $empresa->landing->logo_url) }}" alt="{{ $empresa->nombre }}"/>
                            @else
                                <img src="{{ asset('images/logo-bbb.png') }}" alt="{{ $empresa->nombre }}"/>
                            @endif
                        </div>
                        <div class="body">
                            <div class="name">{{ $empresa->nombre }}</div>
                            <div class="desc">{{ Str::limit($empresa->landing->descripcion ?? 'Sitio publicado en nuestra plataforma', 80) }}</div>
                            <div class="mt-3 d-grid">
                                <a href="{{ $empresa->getLandingUrl() }}" class="btn btn-sm btn-primary" target="_blank" rel="noopener noreferrer">
                                    <i class="bi bi-box-arrow-up-right me-1"></i> Ver página
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $comercios->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <i class="bi bi-building text-muted" style="font-size: 3rem;"></i>
            <p class="mt-3 text-muted">No se encontraron comercios activos.</p>
        </div>
    @endif
</div>
@endsection
