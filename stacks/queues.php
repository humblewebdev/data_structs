<?php
//If you have ever been in a line at the supermarket checkout, then you'll know that the first person in line get served first. In
//computer terminology, a queue is another abstract data type, which operates on a first in first out basis, or FIFO. Inventory is
//also managaed on a FIFO basis, particularly if such items are of a perishable nature.
//
//The basic operations which define a queue are:
//
//init - create the queue
//enwueue - add an item the the "end" (tail) of the queue
//dequeue - remove an item from the "front" (head) of the queue.
//isEmpty - return whether the queue contains no more items.
//
//Since SplQueue is also implemented using a doubly-linked list, the semantic meaning of top and pop are reversed in this
//context. Let's redefine our REadingList calss as a queue:
//
class ReadingList extends SplQueue
{
}

$myBooks = New ReadingList();
//add some items to the queue
$myBooks->enqueue('A Game of Throne');
$myBooks->enqueue('A Clash of Kings');
$myBooks->enqueue('A Storm of Swords');

//To remove items from the front of the queue
echo $myBooks->dequeue() . "n";//outputs 'A Game of Thrones'
echo $myBooks->dequeue() . "n";//outputs 'A Clash of Kings'

//enqueue() is an alias for push(), but note the dequeue() in not an alias for pop(); pop has a different meaning
//and function in the context of a queue. If we had used pop() here, it would remover the item from the end(tail) of the
//queue which violated the FIFO rule.
//
//Similarly, to see what's in the fron(head) of the queue, we have to use bottom() instead of top():
//
echo $myBooks->bottom() . "n"; //outputs 'A Storm of Swords'


