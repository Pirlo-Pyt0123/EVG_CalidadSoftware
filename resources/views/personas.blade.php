<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Persona</title>
</head>
<body>
<h1>Registrar persona</h1>

@if (session('success'))
    <p>{{ session('success') }}</p>
@endif

@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="{{ route('personas.store') }}">
    @csrf
    <label>Nombres:</label>
    <input type="text" name="nombres" value="{{ old('nombres') }}" required><br>

    <label>Apellidos:</label>
    <input type="text" name="apellidos" value="{{ old('apellidos') }}" required><br>

    <label>Correo:</label>
    <input type="email" name="correo" value="{{ old('correo') }}" required><br>

    <label>Sexo:</label>
    <select name="sexo" required>
        <option value="">Selecciona</option>
        <option value="M" {{ old('sexo') === 'M' ? 'selected' : '' }}>M</option>
        <option value="F" {{ old('sexo') === 'F' ? 'selected' : '' }}>F</option>
    </select><br>

    <button type="submit">Guardar</button>
</form>

</body>
</html>
