@extends('layouts.app')

@section('content')
    <div class="container">

        <a href="{{route('group.index')}}">

            <div class="row justify-content-center">
                <div class="col-md-8">
                    <button style="margin-bottom: 10px" class="btn btn-sm btn-primary">Back to Lists</button></a>
        <div class="card">
            <div class="card-header">Create Group</div>

            <div class="card-body">
                <form method="POST" action="{{route('group.store')}}">
                    @csrf

                    <div class="form-group row"style="margin-top: 10px">
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row"style="margin-top: 10px">
                        <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('description') }}</label>

                        <div class="col-md-6">
                            <input id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') }}" required autocomplete="name" autofocus>

                            @error('description')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-0 "style="margin-left: 218px ;margin-top: 10px">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                               Create
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
