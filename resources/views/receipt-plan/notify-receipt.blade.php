<div class="row">
    <div class="container-fluid">
        {!! Form::open(['url' => url($route->module.'/notify-receipt'),'id' => 'form-'.$route->module,'method' => 'POST','data-action' => url($route->module.'/notify-receipt'),'data-refresh' => true]) !!}  
        {!! Form::hidden('receipt_plan_id', $receipt_plan_id ?? '', ['id' => 'receipt_plan_id']) !!}
        {!! Form::hidden('notify_hash', $datetime ?? '', ['id' => 'notify_hash']) !!}
        <div class="col-lg-12 box-form-container">
            <div class="col-lg-12">
                {!! Form::label('Observações') !!}:
                {!! Form::textarea('observations',$observations ?? '', ['id' => 'observations','class' => 'form-control','placeholder' => 'Observações','rows' => 3]) !!}   
            </div>
            <div class="col-lg-12"><br></div>
            <div class="col-lg-12">
                <div class="text-right">
                    <button type="button" class="btn btn-primary btn-sm" onclick="Application.onValidateModal(this);">
                        Registrar Chegada
                    </button>
                </div>
            </div>
        </div>
        <div class="col-lg-12"><br></div>
        <div class="col-lg-12">
            <table class="table table-bordered table-list">
                <thead>
                    <tr style="vertical-align: middle !important;">
                        <th width="15%" class="text-left">Data</th>
                        <th width="15%" class="text-center">Hora</th>
                        <th width="15%" class="text-center">Usuário</th>
                        <th width="45%" class="text-center">Observações</th>
                        <th width="10%" class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($list as $element)
                        <tr>
                            <td>{{\Carbon\Carbon::parse($element->date)->format('d/m/Y')}}</td>
                            <td>{{$element->hour}}</td>
                            <td>{{$element->user}}</td>
                            <td class="text-center">{{$element->observations}}</td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm btn-icon" data-action="{{url($route->module.'/delete-notify-receipt')}}" data-id="{{$element->id}}" onclick="Application.onRemoveModal(this);" data-toggle="tooltip" data-placement="left" title="Excluir" data-original-title="Excluir">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </button>       
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4">Nenhum registro encontrado...</td></tr>
                    @endforelse     
                </tbody>
            </table>
        </div>
        {!! Form::close() !!}
    </div>
</div><br>

<script type="application/javascript">
    $(document).ready(function(){
        Application.onReady();
    });
</script>
    