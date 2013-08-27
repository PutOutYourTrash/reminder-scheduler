<?php
return array(
    'doctrine' => array(
		'driver' => array(
			'poyt_reminder_scheduler_entities' => array(
				'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
				'cache' => 'array',
				'paths' => array(
					__DIR__.'/../src/POYT/ReminderScheduler/Entity'
				),
			),
			'orm_default' => array(
				'drivers' => array(
					'POYT\ReminderScheduler\Entity' => 'poyt_reminder_scheduler_entities'
				)
			)
		)
	),
);
