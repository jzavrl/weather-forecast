<?php

namespace Drupal\manifesto_weather\EventSubscriber\Entity;

use Drupal\core_event_dispatcher\Event\Entity\EntityViewEvent;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Drupal\manifesto_weather\EventSubscriber\Field\WeatherForecastExtraFieldInfoSubscribers;
use Drupal\manifesto_weather\WeatherManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class WeatherForecastEntityViewSubscribers.
 */
class WeatherForecastEntityViewSubscribers implements EventSubscriberInterface {

  /**
   * Drupal\manifesto_weather\WeatherManager definition.
   *
   * @var \Drupal\manifesto_weather\WeatherManager
   */
  protected $weatherManager;

  /**
   * Constructs a new WeatherForecastEntityViewSubscribers object.
   *
   * @param \Drupal\manifesto_weather\WeatherManager $weather_manager
   *   The weather manager service.
   */
  public function __construct(WeatherManager $weather_manager) {
    $this->weatherManager = $weather_manager;
  }

  /**
   * Alter entity view.
   *
   * @param \Drupal\core_event_dispatcher\Event\Entity\EntityViewEvent $event
   *   The event.
   */
  public function entityView(EntityViewEvent $event): void {
    $entity = $event->getEntity();

    // Take the parameters from WeatherForecastExtraFieldInfoSubscribers in
    // which the pseudo field will be created and add the forecast markup into
    // it.
    if (
      $entity->getEntityTypeId() === WeatherForecastExtraFieldInfoSubscribers::ENTITY &&
      in_array($entity->bundle(), WeatherForecastExtraFieldInfoSubscribers::BUNDLES)
    ) {
      $build = &$event->getBuild();
      $build[WeatherForecastExtraFieldInfoSubscribers::FIELD_NAME] = $this->weatherManager->getWeatherForecast();
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents(): array {
    return [
      HookEventDispatcherInterface::ENTITY_VIEW => 'entityView',
    ];
  }

}
