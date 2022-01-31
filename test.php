<pre>
<?php
    $host_name='localhost';
    $user_name='root';
    $password='';
    $db_name='e_classe_db';
    $connection=new mysqli($host_name,$user_name,$password,$db_name);
    if($connection->connect_errno){
        die('there was an error: '.$connection->connect_error);
    }else
        die('connected successfully');

  ?>
</pre>

