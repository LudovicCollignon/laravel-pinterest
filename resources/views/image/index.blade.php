@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center flex-wrap align-items-start">
    @if (isset($images) && $images->isNotEmpty())
    @foreach ($images as $image)
    <div class="image-container">
        <a href="{{ route('image.show', $image->id) }}" class="image">
            <img class="rounded m-1" src="<?php echo asset("storage/thumbs/$image->filename") ?>"></img>
        </a>
        <button type="button" class="btn btn-danger btn-sm image-button" data-toggle="modal" data-target="#saveImageModal">
            Save
        </button>
    </div>
    @endforeach
    @else
    <div class="d-flex flex-column justify-content-between flex-wrap align-items-center">
        <div class="">You don't have any images !</div>
        <a class="btn btn-dark my-3" href="{{ route('image.create') }}">Add image</a>
    </div>
    @endif
</div>
@endsection

<!-- Modal -->
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
                            <input class="form-control" name="image" value="{{ $image->id }}" type="text" hidden />
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