@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center flex-wrap align-items-start">
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif
@if (isset($images) && $images->isNotEmpty())
<div class="d-flex justify-content-center flex-wrap align-items-start">

    @foreach ($images as $image)
    <div class="image-container">
        <a href="{{ route('image.show', $image->id) }}" class="image">
            <img class="rounded m-1 img-fluid img-resp" src="{{ asset("storage/thumbs/$image->filename") }}"></img>
        </a>
        <button type="button" name="save-btn" class="btn btn-danger btn-sm image-button display-none" data-image="{{ $image->id }}" data-toggle="modal" data-target="#saveImageModal">
            Save
        </button>
    </div>
    @endforeach
    @else
    <div class="d-flex flex-column justify-content-between flex-wrap align-items-center">
        <div class="">Oups ! No image found</div>
        <a class="btn btn-dark my-3" href="{{ route('image.create') }}">Add image</a>
    </div>
    @endif
</div>
@endsection

<!-- saveImageModal -->
@isset ($image)
@isset ($boards)
<div class="modal fade" id="saveImageModal" tabindex="-1" role="dialog" aria-labelledby="saveImageModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card">
                <div class="card-header">Save image</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('image.save') }}" enctype="multipart/form-data" class="my-0">
                        @csrf
                        <div class="form-group">
                            <input class="form-control" id="image-input" name="image" type="text" hidden />
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
                            <input type="submit" value="Save" class="btn btn-dark" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endisset
@endisset

@section('script')
<script>
    $(document).ready(function() {
        var btns = document.getElementsByName("save-btn");
        var inputImage = document.getElementById("image-input");
        for (btn of btns) {
            btn.addEventListener('click', function(event) {
                var image = this.getAttribute('data-image');
                console.log(image)
                inputImage.value = image;
            });
        }
    });
</script>
@endsection