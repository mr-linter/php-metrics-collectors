<?php

namespace MrLinter\Metrics\Collectors;

use MrLinter\Contracts\Metrics\CounterRecord;
use MrLinter\Contracts\Metrics\Snapshot;
use MrLinter\Contracts\Metrics\Subject;

class Counter extends Collector
{
    private float $value = 0.0;

    /**
     * @param array<string, string> $labels
     */
    public function __construct(
        Subject $subject,
        private readonly array $labels = [],
    ) {
        parent::__construct($subject);
    }

    public function collect(): Snapshot
    {
        return new Snapshot(
            $this->subject(),
            [
                new CounterRecord($this->subject()->key, $this->value, $this->labels),
            ],
            [],
            [],
        );
    }

    public function inc(float $val = 1): void
    {
        $this->value += $val;
    }
}
