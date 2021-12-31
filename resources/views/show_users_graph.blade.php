@extends('layouts.app')

@section('additional-head')
<!-- Fonts -->
<link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
<!-- bootstrap -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center text-center">
        <div class="w-75 mt-5">
            
            <div class="text-black-50 text-center mt-5">
                <h1>グラフ表示</h1>
            </div>
            
            {{ Form::open(['method'=>'get', 'url'=>'/show_users_graph']) }}
            {{ Form::label('search_word', '検索ワード', ['class'=>'search_word']) }}
            {{ Form::text('search_word',  $search_word ) }}
            {{ Form::close() }}
            
            <p><a href="{{ route('show_users') }}?search_word={{ $search_word }}">ユーザ一覧</a></p>
            
       </div>
	</div>
</div>
@endsection

@section('additional-foot')
<div class="container">
	<div class="row justify-content-center text-center">
		<div class="w-100 mt-0">
            <div class="text-black-50 text-center mt-0">
				<canvas id="myChart1" width="400" height="200"></canvas>
			   	<canvas id="myChart2" width="400" height="200"></canvas>
		   	</div>
	   	</div>
   	</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
<!-- グラフを描画 -->
<script>
//ラベル
var labels = [
    @foreach($arrays as $index => $array)
    "{{ $array->created_day }}",
    @endforeach
];
//フォロワー数
var values1 = [
    @foreach($arrays as $index => $array)
    {{ $array->followers_count }},
    @endforeach
];
//フォロー数
var values2 = [
    @foreach($arrays as $index => $array)
    {{ $array->friends_count }},
    @endforeach
];
//リスト数
var values3 = [
    @foreach($arrays as $index => $array)
    {{ $array->listed_count }},
    @endforeach
];
//favorite数
var values4 = [
    @foreach($arrays as $index => $array)
    {{ $array->favourites_count }},
    @endforeach
];

// グラフオプションの設定
var complexChartOption = {
		//responsive: true,
		maintainAspectRatio: false,
		title: {
			display: true,
			text: '推移'
		},
		scales: {
		    yAxes: [{
		        id: "y-axis-1",   // Y軸のID
		        type: "linear",   // linear固定 
		        position: "left", // どちら側に表示される軸か？
		        ticks: {          // スケール
		            max: 100,
		            min: 0,
		            //stepSize: 1
		        },
		    }, {
		        id: "y-axis-2",
		        type: "linear", 
		        position: "right",
		        ticks: {
		            max: 100,
		            min: 0,
		            //stepSize: 1
		        },
		    }],
		}
    };

//グラフを描画
<?php
	$max_value1=0;$min_value1=1000000000000;
	$max_value2=0;$min_value2=1000000000000;
	foreach($arrays as $index => $array){
		if($max_value1 < $array->followers_count){$max_value1=$array->followers_count;};
		if($max_value2 < $array->friends_count){$max_value2=$array->friends_count;};
		if($min_value1 > $array->followers_count){$min_value1=$array->followers_count;};
		if($min_value2 > $array->friends_count){$min_value2=$array->friends_count;};
	}
?>
complexChartOption.scales.yAxes[0].ticks.max= {{ $max_value1 }};
complexChartOption.scales.yAxes[1].ticks.max= {{ $max_value2 }};
complexChartOption.scales.yAxes[0].ticks.min= {{ $min_value1 }};
complexChartOption.scales.yAxes[1].ticks.min= {{ $min_value2 }};
var ctx1 = document.getElementById("myChart1");
var myChart1 = new Chart(ctx1, {
	type: 'line',
	data : {
		labels: labels,
		datasets: [
			{
				type: 'line',
				label: 'フォロワー数',
				data: values1,
				borderColor: "rgba(0,0,255,1)",
     			backgroundColor: "rgba(0,0,0,0)",
     			yAxisID: "y-axis-1",
			},
			{
				type: 'line',
				label: 'フォロー数',
				data: values2,
				borderColor: "rgba(0,255,0,1)",
     			backgroundColor: "rgba(0,0,0,0)",
     			yAxisID: "y-axis-2", 
			}
			
		]
	},
	options: complexChartOption
});
ctx1.parentNode.style.height = '300px';
<?php
	$max_value1=0;$min_value1=1000000000000;
	$max_value2=0;$min_value2=1000000000000;
	foreach($arrays as $index => $array){
		if($max_value1 < $array->listed_count){$max_value1=$array->listed_count;};
		if($max_value2 < $array->favourites_count){$max_value2=$array->favourites_count;};
		if($min_value1 > $array->listed_count){$min_value1=$array->listed_count;};
		if($min_value2 > $array->favourites_count){$min_value2=$array->favourites_count;};
	}
?>
complexChartOption.scales.yAxes[0].ticks.max= {{ $max_value1 }};
complexChartOption.scales.yAxes[1].ticks.max= {{ $max_value2 }};
complexChartOption.scales.yAxes[0].ticks.min= {{ $min_value1 }};
complexChartOption.scales.yAxes[1].ticks.min= {{ $min_value2 }};
var ctx2 = document.getElementById("myChart2");
var myChart2 = new Chart(ctx2, {
	type: 'line',
	data : {
		labels: labels,
		datasets: [
			{
				type: 'line',
				label: 'リスト数',
				data: values3,
				borderColor: "rgba(255,0,0,1)",
     			backgroundColor: "rgba(0,0,0,0)",
     			yAxisID: "y-axis-1",
			},
			{
				type: 'line',
				label: 'favorite数',
				data: values4,
				borderColor: "rgba(0,255,255,1)",
     			backgroundColor: "rgba(0,0,0,0)",
     			yAxisID: "y-axis-2",
			}
			
		]
	},
	options: complexChartOption
});
ctx2.parentNode.style.height = '300px';
</script>
<!-- グラフを描画ここまで -->
@endsection

 