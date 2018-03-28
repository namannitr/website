<?php
session_start();
class admin extends Controller
{
  public function index(){

        //$query = $this->db->prepare("SELECT * FROM user WHERE c");
        //$query->execute();
        echo "apiiii";
        print_r($_SERVER);
  }
	public function log($txt,$query){   
  	if (!isset($_SESSION['admin_name'])) {
  			$name="";
  		} else {
  			$name=$_SESSION['admin_name'];
  		}	
	   	$sql ="INSERT INTO log(`txt`,`user`,`query`,`ip`) VALUES('".$txt."','".$name."' ,:query, '".$_SERVER['REMOTE_ADDR']."') ";
	    $log = $this->db->prepare($sql);
	    $log->execute(array(':query' => $query));	
	}
	public function checkSession(){
	    	if (!isset($_SESSION['admin'])) {
	    		 echo "login";
				die();
	    	} 
	}
  public function setSession($id){
    	$_SESSION['admin']=$id;
    	print_r($_SESSION);
  }
  public function logout(){
    $this->log("Logout Admin",$_SESSION['admin_name']);
		unset($_SESSION['admin']);
		unset($_SESSION['admin_name']);	
    echo "login";
  }
  public function login(){
				unset($_SESSION['admin']);
				unset($_SESSION['admin_name']);
		    	if (isset($_POST['username']) && isset($_POST['password']) ) { //check if all parameters are set
					  $sql= "SELECT  * FROM admins WHERE (username = '".$_POST['username']."' and password = '".$_POST['password']."') LIMIT 1";
				      $query = $this->db->prepare($sql);
				      $query->execute();
				      $row=$query->fetch(PDO::FETCH_ASSOC);
					  $num=$query->rowCount();
			          //print_r($num);
					if($num > 0){ ///if login success
						$_SESSION['admin']=$row['admin_id'];
						$_SESSION['admin_name']=$row['name'];
						$h="Location:  ".$_POST['link'];
						$this->log("Login Sucessful Admin",$_POST['username']);
						header($h);
					}else{//if error
						$h="Location:  ".$_POST['err'];
						$this->log("Login Failed",$_POST['username']." ".$_POST['password']);
					    header($h);
					}
		    } else echo "Please set all parameters";//if parameters are not set
	}
  public function nextlogin($password,$username){
				unset($_SESSION['admin']);
				unset($_SESSION['admin_name']);
		    	if (isset($username) && isset($password) ) { //check if all parameters are set
					  $sql= "SELECT  * FROM admins WHERE (username = '".$username."' and password = '".$password."') LIMIT 1";
				      $query = $this->db->prepare($sql);
				      $query->execute();
				      $row=$query->fetch(PDO::FETCH_ASSOC);
					  $num=$query->rowCount();
			          //print_r($num);
					if($num > 0){ ///if login success
						$_SESSION['admin']=$row['admin_id'];
						$_SESSION['admin_name']=$row['name'];
					
						//$this->log("Next_Login Sucessful Admin",$username);
					}else{//if error
						//$this->log("Next_Login Failed",$username.' '.$password);
					}
		    } else echo "Please set all parameters";//if parameters are not set
	}
  public function getUser($user_id){
        $this->checkSession();
        $sql = "SELECT * FROM users WHERE user_id = :user_id LIMIT 1";    
        $query = $this->db->prepare($sql);
        $parameters = array(':user_id' => $user_id);
        $query->execute($parameters);
        $output=$query->fetch(PDO::FETCH_ASSOC);
         $getGroupName = "SELECT group_id,name as g_name FROM groups where group_id ='".$output['group_id']."' "; 
            $getGroupNameQuery = $this->db->prepare($getGroupName);
            $getGroupNameQuery->execute();
            $gname=$getGroupNameQuery->fetch(PDO::FETCH_ASSOC);
            //print_r($gname);

        array_push($output, $gname['g_name']);
        header('Content-type: application/json');
        echo json_encode($output); //echo data json 
  }//get user by id

