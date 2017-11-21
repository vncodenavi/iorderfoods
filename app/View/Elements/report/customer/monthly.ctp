<?php
$totalCustomer=0;
 $datee= array('1'=>"'Jan'",'2'=>"'Feb'",'3'=>"'Mar'",'4'=>"'Apr'",'5'=>"'May'",'6'=>"'Jun'",'7'=>"'Jul'",'8'=>"'Aug'",'9'=>"'Sep'",'10'=>"'Oct'",'11'=>"'Nov'",'12'=>"'Dec'");
        $tamntt = array('1'=>0,'2'=>0,'3'=>0,'4'=>0,'5'=>0,'6'=>0,'7'=>0,'8'=>0,'9'=>0,'10'=>0,'11'=>0,'12'=>0);
        foreach($result as $amount){
            $tamntt[date('n',strtotime($amount['User']['created']))] += $amount['User']['per_day']; 
            $datee[date('n',strtotime($amount['User']['created']))]="'".date('M',strtotime($amount['User']['created']))."'";
            $totalCustomer = $totalCustomer + $amount['User']['per_day'];

        }
        $subTitle = '<style="font-size:14px;font-weight:bold;">Total '.$totalCustomer.' Customer </style>';
        $amntdate = implode(',',$datee);
        $tamnt = implode(',',$tamntt);
        $text = 'Monthly Report for '.date('M',strtotime('2015-'.$Month.'-01')).'-'. $Year;

?>

<?php echo $this->element('chart/chart_script');?>


<script>
     
   $(function () {
        $('#container').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: '<?php echo $text;?>'
            },
            subtitle: {
                text: '<?php echo $subTitle;?>'
            },
            xAxis: {
                categories: [<?php echo $amntdate;?>],
                title: {
                    text: null
                },
                crosshair: true
            },
           yAxis: {
                min: 0,
                title: {
                    text: 'Customer',
                    align: 'high'
                },
                labels: {
                    overflow: 'justify'
                }
            },
            tooltip: {
                valueSuffix: ''
            },
            plotOptions: {
                series: {
                    pointWidth: 50
                }
            },
            exporting: { enabled: false },
            series: [{
                name: 'Customer',
                data: [<?php echo $tamnt; ?>]
    
            }]
        });
    });
    
        
</script>