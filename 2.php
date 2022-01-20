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



<h2>Тест mySortForKey($a, $b)</h2>

<?php

/*
Реализовать функцию mySortForKey($a, $b). $a – двумерный массив вида [['a'=>2,'b'=>1],['a'=>1,'b'=>3]], $b – ключ вложенного массива. 
Результат ее выполнения: двумерном массива $a отсортированный по возрастанию значений для ключа $b. 
В случае отсутствия ключа $b в одном из вложенных массивов, выбросить ошибку класса Exception с индексом неправильного массива.
*/

function mySortForKey(array $a, $b) : array
{
    $aDim = count($a);
    $noKey = false;
    
    $sortArray = array();
    
    for($i = 0; $i<$aDim; $i++){
    foreach($a[$i] as $key=>$value){
        if($key!==$b) //проверяем, есть ли ключ в массиве
        {
            $noKey = true;
        }else{
            $noKey = false;
        }
       
        if(!isset($sortArray[$key])){
            $sortArray[$key] = array();
        }
        $sortArray[$key][] = $value;
    }
    if($noKey) {  throw new Exception("В массиве с индексом  " . $i . "  отсутствует ключ  " . $b);} // если ключа нет, то выбрасываем исключение
}
array_multisort($sortArray[$b],SORT_ASC,$a); // сортируем по ключу

  
    
          return $a;      
}

$a = [['a'=>2,'b'=>1],['a'=>1,'b'=>3],['a'=>5,'b'=>2],['a'=>8,'b'=>6],['a'=>3,'b'=>5],['a'=>4,'b'=>4]];

try {
    print_r(mySortForKey($a, 'b'));
} catch (Exception $ex) {
    echo "Ошибка. Неправильный массив: " . $ex->getMessage() . "<br>"; 
}

?>