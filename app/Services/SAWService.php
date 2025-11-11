<?php

namespace App\Services;

use App\Models\CoffeeAlternative;
use App\Models\Criteria;

class SAWService
{
    public function calculate()
    {
        $alternatives = CoffeeAlternative::with(['evaluations.criteria', 'evaluations.subCriteria'])->get();
        $criteria = Criteria::all();
        
        if ($alternatives->isEmpty() || $criteria->isEmpty()) {
            return [];
        }

        // Step 1: Buat matriks keputusan
        $decisionMatrix = $this->buildDecisionMatrix($alternatives, $criteria);
        
        // Step 2: Normalisasi matriks
        $normalizedMatrix = $this->normalizeMatrix($decisionMatrix, $criteria);
        
        // Step 3: Hitung nilai preferensi
        $results = $this->calculatePreference($normalizedMatrix, $criteria, $alternatives);
        
        // Urutkan dari nilai tertinggi
        usort($results, fn($a, $b) => $b['score'] <=> $a['score']);
        
        // Tambahkan ranking
        foreach ($results as $index => &$result) {
            $result['rank'] = $index + 1;
        }
        
        return $results;
    }
    
    private function buildDecisionMatrix($alternatives, $criteria)
    {
        $matrix = [];
        
        foreach ($alternatives as $alternative) {
            $row = ['id' => $alternative->id, 'name' => $alternative->name];
            
            foreach ($criteria as $criterion) {
                $evaluation = $alternative->evaluations
                    ->where('criteria_id', $criterion->id)
                    ->first();
                
                $row[$criterion->code] = $evaluation ? $evaluation->subCriteria->value : 0;
            }
            
            $matrix[] = $row;
        }
        
        return $matrix;
    }
    
    private function normalizeMatrix($matrix, $criteria)
    {
        $normalized = [];
        
        foreach ($matrix as $row) {
            $normalizedRow = ['id' => $row['id'], 'name' => $row['name']];
            
            foreach ($criteria as $criterion) {
                $code = $criterion->code;
                $values = array_column($matrix, $code);
                
                if ($criterion->type === 'benefit') {
                    // Normalisasi benefit: Rij / max(Rij)
                    $max = max($values);
                    $normalizedRow[$code] = $max > 0 ? $row[$code] / $max : 0;
                } else {
                    // Normalisasi cost: min(Rij) / Rij
                    $min = min(array_filter($values, fn($v) => $v > 0));
                    $normalizedRow[$code] = $row[$code] > 0 ? $min / $row[$code] : 0;
                }
            }
            
            $normalized[] = $normalizedRow;
        }
        
        return $normalized;
    }
    
    private function calculatePreference($normalizedMatrix, $criteria, $alternatives)
    {
        $results = [];
        
        foreach ($normalizedMatrix as $row) {
            $score = 0;
            $details = [];
            
            foreach ($criteria as $criterion) {
                $normalizedValue = $row[$criterion->code];
                $weightedValue = $normalizedValue * $criterion->weight;
                $score += $weightedValue;
                
                $details[] = [
                    'criteria' => $criterion->name,
                    'normalized' => round($normalizedValue, 4),
                    'weight' => $criterion->weight,
                    'weighted' => round($weightedValue, 4)
                ];
            }
            
            $alternative = $alternatives->find($row['id']);
            
            $results[] = [
                'id' => $row['id'],
                'name' => $row['name'],
                'description' => $alternative->description,
                'score' => round($score, 4),
                'details' => $details
            ];
        }
        
        return $results;
    }
}