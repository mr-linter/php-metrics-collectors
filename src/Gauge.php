<?php

namespace MrLinter\Metrics\Collectors;

use MrLinter\Contracts\Metrics\GaugeRecord;
use MrLinter\Contracts\Metrics\Snapshot;
use MrLinter\Contracts\Metrics\Subject;

class Gauge extends Collector
{
    /**
     * @param array<string, string> $labels
     */
    public function __construct(
        Subject $subject,
        private readonly array $labels = [],
        private ?float $value = null,
    ) {
        parent::__construct($subject);
    }

    public function collect(): Snapshot
    {
        $gauges = [];

        if ($this->value !== null) {
            $gauges = [
                new GaugeRecord($this->subject()->key, $this->value, $this->labels),
            ];
        }

        return new Snapshot(
            $this->subject(),
            [],
            $gauges,
            [],
        );
    }

    public function set(float $value): void
    {
        $this->value = $value;
    }
}
