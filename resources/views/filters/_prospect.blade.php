<div class="box">
    {{ Form::open([ 'route' => 'prospect.index', 'method' => 'GET', 'class' => 'form-inline']) }}
    @if(Auth::user()->role == 'admin')
    <div class="form-group sep">
        {{ Form::select('user', $commerciaux, '', ['class' => 'form-control', 'placeholder' => 'choisissez un commercial']) }}
    </div>
    @endif
    <div class="form-group sep">
        {{ Form::select('annee', $prospectYears, '', ['class' => 'form-control', 'placeholder' => 'choisissez l\'annee']) }}
    </div>
    <div class="form-group sep">
        {{ Form::select('mois', $prospectMonths, '', ['class' => 'form-control', 'placeholder' => 'choisissez le mois']) }}
    </div>
    <div class="form-group sep">
        {{ Form::text('search', null, ['class' => 'form-control', 'placeholder' => 'recherche par nom']) }}
    </div>
    <div class="form-group sep">
        {{ Form::label('iban', 'iban') }}
        {{ Form::checkbox('iban', null, false) }}
    </div>
    <div class="form-group sep">
        {{ Form::label('dossier', 'dossier') }}
        {{ Form::checkbox('dossier', null, false) }}
    </div>
    <div class="form-group sep">
        {{ Form::label('rappel', 'rappel') }}
        {{ Form::checkbox('rappel', null, false) }}
    </div>
    <div class="form-group sep">
        {{ Form::label('mandat', 'mandat') }}
        {{ Form::checkbox('mandat', null, false) }}
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-success">
            <i class="fa fa-search" aria-hidden="true"></i> Filtre
        </button>
    </div>
    <div class="form-group">
        <a href="{{ url()->route('prospect.index') }}" class="btn btn-warning">raz filtre</a>
    </div>
    {{ Form::close() }}
</div>