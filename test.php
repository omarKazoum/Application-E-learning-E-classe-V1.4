<pre>
<?php
    require_once 'include/AccountManager.php';
    $am=AccountManager::getInstance();
    $am->login('eee');
    echo $am->isLoggedIn()?'logged':'not logged in';
    ?>
</pre>
