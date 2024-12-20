<?php

// Class representing an edge in the graph
class Edge {
    public int $source;
    public int $destination;
    public int $weight;

    public function __construct(int $source, int $destination, int $weight) {
        $this->source = $source;
        $this->destination = $destination;
        $this->weight = $weight;
    }
}

// Class to manage connected components using Union-Find
class UnionFind {
    private array $parent;

    public function __construct(int $size) {
        $this->parent = range(0, $size - 1); // Initialize the parent array
    }

    // Finds the root of a set with path compression
    public function find(int $x): int {
        if ($this->parent[$x] !== $x) {
            $this->parent[$x] = $this->find($this->parent[$x]); // Path compression
        }
        return $this->parent[$x];
    }

    // Unites two sets
    public function union(int $x, int $y): void {
        $rootX = $this->find($x);
        $rootY = $this->find($y);
        if ($rootX !== $rootY) {
            $this->parent[$rootX] = $rootY; // Merge the two sets
        }
    }
}

function kruskal(int $numberOfVertices, array $edges): void {
    // Sort edges by weight
    usort($edges, fn($edge1, $edge2) => $edge1->weight <=> $edge2->weight);

    $uf = new UnionFind($numberOfVertices);
    $mst = []; // To store edges of the Minimum Spanning Tree (MST)

    foreach ($edges as $edge) {
        $rootSource = $uf->find($edge->source);
        $rootDestination = $uf->find($edge->destination);

        // If the edge doesn't form a cycle, include it in the MST
        if ($rootSource !== $rootDestination) {
            $mst[] = $edge;
            $uf->union($rootSource, $rootDestination);
        }
    }

    // Output the MST edges
    echo "Edges in the MST:\n";
    foreach ($mst as $edge) {
        echo "({$edge->source}, {$edge->destination}) - Weight: {$edge->weight}\n";
    }
}

// Define the graph's vertices and edges
$vertices = 4;
$edges = [
    new Edge(0, 1, 10),
    new Edge(0, 2, 6),
    new Edge(0, 3, 5),
    new Edge(1, 3, 15),
    new Edge(2, 3, 4),
];

// Execute Kruskal's algorithm
kruskal($vertices, $edges);
