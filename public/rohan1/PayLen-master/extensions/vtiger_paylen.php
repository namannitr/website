	<?php

//////////////////////////////////////////////////////////////////////////

// Adalen VLADI             Vtiger to Paylen on Deposit

// vtigercrm/modules/Vtiger/actions/SaveAjax.php   <- location 

///////////////////////////////////////////////////////////////////////////

		public function addToPaylen(){
			$lead_id=$_POST['record'];
			$status=$_POST['value'];
			$field=$_POST['field'];

			if ($field=='leadstatus' && $status='Deposit') {
				
				$vcon=mysqli_connect("localhost","vtiger","vtiger2016","vtiger");//vtiger
				$pcon=mysqli_connect("192.168.1.222","root","admini","paylen");//paylen

				$udataResult=mysqli_query($vcon, "SELECT * FROM vtiger_leaddetails WHERE leadid= '$lead_id' ");
				$udata = $udataResult->fetch_assoc();
			//	print_r($udata);

				$phoneResult=mysqli_query($vcon, "SELECT * FROM vtiger_leadaddress  WHERE leadaddressid= '$lead_id' ");
				$phone = $phoneResult->fetch_assoc();
				
			
				$owner=mysqli_query($vcon, "SELECT smownerid FROM vtiger_crmentity  WHERE crmid= '$lead_id' ");
				$owner = $owner->fetch_assoc();
				$ownerid=$owner['smownerid'];

				$ownerUsernameResult=mysqli_query($vcon, "SELECT user_name FROM vtiger_users WHERE id= '$ownerid' ");
				$user_name = $ownerUsernameResult->fetch_assoc();
				

				$ftdAmountResult=mysqli_query($vcon, "SELECT cf_784 FROM  vtiger_leadscf  WHERE leadid= '$lead_id'  ");
				$ftdAmount = $ftdAmountResult->fetch_assoc();
				
				$now = new DateTime();
				$now=$now->format('Y-m-d H:i:s'); 

				$ftdAmount=$ftdAmount['cf_784'];
				$phone=$phone['phone'];
				$user_name=$user_name['user_name'];
				$email=$udata['email'];
				$name=$udata['firstname']." ".$udata['lastname'];

				//get operator id FROM login $user_name;
				$getOpResult=mysqli_query($pcon,"SELECT user_id FROM users WHERE username='$user_name' ");
				$getOpId=$getOpResult->fetch_assoc();
				$operator=$getOpId['user_id'];


				$checIfExistResult=mysqli_query($pcon,"SELECT COUNT(*) as total FROM ftd WHERE client_id=$phone ");
				$nr=$checIfExistResult->fetch_assoc();
				$nr=$nr['total'];

				if ($nr<1) {
				 	$insertFtdResult=mysqli_query($pcon,"INSERT INTO ftd (user_id,amount,client_name,client_id,client_email,ftd_date) VALUES ('$operator','$ftdAmount','$name','$phone','$email','$now')");
					$setFtdAmountNullonVtiger=mysqli_query($vcon, "UPDATE  vtiger_leadscf SET cf_784 =NULL WHERE leadid= '$lead_id'  ");
				}

			}
		}

	 ?>
