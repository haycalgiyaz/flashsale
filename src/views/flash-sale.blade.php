@extends('mineralcms.flashsale.views.app')
@section('content')
    @if(isset($flash))
        <h3>Edit : </h3>
        {!! Form::model($flash, ['route' => ['flash.update', $flash->id], 'method' => 'patch']) !!}
    @else
        <h3>Add New Task : </h3>
        {!! Form::open(['route' => 'flash.store']) !!}
    @endif
        <div class="form-inline">
            <div class="form-group">
                {!! Form::text('name',null,['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::submit($submit, ['class' => 'btn btn-primary form-control']) !!}
            </div>
        </div>
    {!! Form::close() !!}
    <hr>
    <h4>Tasks To Do : </h4>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($flashs as $flash)
                <tr>
                    <td>{{ $flash->name }}</td>
                    <td>
                        {!! Form::open(['route' => ['flash.destroy', $flash->id], 'method' => 'delete']) !!}
                            <div class='btn-group'>
                                <a href="{!! route('flash.edit', [$flash->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                                {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                            </div>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection