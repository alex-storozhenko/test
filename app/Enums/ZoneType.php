<?php

namespace App\Enums;

enum ZoneType: string
{
    case DISTRICT = 'district';
    case NEIGHBORHOOD = 'neighborhood';
    case MUNICIPALITY = 'municipality';
    case REGION = 'region';
    case LOCATION = 'location';
}
