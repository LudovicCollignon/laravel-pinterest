@extends('layouts.app')

@section('content')
@unless ($user->id == Auth::id())
    <a href="{{ route($isFollowed ? 'user.unfollow' : 'user.follow', $user) }}" class="btn btn-sm {{ $isFollowed ? 'btn-outline-secondary' : 'btn-secondary' }}">{{ $isFollowed ? 'Unfollow' : 'Follow' }}</a>
@endunless
<div class="d-flex row justify-content-center">
    <a name="follows-btn" data-toggle="modal" data-follow="Followers" data-userid="{{ $user->id }}" data-target="#showUserFollowers" href="{{ route('image.create') }}" class="mr-5"><b>{{ $user->followers->count() }} </b>{{ Str::plural('follower', $user->followers->count()) }}</a>
    <a name="follows-btn" data-toggle="modal" data-follow="Followees" data-userid="{{ $user->id }}" data-target="#showUserFollowees" href="{{ route('image.create') }}" class="mb-3"><b>{{ $user->followees->count() }} </b>{{ Str::plural('followee', $user->followees->count()) }}</a>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <x-board-index :boards="$boards" :user="$user"/>
        </div>
    </div>
</div>

<div class="modal fade" id="showUserFollowees" tabindex="-1" role="dialog" aria-labelledby="showUserFollowLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card">
                <div class="card-header">Followees</div>
                <div class="card-body">
                    @if ($user->followees->count() != 0)
                        @foreach ($user->followees()->get()->all() as $followee)
                            <a class="text-dark" href="{{ route('user.show', $followee->name) }}" >{{ $followee->name }}</a>
                        @endforeach
                    @else
                        No followees
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="showUserFollowers" tabindex="-1" role="dialog" aria-labelledby="showUserFollowLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card">
                <div class="card-header">Followers</div>
                <div class="card-body">
                    @if ($user->followers->count() != 0)
                        @foreach ($user->followers()->get()->all() as $follower)
                            <a class="text-dark" href="{{ route('user.show', $follower->name) }}" >{{ $follower->name }}</a>
                        @endforeach
                    @else
                        No followers
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection