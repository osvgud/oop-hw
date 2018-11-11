<?php

namespace Weather\Controller;

use Weather\Manager;
use Weather\Model\NullWeather;

class StartPage
{
    public function getTodayWeather(int $transporterIndex): array
    {
        try {
            $service = new Manager;
            $weather = $service->getTodayInfo($transporterIndex);
        } catch (\Exception $exp) {
            $weather = new NullWeather();
        }

        return ['template' => 'today-weather.twig', 'context' => ['weather' => $weather]];
    }

    public function getWeekWeather(int $transporterIndex): array
    {
        try {
            $service = new Manager;
            $weathers = $service->getWeekInfo($transporterIndex);
        } catch (\Exception $exp) {
            $weathers = [];
        }

        return ['template' => 'range-weather.twig', 'context' => ['weathers' => $weathers]];
    }
}
