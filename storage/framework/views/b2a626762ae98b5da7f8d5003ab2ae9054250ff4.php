<?php
    $edit = !is_null($dataTypeContent->getKey());
    $add  = is_null($dataTypeContent->getKey());
?>



<?php $__env->startSection('css'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_title', __('voyager::generic.'.($edit ? 'edit' : 'add')).' '.$dataType->getTranslatedAttribute('display_name_singular')); ?>

<?php $__env->startSection('page_header'); ?>
    <h1 class="page-title">
        <i class="<?php echo e($dataType->icon); ?>"></i>
        <?php echo e(__('voyager::generic.'.($edit ? 'edit' : 'add')).' '.$dataType->getTranslatedAttribute('display_name_singular')); ?>

    </h1>
    <?php echo $__env->make('voyager::multilingual.language-selector', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-content edit-add container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-bordered">
                    <!-- form start -->
                    <form role="form"
                            class="form-edit-add"
                            action="<?php echo e($edit ? route('voyager.'.$dataType->slug.'.update', $dataTypeContent->getKey()) : route('voyager.'.$dataType->slug.'.store')); ?>"
                            method="POST" enctype="multipart/form-data">
                        <!-- PUT Method if we are editing -->
                        <?php if($edit): ?>
                            <?php echo e(method_field("PUT")); ?>

                        <?php endif; ?>

                        <!-- CSRF TOKEN -->
                        <?php echo e(csrf_field()); ?>


                        <div class="panel-body">

                            <?php if(count($errors) > 0): ?>
                                <div class="alert alert-danger">
                                    <ul>
                                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li><?php echo e($error); ?></li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                            <?php endif; ?>

                            <!-- Adding / Editing -->
                            <?php
                                $dataTypeRows = $dataType->{($edit ? 'editRows' : 'addRows' )};
                            ?>

                            <?php $__currentLoopData = $dataTypeRows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <!-- GET THE DISPLAY OPTIONS -->
                                <?php
                                    $display_options = $row->details->display ?? NULL;
                                    if ($dataTypeContent->{$row->field.'_'.($edit ? 'edit' : 'add')}) {
                                        $dataTypeContent->{$row->field} = $dataTypeContent->{$row->field.'_'.($edit ? 'edit' : 'add')};
                                    }
                                ?>
                                <?php if(isset($row->details->legend) && isset($row->details->legend->text)): ?>
                                    <legend class="text-<?php echo e($row->details->legend->align ?? 'center'); ?>" style="background-color: <?php echo e($row->details->legend->bgcolor ?? '#f0f0f0'); ?>;padding: 5px;"><?php echo e($row->details->legend->text); ?></legend>
                                <?php endif; ?>

                                <div class="form-group <?php if($row->type == 'hidden'): ?> hidden <?php endif; ?> col-md-<?php echo e($display_options->width ?? 12); ?> <?php echo e($errors->has($row->field) ? 'has-error' : ''); ?>" <?php if(isset($display_options->id)): ?><?php echo e("id=$display_options->id"); ?><?php endif; ?>>
                                    <?php echo e($row->slugify); ?>

                                    <label class="control-label" for="name"><?php echo e($row->getTranslatedAttribute('display_name')); ?></label>
                                    <?php echo $__env->make('voyager::multilingual.input-hidden-bread-edit-add', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    <?php if($add && isset($row->details->view_add)): ?>
                                        <?php echo $__env->make($row->details->view_add, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' => $dataTypeContent, 'content' => $dataTypeContent->{$row->field}, 'view' => 'add', 'options' => $row->details], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    <?php elseif($edit && isset($row->details->view_edit)): ?>
                                        <?php echo $__env->make($row->details->view_edit, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' => $dataTypeContent, 'content' => $dataTypeContent->{$row->field}, 'view' => 'edit', 'options' => $row->details], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    <?php elseif(isset($row->details->view)): ?>
                                        <?php echo $__env->make($row->details->view, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' => $dataTypeContent, 'content' => $dataTypeContent->{$row->field}, 'action' => ($edit ? 'edit' : 'add'), 'view' => ($edit ? 'edit' : 'add'), 'options' => $row->details], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    <?php elseif($row->type == 'relationship'): ?>
                                        <?php echo $__env->make('voyager::formfields.relationship', ['options' => $row->details], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    <?php else: ?>
                                        <?php echo app('voyager')->formField($row, $dataType, $dataTypeContent); ?>

                                    <?php endif; ?>

                                    <?php $__currentLoopData = app('voyager')->afterFormFields($row, $dataType, $dataTypeContent); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $after): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php echo $after->handle($row, $dataType, $dataTypeContent); ?>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($errors->has($row->field)): ?>
                                        <?php $__currentLoopData = $errors->get($row->field); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <span class="help-block"><?php echo e($error); ?></span>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

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
									<?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option 
											value="<?php echo e($language->prefijo); ?>"
										>
											<?php echo e($language->name); ?>

										</option>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
											<?php $__currentLoopData = $itemTexts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<tr id="item-<?php echo e($value->language); ?>">												
													<td>
														<?php echo e($value->title); ?>

														<input type="hidden" name="title[]" value="<?php echo e($value->title); ?>" />
													</td>
													<td>
														<?php echo e($value->language); ?>

														<input type="hidden" name="language[]" value="<?php echo e($value->language); ?>" />                            
													</td>
													
													<td> 
														<button type="button" class="btn btn-danger btn-sm" onclick="deleteItem(<?php echo e($value->language_id); ?>)">-</button>
													</td>
												</tr>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										</tbody>
									</table>
									</div>
								</div>
							</div>
						</div>
					</div>

                        </div><!-- panel-body -->

                       
												

                        <div class="panel-footer">
                            <?php $__env->startSection('submit-buttons'); ?>
                                <button type="submit" class="btn btn-primary save"><?php echo e(__('voyager::generic.save')); ?></button>
                            <?php $__env->stopSection(); ?>
                            <?php echo $__env->yieldContent('submit-buttons'); ?>
                        </div>
                    </form>

                    <div style="display:none">
                        <input type="hidden" id="upload_url" value="<?php echo e(route('voyager.upload')); ?>">
                        <input type="hidden" id="upload_type_slug" value="<?php echo e($dataType->slug); ?>">
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
                    <h4 class="modal-title"><i class="voyager-warning"></i> <?php echo e(__('voyager::generic.are_you_sure')); ?></h4>
                </div>

                <div class="modal-body">
                    <h4><?php echo e(__('voyager::generic.are_you_sure_delete')); ?> '<span class="confirm_delete_name"></span>'</h4>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo e(__('voyager::generic.cancel')); ?></button>
                    <button type="button" class="btn btn-danger" id="confirm_delete"><?php echo e(__('voyager::generic.delete_confirm')); ?></button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Delete File Modal -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
    <script>
        var params = {};
        var $file;

        function deleteHandler(tag, isMulti) {
          return function() {
            $file = $(this).siblings(tag);

            params = {
                slug:   '<?php echo e($dataType->slug); ?>',
                filename:  $file.data('file-name'),
                id:     $file.data('id'),
                field:  $file.parent().data('field-name'),
                multi: isMulti,
                _token: '<?php echo e(csrf_token()); ?>'
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

            <?php if($isModelTranslatable): ?>
                $('.side-body').multilingual({"editing": true});
            <?php endif; ?>

            $('.side-body input[data-slug-origin]').each(function(i, el) {
                $(el).slugify();
            });

            $('.form-group').on('click', '.remove-multi-image', deleteHandler('img', true));
            $('.form-group').on('click', '.remove-single-image', deleteHandler('img', false));
            $('.form-group').on('click', '.remove-multi-file', deleteHandler('a', true));
            $('.form-group').on('click', '.remove-single-file', deleteHandler('a', false));

            $('#confirm_delete').on('click', function(){
                $.post('<?php echo e(route('voyager.'.$dataType->slug.'.media.remove')); ?>', params, function (response) {
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
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('voyager::master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u395993619/domains/picksure.tech/public_html/resources/views/vendor/voyager/categories/edit-add.blade.php ENDPATH**/ ?>