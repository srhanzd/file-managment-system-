<!DOCTYPE html>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('s') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    You're logged in!
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Form</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

    <style>
        body {
            color: #999;
            background: #f5f5f5;
            font-family: 'Roboto', sans-serif;
        }
        .form-control, .form-control:focus, .input-group-addon {
            border-color: #e1e1e1;
            border-radius: 0;
        }
        .signup-form {
            width: 50%;
            margin: 0 auto;
            padding: 30px 0;
        }
        .signup-form h2 {
            color: #636363;
            margin: 0 0 15px;
            text-align: center;
        }
        .signup-form .lead {
            font-size: 14px;
            margin-bottom: 30px;
            text-align: center;
        }
        .signup-form form {
            border-radius: 1px;
            margin-bottom: 15px;
            background: #fff;
            border: 1px solid #f3f3f3;
            box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
            padding: 30px;
        }
        .signup-form .form-group {
            margin-bottom: 20px;
        }
        .signup-form label {
            font-weight: normal;
            font-size: 13px;
        }
        .signup-form .form-control {
            min-height: 38px;
            box-shadow: none !important;
            border-width: 0 0 1px 0;
        }
        .signup-form .input-group-addon {
            max-width: 42px;
            text-align: center;
            background: none;
            border-bottom: 1px solid #e1e1e1;
            padding-left: 5px;
        }
        .signup-form .btn, .signup-form .btn:active {
            font-size: 16px;
            font-weight: bold;
            background: #0096FF	 !important;
            border-radius: 3px;
            border: none;
            min-width: 140px;
        }
        .signup-form .btn:hover, .signup-form .btn:focus {
            background:#ADD8E6 !important;
        }
        .signup-form a {
            color: #0000FF	;
            text-decoration: none;
        }
        .signup-form a:hover {
            text-decoration: underline;
        }
        .signup-form .fa {
            font-size: 21px;
            position: relative;
            top: 8px;
        }

    </style>
</head>
<body>
@if($number_of_files<config('userfilesnumber.number')||auth()->user()->id==1)
<div class="signup-form">
    <form action="{{ route('file.save') }}" method="post" enctype="multipart/form-data">
        @csrf
        <h2>File Upload</h2>
        <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-cloud-upload"></i></span>
                <input type="file" class="form-control" name="fileupload[]" required="required" multiple>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block btn-lg">Save</button>

        </div>
    </form>
{{--    @if(session()->has('message'))--}}
{{--        <div class="alert alert-danger">--}}
{{--            {{ session()->get('message') }}--}}
{{--        </div>--}}
{{--    @endif--}}
{{--    <strong style="color:#212121; position:center;margin-right:auto;"class="col-md-12 col" >--}}
{{--        <div id="deletedsuccuss"></div>--}}
{{--    </strong>--}}

</div>
@endif
<div class="signup-form">
    <form action="{{ route('file.modify') }}" method="post" enctype="multipart/form-data">
        @csrf
        <h2>File Modify</h2>
        <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-cloud-upload"></i></span>
                <input type="file" class="form-control" name="fileupload[]" required="required" multiple>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block btn-lg">Modify</button>

        </div>
    </form>
    @if(session()->has('message'))
        <div class="alert alert-danger">
            {{ session()->get('message') }}
        </div>
    @endif
    <strong style="color:#212121; position:center;margin-right:auto;"class="col-md-12 col" >
        <div id="deletedsuccuss"></div>
    </strong>

</div>

<div class="container">
    <div class="card" class=" col-md-auto col">
        <div class="cardHeader col-md-auto col">
            <strong style="color:#212121;">
                Files
            </strong>
            <a href="#" class="btn btn-danger" id="deleteAllSelected">Delete  Selected</a>
            <a href="#" class="btn btn-danger" id="lockAllSelected">Lock  Selected</a>
            <a href="#" class="btn btn-primary" id="unlockAllSelected">Unlock  Selected</a>
        </div>
        <div class="cardBody" class=" col-md-auto col">
            <table class="table table-striped">
                <thead>
                <tr>

                    <th>Number</th>
                    {{--            <th>Path</th>--}}
                    <th>File Name</th>
                    <th>Date Time</th>
                    <th>Uploaded By</th>
                    <th>Locked By</th>
                    <th>History</th>
                    <th>Download</th>
                    <th><input type="checkbox" id="chcCheckAll"></th>
                </tr>
                </thead>
                <tbody class="col-md-auto">
                @if($data!=null)
                    @foreach ($data as $key=>$items )
                        <tr id="fid{{$items->id}}">
                            <td>{{ ++$key }}</td>
                            {{--                <td>{{ $items->path }}</td>--}}
                            <td>{{ $items->file_name }}</td>
                            <td>{{ $items->datetime }}</td>
                            <td>{{ $items->user['name'] }}</td>


                        @if($items->owner_id)
                            <td>{{ $items->user_lock['name'] }}</td>
                            @else
                                <td>Non</td>
                            @endif
                            <td>   <a href="{{route('file.history', $items->id)}}">Events</a></td>
                            <td>

                                <a href="{{route('file.download', $items->id)}}"><button type="button"
                                                                                         class="btn btn-link btn btn-dark"
                                    >
                                        download</button></a></td>
                            <td><input type="checkbox" name="ids" class="checkBoxClass" value="{{$items->id}}"> </td>


                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>
    {!! $data->links() !!}
