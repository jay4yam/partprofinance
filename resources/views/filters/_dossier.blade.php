<div class="box">
    {{ Form::open([ 'route' => 'dossiers.index', 'method' => 'GET', 'class' => 'form-inline']) }}
    @if(Auth::user()->role == 'admin')
        <div class="form-group sep">
            {{ Form::select('user', $commerciaux, '', ['class' => 'form-control', 'placeholder' => 'choisissez un commercial']) }}
        </div>
    @endif
    <div class="form-group sep">
        {{ Form::select('annee', $dossierYears, '', ['class' => 'form-control', 'placeholder' => 'choisissez l\'annee']) }}
    </div>
    <div class="form-group sep">
        {{ Form::select('mois', $dossierMonths, '', ['class' => 'form-control', 'placeholder' => 'choisissez le mois']) }}
    </div>
    <div class="form-group sep">
        {{ Form::select('status', ['Refusé'=>'Refusé','A l étude'=>'A l étude','Accepté'=> 'Accepté','Payé'=>'Payé','Impayé'=>'Impayé'], '', ['class' => 'form-control', 'placeholder' => 'choisissez le status']) }}
    </div>
    <div class="form-group sep">
        {{ Form::text('search', null, ['class' => 'form-control', 'placeholder' => 'recherche par nom']) }}
    </div>
    <div class="form-group sep">
        {{ Form::label('iban', 'iban') }}
        {{ Form::checkbox('iban', null, false) }}
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-success">
            <i class="fa fa-search" aria-hidden="true"></i> Filtre
        </button>
    </div>
    <div class="form-group">
        <a href="{{ url()->route('dossiers.index') }}" class="btn btn-warning">raz filtre</a>
    </div>
    {{ Form::close() }}
</div>