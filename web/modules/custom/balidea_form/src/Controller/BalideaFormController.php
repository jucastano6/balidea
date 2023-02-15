<?php

namespace Drupal\balidea_form\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Defines a Balidea form controller.
 */
class BalideaFormController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function build() {
    $formConfig = $this->config('balidea_form.adminsettings');

    $build = [
      '#theme' => 'balidea-form-result',
      '#data' => [
        'text' => $formConfig->get('custom_html'),
        'number' => $formConfig->get('custom_number'),
      ],
    ];

    return $build;
  }

}
