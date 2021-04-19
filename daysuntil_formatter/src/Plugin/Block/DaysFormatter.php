<?php

namespace Drupal\daysuntil_formatter\Plugin\Block;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Block\BlockBase;
use \DateTime;
/**
 * Provides a 'Days until event' Block.
 *
 * @Block(
 *   id = "daysuntil_block",
 *   admin_label = @Translation("DaysUntil block"),
 *   category = @Translation("Displays formatted sting when the event is happening"),
 * )
 */
class DaysFormatter extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $node = \Drupal::routeMatch()->getParameter('node');
    $event_date = new DrupalDateTime($node->field_date->value, 'UTC');
    
    return [
      '#markup' =>$this->display($event_date),
      '#cache' => [
        'max-age' => 0
      ],
    ];
  }

  /**
   * Call service which calculates days until event is happening and 
   * format the value depending on the event in the past, present of future.
   * 
   * If event is happening today it displays 'This event is happening today'.
   * If event is happening in future it displays number of 'days until event starts'.
   * If event already happened in the past it dispays 'This event has passed'.
   */
  public function display($event_date){
    $format_service = \Drupal::service('daysuntil_service.daysuntil');
    $days = $format_service->daysUntilHappening($event_date);
    if ($days == 0) {
      return "This event is happening today.";
    }
    elseif ($days > 0) {
        return $days." days until events starts.";
    }
    else {
        return "This event has passed.";
    }
  }
}
