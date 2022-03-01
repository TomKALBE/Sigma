@extends('layouts.app')

@section('content')

    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
        <div class="container-fluid">
            <div class="row min-vh-75 flex-center g-0">
                <div class="col-lg-8 col-xxl-5 py-3 position-relative"><img class="bg-auth-circle-shape" src="../../../assets/img/icons/spot-illustrations/bg-shape.png" alt="" width="250"><img class="bg-auth-circle-shape-2" src="../../../assets/img/icons/spot-illustrations/shape-1.png" alt="" width="150">
                    <div class="card overflow-hidden z-index-1">
                        <div class="card-body p-0">
                            <div class="row g-0 h-100">
                                <div class="col-md-5 text-center bg-card-gradient">
                                    <div class="position-relative p-4 pt-md-5 pb-md-7 light">
                                        <!--/.bg-holder-->
                                        <div class="z-index-1 position-relative"><a class="link-light mb-4 font-sans-serif fs-4 d-inline-block fw-bolder" href="{{url("/")}}">Sigma</a>
                                            <p class="opacity-75 text-white">To become a new active member of Sigma please enter your email and we will contact <you></you></p>
                                        </div>
                                    </div>
                                    <div class="mt-3 mb-4 mt-md-4 mb-md-5 light">
                                        <p class="mb-0 mt-4 mt-md-5 fs--1 fw-semi-bold text-white opacity-75">Read our <a class="text-decoration-underline text-white" href="#!">terms</a> and <a class="text-decoration-underline text-white" href="#!">conditions </a></p>
                                    </div>
                                </div>
                                <div class="col-md-7 d-flex flex-center">
                                    <div class="p-4 p-md-5 flex-grow-1">
                                        <div class="text-center text-md-start">
                                            <h4 class="mb-0"> Enter your email</h4>
                                            <p class="mb-4">Enter your email and we'll send you a link with your logs.</p>
                                        </div>
                                        <div class="row justify-content-center">
                                            <div class="col-sm-8 col-md">
                                                <form class="mb-3" action="{{url("/contact/send")}}" method="post">
                                                    @csrf
                                                    <input required class="form-control @error('email') is-invalid @enderror" name="email" type="email" placeholder="Email address" />
                                                    @error('email')<label class="invalid-feedback">Email already used !</label>@enderror
                                                    <div class="mb-3">
                                                        <button class="btn btn-primary d-block w-100 mt-3" type="submit">Send</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->

@endsection
