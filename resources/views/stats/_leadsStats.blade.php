
<div class="chart tab-pane" id="leads-chart" style="position: relative; height: 300px;"></div>

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