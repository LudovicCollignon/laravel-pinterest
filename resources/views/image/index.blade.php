@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
                @foreach ($images as $image)
                    <img src="<?php echo asset("storage/thumbs/$image->filename")?>"></img>
                @endforeach
        </div>
    </div>
@endsection