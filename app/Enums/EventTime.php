<?php
namespace App\Enums;
enum EventTime: string
{
    case EVENTS_ALL = 'events_all';
    case EVENTS_YEAR = 'events_year';
    case EVENTS_MONTH = 'events_month';
    case EVENTS_FUTURE = 'events_future';
}
