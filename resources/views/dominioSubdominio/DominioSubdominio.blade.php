@extends('base')

@section('content')
    <h1>Registrar Dominio y Subdominio</h1>

    {{-- Mensajes de éxito --}}
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    {{-- Formulario Dominio --}}
    <div style="margin-bottom: 30px;">
        <h2>Nuevo Dominio</h2>
        <form action="{{ route('dominio.store') }}" method="POST">
            @csrf
            <label>Descripción del Dominio:</label>
            <input type="text" name="descripcion_dominio" required>
            <button type="submit">Registrar Dominio</button>
        </form>
    </div>

    {{-- Formulario Subdominio --}}
    <div style="margin-bottom: 30px;">
        <h2>Nuevo Subdominio</h2>
        <form action="{{ route('subdominio.store') }}" method="POST">
            @csrf
            <label>Dominio:</label>
            <select name="id_dominio" required>
                <option value="">Seleccione un dominio</option>
                @foreach ($dominios as $dominio)
                    <option value="{{ $dominio->id_dominio }}">{{ $dominio->descripcion }}</option>
                @endforeach
            </select>

            <label>Descripción del Subdominio:</label>
            <input type="text" name="descripcion_subdominio" required>

            <button type="submit">Registrar Subdominio</button>
        </form>
    </div>

    {{-- Lista de Dominios y Subdominios --}}
    <div>
        <h2>Lista de Dominios y Subdominios</h2>
        @foreach ($dominios as $dominio)
            <h3>{{ $dominio->descripcion }}</h3>
            <ul>
                @foreach ($dominio->subdominios as $sub)
                    <li>{{ $sub->descripcion }}</li>
                @endforeach
            </ul>
        @endforeach
    </div>
@endsection
