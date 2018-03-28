<?php
session_start();
class supervisor extends Controller
{
    public function index(){

        //$query = $this->db->prepare("SELECT * FROM user WHERE c");
        //$query->execute();
        echo "apiiii";

    }
	public function log($txt,$query){   
  	if (!isset($_SESSION['supervisor_name'])) {
  			$name="";
  		} else {
  			$name=$_SESSION['supervisor_name'];
  		}	
	   	$sql ="INSERT INTO log(`txt`,`user`,`query`,`ip`) VALUES('".$txt."','".$name."' ,:query, '".$_SERVER['REMOTE_ADDR']."') ";
	    $log = $this->db->prepare($sql);
	    $log->execute(array(':query' => $query));	
	}
	public function checkSession(){
	    	if (!isset($_SESSION['supervisor'])) {
	    		echo "login";
				die();
	    	} 
	}
    public function setSession($id){
    	$_SESSION['supervisor']=$id;
    	print_r($_SESSION);
    }
    public function logout(){
		unset($_SESSION['supervisor']);
		unset($_SESSION['supervisor_name']);	
		echo "login";
    }
	public function login(){
				unset($_SESSION['supervisor']);
				unset($_SESSION['supervisor_name']);
		    	if (isset($_POST['username']) && isset($_POST['password']) ) { //check if all parameters are set
					  $sql= "SELECT  * FROM supervisors WHERE (username = '".$_POST['username']."' and password = '".$_POST['password']."') LIMIT 1";
				      $query = $this->db->prepare($sql);
				      $query->execute();
				      $row=$query->fetch(PDO::FETCH_ASSOC);
       				  //print_r($row);
					  $num=$query->rowCount();
			         // print_r($num);
					if($num > 0){ ///if login success
						$_SESSION['supervisor']=$row['supervisor_id'];
						$_SESSION['supervisor_name']=$row['name'];
						$h="Location:  ".$_POST['link'];
						$this->log("Login Sucessful Supervisor",$_POST['username']);
						header($h);
					}else{//if error
						$h="Location:  ".$_POST['err'];
						$this->log("Login Failed Supervisor",$_POST['username']." ".$_POST['password']);
					    header($h);
					}
		    } else echo "Please set all parameters";//if parameters are not set
	}
  public function nextlogin($password,$username){
        unset($_SESSION['admin']);
        unset($_SESSION['admin_name']);
          if (isset($username) && isset($password) ) { //check if all parameters are set
            $sql= "SELECT  * FROM supervisors WHERE (username = '".$username."' and password = '".$password."') LIMIT 1";
              $query = $this->db->prepare($sql);
              $query->execute();
              $row=$query->fetch(PDO::FETCH_ASSOC);
            $num=$query->rowCount();
                //print_r($num);
          if($num > 0){ ///if login success
            $_SESSION['admin']=$row['admin_id'];
            $_SESSION['admin_name']=$row['name'];
          
            //$this->log("Next_Login Sucessful Supervisor",$username);
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
        header('Content-type: application/json');
        echo json_encode($output); //echo data json 
    }//get user by id
  public function getSupervisors($date){
     $this->checkSession();
      $output=array();
      $sql = "SELECT * FROM supervisors order by supervisor_id desc";
      $query = $this->db->prepare($sql);
      $query->execute();
        while ($row=$query->fetch(PDO::FETCH_ASSOC)) {
        	$get=array();
        	$get['supervisor_id']=$row['supervisor_id'];
        	$get['name']=$row['name'];
        	$get['reg_date']=$row['reg_date'];
        	//$get['username']=$row['username'];
        	//$get['password']=$row['password'];
        	//$a=$this->getSupervisorSalary($row['supervisor_id'],$date);
        	//$get['salary']=$a;
	
            array_push($output, $get);
        }


        header('Content-type: application/json');
        echo json_encode($output); //echo data json 
  }//getsupervisors
  public function getRetentions($date){
     $this->checkSession();
      $output=array();
      $sql = "SELECT * FROM retentions order by retention_id desc";
      $query = $this->db->prepare($sql);
      $query->execute();
        while ($row=$query->fetch(PDO::FETCH_ASSOC)) {
        	$get=array();
        	$get['retention_id']=$row['retention_id'];
        	$get['name']=$row['name'];
        	$get['reg_date']=$row['reg_date'];
        	//$get['username']=$row['username'];
        	//$get['password']=$row['password'];
        	//$a=$this->getRetentionSalary($row['retention_id'],$date);
        	//$get['salary']=$a;
	
            array_push($output, $get);
        }

        header('Content-type: application/json');
        echo json_encode($output); //echo data json 
  }//get retentions 
  public function getUsers($date_){
      $this->checkSession();
      $output=array();
       $getGroupSql = "SELECT * FROM groups WHERE supervisor_id= :supervisor_id LIMIT 1";
    	$getGroupQuery= $this->db->prepare($getGroupSql);
    	$getGroupQuery->execute(array(':supervisor_id'=> $_SESSION['supervisor']));
    	$group=$getGroupQuery->fetch(PDO::FETCH_ASSOC);
      $sql = "SELECT * FROM users where active='True' and group_id='".$group['group_id']."' order by user_id desc";
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
         		  $a=$this->getOperatorSalary($row['user_id'],$date_);
         		  $get['salary']=$a;
    			  array_push($output, $get);
        }    
        header('Content-type: application/json');
        echo json_encode($output); //echo data json 
  }//getallusers



  	public function getOpSalary($user_id,$date){
  		$output=$this->getOperatorSalary($user_id,$date);
//print_r($output);
  		echo json_encode($output);
  	}




    public function getUsersByType($type){
    	$this->checkSession();
      $output=array();
      $sql = "SELECT * FROM users where account_type='$type' order by user_id desc";
      $query = $this->db->prepare($sql);
      $query->execute();
        while ($row=$query->fetch(PDO::FETCH_ASSOC)) {
            array_push($output, $row);
        }
        header('Content-type: application/json');
        echo json_encode($output); //echo data json 
    }//getallusers by type

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
    }//getallusers by type


