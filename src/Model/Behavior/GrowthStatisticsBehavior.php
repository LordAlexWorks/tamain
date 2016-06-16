<?php
namespace App\Model\Behavior;

use Cake\Core\Exception\Exception;
use Cake\ORM\Behavior;
use Cake\ORM\Query;

class GrowthStatisticsBehavior extends Behavior
{
    /**
     * Calculate growth of a final value in relation to a start value.
     *
     * @param float $finalValue Number representing the final state
     * @param float $startValue Number representing the original state
     * @return float Number representing the growth of the final state in relation to the original state
     */
    public function calculateGrowth($finalValue, $startValue)
    {
        if ($startValue <= 0) {
            return 100;
        }
        if (is_numeric($finalValue) && is_numeric($startValue)) {
            return (($finalValue - $startValue) / $startValue) * 100;
        }
        return -1;
    }
    
    /**
     * Compare the number of results of a query in a certain date ('referenceDate')
     * to the number of results in previous dates (specified in array 'dates').
     *
     * @example Param $options must have an array with key 'stats':
     *  $options = [ 'stats' => [
     *      'field' => 'Members.created'        (mandatory to assign a field to be compared)
     *      'customFinder' => 'newMembers'      (default: from $query)
     *      'referenceDate' => 'now'            (default: 'now')
     *      'dates' => ["-1 month", "-1 year"]  (default: null. Format: strtotime string)
     *  ] ];
     *
     * @example Result array $stats will have an array in the following format:
     *  $stats = [
     *      'reference' => [
     *          "count" => 125,             (number of results of the query)
     *          "growth" => 0,              (percentage from 0-100 in which reference's count grew)
     *          "query" => Query object     (used to gather these results)
     *      ],
     *      '-1 month' => [
     *          "count" => 100,
     *          "growth" => 25,
     *          "query" => Query object
     *      ]
     *  ];
     *
     * @param \Cake\ORM\Query $query Query
     * @param array $options Query options
     * @return array Containing key 'reference' and keys with the param 'dates'.
     *      For each key, the value is an array with 'count', 'growth', and 'query'
     */
    public function findCountGrowth(Query $query, array $options)
    {
        if (!array_key_exists("stats", $options) || !array_key_exists("field", $options['stats'])) {
            throw new Exception("Statistics not available with the requested parameters.");
        }

        $stats = [];
        $field = $options['stats']['field'];
        $customFinder = (array_key_exists("customFinder", $options['stats']) ? $options['stats']['customFinder'] : null);

        // Growth reference data
        if (array_key_exists("referenceDate", $options['stats'])) {
            $referenceDate = new \DateTime($options['stats']['referenceDate']);
        } else {
            $referenceDate = new \DateTime();
        }

        $referenceQuery = (clone $query);
        if ($customFinder) {
            $referenceQuery = $referenceQuery->find($customFinder, [ 'referenceDate' => $referenceDate]);
        } else {
            $referenceQuery = $referenceQuery->where([
                $field . ' <= ' => $referenceDate
            ]);
        }

        $referenceCount = $referenceQuery->count();

        $stats["reference"] = [
            "count" => $referenceCount,
            "growth" => 0,
            "query" => $referenceQuery
        ];

        if (!$options['stats']['dates']) {
            return $stats;
        }

        // Growth comparisons
        foreach ($options['stats']['dates'] as $dateModifier) {
            $comparisonDate = clone $referenceDate;
            $comparisonDate->modify($dateModifier);

            $dateQuery = (clone $query);
            if ($customFinder) {
                $dateQuery = $dateQuery->find($customFinder, [
                    'referenceDate' => $comparisonDate
                ]);
            } else {
                $dateQuery = $dateQuery->where([
                    $field . ' <= ' => $comparisonDate
                ]);
            }

            $count = $dateQuery->count();
            
            $stats[$dateModifier] = [
                "count" => $count,
                "growth" => $this->calculateGrowth($referenceCount, $count),
                "query" => $dateQuery
            ];
        }
        return $stats;
    }
}
