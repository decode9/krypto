@extends('layouts.backend')

@section('content')
<div class="backTitle">
    <h2>Posts</h2>
</div>
<div class="TableInfo">
    <table class="backTable">
        <thead>
            <tr>
                <th>Picture</th>
                <th>Created By</th>
                <th>Name</th>
                <th>Content</th>
                <th>Created At</th>
                <th>Last Modified</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($posts as $post)
                <tr>
                    <td class="imgPreview"><img src="{{$post->picture_path}}" width="" height="" alt=""></td>
                    <td>{{$post->user->name}}</td>
                    <td>{{$post->name}}</td>
                    <td>{{$post->content}}</td>
                    <td>{{$post->created_at}}</td>
                    <td>{{$post->updated_at}}</td>
                    <td><a href="{{route('edit.news', $post->id)}}"><button type="button">Edit</button></a><br/><a href="{{route('destroy.news', $post->id)}}"><button>Delete</button></a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
