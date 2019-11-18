<html>
<head>
<title>uFR2FileSystem</title>
</head>
<body>
<?php 
   $idcard=$_POST['idcard'];
   $date=$_POST['date'];
   $time=$_POST['time'];
   $contex=$_POST['contex'];
   $debug_file = fopen('debug.txt','w+');
   if (!get_magic_quotes_gpc())
  {
  	$idcard=addslashes($idcard);
  	$date=addslashes($date);
  	$time=addslashes($time);
  	$contex=addslashes($contex);  
  }
   if (empty($idcard)) exit; 
   
   
    $servername="localhost";
    $username="root";
    $password="";
    $database='ufr2filesystem';
   
   //$file_path='/var/www/ufr.d-logic.net/htdocs/vladan/log/uFR2FileSystem.txt';
  // $file_path='http://ufr.d-logic.net/vladan/log/uFR2FileSystem.txt';
   
   $save_to_database=true;
   $save_to_file=true;   
   
  if ($save_to_database)
  {
   $db=new mysqli($servername,$username,$password,$database);
mysqli_set_charset($db,"utf8");

    
	if (!$db)
    {
     	die('Could not connect: ' . mysql_error());
        exit;
	}
    
    $stmt = $db->prepare("INSERT INTO content (IDCard,Date,Time,Contex) VALUES (?,?,?,?)");
    $stmt->bind_param("ssss",$idcard,$date,$time,$contex);

    $stmt->execute();

    }
	
	 
	if ($save_to_file)
	{
	 $file_path=$_SERVER['DOCUMENT_ROOT'];
     
	 $file_log_path='/ufr2file/logs/';
	 $file_name='uFR2FileSystem_Log.txt';	 
     
     echo($file_path.$file_log_path.$file_name);
     
     $fp=fopen($file_path.$file_log_path.$file_name,'w+');
     if (!$fp)      	
          {
		    die ('file error');		   				    
			exit;
		  }
     $text_file=$idcard." ".$date." ".$time."\n".$contex;
     fwrite($fp,$text_file,strlen($text_file));
     fclose($fp);
	 }
?>

</body>
</html>
