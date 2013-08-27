<?php
return array(
    'doctrine' => array(
		'driver' => array(
			'application_entities' => array(
				'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
				'cache' => 'array',
				'paths' => array(
					__DIR__.'/../src/POYT/ReminderScheduler/Entity'
				),
			),
			'orm_default' => array(
				'drivers' => array(
					'POYT\ReminderScheduler\Entity' => 'application_entities'
				)
			)
		)
	),
);
