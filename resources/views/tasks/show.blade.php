@extends('layouts.app')

@section('content')
    <h1>id = {{ $task->id }} のメッセージ詳細ページ</h1>
    <p>状態: {{ $task->status }}</p>
    <p>タスク: {{ $task->content }}</p>
    {!! link_to_route('tasks.edit', 'このタスクの編集', ['id' => $task->id]) !!}
    
    {!! Form::model($task, ['route' => ['tasks.destroy', $task->id], 'method' => 'delete']) !!}
        {!! Form::submit('削除') !!}
    {!! Form::close() !!}
@endsection