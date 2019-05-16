<?php

namespace Drupal\hello\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class HelloSubscriber.
 */
class HelloSubscriber implements EventSubscriberInterface {


  /**
   * Constructs a new HelloSubscriber object.
   */
  public function __construct() {

  }

  /**
   * {@inheritdoc}
   */
  static function getSubscribedEvents() {

    return $events;
  }


}
