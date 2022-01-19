<!DOCTYPE html>
<html lang='ru'>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <title>Тесты</title>
    
</head>

<body>
<h1>Тесты</h1>
<h2>Тест findSimple($a, $b)</h2>

<?php

/*
Реализовать функцию findSimple ($a, $b). $a и $b – целые положительные числа. 
Результат ее выполнения: массив простых чисел от $a до $b.
*/

	function findSimple(int $a, int $b) : array {   //исправил - указал тип аргументов, добавил тип возвращаемого значения
			if ((($a<=0)||($b<=0))||($a>=$b))  
                        {throw new Exception( 'Не корректный ввод');}//исправил - добавил исключение
		
		$simples = array();
		$sqrt = sqrt($b);
		$isSimple = array_fill(0, $b + 1, false);

		for ($i = 1; $i <= $sqrt; $i++) {
			for ($j = 1 ; $j <= $sqrt; $j++) {
				$n = 4 * pow($i, 2) + pow($j, 2);

				if ($n <= $b && ($n % 12 == 1 || $n % 12 == 5)) {
					$isSimple[$n] ^= true;
				}

				$n = 3 * pow($i, 2) + pow($j, 2);

				if ($n <= $b && $n % 12 == 7) {
					$isSimple[$n] ^= true;
				}
				
				$n = 3 * pow($i, 2) - pow($j, 2);
				
				if ($i > $j && $n <= $b && $n % 12 == 11) {
					$isSimple[$n] ^= true;
				}
			}
		}

		for ($n = 5 ; $n <= $sqrt ; $n++) {
			if ($isSimple[$n]) {
				$s = pow($n, 2);
				
				for ($k = $s; $k <= $b; $k += $s) {
					$isSimple[$k] = false;
				}
			}
		}

		if($a<=2) {
			$simples[] = 2;
			$simples[] = 3;
		}
		elseif ($a<=3) $simples[] = 3;
		

		for ( $i = $a ; $i < $b ; $i++) {
			if ($isSimple[$i]) {
				$simples[] = $i;
			}
		}




		return $simples; 
	}

	



try{
print_r(findSimple(3,120));
}
 catch (Throwable $ex)
 {
 echo "Ошибка в функции findSimple(): " . $ex->getMessage() . "<br>"; // исправил - добавил обработку исключения
 }
?>

<h2>Тест createTrapeze($a)</h2>

<?php

/*Реализовать функцию createTrapeze($a). $a – массив положительных чисел, количество элементов кратно 3. 
Результат ее выполнения: двумерный массив (массив состоящий из ассоциативных массивов с ключами a, b, c). 
Пример для входных массива [1, 2, 3, 4, 5, 6] результат [[‘a’=>1,’b’=>2,’с’=>3],[‘a’=>4,’b’=>5 ,’c’=>6]].
*/

function createTrapeze(array $a) : array
{
	if((count($a)%3!=0)||(is_array($a)==false)) throw new Exception( 'Аргумент не массив или массив не кратный 3 ');
        
        $arrElements = count($a);
	for($i=0;$i<$arrElements-1;$i++) // исправил - объявил переменную и присвоил значение до этой строки
	{
		if($a[$i]<=0) throw new Exception( 'Элемент массива меньше нуля или равен нулю');
	}
	
	$arr2d = array();
	
        $fields = array('a','b','c');

        for($i=0;$i<$arrElements/3;$i++){
            $arrTemp=array_combine($fields,array_slice($a,3*$i,3)); // исправил - сделал реализацию через array_combine()
            array_push($arr2d,$arrTemp);
        }

	return $arr2d;
		
}
$testArr = [4,5,6,7,8,3,1,2,3];

try{
$createTrapezeResult = createTrapeze($testArr);
print_r($createTrapezeResult);
}
catch (Throwable $ex)
 {
 echo "Ошибка в функции createTrapeze(): " . $ex->getMessage() . "<br>"; // исправил - добавил обработку исключения
 }
unset ($testArr);


?>


<h2>Тест squareTrapeze($a)</h2>

<?php
/*
Реализовать функцию squareTrapeze($a). $a – массив результата выполнения функции createTrapeze(). 
Результат ее выполнения: в исходный массив для каждой тройки чисел добавляется дополнительный ключ s, 
содержащий результат расчета площади трапеции со сторонами a и b, и высотой c.
*/

function squareTrapeze(array $a) : array
{
	if(((is_null($a==true))||is_array($a)==false)){
            throw new Exception( 'Аргумент не является массивом ');
        }
	$subArrayNum = count($a);

	for($i=0;$i<$subArrayNum;$i++){
            $a[$i]['s'] = ($a[$i][a]+$a[$i][b])*0.5*$a[$i][c];
	
		
	}
return $a;

}


try {
    $sqrTpz=squareTrapeze($createTrapezeResult);
    print_r($sqrTpz);
} catch (Throwable $ex) {
    echo "Ошибка в функции squareTrapeze(): " . $ex->getMessage() . "<br>"; // исправил - добавил обработку исключения
}

?>







<h2>Тест getSizeForLimit($a, $b)</h2>

<?php
/*
Реализовать функцию getSizeForLimit($a, $b). 
$a – массив результата выполнения функции squareTrapeze(), 
$b – максимальная площадь. 
Результат ее выполнения: массив размеров трапеции с максимальной площадью, но меньше или равной $b.
*/

