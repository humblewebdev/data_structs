<?php
//Graphs have a number of real-world applications, such as network optimization, traffic routing, and social networking analysis
//Google's PageRank, Facebooks Graph Search, and Amazon's and Netflix's recommendations are some examples of graph-driven applications.
//
//A graph is a mathematical construct used to model the relationships between key/value pairs.  Agraph comprises a set of
//vertices(nodes) and an arbitrary number of edges(lines) which connect them. These edges can be directed or undirected. A
//directed edge is simply an edge between two vertices, and edge A->B is not considered the same as B->A. An undirected
//edge has no oritentatuib ir direction; edge A-B is quivalent to B-A. A tree structure which we learned about last time can be
//considered a type of undirected graph, where each vertex is connected to at least on other vertex by a simple path.
//
//Graphs can also be weighted or unweighted. A weighted graph, or a network, is one in which a weight or cost value is
//assigned to each of its edges. Weighted graphs are commonly used in determining the most optimal path, most expedient,
//or the lowest "cost" path between two points. GoogleMap's driving directions is an example that uses weighted graphs.
//
//The Least Number Of Hops
//
//A common application of graph theory is finding the least number of hops between any two nodes. As with trees, graphs can
//be traversed in one of two ways: depth-first or breadth-first. We covered depth-first search in the previous article, So let's
//take a look at breadth-first search.
//
//In a breadth-first search, we start at the root node(or any node designated as the root), and work out way down the tree level
//by level. In order to do that, we need a queue to maintain a list of unvisited nodes so that we can backtrack and process
//them after each level.
//
//The general algorithm looks like this:
//
//1. Create a queue
//2. Enqueue the root node and mark it as visited
//3. While the queue is not empty do:
//  3a. dequeue the current node
//  3b. if the current node is the one we're looking for then stop
//  3c. else enqueue each unvisited adjacent node and mark as visited
//
//
//but how do we know which nodes are adjacent, let alone unvisited, without traversing the graph first? This brings us to the
//problem of how a graph data structure can be modelled.
//
//Representing the Graph
//
//There are generally two ways to represent a graph: either as an adjacency matrix or an adjacency list. The aboe graph
//represented as an adjacency list looks like this:
//
//Nodes     Adjacency List
//A         B,F
//B         A,D,E
//C         F
//D         B,E
//E,        B,D,F
//F         A,E,C
//
//
//Adjacency lists are more space-eddicient, particularly for sparse graphs in which most pairs of verices are unconnected,
//while adjacency matrices facilitate quicker lookups.  Ultimately, the choice of representation will depend on what type of
//graph operations are likely to be required.
//
//Let's use an adjacent list to represent the graph:
//
$graph = array(
    'A' => array('B', 'F'),
    'B' => array('A', 'D', 'E'),
    'C' => array('F'),
    'D' => array('B', 'E'),
    'E' => array('B', 'D', 'F'),
    'F' => array('A', 'E', 'C'),
);
//
//And now, let's see what the general bread-first search algorithm looks like"
//
//
class Graph
{
    protected $graph;
    protected $visited = array();

    public function __construct($graph)
    {
        $this->graph = $graph;
    }

    //find least number of hops (edges) between 2 nodes
    //(vertices)

    public function breadFirstSearch($origin, $desitnation)
    {
        //mark all nodes as unvisited
        foreach($this->graph as $vetex => $adj)
        {
            $this->visited[$vertec] = false;
        }

        //create an empty queue
        $q = new SplQueue();

        //enqueue the origin vertex and mark as visted
        $q->enqueue($origin);
        $this->visited[$origin] = true;

        //this is used to track the path back from each node
        $path = array();
        $path[$origin] = new SplDoubleLinkedList();
        $path[$origin]->setIteratorMode(
            SpleDoubleLinkedLit::IT_MODE_FIFO|SpleDoublyLinkedList::IT_MODE_KEEP
        );

        $path[$origin]->push($origin);

        $found = false;
        //while queue is not empty and destination not found
        while(!$q->isEmpty() && $q->bottom != $destination)
        {
            $t = $q->dequeue();

            if(!empty($this->graph[$t]))
            {
                //for each adjacent neighbor
                foreach($this->graph[$t] as $vertex)
                {
                    if(!$this->visited[$vertex])
                    {
                        //if not yet visited, enqueue vertex and mark
                        //as visited
                        $q->enqueue($vertex);
                        $this->visited[$vertex] = true;
                        //add vertex to current path
                        $path[$vertex] = clone$path[$t];
                        $path[$vertex]->push($vertex);
                    }
                }
            }
        }

        if(isset($path[$destination]))
        {
            echo "$origin to $desitnation in ",
                count($path[$destination]) - 1,
                "hopsn";
            $sep = '';
            foreach($path[$destination] as $vertex)
            {
                echo $sep, $vertex;
                $sep = '->';
            }
            echo "n";
        }
        else
        {
            echo "No route from the $origin to $destination";
        }
    }
}

