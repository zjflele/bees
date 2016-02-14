<?
	$host		=	"localhost";
	$user		=	"root";
	$password	=	"f"; 
        $database   =   "hebly";

$conn=mysql_connect($host,$user,$password) or die ("不能连接MYSQL服务器");
$myconn=$conn;
mysql_select_db($database)or die("不能连接数据库！"); 
mysql_query("set names gbk");

$db = NewADOConnection(   "mysql"   );
$db->charSet =  'latin1_swedish_ci';
$db->Connect( $host, $user, $password,$database);

?>