  public function getUsers($date_){
      $this->checkSession();
      $output=array();
      $sql = "SELECT * FROM users where active='True'  order by group_id  desc";
      $query = $this->db->prepare($sql);
      $query->execute();
        while ($row=$query->fetch(PDO::FETCH_ASSOC)) {
        			//get group name
        	      $getGroupName = "SELECT group_id,name as g_name FROM groups where group_id ='".$row['group_id']."' ";
			      $getGroupNameQuery = $this->db->prepare($getGroupName);
			      $getGroupNameQuery->execute();
			      $gname=$getGroupNameQuery->fetch(PDO::FETCH_ASSOC);
			      //get ftd name
        	      $getFtdNr = "SELECT `ftd`.user_id ,count(`ftd`.ftd_id) as ftdnr FROM ftd where `ftd`.user_id ='".$row['user_id']."' ";
			      $getFtdNrQuery = $this->db->prepare($getFtdNr);
			      $getFtdNrQuery->execute();
			      $ftdNr=$getFtdNrQuery->fetch(PDO::FETCH_ASSOC);
			      //int_r($row2);
			      //print_r($ftdNr);
			      $get=array();
			      $get['id']=$row['user_id'];
			      $get['name']=$row['first_name'].' '.$row['middle_name'].' '.$row['last_name'];
			      $get['reg_date']=$row['reg_date'];
			      $get['g_name']=$gname['g_name'];
         		  $get['ftd_total']=$ftdNr['ftdnr'];
              $get['active']=$row['active'];
         		  $a=$this->getOperatorSalary($row['user_id'],$date_);
         		  $get['salary']=$a;
    			  array_push($output, $get);
        }    
        header('Content-type: application/json');
        echo json_encode($output); //echo data json 
  }//getallusers active
    public function getInactiveUsers($date_){
      $this->checkSession();
      $output=array();
      $sql = "SELECT * FROM users where active='False'  order by user_id  desc";
      $query = $this->db->prepare($sql);
      $query->execute();
        while ($row=$query->fetch(PDO::FETCH_ASSOC)) {
              //get group name
                $getGroupName = "SELECT group_id,name as g_name FROM groups where group_id ='".$row['group_id']."' ";
            $getGroupNameQuery = $this->db->prepare($getGroupName);
            $getGroupNameQuery->execute();
            $gname=$getGroupNameQuery->fetch(PDO::FETCH_ASSOC);
            //get ftd name
                $getFtdNr = "SELECT `ftd`.user_id ,count(`ftd`.ftd_id) as ftdnr FROM ftd where `ftd`.user_id ='".$row['user_id']."' ";
            $getFtdNrQuery = $this->db->prepare($getFtdNr);
            $getFtdNrQuery->execute();
            $ftdNr=$getFtdNrQuery->fetch(PDO::FETCH_ASSOC);
            //int_r($row2);
            //print_r($ftdNr);
            $get=array();
            $get['id']=$row['user_id'];
            $get['name']=$row['first_name'].' '.$row['middle_name'].' '.$row['last_name'];
            $get['reg_date']=$row['reg_date'];
            $get['g_name']=$gname['g_name'];
            $get['active']=$row['active'];
              $get['ftd_total']=$ftdNr['ftdnr'];
              $a=$this->getOperatorSalary($row['user_id'],$date_);
              $get['salary']=$a;
            array_push($output, $get);
        }    
        header('Content-type: application/json');
        echo json_encode($output); //echo data json 
  }//getallusers inactive
  public function getUsersBySupervisor($date,$supervisor_id){
      $this->checkSession();

    	$getSupervisorSql = "SELECT * FROM supervisors WHERE supervisor_id= :supervisor_id LIMIT 1";
    	$getSupervisorQuery= $this->db->prepare($getSupervisorSql);
    	$getSupervisorQuery->execute(array(':supervisor_id'=> $supervisor_id));
    	$supervisor=$getSupervisorQuery->fetch(PDO::FETCH_ASSOC);

    	$getGroupSql = "SELECT * FROM groups WHERE supervisor_id= :supervisor_id LIMIT 1";
    	$getGroupQuery= $this->db->prepare($getGroupSql);
    	$getGroupQuery->execute(array(':supervisor_id'=> $supervisor['supervisor_id']));
    	$group=$getGroupQuery->fetch(PDO::FETCH_ASSOC);

      $output=array();
      $sql = "SELECT * FROM users where active='True' and group_id= '".$group['group_id']."' order by active asc";
      $query = $this->db->prepare($sql);
      $query->execute();
        while ($row=$query->fetch(PDO::FETCH_ASSOC)) {
        			//get group name
        	      $getGroupName = "SELECT group_id,name as g_name FROM groups where group_id ='".$row['group_id']."' ";
			      $getGroupNameQuery = $this->db->prepare($getGroupName);
			      $getGroupNameQuery->execute();
			      $gname=$getGroupNameQuery->fetch(PDO::FETCH_ASSOC);
			      //get ftd name
        	      $getFtdNr = "SELECT `ftd`.user_id,`ftd`.ftd_date FROM ftd where `ftd`.user_id ='".$row['user_id']."' and MONTH(`ftd`.ftd_date) = MONTH('$date') and YEAR(`ftd`.ftd_date) = YEAR('$date')  ";
			      $getFtdNrQuery = $this->db->prepare($getFtdNr);
			      $getFtdNrQuery->execute();
			      $ftdNr=$getFtdNrQuery->fetch(PDO::FETCH_ASSOC);
			      //int_r($row2);
			      //print_r($ftdNr);
			      $get=array();
			      $get['id']=$row['user_id'];
			      $get['name']=$row['first_name'].' '.$row['middle_name'].' '.$row['last_name'];
			      $get['reg_date']=$row['reg_date'];
			      $get['g_name']=$gname['g_name'];
            $get['active']=$row['active'];
         		 // $get['ftd_total']=$ftdNr['ftdnr'];
         		  $a=$this->getOperatorSalary($row['user_id'],$date);
         		  $get['salary']=$a;
         		  //print_r($get);
         		  
    			  array_push($output, $get);
        }
        
        header('Content-type: application/json');
        echo json_encode($output); //echo data json 
  }//get users by supervisor
  public function getOpSalary($user_id,$date){
  		$output=$this->getOperatorSalary($user_id,$date);
  		echo json_encode($output);
  }//get op salary
  public function getSupervisors($date){
     $this->checkSession();
      $output=array();
      $sql = "SELECT * FROM supervisors WHERE active='True' order by supervisor_id desc";
      $query = $this->db->prepare($sql);
      $query->execute();
        while ($row=$query->fetch(PDO::FETCH_ASSOC)) {
        	$get=array();
        	$get['supervisor_id']=$row['supervisor_id'];
        	$get['name']=$row['name'];
        	$get['reg_date']=$row['reg_date'];
          $get['active']=$row['active'];
        	//$get['username']=$row['username'];
        	//$get['password']=$row['password'];
        	$a=$this->getSupervisorSalary($row['supervisor_id'],$date);
        	$get['salary']=$a;
	
            array_push($output, $get);
        }
        header('Content-type: application/json');
        echo json_encode($output); //echo data json 
  }//getsupervisors active 
  public function getInactiveSupervisors($date){
     $this->checkSession();
      $output=array();
      $sql = "SELECT * FROM supervisors WHERE active='False' order by supervisor_id desc";
      $query = $this->db->prepare($sql);
      $query->execute();
        while ($row=$query->fetch(PDO::FETCH_ASSOC)) {
          $get=array();
          $get['supervisor_id']=$row['supervisor_id'];
          $get['name']=$row['name'];
          $get['reg_date']=$row['reg_date'];
          $get['active']=$row['active'];
          //$get['username']=$row['username'];
          //$get['password']=$row['password'];
          $a=$this->getSupervisorSalary($row['supervisor_id'],$date);
          $get['salary']=$a;
  
            array_push($output, $get);
        }
        header('Content-type: application/json');
        echo json_encode($output); //echo data json 
  }//getsupervisors inactive 
  public function getRetentions($date){
     $this->checkSession();
      $output=array();
      $sql = "SELECT * FROM retentions where active='True' order by retention_id desc";
      $query = $this->db->prepare($sql);
      $query->execute();
        while ($row=$query->fetch(PDO::FETCH_ASSOC)) {
        	$get=array();
        	$get['retention_id']=$row['retention_id'];
        	$get['name']=$row['name'];
        	$get['reg_date']=$row['reg_date'];
          $get['active']=$row['active'];
        	//$get['username']=$row['username'];
        	//$get['password']=$row['password'];
        	$a=$this->getRetentionSalary($row['retention_id'],$date);
        	$get['salary']=$a;
	
            array_push($output, $get);
        }

        header('Content-type: application/json');
        echo json_encode($output); //echo data json 
  }//get retentions active

