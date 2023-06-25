@extends('layout')

@section('content')
    <div class="card mb-3 mx-auto">
        <div class="card-body">
            <h5 class="card-title">Maak een bericht</h5>
            <form action="{{ route('messages.store') }}" method="post">
                {{ @csrf_field() }}
                <div class="form-group">
                    <label for="exampleInputEmail1">Bericht</label>
                    <textarea required name="message" class="form-control" rows="5"
                          placeholder="Plaats hier je bericht"></textarea>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Selecteer een collega (optioneel)</label>
                    <select name="colleague_email" class="form-control" aria-label="colleague email">
                        <option value="">Selecteer een collega</option>
                        @foreach($colleagues as $colleague)
                            <option value="{{ $colleague['email'] }}">{{ $colleague['name'] }}</option>
                        @endforeach
                    </select>
                    <small id="emailHelp" class="form-text text-muted">Selecteer een collega om het bericht gelijk te delen.</small>
                </div>
                <button type="submit" class="btn btn-primary">Versleutel bericht</button>
            </form>
        </div>
    </div>
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
