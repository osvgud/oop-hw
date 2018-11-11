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

    public function getTodayInfo(): Weather
    {
        return $this->getTransporter()->selectByDate(new \DateTime());
    }

    public function getWeekInfo(): array
    {
        return $this->getTransporter()->selectByRange(new \DateTime(), new \DateTime('+7 days'));
    }

    private function getTransporter()
    {
//        if (null === $this->transporter) {
//            $this->transporter = new DbRepository();
//        }
//        if (null === $this->transporter) {
//            $this->transporter = new GoogleApi();
//        }
        if (null === $this->transporter) {
            $this->transporter = new WeatherApi();
        }

        return $this->transporter;
    }
}


