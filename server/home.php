<?php
include_once 'model.php';
if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    switch($action) {
        case 'update_school_detail' : 
        	update_school_detail();
        	break;
        case 'login' :
        	login();
        	break;
        case 'fetch_data':
        	fetch_data();
        	break;
        case 'fetch_full_data':
        	fetch_full_data();
        	break;
        case 'get_user':
        	get_user();
        	break;

        
    }
}
function update_school_detail()
{
	if(isset($_POST['school_detail_id']) || ! empty($_POST['school_detail_id']))
		$school_detail_id = $_POST['school_detail_id'];
	else
		$school_detail_id = '';
	if(empty($_SESSION['admin']) && empty($_SESSION['user']))
    {
        $response['error'] = 1;
		$response['message'] = "Not logged in";
		echo json_encode($response);
		return;
    }
	try{
		if( ! isset($_POST['schoolName']) || empty($_POST['schoolName']))
			throw new Exception("Enter School Name");
		if(strlen($_POST['schoolName'])>300)
			throw new Exception("School Name should be less than 300 characters");
		if( ! isset($_POST['streetAddress']) || empty($_POST['streetAddress']))
			throw new Exception("Enter Street Address");
		if(strlen($_POST['streetAddress'])>300)
			throw new Exception("Street Address should be less than 300 characters");
		if( ! isset($_POST['cityName']) || empty($_POST['cityName']))
			throw new Exception("Enter City Name");
		if(strlen($_POST['cityName'])>100)
			throw new Exception("City Name should be less than 100 characters");
		if( ! isset($_POST['zipCode']) || empty($_POST['zipCode']))
			throw new Exception("Enter Zip code");
		if(strlen($_POST['zipCode'])>6 || ! is_numeric($_POST['zipCode']))
			throw new Exception("Enter valid 6 digit zip code number");
		if( ! isset($_POST['schoolBoard']) || empty($_POST['schoolBoard']) || strlen($_POST['schoolBoard'])>30)
			throw new Exception("Select valid Board name");
		if( ! isset($_POST['noOfStudents']) || empty($_POST['noOfStudents']) || strlen($_POST['noOfStudents']) >11 || ! is_numeric($_POST['noOfStudents']))
			throw new Exception("Enter Valid No of students");
		if( ! isset($_POST['priceQuoted']) || empty($_POST['priceQuoted']) || strlen($_POST['priceQuoted']) >11 || ! is_numeric($_POST['priceQuoted']))
			throw new Exception("Enter Valid Price Quoted");
		if( ! isset($_POST['pointOfContact']) || empty($_POST['pointOfContact']) || strlen($_POST['pointOfContact']) >30)
			throw new Exception("Select Valid point of contact");
		if($_POST['pointOfContact']=='others' && ( ! isset($_POST['poinOfContactOthers']) || empty($_POST['poinOfContactOthers']) || strlen($_POST['poinOfContactOthers']) >30))
			throw new Exception("Enter Others Occupation");
		if(strlen($_POST['principalName']) > 50) 
			throw new Exception("Principal Name should be less than 50 character");
		if(strlen($_POST['principalPhoneNo']) > 10 || (! is_numeric($_POST['principalPhoneNo']) && !empty($_POST['principalPhoneNo'])))
			throw new Exception("Principal phone number should be valid 10 digit integer");
		if(strlen($_POST['principalEMail'])>50)
			throw new Exception("Principal's email should be less than 50 charcter");
		if(!filter_var($_POST['principalEMail'], FILTER_VALIDATE_EMAIL) && ! empty($_POST['principalEMail']))
			throw new Exception("Principal email is not valid");
		if(strlen($_POST['corresspondentName']) > 50) 
			throw new Exception("corresspondent Name should be less than 50 character");
		if(strlen($_POST['corresspondentPhoneNo']) > 10 || (! is_numeric($_POST['corresspondentPhoneNo']) && !empty($_POST['corresspondentPhoneNo'])))
			throw new Exception("corresspondent phone number should be valid 10 digit integer");
		if(strlen($_POST['corresspondentEMail'])>50)
			throw new Exception("corresspondent's email should be less than 50 charcter");
		if(!filter_var($_POST['corresspondentEMail'], FILTER_VALIDATE_EMAIL) && !empty($_POST['corresspondentEMail']))
			throw new Exception("corresspondent email is not valid");
		if(strlen($_POST['adminName']) > 50) 
			throw new Exception("admin Name should be less than 50 character");
		if(strlen($_POST['adminPhoneNo']) > 10 || (! is_numeric($_POST['adminPhoneNo']) && ! empty($_POST['adminPhoneNo'])))
			throw new Exception("admin phone number should be valid 10 digit integer");
		if(strlen($_POST['adminEMail'])>50)
			throw new Exception("admin's email should be less than 50 charcter");
		if(!filter_var($_POST['adminEMail'], FILTER_VALIDATE_EMAIL) && ! empty($_POST['adminEMail']))
			throw new Exception("admin email is not valid");
		if(strlen($_POST['othersName']) > 50) 
			throw new Exception("others Name should be less than 50 character");
		if(strlen($_POST['othersPhoneNo']) > 10 || (! is_numeric($_POST['othersPhoneNo']) && !empty($_POST['othersPhoneNo'])))
			throw new Exception("others phone number should be valid 10 digit integer");
		if(strlen($_POST['othersEMail'])>50)
			throw new Exception("others's email should be less than 50 charcter");
		if(!filter_var($_POST['othersEMail'], FILTER_VALIDATE_EMAIL) && ! empty($_POST['othersEMail']))
			throw new Exception("others email is not valid");
/*		if(! isset($_POST[$_POST['pointOfContact'].'Name']) || empty($_POST[$_POST['pointOfContact'].'Name']) || ! isset($_POST[$_POST['pointOfContact'].'PhoneNo']) || empty($_POST[$_POST['pointOfContact'].'PhoneNo']) || isset($_POST[$_POST['pointOfContact'].'EMail']) || empty($_POST[$_POST['pointOfContact'].'EMail']))
			throw new Exception("Enter Point of contact's contact detail");*/
		if( ! isset($_POST['dateMet']) || empty($_POST['dateMet']))
			throw new Exception("Select Date Met");
		if( ! isset($_POST['stage']) || empty($_POST['stage']) || strlen($_POST['stage']) >2)
			throw new Exception("Select Valid Stage");

	}
	catch(Exception $e){
		$response['error'] = 1;
		$response['message'] = $e->getMessage();
		echo json_encode($response);
		return;
		
	}

	if(empty($_POST['edit']))
	{
		//Code to insert new school
		$result = insert_details($_POST);
		if(is_numeric($result))
		{
			$school_detail_id = $result;		
			$response['error'] = 0;
			$response['message'] = "Updated Successfully";
		}
		else
		{
			$response['error'] = 1;
			$response['message'] = "Couldn't insert data.Please Try again";			
		}
	}
	else 
	{
		$result = edit_details($_POST);
		if($result)
		{
			$response['error'] = 0;
			$response['message'] = "Updated Successfully";
		}
		else
		{
			$response['error'] = 1;
			$response['message'] = "Couldn't insert data.Please Try again";
			
		}
	}
	if(isset($_POST['comments']) || ! empty($_POST['comments']))
	{
		if(!insert_comment($school_detail_id,$_POST['comments']))
		{
			$response['error'] = 0;
			$response['message'] = "School details updated .Couldn't insert Comment.Please Try again";
		}
	}
	echo json_encode($response);
}

