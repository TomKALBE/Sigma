@extends('layouts.app')
@section('content')
    <style>
        #xxx>span {
            display: inline-block;
            margin: 15px;
            padding: 15px 30px;
            font-size: 20px;
            border-radius: 20px;
            border-width: 1em;
        }

        .draggable-source--is-dragging {
            visibility: hidden;
        }
    </style>
    <body>
{{--    <div id="xxx">--}}
{{--    @foreach($formations as $formation)--}}
{{--        @foreach($formation->chapters as $chapter)--}}
{{--                <span class="proute" id="{{$chapter->id}}" style="background-color: red;">{{$chapter->title}}</span>--}}

{{--        @endforeach--}}
{{--            <button type="button" class="btn btn-primary" onclick="changeNum({{$formation->id}})"> Valider</button>--}}
{{--    @endforeach--}}
{{--    </div>--}}
{{--    <div class="row">--}}
{{--        <div class="col-lg-2 rounded-2 py-3 mb-3">--}}
{{--            <div id="xxx" class="row " style="max-height: none;">--}}
{{--                @foreach($formations as $formation)--}}
{{--                    @foreach($formation->chapters as $chapter)--}}
{{--                        <div class="card-body">--}}
{{--                        <span class="proute" id="{{$chapter->id}}">{{$chapter->title}}</span>--}}
{{--                        </div>--}}
{{--                    @endforeach--}}
{{--                    <button type="button" class="btn btn-primary"  onclick="changeNum({{$formation->id}})"> Valider</button>--}}
{{--                @endforeach--}}

{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
<div class="container">
    <div class="row">
        <div class="col">
            <div class="card">
                1 of 2
            </div>
            <div class="card">
                2 of 2
            </div>
        </div>
        <div class="col">
            <div class="col card">
                <div style="height: 1000px"></div>
            </div>
        </div>
    </div>
</div>
    <script src="{{asset("assets/js/draggable.bundle.js")}}"></script>
    <script>
        const sortable = new Draggable.Sortable(
            document.querySelector('#xxx'), {
                draggable: 'p   ',
            }
        )
        function changeNum(id) {
            let elements = document.querySelectorAll(".proute");
            let tab = new Array() ;
            elements.forEach((item)=>{
                tab.push(item.id)
            })

            console.log(tab)
            var formData = new FormData();
            formData.append('tab', JSON.stringify(tab));
            fetch('/chapter/changeNum/'+id, {
                method: 'POST',
                credentials: "same-origin",
                headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                body:formData
            }).then((response) => response.json())
                .then(function(json){
                    console.log(json)

                })
                .catch(function(error){
                    console.log(error)
                });

        }

        function test(){

            return tab;
        }
    </script>
@endsection
