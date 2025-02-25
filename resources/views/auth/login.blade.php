@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header text-center bg-primary text-white">
                    <h4>Iniciar Sesión</h4>
                </div>
                <div class="card-body">
                    <x-validation-errors />
                    <form action="{{ route('login.submit') }}" method="POST">
                        @csrf
                        <x-form-input type="email" name="email" label="Correo Electrónico" />
                        <x-form-input type="password" name="password" label="Contraseña" />
                        <x-captcha />
                        <x-form-button text="Iniciar Sesión" color="primary" />
                    </form>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('register') }}" class="text-decoration-none">¿No tienes cuenta? Regístrate aquí</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
