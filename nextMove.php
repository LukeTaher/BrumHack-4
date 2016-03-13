<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
ini_set('magic_quotes_runtime', 0); // 5.3 onwards
ini_set('magic_quotes_gpc', 0);
$code = $_POST['raw'];
$user = $_POST['user'];
$opp = $_POST['opp'];
if(get_magic_quotes_gpc())
{
        echo "yeah";
}
// $code = 'class Run' . $user . ' {
//          public static void main(String args[])
//          {
//              ' . $code . '
//          }
//      }';

if (file_exists($opp . '.txt')) {
    $rawopp = file_get_contents('/var/www/html/' . $opp . '.txt');
}
else
{
    $rawopp = '';
    touch('/var/www/html/' . $opp . '.txt');
}

$oppLines = substr_count($rawopp, '\n');

$userLines = substr_count($code, '\n');

getAction($userLines, $oppLines + 1, $opp, $user, $code);

function getAction($myLines, $oppLines, $opp, $user, $code)
{
    $r = rand(0, 1000);
    $r /= 6;
    //$r = $r*($myLines/$oppLines);
    //echo $r;
    if($r < 95)
    {
        //nothing
        // echo "nothing";
        if (file_exists('/var/www/html/' . $opp . '.json')) {
            $jsonopp = json_decode(file_get_contents('/var/www/html/' . $opp . '.json'), true);
        }
        else
        {
            $jsonopp = '';
            touch('/var/www/html/' . $opp . '.json');
        }
        $arr =  array(
            "0" =>  $code,
            "1" =>  '0',
            "2" =>  $jsonopp);
        echo json_encode($arr);
// echo 'code' . $code;
        file_put_contents('/var/www/html/' . $user . '.txt', $code);
        file_put_contents('/var/www/html/' . $user . '.json', json_encode($arr));
    }
    else if($r < 105)
    {
        // change variable name
        // echo "change var name";
        file_put_contents('/var/www/html/' . $user . '.txt', $code);
        file_put_contents('/var/www/html/' . $user . '.json', json_encode($arr));
        return 1;
    }
    else if($r < 110)
    {
        // cover screen
        // echo "cover screen";
        if (file_exists($opp . '.json')) {
            $jsonopp = json_decode(file_get_contents('/var/www/html/' . $opp . '.json'), true);
        }
        else
        {
            $jsonopp = '';
            touch('/var/www/html/' . $opp . '.json');
        }
        $arr =  array(
            "0" =>  $code,
            "1" =>  '2',
            "2" =>  $jsonopp);
        echo json_encode($arr);
        file_put_contents('/var/www/html/' . $user . '.txt', $code);
        file_put_contents('/var/www/html/' . $user . '.json', json_encode($arr));

    }
    else if($r < 115)
    {
        // delete last line
        // echo "delete last line";
        $codeArr = explode('\n', $code);
        foreach ($codeArr as $i => $line) {
            if($i == sizeof($codeArr) - 1)
            {
                $codeArr[$i] = '';
            }
        }
        $code = implode('\n', $codeArr);
        if (file_exists($opp . '.json')) {
            $jsonopp = json_decode(file_get_contents('/var/www/html/' . $opp . '.json'), true);
        }
        else
        {
            $jsonopp = '';
            touch('/var/www/html/' . $opp . '.json');
        }
        $arr =  array(
            "0" =>  $code,
            "1" =>  '3',
            "2" =>  $jsonopp);
        echo json_encode($arr);
        file_put_contents('/var/www/html/' . $user . '.txt', $code);
        file_put_contents('/var/www/html/' . $user . '.json', json_encode($arr));
    }
    else if($r < 120)
    {
        // loud music
        // echo "loud music";

        if (file_exists($opp . '.json')) {
            $jsonopp = json_decode(file_get_contents('/var/www/html/' . $opp . '.json'), true);
        }
        else
        {
            $jsonopp = '';
            touch('/var/www/html/' . $opp . '.json');
        }
        $arr =  array(
            "0" =>  $code,
            "1" =>  '4',
            "2" =>  $jsonopp);
        echo json_encode($arr);
        file_put_contents('/var/www/html/' . $user . '.txt', $code);
        file_put_contents('/var/www/html/' . $user . '.json', json_encode($arr));
    }
    else if ($r < 125)
    {
        // i = 0
        // echo "i = 0";
        file_put_contents('/var/www/html/' . $user . '.txt', $code);
        file_put_contents('/var/www/html/' . $user . '.json', json_encode($arr));
        return 5;
    }
    else
    {
        // nothing
        // echo "nothing";
        if (file_exists($opp . '.json')) {
            $jsonopp = json_decode(file_get_contents('/var/www/html/' . $opp . '.json'), true);
        }
        else
        {
            $jsonopp = '';
            touch('/var/www/html/' . $opp . '.json');
        }
        $arr =  array(
            "0" =>  $code,
            "1" =>  '0',
            "2" =>  $jsonopp);
        echo json_encode($arr);
        file_put_contents('/var/www/html/' . $user . '.txt', $code);
        file_put_contents('/var/www/html/' . $user . '.json', json_encode($arr));
    }
}

?>
