@extends('layout')

@section('content')
    <x-card title="Maak een bericht">

        <form action="{{ route('messages.store') }}" method="post">
            {{ @csrf_field() }}
            <div class="form-group">
                <label for="message">Bericht</label>
                <textarea id="message" required name="message" class="form-control" rows="5" dusk="message"
                          placeholder="Plaats hier je bericht"></textarea>
            </div>
            <div class="form-group">
                <label for="colleague_email">Selecteer een collega (optioneel)</label>
                <select id="colleague_email" name="colleague_email" class="form-control" aria-label="colleague email">
                    <option value="">Selecteer een collega</option>
                    @foreach($colleagues as $colleague)
                        <option value="{{ $colleague['email'] }}">{{ $colleague['name'] }}</option>
                    @endforeach
                </select>
                <small id="emailHelp" class="form-text text-muted">Selecteer een collega om het bericht gelijk te delen.</small>
            </div>
            <button type="submit" class="btn btn-primary" dusk="encrypt-message">Versleutel bericht</button>
        </form>
    </x-card>
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
