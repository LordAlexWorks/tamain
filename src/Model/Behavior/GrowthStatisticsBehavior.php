<?php

namespace App\Model\Behavior;

use Cake\ORM\Behavior;
use Cake\ORM\Query;

class GrowthStatisticsBehavior extends Behavior
{
	public function calculateGrowth($finalValue, $startValue) {
		if ($startValue <= 0) {
			return 100;
		}
		if (is_numeric($finalValue) && is_numeric($startValue)) {
			return (($finalValue - $startValue) / $startValue) * 100;
		}
		return -1;
	}

	// As options:
	// stats
	//   field => 'created'
	//   referenceDate => 'today'
	//   dates => ["-1 month", "-1 year"]
	public function findCountGrowth(Query $query, array $options)
	{

		$stats = array();

		if ($options['stats'] && $options['stats']['field'] && $options['stats']['dates']) {
			$field = $options['stats']['field'];

			// Growth reference data
			if ($options['stats']['referenceDate']) {
				$referenceDate = new \DateTime($options['stats']['referenceDate']);
			}
			else {
				$referenceDate = new \DateTime();
			}
			
			$referenceDateFormatted = date_format($referenceDate, 'Y-m-d');

			$referenceQuery = $query->where([
				$field . ' <= ' => $referenceDateFormatted
			]);
			$referenceCount = $referenceQuery->count();
			$stats["reference"] = [
				"count" => $referenceCount,
				"growth" => 0,
				"data" => $referenceQuery->toArray()
			];			

			// Comparisons
			foreach ($options['stats']['dates'] as $gDate) {
				$comparisonDate = date_add($referenceDate, date_interval_create_from_date_string($gDate));

				$dateQuery = $query->where([
					$field . ' <= ' => date_format($comparisonDate, 'Y-m-d')
				]);

				$count = $dateQuery->count();
				$stats[$gDate] = [
					"count" => $count,
					"growth" => $this->calculateGrowth($referenceCount, $count),
					"data" => $dateQuery->toArray()
				];
			}
		}
	    return $stats;
	}
}