function getSizeForLimit(array $a, float $b):array
{
    if ($b<=0) {
        {throw new Exception( 'Задана площадь меньшая нуля или равная нулю ');}//исправил - добавил исключение
    }
	$subArrayNum = count($a);
	
	$arrTrSz = array();
	
	for($i=0;$i<$subArrayNum;$i++)
{
	if ($a[$i][s] <= $b) 
	{
		$arrTrSz[]=$a[$i][s];
	}
	 
   
    
}
return $arrTrSz;

	
}
try {
    print_r(getSizeForLimit($sqrTpz, 23));
    
} catch (Throwable $ex) {
    echo "Ошибка в функции getSizeForLimit(): " . $ex->getMessage() . "<br>"; // исправил - добавил обработку исключения
}







?>

<h2>Тест getMin($a)</h2>
<?php
/*
Реализовать функцию getMin($a). $a – массив чисел. 
Результат ее выполнения: минимальное число в массиве (не используя функцию min, ключи массива могут быть ассоциативными).
*/

function getMin(array $a) :float{
    if (is_array($a)==false)  {
        throw new Exception('Аргумент не является массивом ');}
    
    $minVal = null;
    
    foreach ($a as &$value) {   
        if (($minVal > $value)||($minVal===null)) $minVal = $value;
    }

return $minVal;
}

$arr = [ 8, 26, 12, -324, -12, 120, 15];
try {
    print getMin($arr);
} catch (Throwable $ex) {
    echo "Ошибка в функции getMin: " . $ex->getMessage() . "<br>"; // исправил - добавил обработку исключения
}


?>



<h2>Тест printTrapeze($a)</h2>

<?php
/*
Реализовать функцию printTrapeze($a). 
$a – массив результата выполнения функции squareTrapeze(). 
Результат ее выполнения: вывод таблицы с размерами трапеций, строки с нечетной площадью трапеции отметить любым способом.
*/

function printTrapeze(array $a){

if(is_array($a)==false){
    throw new Exception('аргумент не является массивом ');
}

$td = ['a','b','c','s'];
$columnNames = ['Сторона a', 'Сторона b','Высота','Площадь'];
$columns = 4;
$rows = count($a);
?>
<style>
table { border: 0; }
td { padding: 25px; text-align: center; }
</style>

<table>

<?php
for ($tr = -1; $tr < $rows; $tr++)
{
    echo '<tr>';

    for($i = 0; $i < $columns; $i++)
    {
        $background = '';
        if ($tr==-1) {
            $background = 'DarkGray';
            echo '<td style="background-color:', $background, '">','<b>', $columnNames[$i] ,'</b>', '</td>';
        } 
        else{
            if($a[$tr]['s'] % 2 !=0 ) {
                $background = 'Orange';}
            else {
                $background = 'Gainsboro';}
            echo '<td style="background-color:', $background, '">', $a[$tr][$td[$i]] , '</td>';//
	}
    }
    echo "</tr>";
	
}

?>
</table>







<?php
}

try {
    printTrapeze($sqrTpz);
} catch (Throwable $ex) {
    echo "Ошибка в функции printTrapeze(): " . $ex->getMessage() . "<br>"; // исправил - добавил обработку исключения
}


?>


<h2>Тест BaseMath и F1</h2>

<?php
/*
Реализовать абстрактный класс BaseMath содержащий 3 метода: exp1($a, $b, $c) и exp2($a, $b, $c),getValue(). 
Метод exp1 реализует расчет по формуле a*(b^c). 
Метод exp2 реализует расчет по формуле (a/b)^c. 
Метод getValue() возвращает результат расчета класса наследника.
*/

abstract class BaseMath {
    function exp1($a, $b, $c){
	return $a*($b**$c);
    }
    function exp2($a, $b, $c){
	if ($b == 0) {
            throw new Exception('Деление на нуль в методе exp2() ') ;}
	return ($a/$b)**$c;
    }
    
    abstract function getValue();
	
}

/*
Реализовать класс F1 наследующий методы BaseMath, содержащий конструктор с параметрами ($a, $b, $c) и метод getValue(). 
Класс реализует расчет по формуле f=(a*(b^c)+(((a/c)^b)%3)^min(a,b,c)).
*/
class F1 extends BaseMath{
	
    function __construct($a, $b, $c){
        $this->a = $a;
        $this->b = $b;
	$this->c = $c;
    }
	
	
    function getValue(){
        if ($this->c == 0) {
            throw new Exception('Деление на нуль в методе getValue() ') ;}
        return ($this->a*($this->b**$this->c)+((($this->a/$this->c)**$this->b)%3)**min($this->a,$this->b,$this->c));
        }
	
}

$f2 = new F1(8,4,1);
try {
    echo  'Метод exp1:	', $f2->exp1(2, 2, 2), "<br>";
    echo 'Метод exp2:	', $f2->exp2(8,2,3), "<br>";
    
} catch (Throwable $ex) {
    echo "Ошибка: " . $ex->getMessage() . "<br>"; // исправил - добавил обработку исключения
}
try {
    echo  'Реализация абстрактного метода getValue():	', $f2->getValue(),  "<br>";
} catch (Throwable $ex) {
    echo "Ошибка: " . $ex->getMessage() . "<br>"; // исправил - добавил обработку исключения
}


?>
</body>

</html>








































