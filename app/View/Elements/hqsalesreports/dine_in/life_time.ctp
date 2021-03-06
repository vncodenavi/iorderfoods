<?php
 $yearFrom = 2012;
 $totalDineIn=0;

$yearTo = date('Y');
$difference =$yearTo-$yearFrom;
for($i=$yearFrom;$i<=$yearTo;$i++){
   $list[$i]['Year'] = "'".$i."'";
   $list[$i]['number'] = 0;  
}
foreach($graphData as $key => $data){
    $result1[$key]=$data[0];
    unset($data); 
}
if(!empty($result1)){
foreach($result1 as $amount){
    $list[date('Y',strtotime($amount['order_date']))]['Year'] = "'".date('Y',strtotime($amount['order_date']))."'";
    if(empty($list[date('Y',strtotime($amount['order_date']))]['number'])){
        $list[date('Y',strtotime($amount['order_date']))]['number'] += 1;
        $totalDineIn = $totalDineIn + 1;

    } else {
        $list[date('Y',strtotime($amount['order_date']))]['number'] += 1;
        $totalDineIn = $totalDineIn + 1;

    }
}
}
foreach($list as $lst){
    $datee[] = $lst['Year']; 
    $tamntt[] = $lst['number']; 
}
$subTitle = '<style="font-size:14px;font-weight:bold;">Total '.$totalDineIn.' Reservations </style>';
$amntdate = implode(',',$datee);
$tamnt = implode(',',$tamntt);
//$text = 'Life Time Report';

$startmonth = date('m', strtotime($dateFrom));
$endmonth   = date('m', strtotime($dateTo));

$startyear  = date('Y', strtotime($dateFrom));
$endyear    = date('Y', strtotime($dateTo));

$titleText = $this->Common->dineInTitleString($startmonth, $startyear, $endmonth, $endyear, 'life_time');
$text = '<style="font-size:14px;font-weight:bold;">' . $titleText . '</style>';


/* For Pie Chart*/
$pieData = $this->Common->dineInPieDataArrange($dineInPieData);

$totalPie = (isset($pieData['total']) ? $pieData['total'] : 0);
$finalPie = (isset($pieData['data']) ? $pieData['data'] : array());
/* End For Pie Chart*/
?>

<div class="col-lg-<?php echo (($totalPie == 0) ? '12' : '6');?>">
    <div id="container"></div>
</div>
<div class="col-lg-6  <?php echo (($totalPie == 0) ? 'hidden' : '');?>">
    <div id="reservationPie"></div>
</div>

<script>
     
$(function () {
    $('#container').highcharts({
        chart: {
            type: 'line'
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
                text: '# Of Reservations',
                align: 'middle'
            },
            labels: {
                overflow: 'justify'
            }
        },
        tooltip: {
            valueSuffix: ''
        },
        plotOptions: {
            line: {
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: true
            },
            series: {
                pointWidth: 50
            }
        },
        exporting: { enabled: false },
        series: [{
            name: 'Reservations',
            data: [<?php echo $tamnt; ?>],
            color: '#f79d54'

        }]
    });
    
    /* Pie Chart Start */
    Highcharts.chart('reservationPie', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Reservation Status'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b> ({point.pointcount})'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    distance : -50,
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} % ({point.pointcount})',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            name: 'Reservations',
            colorByPoint: true,
            data: [
            <?php
            foreach ($finalPie as $finalPieV)
            {
                $percentage = ($finalPieV['status_count'] / $totalPie) * 100;
                ?>
                {
                    name        : '<?php echo $finalPieV['status_name']?>',
                    y           : <?php echo $percentage?>,
                    color       : '<?php echo $finalPieV['color']?>',
                    pointcount  : '<?php echo $finalPieV['status_count'];?>'
                },
                <?php
            }
            ?>
             ]
        }],
        exporting: { enabled: false }
    });
    /* Pie Chart End */
});
</script>
<div id="pagination_data_request">
    <?php echo $this->element('hqsalesreports/dine_in/pagination'); ?>
</div>