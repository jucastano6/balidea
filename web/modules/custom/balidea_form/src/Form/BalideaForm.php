<?php

namespace Drupal\balidea_form\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;

/**
 * Configure Balidea Form settings for this site.
 */
class BalideaForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'balidea_form.adminsettings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['balidea_form.adminsettings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildForm($form, $form_state);

    $form['custom_html'] = [
      '#type' => 'text_format',
      '#title' => $this->t('Custom Text'),
      '#description' => $this->t('Please type your informative text'),
      '#format' => $this->config('balidea_form.adminsettings')->get('custom_html')['format'],
      '#rows' => 6,
      '#default_value' => $this->config('balidea_form.adminsettings')->get('custom_html')['value'],
      '#suffix' => '<p class="item-html"></p>',
    ];

    $form['custom_number'] = [
      '#type' => 'number',
      '#title' => $this->t('Custom Number'),
      '#description' => $this->t('Please type an integer number'),
      '#default_value' => $this->config('balidea_form.adminsettings')->get('custom_number'),
      '#suffix' => '<p class="item-number"></p>',
    ];

    return $form;
  }

   /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $custom_number = $form_state->getValue('custom_number');
    // Check if every characters of custom_number are digits.
    if (!ctype_digit($custom_number)) {
      $form_state->setErrorByName('custom_number', $this->t('Please type a valid integer number'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Get the editable config.
    $settings = $this->configFactory->getEditable('balidea_form.adminsettings');
    // Set form values.
    $settings
      ->set('custom_html', $form_state->getValue('custom_html'))
      ->set('custom_number', $form_state->getValue('custom_number'))
      ->save();
    $this->messenger()->addStatus('The information has been saved.');
  }

}
