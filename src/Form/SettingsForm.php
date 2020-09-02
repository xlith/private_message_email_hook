<?php

namespace Drupal\private_message_email_hook\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure Private Message Email Hook settings for this site.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'private_message_email_hook_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['private_message_email_hook.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['status'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Enabled'),
      '#default_value' => $this->config('private_message_email_hook.settings')
        ->get('status'),
      '#description' => 'Module status. Check if you want users to get emails when another user sends them private message.',
    ];
    $form['mail_title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Mail Title'),
      '#default_value' => $this->config('private_message_email_hook.settings')
        ->get('mail_title'),
    ];
    $form['mail_body'] = [
      '#type' => 'text_format',
      '#title' => $this->t('Mail Body'),
      '#format' => $this->config('private_message_email_hook.settings')
        ->get('mail_body')['format'],
      '#default_value' => $this->config('private_message_email_hook.settings')
        ->get('mail_body')['value'],
      '#description' => $this->t('You can use @user - @sender - @private_message_thread_url as variables.'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('private_message_email_hook.settings')
      ->set('mail_title', $form_state->getValue('mail_title'))
      ->save();
    $this->config('private_message_email_hook.settings')
      ->set('mail_body', $form_state->getValue('mail_body'))
      ->save();
    $this->config('private_message_email_hook.settings')
      ->set('status', $form_state->getValue('status'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
