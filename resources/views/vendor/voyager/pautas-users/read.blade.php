@extends('voyager::master')

@section('page_title', __('voyager::generic.view').' '.$dataType->getTranslatedAttribute('display_name_singular'))

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i> {{ __('voyager::generic.viewing') }} {{ ucfirst($dataType->getTranslatedAttribute('display_name_singular')) }} &nbsp;

        @can('edit', $dataTypeContent)
            <a href="{{ route('voyager.'.$dataType->slug.'.edit', $dataTypeContent->getKey()) }}" class="btn btn-info">
                <i class="glyphicon glyphicon-pencil"></i> <span class="hidden-xs hidden-sm">{{ __('voyager::generic.edit') }}</span>
            </a>
        @endcan
        @can('delete', $dataTypeContent)
            @if($isSoftDeleted)
                <a href="{{ route('voyager.'.$dataType->slug.'.restore', $dataTypeContent->getKey()) }}" title="{{ __('voyager::generic.restore') }}" class="btn btn-default restore" data-id="{{ $dataTypeContent->getKey() }}" id="restore-{{ $dataTypeContent->getKey() }}">
                    <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm">{{ __('voyager::generic.restore') }}</span>
                </a>
            @else
                <a href="javascript:;" title="{{ __('voyager::generic.delete') }}" class="btn btn-danger delete" data-id="{{ $dataTypeContent->getKey() }}" id="delete-{{ $dataTypeContent->getKey() }}">
                    <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm">{{ __('voyager::generic.delete') }}</span>
                </a>
            @endif
        @endcan
        @can('browse', $dataTypeContent)
        <a href="{{ route('voyager.'.$dataType->slug.'.index') }}" class="btn btn-warning">
            <i class="glyphicon glyphicon-list"></i> <span class="hidden-xs hidden-sm">{{ __('voyager::generic.return_to_list') }}</span>
        </a>
        @endcan
    </h1>
    @include('voyager::multilingual.language-selector')
@stop

