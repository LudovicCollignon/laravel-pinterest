@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">New board</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('board.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <input name="boardName" class="form-control" type="text" placeholder="Name">
                        </div>

                        <div class="form-group">
                            <textarea class="form-control" name="boardDescription" rows="5" placeholder="Description"></textarea>
                        </div>

                        <div class="form-group d-flex justify-content-between my-0">
                            <a class="btn btn-light" href="{{ route('home') }}">Cancel</a>
                            <input type="submit" value="Create" class="btn btn-dark" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection