@extends('layout')

@section('content')
    <x-alert type="success">
        Gelukt! Je bericht is nu opgeslagen.
    </x-alert>
    <x-card title="Deel deze gegevens met je collega">
        @if (session('hasEmail'))
            <h6 class="card-subtitle mb-2 text-muted">Deze gegevens zullen ook naar je collega worden gemaild.</h6>
        @endif
        <div class="form-group">
            <label for="message">Link</label>
            <div class="input-group mb-3">
                <input
                    type="text"
                    class="form-control"
                    disabled
                    id="link"
                    aria-label="Link naar bericht"
                    aria-describedby="copy-link-button"
                    value="{{ route('messages.show', ['message' => session('messageRouteKey')]) }}"
                >
                <button class="btn btn-secondary" type="button" id="copy-link-button">Kopieer</button>
                <a
                    class="btn btn-success"
                    type="button"
                    href="{{ route('messages.show', ['message' => session('messageRouteKey')]) }}"
                >
                    Bezoek
                </a>
            </div>
        </div>
        <div class="form-group">
            <label for="message">Wachtwoord</label>
            <div class="input-group mb-3">
                <input
                    type="text"
                    class="form-control"
                    disabled
                    id="password"
                    aria-label="Link naar bericht"
                    aria-describedby="copy-password-button"
                    value="{{ session('password') }}"
                >
                <button class="btn btn-secondary" type="button" id="copy-password-button">Kopieer</button>
            </div>
        </div>
        <div class="form-text">Dit bericht kan 48 uur lang bekeken worden.</div>
    </x-card>
    <a class="btn btn-primary mt-3" href="{{ route('messages.create') }}">Versleutel nog een bericht</a>
@endsection

@push('scripts')
    <script>
        $(document).ready(() => {
            $('#copy-link-button').click(() => {
                navigator.clipboard.writeText('{{ session('message_url') }}');
            });

            $('#copy-password-button').click(() => {
                navigator.clipboard.writeText('{{ session('password') }}');
            });
        });
    </script>
@endpush
