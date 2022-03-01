@extends('layouts.app')
@section('content')
    <div class="card mb-3 m-3">
        <div class="card-body">
            <form class="form-inline" method="GET" action="/">
                <div class="row align-items-center w-50 mb-2">
                    <div class="row w-100">
                        <div class="col">
                            <input placeholder="Research ..." class="form-control " type="text" name="term" id="term">
                        </div>
                        <div class="col ">
                            <select class="form-select" name="price">
                                <option value="more-expensive">More expensive</option>
                                <option value="less-expensive">Less expensive</option>
                            </select>
                        </div>
{{--                        <div class="col ">--}}
{{--                            <select class="form-select" name="category">--}}
{{--                                @foreach($categories as $category)--}}
{{--                                    <option value="{{$category->id}}">{{$category->name}}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                        </div>--}}
                        <div class="col">
                            <button class="btn btn-falcon-primary me-1 mb-1" type="submit">
                                Apply
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="row">

            @foreach($formations as $formation)
                <div class="mb-4 col-md-6 col-lg-4">
                    <div class="border rounded-3 h-100 d-flex flex-column justify-content-between">
                        <div class="overflow-hidden">
                            <div class="position-relative rounded-top overflow-hidden"><a class="d-block" href="{{url("/formation/$formation->id")}}"><img style="height: 200px;object-fit: cover" class="card-img-top " height="200" src="{{url("storage/$formation->picture")}}" alt="" /></a><span class="badge rounded-pill bg-success position-absolute mt-2 me-2 z-index-2 top-0 end-0">New</span>
                            </div>
                            <div class="p-3">
                                <h5 class="fs-0"><a class="text-dark" href="{{url("/formation/$formation->id")}}">{{$formation->name}}</a></h5>
                                <p class="fs--1 mb-3">
                                    @foreach($formation->categories as $category)
                                        @if ($loop->last)
                                        <a class="text-500" href="#!">{{$category->name}}</a>
                                        @else
                                            <a class="text-500" href="#!">{{$category->name}}</a> <span class="text-500">&amp</span>
                                        @endif
                                    @endforeach
                                </p>
                                <h5 class="fs-md-2 text-warning mb-0 d-flex align-items-center mb-3"> {{$formation->price}}€
                                    <del class="ms-2 fs--1 text-500">{{$formation->price + 15.99}}€</del>
                                </h5>
                                <p class="fs--1 mb-1">{{$formation->description}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
        </div>
        @if($formations->items() > 9)
            <div class="card-footer bg-light d-flex justify-content-center">
                <div>
                    <a class="btn btn-falcon-default btn-sm me-2" href="{{$formations->previousPageUrl()}}" type="button" disabled="disabled" data-bs-toggle="tooltip" data-bs-placement="top" title="Prev">
                        <span class="fas fa-chevron-left"></span>
                    </a>
                    @for($i = 1;$i<$formations->lastPage()+1;$i++)
                        @if($formations->currentPage() == $i)
                            <a class="btn btn-sm btn-falcon-default text-primary me-2" href="#">{{$formations->currentPage()}}</a>
                        @else
                            <a class="btn btn-sm btn-falcon-default me-2" href='{{url("/?page=$i")}}'>{{$i}}</a>
                        @endif
                    @endfor
                    <a class="btn btn-falcon-default btn-sm" href="{{$formations->nextPageUrl()}}" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="Next">
                        <span class="fas fa-chevron-right"></span>
                    </a>
                </div>
            </div>
        @endif
    </div>
@endsection
