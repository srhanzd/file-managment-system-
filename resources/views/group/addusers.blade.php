@extends('layouts.app')

@section('content')
    <div class="container">

        <a href="{{route('group.users',$id)}}">

            <div class="row justify-content-center">
                <div class="col-md-8">
                    <button style="margin-bottom: 10px" class="btn btn-sm btn-primary">Back to Lists</button></a>
        <div class="card">
            <div class="card-header">Add users</div>

            <div class="card-body">
                <form method="POST" action="{{route('group.store.users',$id)}}">
                    @csrf

                                        <div class="form-group row"style="margin-top: 10px;margin-left: 20px;">
                                            <label for="groups" class="col-md-4 col-form-label text-md-right">users</label>

                                            <div class="col-md-6">

                                                <select multiple="multiple" name="users[]" id="users"class="form-control @error('users') is-invalid @enderror">
                                                    @foreach($users as  $user)

                                                            <option value="{{$user->id}}"selected="selected">{{$user->name}}</option>

                                                    @endforeach
                                                </select>
                                                @error('users')
                                                <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                @enderror
                                            </div>
                                        </div>
                        <div  class="col-md-6 offset-md-7">
                            <button type="submit" class="btn btn-primary">
                               Add
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    </div>
@endsection
