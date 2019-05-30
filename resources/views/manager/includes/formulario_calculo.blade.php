<div class="row">
    <form class="form" method="POST" action="{{ route('manager.atualizar')}}">
        {!! csrf_field() !!}
        
        <div class="form-group col-md-5">
            <label>Servidor: </label>
            <div class="input-group col-md-3" style="width: 100%;">
                <span class="input-group-addon">NOME</span>
                <select name="matricula" class="form-control">
                    <option value="{{Auth::user()->n_folha}}" selected>{{Auth::user()->nome}}</option>
                    @foreach ($funcionarios as $funcionario)
                        @if($funcionario->n_folha !== Auth::user()->n_folha)
                            <option value="{{$funcionario->n_folha}}">{{$funcionario->nome}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group col-md-3">
                <label>Período: </label>
                <div class="input-group date">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input name="periodo" type="text" class="form-control pull-right" id="datepicker" value="{{ $registros['rangePicker'] }}">
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