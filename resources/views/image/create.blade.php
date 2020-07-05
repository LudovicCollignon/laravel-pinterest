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

                        <div class="col">
                            @if ($errors->has('image'))
                            <div class="invalid-feedback">
                                {{ $errors->first('image') }}
                            </div>
                            @endif
                        </div>
                        <div class="form-group mb-0">
                            <div class="form-row">
                                <div class="col">
                                    <div class="custom-file">
                                        <input type="file" id="input-upload-image" name="image" class="{{ $errors->has('image') ? ' is-invalid ' : '' }}custom-file-input" required>
                                        <label class="custom-file-label" for="image"></label>
                                    </div>
                                </div>
                                <div class="col">
                                    <select id="inputState" class="form-control">
                                        <option value="" selected>Boards...</option>
                                        <option>Board1</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <img id="preview" class="img-fluid rounded mx-auto d-block" src="#" alt="">
                        </div>

                        <div class="form-group">
                            <input name="title" class="form-control" type="text" placeholder="Title">
                        </div>

                        <div class="form-group">
                            <input data-role="tagsinput" id="tags" name="tags" class="form-control" type="text" placeholder="Tags">
                            <small class="form-text text-muted">Write tags separated by commas like 'lol,mdr,cul'</small>
                        </div>

                        <div class="form-group d-flex justify-content-between my-0">
                            <a class="btn btn-light" href="{{ route('home') }}">Back</a>
                            <input type="submit" class="btn btn-dark" />
                        </div>
                </div>
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