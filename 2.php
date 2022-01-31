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


<h2>Тест convertString($a, $b)</h2>

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
        if($key!==$b) 
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
    if($noKey) {  throw new Exception("В массиве с индексом  " . $i . "  отсутствует ключ  " . $b);}
}
array_multisort($sortArray[$b],SORT_ASC,$a);

  
    
          return $a;      
}

$a = [['a'=>2,'b'=>1],['a'=>1,'b'=>3],['a'=>5,'b'=>2],['a'=>8,'b'=>6],['a'=>3,'b'=>5],['a'=>4,'b'=>4]];

try {
    print_r(mySortForKey($a, 'b'));
} catch (Exception $ex) {
    echo "Ошибка. Неправильный массив: " . $ex->getMessage() . "<br>"; // исправил - добавил обработку исключения
}

?>


<h2>Тест importXml($a)</h2>

<!--
Реализовать функцию importXml($a). $a – путь к xml файлу (структура файла приведена ниже). 
Результат ее выполнения: прочитать файл $a и импортировать его в созданную БД.
-->


<?php


function importXml($a)
{
    $prods[] = new Product;
    
    
    if (file_exists($a)) 
    {
         $xml_doc = new DOMDocument(); //создаём DOM документ для считывания XML
    $xml_doc->load($a);
    
    $root = $xml_doc->documentElement;
    

    $nodes=$xml_doc->getElementsByTagName("Товар"); //получаем элементы по тегу Товар
    
        foreach ($nodes as $node)
        {
            $prod = new Product;
            
            //print $node->nodeName .":" ;
 
            if ($node->hasAttributes())
            {
                //echo "Код:" . $node->getAttribute('Код'). "<br>";
                $prod->name = $node->getAttribute('Название');
                $prod->code = $node->getAttribute('Код');
                //echo "Название:" . $node->getAttribute('Название'). "<br>";
            }
            
            
               $elements=$node->getElementsByTagName("Цена");//получаем элементы по тегу Цена
            foreach ($elements as $element)
        {
                //print $element->nodeName ." = " . $element->nodeValue . "<br>";
                $prod->price[$element->getAttribute('Тип')] = $element->nodeValue;
             
        }
            
          
        
          $elements=$node->getElementsByTagName("Свойства");//получаем элементы по тегу Свойства
          foreach ($elements as $element)
          {
           if($element->hasChildNodes())
           {
               $child=$element->firstChild;
               while($child!=false)
               {
                   if($child->nodeName!="#text"){
                   //print $child->nodeName ." === " . $child->nodeValue . "<br>";
                   
                      if ($child->hasAttributes())
            {
                //echo "ЕдИзм:" . $child->getAttribute('ЕдИзм'). "<br>";
                $prod->property[] =  array($child->nodeName,$child->nodeValue,$child->getAttribute('ЕдИзм'));
            } else {
                $prod->property[] =  array($child->nodeName,$child->nodeValue);
            }
                   
                   }
                   
                
                   $child=$child->nextSibling;
               }
           }
          }
            
       
       
       $elements=$node->getElementsByTagName("Раздел");//получаем элементы по тегу Раздел
         
          foreach ($elements as $items)
    
       {
           //print $items->nodeName ." = " . $items->nodeValue . "<br>";
           $prod->category[] = $items->nodeValue;
          
       }
       
       $prods[] = $prod;
        
        }
            
         
           
            
          
            
            
            
            
            
          // Попытка подключения к серверу MySQL. 
        
$link = mysqli_connect("localhost", "root", "", "test_samson");
 
// Проверка подключения
if($link === false){
    die("ERROR: Ошибка подключения. " . mysqli_connect_error());
}

foreach ($prods as $prod)
{
 $code=(int)$prod->code;
 $name=$prod->name;
 
 $priceValue1=$prod->price['Базовая'];
 $priceValue2=$prod->price['Москва'];
 //echo "вывод: " . $code . "<br>" . $name . "<br>"  . "<br>";
 
 //echo "priceValue1: " . $priceValue1 . "<br>"  . "priceValue2: " .$priceValue2 . "<br>";
 
 if($code!=0){
     //приводим к допустимой строке для запроса 
    $code = mysqli_real_escape_string($link, $code);
    $name = mysqli_real_escape_string($link, $name);
 // Попытка выполнения запроса вставки
 $sql = "INSERT INTO a_product (Code, Name) VALUES
          ('$code', '$name');
       ";
if(mysqli_query($link, $sql)){
    echo "Записи успешно вставлены в a_product.". "<br>";
} else{
    echo "ERROR: Не удалось выполнить $sql. " . mysqli_error($link). "<br>";
}
 
 $priceValue1 = mysqli_real_escape_string($link, $priceValue1);
 $priceValue2 = mysqli_real_escape_string($link, $priceValue2);

 $sql = "INSERT INTO a_price (productCode, productName, priceType, price) VALUES
          ('$code', '$name','Базовая','$priceValue1'),
         ('$code', '$name','Москва','$priceValue2');
       ";
if(mysqli_query($link, $sql)){
    echo "Записи успешно вставлены в a_price.". "<br>";
} else{
    echo "ERROR: Не удалось выполнить $sql. " . mysqli_error($link). "<br>";
}
 
 
 foreach ($prod->property as  $value)
 {
     $property = implode(" ", $value);
  

$property = mysqli_real_escape_string($link, $property);
  $sql = "INSERT INTO a_property (productCode , productName, property) VALUES
          ('$code', '$name', '$property');
       ";
if(mysqli_query($link, $sql)){
    echo "Записи успешно вставлены в a_property.". "<br>";
} else{
    echo "ERROR: Не удалось выполнить $sql. " . mysqli_error($link). "<br>";
}
 
}
 
 
 //echo $prod->category[0] .  "<br>";
 $parentCatCode=0;
 for ($i=0;$i<count($prod->category);$i++)  //создаём разделы на основе кода товара
 {
     
     if($i==0)$catCode=floor($code/100);    // 2 - Бумага; 3 - Принтеры
     if($i==1)$catCode=floor($code/10);     // 30 - МФУ
     if($i>1)$catCode=floor($code/10)+$i;   // для более вложенных категорий
     $category=$prod->category[$i];
     $category = mysqli_real_escape_string($link, $category);
     $sql = "INSERT INTO a_category (Id, Code, Name, productName, IdParentCategory)
    VALUES(NULL,'$catCode','$category','$code', '$parentCatCode'); ";        
 if(mysqli_query($link, $sql)){
    echo "Записи успешно вставлены в a_category.". "<br>";
} else{
    echo "ERROR: Не удалось выполнить $sql. " . mysqli_error($link). "<br>";
}
     
     $parentCatCode=$catCode;
 }
 foreach ($prod->category as $cat)
 {
 $category=$cat;
  //echo "category: " . $category .  "<br>";
  
 }

 }
 }
 
// Закрыть соединение
mysqli_close($link);  
  
}

//print_r($prods);
}




