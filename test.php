<pre>
<?php

    require_once 'include/DBManager.php';
    $db_mgr=DBManager::getInstance();
    require_once 'include/DBContract.php';
    echo 'files data<br>';
    print_r($_FILES);
    echo 'post data<br>';
    print_r($_POST);

    ?>
</pre>
