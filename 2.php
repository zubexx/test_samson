<!DOCTYPE html>
<html lang='ru'>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <title>Тесты 2</title>
    
</head>

<body>
<h1>Тесты 2</h1>
<h2>Тест convertString($a, $b)</h2>

<?php

/*
Реализовать функцию convertString($a, $b). 
Результат ее выполнения: если в строке $a содержится 2 и более подстроки $b, то во втором месте заменить подстроку $b на инвертированную подстроку.
*/

function convertString(string $a, string $b) : string
{
    
    $strLenght = strlen($b);//длина подстроки
    
    $pos1 = strpos($a, $b);// находим позицию первого вхождения
    if ($pos1===false) 
    {
        return 'В строке нет данной подстроки';
    }
    
    $pos2 = strpos($a, $b, $pos1+$strLenght-1);// находим позицию второго вхождения
    
    	$b = iconv('utf-8', 'windows-1251', $b); 
	$b = strrev($b); // переворачиваем подстроку
	$b = iconv('windows-1251', 'utf-8', $b);
	 
    return substr_replace($a, $b, $pos2, $strLenght) ; // заменяем подстроку встреченную второй раз на обратную
     

}

$a = 'Без кода нет доступа в коди';
$b = 'код';
echo convertString($a, $b). "<br />\n";



?>
