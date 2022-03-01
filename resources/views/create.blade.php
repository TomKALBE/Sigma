@extends('layouts.app')

@section('content')

    <script src='{{url("/assets/js/tinymce/tinymce.min.js")}}'></script>
    <script>
        tinymce.init({
            selector: 'textarea#tiny',
            height: 300,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste imagetools wordcount',
                'image code'
            ],
            toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
            image_title: true,
            /* enable automatic uploads of images represented by blob or data URIs*/
            automatic_uploads: true,
            /*
              URL of our upload handler (for more details check: https://www.tiny.cloud/docs/configure/file-image-upload/#images_upload_url)
              images_upload_url: 'postAcceptor.php',
              here we add custom filepicker only to Image dialog
            */
            setup: function(editor) {
                editor.on('init', function(e) {
                    document.getElementById("stepeditspinner").classList.add("d-none");
                    let stepedit = document.getElementById("stepeditdiv");
                    if (stepedit == null)
                        return null
                    stepedit.classList.remove("d-none")
                    document.getElementById("stepmodifydiv").classList.remove("d-none");
                });
            },
            file_picker_types: 'image',
            /* and here's our custom image picker*/
            file_picker_callback: function (cb, value, meta) {
                var input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');

                /*
                  Note: In modern browsers input[type="file"] is functional without
                  even adding it to the DOM, but that might not be the case in some older
                  or quirky browsers like IE, so you might want to add it to the DOM
                  just in case, and visually hide it. And do not forget do remove it
                  once you do not need it anymore.
                */

                input.onchange = function () {
                    var file = this.files[0];

                    var reader = new FileReader();
                    reader.onload = function () {
                        /*
                          Note: Now we need to register the blob in TinyMCEs image blob
                          registry. In the next release this part hopefully won't be
                          necessary, as we are looking to handle it internally.
                        */
                        var id = 'blobid' + (new Date()).getTime();
                        var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                        var base64 = reader.result.split(',')[1];
                        var blobInfo = blobCache.create(id, file, base64);
                        blobCache.add(blobInfo);

                        /* call the callback and populate the Title field with the file name */
                        cb(blobInfo.blobUri(), { title: file.name });
                    };
                    reader.readAsDataURL(file);
                };

                input.click();
            },
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
        });
    </script>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-1">
            <a class="btn btn-falcon-primary me-1 mb-1" href="{{ url('/home') }}" ><span class="d-inline-block fas fa-arrow-left"></span> Return</a>
        </div>
            <div class="col-md-3 h1 align-content-center"  >
                <div class="card">
                    <form method="post" action="{{url("/chapter/add/$formation->id")}}">
                        @csrf
                        <div class="card-header bg-light">
                            <h5 class="mb-0">New Chapter</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label"  for="exampleFormControlTextarea1">Chapter title</label>
                                <input required class="form-control @error('title') is-invalid @enderror" name="title" placeholder="Chapter title">
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
                @if(sizeof($formation->chapters) > 0)

                    <div class="card mt-3" style="background:#f9fafd;" role="tabpanel" aria-labelledby="tab-dom-6cc25d73-d40c-4305-94c5-9568577a7a5e" id="dom-6cc25d73-d40c-4305-94c5-9568577a7a5e">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Chapters</h5>
                        </div>
                        <div class="row" >
                            <div id="chapters_list" class="kanban-items-container dark__bg-1000 rounded-2 py-3" style="max-height: none;">
                                @foreach($formation->chapters as $chapter)
                                    <div id="chapterDiv{{$chapter->id}}" class="card kanban-item shadow-sm dark__bg-1100 chapter" style="margin:0.5em;">
                                        <div class="card-body mb-2 row d-flex align-items-center h-50" >
                                            <div class="col" >
                                                <p id="{{$chapter->id}}" style="text-align: center" class="fs--1 fw-medium font-sans-serif mb-0 chapternum">{{$chapter->title}}
                                                </p>
                                            </div>
                                            <div class="col d-flex justify-content-end">
                                                <div style="margin-right: 10px">
                                                    <a class="btn btn-sm btn-falcon-default" type="button" data-bs-toggle="modal" data-bs-target="#modal{{$chapter->id}}" title="Acces to your page">
                                                        <span class="fas fa-edit"></span>
                                                    </a>
                                                </div>
                                                <form class="" id="form_delete{{$chapter->id}}" method="post" action="{{url("/chapter/delete/$chapter->id")}}">
                                                    @csrf
                                                    @method('delete')
                                                    <a class="btn btn-sm btn-falcon-default" onclick="document.getElementById('form_delete{{$chapter->id}}').submit();" title="Acces to your page">
                                                        <span class="far fa-trash-alt"></span>
                                                    </a>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="modal{{$chapter->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px">
                                            <div class="modal-content position-relative">
                                                <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                                                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{url("/chapter/modify/$chapter->id")}}" method="POST">
                                                    @csrf
                                                    @method('put')
                                                    <div class="modal-body p-0">
                                                        <div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
                                                            <h4 class="mb-1" id="modalExampleDemoLabel">Modify </h4>
                                                        </div>
                                                        <div class="pb-0 mx-4">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="recipient-name">Chapter title:</label>
                                                                <input name="title" value="{{$chapter->title}}" class="form-control" id="recipient-name" type="text" />
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
                            <div class="card-footer d-flex flex-between-center">
                                    <div class="d-flex align-items-center">
                                        <button type="button" class="btn btn-primary btn-sm px-5 me-2"  onclick="changeNum({{$formation->id}})"> Changer order</button>
                                    </div>
                                </div>
                            </div>
                    </div>
                @endif
            </div>
            <div class="col-md-8" >
                <div class="text-center" id="stepeditspinner">
                    <div class="spinner-grow text-primary mt-10" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <div class="card d-none" id="stepeditdiv">
                    <form method="post" action="{{url("/step/add/")}}">
                        @csrf
                        <div class="card-header bg-light">
                            <h5 class="mb-0">New Sept </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="exampleFormControlInput1">Chapter title</label>
                                <select id="selectStep" onload="changeChapter(this.value)" onchange='changeChapter(this.value)' name="chapter_id" class="form-select" aria-label="Default select example">
                                    <option  disabled>Select chapter</option>
                                    @foreach($formation->chapters as $key=>$chapter)
                                        <option id="option_{{$key}}" value="{{$chapter->id}}">{{$chapter->num}} : {{$chapter->title}}</option>
                                    @endforeach

                                </select>
                            </div>
                                <div class="mb-3">
                                    <label class="form-label" for="exampleFormControlInput1">Steps title</label>
                                    <input class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Chapter title">
                                    @error('name')<label class="invalid-feedback"> {{$message}}  </label>@enderror
                                </div>
                            <div class="mb-3">
                                <label class="form-label" for="exampleFormControlTextarea1">Step content</label>
                                <textarea id="tiny" class="tinymce d-none" name="content"></textarea>
                                @error('content')<label class="invalid-feedback"> {{$message}}  </label>@enderror
                            </div>
                            <div class="card-footer d-flex flex-between-center">
                                <div class="d-flex align-items-center">
                                    <button class="btn btn-primary btn-sm px-5 me-2" type="submit">Add</button>
                                    <input class="d-none" id="email-attachment" type="file" />
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                @if(sizeof($formation->chapters) > 0 && sizeof($formation->chapters->first->steps->steps) > 0)
                <div class="card mt-3 d-none" style="background:#f9fafd;" role="tabpanel" aria-labelledby="tab-dom-6cc25d73-d40c-4305-94c5-9568577a7a" id="stepmodifydiv">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Steps</h5>
                    </div>
                    <div class="row">
                        <div id="xxx" class="dark__bg-1000 rounded-2 py-3 formation" style="max-height: none;">

                        </div>
                        <div class="card-footer d-flex flex-between-center">
                            <div class="d-flex align-items-center">
                                <button type="button" class="btn btn-primary btn-sm px-5 me-2"  onclick="changeNumStep()"> Changer order</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    <script src="{{asset("assets/js/draggable.bundle.js")}}"></script>

    <script>

        try{
            const sortable = new Draggable.Sortable(

            document.querySelector('#xxx'), {
                draggable: '.steps',
                mirror: {
                    constrainDimensions: true,
                },
            }
            )
        }catch (e) {

        }
        function codeAddress() {
            changeChapter(document.getElementById('selectStep').value)
        }
        window.onload = codeAddress;
        $chapters = document.querySelectorAll('.chapter');
        const sortable2 = new Draggable.Sortable(
            document.querySelector('#chapters_list'), {
                draggable: '.chapter',
                mirror: {
                    constrainDimensions: true,
                },
            }
        )


        function changeChapter(id)
        {
            fetch('{{url("step/get")}}/'+id, {
                method: 'POST',
                credentials: "same-origin",
                headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            }).then((response) => response.json())
                .then(function(json){
                    let div = document.getElementById("xxx");
                    if (div == null)
                        return null
                    div.innerHTML = "";

                    const url = '{{url("/step/delete/")}}'
                    const url_modif = '{{url("/step/modify/")}}'

                    json.map(item=>{
                        div.innerHTML += `
                        <div id="stepDiv${item.id}" class="card kanban-item shadow-sm dark__bg-1100 steps" style="margin:0.5em;">
                            <div class="card-body mb-2 row d-flex align-items-center h-50" >
                                <div class="col" >
                                    <p id="${item.id}" style="text-align: center" class="fs--1 fw-medium font-sans-serif mb-0 stepp">${item.name}
                                    </p>
                                </div>
                                <div class="col d-flex justify-content-end">
                                    <div style="margin-right: 10px">
                                        <a class="btn btn-sm btn-falcon-default" onclick="changeStep(${item.id})" type="button" data-bs-toggle="modal" data-bs-target="#modal_step${item.id}" title="Edit Step">
                                            <span class="fas fa-edit"></span>
                                        </a>
                                    </div>
                                    <form class="" id="form_delete${item.id}" method="post" action="${url + "/" + item.id}">
                                        @csrf
                                        @method('delete')
                                        <a class="btn btn-sm btn-falcon-default" onclick="document.getElementById('form_delete${item.id}').submit();" title="Delete Step">
                                            <span class="far fa-trash-alt"></span>
                                        </a>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="modal_step${item.id}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 1000px">
                                <div class="modal-content position-relative">
                                    <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                                        <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="${url_modif + "/" + item.id}" method="POST">
                                        @csrf
                                        @method('put')
                                        <div class="modal-body p-0">
                                            <div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
                                                <h4 class="mb-1" id="modalExampleDemoLabel">Modify </h4>
                                            </div>
                                            <div class="pb-0 mx-4">
                                                <div class="mb-3">
                                                    <label class="form-label" for="recipient-name">Step title:</label>
                                                    <input name="title" value="${item.name}" class="form-control" id="recipient-name" type="text" />
                                                </div>
                                                <div class="mb-3">
                                                        <label class="form-label" for="exampleFormControlTextarea1">Step content</label>
                                                        <textarea id="tiny${item.id}" class="tinymce d-none" name="content">
                                                        ${item.content}
                                                        </textarea>
                                                        @error('content')<label class="invalid-feedback"> {{$message}}  </label>@enderror
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
`
                    })

                })
                .catch(function(error){
                    console.log(error)
                });

        }


        function deleteChapter(id){
            fetch('{{url("chapter/delete")}}/'+id, {
                method: 'DELETE',
                credentials: "same-origin",
                headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            }).then(function(response){
                console.log(response)
            })
            .then(function(json){
                document.getElementById('chapterDiv'+id).remove();

            })
            .catch(function(error){
                console.log(error)
            });
        }
        function changeNumStep(id) {
            let elements = document.querySelectorAll(".stepp");
            let tab = new Array() ;
            elements.forEach((item)=>{
                tab.push(item.id)
            })
            let formData = new FormData();
            formData.append('tab', JSON.stringify(tab));
            fetch('/step/changeNum/'+id, {
                method: 'POST',
                credentials: "same-origin",
                headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                body:formData
            }).then((response) => response.json())
                .then(function(json){
                    console.log(json)
                    success('Changes saved!')
                })
                .catch(function(error){
                    console.log(error)
                });
        }
        function changeNum(id) {
                let elements = document.querySelectorAll(".chapternum");
                let tab = new Array() ;
                elements.forEach((item)=>{
                    tab.push(item.id)
                })

                let formData = new FormData();
                formData.append('tab', JSON.stringify(tab));
                fetch('/chapter/changeNum/'+id, {
                    method: 'POST',
                    credentials: "same-origin",
                    headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    body:formData
                }).then((response) => response.json())
                .then(function(json){
                    console.log(json)
                    for (let i = 0; i < tab.length; i++){
                        let option = document.getElementById("option_"+i)
                        option.value = json[i].id
                        option.innerHTML = json[i].num+" : "+json[i].title
                    }
                })
                .catch(function(error){
                    console.log(error)
                });
        }

        function changeStep(id){

            console.log("je suis dans le changestep")
            tinymce.init({
                selector: 'textarea#tiny'+id,
                height: 300,
                plugins: [
                    'advlist autolink lists link image charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table paste imagetools wordcount',
                    'image code'
                ],
                toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                image_title: true,
                /* enable automatic uploads of images represented by blob or data URIs*/
                automatic_uploads: true,
                /*
                  URL of our upload handler (for more details check: https://www.tiny.cloud/docs/configure/file-image-upload/#images_upload_url)
                  images_upload_url: 'postAcceptor.php',
                  here we add custom filepicker only to Image dialog
                */
                setup: function(editor) {
                    editor.on('init', function(e) {
                        // document.getElementById("stepeditspinner"+id).classList.add("d-none");
                        // let stepedit = document.getElementById("stepeditdiv"+id);
                        // if (stepedit == null)
                        //     return null
                        // stepedit.classList.remove("d-none")
                        // document.getElementById("stepmodifydiv"+id).classList.remove("d-none");
                    });
                },
                file_picker_types: 'image',
                /* and here's our custom image picker*/
                file_picker_callback: function (cb, value, meta) {
                    var input = document.createElement('input');
                    input.setAttribute('type', 'file');
                    input.setAttribute('accept', 'image/*');

                    /*
                      Note: In modern browsers input[type="file"] is functional without
                      even adding it to the DOM, but that might not be the case in some older
                      or quirky browsers like IE, so you might want to add it to the DOM
                      just in case, and visually hide it. And do not forget do remove it
                      once you do not need it anymore.
                    */

                    input.onchange = function () {
                        var file = this.files[0];

                        var reader = new FileReader();
                        reader.onload = function () {
                            /*
                              Note: Now we need to register the blob in TinyMCEs image blob
                              registry. In the next release this part hopefully won't be
                              necessary, as we are looking to handle it internally.
                            */
                            var id = 'blobid' + (new Date()).getTime();
                            var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                            var base64 = reader.result.split(',')[1];
                            var blobInfo = blobCache.create(id, file, base64);
                            blobCache.add(blobInfo);

                            /* call the callback and populate the Title field with the file name */
                            cb(blobInfo.blobUri(), { title: file.name });
                        };
                        reader.readAsDataURL(file);
                    };

                    input.click();
                },
                content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
            });
        }
    </script>
@endsection
