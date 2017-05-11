<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>


    <?php

    echo $default_assets;
    echo $sidebar

     ?>
<div id="container"></div>
<button id="plain">Plain</button>
<button id="inverted">Inverted</button>
<button id="polar">Polar</button>

<style>
    #container {
        min-width: 320px;
        max-width: 600px;
        margin: 0 auto;
    }
</style>
    <script>
        var chart = Highcharts.chart('container', {

            title: {
                text: 'Chart.update'
            },

            subtitle: {
                text: 'Plain'
            },

            xAxis: {

                categories: [<?php foreach($details as $detail) { ?> <?php echo "'".$detail['month'] ."',";?>   <?php } ?>]

            <?php ?>
            },

            series: [{
                type: 'column',
                colorByPoint: true,
                data: [<?php foreach($details as $detail) { if ($detail['sums']==null) {$val=0;}else{$val=$detail['sums'];} ?> <?php echo $val .",";?>   <?php } ?>],
                showInLegend: false
            }]

        });


        $('#plain').click(function () {
            chart.update({
                chart: {
                    inverted: false,
                    polar: false
                },
                subtitle: {
                    text: 'Plain'
                }
            });
        });

        $('#inverted').click(function () {
            chart.update({
                chart: {
                    inverted: true,
                    polar: false
                },
                subtitle: {
                    text: 'Inverted'
                }
            });
        });

        $('#polar').click(function () {
            chart.update({
                chart: {
                    inverted: false,
                    polar: true
                },
                subtitle: {
                    text: 'Polar'
                }
            });
        });

    </script>