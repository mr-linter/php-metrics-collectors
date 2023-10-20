<?php

namespace MrLinter\Metrics\Collectors\Tests\Unit;

use MrLinter\Contracts\Metrics\CounterRecord;
use MrLinter\Contracts\Metrics\Snapshot;
use MrLinter\Contracts\Metrics\Subject;
use MrLinter\Metrics\Collectors\Counter;
use PHPUnit\Framework\TestCase;

final class CounterTest extends TestCase
{
    /**
     * @covers \MrLinter\Metrics\Collectors\Counter::__construct
     * @covers \MrLinter\Metrics\Collectors\Counter::inc
     * @covers \MrLinter\Metrics\Collectors\Counter::collect
     */
    public function test(): void
    {
        $subject = new Subject('', 'super-counter', '');
        $counter = new Counter($subject, [
            'a' => 'b',
        ]);

        $counter->inc(2);
        $counter->inc(2);

        self::assertEquals(
            new Snapshot($subject, [
                new CounterRecord('super-counter', 4.0, [
                    'a' => 'b',
                ]),
            ], [], []),
            $counter->collect(),
        );
    }
}
