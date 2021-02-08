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
            <th colspan="4"> <div id="curve_chart"></div></th>
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
								<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
								<script type="text/javascript">
									google.charts.load('current', {'packages':['corechart']});
									google.charts.setOnLoadCallback(drawChart);

							function drawChart() {
								var data = google.visualization.arrayToDataTable([
								['Month-Year', 'Income', 'Expenses'],
								<?php
									$userid=$_SESSION['detsuid'];
									$cnt=1;
									$ret3=mysqli_query($con,"SELECT q1.rpmonth, q1.rpyear, q1.totalmonth, q2.totalexp 
															FROM (SELECT month(IncomeDate) as rpmonth,year(IncomeDate) as rpyear,SUM(IncomeAmount) as totalmonth 
															FROM tbleincome where (IncomeDate BETWEEN '$fdate' and '$tdate') && (UserId='$userid')
															group by month(IncomeDate),year(IncomeDate)) as q1 
															LEFT JOIN
															(SELECT month(ExpenseDate) as expmonth,year(ExpenseDate) as expyear,SUM(ExpenseCost) as totalexp 
															FROM tblexpense where (ExpenseDate BETWEEN '$fdate' and '$tdate') && (UserId='$userid') 
															group by month(ExpenseDate),year(ExpenseDate)) as q2
															ON q1.rpmonth = q2.expmonth");
									
									
									while ($row3=mysqli_fetch_array($ret3)){
										$monyear = $row3['rpmonth']."-".$row3['rpyear'];
										$income = $row3['totalmonth'];
										$expense = $row3['totalexp'];
									?>
									['<?php echo $monyear;?>',<?php echo $income;?>,<?php echo $expense;?>],
								
									<?php
										}
									?>
								]);

								var options = {
								title: 'Income vs Expense',
								curveType: 'function',
								legend: { position: 'bottom' }
								
								};

								var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

								chart.draw(data, options);
							}
							</script>
								<!--------------- Graph Part Ended --------------------->

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
