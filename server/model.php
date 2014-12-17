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
			$query->bindParam(':follow_up_date', $details['nextFollowupDate'] ? date('y/m/d',strtotime($details['nextFollowupDate'])) : null,PDO::PARAM_STR);
			$query->bindParam(':user_id', $_SESSION['user'] ? $_SESSION['user'] : $_SESSION['admin']  ,PDO::PARAM_INT);

			$query->execute();
			return $conn->lastInsertId();

		}
		catch(PDOException $e){
			return $e->getMessage();

		}

	}
	function insert_initial_stage($stage,$school_detail_id,$date_met)
	{
		$username	=	get_username();
		global $conn;
		try{
			$query = $conn->prepare("INSERT INTO initial_stages (school_detail_id,changed_by,stage,date_converted)
										VALUES (:school_detail_id,:changed_by,:stage,:date_converted)");
			
			$query->bindParam(':school_detail_id', $school_detail_id,PDO::PARAM_INT);
			$query->bindParam(':changed_by', $username,PDO::PARAM_STR);
			$query->bindParam(':stage', $stage,PDO::PARAM_STR);
	
			$query->bindParam(':date_converted', date('y/m/d',strtotime($date_met)),PDO::PARAM_STR);
			

			
			return $query->execute();

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
SET school_name=:school_name, address=:address, city=:city, zipcode=:zipcode, boardname=:boardname, no_of_students=:no_of_students,price_quoted=:price_quoted,deal_value=:deal_value, poc=:poc, others=:others, principal_name=:principal_name,principal_phone_no=:principal_phone_no, principal_email_id=:principal_email_id, corresspondent_name=:corresspondent_name,corresspondent_phone_no=:corresspondent_phone_no, corresspondent_email_id=:corresspondent_email_id,admin_name=:admin_name,admin_phone_no=:admin_phone_no,admin_email_id=:admin_email_id,others_name=:others_name,others_phone_no=:others_phone_no,others_email_id=:others_email_id,date_met=:date_met,stage=:stage,follow_up_date=:follow_up_date,last_updated_by=:last_updated_by
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
			if(isset($_SESSION['user']))
				$query->bindParam(':last_updated_by', $_SESSION['user'],PDO::PARAM_INT);
			else
				$query->bindParam(':last_updated_by', $_SESSION['admin'],PDO::PARAM_INT);
			
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
				$query = $conn->prepare("SELECT sd.id,u.name,sd.school_name,sd.city,sd.boardname,sd.no_of_students,sd.price_quoted,sd.deal_value,sd.date_met,sd.stage,sd.follow_up_date FROM school_details sd,users u where sd.user_id=u.id");
			else
				$query = $conn->prepare("SELECT id,school_name,city,boardname,no_of_students,price_quoted,deal_value,date_met,stage,follow_up_date FROM school_details WHERE user_id=".$_SESSION['user']);
			
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
			if(isset($_SESSION['user']))
				$query->bindParam(':user_id', $_SESSION['user'],PDO::PARAM_INT);
			else
				$query->bindParam(':user_id', $_SESSION['admin'],PDO::PARAM_INT);
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
	function delete_school_data($school_detail_id)
	{
		delete_comments($school_detail_id);
		global $conn;
		try{				
			$query = $conn->prepare("DELETE FROM school_details WHERE id=".$school_detail_id);
			
			return $query->execute();

		}
		catch(PDOException $e){
			return $e->getMessage();

		}	
	}
	function delete_comments($school_detail_id)
	{
		global $conn;
		try{				
			$query = $conn->prepare("DELETE FROM comments WHERE school_details_id=".$school_detail_id);
			
			return $query->execute();

		}
		catch(PDOException $e){
			return $e->getMessage();

		}	
	}
	function insert_stage($school_detail_id,$previous_stage,$current_stage)
	{
		$username	=	get_username();
		global $conn;
		try{
			$query = $conn->prepare("INSERT INTO stages (school_detail_id,changed_by,current_stage,previous_stage,date_converted)
										VALUES (:school_detail_id,:changed_by,:current_stage,:previous_stage,:date_converted)");
			
			$query->bindParam(':school_detail_id', $school_detail_id,PDO::PARAM_INT);
			$query->bindParam(':changed_by', $username,PDO::PARAM_STR);
			$query->bindParam(':previous_stage', $previous_stage,PDO::PARAM_STR);
			$query->bindParam(':current_stage', $current_stage,PDO::PARAM_STR);
			$query->bindParam(':date_converted', date("Y-m-d"),PDO::PARAM_STR);
			

			
			return $query->execute();

		}
		catch(PDOException $e){
			return $e->getMessage();

		}
	}
	function get_stages()
	{
		global $conn;
		try{
			
			$query = $conn->prepare("SELECT s.previous_stage,s.current_stage,s.changed_by,sd.school_name,s.date_converted from stages s , school_details sd where s.school_detail_id=sd.id");			
			$query->execute();
			$rows=array();
			$parsed_row=array();
			while($row=$query->fetch(PDO::FETCH_ASSOC))
			{
				$parsed_row['changed_by'] = $row['changed_by'];
				$parsed_row['content']	=	$row['school_name']." was converted from ".$row['previous_stage']." to ".$row['current_stage']." on ".$row['date_converted'];
				$parsed_row['date_converted'] = $row['date_converted'];
				array_push($rows, $parsed_row);
			}
			$query = $conn->prepare("SELECT s.stage,s.changed_by,sd.school_name,s.date_converted from initial_stages s , school_details sd where s.school_detail_id=sd.id");			
			$query->execute();
			while($row=$query->fetch(PDO::FETCH_ASSOC))
			{
				$parsed_row['changed_by'] = $row['changed_by'];
				$parsed_row['content']	=	$row['school_name']." was initiated with ".$row['stage']." on ".$row['date_converted'];
				$parsed_row['date_converted'] = $row['date_converted'];
				array_push($rows, $parsed_row);
			}
			return $rows;

		}
		catch(PDOException $e){
			return $e->getMessage();

		}
	}
?>


