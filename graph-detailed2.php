<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['detsuid']==0)) {
  header('location:logout.php');
  } 
else{
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
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    
    
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
                        <div class="panel-heading" >Generated Expense Report</div>
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
                        <script>
                            window.onload = function () {
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
                                var chart = new CanvasJS.Chart("chart", {
                                    animationEnabled: true,
                                    
                                    data: [{
                                        type: "doughnut",
                                        startAngle: 60,
                                        indexLabelFontSize: 17,
                                        indexLabel: "{label} - #percent%",
                                        toolTipContent: "<b>{label}:</b>(#percent%)", 
                                        dataPoints: points    
                                    }]
                                });
                                chart.render();
                            }
                        </script>
                        
                        <p id="chart" style="height: 300px; width: 100%;"></p>
                        
                    </div>    
                </div>
            </div>
        </div>   
    </div>        
</div>
                <style>
                    @media screen and (max-width < 600px) {
                        #chart{
                            color:white;
                            width:60%;
                        }
                    }
                    @media screen and (max-width < 800px) {
                        #chart{
                            color:white;
                            width:70%;
                        }
                    }
                </style>    
</body>
</html>
<?php } ?>

