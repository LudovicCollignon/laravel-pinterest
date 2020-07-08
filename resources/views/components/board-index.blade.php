<div class="card">
    <div class="card-header">Boards</div>
    <div class="card-body">
        @if (isset($boards) && $boards->isNotEmpty())
        <ul class="list-group list-group-flush">
            @foreach ($boards as $board)
            <li class="list-group-item">
                <a href="{{ route('board.show', ['user_name' => $user->name, 'board_id' => $board->id, 'board_name' => $board->name]) }}" class="text-dark">{{ $board->name }}</a>
            </li>
            @endforeach
        </ul>
        @else
        <div class="d-flex flex-column justify-content-between flex-wrap align-items-center">
            <div class="">There is no boards !</div>
            @if ($user->name == Auth::user()->name)
                <a class="btn btn-dark mt-3" href="{{ route('board.create') }}">Add board</a>
            @endif
        </div>
        @endif
    </div>
</div>