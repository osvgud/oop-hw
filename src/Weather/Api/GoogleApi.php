<?php

namespace Weather\Api;

use Weather\Model\NullWeather;
use Weather\Model\Weather;

class GoogleApi
{
    /**
     * @param \DateTime $date
     * @return Weather
     * @throws \Exception
     */
    public function selectByDate(\DateTime $date)
    {
        $day = $this->load(new NullWeather(), $date);

        return $day;
    }

    public function selectByRange(\DateTime $from, \DateTime $to): array
    {
        $iterator = $from;
        $iterator->modify('+1 day');
        $result = [];

        while($iterator < $to)
        {
            $day = $this->load(new NullWeather(), $from);
            $result[] = $day;
            date_add($iterator, date_interval_create_from_date_string('1 day'));
        }
        return $result;
    }

    /**
     * @param Weather $before
     * @param \DateTime $date
     * @return Weather
     * @throws \Exception
     */
    private function load(Weather $before, \DateTime $date)
    {
        $now = new Weather();
        $now->setDate($date);
        $base = $before->getDayTemp();
        $now->setDayTemp(random_int(5 - $base, 5 + $base));

        $base = $before->getNightTemp();
        $now->setNightTemp(random_int(-5 - abs($base), -5 + abs($base)));

        $now->setSky(random_int(1, 3));
        return $now;
    }
}
