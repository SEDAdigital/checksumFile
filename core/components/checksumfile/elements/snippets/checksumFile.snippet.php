<?php
$file = $modx->getOption('file', $scriptProperties, '');
if (empty($file)) return '';

// calculate checksum
$checksum = hash_file('crc32b', MODX_BASE_PATH.$file);
if (empty($checksum)) return $file;

// add checksum to file url
return substr_replace($file, '.'.$checksum.'.', strrpos($file, '.'), 1);
