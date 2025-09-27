@extends('layouts.app')

@section('title', $info['title'])
@section('description', $info['description'])

@push('styles')
<style>
    .legal-hero {
        background: linear-gradient(135deg, var(--primary-red) 0%, var(--primary-gold) 100%);
        padding: 6rem 0 3rem;
        color: white;
        text-align: center;
    }

    .legal-hero h1 {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 1rem;
    }

    .legal-hero p {
        font-size: 1.2rem;
        opacity: 0.9;
    }

    .legal-content {
        line-height: 1.8;
    }

    .legal-content h2 {
        color: var(--primary-red);
        font-weight: 700;
        margin-top: 2.5rem;
        margin-bottom: 1.5rem;
    }

    .legal-content h3 {
        color: var(--dark-gray);
        font-weight: 600;
        margin-top: 2rem;
        margin-bottom: 1rem;
    }

    .legal-content p {
        margin-bottom: 1.2rem;
        color: var(--dark-gray);
    }

    .legal-content ul {
        margin-bottom: 1.5rem;
    }

    .legal-content li {
        margin-bottom: 0.5rem;
        color: var(--dark-gray);
    }

    .last-updated {
        background: var(--light-gray);
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 2rem;
        font-style: italic;
        color: var(--medium-gray);
    }

    .cookie-table {
        width: 100%;
        border-collapse: collapse;
        margin: 1.5rem 0;
    }

    .cookie-table th,
    .cookie-table td {
        border: 1px solid var(--light-gray);
        padding: 0.75rem;
        text-align: left;
    }

    .cookie-table th {
        background-color: var(--light-gray);
        font-weight: 600;
        color: var(--primary-red);
    }

    .cookie-table td {
        color: var(--dark-gray);
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="legal-hero">
    <div class="container">
        <h1>{{ $info['hero_title'] }}</h1>
        <p>{{ $info['hero_subtitle'] }}</p>
    </div>
</section>

<!-- Content Section -->
<section class="legal-content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="last-updated">
                    <strong>Última actualización:</strong> {{ date('d/m/Y') }}
                </div>
            </div>
        </div>
    </div>
</section>

@if($content && !empty(trim($content)))
    <div class="legal-body">
        {!! $content !!}
    </div>
@else
    <div class="text-center py-4">
        <i class="fas fa-info-circle text-muted mb-3" style="font-size: 3rem;"></i>
        <h5 class="text-muted">Contenido no disponible</h5>
        <p class="text-muted">Este contenido aún no ha sido configurado.</p>
    </div>
@endif
@endsection