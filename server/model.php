<?php
	$host="localhost";
	$dbUsername="root";
	$dbPassword="bhuvanbanyan2109";
	$dbName="sccrm";
    $conn = new PDO("mysql:host=$host;dbname=$dbName", $dbUsername, $dbPassword);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if(!isset($_SESSION)){
	    session_start();
	}
	function insert_details($details)
	{
		global $conn;
		try{
			$query = $conn->prepare("INSERT INTO school_details (school_name,address,city,zipcode,boardname,no_of_students,price_quoted,deal_value,poc,others,principal_name,principal_phone_no,principal_email_id,corresspondent_name,corresspondent_phone_no,corresspondent_email_id,admin_name,admin_phone_no,admin_email_id,others_name,others_phone_no,others_email_id,date_met,stage,follow_up_date,user_id)
										VALUES (:school_name, :address, :city, :zipcode, :boardname, :no_of_students, :price_quoted, :deal_value, :poc, :others, :principal_name, :principal_phone_no, :principal_email_id, :corresspondent_name, :corresspondent_phone_no, :corresspondent_email_id, :admin_name, :admin_phone_no, :admin_email_id, :others_name, :others_phone_no, :others_email_id, :date_met, :stage, :follow_up_date,:user_id)");
			$deal_quoted = $details['noOfStudents']*$details['priceQuoted'];
			$query->bindParam(':school_name', $details['schoolName'],PDO::PARAM_STR);
			$query->bindParam(':address', $details['streetAddress'],PDO::PARAM_STR);
			$query->bindParam(':city', $details['cityName'],PDO::PARAM_STR);
			$query->bindParam(':zipcode', $details['zipCode'],PDO::PARAM_STR);
			$query->bindParam(':boardname', $details['schoolBoard'],PDO::PARAM_STR);
			$query->bindParam(':no_of_students', $details['noOfStudents'],PDO::PARAM_INT);
			$query->bindParam(':price_quoted', $details['priceQuoted'],PDO::PARAM_INT);
			$query->bindParam(':deal_value', $deal_quoted,PDO::PARAM_INT);
			$query->bindParam(':poc', $details['pointOfContact'],PDO::PARAM_STR);
			$query->bindParam(':others', $details['poinOfContactOthers'],PDO::PARAM_STR);
			$query->bindParam(':principal_name', $details['principalName'],PDO::PARAM_STR);
			$query->bindParam(':principal_phone_no', $details['principalPhoneNo'],PDO::PARAM_STR);
			$query->bindParam(':principal_email_id', $details['principalEMail'],PDO::PARAM_STR);
			$query->bindParam(':corresspondent_name', $details['corresspondentName'],PDO::PARAM_STR);
			$query->bindParam(':corresspondent_phone_no', $details['corresspondentPhoneNo'],PDO::PARAM_STR);
			$query->bindParam(':corresspondent_email_id', $details['corresspondentEMail'],PDO::PARAM_STR);
			$query->bindParam(':admin_name', $details['adminName'],PDO::PARAM_STR);
			$query->bindParam(':admin_phone_no', $details['adminPhoneNo'],PDO::PARAM_STR);
			$query->bindParam(':admin_email_id', $details['adminEMail'],PDO::PARAM_STR);
			$query->bindParam(':others_name', $details['othersName'],PDO::PARAM_STR);
			$query->bindParam(':others_phone_no', $details['othersPhoneNo'],PDO::PARAM_STR);
			$query->bindParam(':others_email_id', $details['othersEMail'],PDO::PARAM_STR);
			$query->bindParam(':date_met', date('y/m/d',strtotime($details['dateMet'])),PDO::PARAM_STR);
			$query->bindParam(':stage', $details['stage'],PDO::PARAM_STR);
			$query->bindParam(':follow_up_date', date('y/m/d',strtotime($details['nextFollowupDate'])),PDO::PARAM_STR);
			$query->bindParam(':user_id', $_SESSION['user'],PDO::PARAM_INT);

			$query->execute();
			return $conn->lastInsertId();

		}
		catch(PDOException $e){
			return $e->getMessage();

		}

	}
	function edit_details($details)
	{
		global $conn;
		try{
			$query = $conn->prepare("UPDATE school_details 
SET school_name=:school_name, address=:address, city=:city, zipcode=:zipcode, boardname=:boardname, no_of_students=:no_of_students,price_quoted=:price_quoted,deal_value=:deal_value, poc=:poc, others=:others, principal_name=:principal_name,principal_phone_no=:principal_phone_no, principal_email_id=:principal_email_id, corresspondent_name=:corresspondent_name,corresspondent_phone_no=:corresspondent_phone_no, corresspondent_email_id=:corresspondent_email_id,admin_name=:admin_name,admin_phone_no=:admin_phone_no,admin_email_id=:admin_email_id,others_name=:others_name,others_phone_no=:others_phone_no,others_email_id=:others_email_id,date_met=:date_met,stage=:stage,follow_up_date=:follow_up_date,user_id=:user_id 
WHERE id=:school_detail_id");
			$deal_quoted = $details['noOfStudents']*$details['priceQuoted'];
			$query->bindParam(':school_name', $details['schoolName'],PDO::PARAM_STR);
			$query->bindParam(':address', $details['streetAddress'],PDO::PARAM_STR);
			$query->bindParam(':city', $details['cityName'],PDO::PARAM_STR);
			$query->bindParam(':zipcode', $details['zipCode'],PDO::PARAM_STR);
			$query->bindParam(':boardname', $details['schoolBoard'],PDO::PARAM_STR);
			$query->bindParam(':no_of_students', $details['noOfStudents'],PDO::PARAM_INT);
			$query->bindParam(':price_quoted', $details['priceQuoted'],PDO::PARAM_INT);
			$query->bindParam(':deal_value', $deal_quoted,PDO::PARAM_INT);
			$query->bindParam(':poc', $details['pointOfContact'],PDO::PARAM_STR);
			$query->bindParam(':others', $details['poinOfContactOthers'],PDO::PARAM_STR);
			$query->bindParam(':principal_name', $details['principalName'],PDO::PARAM_STR);
			$query->bindParam(':principal_phone_no', $details['principalPhoneNo'],PDO::PARAM_STR);
			$query->bindParam(':principal_email_id', $details['principalEMail'],PDO::PARAM_STR);
			$query->bindParam(':corresspondent_name', $details['corresspondentName'],PDO::PARAM_STR);
			$query->bindParam(':corresspondent_phone_no', $details['corresspondentPhoneNo'],PDO::PARAM_STR);
			$query->bindParam(':corresspondent_email_id', $details['corresspondentEMail'],PDO::PARAM_STR);
			$query->bindParam(':admin_name', $details['adminName'],PDO::PARAM_STR);
			$query->bindParam(':admin_phone_no', $details['adminPhoneNo'],PDO::PARAM_STR);
			$query->bindParam(':admin_email_id', $details['adminEMail'],PDO::PARAM_STR);
			$query->bindParam(':others_name', $details['othersName'],PDO::PARAM_STR);
			$query->bindParam(':others_phone_no', $details['othersPhoneNo'],PDO::PARAM_STR);
			$query->bindParam(':others_email_id', $details['othersEMail'],PDO::PARAM_STR);
			$query->bindParam(':date_met', date('y/m/d',strtotime($details['dateMet'])),PDO::PARAM_STR);
			$query->bindParam(':stage', $details['stage'],PDO::PARAM_STR);
			$query->bindParam(':follow_up_date', date('y/m/d',strtotime($details['nextFollowupDate'])),PDO::PARAM_STR);
			$query->bindParam(':user_id', $_SESSION['user'],PDO::PARAM_INT);
			$query->bindParam(':school_detail_id', $details['school_detail_id'],PDO::PARAM_INT);

			
			return $query->execute();

		}
		catch(PDOException $e){
			return $e->getMessage();

		}

	}
	function authenticate_user($details)
	{
		global $conn;
		try{
			$query = $conn->prepare("SELECT id FROM users WHERE username = :username and password = :password");
			$query->bindParam(':username', $details['username'],PDO::PARAM_STR);
			$query->bindParam(':password', $details['password'],PDO::PARAM_STR);
			$ret = $query->execute();
			return $query->fetchColumn();

		}
		catch(PDOException $e){
			return $e->getMessage();

		}

	}
	function insert_comment($school_detail_id,$comment)
	{
		$username	=	get_username();
		global $conn;
		try{
			$query = $conn->prepare("INSERT INTO comments (school_details_id,name,comments)
										VALUES (:school_details_id, :name, :comments)");
			
			$query->bindParam(':school_details_id', $school_detail_id,PDO::PARAM_INT);
			$query->bindParam(':name', $username,PDO::PARAM_STR);
			$query->bindParam(':comments', $comment,PDO::PARAM_STR);
			

			$query->execute();
			return $conn->lastInsertId();

		}
		catch(PDOException $e){
			return $e->getMessage();

		}

	}
	function get_school_details()
	{
		global $conn;
		try{
			if(!empty($_SESSION['admin']))
				$query = $conn->prepare("SELECT sd.id,u.name,sd.school_name,sd.city,sd.boardname,sd.no_of_students,sd.price_quoted,sd.deal_value,sd.date_met,sd.stage FROM school_details sd,users u where sd.user_id=u.id");
			else
				$query = $conn->prepare("SELECT id,school_name,city,boardname,no_of_students,price_quoted,deal_value,date_met,stage FROM school_details WHERE user_id=".$_SESSION['user']);
			
			$query->execute();
			$rows=array();
			while($row=$query->fetch(PDO::FETCH_ASSOC))
				array_push($rows, $row);
			return $rows;

		}
		catch(PDOException $e){
			return $e->getMessage();

		}
	}
	function get_full_detail_of_a_school($school_detail_id)
	{
		global $conn;
		try{				
			$query = $conn->prepare("SELECT * FROM school_details WHERE id=".$school_detail_id);
			$query->execute();
			return $query->fetch(PDO::FETCH_ASSOC);

		}
		catch(PDOException $e){
			return $e->getMessage();

		}		
	}
	function get_username(){
		global $conn;
		try{
			$query = $conn->prepare("SELECT name FROM users WHERE id=:user_id");
			$query->bindParam(':user_id', $_SESSION['user'],PDO::PARAM_INT);
			$query->execute();
			return $query->fetchColumn();

		}
		catch(PDOException $e){
			return $e->getMessage();

		}
	}
	function get_comments($school_detail_id)
	{
		global $conn;
		try{
			
			$query = $conn->prepare("SELECT name,last_updated_time,comments FROM comments WHERE school_details_id=".$school_detail_id);			
			$query->execute();
			$rows=array();
			while($row=$query->fetch(PDO::FETCH_ASSOC))
				array_push($rows, $row);
			return $rows;

		}
		catch(PDOException $e){
			return $e->getMessage();

		}
	}
?>


