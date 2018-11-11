<?php
/**
 * Created by PhpStorm.
 * User: osvgud
 * Date: 2018-11-11
 * Time: 15:11
 */

namespace Weather\Api;


use Weather\Model\Weather;
use Weather\Model\NullWeather;

class WeatherApi implements DataProvider
{
    /**
     * @param \DateTime $date
     * @return Weather
     */
    public function selectByDate(\DateTime $date): Weather
    {
        $items = $this->selectAll();
        $result = new NullWeather();

        foreach ($items as $item) {
            if ($item->getDate()->format('Y-m-d') === $date->format('Y-m-d')) {
                $result = $item;
            }
        }

        return $result;
    }

    /**
     * @param \DateTime $from
     * @param \DateTime $to
     * @return array
     */
    public function selectByRange(\DateTime $from, \DateTime $to): array
    {
        $items = $this->selectAll();
        $result = [];

        foreach ($items as $item) {
            if ($item->getDate() >= $from && $item->getDate() <= $to) {
                $result[] = $item;
            }
        }

        return $result;
    }

    private function selectAll(): array
    {
        $result = [];
        $data = json_decode(
            file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'Db' . DIRECTORY_SEPARATOR . 'Weather.json'),
            true
        );
        foreach ($data as $item) {
            $record = new Weather();
            $record->setDate(new \DateTime($item['date']));
            $record->setDayTemp($item['high']);
            $record->setNightTemp($item['low']);
            $record->setSky($this->skyAdapter($item['text']));
            $result[] = $record;
        }

        return $result;
    }

    //        1 => 'cloud',
    //        2 => 'cloud-rain',
    //        3 => 'sun'

    private function skyAdapter(string $sky): int
    {
        if($sky === 'Cloudy')
        {
            return 1;
        }
        elseif ($sky === 'Scattered Showers' || $sky === 'Mostly Cloudy' || $sky === 'Partly Cloudy')
        {
            return 2;
        }
        elseif ($sky === 'Breezy' || $sky === 'Sunny')
        {
            return 3;
        }
        return 0;
    }
}