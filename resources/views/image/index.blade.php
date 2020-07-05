@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-center flex-wrap align-items-start">
            @foreach ($images as $image)
                <img class="m-1" src="<?php echo asset("storage/thumbs/$image->filename")?>"></img>
            @endforeach
    </div>
@endsection