
<div class="chart tab-pane" id="sales-chart" style="position: relative; height: 105px;"></div>

@section('js2')
    <script>
        // Donut Chart
        var leadsArray = <?php echo $leadStat; ?>;
        var donut = new Morris.Donut({
            element  : 'sales-chart',
            resize   : true,
            colors   : ['#DC1480', '#439ACE', '#F19B2C'],
            data     : leadsArray,
            hideHover: 'auto'
        });
    </script>
@endsection