<?php

namespace Drupal\daysuntil_service;

use Drupal\Core\Datetime\DrupalDateTime;
use \DateTime;
/**
 * DaysunitlService calculates days when the event is happening.
 * 
 */
class DaysuntilService {

  public function daysUntilHappening($eventDate) {
    $eventDate = new DateTime($eventDate);
    $currentDate = new DateTime();
    $days_until = ($eventDate)->diff($currentDate)->days;
    if ($eventDate < $currentDate) {  // diff returns always positive value
      $days_until = -$days_until;
    }
    return $days_until;
  }

}
