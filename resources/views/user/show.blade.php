@extends('layouts.app')

@section('content')
<a href="{{ route('image.create') }}" class="btn btn-danger btn-sm">Add image</a>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <x-board-index :boards="$boards"/>
        </div>
    </div>
</div>
@endsection