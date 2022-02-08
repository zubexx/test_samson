<?php
namespace Test3;

class newBase
{
    static private $count = 0;
    static public $arSetName = []; //сделал массив с именами публичным
    
    private $name;// исправил, перенёс объявление переменной
    /**
     * @param string $name
     */
    function __construct(int $name = 0)  // исправил тип переменной $name на string
    {
        if (empty($name)) {
            while (array_search(self::$count, self::$arSetName) != false) {
                ++self::$count;
            }
            $name = self::$count;
        }
        $this->name = $name;
        self::$arSetName[] = $this->name;
    }
    
    /**
     * @return string
     */
    public function getName(): string
    {
        return '*' . $this->name  . '*';
    }
    protected $value;
    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }
    /**
     * @return string
     */
    public function getSize()
    {
        $size = strlen(serialize($this->value));
        return strlen($size) + $size;
    }
    public function __sleep()
    {
        return ['value'];
    }
    /**
     * @return string
     */
    public function getSave(): string
    {
        $value = serialize($this->value); // исправил сериализацию c $value на $this->value
        return $this->name . ':' . strlen($value) . ':' . $value;
    }
    /**
     * @return newBase
     */
    static public function load(string $objToLoad): newBase // разбил одну строку на 4 для лучшей читаемости
    {
        $arValue = explode(':', $objToLoad);
       
        $value = unserialize(substr($objToLoad, strlen($arValue[0]) + 1
                + strlen($arValue[1]) + 1, (int)$arValue[1]));
       
        $obj = new newBase($arValue[0]);
        $obj->value = $value;
        return $obj;
        
    }
}
class newView extends newBase
{
    function __construct($name) {
        parent::__construct($name);
        $this->name = parent::$arSetName[count(parent::$arSetName)-1]; //добавил конструктор и присвоение имени
    }
    private $type = null;
    private $size = 0;
    private $property = null;
    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        parent::setValue($value);
        $this->setType();
        $this->setSize();
    }
    public function setProperty($value)
    {
        $this->property = $value;
        //убрал эту строку: return $this;
    }
    private function setType()
    {
        $this->type = myGetType($this->value); // заменил вызов стандартной функции на myGetType
    }
    private function setSize()
    {
        if (is_subclass_of($this->value, "Test3\newView")) {
            $this->size = parent::getSize() + 1 + strlen($this->property);
        } elseif ($this->type == 'test') {
            $this->size = parent::getSize();
        } else {
            $this->size = strlen($this->value);
        }
    }
    /**
     * @return string
     */
    public function __sleep()
    {
        return ['property'];
    }
    /**
     * @return string
     */
    public function getName(): string
    {
        if (empty($this->name)) { 
            throw new \Exception('The object doesn\'t have name'); //Exception не входит в пространство имён, добавил слэш
        }
        return '"' . $this->name  . '": ';
    }
    /**
     * @return string
     */
    public function getType(): string
    {
        return ' type ' . $this->type  . ';';
    }
    /**
     * @return string
     */
    public function getSize(): string
    {
        return ' size ' . $this->size . ';';
    }
    public function getInfo()
    {
        try {
            echo $this->getName()
                . $this->getType()
                . $this->getSize()
                . "\r\n";
        } catch (\Exception $exc) {                     //Exception не входит в пространство имён, добавил слэш
            echo 'Error: ' . $exc->getMessage();
        }
    }
    /**
     * @return string
     */
    public function getSave(): string
    {
        if ($this->type == 'test') {
            $value = $this->value->getSave();
        }
        // дописал териализацию поля type
        $vSize = strlen($value);
        $type = serialize($this->type);
        $tSize = strlen($type);
        $property = serialize($this->property);
        $pSize = strlen($property);
        $ser =  $this->name . ":" . 
                $tSize . ":" . $type .":" .
                $vSize . ":" . $value . ":" .
                $pSize . ":" . $property;
                 //исправил
       
        return $ser;
    }
    /**
     * @return newView
     */
   static public function loadNew(string $value): newView //исправил функцию и переименовал её в loadNew
    {
        $arValue = explode(':', $value);
         $obj = new newView($arValue[0]);
         $tempString = substr($value, strlen($arValue[0]) + 1
                + strlen($arValue[1]) + 1, (int)$arValue[1]);
         $type = unserialize($tempString);
         $tempString1 = substr($value, strlen($arValue[0]) + 1
                + strlen($arValue[1]) + 1+ strlen($arValue[2]) + 1 + strlen($arValue[3]) + 1+ strlen($arValue[4]) + 1 + strlen($arValue[5]) + 1, (int)$arValue[5]);
         
         if($type=="test"){
            
            $subObj =  newBase::load($tempString1);
            
            }
          $obj->setValue($subObj);
          
            
            $tempString2 = substr($value, strlen($arValue[0]) + 1 + strlen($arValue[1])+1+
                + $arValue[1] +1+ strlen($arValue[5])+1+$arValue[5] + 1 + strlen($arValue[11])+1,(int)$arValue[11]);
            $property = unserialize($tempString2);
           
           $obj->setProperty($property);
        
        return $obj;
    }
}
function myGetType($value): string // изменил название функции со стандартной gettype() на myGetType() 
{
    if (is_object($value)) {
        $type = get_class($value);
        // сделал без цикла do {} while ($type = get_parent_class($type)); 
            
            if (strpos($type, "newBase") !== false) {      //убрал Test3\
                return 'test';
            }
            else {
                    return $type;
            }
    }
    return gettype($value);
}


$obj = new newBase('12345');
$obj->setValue('text');

$obj2 = new newView('9876');// убрал букву 'O' в числовом аргументе и \Test3\
$obj2->setValue($obj);
$obj2->setProperty('field');
$obj2->getInfo();



$save = $obj2->getSave();

$obj3 = newView::loadNew($save); // вызываю функцию loadNew вместо load


var_dump($obj2->getSave() == $obj3->getSave());

