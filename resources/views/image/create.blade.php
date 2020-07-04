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
                        <input name="title" class="form-control" type="text" placeholder="Title">
                        <input id="tags" name="tags" class="form-control" type="text" placeholder="Write tags separated by commas like 'lol,mdr,cul'">
                        <div class="form-group">
                            <img id="preview" class="img-fluid" src="#" alt="">
                        </div>
                        <a class="btn btn-light" href="{{ route('home') }}">Back</a>
                        <a class="btn btn-light" href="{{ route('image.index') }}">Images</a>
                        <input type="submit" class="btn btn-dark"/>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(() => {
        $('#input-upload-image').on('change', (e) => {
            let that = e.currentTarget
            if (that.files && that.files[0]) {
                $(that).next('.custom-file-label').html(that.files[0].name)
                let reader = new FileReader()
                reader.onload = (e) => {
                    $('#preview').attr('src', e.target.result)
                }
                reader.readAsDataURL(that.files[0])
            }
        })
    })
</script>
@endsection