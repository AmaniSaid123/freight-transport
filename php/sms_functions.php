<?php 
//*************************************************************************************************************************************************

function add_feedback_sms($mo,$sid,$msg_id,$statut,$datetime){
	include("param.php");
	
		$sql_query=mysql_query("insert into t_sms_feedback(mo,sid,msg_id,date_statut,statut,datecreation) values('".$mo."','".$sid."','".$msg_id."','".$statut."','".$datetime."',now())");

return $sql_query;	
	
	}

function update_sms($msg_id,$statut,$datetime){
	include("param.php");
	
		$sql_query=mysql_query("update t_sms set statut='".$statut."', date_statut='".$datetime." where msg_id='".$msg_id."'");

return $sql_query;	
	
	}
function is_black_listed($phone){
include("param.php");

$resultat=mysql_query("select count(*) as valeur  from t_phone_black_list where phone='".$phone."'");
$data=mysql_fetch_array($resultat);
//echo "select count(*) as total from t_compte_eac where ref_membre=".$idmembre;
return $data['valeur'];

}

function send_sms($phonenumber,$text,$sender,$numero_compte,$source_action,$type_compte){

include("param.php");

$is_sms_enable=get_parameter_value("enable_sms");
$is_black_listed=is_black_listed('0'.substr($phonenumber,3,9));
$message=$text;
$text=str_replace(" ","%20",$text);


if($is_sms_enable==1 && $is_black_listed==0){

$feedback=file_get_contents("https://1s2u.com/sms/sendsms/sendsms.asp?username=lionelok&password=lionelokitgate&mt=0&fl=0&sid=".$sender."&mno=".$phonenumber."&ipcl=5.196.28.150&msg=".$text);

$query="";
	if(strlen($feedback)>8){

		$query="INSERT INTO `t_sms` (`sender`, `mobile_number`, `message`, `datecreation`, `msg_id`, `statut`, `source_action`, `numero_compte`, `type_compte`, `ref_user`) VALUES ('".$sender."', '".$phonenumber."', '".clean_in_text($message)."',now(), '".$feedback."', 'SUBMITED', '".$source_action."', '".$numero_compte."', '".$type_compte."', '".$_SESSION['my_username']."');
";

	}else{
		
	$query="INSERT INTO `t_sms` (`sender`, `mobile_number`, `message`, `datecreation`, `msg_id`, `statut`, `source_action`, `numero_compte`, `type_compte`, `ref_user`) VALUES ('".$sender."', '".$phonenumber."', '".clean_in_text($message)."',now(), '".$feedback."', 'ERROR ON SENT', '".$source_action."', '".$numero_compte."', '".$type_compte."', '".$_SESSION['my_username']."');
";

		}
	

 $resultat=mysql_query($query);

}
	//$text=str_replace(" ","%20",$text);
	//$requete= file_get_contents("http://104.131.234.190:10200/cgi-bin/sendsms?user=shareolite&pass=blog&text=".$text."&to=".$phonenumber);	

}

?>