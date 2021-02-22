@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    Gracias {{$user->name}} {{$user->last_name}} por confirmar tu email. <br>
                    Ahora como ultimo paso necesitamos que ingreses tu RUT, para una mayor seguridad en nuestro sitio.
                    <br>
                    Nuevo push
                    <i>(Solo con fines de administrar de mejor forma nuestros datos)</i>
                </div>
                <div class="card-body">
                    <almacenar-rut></almacenar-rut>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
