@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing').' '.$dataType->getTranslatedAttribute('display_name_plural'))

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="{{ $dataType->icon }}"></i> {{ $dataType->getTranslatedAttribute('display_name_plural') }}
        </h1>
        @can('add', app($dataType->model_name))
            <a href="{{ route('voyager.'.$dataType->slug.'.create') }}" class="btn btn-success btn-add-new">
                <i class="voyager-plus"></i> <span>{{ __('voyager::generic.add_new') }}</span>
            </a>
        @endcan
        @can('delete', app($dataType->model_name))
            @include('voyager::partials.bulk-delete')
        @endcan
        @can('edit', app($dataType->model_name))
            @if(!empty($dataType->order_column) && !empty($dataType->order_display_column))
                <a href="{{ route('voyager.'.$dataType->slug.'.order') }}" class="btn btn-primary btn-add-new">
                    <i class="voyager-list"></i> <span>{{ __('voyager::bread.order') }}</span>
                </a>
            @endif
        @endcan
        @can('delete', app($dataType->model_name))
            @if($usesSoftDeletes)
                <input type="checkbox" @if ($showSoftDeleted) checked @endif id="show_soft_deletes" data-toggle="toggle" data-on="{{ __('voyager::bread.soft_deletes_off') }}" data-off="{{ __('voyager::bread.soft_deletes_on') }}">
            @endif
        @endcan
        @foreach($actions as $action)
            @if (method_exists($action, 'massAction'))
                @include('voyager::bread.partials.actions', ['action' => $action, 'data' => null])
            @endif
        @endforeach
        @include('voyager::multilingual.language-selector')
    </div>
@stop