    public function getFtdByUser($user_id){
        $this->checkSession();
      $output=array();
      $sql = "SELECT * from ftd WHERE user_id = $user_id ";
      $query = $this->db->prepare($sql); 
      $query->execute();
        while ($row=$query->fetch(PDO::FETCH_ASSOC)) {
            array_push($output, $row);
        }
       header('Content-type: application/json');
       echo json_encode($output); //echo data json 
    }//getallusers

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

  public function getMeSupervisor(){
    $this->checkSession();
    $getme = "SELECT supervisor_id,name FROM supervisors WHERE supervisor_id = '".$_SESSION['supervisor']."' ";
    $getmeq = $this->db->prepare($getme);
    $getmeq->execute();
    $me=$getmeq->fetch(PDO::FETCH_ASSOC);

    echo json_encode($me); 
  }
	public function addHours($user_id,$hours,$date){
		    $this->checkSession();
			$date=$date." ".date('H:i:s');
	    	$sql = "INSERT INTO workhours(user_id,hours,date) VALUES($user_id,$hours,'$date')";
		    $addHours = $this->db->prepare($sql);
		    $addHours->execute();	
		   $this->log('Add Hours Supervisor',$sql);

    }
  public function deleteHours($workhours_id){
        $this->checkSession();
        $sql = "DELETE FROM workhours WHERE workhours_id='$workhours_id'";
        $addHours = $this->db->prepare($sql);
        $addHours->execute(); 
       $this->log('Delete Hours Supervisor',$sql);

    }
  public function addFtd(){
    	$this->checkSession();

      $qq ="SELECT COUNT(client_id) as cc from ftd where client_id='".$_POST['client_id']."'";
      $vv = $this->db->prepare($qq);
      $vv->execute(); 
      $cc=$vv->fetch(PDO::FETCH_ASSOC);
      if ($cc['cc']>0) {
        $this->log('Add FTD  Supervisor Failed (client_id exist) ',$_POST['client_id']);
        echo 'ftd_exist';
      }else{

        $date=$_POST['date']." ".date('H:i:s');
        $sql ="INSERT INTO ftd(user_id,ftd_date,client_id,client_name,client_email,amount,note) VALUES('".$_POST['user_id']."','".$date."','".$_POST['client_id']."','".$_POST['client_name']."','".$_POST['client_email']."','".$_POST['ftd_amount']."','".$_POST['note']."')";
        $addFtd = $this->db->prepare($sql);
        $addFtd->execute(); 
        $this->log('Add FTD Supervisor',$sql);
        echo json_encode(array('success' =>true));
      }

  }
  public function editFtd(){
    	$this->checkSession();
    	$date=$_POST['date']." ".date('H:i:s');
	   	$sql="UPDATE ftd  SET user_id='".$_POST['user_id']."', ftd_date='".$date."',client_id='".$_POST['client_id']."',client_name='".$_POST['client_name']."',client_email='".$_POST['client_email']."',amount='".$_POST['ftd_amount']."',retention_id='".$_POST['retention_id']."',note='".$_POST['note']."'  WHERE ftd_id ='".$_POST['ftd_id']."' ";
    	$editFtd = $this->db->prepare($sql);
	    $editFtd->execute();	
	    $this->log('Edit FTD Supervisor',$sql);
  }
  public function addHoursSupervisor($supervisor_id,$hours,$date){
      $this->checkSession();
    $date=$date." ".date('H:i:s');
      $sql = "INSERT INTO workhours_supervisor(supervisor_id,hours,date) VALUES($supervisor_id,$hours,'$date')";
      $addHours = $this->db->prepare($sql);
      $addHours->execute();
      $this->log('Add Hours to Supervisor ',$sql);  
  }

}



?>
 