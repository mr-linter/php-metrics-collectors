<?php

namespace MrLinter\Metrics\Collectors;

use MrLinter\Contracts\Metrics\CalculatedHistogramRecord;
use MrLinter\Contracts\Metrics\CalculatedNumberList;
use MrLinter\Contracts\Metrics\Snapshot;
use MrLinter\Contracts\Metrics\Subject;

class Timer extends Collector
{
    private float $started = -1;
    private float $time = -1;

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
        $this->stop();

        return new Snapshot($this->subject(), [], [], [
            new CalculatedHistogramRecord(
                $this->subject()->key,
                new CalculatedNumberList([$this->time], $this->time, 1),
                [],
                $this->labels,
            ),
        ]);
    }

    public function start(): void
    {
        if ($this->started > -1) {
            return;
        }

        $this->started = microtime(true);
    }

    public function stop(): void
    {
        if ($this->time > -1) {
            return;
        }

        $this->time = microtime(true) - $this->started;
    }
}
