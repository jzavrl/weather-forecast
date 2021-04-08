<?php

namespace Drupal\manifesto_core\EventSubscriber\Form;

use Drupal\Core\Session\AccountInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\core_event_dispatcher\Event\Form\FormIdAlterEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class NodeArticleFormAlterSubscribers.
 */
class NodeArticleFormAlterSubscribers implements EventSubscriberInterface {

  use StringTranslationTrait;

  /**
   * Drupal\Core\Session\AccountInterface definition.
   *
   * @var \Drupal\Core\Session\AccountInterface
   */
  private $currentUser;

  /**
   * Constructs a new NodeArticleFormAlterSubscribers object.
   *
   * @param \Drupal\Core\Session\AccountInterface $current_user
   *   The current user service.
   */
  public function __construct(
    AccountInterface $current_user) {
    $this->currentUser = $current_user;
  }

  /**
   * Alter node article form.
   *
   * @param \Drupal\core_event_dispatcher\Event\Form\FormIdAlterEvent $event
   *   The event.
   */
  public function alterNodeArticleForm(FormIdAlterEvent $event): void {
    $form = &$event->getForm();

    // Show the title field description only for the Editor role.
    if (in_array('editor', $this->currentUser->getRoles())) {
      $form['title']['widget'][0]['value']['#description'] = $this->t('Lorem ipsum dolor sit amet, consectetur adipiscing elit.');
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents(): array {
    return [
      'hook_event_dispatcher.form_node_article_form.alter' => 'alterNodeArticleForm',
    ];
  }

}
