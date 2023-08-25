<?php
namespace App\Enums;
enum EventStatus: string
{
    case PROGRESS = 'progress';
    case FUTURE = 'future';
    case CONCLUDED = 'concluded';
    case CANCELED = 'canceled';
}
