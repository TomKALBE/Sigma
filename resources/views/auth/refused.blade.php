@extends('layouts.app')
@section('content')
    @error('updated_at')
    <div class="row flex-center min-vh-75 py-6">
        <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4"><a class="d-flex flex-center mb-4" href="/"><span class="font-sans-serif fw-bolder fs-5 d-inline-block">Sigma</span></a>
            <div class="card">
                <div class="card-body p-4 p-sm-5">
                    <div class="text-center"><img class="d-block mx-auto mb-4" src="../../../assets/img/icons/spot-illustrations/16.png" alt="Email" width="100" />
                        <h4 class="mb-2">Token already used !</h4>
                        <p>This token as already been used at <strong>{{$message}}</strong>
                        </p><a class="btn btn-primary btn-sm mt-3" href="{{ url()->previous() }}"><span class="fas fa-chevron-left me-1" data-fa-transform="shrink-4 down-1"></span>Return back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
        <div class="row flex-center min-vh-75 py-6">
            <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4"><a class="d-flex flex-center mb-4" href="/"><span class="font-sans-serif fw-bolder fs-5 d-inline-block">Sigma</span></a>
                <div class="card">
                    <div class="card-body p-4 p-sm-5">
                        <div class="text-center"><img class="d-block mx-auto mb-4" src="../../../assets/img/icons/spot-illustrations/16.png" alt="Email" width="100" />
                            <h4 class="mb-2">User rejeted !</h4>
                            <p>An email has been sent to <strong>{{$email}}</strong>
                            </p><a class="btn btn-primary btn-sm mt-3" href="{{ url()->previous() }}"><span class="fas fa-chevron-left me-1" data-fa-transform="shrink-4 down-1"></span>Return back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @enderror
@endsection
