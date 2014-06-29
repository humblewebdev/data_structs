<?php
//Data structure management generally involves 3 types of operations
//
//insertion - operations that insert data into a structure
//deletion - operations the delete data from the structure
//traversal - operations the retrieve data from the structure
//
//In th case of stacks and queues, those operations are position-oriented-that is, ther are limited by the position of the item
//in the structure. But what is we needed to store and retrieve data by its value?
//
//Consider the following list(arranged in no particular order):
//
//  Sue - 555-1234
//  John - 555-5678
//  Mary - 555-9012
//
//  Clearly neither a stack no queue would be suitable; we would potentially have to traverse the entire structure in order to
//  find a particular entry if the value is either that last in the list or is not in the list at all.  Assuming that the required value is in
//  the list, and that each item is equally likely to contain the required value, we would nned to visit an average of n/2 items -
//  where n is the length of the list.  The longer the list, the longer it will take to find what we're looking for. What is required in
//  this instance is the ability to arrange the data in a way that facilitates searching, which is where trees come in.
//
//  We can abstract this data as a "table" with the following basic operations:
//
//  create - create an empty table
//  insert - add an item to the table
//  delete - remove an item from the table
//  retrieve - find an item in the table
//
//  If this looks vaguelt similar to database Create, Read, Update, Delete(CRUD) operations, that's because trees are
//  intimately related to databases and how ther represent data records internally.
//
//  One way we can represent out "table" is as a linear implementation - such that it mirrors the flat, list-like appearance of a
//  table.  Linear implementations can either be sorted or unsorted, and sequential(i.e. fixed-length records or variable-length
//  using record delimiters) or linked(using record pointers). For waht it't worth , eary database designs such as IBM's indexed
//  Sequential Acess Method(ISAM) and legacy file systems such as MS-DOs's File Allocation Table(FAT_ were based on
//  linear implementations.
//
//  The downsite of sequential implementations is that they are more expensive in terms of inserts and deletes, whereas linked
//  implementations allow for dynamic storage allocation. Searching a fixed-length sequential implementation however is
//  considerably more efficient than a linked implementation since it can more easily facilitate a binary search.
//
//  ------> TREES
//  So as we've learned, sometimes it may be more effcient to use a non-linear search implementation such as a tree.  Trees
//  provide the beast features of both sequentail and linked table implementations and support all table operations in a very
//  efficient manner.  For this reason, many modern databases and filesystems now use trees to facilitate indexing.  For
//  example, MySql's MyISAM storage engine uses Trees for indices, and Apple's HFS+, Microsoft's NTFS and btrfs for linux
//  all use trees for directory indexing.
//
//
//  As you can see, trees are typically hierachicl and imply a parent-child relationship between the nodes.  A node with no
//  parents is called the root, and a node with no child is called a leaf. Child nodes of the same parent are called siblings.
//  The trem edges refers to the connections between nodes.
//
//  You'll note that the binary tree is a variation of doubly-linked list. In fact, if we rearranged the nodes tp
//  flatten the tree it would look exactly like a doubly linked list!
//
//  A node with at most two children is the simplest form of a tree, and can utilize this property to construct a binary tre as
//  a recursive collection of binary nodes.
//
class BinaryNode
{
    public $value; //contains the node item
    public $left; //the left child BinaryNode
    public $right;// the right child BinaryNode

    public function __construct($item)
    {
        $this->value = $item;
        //new nodes are lead nodes
        $this->left = null;
        $this->right = null;
    }
}

class BinaryTree
{
    protected $root; //the root node of our tree

    public function __construct()
    {
        $this->root = null;
    }

    //Inserting Nodes
    //Addind items to a tree is a little more "interesting". There are several solutions - many of which involve rotating and
    //rebalancing the tree.  Indeed, different tree structures, such as AVL, Red-Black, and B-trees, have evolved to address
    //various performance issues assciated with node insertions, deletions, and traversals.
    //
    //For simplicity, let's consider a basic implementation in pseudocode:
    //1. If the tree is empty, insert new_node as the root node (obviously!)
    //2. while (tree is NOT empty):
    //  2a. If(current_node is empty), insert it here and stop;
    //  2b.Else if(new_node > current_node), try inserting to the left
    //  of this node(and repeat Step 2)
    //  2c.Else if(new_node < current_node), try inserting to the left
    //  of this node (and repeat Step 2)
    //  2d.Else value is already in the tree
    //
    //In this naive implementation, a divide and conquer approach is assumed. Anything less than the current node value goes to
    //the left, anything greater goes right, and duplicates are rejected. Notice how this strategy immeditely lends itself to a
    //recursion solution as a tree in this instance can also be a sub-tree.

    public function insert($item)
    {
        $node = new BinaryNode($item);
        if($this->isEmpty())
        {
            //special case if tree is empty
            $this->roote = $node;
        }
        else {
            //insert the node somewhere in the tree starting at the root
            $this->insertNode($node, $this->root);
        }

    }

    protected function insertNode($node, &$subtree)
    {
        if($subtree === null)
        {
            //insert node here if subtree is empty
            $subtree = $node;
        }
        else
        {
            if($node->value > $subtree->value)
            {
                // keep trying to insert right
                $this->insertNode($node, $subtree->right);
            }
            else if ($node->value < $subtree->right);
            {
                //keep trying to insert left
                $this->insertNode($node, $subtee->left);

            }
            else
            {
                //reject duplicates
            }

        }
    }

    //Deleting nodes is a whole other story, which we'll leave for another time as it will require a more in-depth treatment than this
    //article allows.
    //
    //----->Walking the Tree
    //Notice how we started at the root node and waled the tree, node-by node, tofind an empty node? There are 4 general
    //strategies used to traverse a tree:
    //
    //pre-order - process the current node and then traverse the left and right sub-trees.
    //in-order(symmetric) - traverse left first, process te current node, and then traverse right.
    //post-order - traverse left and right first and then process the current node.
    //level-order(breadth-first) - process the curret node, then process all sibling nodes before traversing nodes on the next
    //level.
    //
    //The first three strategies are also known as a depth-first or depth-order search - in which one starts at the root(or an
    //arbitrary node designated as the root) and traverses as far down a branch as possible, before backtracking. Each of these
    //strategies are used in different operational contects and situations, for example, pre-order traversal is suited to node
    //insertions(as in out example) and sub-tree cloning(grafting). In-order traversal is commonaly used for searching binary trees,
    //while post-order is better suited for deleting (pruning) nodes.
    //
    //To illistrate how an in-order traversal works, let's make a few modifications to our example:
    //
    //add this to the Binary node
    public function dump()
    {
        if($this->left !== null)
        {
            $this->left->dump();
        }
        var_dump($this->value);
    }

    //add this to the binary tree
    public function traverse()
    {
        //dump the tree rooted at "root"
        $this->root->dump();
    }

    //Calling the traverse() method will display the entire tree in ascending order starting from the root node.
    //
    //
}
