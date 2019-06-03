<?php
$file = $modx->getOption('file', $scriptProperties, '');
$copy = (bool)$modx->getOption('copy', $scriptProperties, 0);

if (empty($file)) {
    return '';
}

// calculate checksum
$checksum = hash_file('crc32b', MODX_BASE_PATH . $file);
if (empty($checksum)) {
    return $file;
}

// add checksum to file url
$bustedName = substr_replace($file, '.' . $checksum . '.', strrpos($file, '.'), 1);

if ($copy && !file_exists(MODX_BASE_PATH . $bustedName)) {
    if (@copy(MODX_BASE_PATH . $file, MODX_BASE_PATH . $bustedName)) {
        return $bustedName;
    } else {
        $modx->log(xPDO::LOG_LEVEL_ERROR, 'Can\'t copy ' . $file . ' to ' . $bustedName, '', 'checksumFile');
        return $file;
    }
} else {
    return $bustedName;
}
