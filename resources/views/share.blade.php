@extends('layout')

@section('content')
    <div class="alert alert-success">
        Gelukt! Je bericht is nu opgeslagen.
    </div>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Deel deze gegevens met je collega</h5>
            @if (session('hasEmail'))
                <h6 class="card-subtitle mb-2 text-muted">Deze gegevens zullen ook naar je collega worden gemaild.</h6>
            @endif
            <div class="input-group mb-3">
                <input
                    type="text"
                    class="form-control"
                    disabled
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
            <div class="input-group mb-3">
                <input type="text" class="form-control" disabled aria-label="Link naar bericht" aria-describedby="copy-password-button" value="{{ session('password') }}">
                <button class="btn btn-secondary" type="button" id="copy-password-button">Kopieer</button>
            </div>
            <div class="form-text">Dit bericht kan 48 uur lang bekeken worden.</div>
        </div>
    </div>
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
