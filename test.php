<pre>
    <code style="font-size:20px">
<?php
    //certificat d'attitude professionnelle
    echo ''.date('Y-m-d h:i:s');
    header('refresh:1');
    echo '<br>';

    $str = file_get_contents('test.txt');
    $pattern = '/\w+@\w+\.\w+/i';
    echo preg_replace($pattern, "<i style='color:red'>an email was here</i>", $str);
    /*if(preg_match_all($pattern,$str,$matches)){
            echo 'matches<br>';
            print_r($matches);
        }else
            echo 'no matches found';
        */
        ///
    ?>
    </code>
</pre>