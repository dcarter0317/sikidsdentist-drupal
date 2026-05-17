<?php

namespace Drupal\form_decorator;

use Drupal\Core\Form\FormBuilder;
use Drupal\Core\Form\FormStateInterface;

/**
 * Add decorators to form objects.
 */
class FormDecoratorFormBuilder extends FormBuilder {

  /**
   * The form decorator plugin manager.
   *
   * @var \Drupal\form_decorator\FormDecoratorPluginManager
   */
  protected $formDecoratorManager;

  /**
   * Constructs a new FormDecoratorFormBuilder.
   *
   * @param \Drupal\form_decorator\FormDecoratorPluginManager $form_decorator_manager
   *   The form decorator plugin manager.
   * @param mixed ...$args
   *   All other arguments.
   */
  public function __construct(
    FormDecoratorPluginManager $form_decorator_manager,
    ...$args,
  ) {
    parent::__construct(...$args);
    $this->formDecoratorManager = $form_decorator_manager;
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId($form_arg, FormStateInterface &$form_state) {
    // Unfortunately we have to extend the FormBuilder class.
    // The buildForm method directly calls this method.
    parent::getFormId($form_arg, $form_state);
    $form_arg = $form_state->getFormObject();

    $definitions = $this->formDecoratorManager->getDefinitions();

    // Decorate Forms that have a matching hook.
    foreach (array_keys($definitions) as $id) {
      /** @var \Drupal\form_decorator\FormDecoratorInterface $instance */
      $instance = $this->formDecoratorManager->createInstance($id);
      $instance->setInner($form_arg);
      if ($instance->applies()) {
        $form_arg = $instance;
      }
    }

    $form_state->setFormObject($form_arg);
    return $form_arg->getFormId();
  }

}
