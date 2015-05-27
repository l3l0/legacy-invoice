<?php

namespace L3l0Labs\Accounting\Invoice;

final class Period
{
    private $from;
    private $to;

    public function __construct(\DateTimeInterface $from, \DateTimeInterface $to)
    {
        if ($from > $to) {
            throw new \InvalidArgumentException(
                'From %s date should not be greater than To %s date',
                $from->format('Y-m-d h:i:s'),
                $to->format('Y-m-d h:i:s')
            );
        }

        $this->from = $from;
        $this->to = $to;
    }
}