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
	<title>Daily Expense Analysis || Datewise Expense Report</title>
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
					<li class="active">Expense Report</li>
				</ol>
			</div><!--/.row-->
			
			
					
			
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading">Generated Expense Report</div>
						<div class="panel-body">
							<div class="col-md-12">
						
								<?php
								$fdate=$_POST['fromdate'];
								$tdate=$_POST['todate'];
								$rtype=$_POST['requesttype'];
								?>

								<h5 align="center" style="color:blue">Expense Report from 
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
								
<!-- 								<div class="table-responsive"> -->
									<table id="datatable" class="table-responsive table table-bordered mg-b-0" style="overflow-x:auto;border-collapse: collapse; border-spacing: 0; width: 100%;">
										<thead>
										<tr>
											<tr>
												<th>S.NO</th>
												<th>Date</th>
												<th>Item Name</th>
												<th>Item Type</th>
												<th>Expense Amount</th>
											</tr>
										</tr>
										</thead>
										
										<?php
										$userid=$_SESSION['detsuid'];
										$ret=mysqli_query($con,"SELECT * FROM `tblexpense`  where (ExpenseDate BETWEEN '$fdate' and '$tdate') && (UserId='$userid')");
										$cnt=1;
										while ($row=mysqli_fetch_array($ret)) {
										?>
				
										<tr>
											<td><?php echo $cnt;?></td>
											<?php 
												$temp5 =  $row['ExpenseDate'];
												$New_date = date("d-m-Y", strtotime($temp5));
											?>
											<td><?php  echo $New_date?></td>
											<td><?php  echo $row['ExpenseItem'];?></td> 
											<td><?php  echo $row['Type_Expense'];?></td> 
											<td><?php  echo $row['ExpenseCost'];?></td> 
											<?php $ttls2= $row['ExpenseCost'];?>
										</tr>
					
										<?php
										$totalsexp+=$ttls2; 
										$cnt=$cnt+1;
										}?>

										<tr>
			<!-- This th is only for calling graph function whose css file is linked above and script part is written on 144 line  -->
											<th colspan="4"> <div id="container"></div></th>
											<!-- <th colspan="3" style="text-align:center">Grand Total</th>-->
											<th><?php echo "Grand Total: ";?><span style="color:red" ><?php echo $totalsexp;?></span></th>	
										</tr>     

									</table>
<!-- 								</div> -->
			<!-- -------------- Download Started---------------------->
								<div>	
									<script type="text/javascript">
										function Export() {
											html2canvas(document.getElementById('datatable'), {
												onrendered: function (canvas) {
													var data = canvas.toDataURL();
													var docDefinition = {
														content: [{
															image: data,
															width: 300
														}]
													};
													pdfMake.createPdf(docDefinition).download("report.pdf");
												}
											});
										}
									</script>
								</div>
								
								<div style="color:red; display: flex;justify-content: center;">
									<input  type="button" id="btnExport" value="Download" onclick="Export()" />
								</div>
			<!-- -------------- Download Ended---------------------->
							</div>
			<!---------------- Graph Part Started ---------------->
							<?php  
								$var1 = array();
								$var2 = array();
								$userid=$_SESSION['detsuid'];
								$ret=mysqli_query($con,"SELECT Type_Expense,SUM(ExpenseCost) as ttl FROM `tblexpense`  where ((ExpenseDate BETWEEN '$fdate' and '$tdate') && (UserId='$userid')) group by Type_Expense");
								$ret1=mysqli_query($con,"SELECT SUM(ExpenseCost) as ttl1 FROM `tblexpense`  where ((ExpenseDate BETWEEN '$fdate' and '$tdate') && (UserId='$userid'))"); 
								while ($row=mysqli_fetch_array($ret)) {
								$var1[] = $row['ttl'];
								$var2[] = $row['Type_Expense']; 
								}
								while ($row1=mysqli_fetch_array($ret1)){    
								$var3 = $row1['ttl1'];
								}
							?>
							
							<figure class="highcharts-figure">
							<script src="https://code.highcharts.com/highcharts.js"></script>
							<script src="https://code.highcharts.com/highcharts-3d.js"></script>
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
								Highcharts.chart('container', {
									chart: {
										type: 'pie',
										options3d: {
										enabled: true,
										alpha: 45,
										beta: 0
										}
									},
									title: {
										
										text: 'Genarated Graph'
									},
									accessibility: {
										point: {
										valueSuffix: '%'
										}
									},
									tooltip: {
										pointFormat: '{point.label}: <b>{point.percentage:.1f}%</b>'
									},
									plotOptions: {
										pie: {
											allowPointSelect: true,
											cursor: 'pointer',
											depth: 35,
											dataLabels: {
												enabled: true,
												format: '{point.label}'
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
				</div>
			</div>
			<?php include_once('includes/footer.php');?>
		</div>
	</div>
	
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
	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/highcharts-3d.js"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>
	<script src="https://code.highcharts.com/modules/export-data.js"></script>
	<script src="https://code.highcharts.com/modules/accessibility.js"></script>
    
</body>
</html>
<?php } ?>
