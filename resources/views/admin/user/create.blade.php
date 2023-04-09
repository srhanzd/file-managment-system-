@extends('layouts.app')

@section('content')
    <div class="container">

        <a href="{{route('user.index')}}">

            <div class="row justify-content-center">
                <div class="col-md-8">
                    <button style="margin-bottom: 10px" class="btn btn-sm btn-primary">Back to Lists</button></a>
        <div class="card">
            <div class="card-header">Create User</div>

            <div class="card-body">
                <form method="POST" action="{{route('user.store')}}">
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
                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row"style="margin-top: 10px">
                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

{{--                    <div class="form-group row"style="margin-top: 10px">--}}
{{--                        <label for="groups" class="col-md-4 col-form-label text-md-right">Groups</label>--}}

{{--                        <div class="col-md-6">--}}

{{--                            <select multiple="multiple" name="groups[]" id="groups"class="form-control @error('groups') is-invalid @enderror">--}}
{{--                                @foreach($groups as  $group)--}}

{{--                                        <option value="{{$group->id}}"selected="selected">{{$group->name}}</option>--}}

{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                            @error('groups')--}}
{{--                            <span class="invalid-feedback" role="alert">--}}
{{--                                            <strong>{{ $message }}</strong>--}}
{{--                                        </span>--}}
{{--                            @enderror--}}
{{--                        </div>--}}
{{--                    </div>--}}

                    <div class="form-group row"style="margin-top: 10px">
                        <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
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
