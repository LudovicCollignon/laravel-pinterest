@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ $image->title }}</div>
                <div class="card-body p-0">
                    <div class="container">
                        <div class="row py-2">
                            <div class="col-sm-12 col-md-6 col-lg-6 py-2">
                                <div class="d-flex justify-content-center flex-wrap align-items-start">
                                    <a href="{{ route('image.show', $image->id) }}" class="image">
                                        <img class="rounded img-fluid" src="{{ asset("storage/thumbs/$image->filename") }}"></img>
                                    </a>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6 py-2 d-flex flex-column justify-content-between">
                                <div class="container mb-5 px-0">
                                    <div class="d-flex justify-content-between flex-wrap align-items-start">
                                        <p class="mb-5">Uploaded by <b>{{ $user->name }}</b></p>
                                        <a href="{{ route('image.create') }}" class="btn btn-secondary btn-sm">Follow</a>
                                    </div>

                                    <div class="d-flex justify-content-between flex-wrap align-items-start">
                                        <b>Description</b>
                                    </div>
                                    <div class="d-flex justify-content-between flex-wrap align-items-start">
                                        <p>{{ $image->description ?? '...' }}</p>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between flex-wrap align-items-end">
                                    <a class="btn btn-light" href="{{ route('home') }}">Back</a>
                                    <div class="d-flex justify-content-between flex-wrap align-items-end">
                                        <a href="{{ route('image.download', $image->id) }}" class="d-flex align-items-end px-3">
                                            <svg width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-download" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M.5 8a.5.5 0 0 1 .5.5V12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V8.5a.5.5 0 0 1 1 0V12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V8.5A.5.5 0 0 1 .5 8z" />
                                                <path fill-rule="evenodd" d="M5 7.5a.5.5 0 0 1 .707 0L8 9.793 10.293 7.5a.5.5 0 1 1 .707.707l-2.646 2.647a.5.5 0 0 1-.708 0L5 8.207A.5.5 0 0 1 5 7.5z" />
                                                <path fill-rule="evenodd" d="M8 1a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-1 0v-8A.5.5 0 0 1 8 1z" />
                                            </svg>
                                        </a>
                                        <button type="button" name="save-btn" class="btn btn-danger btn-sm" data-image="{{ $image->id }}" data-toggle="modal" data-target="#saveImageModal">
                                            Save
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mt-5">
    <h4 class="d-flex justify-content-center">More similar content</h4>
    <div class="d-flex justify-content-center flex-wrap align-items-start">
        @foreach ($images as $image)
        <div class="image-container">
            <a href="{{ route('image.show', $image->id) }}" class="image">
                <img class="rounded m-1 img-fluid img-resp" src="{{ asset("storage/thumbs/$image->filename") }}"></img>
            </a>
            <button type="button" class="btn btn-danger btn-sm image-button display-none" data-toggle="modal" data-target="#saveImageModal">
                Save
            </button>
        </div>
        @endforeach
    </div>
</div>
@endsection

<!-- saveImageModal -->
@isset ($image)
<div class="modal fade" id="saveImageModal" tabindex="-1" role="dialog" aria-labelledby="saveImageModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card">
                <div class="card-header">Save image</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('image.save') }}" enctype="multipart/form-data" class="my-0">
                        @csrf
                        <div class="form-group">
                            <input class="form-control" id="image-input" name="image" value="{{ $image->id }}" type="text" hidden />
                        </div>
                        <div class="form-group">
                            <select name="board" class="form-control">
                                <option value="" selected>Boards...</option>
                                @foreach ($boards as $board)
                                <option value="{{ $board->id }}">{{ $board->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group d-flex justify-content-between my-0">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-dark" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endisset

@section('script')
<script>
    $(document).ready(function() {
        var btns = document.getElementsByName("save-btn");
        var inputImage = document.getElementById("image-input");
        for (btn of btns) {
            btn.addEventListener('click', function(event) {
                var image = this.getAttribute('data-image');
                inputImage.value = image;
            });
        }
    });
</script>
@endsection