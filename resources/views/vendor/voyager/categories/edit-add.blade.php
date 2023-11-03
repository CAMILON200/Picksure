@php
    $edit = !is_null($dataTypeContent->getKey());
    $add  = is_null($dataTypeContent->getKey());
@endphp

@extends('voyager::master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop
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

                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            
							<fieldset id="img-content" class="upload_dropZone text-center mb-3 p-4">

								<div class="icon voyager-upload upload_svg"></div>

								<p class="small my-2">Arrastre y suelte la(s) imagen(es) de fondo dentro de la región punteada<br><i>ó</i></p>

								<input name="image_category" id="image_category" data-post-name="image_background"  class="position-absolute invisible" type="file" accept="image/jpeg, image/png, image/svg+xml" />

								<label class="btn btn-primary mb-3" for="image_category">Seleccionar archivo(s)</label>

								<div class="upload_gallery d-flex flex-wrap justify-content-center gap-3 mb-0"></div>
								@if($edit)
									<div class="image_gallery" style="display:flex; justify-content: center">
										<img class="" style="max-width: 20%;" src="{{ filter_var($dataTypeContent->img_url, FILTER_VALIDATE_URL) ? $dataTypeContent->img_url : Voyager::image($dataTypeContent->img_url) }}">
									</div>
								@endif
							</fieldset>

                            <!-- Adding / Editing -->
                            @php
                                $dataTypeRows = $dataType->{($edit ? 'editRows' : 'addRows' )};
                            @endphp

                            @foreach($dataTypeRows as $row)
                                <!-- GET THE DISPLAY OPTIONS -->
                                @php
                                    $display_options = $row->details->display ?? NULL;
                                    if ($dataTypeContent->{$row->field.'_'.($edit ? 'edit' : 'add')}) {
                                        $dataTypeContent->{$row->field} = $dataTypeContent->{$row->field.'_'.($edit ? 'edit' : 'add')};
                                    }
                                @endphp
                                @if (isset($row->details->legend) && isset($row->details->legend->text))
                                    <legend class="text-{{ $row->details->legend->align ?? 'center' }}" style="background-color: {{ $row->details->legend->bgcolor ?? '#f0f0f0' }};padding: 5px;">{{ $row->details->legend->text }}</legend>
                                @endif

                                <div class="form-group @if($row->type == 'hidden') hidden @endif col-md-{{ $display_options->width ?? 12 }} {{ $errors->has($row->field) ? 'has-error' : '' }}" @if(isset($display_options->id)){{ "id=$display_options->id" }}@endif>
                                    {{ $row->slugify }}
                                    <label class="control-label" for="name">{{ $row->getTranslatedAttribute('display_name') }}</label>
                                    @include('voyager::multilingual.input-hidden-bread-edit-add')
                                    @if ($add && isset($row->details->view_add))
                                        @include($row->details->view_add, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' => $dataTypeContent, 'content' => $dataTypeContent->{$row->field}, 'view' => 'add', 'options' => $row->details])
                                    @elseif ($edit && isset($row->details->view_edit))
                                        @include($row->details->view_edit, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' => $dataTypeContent, 'content' => $dataTypeContent->{$row->field}, 'view' => 'edit', 'options' => $row->details])
                                    @elseif (isset($row->details->view))
                                        @include($row->details->view, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' => $dataTypeContent, 'content' => $dataTypeContent->{$row->field}, 'action' => ($edit ? 'edit' : 'add'), 'view' => ($edit ? 'edit' : 'add'), 'options' => $row->details])
                                    @elseif ($row->type == 'relationship')
                                        @include('voyager::formfields.relationship', ['options' => $row->details])
                                    @else
                                        {!! app('voyager')->formField($row, $dataType, $dataTypeContent) !!}
                                    @endif

                                    @foreach (app('voyager')->afterFormFields($row, $dataType, $dataTypeContent) as $after)
                                        {!! $after->handle($row, $dataType, $dataTypeContent) !!}
                                    @endforeach
                                    @if ($errors->has($row->field))
                                        @foreach ($errors->get($row->field) as $error)
                                            <span class="help-block">{{ $error }}</span>
                                        @endforeach
                                    @endif
                                </div>
                            @endforeach

                            <div class="form-group itemInfo">
							<input type="hidden" name="setting_tab" class="setting_tab" />
							<div class="mt-3">
								<h3 class="panel-title">Agregar información de la Categoría</h3>
								<div id="messsage-item" class="text-danger"></div>
							</div>
							<div class="col-md-4">
								<label for="title">Nombre de Categoría</label>
								<input type="text" class="form-control" name="title" id="title" placeholder="Escribe el nombre">
							</div>
							
							<div class="col-md-4">
								<label for="group">Idioma</label>
								<select class="form-control" name="language" id="language">
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
							
							
							<div class="col-md-4">
								<div class="form-group">
									<button type="button" class="btn btn-primary pull-right new-setting-btn" 
										id="itemTextsImageProducts" onclick="addCategoryLanguage()">
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
														<button type="button" class="btn btn-danger btn-sm" onclick="deleteItem({{ $value->language_id }})">-</button>
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

                        </div><!-- panel-body -->

                       
												

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
        function addTextName(){
            let name = $('#name-category').val()
            let language = $('#lenguage option:selected')
            $('#messsage-item').html('')
            if(name == ''){
                $('#messsage-item').html('Los campos son obligatorios')
            }else {
                if ($('#item-'+language.val()).length) {
                    $('#messsage-item').html('Ya existe un Item con el mismo idioma ' + language.text())
                }else{
                    $('#columnItemText').append(`
                        <tr id="item-${language.val()}">												
                            <td>
                                ${name}
                                <input type="hidden" name="nametext[]" value="${name}" />
                            </td>
                            <td>
                                <input type="hidden" name="language[]" value="${language.val()}" />
                                ${language.text()}
                            </td>
                            <td> 
                                <button type="button" class="btn btn-danger btn-sm" onclick="deleteItem(${language.val()})">-</button>
                            </td>
                        </tr>
                    `)
                    $('#name-category').val('')
                }
            }
        }

        function addCategoryLanguage(){
			let title = $('#title').val()
			let language = $('#language option:selected')
            console.log(language.val())
			$('#messsage-item').html('')
			if(title == ''){
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
								<input type="hidden" name="language[]" value="${language.val()}" />
								${language.val()}
							</td>
							<td> 
								<button type="button" class="btn btn-danger btn-sm" onclick="deleteItem('${language.val()}')">-</button>
							</td>
						</tr>
					`)
					$('#title').val('')

                
					
				}
			}
		}

        function deleteItem(id){
            
            $('#item-'+id).remove();
        }

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
			const isImageFile = file => ['image/jpeg', 'image/png', 'image/svg+xml'].includes(file.type);

			const isCSVFile = file => ['text/csv'].includes(file.type);

			function previewFiles(dataRefs) {
				
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
						$(".image_gallery").css('display', 'none')
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
						if(item.type === 'text/csv') return isCSVFile(item) ? item: null;
						else console.log('Not an image, ', item.type);
					}
					return isImageFile(item) ? item : null;
				});

				if (!files.length) return;
				let maxSize = $("#size_img").val()
				let weightImg = Math.round(dataRefs.files[0].size / 1024);
				if(weightImg > maxSize){
					//this.files[0].size gets the size of your file and then you can validate accourdingly...
					alert('No se puese cargar la imagen');
					return false
				}

				dataRefs.files = files;
				previewFiles(dataRefs);
				imageUpload(dataRefs);
			}

		})();
    </script>
@stop
