<?php

namespace Volosatov;

class WorkHours
{
    public function addHours ($date, $hours)
    {
        $time = strtotime ($date); // переводим дату в секунды
        for ($j = 0; $j < $hours; $j ++) // в цикле добавляем по часу
            $time = $this -> addHour ($time);
        return date ("Y-m-d H:i:s", $time); // конвертируем в дату
    }

    private function addHour ($time)
    {
        do
            $time += 3600;
        while ($this -> isWeekend ($time) // выходной
            || $this -> isHolyday ($time) // праздник
            || $this -> isOfftime ($time)); // нерабочий час
        return $time;
    }

    private $offtimes = array (
        0, 1, 2, 3, 4, 5, 6, 7, 8, 9, // утром
        13,  // обед
        19, 20, 21, 22, 23); // вечером

    private function isOfftime ($time)
    {
        return in_array (date ("G", $time),  // час без ведущего нуля
            $this -> offtimes);  // список нерабочих часов
    }

    private $weekends = array ("Sat", "Sun");

    private function isWeekend ($time)
    {
        return in_array (date ("D", $time), // буквенный код дня недели
            $this -> weekends); // список выходных дней недели
    }

    private $holydays = array (
        "2018-01-01",  "2018-01-02",  "2018-01-03",
        "2018-01-04",  "2018-01-05",  "2018-01-06",
        "2018-01-07",  "2018-01-08",  "2018-02-23", 
        "2018-03-08");

    private function isHolyday ($time)
    {
        return in_array (date ("Y-m-d", $time), // конвертируем в дату
            $this -> holydays); // ищем в списке праздников
    }
}