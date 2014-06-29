<?php
//The SPL extension provides a set of standard data structures, includeing the SplStack class(PHP5>=5.3.0).  We can
//implement the same object, although much more tersely, using the SplStack as follows:
class ReadingList extends SplStack
{
    //The SplStack class implements a few more methods the we define in the simple_stack.php example.  This is beacuse SplStack is
    //implemented as implemented as a doubly-inked list, which provides the capacity to implement a traversable stack.

}
