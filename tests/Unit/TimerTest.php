<?php

namespace MrLinter\Metrics\Collectors\Tests\Unit;

use MrLinter\Contracts\Metrics\Subject;
use MrLinter\Metrics\Collectors\Timer;
use PHPUnit\Framework\TestCase;

final class TimerTest extends TestCase
{
    /**
     * @covers \MrLinter\Metrics\Collectors\Timer::__construct
     * @covers \MrLinter\Metrics\Collectors\Timer::start
     * @covers \MrLinter\Metrics\Collectors\Timer::collect
     * @covers \MrLinter\Metrics\Collectors\Timer::stop
     */
    public function test(): void
    {
        $subject = new Subject('', 'super-timer', '');
        $timer = new Timer($subject, [
            'a' => 'b',
        ]);

        $timer->start();

        usleep(1);

        $gotSnapshot = $timer->collect();

        self::assertArrayHasKey(0, $gotSnapshot->histograms);
        self::assertTrue(1.0 >= $gotSnapshot->histograms[0]->all()->last());
    }
}
