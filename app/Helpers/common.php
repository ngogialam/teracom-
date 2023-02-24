<?php

use App\Models\ProcessStep;

/**
 * To check before insert
 *
 * @param array $params
 * @return boolean
 */
function isGoodArrayBeforeInsert(array $params): bool
{
    $check = 0;
    foreach ($params as $key => $value) {
        if (!(is_array($value) || is_object($value))) {
            return false;
        }

        $count = count($value);
        if ($check == 0 || $count == $check) {
            $check = $count;
            continue;
        }
        return false;
    }
    return true;
}

/**
 * Check to remove null values
 *
 * @param array $params
 * @return array
 */
function abandonNulValue(array $params): array
{
    foreach ($params as $key => $value) {
        if ($value === null || $value === "") {
            unset($params[$key]);
        }
    }
    return $params;
}

/**
 * add day by timestamp
 *
 * @param integer $numberDate
 * @return int
 */
function addDay(int $numberDate = 5): int
{
    return $numberDate * 24 * 60 * 60;
}

/**
 * add hours,days,day working by sla
 *
 * @param integer $slaQuantity
 * @param integer $slaUnit
 * @param object $now
 * @return integer
 */
function convertSla(int $slaQuantity, int $slaUnit, object $now): int
{
    $date = 0;
    switch ($slaUnit) {
        case ProcessStep::SLA_UNIT_HOURS:
            $date = $now->addHours($slaQuantity);
            break;
        case ProcessStep::SLA_UNIT_DAY:
            $date = $now->addDays($slaQuantity);
            break;
        case ProcessStep::SLA_UNIT_DAY_WORK:
            $date = $now->addWeekdays($slaQuantity);
            break;
        default:
            break;
    }
    return $date !== 0 ? $date->timestamp : 0;
}

/**
 * @param \Carbon\Carbon|null|int $dateTime
 * @return int|null
 */
function convertTimeStamp(\Carbon\Carbon|null|int $dateTime): int|null
{
    if ($dateTime instanceof \Carbon\Carbon) {
        return $dateTime->timestamp;
    }
    return $dateTime;
}
