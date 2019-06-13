<div class="row">
    <form class="form" method="POST" action="{{ route('user.batidas.read')}}">
        {!! csrf_field() !!}
        
        <div class="form-group col-md-5">
            <label>Servidor: </label>
                <h4>{{Auth::user()->nome}}</h4>
                <input id="matricula" name="matricula" type="hidden" value="{{Auth::user()->n_folha}}">
        </div>

        <div class="form-group col-md-3">
                <label>Período: </label>
                <div class="input-group date">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input name="periodo" type="text" class="form-control pull-right" id="datepicker" value="{{ $registros['periodoString'] }}">
                </div>
            <!-- /.input group -->
        </div>

        <div class="form-group col-md-3" >
            <label></label>
            <div class="input-group">
                <button class="btn btn-success btn-add" type="submit"><span class="glyphicon glyphicon-refresh"></span> Atualizar</button>
            </div>
        </div>

    </form>
</div>