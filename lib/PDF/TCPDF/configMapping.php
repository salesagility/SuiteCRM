<?php
return $configOptions = [
    'page_size' => $options['page_size'] ?? 'A4',
    'orientation' => $options['orientation'] ?? 'P',
    'unit' => $options['unit'] ?? 'mm',
    'default_font_size' => $options['fontSize'] ?? 0,
    'default_font' => $options['font'] ?? '',
    'mgl' => $options['mgl'] ?? 15,
    'mgr' => $options['mgr'] ?? 15,
    'mgt' => $options['mgt'] ?? 16,
    'mgb' => $options['mgb'] ?? 16,
    'mgh' => $options['mgh'] ?? 9,
    'mgf' => $options['mgf'] ?? 9,
    'image_scale' => $options['image_scale'] ?? 1.33,
];
