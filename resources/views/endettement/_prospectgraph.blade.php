<!-- box Endettement -->
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Endettement : <span id="txEndettement"></span></h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
                <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                <i class="fa fa-times"></i></button>
        </div>
    </div>
    <div class="box-body">
        <canvas id="pieChart" style="height: 138px; width: 340px;"></canvas>
        <div id="legendDiv"></div>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box Endettement -->

@section('js2')
    <!-- ChartJS -->
    <script src="{{ asset('bower_components/chart.js/Chart.js') }}"></script>
    <!-- endettement -->
    <script src="{{ asset('js/endettement.js') }}"></script>
    <script>
        //récupération de la sommes des charges
        var charges = <?php echo $charges; ?>;

        //récupération de la sommes des revenus
        var revenus = <?php echo $revenus; ?>;

        //Fonction arrondir le taux d'endettement
        function precisionRound(number, precision) {
            var factor = Math.pow(10, precision);
            return Math.round(number * factor) / factor;
        }
        //Affiche le taux d'endettement
        $('#txEndettement').html('<b>'+ precisionRound( (charges / revenus)*100, 2)+'</b> %');

        $(document).ready(function () {
            endettement.graphEndettement(charges, revenus);
        });
    </script>

@endsection