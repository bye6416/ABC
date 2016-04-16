<?php 
session_start();
//session_destroy(); 
error_reporting(0);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
</head>
<body>
<?php 
include("./connMysql.php");

    //2016.3.26更改成註解  這段指令會檢查資料有無與student_lis資料表t符合
//------------------------- 驗證ceo的帳號是否重複申請 -------------------------
/*
if(isset($_POST["c"])){
	$manAcc=$_POST["c"];
	
	if (!@mysql_select_db("testabc_login")) die("資料庫選擇失敗11111!");
	{
		//找出對應的ceo帳號
		$sql1="SELECT * FROM `student_list` WHERE `sid` = '".$manAcc."' and `isCaptain` = '1'";
		$result1 = mysql_query($sql1) or die("q1f");
		$find1 = mysql_num_rows($result1) ;
		
		//取得ceo的cid
		$sql_cid = mysql_query("SELECT `cid` FROM `student_list` WHERE `sid` = '".$manAcc."' and `isCaptain` = '1'");
		$cid=mysql_fetch_array($sql_cid);
		
		
		//已註冊過的ceo帳號
		$sql2 ="SELECT * FROM `account` WHERE `Account`='".$manAcc."'";
		$result2 = mysql_query($sql2) or die("q2f");
		$find2 = mysql_num_rows($result2) ;
		
	    if($find1!=0 && $find2==1){
			//已註冊過的ceo
			echo "<?php xml version =\"1.0\" ?> \n";
			echo "<response>\n";
			echo '<message>';
			echo '<status>NO</status>';
			echo "<error>You have already registered!</error>";
			echo '</message>';
			echo "</response>";
	    }else if($find1 != 0 && $find2==0){

            //沒註冊過的ceo
			echo "OK!";  
                
			//找出其他公司成員
			$sql3="select * from `student_list` where `cid`='".$cid[0]."' and `isCaptain`='0'";
			$result3 = mysql_query($sql3) or die("Query failed");
			
			echo "<?php xml version =\"1.0\" ?> \n";
			echo "<response>\n";
			echo '<message>';
			echo '<status>OK</status>';
            echo "<acc1>".$manAcc."</acc1>";
			
			$y=1;
			while($row3 = mysql_fetch_array($result3)){
				if($y==1)
					echo "<cid>".$row3['cid']."</cid>";
					$y++;
					echo "<acc$y>".$row3['sid']."</acc$y>";
			}
			echo "<count>$y</count>";
			echo '</message>';
			echo "</response>";
    	
		}else if($find1 ==0){
		    //不是ceo，echo沒有註冊權限	
			echo "<?php xml version =\"1.0\" ?> \n";
			echo "<response>\n";
			echo '<message>';
			echo '<status>NO</status>';
			echo "<error>You have no authority!</error>";
			echo '</message>';
			echo "</response>";
		}
     }
}

*/
//2016.4.5  新增程式碼，讓輸入的值能成功讀入資料庫
    if(isset($_POST["c"])){
	$manAcc=$_POST["c"];
    if (!@mysql_select_db("testabc_login")) die("資料庫選擇失敗11111!");
	{
        $sql ="SELECT * FROM `account` WHERE `Account`='".$manAcc."'";
		$result = mysql_query($sql) or die("q2f");
		$find = mysql_num_rows($result) ;
        if($find==0){
            //沒註冊過的帳號 
            echo "<?php xml version =\"1.0\" ?> \n";
			echo "<response>\n";
			echo '<message>';
            echo "<acc1>".$manAcc."</acc1>";
			echo '<status>OK</status>';
			echo '</message>';
			echo "</response>";   
      }
      else{
          echo "<?php xml version =\"1.0\" ?> \n";
			echo "<response>\n";
			echo '<message>';
			echo '<status>NO</status>';
			echo '</message>';
			echo "</response>";
      }
    
   }
}
    
//------------------------- register值傳入DB -------------------------
if(isset($_POST["action"])&&($_POST["action"]=="add")){
	
		if (!mysql_select_db("testabc_login")) die("資料庫選擇失敗22222！");
		{ 
			$sql1="select * from `account`";
        	$result1 = mysql_query($sql1) or die("Query failed");
			$num_rows1 = mysql_num_rows($result1);
			
	  	    $cName=$_POST["cName"];
			$cid=$_POST["cid"];
			$password=$_POST["Password"];
           
			for($i=1;$i<=7;$i++)
			{	
		    	$account=$_POST["acc{$i}"];	
				$sql_query = "INSERT INTO `account` (`Account`,`Password`,`CompanyID`,`CompanyName`) VALUES (";
				if($_POST["acc{$i}"]!=""){
		     	 	$sql_query .= "'".$account."',";
				 	$sql_query .= "'".md5($password)."',";
				 	$sql_query .= "'".$cid."',";
		    	 	$sql_query .= "'".$cName."')";
				 	//echo $sql_query;
		     	 	mysql_query($sql_query);
				}//end if
			}//end for
		      
			$sql2="select * from `account`";
        	$result2 = mysql_query($sql2) or die("Query failed");
			$num_rows2 = mysql_num_rows($result2);
			$add = $num_rows2 - $num_rows1;  
    
            /*2016.3.26在?>後本來有的亂碼已改成消失*/
     ?> 
            
        
		<script type="text/javascript">
			 alert("申請成功了哦哦哦哦哦哦哦哦哦哦！"); 
			 document.location.href = "./player_login.php";
    	</script>
            
    <?php
	
		}//endif
	}//end if