  public function getInactiveRetentions($date){
     $this->checkSession();
      $output=array();
      $sql = "SELECT * FROM retentions where active='False' order by retention_id desc";
      $query = $this->db->prepare($sql);
      $query->execute();
        while ($row=$query->fetch(PDO::FETCH_ASSOC)) {
          $get=array();
          $get['retention_id']=$row['retention_id'];
          $get['name']=$row['name'];
          $get['reg_date']=$row['reg_date'];
          $get['active']=$row['active'];
          //$get['username']=$row['username'];
          //$get['password']=$row['password'];
          $a=$this->getRetentionSalary($row['retention_id'],$date);
          $get['salary']=$a;
  
            array_push($output, $get);
        }

        header('Content-type: application/json');
        echo json_encode($output); //echo data json 
  }//get retentions inactive

  public function jsonRetentionSalary($retention_id,$date){
     echo json_encode($this->getRetentionSalary($retention_id,$date));
  }
  public function getGroups(){
    	$this->checkSession();
      $output=array();
      $sql = "SELECT * FROM groups order by group_id desc";

      $query = $this->db->prepare($sql);
      $query->execute();
        while ($row=$query->fetch(PDO::FETCH_ASSOC)) {
    	        			//get supervisor name
    	      $getSupervisorName = "SELECT `supervisors`.supervisor_id,`supervisors`.name as supervisor,`groups`.supervisor_id  FROM supervisors,groups where `supervisors`.supervisor_id ='".$row['supervisor_id']."' ";
		      $getSupervisorNameQuery = $this->db->prepare($getSupervisorName);
		      $getSupervisorNameQuery->execute();
		      $supervisor=$getSupervisorNameQuery->fetch(PDO::FETCH_ASSOC);
		      $get=array();
		      $get['group_id']=$row['group_id'];
		      $get['name']=$row['name'];
		      $get['supervisor']=$supervisor['supervisor'];
		      $get['supervisor_id']=$row['supervisor_id'];
            array_push($output, $get);
        }
        header('Content-type: application/json');
        echo json_encode($output); //echo data json 
  }//getallusers by type
  public function getUsersByGroup($group_id){
    	$this->checkSession();
      $output=array();
      $sql = "SELECT * FROM users where group_id='$group_id' order by user_id desc";
      $query = $this->db->prepare($sql);
      $query->execute();
        while ($row=$query->fetch(PDO::FETCH_ASSOC)) {
        			//get group name
        	      $getGroupName = "SELECT group_id,name as g_name FROM groups where group_id ='".$row['user_id']."' ";
			      $getGroupNameQuery = $this->db->prepare($getGroupName);
			      $getGroupNameQuery->execute();
			      $gname=$getGroupNameQuery->fetch(PDO::FETCH_ASSOC);
			      //get ftd name
        	      $getFtdNr = "SELECT `ftd`.user_id ,count(`ftd`.ftd_id) as ftdnr FROM ftd where `ftd`.user_id ='".$row['user_id']."' ";
			      $getFtdNrQuery = $this->db->prepare($getFtdNr);
			      $getFtdNrQuery->execute();
			      $ftdNr=$getFtdNrQuery->fetch(PDO::FETCH_ASSOC);
			      //int_r($row2);
			      //print_r($ftdNr);
			      $get=array();
			      $get['id']=$row['user_id'];
			      $get['name']=$row['first_name'].' '.$row['middle_name'].' '.$row['last_name'];
			      $get['reg_date']=$row['reg_date'];
			      $get['g_name']=$gname['g_name'];
         		  $get['ftd_total']=$ftdNr['ftdnr'];
    			  array_push($output, $get);

        }
        header('Content-type: application/json');
        echo json_encode($output); //echo data json 
  }//getallusers by group
  public function getFtdByUser($user_id){
      $this->checkSession();
      $output=array();
      $sql = "SELECT * from ftd WHERE user_id = $user_id  order by ftd_id desc";
      $query = $this->db->prepare($sql); 
      $query->execute();
        while ($row=$query->fetch(PDO::FETCH_ASSOC)) {
            array_push($output, $row);
        }
       header('Content-type: application/json');
       echo json_encode($output); //echo data json 
  }//get ftd by user
  public function getFtdByDate($date){
      $this->checkSession();
      $output=array();
      $sql = "SELECT * from ftd WHERE  MONTH(`ftd`.ftd_date) = MONTH('$date') and YEAR(`ftd`.ftd_date) = YEAR('$date') order by ftd_id desc";
      $query = $this->db->prepare($sql); 
      $query->execute();
        while ($row=$query->fetch(PDO::FETCH_ASSOC)) {
        	$getLoad = "SELECT SUM(`load_amount`) as totalload FROM retention_load where `retention_load`.ftd_id='".$row['ftd_id']."' and MONTH(`retention_load`.`load_date`) =MONTH('$date') and YEAR(`retention_load`.`load_date`) =YEAR('$date')";
		      $loadQuery = $this->db->prepare($getLoad);
		      $loadQuery->execute();
		      $retentionLoadtest=$loadQuery->fetch(PDO::FETCH_ASSOC);
		      
		      array_push($row,array('load' =>$retentionLoadtest['totalload'] ));
        $sql2 = "SELECT * FROM users WHERE user_id = :user_id LIMIT 1";    
        $query2 = $this->db->prepare($sql2);
        $parameters2 = array(':user_id' => $row['user_id']);
        $query2->execute($parameters2);
        $user=$query2->fetch(PDO::FETCH_ASSOC);

          array_push($row,array('op_name'=>$user['first_name'].' '.$user['middle_name'].' '.$user['last_name'],'op_id'=>$user['user_id']));
            array_push($output, $row);
        }
       header('Content-type: application/json');
       echo json_encode($output); //echo data json 
  }//get ftd by date
  public function getAllFtd(){
      $this->checkSession();
      $output=array();
      $sql = "SELECT * from ftd order by ftd_id desc";
      $query = $this->db->prepare($sql); 
      $query->execute();
        while ($row=$query->fetch(PDO::FETCH_ASSOC)) {
          $getLoad = "SELECT SUM(`load_amount`) as totalload FROM retention_load where `retention_load`.ftd_id='".$row['ftd_id']."'";
          $loadQuery = $this->db->prepare($getLoad);
          $loadQuery->execute();
          $retentionLoadtest=$loadQuery->fetch(PDO::FETCH_ASSOC);
          
          array_push($row,array('load' =>$retentionLoadtest['totalload'] ));
        $sql2 = "SELECT * FROM users WHERE user_id = :user_id LIMIT 1";    
        $query2 = $this->db->prepare($sql2);
        $parameters2 = array(':user_id' => $row['user_id']);
        $query2->execute($parameters2);
        $user=$query2->fetch(PDO::FETCH_ASSOC);

          array_push($row,array('op_name'=>$user['first_name'].' '.$user['middle_name'].' '.$user['last_name'],'op_id'=>$user['user_id']));
            array_push($output, $row);
        }
       header('Content-type: application/json');
       echo json_encode($output); //echo data json 
  }//get ftd by date
    public function getUserWorkhours($user_id,$date){
      $this->checkSession();
      $output=array();
      $sql = "SELECT * FROM workhours WHERE user_id='$user_id' and MONTH(`date`) = MONTH('$date') and YEAR(`date`) = YEAR('$date')  order by `date` desc";
      $query = $this->db->prepare($sql);
      $query->execute();
        while ($row=$query->fetch(PDO::FETCH_ASSOC)) {
            array_push($output, $row);
        }
        header('Content-type: application/json');
        echo json_encode($output); //echo data json 
    }//user workhours
    public function getSupervisorWorkhours($supervisor_id,$date){
      $this->checkSession();
      $output=array();
      $sql = "SELECT * FROM workhours_supervisor WHERE supervisor_id='$supervisor_id' and MONTH(`date`) = MONTH('$date') and YEAR(`date`) = YEAR('$date')  order by `date` desc";
      $query = $this->db->prepare($sql);
      $query->execute();
        while ($row=$query->fetch(PDO::FETCH_ASSOC)) {
            array_push($output, $row);
        }
        header('Content-type: application/json');
        echo json_encode($output); //echo data json 
    }//supervisor workhours
    public function getRetentionWorkhours($retention_id,$date){
      $this->checkSession();
      $output=array();
      $sql = "SELECT * FROM workhours_retention WHERE retention_id='$retention_id' and MONTH(`date`) = MONTH('$date') and YEAR(`date`) = YEAR('$date')  order by `date` desc";
      $query = $this->db->prepare($sql);
      $query->execute();
        while ($row=$query->fetch(PDO::FETCH_ASSOC)) {
            array_push($output, $row);
        }
        header('Content-type: application/json');
        echo json_encode($output); //echo data json 
    }//supervisor workhours
  public function getFtdByUserAndDate($user_id,$date){
      $this->checkSession();
      $output=array();
      $sql = "SELECT * from ftd WHERE user_id = $user_id and MONTH(`ftd`.ftd_date) = MONTH('$date') and YEAR(`ftd`.ftd_date) = YEAR('$date')  order by user_id";
      $query = $this->db->prepare($sql); 
      $query->execute();
        while ($row=$query->fetch(PDO::FETCH_ASSOC)) {
        		            	   //print_r($output);
	          $getLoad = "SELECT SUM(`load_amount`) as totalload FROM retention_load where `retention_load`.ftd_id='".$row['ftd_id']."' and MONTH(`retention_load`.`load_date`) =MONTH('$date') and YEAR(`retention_load`.`load_date`) =YEAR('$date')";
		      $loadQuery = $this->db->prepare($getLoad);
		      $loadQuery->execute();
		      $retentionLoadtest=$loadQuery->fetch(PDO::FETCH_ASSOC);
		      
		      array_push($row,array('load' =>$retentionLoadtest['totalload'] ));
            array_push($output, $row);
        }
       header('Content-type: application/json');
       echo json_encode($output); //echo data json 
  }//get ftd by user and date
  public function getSupervisorSalary($supervisor_id,$date){
    	$this->checkSession();


        $onlyDateVar=new DateTime($date);
        $onlyDateVar=$onlyDateVar->format('Y-m');
        $onlyYearVar=new DateTime($date);
        $onlyYearVar=$onlyYearVar->format('Y');
        $onlyMonthVar=new DateTime($date);
        $onlyMonthVar=$onlyMonthVar->format('m');

				    $count = 0;
				    $counter = mktime(0, 0, 0, $onlyMonthVar, 1, $onlyYearVar);
				    while (date("n", $counter) == $onlyMonthVar) {
				        if (in_array(date("w", $counter), array(0, 6)) == false) {
				            $count++;
				        }
				        $counter = strtotime("+1 day", $counter);
				    }
				    $workingDays=$count;

	          $workhoursSql = "SELECT SUM(hours) as totalhours FROM workhours_supervisor where `workhours_supervisor`.supervisor_id='$supervisor_id' and MONTH(`workhours_supervisor`.`date`) =MONTH('$date') and YEAR(`workhours_supervisor`.`date`) =YEAR('$date')";
		      $workhoursQuery = $this->db->prepare($workhoursSql);
		      $workhoursQuery->execute();
		      $workhours=$workhoursQuery->fetch(PDO::FETCH_ASSOC);
			  $workhours=$workhours['totalhours'];
			  if (!$workhours) {
			  	$workhours=0;
			  }
			  $totalhoursV=$workingDays*8;
			 

    	$totalLoadtest=0;
    	$getSupervisorSql = "SELECT * FROM supervisors WHERE supervisor_id= :supervisor_id LIMIT 1";
    	$getSupervisorQuery= $this->db->prepare($getSupervisorSql);
    	$getSupervisorQuery->execute(array(':supervisor_id'=> $supervisor_id));
    	$supervisor=$getSupervisorQuery->fetch(PDO::FETCH_ASSOC);

    

    	$getGroupSql = "SELECT * FROM groups WHERE supervisor_id= :supervisor_id LIMIT 1";
    	$getGroupQuery= $this->db->prepare($getGroupSql);
    	$getGroupQuery->execute(array(':supervisor_id'=> $supervisor['supervisor_id']));
    	$group=$getGroupQuery->fetch(PDO::FETCH_ASSOC);

    	$getUsersSql = "SELECT * FROM users WHERE group_id= :group_id";
    	$getUsersQuery= $this->db->prepare($getUsersSql);
    	$getUsersQuery->execute(array(':group_id'=> $group['group_id']));
    	$users=array();
        while ( $rowusr=$getUsersQuery->fetch(PDO::FETCH_ASSOC)) {
        	array_push($users, $rowusr);
        }
        $ftds=array();

        foreach ($users as $key => $value) {

           	$getFtdsSql = "SELECT * FROM ftd WHERE user_id= :user_id  and MONTH(`ftd`.ftd_date) = MONTH('$date') and YEAR(`ftd`.ftd_date) = YEAR('$date')";
	    	$getFtdsQuery= $this->db->prepare($getFtdsSql);
	    	$getFtdsQuery->execute(array(':user_id'=> $value['user_id']));
	    	
	        while ($rowftd=$getFtdsQuery->fetch(PDO::FETCH_ASSOC)) {
	        $getLoad = "SELECT SUM(`load_amount`) as totalload FROM retention_load where `retention_load`.ftd_id='".$rowftd['ftd_id']."' and MONTH(`retention_load`.`load_date`) =MONTH('$date') and YEAR(`retention_load`.`load_date`) =YEAR('$date')";
		      $loadQuery = $this->db->prepare($getLoad);
		      $loadQuery->execute();
		      $retentionLoadtest=$loadQuery->fetch(PDO::FETCH_ASSOC);
		      $totalLoadtest+=$retentionLoadtest['totalload'];

	            array_push($ftds, $rowftd);
	        }
	    }


			    $base=700;
			    $loadBonus=0;
			   // $retention_load=0;
				$totalFtd=count($ftds);
				$ftdSum=0;

					foreach ($ftds as $key => $value) {
						//$retention_load+=$value['retention_load'];
						//print_r($value);
						$ftdSum+=$value['amount'];
					}

				if ($totalFtd>14) {
					$base=1200;

					$loadPlusFtd=$totalLoadtest+$ftdSum;
					if ($loadPlusFtd<100000) {
						$loadBonus=(0.7 / 100) * $loadPlusFtd;
					} elseif ($loadPlusFtd>100000 && $loadPlusFtd <200000) {
						$loadBonus=(1.3 / 100) * $loadPlusFtd;
					} elseif ($loadPlusFtd>200000) {
						$loadBonus=(1.7 / 100) * $loadPlusFtd;
					}

				}

				 $baseSalaryFinal=round(($base/$totalhoursV) * $workhours,3);

			$get=array();

			$get['name']=$supervisor['name'];
			$get['groupname']=$group['name'];
			$get['ftd']=$totalFtd;
			$get['workhours']=$workhours;
			$get['base_onhours']=$baseSalaryFinal;
			$get['base']=$base;
			$get['ftdamount']=$ftdSum;
			$get['loadbonus']=$loadBonus;
			$get['load']=$totalLoadtest;
			$get['total'] =$baseSalaryFinal+$loadBonus;

			return($get);
  }
  public function getRetentionSalary($retention_id,$date){
    	$this->checkSession();
    	$totalLoadtest=0;

    	  $onlyDateVar=new DateTime($date);
        $onlyDateVar=$onlyDateVar->format('Y-m');
        $onlyYearVar=new DateTime($date);
        $onlyYearVar=$onlyYearVar->format('Y');
        $onlyMonthVar=new DateTime($date);
        $onlyMonthVar=$onlyMonthVar->format('m');

				    $count = 0;
				    $counter = mktime(0, 0, 0, $onlyMonthVar, 1, $onlyYearVar);
				    while (date("n", $counter) == $onlyMonthVar) {
				        if (in_array(date("w", $counter), array(0, 6)) == false) {
				            $count++;
				        }
				        $counter = strtotime("+1 day", $counter);
				    }
				    $workingDays=$count;

	          $workhoursSql = "SELECT SUM(hours) as totalhours FROM workhours_retention where `workhours_retention`.retention_id='$retention_id' and MONTH(`workhours_retention`.`date`) =MONTH('$date') and YEAR(`workhours_retention`.`date`) =YEAR('$date')";
		      $workhoursQuery = $this->db->prepare($workhoursSql);
		      $workhoursQuery->execute();
		      $workhours=$workhoursQuery->fetch(PDO::FETCH_ASSOC);
			  $workhours=$workhours['totalhours'];
			  if (!$workhours) {
			  	$workhours=0;
			  }
			  $totalhoursV=$workingDays*8;


      
	        $getLoad = "SELECT SUM(`load_amount`) as totalload FROM retention_load where (`retention_load`.retention_id='".$retention_id."') and (MONTH(`retention_load`.`load_date`) =MONTH('$date') and YEAR(`retention_load`.`load_date`) =YEAR('$date') )";
		      $loadQuery = $this->db->prepare($getLoad);
		      $loadQuery->execute();
		      while ($retentionLoadtest=$loadQuery->fetch(PDO::FETCH_ASSOC)) {

		      	  $totalLoadtest=$retentionLoadtest['totalload'];
		      };


	//print_r($totalLoadtest);
          $getRegDateSql="SELECT reg_date from retentions WHERE retention_id = $retention_id";
          $getRegDateQuery=$this->db->prepare($getRegDateSql);
          $getRegDateQuery->execute();
          $getRegDateQuery=$getRegDateQuery->fetch(PDO::FETCH_ASSOC);
          $regDate=$getRegDateQuery['reg_date'];


        $regDateVar=new DateTime($regDate);
        $regDateVar=$regDateVar->format('Y-m');

        $dateCtr=new DateTime($regDateVar); 
        $operatorRegDate=$dateCtr->format('Y-m');   //operator reg date
        $dateCtr->modify('+1 month');
        $oepratorRegDatePlusOne=$dateCtr->format('Y-m'); // operator reg date + 1 month



         $oepratorRegDatePlusOneV=$oepratorRegDatePlusOne.'-01';
         $regDateV=$regDateVar.'-01';

          $firstMonthsLoadSql="SELECT SUM(`load_amount`) as totalload FROM retention_load where (`retention_load`.retention_id='$retention_id') and ( (MONTH(`retention_load`.`load_date`) =MONTH('$regDateV') and YEAR(`retention_load`.`load_date`) =YEAR('$regDateV') ) or ( MONTH(`retention_load`.`load_date`) =MONTH('$oepratorRegDatePlusOneV') and YEAR(`retention_load`.`load_date`) =YEAR('$oepratorRegDatePlusOneV')) )";
          $firstMonthsLoad=$this->db->prepare($firstMonthsLoadSql);
          $firstMonthsLoad->execute();
          $firstMonthsLoad=$firstMonthsLoad->fetch(PDO::FETCH_ASSOC);


			$base=500;
			$bonus=0;



      switch ($totalLoadtest) {
          case ($totalLoadtest<30000):
             $bonus=(2/100)*$totalLoadtest;;
            break;
          case ($totalLoadtest>=30000 && $totalLoadtest<40000):
            $bonus=(3/100)*$totalLoadtest;
            break;
          case ($totalLoadtest>=40000 && $totalLoadtest<80000):
            $bonus=(4/100)*$totalLoadtest;
            break;
          case ($totalLoadtest>=80000 && $totalLoadtest<120000):
            $bonus=(5/100)*$totalLoadtest;
            break;
          case ($totalLoadtest>=120000 && $totalLoadtest<160000):
            $bonus=(6/100)*$totalLoadtest;
            break;
          case ($totalLoadtest>160000):
              if ($firstMonthsLoad >=40000) {
                 $bonus=(7/100)*$totalLoadtest;
               } else {
                  $bonus=(6/100)*$totalLoadtest;
               }

            break;
        default:
          # code...
          break;
      }

    
			 $baseSalaryFinal=round(($base/$totalhoursV) * $workhours,3);

			$get=array();
			$get['base']=$base;
			$get['totalLoad']=$totalLoadtest;
			$get['workhours']=$workhours;
			$get['base_onhours']=$baseSalaryFinal;
			$get['loadbonus']=$bonus;
			$get['total']=$baseSalaryFinal+$bonus;
			//print_r($get);

			return($get);
  }
  public function getOperatorSalary($user_id,$date){
      $this->checkSession();

	  $settingsSql = "SELECT * from default_settings";
      $settingsQuery = $this->db->prepare($settingsSql);
      $settingsQuery->execute();
      $settings=$settingsQuery->fetch(PDO::FETCH_ASSOC);
      //print_r($settings);

        $sql = "SELECT * FROM users WHERE user_id = :user_id LIMIT 1";    
        $query = $this->db->prepare($sql);
        $parameters = array(':user_id' => $user_id);
        $query->execute($parameters);
        $regDate=$query->fetch(PDO::FETCH_ASSOC);
        $dateCtr=new DateTime($regDate['reg_date']); 
        $operatorRegDate=$dateCtr->format('Y-m');   //operator reg date
        $dateCtr->modify('+1 month');
        $oepratorRegDatePlusOne=$dateCtr->format('Y-m'); // operator reg date + 2 month
        $todayDate=date('Y-m',time());              //today date
        $onlyDateVar=new DateTime($date);
        $onlyDateVar=$onlyDateVar->format('Y-m');
        $onlyYearVar=new DateTime($date);
        $onlyYearVar=$onlyYearVar->format('Y');
        $onlyMonthVar=new DateTime($date);
        $onlyMonthVar=$onlyMonthVar->format('m');

				    $count = 0;
				    $counter = mktime(0, 0, 0, $onlyMonthVar, 1, $onlyYearVar);
				    while (date("n", $counter) == $onlyMonthVar) {
				        if (in_array(date("w", $counter), array(0, 6)) == false) {
				            $count++;
				        }
				        $counter = strtotime("+1 day", $counter);
				    }
				    $workingDays=$count;

	          $workhoursSql = "SELECT SUM(hours) as totalhours FROM workhours where `workhours`.user_id='$user_id' and MONTH(`workhours`.`date`) =MONTH('$date') and YEAR(`workhours`.`date`) =YEAR('$date')";
		      $workhoursQuery = $this->db->prepare($workhoursSql);
		      $workhoursQuery->execute();
		      $workhours=$workhoursQuery->fetch(PDO::FETCH_ASSOC);
			  $workhours=$workhours['totalhours'];
			  if (!$workhours) {
			  	$workhours=0;
			  }
			  $totalhoursV=$workingDays*8;
			  //$baseSalaryFinal=round(($baseSalary/$totalhoursV) * $workhours,3);

      	$baseSalary=250;
     	$ftdBouns=0;
    	$plusEu=0;
      	$retentionBonus=0;
        	//$oneDaySalary=$baseSalary/30;
	
         	$getallloadsql = "SELECT ftd_date, DATE(  `ftd_date` ) AS  'date', COUNT(  `ftd_id` ) AS  'total'
								FROM  `ftd` 
								WHERE  `user_id` ='".$user_id."'
								GROUP BY DATE(  `ftd_date` ) 
								LIMIT 0 , 30";

		    $getallloadquery = $this->db->prepare($getallloadsql);
		    $getallloadquery->execute();
		    $getallload=$getallloadquery->fetchAll();
			
		   	$rload=0;
		    foreach ($getallload as $key => $value) {
		    	$in=array();
		    	//print_r($value->total);
		    	if ($value->total>=3) {

		    	$sql="SELECT * FROM ftd WHERE MONTH(ftd_date)=MONTH('$value->ftd_date') and user_id ='$user_id' ";

			      $getftd1 = $this->db->prepare($sql);
			      $getftd1->execute();

			     while ($ftd_id=$getftd1->fetch(PDO::FETCH_ASSOC)) {
			    // echo $ftd_id['ftd_id']."-";

				  $getLoad1 = "SELECT SUM(`load_amount`) as totalload FROM retention_load where `retention_load`.ftd_id='".$ftd_id['ftd_id']."' and MONTH(`retention_load`.`load_date`) =MONTH('$date') and YEAR(`retention_load`.`load_date`) =YEAR('$date')";
			      $loadQuery1 = $this->db->prepare($getLoad1);
			      $loadQuery1->execute();
			      $loadarr=$loadQuery1->fetch(PDO::FETCH_ASSOC);
			      $rload+=$loadarr['totalload'];
			     //print_r($loadarr);			      
			     }

		    	}

		    }

//print_r("check: ".$rload);



	      $output=array();
	      $selectedMonthSql = "SELECT *,`users`.user_id,`users`.reg_date FROM ftd,users where `ftd`.user_id=`users`.user_id  and `users`.user_id='$user_id' and MONTH(`ftd`.ftd_date) = MONTH('$date') and YEAR(`ftd`.ftd_date) = YEAR('$date')";
	      $selectedMonthQuery = $this->db->prepare($selectedMonthSql);
	      $selectedMonthQuery->execute();
	      $ftdThisMonth=0;
	      $totalLoad=0;
	      //$totalLoadtest=0;
	        while ($row=$selectedMonthQuery->fetch(PDO::FETCH_ASSOC)) {
	     
	             $ftdThisMonth++;

	          $getLoad = "SELECT SUM(`load_amount`) as totalload FROM retention_load where `retention_load`.ftd_id='".$row['ftd_id']."' and MONTH(`retention_load`.`load_date`) =MONTH('$date') and YEAR(`retention_load`.`load_date`) =YEAR('$date')";
		      $loadQuery = $this->db->prepare($getLoad);
		      $loadQuery->execute();
		      $retentionLoadtest=$loadQuery->fetch(PDO::FETCH_ASSOC);
		      $totalLoad+=$retentionLoadtest['totalload'];
	 
	
 			 array_push($output, $row);


	        } 

	       // print_r($rload);

//print_r("no check: ".$totalLoad);

$totalLoad=$rload;

	        if (!isset($ftdThisMonth)) {
	        	$ftdThisMonth=0;
	        }

	        if ($ftdThisMonth==0) {
	        	$baseSalary=$settings['zero_ftd'];
	        }elseif ($ftdThisMonth==1) {
	        		    if($onlyDateVar !=$operatorRegDate && $onlyDateVar !=$oepratorRegDatePlusOne ){ //if not first 2 month
	        				$baseSalary=$settings['one_ftd'];//print_r($baseSalary);
	       				 } else{
	       				 	$baseSalary=$settings['firstmonths_one_ftd'] ;//print_r($baseSalary);
	       				 }
	        	if ($output[0]['amount']>=500 && $output[0]['amount']<1000) {//check ftd amount
	        		$ftdBouns=($settings['500bonus'] / 100) * $output[0]['amount'];//ftd bounus 5%
	        	} elseif ($output[0]['amount']>=1000) {
				      	$ftdBouns=($settings['1000bonus']/ 100) * $output[0]['amount'];//ftd bounus 10%
		        	}

	        } elseif ($ftdThisMonth==2) {
	        	$baseSalary=$settings['two_ftd'];
	        	for ($i=0; $i <$ftdThisMonth ; $i++) { 
		        	if ($output[$i]['amount']>=500 && $output[$i]['amount']<1000) {//check ftd amount
		        		$ftdBouns+=($settings['500bonus'] / 100) * $output[$i]['amount'];//ftd bounus 5%
		        	} elseif ($output[$i]['amount']>=1000) {
						    $ftdBouns+=($settings['1000bonus'] / 100) * $output[$i]['amount'];//ftd bounus 10%
		        	}
	        	}

	        } elseif ($ftdThisMonth>2) {
	        	$baseSalary=$settings['two_ftd'];	 
	        	for ($i=0; $i <$ftdThisMonth ; $i++) { 
		        	if ($output[$i]['amount']>=500 && $output[$i]['amount']<1000) {//check ftd amount
		        		$ftdBouns+=($settings['500bonus']  / 100) * $output[$i]['amount'];//ftd bounus 5%
		        	} elseif ($output[$i]['amount']>=1000) {
						    $ftdBouns+=($settings['1000bonus']  / 100) * $output[$i]['amount'];//ftd bounus 10%
		        	}
	        	}

	        } 


	        $plusEu=$ftdThisMonth*$ftdThisMonth*10;
	        if ($ftdThisMonth>8) {
	        	$plusEu=8*8*10;
	        }

	       // $totalLoad=$rload;
	       // print_r($rload);
	       // if ($ftdThisMonth>=3) {//total load this month
	
	        			if ($totalLoad>5000 && $totalLoad <50000) { //if less then 50k and more than 5k bonus=1%
		        				$retentionBonus+=($settings['load_level1'] / 100) * $totalLoad;//bounus 1%
		        		} elseif ($totalLoad>=50000 && $totalLoad<100000) {  //if more then 50k and less then 100k bonus=1.5%
		        				$retentionBonus+=($settings['load_level2'] / 100) * $totalLoad;//bounus 1.5%
		        		} elseif ($totalLoad>=100000) {  //if more then 100k bouns 2%
		        				$retentionBonus+=($settings['load_level3']  / 100) * $totalLoad;//bounus 2%
		        		}
		        	
	       // }

		    // print_r($retentionBonus);

			$baseSalaryFinal=round(($baseSalary/$totalhoursV) * $workhours,3);
				//print_r($baseSalaryFinal);
			$totalSalary=$baseSalaryFinal+$ftdBouns+$plusEu+$retentionBonus;


	        $get=array();
	        $get['base_c']=$baseSalary;
	        $get['ftdbonus_c']=$ftdBouns;
	        $get['workhours_c']=$workhours;
	        $get['basesalaryfinal_c']=$baseSalaryFinal;
	        $get['pluseu_c']=$plusEu;
	        $get['ftdthismonth_c']=$ftdThisMonth;
		      $get['retention_load_c']= $totalLoad;//$totalLoad;
	        $get['retention_bonus_c']=$retentionBonus;
	        $get['total_c']=$totalSalary;


		        return($get);
		



     }//get salary
     
/////////////////////////////////////////////////////////////////
//                             SETs                            //
////////////////////////////////////////////////////////////////
	public function addHours($user_id,$hours,$date){
	    $this->checkSession();
		$date=$date." ".date('H:i:s');
    	$sql = "INSERT INTO workhours(user_id,hours,date) VALUES($user_id,$hours,'$date')";
	    $addHours = $this->db->prepare($sql);
	    $addHours->execute();
	    $this->log('Add Hours ',$sql);	
	   // echo "success";
  }
	public function addHoursSupervisor($supervisor_id,$hours,$date){
	    $this->checkSession();
		$date=$date." ".date('H:i:s');
    	$sql = "INSERT INTO workhours_supervisor(supervisor_id,hours,date) VALUES($supervisor_id,$hours,'$date')";
	    $addHours = $this->db->prepare($sql);
	    $addHours->execute();
	    $this->log('Add Hours to Supervisor ',$sql);	
  }
	public function addHoursRetention($retention_id,$hours,$date){
	    $this->checkSession();
		$date=$date." ".date('H:i:s');
    	$sql = "INSERT INTO workhours_retention(retention_id,hours,date) VALUES($retention_id,$hours,'$date')";
	    $addHours = $this->db->prepare($sql);
	    $addHours->execute();
	    $this->log('Add Hours to Retention ',$sql);	
  }  
  public function addLoad($ftd_id,$retention_id,$amount,$date){
      $this->checkSession();
      $date=$date." ".date('H:i:s');
      $sql ="INSERT INTO retention_load(ftd_id,load_amount,retention_id,load_date) VALUES($ftd_id,$amount,$retention_id,'$date')";
      $addFtd = $this->db->prepare($sql);
      $addFtd->execute(); 
      $this->log('Add Load ',$sql);
  }
    public function addFtd(){
      $this->checkSession();

      $qq ="SELECT COUNT(client_id) as cc from ftd where client_id='".$_POST['client_id']."'";
      $vv = $this->db->prepare($qq);
      $vv->execute(); 
      $cc=$vv->fetch(PDO::FETCH_ASSOC);
      if ($cc['cc']>0) {
        $this->log('Add FTD  Admin Failed (client_id exist) ',$_POST['client_id']);
        echo 'ftd_exist';
      }else{

        $date=$_POST['date']." ".date('H:i:s');
        $sql ="INSERT INTO ftd(user_id,ftd_date,client_id,client_name,client_email,amount,note) VALUES('".$_POST['user_id']."','".$date."','".$_POST['client_id']."','".$_POST['client_name']."','".$_POST['client_email']."','".$_POST['ftd_amount']."','".$_POST['note']."')";
        $addFtd = $this->db->prepare($sql);
        $addFtd->execute(); 
        $this->log('Add FTD Admin',$sql);
        echo json_encode(array('success' =>true));
      }

  }
  public function editFtd(){
    	$this->checkSession();
    	$date=$_POST['date']." ".date('H:i:s');
	   	$sql="UPDATE ftd  SET user_id='".$_POST['user_id']."', ftd_date='".$date."',client_id='".$_POST['client_id']."',client_name='".$_POST['client_name']."',client_email='".$_POST['client_email']."',amount='".$_POST['ftd_amount']."',retention_id='".$_POST['retention_id']."',note='".$_POST['note']."'  WHERE ftd_id ='".$_POST['ftd_id']."' ";
    	$editFtd = $this->db->prepare($sql);
	    $editFtd->execute();	
	    $this->log('Edit FTD ',$sql);
  }
  public function deleteFtd($ftd_id){
    	$this->checkSession();
    	$sql="DELETE FROM ftd WHERE ftd_id = $ftd_id";
    	$deleteFtd=$this->db->prepare($sql);
    	$deleteFtd->execute();
    	$this->log("Delete FTD",$sql);
  }
  public function createOperator(){
    	$this->checkSession();
    	$sql="INSERT INTO users(first_name,middle_name,last_name,email,group_id) VALUES ('".$_POST['first_name']."','".$_POST['middle_name']."','".$_POST['last_name']."','".$_POST['email']."','".$_POST['group_id']."')";
    	$createOperator=$this->db->prepare($sql);
    	$createOperator->execute();
    	$this->log("Create Operator",$sql);
  }
  public function editOperator(){
      $this->checkSession();
      $sql="UPDATE users SET first_name='".$_POST['first_name']."',last_name='".$_POST['last_name']."',middle_name='".$_POST['middle_name']."',group_id='".$_POST['group_id']."',email='".$_POST['email']."',active='".$_POST['active']."' WHERE user_id='".$_POST['user_id']."' ";
      $createOperator=$this->db->prepare($sql);
      $createOperator->execute();
      $this->log("Edit Operator",$sql);
  }
  public function createSupervisor(){
    	$this->checkSession();
    	$sql="INSERT INTO supervisors(name,username,password,email) VALUES ('".$_POST['name']."','".$_POST['username']."','".$_POST['password']."','".$_POST['email']."')";
    	$createSupervisor=$this->db->prepare($sql);
    	$createSupervisor->execute();
    	$this->log("Create Supervisor",$sql);
  }
  public function createRetention(){
      $this->checkSession();
      $sql="INSERT INTO retentions(name,username,password,email) VALUES ('".$_POST['name']."','".$_POST['username']."','".$_POST['password']."','".$_POST['email']."')";
      $createSupervisor=$this->db->prepare($sql);
      $createSupervisor->execute();
      $this->log("Create Retention",$sql);
  }
  public function editGroup(){
    	$this->checkSession();
    	$sql="UPDATE groups SET name='".$_POST['name']."' , supervisor_id='".$_POST['supervisor_id']."' WHERE group_id ='".$_POST['group_id']."' ";
    	$editGroup=$this->db->prepare($sql);
    	$editGroup->execute();
    	$this->log("Edit Group",$sql);
  }
  public function createGroup(){
      $this->checkSession();
      $sql="INSERT INTO groups(name,supervisor_id) VALUES('".$_POST['name']."','".$_POST['supervisor_id']."')";
      $createGroup=$this->db->prepare($sql);
      $createGroup->execute();
      $this->log("Create Group",$sql);
  }
  public function deleteGroup($group_id){
      $this->checkSession();
      $sql="DELETE FROM groups WHERE group_id=$group_id";
      $deleteGroup=$this->db->prepare($sql);
      $deleteGroup->execute();
      $this->log("Delete Group",$sql);
  }
  public function deleteHours($workhours_id){
        $this->checkSession();
        $sql = "DELETE FROM workhours WHERE workhours_id='$workhours_id'";
        $addHours = $this->db->prepare($sql);
        $addHours->execute(); 
       $this->log('Delete Hours ',$sql);

    }
  public function deleteSupervisorHours($workhours_id){
        $this->checkSession();
        $sql = "DELETE FROM workhours_supervisor WHERE workhours_id='$workhours_id'";
        $addHours = $this->db->prepare($sql);
        $addHours->execute(); 
       $this->log('Delete Supervisor Hours',$sql);

    }
  public function deleteRetentionHours($workhours_id){
        $this->checkSession();
        $sql = "DELETE FROM workhours_retention WHERE workhours_id='$workhours_id'";
        $addHours = $this->db->prepare($sql);
        $addHours->execute(); 
       $this->log('Delete Retention Hours',$sql);

    }
}

?>
