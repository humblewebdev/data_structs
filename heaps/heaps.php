<?php

//Heaps
//
//There are several heap variations. For instance, if parent keys are ordered such that they are of equal or greater value than
//their children, and the highest key is at the root,  the heap is said to be a maxheap.  If parent keys are ordered such that they
//are of equal or lower value than their children, with the lowest key at the root, the heap is called a minheap. SPL
//(PHP>=5.3.0) provides a basic heap, minheap, maxheap, and specialized data type called a Priority Queue.
//
//While heaps are usually implemented as a complete binary trees, unline binary trees there is no implied ordering of siblings
//and cousing, nor is there any implied sequence for an in-order traversal.
//
//Heaps are a variant of the table data type so they also have the same basic operations:
//
//create = creat an empty heap.
//isEmpty - determine if the heap is empty.
//insert -  add an item to the heap
//extract - remve the topmost item(root) item from the heap.
//
//Unlike a table, the retrieve and delete operations for a heap are combined into a single extract operation, so let's focus on
//how the extraxt operation works first.
//
//The condition for removing an item from the heap is that we can only remove the root node.  Let's say we remove the root
//node.  We would be left with two disjoint heaps. We need a method of transforming the
//remaining nodes back into a single heap after the root is removed.  Joining them is easily accomplished by moving the last
//node the the root, but we're left with a resulting structure that fails the heap property. Such a structure is call a semiheap.
//
//We now need a way to transform the semiheap into a heap. One strategy is to trickle the root item down the tree unti it
//reaches a node where it will not be out of place.  We iteratively comapre the value of the root node to its children and swap
//places with the larger child until it arrives at a node where no child has a greater (or equal) value than itself.
//
//Implementing a Heap as an Array
//
//We can naively implement a binary maxheap as an array/ Abinary node has at most twp children, therefore for any n
//number of nodes a binary heap will have at most 2n + 1 nodes.
//
//Here's what an implementation looks like:
//
class BinaryHeap
{
    protected $heap;

    public function __construct()
    {
        $this->heap = array();
    }

    public function isEmpty()
    {
        return empty($this->heap);
    }

    public function count()
    {
        //returns the heapsize
        return count($this->heap) -1;
    }

    public function extract()
    {
        if($this->isEmpty())
        {
            throw new RunTimeException('Heap is empty');
        }

        //extract the root item
        $root = array_shift($this->heap);

        if(!$this->isEmpty())
        {
            //move last item into the root so the hep is
            //no longer disjointed
            $last = array_pop($this->heap);
            array_unshift($this->heap, $last);

            //transform semiheap to heap
            $this->adjust(0);
        }
        return $root;
    }

    public function compare($item1, $item2)
    {
        if($item1 == $item2)
        {
            return 0;
        }
        //reverse the comparison to change to a MinHeap!
        return ($item1 > $item2 ? 1 : -1);
    }

    protected function isLeaf($node)
    {
        //there wil always be 2n +1 nodes in the
        //sub-heap
        return ((2 * $node) + 1) > $this->count();
    }

    protected function adjust($root)
    {
        //we've gone as far as we can down the tree if
        //root is a lead
        if(!$this->isLeaf($root))
        {
            $left = (2 * $root) + 1;//left child
            $right = (2 * $root) +2;//right child

            //if root is less than either of its children
            $h = $this->heap;
            if(
                (isset($h[$left]) &&
                $this->compare($h[$root], $h[$left]) < 0)
                ||(isset($h[$left]) &&
                $this->compare($h[$root], $h[$right]) < 0)
            ){
                //find the larger child
                if(isset($h[$left]) && isset($h[Right]))
                {
                    $j = ($this->compare($h[$left], $h[$right]) >= 0)
                        ? $left : $right;
                }
                else if (isset ($h[$left]))
                {
                    $j = $left;//left child only
                }
                else
                {
                    $j = $right;// right child only
                }

                //swap places with root
                list($this->heap[$root], $this->heap[$j]) =
                    array($this->heap[$j], $this->heap[$root]);

                //recursively adjust semiheap at new
                //node j
                $this->adjust($j);
            }
        }
    }

    //The insertion strategy is teh exact opposite of extracion: we insert the item at the bottom of the heap and trickle it up to its
    //correct location. Since we know that a complete binary tree with a full last level contains n/2 + 1 nodes, we can traverse the
    //heap using a simple binary search.
    //
    public function insert($item)
    {
        //insert new items at the bottom of the heap
        $this->heap[] = $item;

        //trickle up to the correct location
        $place = $this->count();
        $parent - floor($place/2);
        //while not at root and greater than parent
        while(
            $place > 0 && $this->compare(
                $this->heap[$place], $this->$heap[$parent]) >= 0
        ){
            //swap places
            list($this->heap[$place], $this->heap[$parent]) =
                array($this->heap['parent'], $this->heap[$place]);
            $place = $parent;
            $parent = floor($place/2);
            }
    }

}

//SPLMaxHeap and SplMinHeap
//
//Fortunately for us, SPLHeap, SPLMaxHeap and SPLMinHeap abstracts all of this for us. All we have to do is extend the base
//class and override the comparison method like so:

class MyHeap extends SplMaxHeap
{
    public function compare($item1, $item2)
    {
        return (int)$item1 - $item2;
    }
}

//The compare method can perform any arbitrary comparison, as long as it returns - in the case of SplMaxHeap - a positive
//integer if $item1 is greater than $item2, 0 if they are equal, or a negative integer otherwise. If extending SplMinHeap, it
//should return a positive integer if $item1 is less than $item2.
//
//It's not recommended to have multiple elements with the same value in a heap as they may end up in an arbitrary relative
//position
//
//SplPriorityQueue
//
//The Priority Queue is a specialized abstract data type that behaves like a queue, but is usually implemented as a heap - in
//the case of SplPriorityQueue, as a maxheap. Prioritized queues have many real-worl applications, such as service
//desks/ticket escalation. They are also essential in improving the performance of certain graph applications.
//
//Like the SplHeap, you only have to override the base calss and comparator method:
//
class ProQueue extends SplPriorityQueue
{
    public function compare($p1, $p2)
    {
        if($p1 === $p2) return 0;
        //in ascending order of priority, alower value
        //means higher priority
        return ($p1 < $p2) ? 1 : -1;
    }
}

//The main difference in a SplPriorityQueue is that the insert opertion expects a priority value - which can be a mixed data
//type. The insert operation uses the priority to shigt the element up the heap based on the return result of you comparator.
//
//