@section('content')
    <div class="page-content read container-fluid">
        <div class="row">
            <div class="col-md-4">

                <div class="panel panel-bordered" style="padding-bottom:5px;">
                    <!-- form start -->
                    @foreach($dataType->readRows as $row)
                        @if ($row->field == 'id')
                            <input type="hidden" id="id_pauta" value="{{ $dataTypeContent->{$row->field} }}" />
                        @endif

                        @if ($row->field == 'status' || $row->field == 'img_url' || $row->field == 'created_at' || $row->field == 'start_date' || $row->field == 'end_date' || $row->field == 'valor')
                            @php
                                if ($dataTypeContent->{$row->field.'_read'}) {
                                    $dataTypeContent->{$row->field} = $dataTypeContent->{$row->field.'_read'};
                                }
                            @endphp
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">{{ $row->getTranslatedAttribute('display_name') }}</h3>
                            </div>
                       
                            <div class="panel-body" style="padding-top:0;">
                                @if($row->type == "image")
                                    <a href="/admin/imageproducts/{{$images_pautas[0]->id}}">
                                        <img class="img-responsive"
                                            src="{{ filter_var($dataTypeContent->{$row->field}, FILTER_VALIDATE_URL) ? $dataTypeContent->{$row->field} : Voyager::image($dataTypeContent->{$row->field}) }}">
                                    </a>
                                @elseif($row->type == 'relationship')
                                    @include('voyager::formfields.relationship', ['view' => 'read', 'options' => $row->details])
                                @elseif($row->type == 'number')
                                    @if ($row->field == 'status')
                                        <div id="content-state">
                                            @if ($dataTypeContent->{$row->field} == 1)
                                                <span class="badge badge-success">Activo</span>
                                            @else
                                                <span class="badge badge-danger">Inactivo</span>
                                            @endif
                                        </div>
                                        <input type="hidden" id="status_pauta" value="{{ $dataTypeContent->{$row->field} }}" />
                                    @else
                                        {{ $dataTypeContent->{$row->field} }}
                                    @endif
                                @else
                                    @include('voyager::multilingual.input-hidden-bread-read')
                                    <p>{{ $dataTypeContent->{$row->field} }}</p>
                                @endif
                            </div><!-- panel-body -->
                            
                            @if(!$loop->last)
                                <hr style="margin:0;">
                            @endif
                        @endif
                    @endforeach

                </div>
            </div>
            <div class="col-md-8">
                <div class="col-md-6">
                    <div class="panel panel-bordered" style="padding-bottom:5px;">
                        <div class="panel-heading" style="border-bottom:0;">
                            <h3 class="panel-title">Categorias Relacionadas</h3>
                        </div>
                        <div class="panel-body" style="padding-top:0;">
                            @foreach($categories as $key => $value)
                                <span class="badge badge-primary badge-pill">{{ $value->name }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="panel panel-bordered" style="padding-bottom:5px;">
                        <div class="panel-heading" style="border-bottom:0;">
                            <h3 class="panel-title">Paises Relacionados</h3>
                        </div>
                        <div class="panel-body" style="padding-top:0;">
                            @foreach($locations as $key => $value)
                                <span class="badge badge-secondary badge-pill">{{ $value->name }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="panel panel-bordered" style="padding-bottom:5px;padding-top:5px;">
                        @foreach($dataType->readRows as $row)
                            @if ($row->field == 'description' || $row->field == 'destination_url')
                                <div class="panel-heading" style="border-bottom:0;">
                                    <h3 class="panel-title">{{ $row->getTranslatedAttribute('display_name') }}</h3>
                                </div>
                                <div class="panel-body" style="padding-top:0;">
                                    @include('voyager::multilingual.input-hidden-bread-read')
                                    <p>{{ $dataTypeContent->{$row->field} }}

                                        @if($row->field == 'destination_url')
                                            @if($dataTypeContent->{$row->field} != '')
                                                <a href="{{ $dataTypeContent->{$row->field} }}" target="_blank"><i class="glyphicon glyphicon-share"></i></a>
                                            @endif
                                        @endif
                                    </p>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                @if(count($images_pautas) > 1 )
                    <div class="col-md-12">
                        <div class="panel panel-bordered" style="padding-bottom:5px;">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Imagenes</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                @foreach($images_pautas as $file)
                                    <div class="col-md-4">
                                        <a href="/admin/imageproducts/{{$file->id}}">
                                            <img class="img-responsive" src="{{ filter_var($file->img_url, FILTER_VALIDATE_URL) ? $file->img_url : Voyager::image($file->img_url) }}">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
                <div id="content-state-btn" class="col-md-12">
                    @foreach($dataType->readRows as $row)
                        @if ($row->field == 'status')
                            @if ($dataTypeContent->{$row->field} == 2)
                                <button id="btn_status_change" type="button" class="btn btn-secondary btn-lg btn-block" onclick="setPauta()"><i class="voyager-x" ></i> Rechazar</button>
                            @else
                                <button id="btn_status_change" type="button" class="btn btn-primary btn-lg btn-block" onclick="setPauta()"><i class="voyager-check"></i> Aprobar</button>
                            @endif
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Single delete modal --}}
    <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('voyager::generic.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="voyager-trash"></i> {{ __('voyager::generic.delete_question') }} {{ strtolower($dataType->getTranslatedAttribute('display_name_singular')) }}?</h4>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('voyager.'.$dataType->slug.'.index') }}" id="delete_form" method="POST">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm"
                               value="{{ __('voyager::generic.delete_confirm') }} {{ strtolower($dataType->getTranslatedAttribute('display_name_singular')) }}">
                    </form>
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@stop

@section('javascript')
    @if ($isModelTranslatable)
        <script>
            $(document).ready(function () {
                $('.side-body').multilingual();
            });
        </script>
    @endif
    <script>
        var deleteFormAction;
        $('.delete').on('click', function (e) {
            var form = $('#delete_form')[0];

            if (!deleteFormAction) {
                // Save form action initial value
                deleteFormAction = form.action;
            }

            form.action = deleteFormAction.match(/\/[0-9]+$/)
                ? deleteFormAction.replace(/([0-9]+$)/, $(this).data('id'))
                : deleteFormAction + '/' + $(this).data('id');

            $('#delete_modal').modal('show');
        });

        async function setPauta() {
            let dataupdate = {
                id: $('#id_pauta').val(),
                status: $('#status_pauta').val() == 1 ? 2 : 1
            }
            const response = await fetch("/api/v1/pautasusers/active",{
                method: 'POST', //Request Type
                body: JSON.stringify(dataupdate), //post body
                headers: {
                    "Content-Type": "application/json",
                },
            });
            const state_pauta = await response.json();
            if(state_pauta.status == 200){
                let class_state_active = '<span class="badge badge-success">Activo</span>' 
                let class_state_inactive = '<span class="badge badge-danger">Inactivo</span>'
                let class_state_update = $('#status_pauta').val() == 1 ? class_state_inactive : class_state_active 
                $('#content-state').html(class_state_update)
                let class_btn_active = '<button id="btn_status_change" type="button" class="btn btn-primary btn-lg btn-block" onclick="setPauta()"><i class="voyager-check"></i> Activar</button>' 
                let class_btn_inactive = '<button id="btn_status_change" type="button" class="btn btn-secondary btn-lg btn-block" onclick="setPauta()"><i class="voyager-x" ></i> Eliminar</button>'
                let class_btn_update = $('#status_pauta').val() == 1 ? class_btn_active : class_btn_inactive
                $('#content-state-btn').html(class_btn_update)

                let change_value_state = $('#status_pauta').val() == 1 ? 2 : 1
                $('#status_pauta').val(change_value_state)
            }
        }
        
       
    </script>
@stop
