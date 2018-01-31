<div class="box box-solid">
    <div class="box-header">
        <i class="fa fa-calendar"></i>

        <h3 class="box-title">Statistique Lead</h3>
        <!-- tools box -->
        <div class="pull-right box-tools">
            <!-- button with a dropdown -->
            <button type="button" class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-success btn-sm" data-widget="remove"><i class="fa fa-times"></i>
            </button>
        </div>
        <!-- /. tools -->
    </div>
    <!-- /.box-stats -->
    <div class="box-body no-padding">
        <!--The stats -->
        <div class="chart tab-pane" id="leads-chart" style="position: relative; height: 300px;"></div>
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
    </div>
</div>

@section('js2')
    <script>
        //Récupère le tableau au format json contenant la source des leads et le nombre
        var leadsArray = <?php echo $leadStat; ?>;

        // Donut Chart
        var donut = new Morris.Donut({
            element  : 'leads-chart',
            resize   : true,
            colors   : ['#DC1480', '#439ACE', '#F19B2C'],
            data     : leadsArray,
            hideHover: 'auto'
        });
    </script>
@endsection