<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CRUD de Gestiones</title>
</head>
<body>

    @if (isset($gestionToEdit))
        {{-- FORMULARIO DE EDICIÓN --}}
        <h2>Editar Gestión #{{ $gestionToEdit->id_gestion }}</h2>
        <form action="{{ route('gestiones.update', ['gestione' => $gestionToEdit]) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div>
                <label for="num_resolucion">N° Resolución:</label><br>
                <input type="text" name="num_resolucion" value="{{ old('num_resolucion', $gestionToEdit->num_resolucion) }}">
            </div>
            <br>
            <div>
                <label for="desc_gestion">Descripción:</label><br>
                <textarea name="desc_gestion">{{ old('desc_gestion', $gestionToEdit->desc_gestion) }}</textarea>
            </div>
            <br>
            <div>
                <label for="fecha_inicio">Fecha Inicio:</label><br>
                <input type="date" name="fecha_inicio" value="{{ old('fecha_inicio', $gestionToEdit->fecha_inicio->format('Y-m-d')) }}">
            </div>
            <br>
            <div>
                <label for="fecha_final">Fecha Final:</label><br>
                <input type="date" name="fecha_final" value="{{ old('fecha_final', $gestionToEdit->fecha_final->format('Y-m-d')) }}">
            </div>
            <br>
            <button type="submit">Actualizar</button>
            <a href="{{ route('gestiones.index') }}">Cancelar</a>
        </form>
    @else
        <h2>Crear Nueva Gestión</h2>
        <form action="{{ route('gestiones.store') }}" method="POST">
            @csrf
            
            <div>
                <label for="num_resolucion">N° Resolución:</label><br>
                <input type="text" name="num_resolucion" value="{{ old('num_resolucion') }}">
            </div>
            <br>
            <div>
                <label for="desc_gestion">Descripción:</label><br>
                <textarea name="desc_gestion">{{ old('desc_gestion') }}</textarea>
            </div>
            <br>
            <div>
                <label for="fecha_inicio">Fecha Inicio:</label><br>
                <input type="date" name="fecha_inicio" value="{{ old('fecha_inicio') }}">
            </div>
            <br>
            <div>
                <label for="fecha_final">Fecha Final:</label><br>
                <input type="date" name="fecha_final" value="{{ old('fecha_final') }}">
            </div>
            <br>
            <button type="submit">Guardar</button>
        </form>
    @endif
    
    @if ($errors->any())
        <div style="color: red; border: 1px solid red; padding: 10px; margin: 20px 0;">
            <strong>¡Errores!</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <hr style="margin: 40px 0;">


    <h2>Lista de Gestiones</h2>

    @if (session('success'))
        <div style="color: green; border: 1px solid green; padding: 10px; margin: 10px 0;">
            {{ session('success') }}
        </div>
    @endif

    <table border="1" style="width:100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th>ID</th>
                <th>N° Resolución</th>
                <th>Descripción</th>
                <th>Fecha Inicio</th>
                <th>Fecha Final</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($gestiones as $gestion)
                <tr>
                    <td>{{ $gestion->id_gestion }}</td>
                    <td>{{ $gestion->num_resolucion }}</td>
                    <td>{{ $gestion->desc_gestion }}</td>
                    <td>{{ $gestion->fecha_inicio->format('d/m/Y') }}</td>
                    <td>{{ $gestion->fecha_final->format('d/m/Y') }}</td>
                    <td>
                        {{-- El enlace a 'edit' recargará esta misma página en modo edición --}}
                        <a href="{{ route('gestiones.edit', $gestion) }}">Editar</a>
                        
                        <form action="{{ route('gestiones.destroy', $gestion) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('¿Estás seguro?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No hay gestiones registradas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        {{ $gestiones->links() }}
    </div>

</body>
</html>