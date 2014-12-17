<?php
    if(!isset($_SESSION)){
        session_start();
    }
    if(empty($_SESSION['admin']))
    {
        header('Location: home.php');
    }
    else if(!empty($_SESSION['user']))
    {
        header('Location: dashboard.php');
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Schoolcom</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="css/plugins/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/main.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="css/plugins/morris.css" rel="stylesheet">
    <link href="css/plugins/jqwidgets/jqx.base.css" rel="stylesheet">
    <link href="css/plugins/jqwidgets/jqx.bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="css/plugins/jqwidgets/jqx.windowsphone.css" type="text/css" />
    <link rel="stylesheet" href="css/plugins/jqwidgets/jqx.blackberry.css" type="text/css" />
    <link rel="stylesheet" href="css/plugins/jqwidgets/jqx.mobile.css" type="text/css" />
    <link rel="stylesheet" href="css/plugins/jqwidgets/jqx.android.css" type="text/css" />

    <!-- Custom Fonts -->
    <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->




</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">SchoolCom</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
            	<li id='welcomeUser'>Welcome Mangal</li>
                <li>
                    <button id="showDetailModal" type="button" class="btn btn-primary">Add School</button>
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        
                        <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <!-- <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        
                        <li>
                            <a class="active" href="admin.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                            <a ><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            <!--/div> -->
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Dashboard</h1>
                </div>
                <!-- /.col-lg-12 -->
                <div id="schoolGrid"></div>
            </div>
            <div id="reportTable" style="display:none" class="table-responsive">
			   <table class="table table-striped">
			      <caption><h3>Report</h3></caption>
			      <tbody>
			         <tr>
			            <td>No of Schools dealt with</td>
			            <td id="schoolAggregateContainer"></td>
			         </tr>
			         <tr>
			            <td>No of Students dealt with</td>
			            <td id="studentAggregateContainer"></td>
			         </tr>
			         <tr>
			            <td>Average Price Quoted</td>
			            <td id="priceQuotedAggregateContainer"></td>
			         </tr>
			         <tr>
			            <td>Total Deal Value dealt with</td>
			            <td id="dealValueAggregateContainer"></td>
			         </tr>
			         <tr>
			            <td>No of Schools in Stage -1</td>
			            <td id="stageAggregateContainer"></td>
			         </tr>
			         <tr>
			            <td>No of Schools in Stage 0</td>
			            <td id="stage0AggregateContainer"></td>
			         </tr>
			         <tr>
			            <td>No of Schools in Stage 1</td>
			            <td id="stage1AggregateContainer"></td>
			         </tr>
			         <tr>
			            <td>No of Schools in Stage 2</td>
			            <td id="stage2AggregateContainer"></td>
			         </tr>
			      </tbody>
			   </table>
</div>  	
           <div id="stageGrid"></div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    <!-- Form Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="myModalLabel">Add Detail</h4>
          </div>
          <div class="modal-body">
                <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <form name="detailForm" role="form">
                                        <div class="form-group">
                                            <label>School Name</label>
                                            <input name='schoolName' class="form-control" placeholder="Please enter schoolname here">
                                           
                                        </div>
                                        <div class="form-group">
                                            <label>Address</label>
                                            <input name='streetAddress' class="form-control" placeholder="Street Address">
                                        </div>
                                        
                                            
                                        <div class="form-group col-lg-6">
                                            <input name='cityName' class="form-control" placeholder="City Name">
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <input name='zipCode' class="form-control" placeholder="Zip Code">
                                        </div>
                                        <div class="form-group">
                                            <label>Board</label>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="schoolBoard" id="schoolBoard1" value="State Board" checked>State Board
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="schoolBoard" id="schoolBoard2" value="CBSE">CBSE
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="schoolBoard" id="schoolBoard3" value="ICSE">ICSE
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="schoolBoard" id="schoolBoard4" value="International">International
                                                </label>
                                            </div>                                            
                                        </div>
                                        <div class="form-group">
                                            <label>Number of Students</label>
                                            <input  name='noOfStudents' class="form-control" placeholder="No of Students">            
                                        </div>  
                                        <div class="form-group">
                                            <label>Price Quoted</label>
                                            <input  name='priceQuoted' class="form-control" placeholder="Price Quoted per student">
                                           
                                        </div>    
                                        <div class="form-group">
                                            <label>Deal Value</label>
                                            <input data-toggle="tooltip" data-placement="top" title="Will be autocalculated based on NoOf students and Price Quoted" disabled name='dealValue' class="form-control" placeholder="Price Quoted per student * No of student">
                                           
                                        </div>

                                        <div class="form-group">
                                            <label>Point Of Contact</label>
                                            <select name='pointOfContact' class="form-control">
                                                <option value='principal'>Principal</option>
                                                <option value='corresspondent'>Corresspondent</option>
                                                <option value='admin'>Admin</option>
                                                <option value='others'>Other</option>
                                            </select>
                                            <div style='display:none' id='pointOfContactOthersBlock' class="help-block">
                                                <label>If others please enter Occupation</label>
                                                <input  name='poinOfContactOthers' class="form-control" placeholder="Point of Contact Others">
                                               
                                            </div>
                                        </div> 
                                        <div class="form-group">
                                            <label>Contact Details</label>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label>Principal</label>
                                            <div class="form-group">
                                                <input  name='principalName' class="form-control" placeholder="Principal Name">
                                            </div>
                                            <div class="form-group">
                                                <input  name='principalPhoneNo' class="form-control" placeholder="Principal Phone Number">
                                            </div>
                                            <div class="form-group">
                                                <input  name='principalEMail' class="form-control" placeholder="Principal E-Mail id">
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label>Corresspondent</label>
                                            <div class="form-group">
                                                <input  name='corresspondentName' class="form-control" placeholder="Corresspondent Name">
                                            </div>
                                            <div class="form-group">
                                                <input  name='corresspondentPhoneNo' class="form-control" placeholder="Corresspondent Phone Number">
                                            </div>
                                            <div class="form-group">
                                                <input  name='corresspondentEMail' class="form-control" placeholder="Corresspondent E-Mail id">
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label>Admin</label>
                                            <div class="form-group">
                                                <input  name='adminName' class="form-control" placeholder="Admin Name">
                                            </div>
                                            <div class="form-group">
                                                <input  name='adminPhoneNo' class="form-control" placeholder="Admin Phone Number">
                                            </div>
                                            <div class="form-group">
                                                <input  name='adminEMail' class="form-control" placeholder="Admin E-Mail id">
                                            </div>
                                        </div>
                                        <div id="othersContactDetailsBlock" style="display:none" class="form-group col-lg-6">
                                            <label>Others</label>
                                            <div class="form-group">
                                                <input  name='othersName' class="form-control" placeholder="Others Name">
                                            </div>
                                            <div class="form-group">
                                                <input  name='othersPhoneNo' class="form-control" placeholder="Others Phone Number">
                                            </div>
                                            <div class="form-group">
                                                <input  name='othersEMail' class="form-control" placeholder="Others E-Mail id">
                                            </div>

                                        </div>
                                        <div class="form-group col-lg-12">
                                            <label>Date Met</label>
                                            <input  name='dateMet' class="form-control" placeholder="Date Met">
                                           
                                        </div> 
                                        <div class="form-group col-lg-12">
                                            <label>Stage</label>
                                            <select name='stage' class="form-control">
                                                <option value='-1'>-1</option>
                                                <option value='0'>0</option>
                                                <option value='1'>1</option>
                                                <option value='2'>2</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-12">
                                            <label>Next Follow up Date</label>
                                            <input  name='nextFollowupDate' class="form-control" placeholder="Next Follow up Date">
                                           
                                        </div>
                                        <div id='lastUpdatedBlock' class="help-block  col-lg-12"></div>
                                        <div>
                                            <div class="col-lg-12">
                                            <div class="well">
                                                <h4>Comments</h4>
                                            <div class="form-group">
                                                 <textarea name='comments' style="resize:none" class="form-control" placeholder="Type your comments here..." rows="3"></textarea>
                                                
                                            </div>
                                            <hr>
                                            <ul id="comments_container" class="list-unstyled ui-sortable">
                                                
                                                
                                            </ul>
                                            </div>
                                        </div>
                                        

                                        
                                               
                                               
                                            


                                    </form>
                                </div>
                                
                            </div>
                            <!-- /.row (nested) -->
                        </div>
          </div>
          <div class="modal-footer">
          <button id="deleteSchool" style="display:none" type="button" class="btn btn-danger">Delete</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button id="saveChanges" type="button" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Form Modal -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="js/plugins/metisMenu/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="js/plugins/morris/raphael.min.js"></script>
    <!--script src="js/plugins/morris/morris.min.js"></script>
    <script src="js/plugins/morris/morris-data.js"></script-->

    <!-- Custom Theme JavaScript -->
    

    <script src="https://code.jquery.com/ui/1.11.2/jquery-ui.min.js"></script>



    <script type="text/javascript" src="js/plugins/jqwidgets/jqxcore.js"></script>
    <script type="text/javascript" src="js/plugins/jqwidgets/jqxdata.js"></script>
    <script type="text/javascript" src="js/plugins/jqwidgets/jqxbuttons.js"></script>
    <script type="text/javascript" src="js/plugins/jqwidgets/jqxscrollbar.js"></script>
    <script type="text/javascript" src="js/plugins/jqwidgets/jqxlistbox.js"></script>
    <script type="text/javascript" src="js/plugins/jqwidgets/jqxdropdownlist.js"></script>
    <script type="text/javascript" src="js/plugins/jqwidgets/jqxmenu.js"></script>
    <script type="text/javascript" src="js/plugins/jqwidgets/jqxgrid.js"></script>
    <script type="text/javascript" src="js/plugins/jqwidgets/jqxgrid.filter.js"></script>
    <script type="text/javascript" src="js/plugins/jqwidgets/jqxgrid.sort.js"></script>
    <script type="text/javascript" src="js/plugins/jqwidgets/jqxgrid.selection.js"></script>
     <script type="text/javascript" src="js/plugins/jqwidgets/jqxgrid.aggregates.js"></script>
    <script type="text/javascript" src="js/plugins/jqwidgets/jqxpanel.js"></script>
    <script type="text/javascript" src="js/plugins/jqwidgets/jqxcalendar.js"></script>
    <script type="text/javascript" src="js/plugins/jqwidgets/jqxdatetimeinput.js"></script>
    <script type="text/javascript" src="js/plugins/jqwidgets/jqxcheckbox.js"></script>
    <script type="text/javascript" src="js/plugins/jqwidgets/jqxtouch.js"></script>

    <!--script type="text/javascript" src="js/plugins/jqwidgets/globalization/globalize.js"></script-->



    <script src="js/admin.js"></script>

</body>

</html>
