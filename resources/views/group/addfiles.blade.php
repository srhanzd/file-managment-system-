@extends('layouts.app')

@section('content')
    <div class="container">

        <a href="{{route('user.group.files',$id)}}">

            <div class="row justify-content-center">
                <div class="col-md-8">
                    <button style="margin-bottom: 10px" class="btn btn-sm btn-primary">Back to Lists</button></a>
        <div class="card">
            <div class="card-header">Add files</div>

            <div class="card-body">
                <form method="POST" action="{{route('group.store.files',$id)}}">
                    @csrf

                                        <div class="form-group row"style="margin-top: 10px;margin-left: 20px;">
                                            <label for="groups" class="col-md-4 col-form-label text-md-right">files</label>

                                            <div class="col-md-6">

                                                <select multiple="multiple" name="files[]" id="files"class="form-control @error('files') is-invalid @enderror">
                                                    @foreach($files as  $file)

                                                            <option value="{{$file->id}}"selected="selected">{{$file->file_name}}</option>

                                                    @endforeach
                                                </select>
                                                @error('files')
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
