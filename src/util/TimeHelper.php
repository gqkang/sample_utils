<?php

/**
 * Created by PhpStorm.
 * User: apple
 * Date: 16/5/25
 * Time: 下午9:40
 */
class TimeHelper
{

    function beginOfHour($time = null)
    {
        if (!$time) {
            $time = time();
        }
        return strtotime(date('Y-m-d H:00:00', $time));
    }

    function endOfHour($time = null)
    {
        if (!$time) {
            $time = time();
        }
        return strtotime(date('Y-m-d H:59:59', $time));
    }

    function beginOfDay($time = null)
    {
        if (!$time) {
            $time = time();
        }
        return strtotime(date('Y-m-d 00:00:00', $time));
    }

    function endOfDay($time = null)
    {
        if (!$time) {
            $time = time();
        }

        return strtotime(date('Y-m-d 00:00:00', $time)) + 60 * 60 * 24 - 1;
    }

    function beginOfMonth($time = null)
    {
        if (is_null($time)) {
            $time = time();
        }
        return strtotime(date('Y-m-01 00:00:00', $time));
    }

    function endOfMonth($time = null)
    {
        if (is_null($time)) {
            $time = time();
        }

        return strtotime(date("Y-m-t 23:59:59", $time));
    }

    function beginOfYear($time)
    {
        if (!$time) {
            $time = time();
        }
        return strtotime(date('Y-01-01 00:00:00', $time));
    }

    function endOfYear($time)
    {
        if (!$time) {
            $time = time();
        }
        $year = date("Y", $time);
        $year += 1;
        return strtotime("{$year}-01-01 00:00:00") - 1;
    }

}