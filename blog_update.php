<?php 
ini_set( 'display_errors', "On" );
require_once('blog.php');
$blogs=$_POST;

$blog=new Blog();
$blog->blogValidate($blogs);
$blog->blogUpdate($blogs);


?>
    <p><a href ="/">戻る</a></p>