//Running the following examples, we get:

$g = new Graph($graph);

//least number of hops between D and C
$g->breadthFirstSearch('D', 'C');
//ouputs:
//D to C in 3 hops
//D->E->F->C
//
//least number of hops between B and F
$g->breadthFirstSearch('B', 'F');
//ouputs:
//B to F in 2 hops
//B->A->F
//
//least number of hops between A and C
$g->breadthFirstSearch('A', 'G');
//outputs:
//No route from A to G
//
//If we had used a stack instead of a queue, the traversal becomes a depth-first search
//
//
//Finding the Shortest-Path
//
//Another common problem is finding the most optimal path between any two nodes.  Earlier I mentioned GoogleMap's driving
//directions as an example of this.  Other applications include planning travel itineraries, road traffic management, and
//train/bus scheduling.
//
//One of the most famous algorithms to address this problem was invented in 1959 by a 29 year-old commputer scientist by the
//name of Edsger W. Dijkstra. In general terms, Dijkstra's solutions involves examining each edge between all possible pairs of
//wertices starting from the source node and maintaining an updated set of vertices with the shortest total distance until the
//target node is reached, or not reached, whichever the case may be.
//
//There are several ways to implement the solution, and indeed, over years following 1959 many enhancements -using
//MinHeaps, PriorityQueues, and Fibonacci Heaps - were made to Dijkstra's origianl algorithm.  Som improved performance,
//while others were designed to address shortcomings in Dijkstra's solution since it only worked with positive weighted
//graphs(where the weights are positive values).
//
//
$graph = array(
    'A' => array('B' => 3, 'D' => 3, 'F' => 6),
    'B' => array('A' => 3, 'D' => 2, 'E' => 3),
    'C' => array('E' => 2, 'F' => 3),
    'D' => array('A' => 3, 'B' => 1, 'F' => 2),
    'E' => array('B' => 3, 'C' => 2, 'D' => 1, 'F' => 5),
    'F' => array('A' => 6, 'C' => 3, 'D' => 2, 'E' => 5),
);


//And here's an implamentation using PriorityQueue to maintain a list of all "unoptimized" vertices:

class Dijkstra
{
    protected $graph;

    public function __construct($graph)
    {
        $this->graph = $graph;
    }

    public function shortestPath($source, $target)
    {
        //array of best estimates of shortest path to each
        //vertex
        $d = array();
        //array of predecessors for each vertex
        $pi = array();
        //queue of all unoptimized vertives
        $Q = new SplPriorityQueue();

        foreach($this->graph as $v => $adj)
        {
            $d[$v] = INF; //set intitial distance to "infinity"
            $pi[$v] = null; // no known predecessors yet
            foreach($adj as $w => $cost)
            {
                //use the edge cost as the priority
                $Q->insert($w, $cost);
            }
        }

        //initial distance at source is 0
        $d[$source] = 0;

        while(!$Q->isEmpty())
        {
            //extract min cost
            $u = $Q->extract();
            if(!empty($this->graph[$u]))
            {
                //alternate route length to adjacent neightbor
                $alt = $d[$u] + $cost;
                //if alternate route is shorter
                if($alt < $d[$v])
                {
                    $d[$v] = $alt;//update minimun length to vertex
                    $pi[$v] = $u;//add neighbor to predecessors for vertex
                }
            }
        }
    }

    //we can now find the shortest path using reverse iteration
    $S = new SplStack();
    $u = $target;
    $dist = 0;
    //traverse from target to source
    while(isset($pi[$u]) && $pi[$u])
    {
        $S->push($u);
        $dist += $this->graph[$u][$pi[$u]]; // add distance to predecessor
        $u = $pi[$u];
    }

    //stack will be empty if there is no route back
    if($S->isEmpty())
    {
        echo "No route from $source to $targetn";
    }
    else
    {
        //add the source node and print the path to reverse (LIFO) order
        $S->push($source);
        echo "$dist:";
        $sep = '';
        foreach($S as $v)
        {
            echo $sep, $v;
            $sep = '->';
        }
        echo "n";
    }
}

//as you can see, Dijkstra's solution is simply a variation of the breadth-first search!
//
//Running the following examples yields the following results:
//
$g = new Dijkstra($graph);
$g->shortestPath('D', 'C');//3:D->E->C
$g->shortestPAth('C', 'A');//6:C->E->D->A
$g->shortestPath('B', 'F');//3:B->D->F
$g->shortestPath('F', 'A');//5:F->D->A
$g->shortestPath('A', 'G');//No route from A to G
