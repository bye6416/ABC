<?php 
session_start(); 
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>ABC競賽系統</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" href="./css/style_login.css" type="text/css" media="screen"/>
        <link rel="stylesheet" href="./css/table1.css" type="text/css" media="screen"/>
        <!-- jQuery -->
		<script type="text/javascript" src="./js/jquery-1.6.1.js"></script> <!-- http://code.jquery.com/jquery-1.5.2.min.js-->
		<!-- the main script -->
		<script type="text/javascript" src="./js/jquery.template.js"></script>
		 <link href="./js/jquery.fancybox-1.3.4/fancybox/jquery.fancybox-1.3.4.css" type="text/css" rel="stylesheet" media="screen">
        <script type="text/javascript" src="./js/jquery.fancybox-1.3.4/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<style type="text/css">

body {
	overflow-y:scroll;
	background-position : center;
	background-attachment: fixed;
	background-repeat:no-repeat;
	
	font-family: verdana, arial, helvetica;
	font-size: 14px;
	text-align: center;
	}
</style>
<script type="text/javascript">
//-----------------------------------grayTips-----------------------------------
function inputTipText(){    
    $("input[class*=grayTips]")
	
	 //所有樣式名中含有grayTips的input  
	.each(function(){   
        var oldVal=$(this).val();   //默認的提示性文字   
		$(this)   
		.css({"color":"#888"})
		  //灰色
		.focus(function(){ 
		  
		if($(this).val()!=oldVal){$(this).css({"color":"#000"})}else{$(this).val("").css({"color":"#888"} )} 
		})
		
        .blur(function(){   
        if($(this).val()==""){$(this).val(oldVal).css({"color":"#888"})}
		})  
		 
		.keydown(function(){$(this).css({"color":"#000"})})   
		})   
}   
  
$(function(){   
inputTipText(); //顯示   
})

// -------------------------------註冊套件fancybox-----------------------
$(document).ready(function() {

//連結的id
$("#ceo_regi").fancybox({
				'titlePosition'	: 'outside',
				'transitionIn'	: 'fade',
				'transitionOut'	: 'fade'
});

//連結的id
$("a#ceo_regi").click(function () {

//要顯示的
$("#regiForm").bind("submit", function() {

	if ($("#login_name").val().length < 1 || $("#login_pass").val().length < 1) {
	    $("#login_error").show();
	    $.fancybox.resize();
	    return false;
	}

	$.fancybox.showActivity();

	$.ajax({
		type	: "POST",
		cache	: false,
		url		: "/data/loginDB.php",
		data	: $(this).serializeArray(),
		success: function(data) {
			$.fancybox(data);
		}
	});

	return false;
});
  }); 
   });

//-----------------------------------check Account -----------------------------------
function checkAcc(input){

  	if (input=="" || input==" 請輸入學號"){
   		document.getElementById('check1').innerHTML="<font size='1px' color=#FF3425>Account cannot be empty!</font>";
    }
	$.post("loginDB.php",{
			c:input
			},function(xml){
					 adminlogin(xml);
					/* alert(xml);*/
				});
}

//-----------------------------------check password-----------------------------------
function checkPWD(p){

	var p1=document.getElementById('Password1').value;
	var p2=document.getElementById('Password2').value;
	
	if(p1==""||p2==""){		
		document.getElementById('checkPwd').innerHTML="<font size='1px' color=#FF3425>Password cannot be empty!</font>";
    	return;
	}else if(p1!=p2){
		document.getElementById('checkPwd').innerHTML="<font size='1px' color=#FF3425>Passwords incorrect!</font>";		
	}else{
		document.getElementById('checkPwd').innerHTML="OK!";
	}	
}

