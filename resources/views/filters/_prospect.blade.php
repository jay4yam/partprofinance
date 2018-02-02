<div class="box">
    {{ Form::open([ 'route' => 'prospect.index', 'method' => 'GET', 'class' => 'form-inline']) }}
    <div class="form-group sep">
        {{ Form::label('annee', 'Année') }}
        {{ Form::select('annee', $years, '', ['class' => 'form-control', 'placeholder' => 'choisissez l\'annee']) }}
    </div>
    <div class="form-group sep">
        {{ Form::label('mois', 'Mois') }}
        {{ Form::select('mois', [
                                '01' => 'Janvier',
                                '02' => 'Février',
                                '03' => 'Mars',
                                '04' => 'Avril',
                                '05' => 'Mai',
                                '06' => 'Juin',
                                '07' => 'Juillet',
                                '08' => 'Août',
                                '09' => 'Septembre',
                                '10' => 'Octobre',
                                '11' => 'Novembre',
                                '12' => 'Décembre',
        ], null, ['class' => 'form-control', 'placeholder' => 'choisissez le mois']) }}
    </div>
    <div class="form-group sep">
        {{ Form::label('nom', 'Recherche') }}
        {{ Form::text('search', null, ['class' => 'form-control']) }}
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
    {{ Form::close() }}
</div>