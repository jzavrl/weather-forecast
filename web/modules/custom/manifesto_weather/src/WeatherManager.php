<?php

namespace Drupal\manifesto_weather;

use Drupal\Core\Config\ConfigManagerInterface;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\Core\State\StateInterface;
use GuzzleHttp\ClientInterface;

/**
 * Class WeatherManager.
 */
class WeatherManager {

  /**
   * Possible forecast outcomes.
   *
   * @var array
   */
  const FORECAST = [
    'sunny',
    'cloudy',
    'rainy',
  ];

  /**
   * GuzzleHttp\ClientInterface definition.
   *
   * @var \GuzzleHttp\ClientInterface
   */
  protected $httpClient;

  /**
   * Drupal\Core\Config\ConfigManagerInterface definition.
   *
   * @var \Drupal\Core\Config\ConfigManagerInterface
   */
  protected $configManager;

  /**
   * Drupal\Core\State\StateInterface definition.
   *
   * @var \Drupal\Core\State\StateInterface
   */
  protected $state;

  /**
   * @var \Drupal\Core\Logger\LoggerChannelFactoryInterface
   */
  private $logger;

  /**
   * Constructs a new WeatherManager object.
   *
   * @param \GuzzleHttp\ClientInterface $http_client
   *   The http client service.
   * @param \Drupal\Core\Config\ConfigManagerInterface $config_manager
   *   The config manager service.
   * @param \Drupal\Core\State\StateInterface $state
   *   The state manager service.
   * @param \Drupal\Core\Logger\LoggerChannelFactoryInterface $logger
   *   The logger service.
   */
  public function __construct(
    ClientInterface $http_client,
    ConfigManagerInterface $config_manager,
    StateInterface $state,
    LoggerChannelFactoryInterface $logger
  ) {
    $this->httpClient = $http_client;
    $this->configManager = $config_manager;
    $this->state = $state;
    $this->logger = $logger->get('manifesto_weather');
  }

  /**
   * Gets a weather forecast from the API.
   *
   * @param null $postcode
   *   The postcode value for the location.
   *
   * @return array
   *   Renderable array fore the forecast widget.
   */
  public function getWeatherForecast($postcode = NULL) {
    // The logic here can differ, mostly based on the service we use. If it
    // needs an authentication then we check if we have the details saved from
    // the form and if not log a message on that. Once we have them, try and
    // authenticate and then retrieve the values. Depending what it is, parse
    // those values and return them here. Also make sure we check if the return
    // from the API was successful. The postcode is NULL by default and we can
    // get it from the node entity or we could also make sure to set one as a
    // default in the configuration form. We have the needed services already
    // injected and the parsing would be done using the Json class (if it
    // returns a JSON format)

    // Return the weather forecast and also cache it for 2 hours. Hopefully
    // enough for the UK weather, but doubt it.
    return [
      '#theme' => 'manifesto_weather',
      '#forecast' => self::FORECAST[array_rand(self::FORECAST)],
      '#cache' => [
        'max-age' => 60 * 60 * 2,
      ],
    ];
  }

}
