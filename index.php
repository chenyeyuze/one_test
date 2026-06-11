<?php

class DataProcessor {
    private $data;

    public function __construct(array $data = []) {
        $this->data = $data;
    }

    public function setData(array $data): void {
        $this->data = $data;
    }

    public function getData(): array {
        return $this->data;
    }

    public function calculateSum(): float {
        return array_sum($this->data);
    }

    public function calculateAverage(): float {
        $count = count($this->data);
        if ($count === 0) {
            return 0.0;
        }
        return $this->calculateSum() / $count;
    }

    public function findMax(): ?float {
        if (empty($this->data)) {
            return null;
        }
        return max($this->data);
    }

    public function findMin(): ?float {
        if (empty($this->data)) {
            return null;
        }
        return min($this->data);
    }

    public function calculateMedian(): ?float {
        if (empty($this->data)) {
            return null;
        }
        $sorted = $this->data;
        sort($sorted);
        $count = count($sorted);
        $middle = (int)($count / 2);
        
        if ($count % 2 === 0) {
            return ($sorted[$middle - 1] + $sorted[$middle]) / 2;
        } else {
            return $sorted[$middle];
        }
    }

    public function calculateVariance(): float {
        if (count($this->data) < 2) {
            return 0.0;
        }
        $mean = $this->calculateAverage();
        $sumSquaredDiff = 0;
        
        foreach ($this->data as $value) {
            $sumSquaredDiff += pow($value - $mean, 2);
        }
        
        return $sumSquaredDiff / (count($this->data) - 1);
    }

    public function calculateStandardDeviation(): float {
        return sqrt($this->calculateVariance());
    }

    public function getStatistics(): array {
        return [
            'count' => count($this->data),
            'sum' => $this->calculateSum(),
            'average' => $this->calculateAverage(),
            'max' => $this->findMax(),
            'min' => $this->findMin(),
            'median' => $this->calculateMedian(),
            'variance' => $this->calculateVariance(),
            'standard_deviation' => $this->calculateStandardDeviation()
        ];
    }

    public static function formatNumber(float $number, int $decimals = 2): string {
        return number_format($number, $decimals, '.', ',');
    }

    public static function formatStatistics(array $stats): string {
        $output = "数据统计报告\n";
        $output .= "================\n\n";
        $output .= "数据个数: {$stats['count']}\n";
        $output .= "总和: " . self::formatNumber($stats['sum']) . "\n";
        $output .= "平均值: " . self::formatNumber($stats['average']) . "\n";
        $output .= "最大值: " . self::formatNumber($stats['max']) . "\n";
        $output .= "最小值: " . self::formatNumber($stats['min']) . "\n";
        $output .= "中位数: " . self::formatNumber($stats['median']) . "\n";
        $output .= "方差: " . self::formatNumber($stats['variance']) . "\n";
        $output .= "标准差: " . self::formatNumber($stats['standard_deviation']) . "\n";
        
        return $output;
    }
}

$sampleData = [12, 15, 18, 22, 19, 25, 30, 17, 21, 24];

$processor = new DataProcessor($sampleData);
$statistics = $processor->getStatistics();

echo DataProcessor::formatStatistics($statistics);

$anotherData = [85, 92, 78, 96, 88, 91, 89, 93, 87, 90];
$processor->setData($anotherData);
$statistics2 = $processor->getStatistics();

echo "\n";
echo DataProcessor::formatStatistics($statistics2);
?>