//---------------------------- 驗證login ----------------------------
if(isset($_POST["action"])&&($_POST["action"]=="login")){
	
	if (!@mysql_select_db("testabc_main")) die("資料庫選擇失敗33333！");
	{   
	
		$account=$_POST["playerID"];	
		$password=$_POST["playerPW"];
		echo $account."|".$password;
		
		//將user account 存入session
		$_SESSION['user']=$account;
		//echo $_SESSION['user'];
		
		$sql_year = "SELECT MAX(`year`) FROM `state`";
		$result = mysql_query($sql_year) or die("Query failed@競賽尚未啟動");	
		$rowy=mysql_fetch_array($result);
		$sql_month = "SELECT MAX(`month`) FROM `state` WHERE `year`=$rowy[0];";
		$result = mysql_query($sql_month) or die("Query failed@競賽尚未啟動");	
		$rowm=mysql_fetch_array($result);
		
		//將month、year存入session
		$_SESSION['year']=$rowy[0];
		$year=$_SESSION['year'];
		
		//(int)($row[0]/12)+1;
		$_SESSION['month']=$rowm[0];
		$month=$_SESSION['month'];
		//$row[0]%12;
		//echo $month."|".$year;
		mysql_select_db("testabc_login");
		$sql_query = "SELECT * from `account` where `Account`='".$account."' && `Password` = '".md5($password)."'";
		$result = mysql_query($sql_query);	
		$rows=mysql_num_rows($result);
		$acc=mysql_fetch_array($result);
		$cname=$acc['CompanyName'];
		$_SESSION['CompanyName']=$cname;
		//echo $rows;	
		//echo $sql_query;
		//echo mysql_num_rows($result);
		
		if($rows==1)//是否有這位學生
			$pass=true;
		//end if
		//echo $pass;	
		 
		$sql_query = "SELECT `cid` from `student_list` where `sid`='".$account."' AND `isCaptain` = '1'";
		$result = mysql_query($sql_query) or die("Query failed@getcid");	
		$cap=mysql_num_rows($result);
		$gtcid=mysql_fetch_array($result);
		//將company id存入session
		$_SESSION['cid']=$gtcid[0];
			mysql_select_db("testabc_main");
			$sql_kpi = "SELECT MAX(`session`) FROM `kpi_info` where `account`='".$cid."'" ;
			$result_kpi = mysql_query($sql_kpi) or die("Query failed@kpi");	
		
		if($pass==true){
			if($month==1){
				mysql_select_db("testabc_login");
				$sql_query = "SELECT * from `authority` where `Account`='".$account."' AND `Year`='".$year."'" ;
				$result = mysql_query($sql_query) or die("Query failed@auto");	
				$row=mysql_num_rows($result);
				$kpi=mysql_fetch_array($result_kpi);//NULL or floor($kpi[0]/12)=$year
				
				if($row==0 && $kpi[0]==NULL || floor($kpi[0]/12)==($year-1)){
					if($cap==1){
						$IsCaptainPass=true;
						echo "<script language=\"JavaScript\"> location.href= ('./mid_login/mid_login.html');</script>";
					}else if($cap==0)
				    	echo "<script language=\"JavaScript\"> alert('總經理尚未完成必要的競賽設定! \\n請盡速通知總經理以順利進入競賽'); 
															location.href=('./player_login.php') </script>";
				}else//有做過決策分配
					echo "<script language=\"JavaScript\"> location.href= ('../abc_main/main.php'); </script>";		
		   }else//month!=1
			  echo "<script language=\"JavaScript\"> location.href= ('../abc_main/main.php'); </script>"; 
		}else{
			echo "<script language=\"JavaScript\"> alert('請確認帳號密碼無誤!'); location.href=('./player_login.php')</script>";
	    }//end if($pass)
	}//end connect db
}//end action=login

//echo $_SESSION['year'];
?>
</body>
</html>