//-----------------------------get information from loginDB----------------------------
    /*
function adminlogin(xml){
	$("message",xml).each(function(id){
		message = $("message",xml).get(id);
		
		var status = $("status",message).text();	
		var acc1 = $("acc1",message).text();	
		var acc2 = $("acc2",message).text();	
		var acc3 = $("acc3",message).text();	
		var acc4 = $("acc4",message).text();	
		var acc5 = $("acc5",message).text();	
		var acc6 = $("acc6",message).text();	
		var acc7 = $("acc7",message).text();	
		if(status=='OK')
		{	
			//alert(acc1);
			document.getElementById('check1').innerHTML="OK!";
			document.getElementById('acc1').value=$("acc1",message).text();
			document.getElementById('acc2').value=$("acc2",message).text();
			document.getElementById('acc3').value=$("acc3",message).text();
			document.getElementById('acc4').value=$("acc4",message).text();
			document.getElementById('acc5').value=$("acc5",message).text();
			document.getElementById('acc6').value=$("acc6",message).text();
			document.getElementById('acc7').value=$("acc7",message).text();
			document.getElementById('cid').innerHTML=$("cid",message).text();
			document.getElementById('ccount').value=$("count",message).text();
			document.getElementById('ccount').innerHTML=$("count",message).text();
			document.getElementById('ccid').value=$("cid",message).text();
			
			var n = document.getElementById('ccount').innerHTML;
			document.getElementById('Member1').innerHTML="組長";
			for(var i=2;i<=n;i++){
			document.getElementById('Member'+i).innerHTML="組員 "+(i-1);
			}
		}
		
		else if (status=='NO')
		{
			document.getElementById('check1').innerHTML="<font size='1px' color=#FF3425>"+$("error",message).text()+"</font>";
			document.getElementById('acc1').value="";
			document.getElementById('acc2').value="";
			document.getElementById('acc3').value="";
			document.getElementById('acc4').value="";
			document.getElementById('acc5').value="";
			document.getElementById('acc6').value="";
			document.getElementById('acc7').value="";
		}
   });
   
}
    */
    
    function adminlogin(xml){
	$("message",xml).each(function(id){
		message = $("message",xml).get(id);
		
		var status = $("status",message).text();	
		var acc1 = $("acc1",message).text();	
		var acc2 = $("acc2",message).text();	
		var acc3 = $("acc3",message).text();	
		var acc4 = $("acc4",message).text();	
		var acc5 = $("acc5",message).text();	
		var acc6 = $("acc6",message).text();	
		var acc7 = $("acc7",message).text();	
        
     
          if(status=='OK'){
            document.getElementById('check1').innerHTML="OK!";
   			document.getElementById('acc1').value=$("acc1",message).text();
			document.getElementById('acc2').value=$("acc2",message).text();
			document.getElementById('acc3').value=$("acc3",message).text();
			document.getElementById('acc4').value=$("acc4",message).text();
			document.getElementById('acc5').value=$("acc5",message).text();
			document.getElementById('acc6').value=$("acc6",message).text();
			document.getElementById('acc7').value=$("acc7",message).text();
			document.getElementById('cid').innerHTML=$("cid",message).text();
			document.getElementById('ccid').value=$("cid",message).text();
			}
        else if (status=='NO'){
			document.getElementById('check1').innerHTML="<font size='1px' color=#FF3425>It has been registered!</font>";
			document.getElementById('acc1').value="";
			document.getElementById('acc2').value="";
			document.getElementById('acc3').value="";
			document.getElementById('acc4').value="";
			document.getElementById('acc5').value="";
			document.getElementById('acc6').value="";
			document.getElementById('acc7').value="";
        }
    }
    );
}
   

 </script>
	</head>
    <body>
        <div class="left"></div>
		<div class="cd_wrapper">
			<div id="cd_background" class="cd_background">
			<div class="cd_overlay"></div>
			</div>
			<h1 class="cd_title">ABC<span> 製造業模擬競賽系統<br> PLAYER * LOGIN</span></h1>
			<div id="cd_container" class="cd_container">		
				<div class="cd_album cd_album_1" data-bgimg="./thumbs/1.jpg">
		    </div>
			
        </div>

<!--login form -->
<div id="loginForm" style="position:fixed; top:345px; right:180px; font-size: 19px;" >
<form name="loginForm" method="post" action="loginDB.php" ><strong>
  帳號: <input type="text" name="playerID" style="font-size:13px" required/><br/><br/>
  密碼: <input type="password" name="playerPW" style="font-size:13px" required/><br/><br/></strong>
       <tr height="60">
   <td colspan="2" align="center">
      &nbsp;&nbsp;&nbsp;<span><a id="ceo_regi" href="#regiForm" title="註冊"> <img src="./images/signup.png"/></a></span>
      &nbsp;&nbsp;
      <input type="image" src="./images/login.png" href="#" id="loginsubmit"></input>
      </td>
   </tr>
      <input type="hidden" name="action" value="login"/>
   
</form>
 </div> 
<?php
include("connMysql.php");
if (!@mysql_select_db("testabc_login")) die("資料庫選擇失敗!");
$sql="Select `GameName` From `game`";
$result = mysql_query($sql);
$gamename=mysql_fetch_array($result);

?>
<div style="display:none"> 

<!--register form-->
<div id="regiForm" style=" color:#000; width:782px; height:610px; overflow:auto; padding:-45px;" >

