<?php session_start();require( "cn.php" );
date_default_timezone_set('America/Bogota');
$password = $_POST['password'] ?? '';
$user = $_POST['user'] ?? '';
$fecha=date("Y/m/d");
$ro = mysqli_fetch_array(mysqli_query($connection,"SELECT * FROM a_usuarios WHERE user='$user'"));
if (!empty($password)){ 
//if (!empty($password)){ $pass=password_hash($password, PASSWORD_BCRYPT); }

	//$sq = "select id,doc,nombre,nivel,user,clave,sucursal,obs4  from d_usuarios where user='$user'  and clave='$pass' and estado = 'Activo' ";
	//$resul = mysqli_query($connection,$sq);
	//$ro = mysqli_fetch_array($resul);
 
	//if(mysqli_num_rows($resul)>0){
    if($user && password_verify($password, $ro['clave'])) { 
		$_SESSION['logged']= "yes";
		$_SESSION['nomcli']= explode(" ",explode(", ",$ro['nombre'])[2])[0];
		$_SESSION['codcli']= $ro['id'];
		$_SESSION['nivelcli']= $ro['nivel'];
		$_SESSION['sucurcli']= $ro['sucursal'];
		$_SESSION['ndoc']= $ro['ndoc'];
		$_SESSION['color']= $ro['obs']; // color de usuarui
		echo '<script>document.location.href="dashboard.php";</script>';
    }else { 
		$_SESSION['logged']= NULL;
		session_destroy();
		echo '<script>document.location.href="intranet.php";</script>';
    }
}
?>