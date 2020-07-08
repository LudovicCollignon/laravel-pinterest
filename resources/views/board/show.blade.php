@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justofy-content-between align-items-center">
                    <a href="{{ url()->previous() }}" class="d-flex align-items-end px-3 mr-3">
                        <svg width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-arrow-left-short" fill="black" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M7.854 4.646a.5.5 0 0 1 0 .708L5.207 8l2.647 2.646a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 0 1 .708 0z" />
                            <path fill-rule="evenodd" d="M4.5 8a.5.5 0 0 1 .5-.5h6.5a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5z" />
                        </svg>
                    </a>
                    <b>{{ $board->name }}</b>
                </div>

                <div class="card-body">
                    <div class="d-flex justify-content-center flex-wrap align-items-start">
                        @if (isset($images) && $images->isNotEmpty())
                        @section('script')
                        <script>
                            $(document).ready(function() {
                                var btns = document.getElementsByName("follows-btn");
                                var modalHeader = document.getElementById('modal-header');
                                for (btn of btns) {
                                    btn.addEventListener('click', function(event) {
                                        var title = this.getAttribute('data-follow');
                                        modalHeader.innerHTML = title;
                                    });
                                }
                            });
                        </script>
                        @endsection
                        @foreach ($images as $image)
                        <div class="image-container">
                            <a href="{{ route('image.show', $image->id) }}" class="image">
                                <img class="rounded m-1 img-fluid img-resp" src="{{ asset("storage/thumbs/$image->filename") }}"></img>
                            </a>
                            @if ($user->name == Auth::user()->name)
                            <button type="button" name="remove-btn" class="btn btn-danger btn-sm image-button display-none" data-image="{{ $image->id }}" data-board="{{ $board->id }}" data-toggle="modal" data-target="#removeImageModal">
                                Remove
                            </button>
                            @endif
                        </div>
                        @endforeach
                        @else
                        <div class="d-flex flex-column justify-content-between flex-wrap align-items-center">
                            <div class="">The board is empty.</div>
                            <a class="btn btn-dark mt-3" href="{{ route('home') }}">Save images</a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- removeImageFromBoardModal -->
@isset ($image)
<div class="modal fade" id="removeImageModal" tabindex="-1" role="dialog" aria-labelledby="removeImageModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card">
                <div class="card-header">Remove image</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('board.remove.image') }}" enctype="multipart/form-data" class="my-0">
                        @csrf
                        <input class="form-control" id="image-input" name="image" value="{{ $image->id }}" type="text" hidden />
                        <input class="form-control" id="board-input" name=" board" value="{{ $board->id }}" type="text" hidden />

                        <div class="d-flex flex-column justify-content-between flex-wrap align-items-center">
                            <div class="pb-4">Do you want to remove this image from the board ?<b>{{ $board->name }}</b></div>
                        </div>

                        <div class="form-group d-flex justify-content-between my-0">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <input type="submit" class="btn btn-dark" value="Remove" />
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
        var btns = document.getElementsByName("remove-btn");
        var inputImage = document.getElementById("image-input");
        var inputBoard = document.getElementById("board-input");
        for (btn of btns) {
            btn.addEventListener('click', function(event) {
                var image = this.getAttribute('data-image');
                var board = this.getAttribute('data-board');
                inputImage.value = image;
                inputBoard.value = board;
            });
        }
    });
</script>
@endsection