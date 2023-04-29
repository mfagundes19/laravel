<div class="row">
    <div class="container-fluid">
        <div class="col-lg-12 box-form-container">
            {!! Form::open(['url' => url($route->module.'/payment/'.$consortium_id),'id' => 'form-'.$route->module,'method' => 'POST','data-action' => url($route->module.'/payment/'.$consortium_id),'data-refresh' => true]) !!}  
                {!! Form::hidden('consortium_id', $consortium_id ?? '', ['id' => 'consortium_id']) !!}
                {!! Form::hidden('chargeback_cancel', '', ['id' => 'chargeback_cancel']) !!}
                
            {!! Form::close() !!}
        </div>
    </div>
</div>

<script type="application/javascript">
    $(document).ready(function(){
        Application.onReady();
    });
</script>
    
    