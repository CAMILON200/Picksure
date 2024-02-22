<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Picksure</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
    integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <!-- Styles -->
        <style>
            /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */html{line-height:1.15;-webkit-text-size-adjust:100%}body{margin:0}a{background-color:transparent}[hidden]{display:none}html{font-family:system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji;line-height:1.5}*,:after,:before{box-sizing:border-box;border:0 solid #e2e8f0}a{color:inherit;text-decoration:inherit}svg,video{display:block;vertical-align:middle}video{max-width:100%;height:auto}.bg-white{--bg-opacity:1;background-color:#fff;background-color:rgba(255,255,255,var(--bg-opacity))}.bg-gray-100{--bg-opacity:1;background-color:#f7fafc;background-color:rgba(247,250,252,var(--bg-opacity))}.border-gray-200{--border-opacity:1;border-color:#edf2f7;border-color:rgba(237,242,247,var(--border-opacity))}.border-t{border-top-width:1px}.flex{display:flex}.grid{display:grid}.hidden{display:none}.items-center{align-items:center}.justify-center{justify-content:center}.font-semibold{font-weight:600}.h-5{height:1.25rem}.h-8{height:2rem}.h-16{height:4rem}.text-sm{font-size:.875rem}.text-lg{font-size:1.125rem}.leading-7{line-height:1.75rem}.mx-auto{margin-left:auto;margin-right:auto}.ml-1{margin-left:.25rem}.mt-2{margin-top:.5rem}.mr-2{margin-right:.5rem}.ml-2{margin-left:.5rem}.mt-4{margin-top:1rem}.ml-4{margin-left:1rem}.mt-8{margin-top:2rem}.ml-12{margin-left:3rem}.-mt-px{margin-top:-1px}.max-w-6xl{max-width:72rem}.min-h-screen{min-height:100vh}.overflow-hidden{overflow:hidden}.p-6{padding:1.5rem}.py-4{padding-top:1rem;padding-bottom:1rem}.px-6{padding-left:1.5rem;padding-right:1.5rem}.pt-8{padding-top:2rem}.fixed{position:fixed}.relative{position:relative}.top-0{top:0}.right-0{right:0}.shadow{box-shadow:0 1px 3px 0 rgba(0,0,0,.1),0 1px 2px 0 rgba(0,0,0,.06)}.text-center{text-align:center}.text-gray-200{--text-opacity:1;color:#edf2f7;color:rgba(237,242,247,var(--text-opacity))}.text-gray-300{--text-opacity:1;color:#e2e8f0;color:rgba(226,232,240,var(--text-opacity))}.text-gray-400{--text-opacity:1;color:#cbd5e0;color:rgba(203,213,224,var(--text-opacity))}.text-gray-500{--text-opacity:1;color:#a0aec0;color:rgba(160,174,192,var(--text-opacity))}.text-gray-600{--text-opacity:1;color:#718096;color:rgba(113,128,150,var(--text-opacity))}.text-gray-700{--text-opacity:1;color:#4a5568;color:rgba(74,85,104,var(--text-opacity))}.text-gray-900{--text-opacity:1;color:#1a202c;color:rgba(26,32,44,var(--text-opacity))}.underline{text-decoration:underline}.antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.w-5{width:1.25rem}.w-8{width:2rem}.w-auto{width:auto}.grid-cols-1{grid-template-columns:repeat(1,minmax(0,1fr))}@media (min-width:640px){.sm\:rounded-lg{border-radius:.5rem}.sm\:block{display:block}.sm\:items-center{align-items:center}.sm\:justify-start{justify-content:flex-start}.sm\:justify-between{justify-content:space-between}.sm\:h-20{height:5rem}.sm\:ml-0{margin-left:0}.sm\:px-6{padding-left:1.5rem;padding-right:1.5rem}.sm\:pt-0{padding-top:0}.sm\:text-left{text-align:left}.sm\:text-right{text-align:right}}@media (min-width:768px){.md\:border-t-0{border-top-width:0}.md\:border-l{border-left-width:1px}.md\:grid-cols-2{grid-template-columns:repeat(2,minmax(0,1fr))}}@media (min-width:1024px){.lg\:px-8{padding-left:2rem;padding-right:2rem}}@media (prefers-color-scheme:dark){.dark\:bg-gray-800{--bg-opacity:1;background-color:#2d3748;background-color:rgba(45,55,72,var(--bg-opacity))}.dark\:bg-gray-900{--bg-opacity:1;background-color:#1a202c;background-color:rgba(26,32,44,var(--bg-opacity))}.dark\:border-gray-700{--border-opacity:1;border-color:#4a5568;border-color:rgba(74,85,104,var(--border-opacity))}.dark\:text-white{--text-opacity:1;color:#fff;color:rgba(255,255,255,var(--text-opacity))}.dark\:text-gray-400{--text-opacity:1;color:#cbd5e0;color:rgba(203,213,224,var(--text-opacity))}.dark\:text-gray-500{--tw-text-opacity:1;color:#6b7280;color:rgba(107,114,128,var(--tw-text-opacity))}}
        </style>

        <style>
            body {
                font-family: 'Nunito', sans-serif;
                margin-top: 30px;
            }
            .bg-black-100 {
                background-color: black!important;
            }
            .galeria .col-lg-4{
                margin: 0 !important;
                padding: 15px;
            }
            .galeria img{
                border-radius: 1rem!important;
            }

            .galeria img:hover{
                border: 2px solid white;
            }

            .text-center{
                color: white;
            }
            .btn-categories {
                background-color: #303030;
                color: white;
                margin-left: 5px;
                margin-right: 5px;
            }
            #content_categories {
                display: flex;
                flex-direction: row;
                overflow: unset;
                align-items: flex-start;
                overflow-x: auto;
                overflow-y: hidden;
                white-space: nowrap;
                padding-top: 10px;
                padding-bottom: 10px;
            }
            #content_images {
            }
            .logo-img {
                width: 30%;
            }
            
            .dropdown-menu {
                background-color: black;
                width: 40rem;
            }

            .dropdown-item:focus, .dropdown-item:hover {
                color: #16181b;
                text-decoration: none;
                background-color: black;
            }
            .bg-dark {
                background-color: #000000!important;
            }
        </style>
    </head>
    <body class="antialiased bg-black-100">
        <div class="min-h-screen">
            @if (Route::has('login'))
                <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                    @auth
                        <a href="{{ url('/home') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Home</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
            <nav class="navbar navbar-dark bg-dark navbar-expand-lg">
                <a class="navbar-brand" href="#">
                    <img src="data:image/png;base64,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" class="logo-img" alt="Picksure">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                                Categorias
                            </a>
                            <div class="dropdown-menu">
                                <div id="content_categories" class="row row-cols-3"></div>
                            </div>
                        </li>
                       
                    </ul>
                </div>
            </nav>

            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
               
                <div class="mt-8 bg-black-100 dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                    <section class="container galeria">
                        <div id="content_images" class="row" style="display: flex;
                        justify-content: space-between;
                        flex-wrap: wrap;
                        align-items: center;"></div>
                    </section>
                </div>

                <div class="flex justify-center mt-4 sm:items-center sm:justify-between">
                    <div class="text-center text-sm text-gray-500 sm:text-left"></div>

                    <div class="ml-4 text-center text-sm text-gray-500 sm:text-right sm:ml-0">
                        Developed by ZIEL 
                    </div>
                </div>

            </div>
        </div>
        
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <img src="" alt="Imagenes" class="rounded" id="imgModal" width="480">
            </div>
        </div>
        
    </body>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"
        integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s"
        crossorigin="anonymous"></script>
    <script>
        let data_images = []
        let offset = 0
        let pagination = 0
        let maxImagesPerPagination = 30
        function filter(id) {
            console.log('id ', id)
        }
        function changeOffset () {
            let o = offset + maxImagesPerPagination
            getImages(o)
        }
        async function getCategories() {
            const response = await fetch("/api/v1/categories/ES");
            const categories = await response.json();
            let html_categories = ''
            if(categories.status == 200){
                let data_categories = categories.data
                data_categories.forEach(element => {
                    html_categories += '<div class="col dropdown-item"><button type="button" class="btn btn-block btn-categories" onclick="filter('+element.value+')">'+element.label+'</button></div>'
                });
            }
            $("#content_categories").html(html_categories)
            console.log(categories);
        }

        async function getImages(newOffset) {
            const response = await fetch(`/api/v1/imageproducts/ES/${maxImagesPerPagination}/${newOffset}`);
            const images = await response.json();
            let html_imgs = ''
            if(images.status == 200){
                data_images = images.data
                if(data_images.length > 0){
                    data_images.forEach(element => {
                        html_imgs += '<img src="/storage/'+element.img_url+'" alt="'+element.title+'" class="rounded img" style="width: 250px;margin: 10px;">'
                    });
                    offset = newOffset
                }
            }
            $("#content_images").append(html_imgs)

            const imagenes_sel = document.querySelectorAll('.img');
            const imgModal = document.querySelector('#imgModal')

            
            imagenes_sel.forEach(img => {
                img.addEventListener('click', (e) => {
                    imgModal.src = e.target.src  
                    e.target.setAttribute('data-toggle', 'modal')
                    e.target.setAttribute('data-target', '#exampleModal')    
                })
            })
        }

        function startImgs () {
            let o = offset + maxImagesPerPagination
            getImages(offset)
        }

        $(window).scroll(function() {
            // Verificar si se ha llegado al final de la página
            if($(window).scrollTop() + $(window).height() == $(document).height()) {
    
                console.log("► End of scroll");
                changeOffset()
            }
        });
        
        $( document ).ready(function() {
            console.log( "ready!" );
            getCategories()
            startImgs()
        });
    </script>
</html>
