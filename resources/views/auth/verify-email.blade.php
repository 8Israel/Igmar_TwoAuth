<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifica tu correo</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header text-center bg-warning text-white">
                        <h4>Verifica tu correo electrónico</h4>
                    </div>
                    <div class="card-body text-center">
                        <p>Hemos enviado un enlace de verificación a tu correo electrónico.</p>
                        <p>Por favor, revisa tu bandeja de entrada y haz clic en el enlace para continuar.</p>

                        <!-- Botón para reenviar el correo de verificación -->
                        <form action="{{ route('verification.resend') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary">Reenviar enlace de verificación</button>
                        </form>

                        @if (session('status') == 'verification-link-sent')
                            <div class="alert alert-success mt-3">
                                Se ha enviado un nuevo enlace de verificación a tu correo.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
