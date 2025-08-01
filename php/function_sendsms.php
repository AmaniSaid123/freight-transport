<?php 

function send_sms_2($phonenumber,$text,$sender,$numero_compte,$source_action,$type_compte){

include("param.php");

//$is_sms_enable=get_parameter_value("enable_sms");
//$is_black_listed=is_black_listed('0'.substr($phonenumber,3,9));
$message=$text;
$text=urlencode($text);
$total_expediteur=substr_count($phonenumber,",")+1;
if(1){
//$phonenumber=str_replace()
$feedback=file_get_contents('https://api-public-2.mtarget.fr/messages?username=passportsarl&password=VULPli7BSawN&msisdn=%2b'.str_replace(",",",%2b",$phonenumber).'&sender='.$sender.'&msg='.$text);
//echo(file_get_contents('https://api-public-2.mtarget.fr/messages?username=passportsarl&password=VULPli7BSawN&msisdn=%2b'.str_replace(",",",%2b",$phonenumber).'&sender='.$sender.'&msg='.$text));
//$feedback=file_get_contents('https://api.mtarget.fr/api-sms.json?username=esolution&password=Ho4lMaC2&msisdn=%2b'.str_replace(",",",%2b",$phonenumber).'&sender='.$sender.'&msg='.$text);
//echo 'https://api.mtarget.fr/api-sms.json?username=esolution&password=Ho4lMaC2&msisdn=%2b'.str_replace(",",",%2b",$phonenumber).'&sender='.$sender.'&msg='.$text;

//$feedback=file_get_contents("https://1s2u.com/sms/sendsms/sendsms.asp?username=lionelok&password=lionelokitgate&mt=0&fl=0&sid=".$sender."&mno=".trim($phonenumber)."&ipcl=5.196.28.150&msg=".$text);

//echo "https://1s2u.com/sms/sendsms/sendsms.asp?username=lionelok&password=lionelokitgate&mt=0&fl=0&sid=".$sender."&mno=".trim($phonenumber)."&ipcl=5.196.28.150&msg=".$text;
//$result = json_decode($feedback);

$feedback=1;
//echo "<br>".$feedback;
$query="";
	if(1){

		/*$query="INSERT INTO `t_sms` (`sender`, `mobile_number`, `message`, `datecreation`, `msg_id`, `statut`, `source_action`, `numero_compte`, `type_compte`, `ref_user`,nb_caractere,nb_sms) VALUES ('".$sender."', '".$phonenumber."', '".$message."',now(), '".$result->results[0]->ticket."', '".$result->results[0]->reason."', '".$source_action."', '".$numero_compte."', '".$type_compte."', '".$_SESSION['my_username']."',".strlen($text).",".ceil((strlen($text)/140)).");
";*/
$user=(isset($_SESSION['my_username'])) ? $_SESSION['my_username'] : "system";
        $query="INSERT INTO `t_sms` (`sender`, `mobile_number`, `message`, `datecreation`, `msg_id`, `statut`, `source_action`, `numero_compte`, `type_compte`, `ref_user`,nb_caractere,nb_sms) VALUES ('".$sender."', '".$phonenumber."', '".$message."',now(), '".$feedback."', '".$feedback."', '".$source_action."', '".$numero_compte."', '".$type_compte."', '".$user."',".strlen($text).",".ceil((strlen($text)/140))*$total_expediteur.")";
;
	}else{
		
	$query="INSERT INTO `t_sms` (`sender`, `mobile_number`, `message`, `datecreation`, `msg_id`, `statut`, `source_action`, `numero_compte`, `type_compte`, `ref_user`) VALUES ('".$sender."', '".$phonenumber."', '".$message."',now(), '".$feedback."', 'ERROR ON SENT', '".$source_action."', '".$numero_compte."', '".$type_compte."', '".$_SESSION['my_username']."');
";

		}
//echo $query;
 $resultat=$bdd->exec($query);

}
}

function send_sms($phonenumber,$text,$sender,$type){

send_sms_2($phonenumber,$text,$sender,"RAS","System","RAS");


}



?>