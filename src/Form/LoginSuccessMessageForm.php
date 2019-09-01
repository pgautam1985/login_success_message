<?php  
/**  
 * @file  
 * Contains Drupal\login_success_message\Form\LoginSuccessMessageForm.  
 */  
namespace Drupal\login_success_message\Form;  
use Drupal\Core\Form\ConfigFormBase;  
use Drupal\Core\Form\FormStateInterface;

class LoginSuccessMessageForm extends ConfigFormBase {  
  /**  
   * {@inheritdoc}  
   */  
  protected function getEditableConfigNames() {  
    return [  
      'login_success_message.adminsettings',  
    ];  
  }  

  /**  
   * {@inheritdoc}  
   */  
  public function getFormId() {  
    return 'login_success_message_form';  
  } 
  
  /**
   * 
   */
  public function getRoles(){
      return array_map(['\Drupal\Component\Utility\Html', 'escape'], user_role_names(TRUE));
  }

      /**  
   * {@inheritdoc}  
   */  
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('login_success_message.adminsettings');  

    foreach ($this->getRoles() as $key => $value){
        $form['login_success_message_' . $key] = [  
          '#type' => 'textarea',  
          '#title' => $this->t('Login Success Message for ' . $value),  
          '#description' => $this->t('Login Success Message display to users when they login as ' . $value),  
          '#default_value' => $config->get('login_success_message_' . $key),  
        ];
    }
    return parent::buildForm($form, $form_state);  
  }
  
   /**  
   * {@inheritdoc}  
   */  
  public function submitForm(array &$form, FormStateInterface $form_state) { 
    parent::submitForm($form, $form_state);  
  
    $this->config('login_success_message.adminsettings')  
      ->set('login_success_message', $form_state->getValue('login_success_message'))  
      ->save();  
  } 
}