<form name="regForm" method="post" action="loginDB.php" >
<div id="tableWrapper" style="width: 100%;">
<table id="vsTable" style="height:90%; width:90%; float:center; margin-top:2%">
<tbody>
<tr>
   <td class="title" colspan="3" align="center"><?php echo $gamename[0]; ?></td>
</tr>

<tr class="second">
   <td class="left" style="border-bottom: 5px solid #9e9e9e;">公司註冊</td>
   <td class="cat" colspan="2" align="center" style=" border-right: 5px solid #9e9e9e;">公司登入資訊</td>
</tr>

<tr>
   <td class="left">組長帳號：
       <input size="10px" type="text" name="check_acc1" class="grayTips" onblur="checkAcc(this.value)" value=" 請輸入學號"/></td>
   <td>組別：<span id="cid"></span></td>
   <td style="border-right: 4px solid #9e9e9e;">公司人數：<span id="ccount"></span></td>
</tr>

<tr class="second">
   <td class="left" style="text-align:right"><span id="check1">*&nbsp;&nbsp;&nbsp;</span>
   <td><span id="Member1" style="text-align:center"/>組長</span></td>
   <td style="border-right: 4px solid #9e9e9e;"> 帳號： <input type="text" size="12px" id="acc1" name="acc1" readonly/></td>
</tr>

<tr class="second">
   <td class="left" >公司名稱：
   	   <input size="13px" type="text" name="cName" class="grayTips" onblur="checkcname(this.value)" value=" 請為公司命名"/></td>
   <td><span id="Member2" style="text-align:center"/>組員1</span></td>
   <td style="border-right: 4px solid #9e9e9e;"> 帳號： <input type="text" size="12px" id="acc2" name="acc2" /></td>
</tr>
<tr class="second">
   <td class="left" style="text-align:right">請選擇您的公司代號:<Br>
    <Select name="cid">
    <Option Value="C01">C01</Option>
    <Option Value="C02">C02</Option>
    <Option Value="C03">C03</Option>
    <Option Value="C04">C04</Option>
    <Option Value="C05">C05</Option>
        <Option Value="C06">C06</Option>
        <Option Value="C07">C07</Option>
        <Option Value="C08">C08</Option>
        <Option Value="C09">C09</Option>
        <Option Value="C10">C10</Option>
</Select>
       <span id="checkcname"></span></td>
   <td><span id="Member3" style="text-align:center"/>組員2</span></td>
   <td style="border-right: 4px solid #9e9e9e;"> 帳號： <input type="text" size="12px" id="acc3" name="acc3" /></td>
</tr>
<tr class="second">
    <td class="left" style="border-bottom: 5px solid #9e9e9e; border-top: 5px solid #9e9e9e;">共用密碼</td>
    <td><span id="Member4" style="text-align:center"/>組員3</span></td>
   <td style="border-right: 4px solid #9e9e9e;"> 帳號： <input type="text" size="12px" id="acc4" name="acc4" /></td>
</tr>
<tr class="second">
   <td class="left" algin="center">請輸入密碼：
       <input size="9px" type="password" name="Password" id="Password1" style="text-align:left;" required/></td>
   <td><span id="Member5" style="text-align:center"/>組員4</span></td>
   <td style="border-right: 4px solid #9e9e9e;"> 帳號： <input type="text" size="12px" id="acc5" name="acc5" /></td>
</tr>

<tr class="second">
   <td class="left" align="center">請確認密碼：
       <input size="9px" type="password" id="Password2" onblur="checkPWD(this.value);" style="text-align:left" required/></td> 
   <td><span id="Member6" style="text-align:center"/>組員5</span></td>
   <td style="border-right: 4px solid #9e9e9e;"> 帳號： <input type="text" size="12px" id="acc6" name="acc6" /></td>
</tr>

<tr class="second">
    <td class="left" style="text-align:right; border-bottom: 4px solid #9e9e9e;"><span id="checkPwd">*&nbsp;&nbsp;&nbsp;</span></td>
    <td style="	border-bottom: 4px solid #9e9e9e;">
    	<span id="Member7" style="text-align:center"/>組員6</span></td>
    <td style="	border-bottom: 4px solid #9e9e9e; border-right: 4px solid #9e9e9e;"> 
    	帳號： <input type="text" size="12px" id="acc7" name="acc7" /></td>
</tr>
</tbody>
</table>
<p>
<input type="hidden" id="ccid" name="ccid" />
<input type="hidden" name="action" value="add" />
<input id="regitit" type="submit"  value="申請"/>
</div>
</form>
</div>
</div>

</div>
</body>

</html>