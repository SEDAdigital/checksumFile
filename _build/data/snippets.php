<?php
/**
 * @var modX $modx
 * @var array $sources
 */

/** @var modSnippet[] $snippets */
$snippets = [];
$i = 0;

$snippets[$i] = $modx->newObject('modSnippet');
$snippets[$i]->fromArray([
    'name' => 'checksumFile',
    'description' => 'Create a checksum of any file in MODX and return a path with the checksum for cachebusting.',
    'snippet' => getPHPContent($sources['source_core'] . '/elements/snippets/checksumFile.snippet.php'),
], '', true, true);

return $snippets;
