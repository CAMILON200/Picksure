<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Picksure</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <!-- Styles -->
        <style>
            /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */html{line-height:1.15;-webkit-text-size-adjust:100%}body{margin:0}a{background-color:transparent}[hidden]{display:none}html{font-family:system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji;line-height:1.5}*,:after,:before{box-sizing:border-box;border:0 solid #e2e8f0}a{color:inherit;text-decoration:inherit}svg,video{display:block;vertical-align:middle}video{max-width:100%;height:auto}.bg-white{--bg-opacity:1;background-color:#fff;background-color:rgba(255,255,255,var(--bg-opacity))}.bg-gray-100{--bg-opacity:1;background-color:#f7fafc;background-color:rgba(247,250,252,var(--bg-opacity))}.border-gray-200{--border-opacity:1;border-color:#edf2f7;border-color:rgba(237,242,247,var(--border-opacity))}.border-t{border-top-width:1px}.flex{display:flex}.grid{display:grid}.hidden{display:none}.items-center{align-items:center}.justify-center{justify-content:center}.font-semibold{font-weight:600}.h-5{height:1.25rem}.h-8{height:2rem}.h-16{height:4rem}.text-sm{font-size:.875rem}.text-lg{font-size:1.125rem}.leading-7{line-height:1.75rem}.mx-auto{margin-left:auto;margin-right:auto}.ml-1{margin-left:.25rem}.mt-2{margin-top:.5rem}.mr-2{margin-right:.5rem}.ml-2{margin-left:.5rem}.mt-4{margin-top:1rem}.ml-4{margin-left:1rem}.mt-8{margin-top:2rem}.ml-12{margin-left:3rem}.-mt-px{margin-top:-1px}.max-w-6xl{max-width:72rem}.min-h-screen{min-height:100vh}.overflow-hidden{overflow:hidden}.p-6{padding:1.5rem}.py-4{padding-top:1rem;padding-bottom:1rem}.px-6{padding-left:1.5rem;padding-right:1.5rem}.pt-8{padding-top:2rem}.fixed{position:fixed}.relative{position:relative}.top-0{top:0}.right-0{right:0}.shadow{box-shadow:0 1px 3px 0 rgba(0,0,0,.1),0 1px 2px 0 rgba(0,0,0,.06)}.text-center{text-align:center}.text-gray-200{--text-opacity:1;color:#edf2f7;color:rgba(237,242,247,var(--text-opacity))}.text-gray-300{--text-opacity:1;color:#e2e8f0;color:rgba(226,232,240,var(--text-opacity))}.text-gray-400{--text-opacity:1;color:#cbd5e0;color:rgba(203,213,224,var(--text-opacity))}.text-gray-500{--text-opacity:1;color:#a0aec0;color:rgba(160,174,192,var(--text-opacity))}.text-gray-600{--text-opacity:1;color:#718096;color:rgba(113,128,150,var(--text-opacity))}.text-gray-700{--text-opacity:1;color:#4a5568;color:rgba(74,85,104,var(--text-opacity))}.text-gray-900{--text-opacity:1;color:#1a202c;color:rgba(26,32,44,var(--text-opacity))}.underline{text-decoration:underline}.antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.w-5{width:1.25rem}.w-8{width:2rem}.w-auto{width:auto}.grid-cols-1{grid-template-columns:repeat(1,minmax(0,1fr))}@media (min-width:640px){.sm\:rounded-lg{border-radius:.5rem}.sm\:block{display:block}.sm\:items-center{align-items:center}.sm\:justify-start{justify-content:flex-start}.sm\:justify-between{justify-content:space-between}.sm\:h-20{height:5rem}.sm\:ml-0{margin-left:0}.sm\:px-6{padding-left:1.5rem;padding-right:1.5rem}.sm\:pt-0{padding-top:0}.sm\:text-left{text-align:left}.sm\:text-right{text-align:right}}@media (min-width:768px){.md\:border-t-0{border-top-width:0}.md\:border-l{border-left-width:1px}.md\:grid-cols-2{grid-template-columns:repeat(2,minmax(0,1fr))}}@media (min-width:1024px){.lg\:px-8{padding-left:2rem;padding-right:2rem}}@media (prefers-color-scheme:dark){.dark\:bg-gray-800{--bg-opacity:1;background-color:#2d3748;background-color:rgba(45,55,72,var(--bg-opacity))}.dark\:bg-gray-900{--bg-opacity:1;background-color:#1a202c;background-color:rgba(26,32,44,var(--bg-opacity))}.dark\:border-gray-700{--border-opacity:1;border-color:#4a5568;border-color:rgba(74,85,104,var(--border-opacity))}.dark\:text-white{--text-opacity:1;color:#fff;color:rgba(255,255,255,var(--text-opacity))}.dark\:text-gray-400{--text-opacity:1;color:#cbd5e0;color:rgba(203,213,224,var(--text-opacity))}.dark\:text-gray-500{--tw-text-opacity:1;color:#6b7280;color:rgba(107,114,128,var(--tw-text-opacity))}}
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
            #voyager-loader {
                display: flex;
                justify-content: center;
                align-items: center;
            }
            #image-loader {
                animation: spin 2s linear infinite;
                width: 100px;
                height: 100px;
            }
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
                height: 300px;
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
                text-align: center;
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                grid-auto-rows: 320px;
                align-items: center;
                justify-items: center;
                align-content: center;
            }
            .logo-img {
                width: 30%;
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
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div id="voyager-loader">
                    <img id="image-loader" src="http://192.168.1.8:8000/admin/voyager-assets?path=images%2Flogo-icon.png" alt="Voyager Loader">
                </div>
                <div class="flex justify-center mt-4 sm:items-center sm:justify-between">
                    <div class="ml-4 text-center text-sm text-gray-500 sm:text-right sm:ml-0">
                        Cargando pasarela de pago...
                    </div>
                </div>
               
                <div style="display: none;">
                    <!-- <form method="post" action="https://checkout.payulatam.com/ppp-web-gateway-payu/"> -->
                    <form method="post" action="https://checkout.payulatam.com/ppp-web-gateway-payu/">
                        <input  id="merchantId"  name="merchantId"              type="hidden"  value="999442"   >
                        <input  id="accountId"  name="accountId"                type="hidden"  value="1008095" >
                        <input  id="description"  name="description"            type="hidden"  value=""  >
                        <input  id="referenceCode"  name="referenceCode"        type="hidden"  value="" >
                        <input  id="amount"  name="amount"                      type="hidden"  value=""   >
                        <input  id="tax"  name="tax"                            type="hidden"  value="0"  >
                        <input  id="taxReturnBase"  name="taxReturnBase"        type="hidden"  value="0" >
                        <input  id="currency"  name="currency"                  type="hidden"  value="COP" >
                        <input  id="signature"  name="signature"                type="hidden"  value=""  >
                        <input  id="test"  name="test"                          type="hidden"  value="0" >
                        <input  id="buyerEmail"  name="buyerEmail"              type="hidden"  value="" >
                        <input  id="responseUrl"  name="responseUrl"            type="hidden"  value="https://picksure.com/responsepay/response.php" >
                        <input  id="confirmationUrl"  name="confirmationUrl"    type="hidden"  value="https://picksure.com/confirmationpay/response.php" >
                        <input  id="submit"  name="Submit"                      type="submit"  value="Pagar" >
                    </form>
                </div>

                <div class="flex justify-center mt-4 sm:items-center sm:justify-between">
                    <div class="text-center text-sm text-gray-500 sm:text-left"></div>

                    <div class="ml-4 text-center text-sm text-gray-500 sm:text-right sm:ml-0">
                        Hecho por ZIEL - v1.1.0
                    </div>
                </div>

                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <img src="" alt="Imagenes" class="rounded" id="imgModal">
                    </div>
                </div>
                <input id="hash" name="hash" type="hidden"  value="{{$key}}" >
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/js-md5@0.8.3/src/md5.min.js"></script>
    <script>
        (function(){
            var appContainer = document.querySelector('.app-container'),
                sidebar = appContainer.querySelector('.side-menu'),
                navbar = appContainer.querySelector('nav.navbar.navbar-top'),
                loader = document.getElementById('voyager-loader'),
                hamburgerMenu = document.querySelector('.hamburger'),
                sidebarTransition = sidebar.style.transition,
                navbarTransition = navbar.style.transition,
                containerTransition = appContainer.style.transition;

            sidebar.style.WebkitTransition = sidebar.style.MozTransition = sidebar.style.transition =
            appContainer.style.WebkitTransition = appContainer.style.MozTransition = appContainer.style.transition =
            navbar.style.WebkitTransition = navbar.style.MozTransition = navbar.style.transition = 'none';

            if (window.innerWidth > 768 && window.localStorage && window.localStorage['voyager.stickySidebar'] == 'true') {
                appContainer.className += ' expanded no-animation';
                loader.style.left = (sidebar.clientWidth/2)+'px';
                hamburgerMenu.className += ' is-active no-animation';
            }

            navbar.style.WebkitTransition = navbar.style.MozTransition = navbar.style.transition = navbarTransition;
            sidebar.style.WebkitTransition = sidebar.style.MozTransition = sidebar.style.transition = sidebarTransition;
            appContainer.style.WebkitTransition = appContainer.style.MozTransition = appContainer.style.transition = containerTransition;
        })();
    </script>
    <script>
        function decryptText(encryptedText) {
            const decrypted = CryptoJS.AES.decrypt(encryptedText, 'secretKey');
            const originalText = decrypted.toString(CryptoJS.enc.Utf8);
            const parseData = JSON.parse(originalText)
            console.log('desencriptado === ',parseData)
            return parseData;
        }
        function decrypt_data(string) {
            console.log('paso... = ', string)
            var newString = '',
            char, codeStr, firstCharCode, lastCharCode;
            string = string.match(/.{1,4}/g).reduce((acc,char)=>acc+String.fromCharCode(parseInt(char, 16)),"");
            for (var i = 0; i < string.length; i++) {
                char = string.charCodeAt(i);
                if (char > 132) {
                    codeStr = char.toString(10);

                    firstCharCode = parseInt(codeStr.substring(0, codeStr.length - 2), 10);

                    lastCharCode = parseInt(codeStr.substring(codeStr.length - 2, codeStr.length), 10) + 31;

                    newString += String.fromCharCode(firstCharCode) + String.fromCharCode(lastCharCode);
                } else {
                    newString += string.charAt(i);
                }
            }
            console.log('desencriptado === ',newString)
            let result = JSON.parse(newString)
            return result;
        }
        function filter(id) {
            console.log('id ', id)
        }
        async function getCategories() {
            console.log("llego cat")
            const response = await fetch("/api/v1/categories/ES");
            const categories = await response.json();
            let html_categories = ''
            if(categories.status == 200){
                let data_categories = categories.data
                data_categories.forEach(element => {
                    html_categories += '<button type="button" class="btn btn-categories" onclick="filter('+element.id+')">'+element.name+'</button>'
                });
            }
            $("#content_categories").html(html_categories)
            console.log(categories);
        }

        async function getImages() {
            console.log("llego")
            const response = await fetch("/api/v1/imageproducts/ES/100/0");
            const images = await response.json();
            let html_imgs = ''
            if(images.status == 200){
                let data_images = images.data
                data_images.forEach(element => {
                    html_imgs += '<img src="/storage/'+element.img_url+'" alt="'+element.title+'" class="rounded img">'
                });
            }
            $("#content_images").html(html_imgs)
            console.log(images);

            const imagenes_sel = document.querySelectorAll('.img');
            console.log("leggo")
            const imgModal = document.querySelector('#imgModal')

            
            imagenes_sel.forEach(img => {
                img.addEventListener('click', (e) => {
                    imgModal.src = e.target.src  
                    e.target.setAttribute('data-toggle', 'modal')
                    e.target.setAttribute('data-target', '#exampleModal')    
                })
            })
        }

        async function saveProcessPay(data_body) {
            const res_pay_suscription = await fetch(`/api/v1/user/pay_suscription`, {
                method: 'POST', //Request Type
                //body: formData, //post body
                body: JSON.stringify(data_body),
                headers: {
                    "Content-Type": "application/json",
                },
            });
            await res_pay_suscription.json();
        }
        
        $( document ).ready(function() {
            let key = atob($('#hash').val())

            const dataPay = decryptText(key)
            const apiKey = 'aeajec3aw51153Z26HIYIe8DnZ'
            const merchantId = $('#merchantId').val()
            const accountId = $('#accountId').val()
            const btn = document.getElementById('submit')

            const amount = dataPay.amount
            const payment_description = dataPay.payment_description
            const reference_code = dataPay.reference_code
            const buyer_email = dataPay.buyer_email
            const signature = md5(`${apiKey}~${merchantId}~${reference_code}~${amount}~COP`);

            saveProcessPay(dataPay)

            $('#amount').val(amount)
            $('#description').val(`PICKSURE - ${payment_description}`)
            $('#referenceCode').val(reference_code)
            $('#buyerEmail').val(buyer_email)
            $('#signature').val(signature)

            

            btn.click();
        });
    </script>
</html>
