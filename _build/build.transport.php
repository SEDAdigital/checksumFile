<?php
/**
 * Quip build script
 *
 * @package checksumFile
 * @subpackage build
 */
$tstart = microtime(true);
set_time_limit(0); /* makes sure our script doesnt timeout */

require_once dirname(__FILE__) . '/build.config.php';
require_once MODX_CORE_PATH . 'model/modx/modx.class.php';

// Define build paths
$root = dirname(dirname(__FILE__)).'/';
$sources = array (
    'root' => $root,
    'build' => $root .'_build/',
    'source_core' => $root.'core/components/'.PKG_NAME_LOWER
);
unset($root); /* save memory */

// Instantiate modX
$modx= new modX();
$modx->initialize('mgr');
$modx->setLogLevel(modX::LOG_LEVEL_INFO);
$modx->setLogTarget(XPDO_CLI_MODE ? 'ECHO' : 'HTML');

$modx->loadClass('transport.modPackageBuilder','',false, true);
$builder = new modPackageBuilder($modx);
$builder->createPackage(PKG_NAME_LOWER, PKG_VERSION, PKG_RELEASE);
$builder->registerNamespace(PKG_NAME_LOWER, false, true, '{core_path}components/' . PKG_NAME_LOWER . '/');

// Create category
/** @var $category modCategory */
$category = $modx->newObject('modCategory');
$category->set('id', 1);
$category->set('category', PKG_NAME);

// Create snippet
/** @var $snippet modSnippet */
$modx->log(modX::LOG_LEVEL_INFO, 'Packaging snippet...');
$snippet = $modx->newObject('modSnippet');
$snippet->set('id',0);
$snippet->set('name', PKG_NAME);
$snippet->set('description', 'Create a checksum of any file in MODX and return a path with the checksum for cachebusting.');
$snippet->set('snippet',file_get_contents($sources['source_core'].'/snippet.'.PKG_NAME_LOWER.'.php'));

/* create category vehicle */
$attr = array(
    xPDOTransport::UNIQUE_KEY => 'category',
    xPDOTransport::PRESERVE_KEYS => false,
    xPDOTransport::UPDATE_OBJECT => true,
    xPDOTransport::RELATED_OBJECTS => true,
    xPDOTransport::RELATED_OBJECT_ATTRIBUTES => array (
        'Snippets' => array(
            xPDOTransport::PRESERVE_KEYS => false,
            xPDOTransport::UPDATE_OBJECT => true,
            xPDOTransport::UNIQUE_KEY => 'name',
        ),
    )
);
$vehicle = $builder->createVehicle($category, $attr);

$modx->log(modX::LOG_LEVEL_INFO, 'Adding file resolvers to category...');
$vehicle->resolve('file', [
    'source' => $sources['source_core'],
    'target' => "return MODX_CORE_PATH . 'components/';",
]);
$builder->putVehicle($vehicle);

// Now pack in the license file, readme and setup options
$modx->log(modX::LOG_LEVEL_INFO, 'Adding package attributes...');
$builder->setPackageAttributes([
    'license' => file_get_contents($sources['root'] . 'LICENSE'),
    'readme' => file_get_contents($sources['root'] . 'README.md'),
    'changelog' => file_get_contents($sources['root'] . 'CHANGELOG.md')
]);

// Zip up package
$modx->log(modX::LOG_LEVEL_INFO, 'Packing up transport package zip...');
$builder->pack();

$tend = microtime(true);
$totalTime = sprintf('%2.4f s', $tend - $tstart);
$modx->log(modX::LOG_LEVEL_INFO, "\n\nPackage Built. \nExecution time: {$totalTime}\n");
exit();
