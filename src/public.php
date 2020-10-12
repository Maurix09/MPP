<?php
require_once __DIR__ . '/vendor/autoload.php';
$api = \Ubnt\UcrmPluginSdk\Service\UcrmApi::create();

    //Solamente queremos los del usuario que esta registrado. Asi que obtenemos datos
    // del usuario logueado.

$security = \Ubnt\UcrmPluginSdk\Service\UcrmSecurity::create();
$user = $security->getUser();

    // Debemos chequear que el usuario este conectado y que tenga permiso para ver los trabajos.
if (! $user || ! $user->hasViewPermission(\Ubnt\UcrmPluginSdk\Security\PermissionNames::SCHEDULING_MY_JOBS)) {
    die('Usted no tiene permisos para ver esta página.');
}

    //Ahora pedimos los trabajos del usuario y que esten abierto
$jobs = $api->get(
    'scheduling/jobs',
    [
        'statuses' => [0],
        'assignedUserId' => $user->userId,
    ]
);

    //Vamos a mostrar los trabajos
echo 'Usted tiene pendiente los siguientes trabajos:<br>';
echo '<ul>';
foreach ($jobs as $job) {
    echo sprintf('<li>%s</li>', htmlspecialchars($job['title'], ENT_QUOTES));
}
echo '</ul>';