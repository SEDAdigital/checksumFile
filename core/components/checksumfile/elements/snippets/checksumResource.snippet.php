<?php
$id = $modx->getOption('id', $scriptProperties, '');
if (empty($id)) return '';

$resource = $modx->getObject('modResource', $id);
if ($resource) {
    $date = $resource->get('editedon');
    $date = ($date) ? $date : $resource->get('createdon');
    $checksum = hash('crc32b', $date);
    if (!empty($checksum)) { 
        $url = $modx->makeUrl($id);
        return substr_replace($url, '.'.$checksum.'.', strrpos($url, '.'), 1);
    }
} 
return $modx->makeUrl($id);
