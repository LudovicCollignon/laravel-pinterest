@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-center flex-wrap align-items-start">
            @foreach ($images as $image)
                <div class="image-container">
                    <a href="{{ route('image.show', $image->id) }}" class="image">
                        <img class="rounded m-1" src="<?php echo asset("storage/thumbs/$image->filename")?>"></img>
                    </a>
                    <a href="{{ route('image.create') }}" class="btn btn-danger btn-sm image-button display-none">Add</a>
                </div>
            @endforeach
    </div>
@endsection