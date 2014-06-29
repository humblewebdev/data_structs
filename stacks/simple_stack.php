<?php
class ReadingList
{
    protected $stack;
    protected $limit;

    public function __construct($limit = 10)
    {
        //initialize the stack
        $this->stack = array();
        //stack can only contain this many items
        $this->limit = $limit;
    }

    public function push($item)
    {
        if(count($this->stack) < $this->limit)
        {
            //prepend item to the start of the array
            array_unshift($this->stack, $item);
        }else {
            throw new RuntTimeException('Stack is full!');
        }
    }

    public function pop(){
        if($this->isEmpty())
        {
            //trap for stack underflow
            throw new Exception('Stack is empty!');
        } else {
            //pop item from the start of the array
            return array_shift($this->stack);
        }
    }

    public function top(){
        return current($this->stack);
    }

    public function isEmpty(){
        return empty($this->stack);
    }
}


//Here is how you would use the ReadingList class

$myBooks = new REadingList();

$myBooks->push('A dream of Sping');
$myBooks->push('The Wind of Winter');
$myBooks->push('A Dance with Dragons');
$myBooks->push('A Feast for Crows');
$myBooks->push('A Storm of Swords');
$myBooks->push('A Clash of King');
$myBooks->push('A GAme of Throne');

//Here we will remove some items from the stack
echo $myBooks->pop(); //outputs 'A Game of Thrones'
echo $myBooks->pop(); //outputs 'A Clash of Kings'
echo $myBooks->pop();//outputs 'A Storm of Swords'

//Lets see whats on top of the stack
echo $myBooks->top();//outputs 'A Feast for Crows'

//Lets add a new item to the stack
$myBooks->push('The Armageddon Rag');
echo $myBooks->pop(); //outputs 'The Armageddon Rag'


