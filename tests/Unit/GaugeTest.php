<?php

namespace MrLinter\Metrics\Collectors\Tests\Unit;

use MrLinter\Contracts\Metrics\CounterRecord;
use MrLinter\Contracts\Metrics\GaugeRecord;
use MrLinter\Contracts\Metrics\Snapshot;
use MrLinter\Contracts\Metrics\Subject;
use MrLinter\Metrics\Collectors\Counter;
use MrLinter\Metrics\Collectors\Gauge;
use PHPUnit\Framework\TestCase;

final class GaugeTest extends TestCase
{
    /**
     * @covers \MrLinter\Metrics\Collectors\Gauge::__construct
     * @covers \MrLinter\Metrics\Collectors\Gauge::set
     * @covers \MrLinter\Metrics\Collectors\Gauge::collect
     */
    public function test(): void
    {
        $subject = new Subject('', 'super-gauge', '');
        $gauge = new Gauge($subject, [
            'a' => 'b',
        ]);

        $gauge->set(5);

        self::assertEquals(
            new Snapshot($subject, [], [
                new GaugeRecord('super-gauge', 5.0, [
                    'a' => 'b',
                ]),
            ], []),
            $gauge->collect(),
        );
    }
}
