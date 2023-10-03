<style>
	:root {
		--colorPrimaryNormal: #00b3bb;
		--colorPrimaryDark: #00979f;
		--colorPrimaryGlare: #00cdd7;
		--colorPrimaryHalf: #000000;
		--colorPrimaryQuarter: #bfecee;
		--colorPrimaryEighth: #dff5f7;
		--colorPrimaryPale: #f3f5f7;
		--colorPrimarySeparator: #f3f5f7;
		--colorPrimaryOutline: #dff5f7;
		--colorButtonNormal: #00b3bb;
		--colorButtonHover: #00cdd7;
		--colorLinkNormal: #00979f;
		--colorLinkHover: #00cdd7;
	}
	.upload_dropZone {
		color: #0f3c4b;
		background-color: var(--colorPrimaryPale, #c8dadf);
		outline: 2px dashed var(--colorPrimaryHalf, #c1ddef);
		outline-offset: -12px;
		transition:
			outline-offset 0.2s ease-out,
			outline-color 0.3s ease-in-out,
			background-color 0.2s ease-out;
	}
	.upload_dropZone.highlight {
		outline-offset: -4px;
		outline-color: var(--colorPrimaryNormal, #0576bd);
		background-color: var(--colorPrimaryEighth, #c8dadf);
	}
	.upload_svg {
		fill: var(--colorPrimaryNormal, #0576bd)!important;
		vertical-align: middle;
		display: contents!important;
	}
	.btn-upload {
		color: #fff;
		background-color: var(--colorPrimaryNormal);
	}
	.btn-upload:hover,
	.btn-upload:focus {
		color: #fff;
		background-color: var(--colorPrimaryGlare);
	}
	.icon {
		font-size: 40px;
	}
	.upload_img {
		width: calc(33.333% - (2rem / 3));
		object-fit: contain;
	}
	.position-absolute {
		position: absolute!important;
	}
	.p-4 {
		padding: 1.5rem!important;
	}
	.mb-3 {
		margin-bottom: 1rem!important;
	}
</style>
@php
	$edit = !is_null($dataTypeContent->getKey());
	$add  = is_null($dataTypeContent->getKey());
@endphp
@extends('voyager::master')

@section('css')
<meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('page_title', __('voyager::generic.'.($edit ? 'edit' : 'add')).' '.$dataType->getTranslatedAttribute('display_name_singular'))
@section('page_header')
<h1 class="page-title">
	<i class="{{ $dataType->icon }}"></i>
	{{ __('voyager::generic.'.($edit ? 'edit' : 'add')).' '.$dataType->getTranslatedAttribute('display_name_singular') }}
</h1>
@include('voyager::multilingual.language-selector')
@stop

@section('content')
	<div class="page-content edit-add container-fluid">
		<div class="row">
			<div class="col-md-12">

				<div class="panel panel-bordered">
					<!-- form start -->
					<form role="form"
						class="form-edit-add"
						action="{{ $edit ? route('voyager.'.$dataType->slug.'.update', $dataTypeContent->getKey()) : route('voyager.'.$dataType->slug.'.store') }}"
						method="POST" enctype="multipart/form-data">
					<!-- PUT Method if we are editing -->
					@if($edit)
						{{ method_field("PUT") }}
					@endif

					<!-- CSRF TOKEN -->
					{{ csrf_field() }}

					
					<div class="panel-body">
						@if(!$edit)
							<div class="form-check">
								<input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" value="1" checked>
								<label class="form-check-label" for="flexRadioDefault1">
									Subir Imagen
								</label>
							</div>
							<div class="form-check">
								<input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" value="2">
								<label class="form-check-label" for="flexRadioDefault2">
									Url de la Imagen
								</label>
							</div>
							<div class="form-check">
								<input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault3" value="3">
								<label class="form-check-label" for="flexRadioDefault3">
									Subir Imagenes por CSV
								</label>
							</div>
						@endif

						<fieldset id="img-content" class="upload_dropZone text-center mb-3 p-4">


							<div class="icon voyager-upload upload_svg"></div>

							<p class="small my-2">Arrastre y suelte la(s) imagen(es) de fondo dentro de la región punteada<br><i>ó</i></p>

							<input name="image_product" id="image_product" data-post-name="image_background"  class="position-absolute invisible" type="file" accept="image/jpeg, image/png, image/svg+xml" />

							<label class="btn btn-primary mb-3" for="image_product">Seleccionar archivo(s)</label>

							<div class="upload_gallery d-flex flex-wrap justify-content-center gap-3 mb-0"></div>

						</fieldset>

						<fieldset id="upload_csv" class="upload_dropZone text-center mb-3 p-4" style="display:none;">

                        
							<a href="{{$url_bulck_load}}" target="_blank" type="button" class="btn btn-primary pull-center new-setting-btn">Descargar Plantilla CSV</a>
							</br>
							
							<div class="icon voyager-upload upload_svg"></div>

							<p class="small my-2">Arrastre y suelte el archivo<br><i>ó</i></p>

							<input name="image_product_2" id="image_product_2" data-post-name="image_background"  class="position-absolute invisible" type="file" accept=".csv" />

							<label class="btn btn-primary mb-3" for="image_product_2">Seleccionar archivo(s)</label>

							<div class="upload_gallery d-flex flex-wrap justify-content-center gap-3 mb-0"></div>

						</fieldset>

						<div class="form-group">
							<div id="url-content" class="col-md-12" style="display: none;">
								<label for="title">URL</label>
								<input type="text" class="form-control" name="img_url" id="img_url" placeholder="storage/posts/post2.jpg">
							</div>
						</div>
						
						<div class="form-group itemCat">
							<div class="col-md-12">
								<label for="description">Selecciona la Categoría</label>
								<div class="categories-product" style="height:auto !important; margin-bottom:30px !important">
									@foreach($categories as $category)
										<div class="form-check">
											<input type="checkbox" name="category[]" value="{{ $category->id }}" 
												class="form-check-input" 
												@if ($category->selected)
													checked
												@endif
												>
											<label class="form-check-label">{{ $category->name }}</label>
										</div>
									@endforeach
								</div>
							</div>
						</div>
						<input type="hidden" name="is_public" class="is_public" value="1"/>
						<input type="hidden" name="status" class="status" value="1"/>
						<input type="hidden" name="user_id" class="user_id" value="{{Auth::user()->id}}"/>

						<hr>
						<div class="form-group itemInfo">
							<input type="hidden" name="setting_tab" class="setting_tab" />
							<div class="">
								<h3 class="panel-title">Agregar información de la imágen</h3>
								<div id="messsage-item" class="text-danger"></div>
							</div>
							<div class="col-md-3">
								<label for="title">Título</label>
								<input type="text" class="form-control" name="title" id="title" placeholder="Escribe el título">
							</div>
							
							<div class="col-md-3">
								<label for="group">Idioma</label>
								<select class="form-control" name="lenguage" id="lenguage">
									<option  value=""> Seleccione </option>
									@foreach($languages as $language)
										<option 
											value="{{$language->prefijo}}"
										>
											{{$language->name}}
										</option>
									@endforeach
								</select>
							</div>
							<div class="col-md-3">
								<label for="description">Descripción</label>
								<textarea class="form-control" name="description" id="description" placeholder="Descripción del modelo" ></textarea>
							</div>
							
							<div class="col-md-3">
								<div class="form-group">
									<button type="button" class="btn btn-primary pull-right new-setting-btn" 
										id="itemTextsImageProducts" onclick="addItemImageProducts()">
										<i class="voyager-plus"></i>Agregar texto
									</button>
								</div>
							</div>
						</div>
					</div>
					<div class="panel-body itemTable">
						<div class="row">
							<div class="col-12">
								<div class="card px2">
									<div class="card-body">
									<table class="table table-hover">
										<thead>
											<tr>
												<th scope="col">Título</th>
												<th scope="col">Descripción</th>
												<th scope="col">Idioma</th>
												<th scope="col">Acciones</th>
											</tr>
										</thead>
										<tbody id="columnItemText">
											@foreach($itemTexts as $key => $value)
												<tr id="item-{{ $value->language }}">												
													<td>
														{{ $value->title }}
														<input type="hidden" name="title[]" value="{{ $value->title }}" />
													</td>
													<td>
														{{ $value->language }}
														<input type="hidden" name="language[]" value="{{ $value->language }}" />                            
													</td>
													<td>
														{{ $value->description }}
														<input type="hidden" name="description[]" value="{{ $value->description }}" />
													</td>
													<td> 
														<button type="button" class="btn btn-danger btn-sm" onclick="deleteItem('{{ $value->language }}')">-</button>
													</td>
												</tr>
											@endforeach
										</tbody>
									</table>
									</div>
								</div>
							</div>
						</div>
					</div>

					@section('item-text-imageproducts')

					@endsection

					<div class="panel-footer">
						@section('submit-buttons')
							<button type="submit" class="btn btn-primary save">{{ __('voyager::generic.save') }}</button>
						@stop
						@yield('submit-buttons')
					</div>
					</form>

					<div style="display:none">
						<input type="hidden" id="upload_url" value="{{ route('voyager.upload') }}">
						<input type="hidden" id="upload_type_slug" value="{{ $dataType->slug }}">
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade modal-danger" id="confirm_delete_modal">
		<div class="modal-dialog">
			<div class="modal-content">

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"
						aria-hidden="true">&times;</button>
					<h4 class="modal-title"><i class="voyager-warning"></i> {{ __('voyager::generic.are_you_sure') }}</h4>
				</div>

				<div class="modal-body">
					<h4>{{ __('voyager::generic.are_you_sure_delete') }} '<span class="confirm_delete_name"></span>'</h4>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
					<button type="button" class="btn btn-danger" id="confirm_delete">{{ __('voyager::generic.delete_confirm') }}</button>
				</div>
			</div>
		</div>
	</div>
	<!-- End Delete File Modal -->
@stop

@section('javascript')
	<script>
		var params = {};
		var $file;

		const radioButtons = document.querySelectorAll('input[name="flexRadioDefault"]');
		for (const radioButton of radioButtons) {
			radioButton.addEventListener('change', showSelected);
		}

		function showSelected(e) {
			if (this.checked) {
				console.log("dmdndn = ", this.value)
				if(this.value == 1){
					$("#img-content").show()
					$("#url-content").hide()
					$("#upload_csv").hide()
					$(".itemCat").show()
					$(".itemInfo").show()
					$(".itemTable").show()
				}else if (this.value == 2){
					$("#img-content").hide()
					$("#url-content").show()
					$("#upload_csv").hide()
					$(".itemCat").show()
					$(".itemInfo").show()
					$(".itemTable").show()
				}
				else
				{
					$("#img-content").hide()
					$("#url-content").hide()
					$("#upload_csv").show()
					$(".itemCat").hide()
					$(".itemInfo").hide()
					$(".itemTable").hide()
				}

			}
		}
		
		function deleteHandler(tag, isMulti) {
			return function() {
				$file = $(this).siblings(tag);

				params = {
					slug:   '{{ $dataType->slug }}',
					filename:  $file.data('file-name'),
					id:     $file.data('id'),
					field:  $file.parent().data('field-name'),
					multi: isMulti,
					_token: '{{ csrf_token() }}'
				}

				$('.confirm_delete_name').text(params.filename);
				$('#confirm_delete_modal').modal('show');
			};
		}

		$('document').ready(function () {
			$('.toggleswitch').bootstrapToggle();

			//Init datepicker for date fields if data-datepicker attribute defined
			//or if browser does not handle date inputs
			$('.form-group input[type=date]').each(function (idx, elt) {
				if (elt.hasAttribute('data-datepicker')) {
					elt.type = 'text';
					$(elt).datetimepicker($(elt).data('datepicker'));
				} else if (elt.type != 'date') {
					elt.type = 'text';
					$(elt).datetimepicker({
						format: 'L',
						extraFormats: [ 'YYYY-MM-DD' ]
					}).datetimepicker($(elt).data('datepicker'));
				}
			});

			@if ($isModelTranslatable)
				$('.side-body').multilingual({"editing": true});
			@endif

			$('.side-body input[data-slug-origin]').each(function(i, el) {
				$(el).slugify();
			});

			$('.form-group').on('click', '.remove-multi-image', deleteHandler('img', true));
			$('.form-group').on('click', '.remove-single-image', deleteHandler('img', false));
			$('.form-group').on('click', '.remove-multi-file', deleteHandler('a', true));
			$('.form-group').on('click', '.remove-single-file', deleteHandler('a', false));

			$('#confirm_delete').on('click', function(){
				$.post('{{ route('voyager.'.$dataType->slug.'.media.remove') }}', params, function (response) {
					if ( response
						&& response.data
						&& response.data.status
						&& response.data.status == 200 ) {

						toastr.success(response.data.message);
						$file.parent().fadeOut(300, function() { $(this).remove(); })
					} else {
						toastr.error("Error removing file.");
					}
				});

				$('#confirm_delete_modal').modal('hide');
			});
			$('[data-toggle="tooltip"]').tooltip();

		});

		function downloadTemplate(){
			
			let csvData = 'Titulo;Idioma;Imagen_Url;Descripcion;Categoria\n';
   
         
			// Download the CSV file
			let anchor = document.createElement('a');
			anchor.href = 'data:text/csv;charset=utf-8,' + encodeURI(csvData);
			anchor.target = '_blank';
			anchor.download = 'List_Images.csv';
			anchor.click(); 

	


		}

		function addItemImageProducts(){
			let title = $('#title').val()
			let description = $('#description').val()
			let language = $('#lenguage')
			$('#messsage-item').html('')
			if(title == '' || description == ''){
				$('#messsage-item').html('Los campos son obligatorios')
			}else {
				if ($('#item-'+language.val()).length) {
					$('#messsage-item').html('Ya existe un Item con el mismo idioma ' + language.val())
				}else{
					$('#columnItemText').append(`
						<tr id="item-${language.val()}">												
							<td>
								${title}
								<input type="hidden" name="title[]" value="${title}" />
							</td>
							<td>
								${description}
								<input type="hidden" name="description[]" value="${description}" />
							</td>
							<td>
								<input type="hidden" name="language[]" value="${language.val()}" />
								${language.val()}
							</td>
							<td> 
								<button type="button" class="btn btn-danger btn-sm" onclick="deleteItem('${language.val()}')">-</button>
							</td>
						</tr>
					`)
					$('#title').val('')
					$('#description').val('')
				}
			}
		}

		function deleteItem(id){
			$('#item-'+id).remove()
		}

	console.clear();
('use strict');


// Drag and drop - single or multiple image files
// https://www.smashingmagazine.com/2018/01/drag-drop-file-uploader-vanilla-js/
// https://codepen.io/joezimjs/pen/yPWQbd?editors=1000
(function () {
    console.log("llegooooo")
  'use strict';
  
  // Four objects of interest: drop zones, input elements, gallery elements, and the files.
  // dataRefs = {files: [image files], input: element ref, gallery: element ref}

  const preventDefaults = event => {
    event.preventDefault();
    event.stopPropagation();
  };

  const highlight = event =>
    event.target.classList.add('highlight');
  
  const unhighlight = event =>
    event.target.classList.remove('highlight');

  const getInputAndGalleryRefs = element => {
    const zone = element.closest('.upload_dropZone') || false;
    const gallery = zone.querySelector('.upload_gallery') || false;
    const input = zone.querySelector('input[type="file"]') || false;
    return {input: input, gallery: gallery};
  }

  const handleDrop = event => {
    const dataRefs = getInputAndGalleryRefs(event.target);
    dataRefs.files = event.dataTransfer.files;
    handleFiles(dataRefs);
  }


  const eventHandlers = zone => {

    const dataRefs = getInputAndGalleryRefs(zone);
    if (!dataRefs.input) return;

    // Prevent default drag behaviors
    ;['dragenter', 'dragover', 'dragleave', 'drop'].forEach(event => {
      zone.addEventListener(event, preventDefaults, false);
      document.body.addEventListener(event, preventDefaults, false);
    });

    // Highlighting drop area when item is dragged over it
    ;['dragenter', 'dragover'].forEach(event => {
      zone.addEventListener(event, highlight, false);
    });
    ;['dragleave', 'drop'].forEach(event => {
      zone.addEventListener(event, unhighlight, false);
    });

    // Handle dropped files
    zone.addEventListener('drop', handleDrop, false);

    // Handle browse selected files
    dataRefs.input.addEventListener('change', event => {
      dataRefs.files = event.target.files;
      handleFiles(dataRefs);
    }, false);

  }


  // Initialise ALL dropzones
  const dropZones = document.querySelectorAll('.upload_dropZone');
  for (const zone of dropZones) {
    eventHandlers(zone);
  }


  // No 'image/gif' or PDF or webp allowed here, but it's up to your use case.
  // Double checks the input "accept" attribute
  const isImageFile = file => 
    ['image/jpeg', 'image/png', 'image/svg+xml'].includes(file.type);

	const isCSVFile = file =>['text/csv'].includes(file.type);

  function previewFiles(dataRefs) {
	console.log(dataRefs.files[0].type);
	
    if (!dataRefs.gallery) return;

	if(dataRefs.files[0].type==="text/csv")
	{
		let text = document.createElement('p');
		text.className = 'mt-2';
		let oText = document.createTextNode(dataRefs.files[0].name);
		text.appendChild(oText);
		dataRefs.gallery.appendChild(text);
	}
	else{
    for (const file of dataRefs.files) {
      let reader = new FileReader();
      reader.readAsDataURL(file);
      reader.onloadend = function() {
        let img = document.createElement('img');
        img.className = 'upload_img mt-2';
        img.setAttribute('alt', file.name);
        img.src = reader.result;
        dataRefs.gallery.appendChild(img);
      }
    }
  }
}

  // Based on: https://flaviocopes.com/how-to-upload-files-fetch/
  const imageUpload = dataRefs => {

    // Multiple source routes, so double check validity
    if (!dataRefs.files || !dataRefs.input) return;

    const url = dataRefs.input.getAttribute('data-post-url');
    if (!url) return;

    const name = dataRefs.input.getAttribute('data-post-name');
    if (!name) return;

    const formData = new FormData();
    formData.append(name, dataRefs.files);

    fetch(url, {
      method: 'POST',
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      console.log('posted: ', data);
      if (data.success === true) {
        previewFiles(dataRefs);
      } else {
        console.log('URL: ', url, '  name: ', name)
      }
    })
    .catch(error => {
      console.error('errored: ', error);
    });
  }


  // Handle both selected and dropped files
  const handleFiles = dataRefs => {

    let files = [...dataRefs.files];

    // Remove unaccepted file types
    files = files.filter(item => {
      if (!isImageFile(item)) {
		if(item.type === 'text/csv')
		{
			return isCSVFile(item) ? item: null;
		}
		else
		{
        console.log('Not an image, ', item.type);
		}
       
      }
      return isImageFile(item) ? item : null;
    });

    if (!files.length) return;
    dataRefs.files = files;

    previewFiles(dataRefs);
    imageUpload(dataRefs);
  }

})();

	</script>
@stop
