<?php session_start();require( "cn.php" );
date_default_timezone_set('America/Bogota');
$password = $_POST['password'] ?? '';
$user = $_POST['user'] ?? '';
$fecha=date("Y/m/d");
if (!empty($password)){ $pass=md5($password); }

	$sq = "select id,ndoc,nombre,nivel,user,clave,sucursal  from a_usuarios where user='$user'  and clave='$pass' and estado = 'Activo'";
	$resul = mysqli_query($connection,$sq);
	$ro = mysqli_fetch_array($resul);
 
	if(mysqli_num_rows($resul)>0){
		$_SESSION['logged']= "yes";
		$_SESSION['nomcli']= explode(" ",explode(", ",$ro['nombre'])[2])[0];
		$_SESSION['codcli']= $ro['id'];
		$_SESSION['nivelcli']= $ro['nivel'];
		$_SESSION['sucurcli']= $ro['sucursal'];
		$_SESSION['ndoc']= $ro['ndoc'];
		echo '<script>document.location.href="inicio.php";</script>';

	}else{
		$_SESSION['logged']= NULL;
		session_destroy();
		echo '<script>document.location.href="intranet.php?e=1&r='.$r.'";</script>';
	}

?>