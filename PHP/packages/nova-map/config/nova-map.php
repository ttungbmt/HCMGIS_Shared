<?php

return [
    'config' => [
        'center' => [10.798347336391638, 106.66132766773595],
        'zoom' => 10,
        'zoomControl' => false
    ],
    'layers' => [
        [
            'control' => 'basemap',
            'type' => 'tile',
            'title' => 'Google',
            'options' => ['url' => 'http://mt2.google.com/vt/lyrs=m&x={x}&y={y}&z={z}'],
            'active' => true,
        ],
        [
            'control' => 'basemap',
            'type' => 'tile',
            'title' => 'Map4D',
            'options' => ['url' => 'http://rtile.map4d.vn/all/2d/{z}/{x}/{y}.png'],
        ],
    ]
];
