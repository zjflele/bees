<?
	$host		=	"localhost";
	$user		=	"root";
	$password	=	"f"; 
        $database   =   "hebly";

$conn=mysql_connect($host,$user,$password) or die ("��������MYSQL������");
$myconn=$conn;
mysql_select_db($database)or die("�����������ݿ⣡"); 
mysql_query("set names gbk");

$db = NewADOConnection(   "mysql"   );
$db->charSet =  'latin1_swedish_ci';
$db->Connect( $host, $user, $password,$database);

?>
