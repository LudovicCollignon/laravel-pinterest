@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ $image->title }}</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <img class="rounded m-1" src="<?php echo asset("storage/images/$image->filename")?>"></img>
                        </div>
                        <div class="col-6 image-show-details">
                            <div image-show-buttons>
                                <a href="{{ route('image.download', $image->id) }}">
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-download" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M.5 8a.5.5 0 0 1 .5.5V12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V8.5a.5.5 0 0 1 1 0V12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V8.5A.5.5 0 0 1 .5 8z"/>
                                        <path fill-rule="evenodd" d="M5 7.5a.5.5 0 0 1 .707 0L8 9.793 10.293 7.5a.5.5 0 1 1 .707.707l-2.646 2.647a.5.5 0 0 1-.708 0L5 8.207A.5.5 0 0 1 5 7.5z"/>
                                        <path fill-rule="evenodd" d="M8 1a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-1 0v-8A.5.5 0 0 1 8 1z"/>
                                    </svg>
                                </a>
                                <a href="{{ route('image.create') }}" class="btn btn-danger btn-sm">Save</a>
                                <a href="{{ route('image.create') }}" class="btn btn-secondary btn-sm">Follow</a>
                            </div>
                            <div class="mt-5 pt-5">
                                <p class="mb-5">{{ $user->name }}</p>
                                <p>{{ $image->description }}</p>
                            </div>
                            <a class="btn btn-light" href="{{ url()->previous() }}">Back</a>
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
                    <img class="rounded m-1" src="<?php echo asset("storage/thumbs/$image->filename")?>"></img>
                </a>
                <a href="{{ route('image.create') }}" class="btn btn-danger btn-sm image-button display-none">Add</a>
            </div>
        @endforeach
    </div>
</div>
@endsection