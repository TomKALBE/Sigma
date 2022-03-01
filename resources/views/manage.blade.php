@extends('layouts.app')
@section('content')

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-3 h1 align-content-center"  >
                <div class="card">
                    <form method="post" action="{{url("/category/add")}}">
                        @csrf
                        <div class="card-header bg-light">
                            <h5 class="mb-0">New Category</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label"  for="exampleFormControlTextarea1">Category name</label>
                                <input required class="form-control @error('title') is-invalid @enderror" name="name" placeholder="Chapter title">
                                @error('title')<label class="invalid-feedback"> {{$message}}  </label>@enderror
                            </div>
                            <div class="card-footer d-flex flex-between-center">
                                <div class="d-flex align-items-center">
                                    <button class="btn btn-primary btn-sm px-5 me-2" type="submit">Add</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card mt-3" style="background:#f9fafd;" role="tabpanel" aria-labelledby="tab-dom-6cc25d73-d40c-4305-94c5-9568577a7a5e" id="dom-6cc25d73-d40c-4305-94c5-9568577a7a5e">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Categories</h5>
                    </div>
                    <div class="row" >
                        <div id="chapters_list" class="kanban-items-container dark__bg-1000 rounded-2 py-3" style="max-height: none;">
                            @foreach($categories as $category)
                                <div id="chapterDiv{{$category->id}}" class="card kanban-item shadow-sm dark__bg-1100 chapter" style="margin:0.5em;">
                                    <div class="card-body mb-2 row d-flex align-items-center h-50" >
                                        <div class="col" >
                                            <p id="{{$category->id}}" style="text-align: center" class="fs--1 fw-medium font-sans-serif mb-0">{{$category->name}}
                                            </p>
                                        </div>
                                        <div class="col d-flex justify-content-end">
                                            <div style="margin-right: 10px">
                                                <a class="btn btn-sm btn-falcon-default" type="button" data-bs-toggle="modal" data-bs-target="#modal{{$category->id}}" title="Acces to your page">
                                                    <span class="fas fa-edit"></span>
                                                </a>
                                            </div>
                                            <form class="" id="form_delete{{$category->id}}" method="post" action="{{url("/category/delete/$category->id")}}">
                                                @csrf
                                                @method('delete')
                                                <a class="btn btn-sm btn-falcon-default" onclick="document.getElementById('form_delete{{$category->id}}').submit();" title="Acces to your page">
                                                    <span class="far fa-trash-alt"></span>
                                                </a>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="modal{{$category->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px">
                                        <div class="modal-content position-relative">
                                            <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                                                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{url("/category/modify/$category->id")}}" method="POST">
                                                @csrf
                                                @method('put')
                                                <div class="modal-body p-0">
                                                    <div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
                                                        <h4 class="mb-1" id="modalExampleDemoLabel">Modify </h4>
                                                    </div>
                                                    <div class="pb-0 mx-4">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="recipient-name">Category name:</label>
                                                            <input name="name" value="{{$category->name}}" class="form-control" id="recipient-name" type="text" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                                                    <button class="btn btn-primary" type="submit">Modify</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Register request</h5>
                    </div>
                    <div class="card-body">
                        <div class="row" >
                            <div id="chapters_list" class="kanban-items-container dark__bg-1000 rounded-2 py-3" style="max-height: none;">
                                @if(sizeof($registerRequests) > 0)
                                    @foreach($registerRequests as $request)
                                        <div id="chapterDiv{{$request->id}}" class="card kanban-item shadow-sm dark__bg-1100 chapter" style="margin:0.5em;opacity: @if($request->tokenUsed) 0.5;cursor: default @else 1 @endif">
                                            <div class="card-body mb-2 row d-flex align-items-center h-50" >
                                                <div class="col" >
                                                    <p id="{{$request->id}}" style="text-align: center" class="fs--1 fw-medium font-sans-serif mb-0">{{$request->email}}
                                                    </p>
                                                </div>
                                                <div class="col d-flex justify-content-end">
                                                    <a class="btn btn-sm btn-falcon-default" style="margin-right: 10px" href="{{url("/refuse/$request->token")}}" title="Deny access">
                                                        <span class="far fa-trash-alt"></span>
                                                    </a>
                                                    <a class="btn btn-sm btn-falcon-default" href="{{url("/register/$request->token")}}" title="Grant access">
                                                        <span class="fas fa-check"></span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="modal{{$request->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px">
                                                <div class="modal-content position-relative">
                                                    <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                                                        <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{url("refuse/$request->token")}}" method="POST">
                                                        @csrf
                                                        @method('put')
                                                        <div class="modal-body p-0">
                                                            <div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
                                                                <h4 class="mb-1" id="modalExampleDemoLabel">Modify </h4>
                                                            </div>
                                                            <div class="pb-0 mx-4">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="recipient-name">Category name:</label>
                                                                    <input name="name" value="{{$request->email}}" class="form-control" id="recipient-name" type="text" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                                                            <button class="btn btn-primary" type="submit">Modify</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <p>No request</p>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card mt-3">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Users</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive scrollbar">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col"> </th>
                                    <th scope="col">joined</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)

                                    <tr class="hover-actions-trigger">
                                        <td class="align-middle text-nowrap">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-xl">
                                                    <img class="rounded-circle" src="@if($user->picture == null){{asset("
                                                         assets/img/team/avatar.png")}}@else {{asset("assets/img/team/$user->picture")}}@endif" alt="" />
                                                </div>
                                                <div class="ms-2">{{$user->name}}</div>
                                            </div>
                                        </td>
                                        <td class="align-middle text-nowrap">{{$user->email}}</td>
                                        <td class="w-auto">
                                            <div class="btn-group btn-group hover-actions end-0 me-4">
                                                <button class="btn btn-light pe-2" type="button"  data-bs-target="#modal2{{$user->id}}" data-bs-toggle="modal" data-bs-placement="top" title="Edit">
                                                    <span class="fas fa-edit"></span>
                                                </button>
                                            </div>
                                        </td>
                                        <td class="align-middle text-nowrap">{{$user->created_at}}</td>
                                    </tr>
                                    <div class="modal fade" id="modal2{{$user->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px">
                                            <div class="modal-content position-relative">
                                                <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                                                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{url("/profile/modify/$user->id")}}" method="POST">
                                                    @csrf
                                                    @method('put')
                                                    <div class="modal-body p-0">
                                                        <div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
                                                            <h4 class="mb-1" id="modalExampleDemoLabel">Modify </h4>
                                                        </div>
                                                        <div class="pb-0 mx-4">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="recipient-name">User name:</label>
                                                                <input required name="first_name" value="{{$user->name}}" class="form-control" id="recipient-name" type="text" />
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label" for="recipient-name">Last name:</label>
                                                                <input required name="last_name" value="{{$user->last_name}}" class="form-control" id="recipient-name" type="text" />
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label" for="recipient-name">Email:</label>
                                                                <input required name="email" value="{{$user->email}}" class="form-control" id="recipient-name" type="email" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                                                        <a class="btn btn-danger"  href="{{ url("/profile/delete/$user->id") }}"
                                                           onclick="event.preventDefault();
                                                                document.getElementById('delete-form{{$user->id}}').submit();">
                                                            Delete
                                                        </a>
                                                        <button class="btn btn-primary" type="submit">Modify</button>
                                                    </div>
                                                </form>
                                                <form id="delete-form{{$user->id}}" action="{{ url("/profile/delete/$user->id") }}" method="POST" class="d-none">
                                                    @csrf
                                                    @method('delete')
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
