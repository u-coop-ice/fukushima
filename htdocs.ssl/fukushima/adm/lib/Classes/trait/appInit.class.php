<?php
Trait appInit {

	protected $_fields_regist = [
		'dept' => 'integer',
		'name' => 'text',
		'address' => [],
		'membership' => 'text',
		'sex' => 'integer',
		'age' => 'text',
		'new_add' => 'text',
		'student_phone' => 'text',
		'mobilephone' => 'text',
		'address' => 'text',
		'phonenumber' => 'text',
	];

	protected $_fields_regist_must = [
		'dept' => 'integer',
		'name' => 'text',
		'address' => 'text',
		'phonenumber' => 'text',
		'new_add' => 'text',
	];

	protected $_fields_init_regist = [
		'name' => 'text',
		'password2' => 'text',
		'passwordcfrm' => 'text',
	];

	protected $_fields_init_regist_must = [
		'name' => 'text',
		'password2' => 'text',
		'passwordcfrm' => 'text',
	];

	protected $_fields_ask = [
		'title' => 'text',
		'ask' => 'text',
	];

}
?>
