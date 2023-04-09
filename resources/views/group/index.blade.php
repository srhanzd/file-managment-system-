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


        <div class="container">
            <div class="card">
                <div class="cardHeader col-md-12 col">
                    <strong style="color:#212121;">
                        Groups
                    </strong>
{{--                    <a href="#" class="btn btn-danger" id="deleteAllSelected">Delete  Selected</a>--}}
                    <a href="{{ route('group.create') }}" class="btn btn-primary" id="createugroup">Create  Group</a>
                </div>
                @if(session()->has('message'))
                    <div class="alert alert-danger">
                        {{ session()->get('message') }}
                    </div>
                @endif
                <div class="cardBody">
                    <table class="table table-striped">
                        <thead>
                        <tr>


                            <th>Number</th>
                            <th>Group Name</th>
                            <th>Creator Name</th>
                            <th>Users</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($groups!=null)
                            @foreach ($groups as $key=>$group )
                                <tr id="gid{{$group->id}}">
                                    <td>{{ ++$key }}</td>


                                    <td>
                                        {{ $group->name }}
                                    </td>
                                    <td>
                                        {{ $group->user()->value('name') }}
                                    </td>
                                    <td> <a href="{{route('group.users', $group->id)}}">Users</a>

                                    </td>
                                    <td>   {{ $group->description }}</td>
                                    <td>

                                           @if($group->name!='public')
                                        <a href="{{route('group.edit', $group->id)}}" class="btn btn-primary" id="editgroup">Edit</a>
                                        <a href="{{route('group.delete', $group->id)}}" class="btn btn-danger" >Delete</a>
                                        @endif
                                    </td>





                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                    {!! $groups->links() !!}

                </div>
            </div>
        </div>
{{--<script>--}}
{{--    $(function (e){--}}
{{--        $("#chcCheckAll").click(function () {--}}
{{--            $(".checkBoxClass").prop('checked',$(this).prop('checked'));--}}
{{--        });--}}

{{--        $("#deleteAllSelected").click(function (e){--}}
{{--            e.preventDefault();--}}
{{--            var allids=[];--}}
{{--            $("input:checkbox[name=ids]:checked").each(function () {--}}
{{--                allids.push($(this).val())--}}
{{--            });--}}
{{--            $.ajax({--}}
{{--                url:"{{route('group.destroy',0)}}",--}}
{{--                type:"DELETE",--}}
{{--                data:{--}}
{{--                    _token:$("input[name=_token]").val(),--}}
{{--                    ids:allids--}}
{{--                },--}}
{{--                success:function (response){--}}
{{--                    // console.log(response);--}}
{{--                    // $('#deletedsuccuss').html(response.success);--}}
{{--                    fetch('https://jsonplaceholder.typicode.com/todos/1')--}}
{{--                        .then(response => response.blob())--}}
{{--                        .then(blob => {--}}

{{--                            alert(response.success); // or you know, something with better UX...--}}
{{--                        })--}}
{{--                    $.each(allids,function (key,val) {--}}
{{--                        $("#gid"+val).remove();--}}
{{--                    })--}}
{{--                }--}}

{{--            });--}}
{{--        })--}}

{{--        $('.checkBoxClass').on('change',function () {--}}
{{--            if($(this).prop('checked')===false){--}}
{{--                $("#chcCheckAll").prop('checked',false)--}}
{{--            }--}}
{{--            if($('.checkBoxClass:checked').length===$('.checkBoxClass').length){--}}
{{--                $("#chcCheckAll").prop('checked',true)--}}

{{--            };--}}
{{--        });--}}

{{--    });--}}
{{--</script>--}}
