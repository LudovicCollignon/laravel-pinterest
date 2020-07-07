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
                        @if ($errors->has('image'))
                        <div class="invalid-feedback">
                            {{ $errors->first('image') }}
                        </div>
                        @endif
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col d-flex flex-column justify-content-between">
                                    <label>Choose a file</label>
                                    <div class="custom-file">
                                        <input type="file" id="input-upload-image" name="image" class="{{ $errors->has('image') ? ' is-invalid ' : '' }}custom-file-input" required>
                                        <label class="custom-file-label my-0" for="image"></label>
                                    </div>
                                </div>
                                <div class="col">

                                    <label class="d-flex justify-content-between align-items-center">Add to a board <a class="btn btn-dark btn-sm" href="{{ route('board.create') }}">New board</a></label>

                                    <select name="board" class="form-control">
                                        <option value="" selected>...</option>
                                        @foreach ($boards as $board)
                                        <option value="{{ $board->id }}">{{ $board->name }}</option>
                                        @endforeach
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
                            <textarea name="description" rows="5" class="form-control" type="textarea" placeholder="Description"></textarea>
                        </div>

                        <div class="form-group">
                            <input data-role="tagsinput" id="tags" name="tags" class="form-control" type="text" placeholder="Tags">
                            <small class="form-text text-muted">Write tags separated by commas like 'lol,mdr,cul'</small>
                        </div>

                        <div class="form-group d-flex justify-content-between my-0">
                            <a class="btn btn-light" href="{{ url()->previous() }}">Back</a>
                            <input type="submit" class="btn btn-dark" />
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