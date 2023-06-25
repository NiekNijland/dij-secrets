@extends('layout')

@section('content')
        @if($passwordSubmitted === true)
            <div class="alert alert-danger">
                Verkeerd wachtwoord ingevoerd!
            </div>
        @endif
        <div class="card mb-3 mx-auto">
            <div class="card-body">
                <h5 class="card-title">Vul het wachtwoord</h5>
                <form action="{{ route('messages.show', ['message' => $messageRouteKey]) }}" method="GET">
                    <div class="form-group">
                        <input class="form-control" type="text" name="password" placeholder="Voer wachtwoord in" aria-label="wachtwoord">
                    </div>
                    <button type="submit" class="btn btn-primary">Ontsleutel bericht</button>
                </form>
            </div>
        </div>
@endsection