class Product
{
    public  $code;
    public  $name;
    public  $price = array();
    public  $property = array();
    public  $category = array();
}

 
 


 if( isset( $_POST['fromXMLtoBase'] ) )
    {
       
         importXml('importXML.xml');
        
    }


?>

<form method="POST">
    <input type="submit" name="fromXMLtoBase" value="Считать файл в базу" />
</form>
<br>












<h2>Тест exportXml($a, $b)</h2>

<!--
Реализовать функцию exportXml($a, $b). 
$a – путь к xml файлу вида (структура файла приведена ниже), $b – код рубрики. 
Результат ее выполнения: выбрать из БД товары (и их характеристики, необходимые для формирования файла) 
выходящие в рубрику $b или в любую из всех вложенных в нее рубрик, сохранить результат в файл $a.
-->



<form method="POST">
    <label>Код категории (здесь это: 2,3 или 30): <input type="text" name="catname"></label>
    <input type="submit" name="fromBasetoXML" value="Считать из базы в файл" />
</form>


<?php

function exportXml($a, $b)
 {   
    $prods[] = new Product; //создаём объект для хранения данных считанных из БД
    
    $link  =  mysqli_connect("localhost", "root", "", "test_samson" ); //соединяемся с БД
    if (  !$link  )   die("Error");

    $b = mysqli_real_escape_string($link, $b); // проверяем введённую пользователем информацию на допустимость применения в запросе
    
    $query   =  "SELECT productName, Name, IdParentCategory FROM a_category WHERE Code ='$b'"; //запрос по категории
    $result  =  mysqli_query( $link,  $query );
    if ( !$result ) echo "Произошла ошибка: "  .  mysqli_sqlstate($link);//mysqli_error()
    else echo "Данные получены по коду ".$b."<br>";

    
    $entries = $result->fetch_all(MYSQLI_ASSOC);

    $prod = new Product;
    $prods[] = $prod;   //массив для хранения считанной из БД информации
    $i=0;
    foreach ($entries as $value)
        {
             
            $code=(int)$value['productName'];
            if($code!=0)
            {
                
            $query   =  "SELECT Name FROM a_product WHERE Code =$code"; //выбираем продукты с кодом присутствующем в категории
            $result  =  mysqli_query( $link,  $query );
            if ( !$result ) echo "Произошла ошибка: "  .  mysqli_error();
            else echo "Данные получены из a_product"."<br>";
            $entries = $result->fetch_all(MYSQLI_ASSOC);
            $prods[$i]->name=$entries[0]['Name'];
            $prods[$i]->code=$code;
            $prods[$i]->category[]=$value['Name'];
            
            $query   =  "SELECT priceType, price FROM a_price WHERE productCode=$code"; //выбираем цены по коду товара
            $result  =  mysqli_query( $link,  $query );
            if ( !$result ) echo "Произошла ошибка: "  .  mysqli_error();
            else echo "Данные получены из a_price"."<br>";
            $entries = $result->fetch_all(MYSQLI_ASSOC);
            foreach ($entries as $val)
            {
                $prods[$i]->price[$val['priceType']]=$val['price'];
            }
            
            $query   =  "SELECT property FROM a_property WHERE productCode=$code"; //выбираем свойства по коду товара
            $result  =  mysqli_query( $link,  $query );
            if ( !$result ) echo "Произошла ошибка: "  .  mysqli_error();
            else echo "Данные получены из a_property"."<br>";
            
            $entries = $result->fetch_all(MYSQLI_ASSOC);
            
            foreach ($entries as $val)
            {
                foreach ($val as $s)
                $prods[$i]->property[]=explode(" ", $s);
            }
           
            $parent=(int)$value['IdParentCategory'];
            while ($parent!=0)
                {
                    $query   =  "SELECT Name, IdParentCategory FROM a_category WHERE Code=$parent"; //выбираем рубрики в которых присутствует товар
                    $result  =  mysqli_query( $link,  $query );
                    if ( !$result ) echo "Произошла ошибка: "  .  mysqli_error();
                    else echo "Данные получены из a_category"."<br>";
                    $entries = $result->fetch_all(MYSQLI_ASSOC);
    
                    foreach ($entries as $value)
                        {
                            $prods[$i]->category[]=$value['Name'];
                            $parent=$value['IdParentCategory'];
                        }
                    $prods[$i]->category = array_unique($prods[$i]->category);
                }
                
                }
               // $prods[$i] = $prod;
                unset ($propertyArr);
            $i++;
        }
        
       

   // print_r($prods);
    mysqli_close( $link );
    
    
    
   

$doc = new DOMDocument("1.0", "windows-1251");// Создаём новый XML-документ


$root = $doc->createElement("Товары");// Добавляем корневой элемент
$doc->appendChild($root);

foreach($prods as $product)
{

$prodDOM = $doc->createElement("Товар");// Элемент Товар
$root = $doc->appendChild($prodDOM);

$tempCode=$product->code;
$prodDOM->setAttribute("Код", "$tempCode");
$tempName=$product->name;
$prodDOM->setAttribute("Название", "$tempName");



for ($k=0;$k<count($product->price);$k++) {
    $priceDOM[$k] = $doc->createElement("Цена");// Элемент Цена
    $prodDOM = $doc->appendChild($priceDOM[$k]);
    $tempPriceType = key($product->price);
    $tempPriceValue = $product->price[$tempPriceType];
    $priceDOM[$k]->setAttribute("Тип", "$tempPriceType");
    $priceDOMtext[$k] = $doc->createTextNode("$tempPriceValue");
    $priceDOM[$k] = $doc->appendChild($priceDOMtext[$k]);
    
    next($product->price);
}


$propertiesDOM = $doc->createElement("Свойства");// Элемент Свойства
$prodDOM = $doc->appendChild($propertiesDOM);


for ($k=0;$k<count($product->property);$k++) {
    $propName=$product->property[$k][0];
    $propValue=$product->property[$k][1];
    
    $propertyDOM[$k] = $doc->createElement("$propName");// Элемент Свойство
    
    $propertyDOMtext[$k] = $doc->createTextNode("$propValue");
    $propertiesDOM = $doc->appendChild($propertyDOM[$k]);
    if($product->property[$k][2]!=false)
    {
        $propM=$product->property[$k][2];
        $propertyDOM[$k]->setAttribute("ЕдИзм", "$propM");
    }
    $propertyDOM[$k] = $doc->appendChild($propertyDOMtext[$k]);
}


$categoriesDOM = $doc->createElement("Разделы");// Элемент Разделы
$prodDOM = $doc->appendChild($categoriesDOM);

for ($k=0;$k<count($product->category);$k++) {
    $tempCat = $product->category[$k];
    $categoryDOM[$k] = $doc->createElement("Раздел");
    $categoriesDOM = $doc->appendChild($categoryDOM[$k]);
    $categoryDOMtext = $doc->createTextNode("$tempCat");
    $categoryDOM[$k] = $doc->appendChild($categoryDOMtext);
}
}

// Сохранить XML-документ
$doc->save($a);
echo 'файл '. $a . ' записан';    
    
 }




if( isset( $_POST['fromBasetoXML'] ) )
    {
      $catname = $_POST['catname'];
         exportXml('exportXML.xml', $catname);
        // коды категорий здесь: 2 - Бумага, 3 - Принтеры, 30 - МФУ
    }


?>