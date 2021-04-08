<?php

namespace Drupal\manifesto_weather\EventSubscriber\Field;

use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\core_event_dispatcher\Event\Entity\EntityExtraFieldInfoEvent;
use Drupal\hook_event_dispatcher\HookEventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class WeatherForecastExtraFieldInfoSubscribers.
 */
class WeatherForecastExtraFieldInfoSubscribers implements EventSubscriberInterface {

  use StringTranslationTrait;

  /**
   * Array of bundles to add the field into.
   *
   * @var array
   */
  public const BUNDLES = [
    'article',
  ];

  /**
   * The entity type for the field.
   *
   * @var string
   */
  public const ENTITY = 'node';

  /**
   * The field machine name.
   *
   * @var string
   */
  public const FIELD_NAME = 'weather_forecast';

  /**
   * Entity extra field info.
   *
   * @param \Drupal\core_event_dispatcher\Event\Entity\EntityExtraFieldInfoEvent $event
   *   The event.
   */
  public function fieldInfo(EntityExtraFieldInfoEvent $event): void {
    // Adds a new field into the entity.
    foreach (self::BUNDLES as $bundle) {
      $event->addDisplayFieldInfo(self::ENTITY, $bundle, self::FIELD_NAME, []);
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents(): array {
    return [
      HookEventDispatcherInterface::ENTITY_EXTRA_FIELD_INFO => 'fieldInfo',
    ];
  }

}
