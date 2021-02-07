<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['detsuid']==0)) {
  header('location:logout.php');
  } else{
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Income Analysis || Datewise Income Report</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/font-awesome.min.css" rel="stylesheet">
	<link href="css/datepicker3.css" rel="stylesheet">
	<link href="css/styles.css" rel="stylesheet">
	<link href="css/graph.css" rel="stylesheet">
	
	<!--Custom Font-->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
	
</head>
<body>
	<?php include_once('includes/header.php');?>
	<?php include_once('includes/sidebar.php');?>
		
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#">
					<em class="fa fa-home"></em>
				</a></li>
				<li class="active">Income vs Expense Report</li>
			</ol>
		</div><!--/.row-->
		
		
				
		
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">Income vs Expense Report</div>
					<div class="panel-body">

						<div class="col-md-12">
					
                        <?php
                        $fdate=$_POST['fromdate'];
                        $tdate=$_POST['todate'];
                        $rtype=$_POST['requesttype'];
                        ?>
                        <h5 align="center" style="color:blue"> Report from 
                        <span style="color:red"><?php 
                            $New_fdate = date("d-m-Y", strtotime($fdate));
                            echo $New_fdate;
                        ?></span>  to 
                        <span style="color:red"><?php 
                            $New_tdate = date("d-m-Y", strtotime($tdate));
                            echo $New_tdate;
                        ?></span> 
                        </h5>
                        <hr />
		<div class="table-responsive">
		<table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
			<thead>
			<tr>
				<tr>
					<th>S.NO</th>
					<th>Month</th>
					<th>Total Income</th>
					<th>Total Expense</th>
				</tr>
			</tr>
			<tr></tr>
			<tr></tr>
			</thead>
            
            <?php
            $userid=$_SESSION['detsuid'];
            $cnt=1;
			$ret1=mysqli_query($con,"SELECT q1.rpmonth, q1.rpyear, q1.totalmonth, q2.totalexp 
									 FROM (SELECT month(IncomeDate) as rpmonth,year(IncomeDate) as rpyear,SUM(IncomeAmount) as totalmonth 
									 FROM tbleincome where (IncomeDate BETWEEN '$fdate' and '$tdate') && (UserId='$userid')
									 group by month(IncomeDate),year(IncomeDate)) as q1 
									 LEFT JOIN
									 (SELECT month(ExpenseDate) as expmonth,year(ExpenseDate) as expyear,SUM(ExpenseCost) as totalexp 
									 FROM tblexpense where (ExpenseDate BETWEEN '$fdate' and '$tdate') && (UserId='$userid') 
									 group by month(ExpenseDate),year(ExpenseDate)) as q2
									 ON q1.rpmonth = q2.expmonth");
            
		    
            while ($row=mysqli_fetch_array($ret1)){
				
            ?>

            <tr>
                <td><?php echo $cnt;?></td>
                <td><?php  echo $row['rpmonth']."-".$row['rpyear'];?></td>
                <td><?php  echo $row['totalmonth'];?></td>
				<td><?php  echo $row['totalexp'];?></td>	
			</tr>
				 <?php
                $cnt=$cnt+1;
                
			}?>
			
            <tr>
            <th colspan="4"> <div id="container"></div></th>
            </tr>
			<tr>
            <th colspan="4"> <div id="container2"></div></th>
            </tr> 
		
	</table>
	
	</div>
								<div>
								<script type="text/javascript">
									function Export() {
										html2canvas(document.getElementById('datatable'), {
											onrendered: function (canvas) {
												var data = canvas.toDataURL();
												var docDefinition = {
													content: [{
														image: data,
														width: 500
													}]
												};
												pdfMake.createPdf(docDefinition).download("report.pdf");
											}
										});
									}
								</script>
								<br>
								<div style="color:red; display: flex;justify-content: center;">
								<input  type="button" id="btnExport" value="Download" onclick="Export()" />
								</div>
								</div>
		<!---------------- Graph Part Started ---------------->
							<?php  
								$var1 = array();
								$var2 = array();
								$userid=$_SESSION['detsuid'];
								$ret=mysqli_query($con,"SELECT month(IncomeDate)as inmonth,year(IncomeDate) as inyear,SUM(IncomeAmount) as ttl FROM `tbleincome`  where ((IncomeDate BETWEEN '$fdate' and '$tdate') && (UserId='$userid')) group by(month(IncomeDate))");
								$ret1=mysqli_query($con,"SELECT SUM(IncomeAmount) as ttl1 FROM `tbleincome`  where ((IncomeDate BETWEEN '$fdate' and '$tdate') && (UserId='$userid'))"); 
								while ($row=mysqli_fetch_array($ret)) {
								$var1[] = $row['ttl'];
								$var2[] = $row['inmonth']."-".$row['inyear']; 
								}
								while ($row1=mysqli_fetch_array($ret1)){    
								$var3 = $row1['ttl1'];
								}
								
							?>
							
							

							<figure class="highcharts-figure">
							<script src="https://code.highcharts.com/highcharts.js"></script>
							<script src="https://code.highcharts.com/modules/exporting.js"></script>
							<script src="https://code.highcharts.com/modules/export-data.js"></script>
							<script src="https://code.highcharts.com/modules/accessibility.js"></script>
							</figure>
							
							<script>
								var totalpriceArr = <?php echo json_encode($var1); ?>;
								var labelArr = <?php echo json_encode($var2); ?>;
								var total = <?php echo json_encode($var3); ?>;
								// alert(labelArr);
								var points=[];
									for(i=0;i<totalpriceArr.length;i++){
									var dict={};
									dict.y=totalpriceArr[i]/total;
									dict.label=""+labelArr[i];
									points.push(dict);
									}
									Highcharts.setOptions({
										colors: Highcharts.map(Highcharts.getOptions().colors, function (color) {
											return {
											radialGradient: {
												cx: 0.5,
												cy: 0.3,
												r: 0.7
											},
											stops: [
												[0, color],
												[1, Highcharts.color(color).brighten(-0.3).get('rgb')] // darken
											]
											};
										})
										});

									// Build the chart
									Highcharts.chart('container', {
									chart: {
										plotBackgroundColor: null,
										plotBorderWidth: null,
										plotShadow: false,
										type: 'pie'
									},
									title: {
										text: 'Income'
									},
									tooltip: {
										pointFormat: '{point.label}: <b>{point.percentage:.1f}%</b>'
									},
									accessibility: {
										point: {
										valueSuffix: '%'
										}
									},
									plotOptions: {
										pie: {
										allowPointSelect: true,
										cursor: 'pointer',
										dataLabels: {
											enabled: true,
											format: '<b>{point.label}</b>: {point.percentage:.1f} %',
											connectorColor: 'silver'
										}
										}
									},
									series: [{
										name: 'Expense',
										data: points
									}]
								});
							</script>
							    <!--Graph Part Ended  -->

								<!---------------- Graph Part Started ---------------->
							<?php  
								$var4 = array();
								$var5 = array();
								$userid=$_SESSION['detsuid'];
								$rett=mysqli_query($con,"SELECT month(ExpenseDate)as exmonth,year(ExpenseDate) as exyear,SUM(ExpenseCost) as ttll FROM `tblexpense`  where ((ExpenseDate BETWEEN '$fdate' and '$tdate') && (UserId='$userid')) group by(month(ExpenseDate))");
								$rett1=mysqli_query($con,"SELECT SUM(ExpenseCost) as ttll1 FROM `tblexpense`  where ((ExpenseDate BETWEEN '$fdate' and '$tdate') && (UserId='$userid'))"); 
								while ($row1=mysqli_fetch_array($rett)) {
								$var4[] = $row1['ttll'];
								$var5[] = $row1['exmonth']."-".$row1['exyear']; 
								}
								while ($row1=mysqli_fetch_array($rett1)){    
								$var6 = $row1['ttll1'];
								}
								
							?>

							<figure class="highcharts-figure">
							<script src="https://code.highcharts.com/highcharts.js"></script>
							<script src="https://code.highcharts.com/modules/exporting.js"></script>
							<script src="https://code.highcharts.com/modules/export-data.js"></script>
							<script src="https://code.highcharts.com/modules/accessibility.js"></script>
							</figure>
							
							<script>
								var totalpriceArr = <?php echo json_encode($var4); ?>;
								var labelArr = <?php echo json_encode($var5); ?>;
								var total = <?php echo json_encode($var6); ?>;
								// alert(labelArr);
								var points=[];
									for(i=0;i<totalpriceArr.length;i++){
									var dict={};
									dict.y=totalpriceArr[i]/total;
									dict.label=""+labelArr[i];
									points.push(dict);
									}
								Highcharts.chart('container2', {
									chart: {
										type: 'pie',
										options3d: {
										enabled: true,
										alpha: 45,
										beta: 0
										}
									},
									title: {
										
										text: 'Expense Graph Monthwise'
									},
									accessibility: {
										point: {
										valueSuffix: '%'
										}
									},
									tooltip: {
										pointFormat: '{point.label}: <b>{point.percentage:.1f}%</b>',
									},
									plotOptions: {
										pie: {
											allowPointSelect: true,
											cursor: 'pointer',
											depth: 35,
											dataLabels: {
												enabled: true,
												format: '{point.label}:<b>{point.percentage:.1f}%</b>',
											}
										}
									},
									series: [{
										type: 'pie',
										name: 'Expense',
										data: points
									}]
								});
							</script>
							    <!--Graph Part Ended  -->

		</div>
	</div>
</div><!-- /.panel-->
</div><!-- /.col-->
<?php include_once('includes/footer.php');?>
</div><!-- /.row -->
</div><!--/.main-->
	<style>
	@media (max-width: 767px) {    
		#btnExport{
	  	    display:none;
		}
	}
	</style>
	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/chart.min.js"></script>
	<script src="js/chart-data.js"></script>
	<script src="js/easypiechart.js"></script>
	<script src="js/easypiechart-data.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script src="js/custom.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.22/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
    
</body>
</html>
<?php } ?>
