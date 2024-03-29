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
					<div class="panel-heading">Expense Report</div>
					<div class="panel-body">
						<p style="font-size:16px; color:red" align="center"> <?php if($msg){
    					echo $msg;
 						 }  ?> </p>
						<div class="col-md-12">
						<form role="form" method="post" action="Expense-report-typewise-detailed.php" name="bwdatesreport">
								<div class="form-group">
									<label>From Date</label>
									<input class="form-control" type="date"  id="fromdate" name="fromdate" required="true">
								</div>
								<div class="form-group">
									<label>To Date</label>
									<input class="form-control" type="date"  id="todate" name="todate" required="true">
								</div>
                                <div class="form-group">
									<input type="radio" id="1" name="optradio" checked value="General">
										<label for="1">General</label>
									<input type="radio" id="2" name="optradio" value="Food">
										<label for="2">Food</label>
									<input type="radio" id="3" name="optradio" value="Electronics">
										<label for="3">Electronics</label>
									<input type="radio" id="4" name="optradio" value="Bill">
										<label for="4">Bill</label>
									<input type="radio" id="5" name="optradio" value="Sport">
										<label for="5">Sport</label>
									<input type="radio" id="5" name="optradio" value="Clothes">
										<label for="5">Clothes</label>
								</div>	
																			<!-- <label class="radio-inline">
																			<input  type="radio" name="optradio" checked value="General"/>General
																			</label>
																			<label class="radio-inline">
																			<input  type="radio" name="optradio" value="Food"/>Food
																			</label>
																			<label class="radio-inline">
																			<input  type="radio" name="optradio" value="Home"/>Electronics
																			</label>
																			<label class="radio-inline">
																			<input type="radio" name="optradio" value="Electricity"/>Bill
																			</label>
																			<label class="radio-inline">
																			<input  type="radio" name="optradio" value="Other"/>Sport
																			</label>
																			<label class="radio-inline">
																			<input  type="radio" name="optradio" value="Other"/>Clothes
																			</label> -->
                                
								
								  <br><br>
								
								<div class="form-group has-success">
									<button type="submit" class="btn btn-primary" name="submit">Submit</button>
								</div>
								
								
								</div>
								
							</form>
						</div>
					</div>
				</div><!-- /.panel-->
				
			</div><!-- /.col-->
			
			<?php include_once('includes/footer.php');?>
			
		</div><!-- /.row -->
	</div><!--/.main-->
	
<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/chart.min.js"></script>
	<script src="js/chart-data.js"></script>
	<script src="js/easypiechart.js"></script>
	<script src="js/easypiechart-data.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script src="js/custom.js"></script>
	
</body>
</html>
<?php } ?>                         
                                
                                
                                

