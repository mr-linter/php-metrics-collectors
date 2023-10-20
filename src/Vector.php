<?php

namespace MrLinter\Metrics\Collectors;

use MrLinter\Contracts\Metrics\Snapshot;
use MrLinter\Contracts\Metrics\Subject;

/**
 * @template C of \MrLinter\Contracts\Metrics\Collector
 */
abstract class Vector extends Collector
{
    /** @var array<string, C> */
    private array $collectors = [];

    public function __construct(
        Subject $subject,
    ) {
        parent::__construct($subject);
    }

    public function collect(): Snapshot
    {
        $counters = [];
        $gauges = [];
        $histograms = [];

        foreach ($this->collectors as $collector) {
            $snapshot = $collector->collect();

            foreach ($snapshot->counters as $counter) {
                $counters[] = $counter;
            }

            foreach ($snapshot->gauges as $gauge) {
                $gauges[] = $gauge;
            }

            foreach ($snapshot->histograms as $histogram) {
                $histograms[] = $histogram;
            }
        }

        return new Snapshot(
            $this->subject(),
            $counters,
            $gauges,
            $histograms,
        );
    }

    public function reset(): void
    {
        $this->collectors = [];
    }

    /**
     * @param array<string, string> $labels
     * @param callable(array<string, string> $labels): C $factory
     * @return C
     */
    final protected function attach(array $labels, callable $factory): \MrLinter\Contracts\Metrics\Collector
    {
        $hash = $this->hashLabels($labels);

        if (! array_key_exists($hash, $this->collectors)) {
            $this->collectors[$hash] = $factory($labels);
        }

        return $this->collectors[$hash];
    }

    /**
     * @param array<string, string> $labels
     */
    final protected function hashLabels(array $labels): string
    {
        $hash = '';

        foreach ($labels as $k => $v) {
            $hash .= "$k/$v";
        }

        return $hash;
    }
}
