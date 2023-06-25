@extends('layout')

@section('content')
    <div class="card mb-3 mx-auto">
        <div class="card-body">
            <h5 class="card-title">Bekijk het bericht</h5>
            <div class="form-group">
                <label for="exampleInputEmail1">Bericht</label>
                <textarea class="form-control" rows="5" readonly aria-label="bericht">
                        {{ $decryptedContents }}
                    </textarea>
                <div class="form-text">Bericht geplaatst om: {{ $message->created_at->format('d/m/Y H:i:s') }}</div>
            </div>
            <div class="pt-2">
                <a class="btn btn-danger" id="destroy-message-button" dusk="delete-message">
                    Verwijder bericht
                </a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(() => {
            $('#destroy-message-button').click(() => {
                $.ajax({
                    url: '{{ route('messages.destroy', ['message' => $message, 'password' => $password]) }}',
                    type: 'DELETE',
                    data: {
                        '_token': '{{ @csrf_token() }}'
                    },
                    success: function() {
                        console.log('hoi');
                        window.location = '{{ route('messages.create') }}'
                    }
                });
            });
        })
    </script>
@endpush
