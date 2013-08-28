<?php
return array(
    'console' => array(
		'router' => array(
			'routes' => array(
			    'schedule-create' => array(
			        'options' => array(
			            'route' => 'schedule create <name>',
						'defaults' => array(
							'controller' => 'POYT\ReminderScheduler\Controller\Schedule',
							'action' => 'create',
						)
			        )
			    ),
			    'schedule-add-node' => array(
			        'options' => array(
			            'route' => 'schedule <schedule_id> add node <start_date> <expression>',
						'defaults' => array(
							'controller' => 'POYT\ReminderScheduler\Controller\Schedule',
							'action' => 'addNode'
						)
			        )
			    ),
			    'schedule-remove-node' => array(
			        'options' => array(
			            'route' => 'schedule remove node <node_id>',
						'defaults' => array(
							'controller' => 'POYT\ReminderScheduler\Controller\Schedule',
							'action' => 'removeNode'
						)
			        )
			    ),
			    'schedule-project' => array(
			        'options' => array(
			            'route' => 'schedule <schedule_id> project [<start_date>] [<end_date>]',
						'defaults' => array(
							'controller' => 'POYT\ReminderScheduler\Controller\Schedule',
							'action' => 'project',
							'start_date' => 'first day of this month',
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
	'view_manager' => array(
		'display_not_found_reason' => true,
		'display_exceptions'	   => true,
		'template_map' => array(),
		'template_path_stack' => array(
			__DIR__ . '/../view',
		),
	),
);
