<?php

namespace MrLinter\Metrics\Collectors;

/**
 * @template-extends Vector<Counter>
 */
class CounterVector extends Vector
{
    /**
     * @param array<string, string> $labels
     */
    public function add(array $labels): Counter
    {
        return $this->attach($labels, function (array $labels) {
            return new Counter($this->subject(), $labels);
        });
    }
}
