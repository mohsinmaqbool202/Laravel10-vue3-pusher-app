<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class SortJSONData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sort';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $jsonContents = File::get(public_path('products/products.json'));
        $products = json_decode($jsonContents, true);

        $options = ['Un Sort', 'Bubble Sort', 'Insertion Sort', 'Selection Sort', 'Quick Sort'];

        $option = $this->choice(
            'Please select a sort type:',
            $options
        );

        switch ($option) {
            case 'Un Sort':
                $products = $this->unSort($products);
                break;
            case 'Bubble Sort':
                $products = $this->bubbleSort($products);
                break;
            case 'Insertion Sort':
                $products = $this->insertionSort($products);
                break;
            case 'Selection Sort':
                $products = $this->selectionSort($products);
                break;
            default:
                $this->error('Invalid option selected.');
                break;
        }
    }

    /**
     * unsort function accepts an array and a comparison function.
     * The comparison function is called multiple times by usort, which compares pairs of elements in the array.
     * If the first argument should be sorted before the second argument, the function returns a negative number.
     * If the first argument should be sorted after the second argument, the function returns a positive number.
     * If the arguments are equal, the function returns 0.
     * @param $products
     * @return array
     */
    public function unSort($products): array
    {
        $startTime = microtime(true);

        usort($products, function ($a, $b) {
            return $a['id'] - $b['id'];
        });

        $endTime = microtime(true);
        $this->logProcessingTime($startTime, $endTime);
        return $products;
    }

    /**
     * After each outer loop iteration, largest element moves down to end of array, At the end of outer loop array gets sorted
     * Inner loop compare to adjacent elements and swap them if the first element is greater then the other
     * @param $products
     * @return array
     */
    public function bubbleSort($products): array
    {
        $startTime = microtime(true);

        $n = count($products);
        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < $n - $i - 1; $j++) {
                if ($products[$j]['id'] > $products[$j + 1]['id']) {
                    $temp = $products[$j];
                    $products[$j] = $products[$j + 1];
                    $products[$j + 1] = $temp;
                }
            }
        }

        $endTime = microtime(true);
        $this->logProcessingTime($startTime, $endTime);
        return $products;
    }

    /**
     * Insertion sort is a simple sorting algorithm that works similarly to the way you sort playing cards in your hands.
     * The array is virtually split into a sorted and an unsorted part.
     * Values from the unsorted part are picked and placed in the correct position in the sorted part.
     * @param $products
     * @return array
     */
    public function insertionSort($products): array
    {
        $startTime = microtime(true);

        $n = count($products);
        for ($i = 1; $i < $n; $i++) {
            $key = $products[$i];
            $j = $i - 1;

            while ($j >= 0 && $products[$j]['id'] > $key['id']) {
                $products[$j + 1] = $products[$j];
                $j = $j - 1;
            }

            $products[$j + 1] = $key;
        }

        $endTime = microtime(true);
        $this->logProcessingTime($startTime, $endTime);
        return $products;
    }

    /**
     * Selection Sort divides the input array into two parts: the sorted and the unsorted subarrays.
     * The algorithm iterates through the unsorted subarray, finds the minimum element, and swaps it with the first element of the unsorted subarray.
     * This process is repeated until the entire array is sorted.
     * @param $products
     * @return array
     */
    public function selectionSort($products): array
    {
        $startTime = microtime(true);

        $n = count($products);
        for ($i = 0; $i < $n; $i++) {
            $low = $i;
            for ($j = $i + 1; $j < $n; $j++) {
                if ($products[$j]['id'] < $products[$low]['id']) {
                    $low = $j;
                }
            }

            // Swap the minimum value to $ith node
            if ($products[$i]['id'] > $products[$low]['id']) {
                $tmp = $products[$i];
                $products[$i] = $products[$low];
                $products[$low] = $tmp;
            }
        }

        $endTime = microtime(true);
        $this->logProcessingTime($startTime, $endTime);
        return $products;
    }

    /**
     * @param $startTime
     * @param $endTime
     * @return void
     */
    public function logProcessingTime($startTime, $endTime): void
    {
        $processingTime = round(($endTime - $startTime) * 1000, 2);
        $this->error('Processing Time: ' . $processingTime . ' milliseconds');
    }
}
