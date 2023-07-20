<?php

return [

    'order_status_admin' => [
        'pending' => [
            'status' => 'Pendiente',
            'details' => 'Tu pedido está pendiente'
        ],
        'processed_and_ready_to_ship' => [
            'status' => 'Procesado y listo para enviar',
            'details' => 'Tu pedido ha sido procesado y será enviado pronto'
        ],
        'dropped_off' => [
            'status' => 'Dropped Off',
            'details' => 'Your package has been dropped off by the seller'
        ],
        'shipped' => [
            'status' => 'Enviado',
            'details' => 'Tu pedido ha sido enviado y pronto será recibido'
        ],
        'out_for_delivery' => [
            'status' => 'Out For Delivery',
            'details' => 'Our delivery partner will attempt to delivery your package'
        ],
        'delivered' => [
            'status' => 'Entregado',
            'details' => 'Entregado'
        ],
        'canceled' => [
            'status' => 'Cancelado',
            'details' => 'Cancelado'
        ]

    ],


    'order_status_vendor' => [
        'pending' => [
            'status' => 'Pendiente',
            'details' => 'Tu pedido aún está pendiente'
        ],
        'processed_and_ready_to_ship' => [
            'status' => 'Processed and ready to ship',
            'details' => 'Your pacakge has been processed and will be with our delivery parter soon'
        ]
    ]
];
