<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TopsisController extends Controller
{
    private $alternatives;
    private $criteria;
    private $weights;
    private $idealSolution;
    private $antiIdealSolution;

    public function __construct($alternatives, $criteria, $weights)
    {
        $this->alternatives = $alternatives;
        $this->criteria = $criteria;
        $this->weights = $weights;
    }

    public function calculate()
    {
        // Step 1: Normalize the decision matrix
        $normalizedMatrix = $this->normalizeMatrix();

        // Step 2: Calculate the weighted normalized decision matrix
        $weightedNormalizedMatrix = $this->calculateWeightedNormalizedMatrix($normalizedMatrix);

        // Step 3: Determine the ideal and anti-ideal solutions
        $this->idealSolution = $this->calculateIdealSolution($weightedNormalizedMatrix);
        $this->antiIdealSolution = $this->calculateAntiIdealSolution($weightedNormalizedMatrix);

        // Step 4: Calculate the separation measures
        $separationMeasures = $this->calculateSeparationMeasures($weightedNormalizedMatrix);

        // Step 5: Calculate the relative closeness to the ideal solution
        $relativeCloseness = $this->calculateRelativeCloseness($separationMeasures);

        // Return the ranking of alternatives based on relative closeness
        return $this->rankAlternatives($relativeCloseness);
    }

    private function normalizeMatrix()
    {
        $normalizedMatrix = array();
        foreach ($this->alternatives as $alternative) {
            $row = array();
            foreach ($this->criteria as $criterion) {
                $value = $alternative[$criterion];
                $maxValue = max(array_column($this->alternatives, $criterion));
                $minValue = min(array_column($this->alternatives, $criterion));
                $normalizedValue = ($value - $minValue) / ($maxValue - $minValue);
                $row[] = $normalizedValue;
            }
            $normalizedMatrix[] = $row;
        }
        return $normalizedMatrix;
    }

    private function calculateWeightedNormalizedMatrix($normalizedMatrix)
    {
        $weightedNormalizedMatrix = array();
        foreach ($normalizedMatrix as $row) {
            $weightedRow = array();
            foreach ($row as $i => $value) {
                $weightedValue = $value * $this->weights[$i];
                $weightedRow[] = $weightedValue;
            }
            $weightedNormalizedMatrix[] = $weightedRow;
        }
        return $weightedNormalizedMatrix;
    }

    private function calculateIdealSolution($weightedNormalizedMatrix)
    {
        $idealSolution = array();
        foreach ($weightedNormalizedMatrix[0] as $i => $value) {
            $maxValue = max(array_column($weightedNormalizedMatrix, $i));
            $idealSolution[] = $maxValue;
        }
        return $idealSolution;
    }

    private function calculateAntiIdealSolution($weightedNormalizedMatrix)
    {
        $antiIdealSolution = array();
        foreach ($weightedNormalizedMatrix[0] as $i => $value) {
            $minValue = min(array_column($weightedNormalizedMatrix, $i));
            $antiIdealSolution[] = $minValue;
        }
        return $antiIdealSolution;
    }

    private function calculateSeparationMeasures($weightedNormalizedMatrix)
    {
        $separationMeasures = array();
        foreach ($weightedNormalizedMatrix as $alternative) {
            $distanceToIdeal = 0;
            $distanceToAntiIdeal = 0;
            foreach ($alternative as $i => $value) {
                $distanceToIdeal += pow($value - $this->idealSolution[$i], 2);
                $distanceToAntiIdeal += pow($value - $this->antiIdealSolution[$i], 2);
            }
            $distanceToIdeal = sqrt($distanceToIdeal);
            $distanceToAntiIdeal = sqrt($distanceToAntiIdeal);
            $separationMeasures[] = array($distanceToIdeal, $distanceToAntiIdeal);
        }
        return $separationMeasures;
    }

    private function calculateRelativeCloseness($separationMeasures)
    {
        $relativeCloseness = array();
        foreach ($separationMeasures as $separationMeasure) {
            $distanceToIdeal = $separationMeasure[0];
            $distanceToAntiIdeal = $separationMeasure[1];
            $relativeCloseness[] = $distanceToAntiIdeal / ($distanceToIdeal + $distanceToAntiIdeal);
        }
        return $relativeCloseness;
    }

    private function rankAlternatives($relativeCloseness)
    {
        $rankedAlternatives = array();
        foreach ($relativeCloseness as $i => $closeness) {
            $rankedAlternatives[$this->alternatives[$i]['name']] = $closeness;
        }
        arsort($rankedAlternatives);
        return $rankedAlternatives;
    }
}
