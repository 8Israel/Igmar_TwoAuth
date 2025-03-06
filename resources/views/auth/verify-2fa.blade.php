<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificación en dos pasos</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header text-center bg-primary text-white">
                        <h4>Verificación en dos pasos</h4>
                    </div>
                    <div class="card-body">
                        <!-- Mostrar errores -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Formulario -->
                        <form action="{{ route('2fa.verify') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="2fa_code" class="form-label">Código de verificación</label>
                                <input type="text" id="2fa_code" name="2fa_code" class="form-control" required>
                            </div>
                            <x-captcha />
                            <button type="submit" class="btn btn-primary w-100">Verificar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
