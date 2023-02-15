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
    $form['custom_html'] = [
      '#type' => 'text_format',
      '#description' => $this->t('Please type your informative text'),
      '#format' => $this->config('balidea_form.adminsettings')->get('custom_html')['format'],
      '#rows' => 6,
      '#default_value' => $this->config('balidea_form.adminsettings')->get('custom_html')['value'],
      '#suffix' => '<p class="item-html"></p>',
    ];

    $form['custom_number'] = [
      '#type' => 'number',
      '#description' => $this->t('Please type an integer number'),
      '#default_value' => $this->config('balidea_form.adminsettings')->get('custom_number'),
      '#suffix' => '<p class="item-number"></p>',
    ];

    $form['actions'] = [
      '#type' => 'button',
      '#value' => $this->t('Send'),
      '#ajax' => [
        'callback' => '::sendData',
      ],
      '#suffix' => '<p class="result-balidea"></p>',
    ];



    return $form;
  }

  /**
   * Collect and process the form data.
   */
  public function sendData(array &$form, FormStateInterface $form_state) {

    $custom_html = $form_state->getValue('custom_html')['value'];
    $custom_number = $form_state->getValue('custom_number');

    $response = new AjaxResponse();
    $error = 0;
    $msg = $this->t('Your number is a valid integer');
    if (!ctype_digit($custom_number)) {
      $msg = $this->t("Your number isn't a valid integer");
      $error = 1;
    }

    $response->addCommand(
          new HtmlCommand('.item-number', $msg)
    );
    $msg = $this->t('Your text is valid');
    if ($custom_html == "") {
      $msg = $this->t("Your text isn't valid");
      $error = 1;
    }

    $response->addCommand(
      new HtmlCommand('.item-html', $msg)
    );

    if (!$error) {
      $this->config('balidea_form.adminsettings')
        ->set('custom_html', $form_state->getValue('custom_html'))
        ->set('custom_number', $form_state->getValue('custom_number'))
        ->save();
      $msg = $this->t('The information has been saved');
    }
    else {
      $msg = $this->t('Please correct the information and try again');
    }

    $response->addCommand(
      new HtmlCommand('.result-balidea', $msg)
    );

    return $response;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
  }

}
