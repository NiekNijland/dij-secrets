@extends('layout')

@section('content')
        @if($passwordSubmitted === true)
            <x-alert type="danger">
                Verkeerd wachtwoord ingevoerd!
            </x-alert>
        @endif
        <x-card title="Vul het wachtwoord in">
            <form action="{{ route('messages.show', ['message' => $messageRouteKey]) }}" method="GET">
                <div class="form-group">
                    <input class="form-control" type="text" name="password" placeholder="Voer wachtwoord in" aria-label="wachtwoord" dusk="password">
                </div>
                <button type="submit" class="btn btn-primary" dusk="show-message">Ontsleutel bericht</button>
            </form>
        </x-card>
@endsection
