<?php

namespace Weather;

use Weather\Api\DataProvider;
use Weather\Api\DbRepository;
use Weather\Api\GoogleApi;
use Weather\Model\Weather;
use Weather\Api\WeatherApi;

class Manager
{
    /**
     * @var DataProvider
     */
    private $transporter;

    public function getTodayInfo(int $i): Weather
    {
        return $this->getTransporter($i)->selectByDate(new \DateTime());
    }

    public function getWeekInfo(int $i): array
    {
        return $this->getTransporter($i)->selectByRange(new \DateTime(), new \DateTime('+7 days'));
    }

    private function getTransporter(int $i)
    {
        if ($i === 1) {
            $this->transporter = new DbRepository();
        }
        if ($i === 2) {
            $this->transporter = new GoogleApi();
        }
        if ($i === 3) {
            $this->transporter = new WeatherApi();
        }

        return $this->transporter;
    }
}


