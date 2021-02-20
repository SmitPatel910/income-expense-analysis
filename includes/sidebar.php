<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
?>


<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
        <div class="profile-sidebar">
            <div class="profile-userpic">
                <img src="https://images.pexels.com/photos/220453/pexels-photo-220453.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" class="img-responsive" alt="">
            </div>

            <div class="profile-usertitle">
                <?php
                $uid=$_SESSION['detsuid'];
                $ret=mysqli_query($con,"select FullName from tbluser where ID='$uid'");
                $row=mysqli_fetch_array($ret);
                $name=$row['FullName'];
                ?>
                <div class="profile-usertitle-name"><a href="user-profile.php"><?php echo $name; ?></a></div>
                <div class="profile-usertitle-status"><span class="indicator label-success"></span>Online</div>
            </div>
            <div class="clear"></div>
        </div>
        




        <div class="divider"></div>
        <ul class="nav menu">
            
            
            <li class="active"><a href="dashboard.php"><em class="fa fa-dashboard">&nbsp;</em>Dashboard</a></li>
            
            <li class="parent "><a data-toggle="collapse" href="#sub-item-1">
                <em class="fa fa-navicon">&nbsp;</em>Income<span data-toggle="collapse" href="#sub-item-1" class="icon pull-right"><em class="fa fa-plus"></em></span>
                </a>
                
                <ul class="children collapse" id="sub-item-1">
                    <li><a class="" href="add-income.php">
                        <span class="fa fa-arrow-right">&nbsp;</span> Add Income
                    </a></li>
                    <li><a class="" href="manage-income.php">
                        <span class="fa fa-arrow-right">&nbsp;</span> Manage Income
                    </a></li>
                    
                    
                    
                </ul>

            </li>


            <li class="parent "><a data-toggle="collapse" href="#sub-item-2">
                <em class="fa fa-navicon">&nbsp;</em>Expenses <span data-toggle="collapse" href="#sub-item-2" class="icon pull-right"><em class="fa fa-plus"></em></span>
                </a>
                
                <ul class="children collapse" id="sub-item-2">
                    <li><a class="" href="add-expense.php">
                        <span class="fa fa-arrow-right">&nbsp;</span> Add Expenses
                    </a></li>
                    <li><a class="" href="manage-expense.php">
                        <span class="fa fa-arrow-right">&nbsp;</span> Manage Expenses
                    </a></li>
                    
                </ul>

            </li>
           
            <li class="parent "><a data-toggle="collapse" href="#sub-item-3">
                <em class="fa fa-navicon">&nbsp;</em>Generate Report <span data-toggle="collapse" href="#sub-item-3" class="icon pull-right"><em class="fa fa-plus"></em></span>
                </a>
                <ul class="children collapse" id="sub-item-3">
                    
                    <li><a class="" href="income-report.php">
                        <span class="fa fa-arrow-right">&nbsp;</span> Income Report 
                    </a></li>
                    <li><a class="" href="expense-report.php">
                        <span class="fa fa-arrow-right">&nbsp;</span> Expense Report 
                    </a></li>
                    <li><a class="" href="Income-report-typewise.php">
                        <span class="fa fa-arrow-right">&nbsp;</span> Typewise Income
                    </a></li>
                    <li><a class="" href="Expense-report-typewise.php">
                        <span class="fa fa-arrow-right">&nbsp;</span> Typewise Expense
                    </a></li>
                    <li><a class="" href="income-expense-report.php">
                        <span class="fa fa-arrow-right">&nbsp;</span> Income vs Expense
                    </a></li>
                </ul>
            </li>

            <!-- <li><a href="user-profile.php"><em class="fa fa-user">&nbsp;</em> Profile</a></li> -->
             
            <li><a href="change-password.php"><em class="fa fa-clone">&nbsp;</em> Change Password</a></li>

            <li><a href="logout.php"><em class="fa fa-power-off">&nbsp;</em> Logout</a></li>

        </ul>
</div>
