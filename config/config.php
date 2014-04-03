<?php


return new \Phalcon\Config(array(
    'database' => array(
        'adapter'     => 'Mysql',
        'host'        => 'localhost',
        'username'    => 'root',
        'password'    => '',
        'dbname'      => 'scheduler',
    ),
    'application' => array(
        'controllersDir' => APP_DIR . '/pages/controllers/',
        'modelsDir'      => APP_DIR . '/pages/models/',
        'viewsDir'       => APP_DIR . '/pages/views/',
        'baseDir'        => APP_DIR . '/base/',
        'libraryDir'     => APP_DIR . '/base/library/',
        'cacheDir'       => BASE_DIR . '/cache/',
        'baseUri'        => '/phalcon/scheduler/',
        'salt'           => '%j(0o)$|-|U@&+@+$15.^.11*/',
    ),
    'error_messages' => array(
        'required'           => "The %s field is required.",
        'valid_email'        => "The %s field must contain a valid email address.",
        'min_length'         => "The %s field must be at least %s characters in length.",
        'max_length'         => "The %s field can not exceed %s characters in length.",
        'exact_length'       => "The %s field must be exactly %s characters in length.",
        'alpha'              => "The %s field may only contain alphabetical characters.",
        'alpha_numeric'      => "The %s field may only contain alpha-numeric characters.",
        'alpha_dash'         => "The %s field may only contain alpha-numeric characters, underscores, and dashes.",
        'numeric'            => "The %s field must contain only numbers.",
        'regex_match'        => "The %s field is not in the correct format.",
        'matches'            => "The %s field does not match the %s field.",
        'is_unique'          => "The %s field must contain a unique value.",
        'is_natural'         => "The %s field must contain only positive numbers.",
        'is_natural_no_zero' => "The %s field must contain a number greater than zero.",
        'less_than'          => "The %s field must contain a number less than %s.",
        'greater_than'       => "The %s field must contain a number greater than %s."
    )
));