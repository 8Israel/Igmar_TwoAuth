@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h1>Hola, {{ Auth::user()->name }}</h1>
    
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <x-form-button text="Cerrar Sesión" color="danger" />
    </form>
@endsection
