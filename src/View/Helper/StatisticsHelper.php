<?php
namespace App\View\Helper;

use Cake\View\Helper;
use Cake\View\StringTemplateTrait;

class StatisticsHelper extends Helper
{
    /**
     * Get HTML to display a single row of statistics
     *
     * @param string $type 'positive'|'negative' - whether a percentage > 0 indicates something positive or negative
     * @param float $percentage Number from 0-100
     * @param float $value Number that generated the percentage
     * @param string $label Label to be identify the meaning of these values
     * @return string HTML code
     */
    public function displaySingleStatistics($type, $percentage, $value, $label)
    {
        $percentage = number_format($percentage, 0);

        if ((($type == "positive") && ($percentage < 0)) || (($type == "negative") && ($percentage > 0))) {
            $textColor = "text-danger";
            $icon = "fa-level-up";
        } else {
            $textColor = "text-navy";
            $icon = "fa-level-down";
        }

        $html = "<div class='display-table-row stat-percent font-bold $textColor'>";
        $html .= "	<div class='display-table-cell text-right'>" . $percentage . "%</div>";
        $html .= "	<div class='display-table-cell'><i class='fa $icon'></i></div>";
        $html .= "	<div class='display-table-cell'><small>$label</small></div>";
        $html .= "	<div class='display-table-cell'><small>($value)</small></div>";
        $html .= "</div>";
        return $html;
    }

    /**
     * Get HTML to display a set of statistics in a table layout
     *
     * @param string $type 'positive'|'negative' - whether a percentage > 0 indicates something positive or negative
     * @param array $statistics Keys: 'percentage', value', 'label'
     * @return string HTML code
     */
    public function displaySetOfStatistics($type, array $statistics)
    {
        $html = "<div class='row stat-table'>";
        foreach ($statistics as $stat) {
            $html .= $this->displaySingleStatistics($type, $stat['percentage'], $stat['value'], $stat['label']);
        }
        $html .= "</div>";
        return $html;
    }
}
