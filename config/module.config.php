<?php
return array(
    'console' => array(
		'router' => array(
			'routes' => array(
			    'schedule-project' => array(
			        'options' => array(
			            'route' => 'schedule project <schedule_id> [<start_date>] [<end_date>]',
						'defaults' => array(
							'controller' => 'POYT\ReminderScheduler\Controller\Schedule',
							'action' => 'project',
							'start_date' => null,
							'end_date' => null
						)
			        )
			    )
		    )
		)
	),
	'controllers' => array(
		'invokables' => array(
			'POYT\ReminderScheduler\Controller\Schedule' => 'POYT\ReminderScheduler\Controller\Schedule',
		),
	),
	'service_manager' => array(
		'invokables' => array(
			'POYT\ReminderScheduler\Service\Schedule' => '\POYT\ReminderScheduler\Service\Schedule',
			'POYT\ReminderScheduler\Service\Job' => '\POYT\ReminderScheduler\Service\Job'
		)
	),
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
