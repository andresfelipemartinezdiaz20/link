<?php



namespace Drupal\form_example\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
/**
 * Implements an example form.
 */
class form extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'form_example_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['#attached']['library'][] = 'form_example/form_example_libraries';

    $form['datos_personales'] = array(
      '#type' => 'fieldset',
      '#title' => $this->t('Datos Personales'),
      '#attributes' => array(
        'class' => array('mi_clase')
      ),
    );

    $form['datos_personales']['nombre completo'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Digite el nombre'),
      //'#default_value' => $node->title,
      '#size' => 60,
      '#maxlength' => 128,
      '#required' => TRUE,
    );

    $form['datos_personales']['identificacion'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Digite su numero de identificación'),
      //'#default_value' => $node->title,
      '#pattern' => [0-9],
      '#required' => TRUE,
    );

    $form['datos_personales']['fecha de nacimiento'] = array(
      '#type' => 'date',
      '#title' => $this->t('Fecha de nacimiento'),
    );

    $form['datos_personales']['example_select'] = [
      '#type' => 'select',
      '#title' => $this ->t('cargo'),
      '#options' => [
        '1' => $this
          ->t('Administrador'),
        '2' => $this
          ->t('Webmaster'),
        '3' => $this
          ->t('Desarrollador'),
      ],
    ];

    $form['actions']['#type'] = 'actions';

    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Save'),
      '#button_type' => 'primary',
      '#attributes' => array(
        'class' => array('mibotonprincipal')
      ),
    );

    $form['actions']['cancelar'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Cancel'),
      '#submit' => array('form_example_cancelar'),
      '#limit_validation_errors' => array(),
      '#attributes' => array(
        'class' => array('mibotonprincipal')
      ),
    );






    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if (strlen($form_state->getValue('phone_number')) < 3) {
      $form_state->setErrorByName('phone_number', $this->t('Este número telefónico es muy corto, por favor digite su número telefónico completo.'));
    }


    $mystring = $form_state->getValue('email');
    $findme   = '@';
    $pos = strpos($mystring, $findme);

    // Nótese el uso de ===. Puesto que == simple no funcionará como se espera
    // porque la posición de 'a' está en el 1° (primer) caracter.
    if ($pos === false) {
      $form_state->setErrorByName('email', $this->t('Email no válido'));

    }






  }

  /**
   * {@inheritdoc}
   */



  public function submitForm(array &$form, FormStateInterface $form_state) {
    drupal_set_message($this->t('Su número telefónico es: @number', array('@number' => $form_state->getValue('phone_number'))));

    global $base_url;

    //dpm($base_url);

    $response = new RedirectResponse($base_url);
    $response->send();
    return;

  }

}
