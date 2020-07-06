@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">{{ $board->name }}</div>

                <div class="card-body">
                    <div class="d-flex justify-content-center flex-wrap align-items-start">
                        @if (isset($images) && $images->isNotEmpty())
                        @foreach ($images as $image)
                        <div class="image-container">
                            <a href="{{ route('image.show', $image->id) }}" class="image">
                                <img class="rounded m-1" src="<?php echo asset("storage/thumbs/$image->filename") ?>"></img>
                            </a>
                        </div>
                        @endforeach
                        @else
                        <div class="d-flex flex-column justify-content-between flex-wrap align-items-center">
                            <div class="">Your board is empty, add some image.</div>
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