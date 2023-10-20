<?php

namespace MrLinter\Metrics\Collectors;

use MrLinter\Contracts\Metrics\Collector as CollectorContract;
use MrLinter\Contracts\Metrics\Subject;

abstract class Collector implements CollectorContract
{
    public function __construct(
        private readonly Subject $subject,
    ) {
    }

    public function subject(): Subject
    {
        return $this->subject;
    }
}
