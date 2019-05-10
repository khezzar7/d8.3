<?php

namespace Drupal\annonce\EventSubscriber;


use Drupal\Component\Datetime\Time;
use Drupal\Core\Routing\CurrentRouteMatch;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\Event;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\Core\Session\AccountProxyInterface;

/**
 * Class DisplayThingsSubscriber.
 */
class DisplayThingsSubscriber implements EventSubscriberInterface {

  /**
   * Drupal\Core\Messenger\MessengerInterface definition.
   *
   * @var \Drupal\Core\Messenger\MessengerInterface
   */
  protected $messenger;
  /**
   * Drupal\Core\Session\AccountProxyInterface definition.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;

  protected $current_route_match;

  protected  $database;

  protected $time;

  /**
   * Constructs a new DisplayThingsSubscriber object.
   */
  public function __construct(MessengerInterface $messenger, AccountProxyInterface $current_user, CurrentRouteMatch $current_route_match,\Drupal\Core\Database\Driver\mysql\Connection $database,Time $time) {
    $this->messenger = $messenger;
    $this->currentUser = $current_user;
    $this->current_route_match=$current_route_match;
    $this->database= $database;
    $this->time= $time;
  }

  /**
   * {@inheritdoc}
   */
  static function getSubscribedEvents() {
    $events['kernel.request'] = ['request'];

    return $events;
  }

  /**
   * This method is called whenever the kernel.request event is
   * dispatched.
   *
   * @param GetResponseEvent $event
   */
  public function request(Event $event) {

    if ($this->current_route_match->getRouteName() == 'entity.annonce.canonical') {

      $this->messenger->addMessage(t('Entity Annonce'));

      $this->messenger->addMessage(t('Event for' . $this->currentUser->getDisplayName()), 'status');

      $this->database->insert('annonce_history')->fields([
        'uid' => $this->currentUser->id(),
        'aid' => $this->current_route_match->getParameter('annonce')->id(),
        'date' => $this->time->getCurrentTime(),
      ])->execute();

    }
  }
}
