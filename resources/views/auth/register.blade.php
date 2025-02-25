@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header text-center bg-success text-white">
                    <h4>Registro</h4>
                </div>
                <div class="card-body">
                    <x-validation-errors />
                    <form action="{{ route('register.submit') }}" method="POST">
                        @csrf
                        <x-form-input type="text" name="name" label="Nombre" />
                        <x-form-input type="email" name="email" label="Correo Electrónico" />
                        <x-form-input type="password" name="password" label="Contraseña" />
                        <x-form-input type="password" name="password_confirmation" label="Confirmar Contraseña" />
                        <x-captcha />
                        <x-form-button text="Registrarse" color="success" />
                    </form>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('login') }}" class="text-decoration-none">¿Ya tienes cuenta? Inicia sesión</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
