@extends('layouts.app')

@section('content')
    <div style="padding-right: 1em;padding-left: 1em">
        <div class="card mb-3">
            <div class="bg-holder d-none d-lg-block bg-card">
            </div>
            <div class="card-body position-relative">
                <div class="row">
                    <div class="col-lg-8">
                        <h3>{{$formation->name}}</h3>
                        <p class="mb-0">{{$formation->description}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-0">
            <div class="col-lg-8 pe-lg-2">
            @foreach($formation->chapters as $chapter)
                <div class="card mb-3">
                    <div class="card-header bg-light">
                        <h5 class="mb-0" id="chapter{{$chapter->id}}">{{$chapter->title}}</h5>
                    </div>

                    <div class="card-body">
                    @foreach($chapter->steps as $step)
                        @if ($loop->last)
                                <h6 class="text-primary">{{$step->title}}</h6>
                                <p class="mb-0 ps-3">{!! $step->content !!}</p>
                        @else
                                <h6 class="text-primary">{{$step->title}}</h6>
                                <p class="mb-0 ps-3">{!! $step->content !!}</p>

                                <hr class="my-4" />
                        @endif

                    @endforeach
                    </div>
                </div>
            @endforeach
            </div>
            <div class="col-lg-4 ps-lg-2">
                <div class="sticky-sidebar">
                    <div class="card sticky-top">
                        <div class="card-header border-bottom">
                            <h6 class="mb-0 fs-0">Summary</h6>
                        </div>
                        <div class="card-body">
                            <div class="terms-sidebar nav flex-column fs--1" id="terms-sidebar">
                                @foreach($formation->chapters as $chapter)
                                    <div class="nav-item"><a class="nav-link px-0 py-1" href="#chapter{{$chapter->id}}">{{$chapter->title}}</a></div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div style="height: 100px"></div>
    </div>
@endsection
