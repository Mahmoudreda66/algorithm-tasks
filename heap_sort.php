<?php

// Ensures the subtree rooted at index $i satisfies the max-heap property
function heapify(array &$arr, int $n, int $i): void {
    $largest = $i; // Assume the root is the largest element
    $left = 2 * $i + 1; // Index of the left child
    $right = 2 * $i + 2; // Index of the right child

    // Check if the left child exists and is larger than the current largest
    if ($left < $n && $arr[$left] > $arr[$largest]) {
        $largest = $left;
    }

    // Check if the right child exists and is larger than the current largest
    if ($right < $n && $arr[$right] > $arr[$largest]) {
        $largest = $right;
    }

    // Swap and recursively heapify if the root is not the largest
    if ($largest !== $i) {
        [$arr[$i], $arr[$largest]] = [$arr[$largest], $arr[$i]];
        heapify($arr, $n, $largest);
    }
}

// Converts the input array into a max-heap
function buildMaxHeap(array &$arr): void {
    $n = count($arr);
    // Start from the last non-leaf node and heapify each node
    for ($i = intdiv($n, 2) - 1; $i >= 0; $i--) {
        heapify($arr, $n, $i);
    }
}

// Sorts the array in ascending order using heap sort
function heapSort(array &$arr): void {
    $n = count($arr);
    // First, build the max-heap
    buildMaxHeap($arr);

    // Move the root of the heap to the end of the array and reduce the heap size
    for ($i = $n - 1; $i > 0; $i--) {
        [$arr[0], $arr[$i]] = [$arr[$i], $arr[0]]; // Swap root with the last element
        heapify($arr, $i, 0); // Restore the heap property for the reduced heap
    }
}

// Outputs the elements of the array as a space-separated string
function printArray(array $arr): void {
    echo implode(" ", $arr) . PHP_EOL;
}

// Test the heap sort implementation
$arr = [12, 11, 13, 5, 6, 7];

echo "Original array:\n";
printArray($arr);

heapSort($arr);

echo "Sorted array:\n";
printArray($arr);
