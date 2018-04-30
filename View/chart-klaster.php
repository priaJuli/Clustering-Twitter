<!DOCTYPE html>
<html>
	<head>
		<title>chart created with amCharts | amCharts</title>
		<meta name="description" content="chart created using amCharts live editor" />
		
		<!-- amCharts javascript sources -->
		<script type="text/javascript" src="https://www.amcharts.com/lib/3/amcharts.js"></script>
		<script type="text/javascript" src="https://www.amcharts.com/lib/3/serial.js"></script>
		

		<!-- amCharts javascript code -->
		<script type="text/javascript">
			AmCharts.makeChart("chartdiv",
				{
					"type": "serial",
					"categoryField": "category",
					"startDuration": 1,
					"fontSize": 17,
					"categoryAxis": {
						"gridPosition": "start"
					},
					"trendLines": [],
					"graphs": [
						{
							"balloonText": "[[title]] of [[category]]:[[value]]",
							"fillAlphas": 1,
							"id": "AmGraph-1",
							"title": "Cluster1",
							"type": "column",
							"valueField": "Cluster1"
						},
						{
							"balloonText": "[[title]] of [[category]]:[[value]]",
							"fillAlphas": 1,
							"id": "AmGraph-2",
							"title": "Cluster2",
							"type": "column",
							"valueField": "Cluster2"
						},
						{
							"balloonText": "[[title]] of [[category]]:[[value]]",
							"fillAlphas": 1,
							"fillColors": "#0000FF",
							"id": "AmGraph-3",
							"tabIndex": -1,
							"title": "Cluster3",
							"type": "column",
							"valueField": "Cluster3"
						},
						{
							"balloonText": "[[title]] of [[category]]:[[value]]",
							"columnWidth": 0.94,
							"fillAlphas": 0.85,
							"fillColors": "#95CD2B",
							"gapPeriod": 1,
							"id": "AmGraph-4",
							"title": "OutofCluster",
							"type": "column",
							"valueField": "OutOfCluster"
						}
					],
					"guides": [],
					"valueAxes": [
						{
							"id": "ValueAxis-1",
							"title": "Jumlah Document"
						},
						{
							"id": "ValueAxis-2",
							"title": "Bulan February"
						}
					],
					"allLabels": [],
					"balloon": {},
					"legend": {
						"enabled": true,
						"useGraphSettings": true
					},
					"titles": [
						{
							"id": "Title-1",
							"size": 15,
							"text": "Klasterisasi Twitter Biznet Bulan February"
						}
					],
					"dataProvider": [
						{
							"category": "Week1",
							"Cluster3": "94",
							"Cluster2": "91",
							"Cluster1": "58",
							"OutOfCluster": "7",
							"DBI": 0.00045865
						},
						{
							"category": "Week2",
							"Cluster3": "44",
							"Cluster2": "107",
							"Cluster1": "42",
							"OutOfCluster": "7",
							"DBI": 0.00286787
						},
						{
							"category": "Week3",
							"Cluster3": "6",
							"Cluster2": "78",
							"Cluster1": "65",
							"OutOfCluster": "4",
							"DBI": 0.0100857
						},
						{
							"category": "Week4",
							"Cluster3": "80",
							"Cluster2": "118",
							"Cluster1": "78",
							"OutOfCluster": "4",
							"DBI": 0.00122976
						}
					]
				}
			);
		</script>
	</head>
	<body>
		<div id="chartdiv" style="width: 100%; height: 400px; background-color: #FFFFFF;" ></div>
	</body>
</html>