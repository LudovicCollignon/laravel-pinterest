@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-center flex-wrap align-items-start">
            @foreach ($images as $image)
                <div class="image-container">
                    <img class="rounded m-1 image" src="<?php echo asset("storage/thumbs/$image->filename")?>"></img>
                    <a href="{{ route('image.create') }}" class="btn btn-danger btn-sm image-button">Enregistrer</a>
                </div>
            @endforeach
    </div>
@endsection