@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Ton image</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('image.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group{{ $errors->has('image') ? ' is-invalid' : '' }}">
                            <div class="custom-file">
                                <input type="file" id="input-upload-image" name="image" class="{{ $errors->has('image') ? ' is-invalid ' : '' }}custom-file-input" required>
                                <label class="custom-file-label" for="image"></label>
                                @if ($errors->has('image'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('image') }}
                                </div>
                                @endif
                            </div>
                            <br>
                        </div>
                        <div class="form-group">
                            <img id="preview" class="img-fluid" src="#" alt="">
                        </div>
                        <a class="btn btn-light" href="{{ route('home') }}">Back</a>
                        <a class="btn btn-light" href="{{ route('image.index') }}">Images</a>
                        <input type="submit" class="btn btn-dark" />
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection