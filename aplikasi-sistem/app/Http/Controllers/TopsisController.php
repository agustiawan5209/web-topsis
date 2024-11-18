<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TopsisController extends Controller
{
    private $alternatives;
    private $alternativespow;
    private $criteria;
    private $weights;
    private $idealSolution;
    private $antiIdealSolution;
    private $normalizedMatrix;
    private $WeightedNormalizedMatrix;
    private $relativeCloseness;
    private $separationMeasures;

    public function __construct($alternatives, $criteria, $weights)
    {
        foreach ($alternatives as $key => $alternative) {
            $alternative = array_map(function ($value) {
                if (is_integer($value)) {
                    return pow($value, 2);
                } else {
                    return $value;
                }
            }, $alternative);
            $this->alternativespow[$key] = $alternative;
        }
        $this->alternatives = $alternatives;
        $this->criteria = $criteria;
        $this->weights = $weights;
        $this->normalizedMatrix = array();
        $this->WeightedNormalizedMatrix = array();
        $this->relativeCloseness = array();
        $this->separationMeasures = array();
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
            foreach ($this->criteria as $key => $criterion) {
                $value = $alternative[$criterion];
                $maxValue = array_sum(array_column($this->alternativespow, $criterion));
                $normalizedValue = round($value / sqrt($maxValue), 5);
                // if ($key == 2) {
                //     dd(array_column($this->alternatives, $criterion), sqrt($maxValue), $normalizedValue, $value);
                // }
                $row[] = $normalizedValue;
            }
            $normalizedMatrix[] = $row;
        }
        $this->normalizedMatrix = $normalizedMatrix;
        return $normalizedMatrix;
    }

    private function calculateWeightedNormalizedMatrix($normalizedMatrix)
    {
        $weightedNormalizedMatrix = array();
        foreach ($normalizedMatrix as $row) {
            $weightedRow = array();
            foreach ($row as $i => $value) {
                $weightedValue = round($value * $this->weights[$i], 5);
                $weightedRow[] = $weightedValue;
            }
            $weightedNormalizedMatrix[] = $weightedRow;
        }
        $this->WeightedNormalizedMatrix = $weightedNormalizedMatrix;
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
        $this->separationMeasures = $separationMeasures;
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
        $this->relativeCloseness = $relativeCloseness;
        return $relativeCloseness;
    }

    private function rankAlternatives($relativeCloseness)
    {
        $rankedAlternatives = array();
        foreach ($relativeCloseness as $i => $closeness) {
            if ($closeness >= 0.8) {
                $text = "Sangat Layak";
            } else if ($closeness >= 0.5 && $closeness < 0.8) {
                $text = "Layak";
            } else if ($closeness < 0.5) {
                $text = "Tidak Layak";
            }
            $rankedAlternatives[$this->alternatives[$i]['nama']] = [
                'teks' => $text,
                'nilai' => $closeness,
            ];
        }
        // Sortir array berdasarkan 'nilai' terbesar
        uasort($rankedAlternatives, function ($a, $b) {
            return $b['nilai'] <=> $a['nilai']; // Urutkan dari terbesar ke terkecil
        });

        return [
            'rank' => $rankedAlternatives,
            'alternative' => $this->alternatives,
            'alternative_square' => $this->alternativespow,
            'idealSolution' => $this->idealSolution,
            'antiIdealSolution' => $this->antiIdealSolution,
            'criteria' => $this->criteria,
            'weights' => $this->weights,
            'normalizedMatrix' => $this->normalizedMatrix,
            'WeightedNormalizedMatrix' => $this->WeightedNormalizedMatrix,
            'separationMeasures' => $this->separationMeasures,
            'relativeCloseness' => $this->relativeCloseness,
        ];
    }
}
