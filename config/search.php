<?php
return [
    /**
     * Where the template is module
     *
     * @var string|null
     */
    'template_module' => 'search',

    /**
     * Where the template is directory
     *
     * @var string|null
     */
    'template_directory' => '',

    /**
     * Use a special template for this operator
     *
     * @var array
     * ex) type.operator => template_name
     */
    'extended_template_operations' => [
        'datetime.between' => 'datetime-between',
    ],
];
