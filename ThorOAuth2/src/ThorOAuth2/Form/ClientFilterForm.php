<?php
namespace ThorOAuth2\Form;

use Zend\InputFilter\InputFilter;


class ClientFilter extends InputFilter {

	public function __construct($emailValidator, $usernameValidator)
	{
		$this->add(array(
			'name' => 'client_id',
			'required'      => true,
			'validators'    => array(
				array(
					'name'      => 'StringLength',
					'options'   => array(
						'min'   => 3,
						'max'   => 255,
					),
				)
			),
		));
	}
}