@section('content')
    <div class="page-content browse container-fluid">
        @include('voyager::alerts')
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        @if ($isServerSide)
                            <form method="get" class="form-search">
                                <div id="search-input">
                                    <div class="col-2">
                                        <select id="search_key" name="key">
                                            @foreach($searchNames as $key => $name)
                                                <option value="{{ $key }}" @if($search->key == $key || (empty($search->key) && $key == $defaultSearchKey)) selected @endif>{{ $name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-2">
                                        <select id="filter" name="filter">
                                            <option value="contains" @if($search->filter == "contains") selected @endif>{{ __('voyager::generic.contains') }}</option>
                                            <option value="equals" @if($search->filter == "equals") selected @endif>=</option>
                                        </select>
                                    </div>
                                    <div class="input-group col-md-12">
                                        <input type="text" class="form-control" placeholder="{{ __('voyager::generic.search') }}" name="s" value="{{ $search->value }}">
                                        <span class="input-group-btn">
                                            <button class="btn btn-info btn-lg" type="submit">
                                                <i class="voyager-search"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                @if (Request::has('sort_order') && Request::has('order_by'))
                                    <input type="hidden" name="sort_order" value="{{ Request::get('sort_order') }}">
                                    <input type="hidden" name="order_by" value="{{ Request::get('order_by') }}">
                                @endif
                            </form>
                        @endif
                        <div class="table-responsive">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="financial-tab" data-toggle="tab" data-target="#financial" type="button" role="tab" aria-controls="financial" aria-selected="true">Financial</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="integration-tab" data-toggle="tab" data-target="#integration" type="button" role="tab" aria-controls="integration" aria-selected="false">Integration</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="images-tab" data-toggle="tab" data-target="#images" type="button" role="tab" aria-controls="images" aria-selected="false">Images</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="financial" role="tabpanel" aria-labelledby="financial-tab">
                                    @foreach($dataTypeContent as $data)
                                        <div>
                                           
                                            @foreach($dataType->browseRows as $row)
                                            
                                                <div>
                                                    <!-- {"id":10,"name_parameter":"suscription_twelve_month","value_parameter":"480000","created_at":"2023-11-17T04:13:20.000000Z","updated_at":"2023-11-17T04:13:20.000000Z"} -->
                                                
                                                    @if (isset($row->details->view_browse))
                                                        @include($row->details->view_browse, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' => $dataTypeContent, 'content' => $data->{$row->field}, 'view' => 'browse', 'options' => $row->details])
                                                   
                                                    @elseif($row->type == 'text')
                                                        
                                                        @if ($data->name_parameter == 'suscription_twelve_month')
                                                            <label>Suscription twelve month</label>
                                                            <input type="number" id="{{ $data->value_parameter }}" value="{{ $data->{$row->field} }}"/>
                                                        @endif
                                                        @if ($data->name_parameter == 'suscription_three_month')
                                                            <label>Suscription three month</label>
                                                            <input type="number" id="{{ $data->value_parameter }}" value="{{ $data->{$row->field} }}"/>
                                                        @endif
                                                        @if ($data->name_parameter == 'suscription_one_month')
                                                            <label>Suscription one month</label>
                                                            <input type="number" id="{{ $data->value_parameter }}" value="{{ $data->{$row->field} }}"/>
                                                        @endif
                                                        
                                                        @if ($data->name_parameter == 'price_per_images_pauta')
                                                            <label>Price per images pauta</label>
                                                            <input type="number" id="{{ $data->value_parameter }}" value="{{ $data->{$row->field} }}"/>
                                                        @endif
                                                    
                                                    @else
                                                        @include('voyager::multilingual.input-hidden-bread-browse')
                                                        <span>{{ $data->{$row->field} }}</span>
                                                    @endif
                                                </div>
                                            @endforeach
                                            
                                        </div>
                                    @endforeach
                                </div>
                                <div class="tab-pane fade" id="integration" role="tabpanel" aria-labelledby="integration-tab">
                                    @foreach($dataTypeContent as $data)
                                        <div>
                                           
                                            @foreach($dataType->browseRows as $row)
                                            
                                                <div>
                                                    <!-- {"id":10,"name_parameter":"suscription_twelve_month","value_parameter":"480000","created_at":"2023-11-17T04:13:20.000000Z","updated_at":"2023-11-17T04:13:20.000000Z"} -->
                                                
                                                    @if (isset($row->details->view_browse))
                                                        @include($row->details->view_browse, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' => $dataTypeContent, 'content' => $data->{$row->field}, 'view' => 'browse', 'options' => $row->details])
                                                   
                                                    @elseif($row->type == 'text')
                                                        
                                                        <!-- @if ($data->name_parameter == 'url_drive_bulck_load')
                                                            <label>URL drive bulck load</label>
                                                            <input type="text" id="{{ $data->value_parameter }}" value="{{ $data->{$row->field} }}"/>
                                                        @endif -->

                                                    
                                                    @else
                                                        @include('voyager::multilingual.input-hidden-bread-browse')
                                                        <span>{{ $data->{$row->field} }}</span>
                                                    @endif
                                                </div>
                                            @endforeach
                                            
                                        </div>
                                    @endforeach
                                </div>
                                <div class="tab-pane fade" id="images" role="tabpanel" aria-labelledby="images-tab">
                                    @foreach($dataTypeContent as $data)
                                        <div>
                                           
                                            @foreach($dataType->browseRows as $row)
                                            
                                                <div>
                                                    <!-- {"id":10,"name_parameter":"suscription_twelve_month","value_parameter":"480000","created_at":"2023-11-17T04:13:20.000000Z","updated_at":"2023-11-17T04:13:20.000000Z"} -->
                                                
                                                    @if (isset($row->details->view_browse))
                                                        @include($row->details->view_browse, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' => $dataTypeContent, 'content' => $data->{$row->field}, 'view' => 'browse', 'options' => $row->details])
                                                   
                                                    @elseif($row->type == 'text')
                                                        
                                                        @if ($data->name_parameter == 'max_upload_images')
                                                            <label>Max upload images</label>
                                                            <input type="number" id="{{ $data->value_parameter }}" value="{{ $data->{$row->field} }}"/>
                                                        @endif
                                                        @if ($data->name_parameter == 'max_images_per_pauta')
                                                            <label>Max images per pauta</label>
                                                            <input type="number" id="{{ $data->value_parameter }}" value="{{ $data->{$row->field} }}"/>
                                                        @endif
                                                        @if ($data->name_parameter == 'max_images_pautadas_per_pagination')
                                                            <label>Max images pautadas per pagination</label>
                                                            <input type="number" id="{{ $data->value_parameter }}" value="{{ $data->{$row->field} }}"/>
                                                        @endif
                                                        @if ($data->name_parameter == 'max_images_per_pagination')
                                                            <label>Max images per pagination</label>
                                                            <input type="number" id="{{ $data->value_parameter }}" value="{{ $data->{$row->field} }}"/>
                                                        @endif
                                                        @if ($data->name_parameter == 'max_weight_image')
                                                            <label>Max weight image</label>
                                                            <input type="number" id="{{ $data->value_parameter }}" value="{{ $data->{$row->field} }}"/>
                                                        @endif
                                                
                                                    @else
                                                        @include('voyager::multilingual.input-hidden-bread-browse')
                                                        <span>{{ $data->{$row->field} }}</span>
                                                    @endif
                                                </div>
                                            @endforeach
                                            
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                                
                                    @foreach($dataTypeContent as $data)
                                        <div>
                                           
                                            @foreach($dataType->browseRows as $row)
                                            
                                                <div>
                                                    <!-- {"id":10,"name_parameter":"suscription_twelve_month","value_parameter":"480000","created_at":"2023-11-17T04:13:20.000000Z","updated_at":"2023-11-17T04:13:20.000000Z"} -->
                                                
                                                    @if (isset($row->details->view_browse))
                                                        @include($row->details->view_browse, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' => $dataTypeContent, 'content' => $data->{$row->field}, 'view' => 'browse', 'options' => $row->details])
                                                   
                                                    @elseif($row->type == 'text')
                                                        
                                                        @if ($data->name_parameter == 'suscription_twelve_month')
                                                            <label>Suscription twelve month</label>
                                                            <input type="number" id="{{ $data->value_parameter }}" value="{{ $data->{$row->field} }}"/>
                                                        @endif
                                                        @if ($data->name_parameter == 'suscription_three_month')
                                                            <label>Suscription three month</label>
                                                            <input type="number" id="{{ $data->value_parameter }}" value="{{ $data->{$row->field} }}"/>
                                                        @endif
                                                        @if ($data->name_parameter == 'suscription_one_month')
                                                            <label>Suscription one month</label>
                                                            <input type="number" id="{{ $data->value_parameter }}" value="{{ $data->{$row->field} }}"/>
                                                        @endif
                                                        @if ($data->name_parameter == 'max_upload_images')
                                                            <label>Max upload images</label>
                                                            <input type="number" id="{{ $data->value_parameter }}" value="{{ $data->{$row->field} }}"/>
                                                        @endif
                                                        @if ($data->name_parameter == 'max_images_per_pauta')
                                                            <label>Max images per pauta</label>
                                                            <input type="number" id="{{ $data->value_parameter }}" value="{{ $data->{$row->field} }}"/>
                                                        @endif
                                                        @if ($data->name_parameter == 'max_images_pautadas_per_pagination')
                                                            <label>Max images pautadas per pagination</label>
                                                            <input type="number" id="{{ $data->value_parameter }}" value="{{ $data->{$row->field} }}"/>
                                                        @endif
                                                        @if ($data->name_parameter == 'max_images_per_pagination')
                                                            <label>Max images per pagination</label>
                                                            <input type="number" id="{{ $data->value_parameter }}" value="{{ $data->{$row->field} }}"/>
                                                        @endif
                                                        @if ($data->name_parameter == 'price_per_images_pauta')
                                                            <label>Price per images pauta</label>
                                                            <input type="number" id="{{ $data->value_parameter }}" value="{{ $data->{$row->field} }}"/>
                                                        @endif
                                                        @if ($data->name_parameter == 'max_weight_image')
                                                            <label>Max weight image</label>
                                                            <input type="number" id="{{ $data->value_parameter }}" value="{{ $data->{$row->field} }}"/>
                                                        @endif
                                                        @if ($data->name_parameter == 'url_drive_bulck_load')
                                                            <label>URL drive bulck load</label>
                                                            <input type="text" id="{{ $data->value_parameter }}" value="{{ $data->{$row->field} }}"/>
                                                        @endif

                                                    
                                                    @else
                                                        @include('voyager::multilingual.input-hidden-bread-browse')
                                                        <span>{{ $data->{$row->field} }}</span>
                                                    @endif
                                                </div>
                                            @endforeach
                                            
                                        </div>
                                    @endforeach
                        </div>
                        @if ($isServerSide)
                            <div class="pull-left">
                                <div role="status" class="show-res" aria-live="polite">{{ trans_choice(
                                    'voyager::generic.showing_entries', $dataTypeContent->total(), [
                                        'from' => $dataTypeContent->firstItem(),
                                        'to' => $dataTypeContent->lastItem(),
                                        'all' => $dataTypeContent->total()
                                    ]) }}</div>
                            </div>
                            <div class="pull-right">
                                {{ $dataTypeContent->appends([
                                    's' => $search->value,
                                    'filter' => $search->filter,
                                    'key' => $search->key,
                                    'order_by' => $orderBy,
                                    'sort_order' => $sortOrder,
                                    'showSoftDeleted' => $showSoftDeleted,
                                ])->links() }}
                            </div>
                        @endif
                    </div>
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
                    <form action="#" id="delete_form" method="POST">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm" value="{{ __('voyager::generic.delete_confirm') }}">
                    </form>
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@stop

@section('css')
@if(!$dataType->server_side && config('dashboard.data_tables.responsive'))
    <link rel="stylesheet" href="{{ voyager_asset('lib/css/responsive.dataTables.min.css') }}">
@endif
@stop

@section('javascript')
    <!-- DataTables -->
    @if(!$dataType->server_side && config('dashboard.data_tables.responsive'))
        <script src="{{ voyager_asset('lib/js/dataTables.responsive.min.js') }}"></script>
    @endif
    <script>
        $(document).ready(function () {
            @if (!$dataType->server_side)
                var table = $('#dataTable').DataTable({!! json_encode(
                    array_merge([
                        "order" => $orderColumn,
                        "language" => __('voyager::datatable'),
                        "columnDefs" => [
                            ['targets' => 'dt-not-orderable', 'searchable' =>  false, 'orderable' => false],
                        ],
                    ],
                    config('voyager.dashboard.data_tables', []))
                , true) !!});
            @else
                $('#search-input select').select2({
                    minimumResultsForSearch: Infinity
                });
            @endif

            @if ($isModelTranslatable)
                $('.side-body').multilingual();
                //Reinitialise the multilingual features when they change tab
                $('#dataTable').on('draw.dt', function(){
                    $('.side-body').data('multilingual').init();
                })
            @endif
            $('.select_all').on('click', function(e) {
                $('input[name="row_id"]').prop('checked', $(this).prop('checked')).trigger('change');
            });

            
        });

        async function setPauta(id, state) {
                let dataupdate = {
                    id: id,
                    status: state
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
                    let class_state_active = '<span class="badge badge-success">Aprobado</span>' 
                    let class_state_inactive = '<span class="badge badge-danger">Rechazado</span>'
                    let class_state_update = state == 1 ? class_state_active : class_state_inactive
                    $('#content-state-'+id).html(class_state_update)
                    let class_btn_active = '<a href="javascript:void(0)" onclick="setPauta('+id+',2)" class="badge badge-primary" title="Aprobar Pauta"><i class="voyager-check"></i></a>' 
                    let class_btn_inactive = '<a href="javascript:void(0)" onclick="setPauta('+id+',0)" class="badge badge-secondary" title="Rechazar Pauta"><i class="voyager-x"></i></a>'
                    let class_btn_update = state == 2 ? class_btn_inactive : class_btn_active   
                    $('#action-status-'+id).html(class_btn_update)

                }
            }

        var deleteFormAction;
        $('td').on('click', '.delete', function (e) {
            $('#delete_form')[0].action = '{{ route('voyager.'.$dataType->slug.'.destroy', '__id') }}'.replace('__id', $(this).data('id'));
            $('#delete_modal').modal('show');
        });

        @if($usesSoftDeletes)
            @php
                $params = [
                    's' => $search->value,
                    'filter' => $search->filter,
                    'key' => $search->key,
                    'order_by' => $orderBy,
                    'sort_order' => $sortOrder,
                ];
            @endphp
            $(function() {
                $('#show_soft_deletes').change(function() {
                    if ($(this).prop('checked')) {
                        $('#dataTable').before('<a id="redir" href="{{ (route('voyager.'.$dataType->slug.'.index', array_merge($params, ['showSoftDeleted' => 1]), true)) }}"></a>');
                    }else{
                        $('#dataTable').before('<a id="redir" href="{{ (route('voyager.'.$dataType->slug.'.index', array_merge($params, ['showSoftDeleted' => 0]), true)) }}"></a>');
                    }

                    $('#redir')[0].click();
                })
            })
        @endif
        $('input[name="row_id"]').on('change', function () {
            var ids = [];
            $('input[name="row_id"]').each(function() {
                if ($(this).is(':checked')) {
                    ids.push($(this).val());
                }
            });
            $('.selected_ids').val(ids);
        });
    </script>
@stop
