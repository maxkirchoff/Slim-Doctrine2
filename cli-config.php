<?php
namespace ShareBear;
/*
 * Doctrine cli tool bootstrap script
 * @see http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/tools.html#configuration-pear
 */
$src_dir = __DIR__."/src";

require "{$src_dir}/autoload.php";

$entityManager = null;
if ( ! class_exists("Doctrine\Common\Version", false)) {
    $entityManager = require_once "{$src_dir}/bootstrap_doctrine.php";
}

$helperSet = new \Symfony\Component\Console\Helper\HelperSet(array(
    'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($entityManager)
));