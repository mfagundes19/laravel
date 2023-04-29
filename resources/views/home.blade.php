<div class="content-header">    
    <div class="container-fluid">
        <div class="row mb-2 row-content-header">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Dashboard</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Index</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{$number_receipt_plans}}</h3>
                        <p>Planos de Recebimento</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{ url('receipt-plans') }}" class="small-box-footer">Ver Mais <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-4 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{$number_receivement}}</h3>
                        <p>Recebimentos</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="{{ url('receivement') }}" class="small-box-footer">Ver Mais <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-4 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{$number_users}}</h3>
                        <p>Usuários Registrados</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="{{ url('users') }}" class="small-box-footer">Ver Mais <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>


