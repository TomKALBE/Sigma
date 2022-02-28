@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row justify-content-center">
            @if(sizeof($formations) > 0)
                <div class="card col-md-10">
                    <div class="card-body">
                        <form class="form-inline" method="GET" action="/admin">
                            <div class="row align-items-center w-50 mb-2">
                                <div class="row w-75">
                                    <div class="col">
                                        <input placeholder="Research ..." class="form-control " type="text" name="term" id="term">
                                    </div>
                                    <div class="col ">
                                        <select class="form-select" name="price">
                                            <option value="more-expensive">More expensive</option>
                                            <option value="less-expensive">Less expensive</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <button class="btn btn-falcon-primary me-1 mb-1" type="submit">
                                            Apply
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="row mb-2">
                            @foreach($formations as $formation)
                                <div class="col-sm-4 mt-2">
                                    <div class="border rounded-3 h-100 d-flex flex-column justify-content-between">
                                        <div class="overflow-hidden">
                                            <div class="position-relative rounded-top overflow-hidden">
                                                <a style="top:0.8rem;left:0.8rem" class="btn btn-sm btn-falcon-default mb-3 position-absolute" data-bs-toggle="modal" data-bs-target="#modaledit{{$formation->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Acces to your page">
                                                    <span class="fas fa-edit" style="margin-left: 3px"></span>
                                                </a>
                                                <a class="d-block" href="{{url("/formation/edit/$formation->id")}}">
                                                    <img style="height: 200px;object-fit: cover" class="card-img-top " height="150" src="{{url("storage/$formation->picture")}}" alt="" />
                                                </a>
                                                <span class="badge rounded-pill bg-success position-absolute mt-2 me-2 z-index-2 top-0 end-0">New</span>
                                            </div>

                                            <div class="p-3">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <h5 class="fs-0"><a class="text-dark" href="/formation/edit/{{$formation->id}}">{{$formation->name}}</a></h5>
                                                        <p class="fs--1 mb-3">
                                                            @foreach($formation->categories as $category)
                                                                @if ($loop->last)
                                                                    <a class="text-500" href="#!">{{$category->name}}</a>
                                                                @else
                                                                    <a class="text-500" href="#!">{{$category->name}}</a> <span class="text-500">&amp</span>
                                                                @endif
                                                            @endforeach
                                                        </p>
                                                    </div>
                                                    <div class="col-6">
                                                        <h5 class="fs-md-2 text-warning mb-0 d-flex align-items-center mb-3 float-end"> {{$formation->price}}€
                                                            <del class="ms-2 fs--1 text-500">99.99€</del>
                                                        </h5>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-10">
                                                        <p class="fs--1 mb-1">{{ Str::limit($formation->description, 70, ' (...)') }}</p>
                                                        <p class="fs--1 mb-1">Status: <strong class="text-success">Online</strong>

                                                        </p>
                                                    </div>
                                                    <div class="col-2">
                                                        <a class="btn btn-sm btn-falcon-default me-2 float-end " href="/formation/{{$formation->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Acces to your page">
                                                            <span class="far fa-eye"></span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="modaledit{{$formation->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px">
                                        <div class="modal-content position-relative">
                                            <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                                                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body p-0">
                                                <div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
                                                    <h4 class="mb-1" id="modalExampleDemoLabel">Add a new illustration </h4>
                                                </div>
                                                <div class="p-4 pb-0">
                                                    <form method="post" action="{{url("/home/edit/$formation->id")}}" enctype="multipart/form-data">
                                                        @method('put')
                                                        @csrf
                                                        <div class="mb-3">
                                                            <label class="col-form-label" for="recipient-name">Title:</label>
                                                            <input required class="form-control" id="recipient-name" name="name" value="{{$formation->name}}" type="text" />
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="col-form-label" for="message-text">Type:</label>
                                                            <input required class="form-control" name="type" value="{{$formation->type}}" id="message-text"></div>
                                                        <div class="mb-3">
                                                            <label class="col-form-label" for="message-text">Description:</label>
                                                            <textarea required class="form-control" name="description"  id="message-text">{{$formation->description}}</textarea>
                                                        </div>
                                                        <div class="mb-3 imageContainer">
                                                            <div  class="col-form-label" >Image :</div>
                                                            <label for="choose-file{{$formation->id}}" class="w-100">
                                                                <div class="dropzone dropzone-single p-0 cursor-pointer dz-clickable" id="backgroundImage" for="choose-file" data-dropzone="" data-options="{maxFile:1}" style="height: 300px; background-image: url({{asset("/storage/$formation->picture")}}); background-repeat: no-repeat; background-size: 100% 100%;">
                                                                    <div class="row justify-content-center" data-dz-message="" style="height: 300px;">
                                                                        <div class="text-center align-self-center font-weight-bold">Glissez une image ici ou cliquez pour en charger une</div>
                                                                    </div>
                                                                </div>
                                                            </label>
                                                            <input  class="form-control" type="file" accept="image/*" id="choose-file{{$formation->id}}" name="picture" />
                                                        </div>
                                                        <div class="mb-3">
                                                            <select class="form-select js-choice" id="organizerMultiple" multiple="multiple" size="1" name="categories[]" data-options='{"removeItemButton":true,"placeholder":true}'>
                                                                <option value="">Select organizer...</option>
                                                                @foreach($categories as $category)
                                                                    <option @if($formation->categories->contains('id',$category->id))selected @endif value="{{$category->id}}">{{$category->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="col-form-label" for="message-text">Price:</label>
                                                            <input required type="number" class="form-control" name="price" value="{{$formation->price}}" id="message-text">
                                                        </div>

                                                        <div class="modal-footer">
                                                            <a class="btn btn-danger"  href="{{ url("/home/delete/$formation->id") }}"
                                                               onclick="event.preventDefault();
                                                                document.getElementById('delete-form').submit();">
                                                                Delete
                                                            </a>


                                                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                                                            <button class="btn btn-primary" type="submit">Modify</button>
                                                        </div>
                                                    </form>
                                                    <form id="delete-form" action="{{ url("/home/delete/$formation->id") }}" method="POST" class="d-none">
                                                        @csrf
                                                        @method('delete')
                                                    </form>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            @endforeach
                        </div>
                    </div>
                    <div class="card-footer bg-light d-flex justify-content-center">
                        <div>
                            <a class="btn btn-falcon-default btn-sm me-2" href="{{$formations->previousPageUrl()}}" type="button" disabled="disabled" data-bs-toggle="tooltip" data-bs-placement="top" title="Prev">
                                <span class="fas fa-chevron-left"></span>
                            </a>
                            @for($i = 1;$i<$formations->lastPage()+1;$i++)
                                @if($formations->currentPage() == $i)
                                    <a class="btn btn-sm btn-falcon-default text-primary me-2" href="#">{{$formations->currentPage()}}</a>
                                @else
                                    <a class="btn btn-sm btn-falcon-default me-2" href='{{url("admin/?page=$i")}}'>{{$i}}</a>
                                @endif
                            @endfor
                            <a class="btn btn-falcon-default btn-sm" href="{{$formations->nextPageUrl()}}" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="Next">
                                <span class="fas fa-chevron-right"></span>
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <script src={{asset('./assets/lib/choices/choices.min.js')}}></script>
    <script>
        function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }
        function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) { symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); } keys.push.apply(keys, symbols); } return keys; }
        function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

        var camelize = function camelize(str) {
            var text = str.replace(/[-_\s.]+(.)?/g, function (_, c) {
                return c ? c.toUpperCase() : '';
            });
            return "".concat(text.substr(0, 1).toLowerCase()).concat(text.substr(1));
        };

        var getData = function getData(el, data) {
            try {
                return JSON.parse(el.dataset[camelize(data)]);
            } catch (e) {
                return el.dataset[camelize(data)];
            }
        };
        window.onload = choicesInit;
        function choicesInit() {
            if (window.Choices) {
                var elements = document.querySelectorAll('.js-choice');
                elements.forEach(function (item) {
                    var userOptions = getData(item, 'options');
                    var choices = new window.Choices(item, _objectSpread({
                        itemSelectText: ''
                    }, userOptions));
                    return choices;
                });
            }
        };
    </script>
@endsection