</div>
<script>
    $(function (e){
        $("#chcCheckAll").click(function () {
            $(".checkBoxClass").prop('checked',$(this).prop('checked'));
        });

        $("#deleteAllSelected").click(function (e){
            e.preventDefault();
            var allids=[];
            $("input:checkbox[name=ids]:checked").each(function () {
                allids.push($(this).val())
            });
            $.ajax({
                url:"{{route('file.deleteselected')}}",
                type:"DELETE",
                data:{
                    _token:$("input[name=_token]").val(),
                    ids:allids
                },
                success:function (response){
                    console.log(response);
                    // $('#deletedsuccuss').html(response.success);
                    // fetch('https://jsonplaceholder.typicode.com/todos/1')
                    //     .then(response => response.blob())
                    //     .then(blob => {
                    //
                    //         alert(response.success); // or you know, something with better UX...
                    //     })
                    // $.each(allids,function (key,val) {
                    //     $("#fid"+val).remove();
                    // })
                    location.reload();
                }

            });
        })
        $("#lockAllSelected").click(function (e){
            e.preventDefault();
            var allids=[];
            $("input:checkbox[name=ids]:checked").each(function () {
                allids.push($(this).val())
            });
            $.ajax({
                url:"{{route('file.lockAllSelected')}}",
                type:"GET",
                data:{
                    _token:$("input[name=_token]").val(),
                    ids:allids
                },
                success:function (response){
                    console.log(response);
                    // $('#deletedsuccuss').html(response.success);
                    // fetch('https://jsonplaceholder.typicode.com/todos/1')
                    //     .then(response => response.blob())
                    //     .then(blob => {
                    //
                    //         alert(response.success); // or you know, something with better UX...
                    //     })
                    // $.each(allids,function (key,val) {
                    //
                    // })
                    location.reload();
                }

            });
        })
        $("#unlockAllSelected").click(function (e){
            e.preventDefault();
            var allids=[];
            $("input:checkbox[name=ids]:checked").each(function () {
                allids.push($(this).val())
            });
            $.ajax({
                url:"{{route('file.unlockAllSelected')}}",
                type:"GET",
                data:{
                    _token:$("input[name=_token]").val(),
                    ids:allids
                },
                success:function (response){
                    console.log(response);
                    // $('#deletedsuccuss').html(response.success);
                    // fetch('https://jsonplaceholder.typicode.com/todos/1')
                    //     .then(response => response.blob())
                    //     .then(blob => {
                    //
                    //         alert(response.success); // or you know, something with better UX...
                    //     })
                    // $.each(allids,function (key,val) {
                    //
                    // })
                    location.reload();
                }

            });
        })
        {{--$("#downloadAllSelected").click(function (e){--}}

        {{--    var allids=[];--}}
        {{--    $("input:checkbox[name=ids]:checked").each(function () {--}}
        {{--        allids.push($(this).val())--}}
        {{--    });--}}
        {{--    $.ajax({--}}
        {{--        url:"{{route('file.downloadselected')}}",--}}
        {{--        type:"GET",--}}
        {{--        data:{--}}
        {{--            _token:$("input[name=_token]").val(),--}}
        {{--            ids:allids--}}
        {{--        },--}}
        {{--        success:function (response){--}}
        {{--            location.reload();--}}
        {{--        }--}}
        {{--    });--}}
        {{--})--}}

        {{--$("#download").valueOf().click(function (e){--}}
        {{--    var downloadid= $("#download").val();--}}
        {{--    $.ajax({--}}

        {{--        url:"{{route('file.download')}}",--}}
        {{--        type:"GET",--}}
        {{--        data:{--}}
        {{--            _token:$("input[name=_token]").val(),--}}
        {{--            id:downloadid--}}
        {{--        },--}}
        {{--        success:function (response){--}}
        {{--            console.log(response);--}}
        {{--            // $('#deletedsuccuss').html(response.success);--}}
        {{--            fetch('https://jsonplaceholder.typicode.com/todos/1')--}}
        {{--                .then(response => response.blob())--}}
        {{--                .then(blob => {--}}

        {{--                    alert(response.success); // or you know, something with better UX...--}}
        {{--                })--}}

        {{--        }--}}

        {{--    });--}}
        {{--    //location.reload();--}}
        {{--})--}}

        $('.checkBoxClass').on('change',function () {
            if($(this).prop('checked')===false){
                $("#chcCheckAll").prop('checked',false)
            }
            if($('.checkBoxClass:checked').length===$('.checkBoxClass').length){
                $("#chcCheckAll").prop('checked',true)

            };
        });

    });
</script>
</body>
</html>
