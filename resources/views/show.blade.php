@extends('layout')

@section('content')
    <x-card title="Bekijk het bericht">
        <div class="form-group">
            <label for="exampleInputEmail1">Bericht</label>
            <textarea class="form-control" rows="5" readonly aria-label="bericht">
                        {{ $decryptedContents }}
                    </textarea>
            <div class="form-text">Bericht geplaatst om: {{ $messageTimestamp }}</div>
        </div>
        <div class="pt-2">
            <a class="btn btn-danger" id="destroy-message-button" dusk="delete-message">
                Verwijder bericht
            </a>
        </div>
    </x-card>
@endsection

@push('scripts')
    <script>
        $(document).ready(() => {
            $('#destroy-message-button').click(() => {
                $.ajax({
                    url: '{{ route('messages.destroy', ['message' => $messageRouteKey, 'password' => $password]) }}',
                    type: 'DELETE',
                    data: {
                        '_token': '{{ @csrf_token() }}'
                    },
                    success: function() {
                        window.location = '{{ route('messages.create') }}'
                    }
                });
            });
        })
    </script>
@endpush