function login()
{
	
	try{
		if( ! isset($_POST['username']) || empty($_POST['username']))
			throw new Exception("Enter User Name");
		if( ! isset($_POST['password']) || empty($_POST['password']))
			throw new Exception("Enter Password");
	}
	catch(Exception $e){
		$response['error'] = 1;
		$response['message'] = $e->getMessage();
		echo json_encode($response);
		return;		
	}
	$result = authenticate_user($_POST);
	if(! $result)
	{
		$response['error'] = 1;
		$response['message'] = "Username of password combination Invalid";
	}
	else
	{
		if($result[0]==1)
		{
			$_SESSION['admin'] = $result[0];
		}
		else
			$_SESSION['user'] = $result[0];
		$response['error'] = 0;
		
	}

	echo json_encode($response);
}

function fetch_data()
{
	if(empty($_SESSION['admin']) && empty($_SESSION['user']))
    {
        $response['error'] = 1;
		$response['message'] = "Not logged in";
		echo json_encode($response);
		return;
    }
    $response = get_school_details();
    echo json_encode($response);
}
function fetch_full_data()
{
	$response = array();
	if(empty($_SESSION['admin']) && empty($_SESSION['user']))
    {
        $response['error'] = 1;
		$response['message'] = "Not logged in";
		echo json_encode($response);
		return;
    }
    if(isset($_POST['school_detail_id']))
    {
    	$response['school_data'] = get_full_detail_of_a_school($_POST['school_detail_id']);
    	$response['comments'] = get_comments($_POST['school_detail_id']);
    }
    echo json_encode($response);
}
function get_user()
{
	if(empty($_SESSION['admin']) && empty($_SESSION['user']))
    {
        $response['error'] = 1;
		$response['message'] = "Not logged in";
		echo json_encode($response);
		return;
    }
    $response['error'] = 0;
    $response['username'] = get_username();
    echo json_encode($response);
}

?>