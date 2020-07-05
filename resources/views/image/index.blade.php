@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Images</div>

                <div class="card-body">
                        @foreach ($images as $image)
                            <img src="{{ Storage::url("thumbs/{$image->filename}") }}" alt="{{ $image->title }}" />
                        @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection