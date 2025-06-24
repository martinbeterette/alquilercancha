@extends('base')

@section('title', 'Revisión de error')

@section('content')
    <div class="alert alert-warning border border-dark shadow-sm" role="alert">
    <h4 class="alert-heading">
        <i class="fas fa-exclamation-triangle me-2"></i> Se produjo un error
    </h4>
    <hr>

    @isset($message)
        <p class="mb-2"><strong>Mensaje:</strong> {{ $message }}</p>
    @endisset

    @if (!empty($errors) && is_array($errors))
        <div>
            <strong>Detalles:</strong>
            <ul class="mb-0">
                @foreach ($errors as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (isset($url) || isset($status))
        <hr>
        <p><strong>Status:</strong> {{ $status ?? 'N/D' }}</p>
        <p><strong>URL:</strong> {{ $url ?? 'N/D' }}</p>
    @endif

    <div class="mt-4 d-flex gap-2">
        <a href="{{ url('/') }}" class="btn btn-outline-primary">
            <i class="fas fa-home me-2"></i> Volver al inicio
        </a>

    </div>
</div>
@endsection
