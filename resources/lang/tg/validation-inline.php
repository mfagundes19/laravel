<?php

/*
|--------------------------------------------------------------------------
| Validation Language Lines
|--------------------------------------------------------------------------
|
| The following language lines contain the default error messages used by
| the validator class. Some of these rules have multiple versions such
| as the size rules. Feel free to tweak each of these messages here.
|
*/

return [
    'accepted'             => 'Ин соҳа бояд қабул шудааст.',
    'accepted_if'          => 'This field must be accepted when :other is :value.',
    'active_url'           => 'Ин недопустимый URL-адрес.',
    'after'                => 'Бояд, ки ин сана пас аз соли :date.',
    'after_or_equal'       => 'Он бояд аз таърих пас аз он е баробар ба соли :date.',
    'alpha'                => 'Ин соҳа метавонад дар бар гирад, ки танҳо ҳарфҳои.',
    'alpha_dash'           => 'Ин соҳа метавонад дар бар гирад, ки танҳо ҳарфҳо, рақамҳо, тире ва подчеркивания.',
    'alpha_num'            => 'Ин соҳа метавонад дар бар гирад, ки танҳо ҳарфҳо ва рақамҳои.',
    'array'                => 'Ин соҳа бояд массивом.',
    'attached'             => 'Ин майдон аллакай прикреплено.',
    'before'               => 'Он бояд аз таърих, ки то соли :date.',
    'before_or_equal'      => 'Он бояд бошад, то санаи е баробар ба :date.',
    'between'              => [
        'array'   => 'This content must have between :min and :max items.',
        'file'    => 'This file must be between :min and :max kilobytes.',
        'numeric' => 'This value must be between :min and :max.',
        'string'  => 'This string must be between :min and :max characters.',
    ],
    'boolean'              => 'Ин соҳа бояд бошад, ҳақ е бардурӯғ.',
    'confirmed'            => 'Тасдиқи мувофиқ нест.',
    'current_password'     => 'The password is incorrect.',
    'date'                 => 'Ин действительная таърих.',
    'date_equals'          => 'Ин бояд сана, баробар ба :date сол.',
    'date_format'          => 'Ин ба формату :format.',
    'different'            => 'Ин аҳамият бояд фарқ аз :other.',
    'digits'               => 'Ин бояд :digits рақам.',
    'digits_between'       => 'Он бояд байни :min ва :max рақам.',
    'dimensions'           => 'Ин тасвир, ки дорои недопустимые андозаи.',
    'distinct'             => 'Дар ин соҳа дорад, ки бд, аҳамияти.',
    'email'                => 'Ин бояд воқеии суроғаи почтаи электронӣ.',
    'ends_with'            => 'Ин бояд заканчиваться яке аз нуқтаҳои зерин: :values.',
    'exists'               => 'Интихоб арзиши як недопустимым.',
    'file'                 => 'Маълумоте, ки бояд бошад, ки файли матнӣ намебошад.',
    'filled'               => 'Ин соҳа бояд дорои аҳамияти.',
    'gt'                   => [
        'array'   => 'The content must have more than :value items.',
        'file'    => 'The file size must be greater than :value kilobytes.',
        'numeric' => 'The value must be greater than :value.',
        'string'  => 'The string must be greater than :value characters.',
    ],
    'gte'                  => [
        'array'   => 'The content must have :value items or more.',
        'file'    => 'The file size must be greater than or equal :value kilobytes.',
        'numeric' => 'The value must be greater than or equal :value.',
        'string'  => 'The string must be greater than or equal :value characters.',
    ],
    'image'                => 'Ин бояд тасвир.',
    'in'                   => 'Интихоб арзиши як недопустимым.',
    'in_array'             => 'Ин муҳим нест, ки дар :other.',
    'integer'              => 'Ин бояд ба тамоми шумораи.',
    'ip'                   => 'Ин бояд воқеии IP-адрес.',
    'ipv4'                 => 'Ин бояд воқеии IPv4-адрес.',
    'ipv6'                 => 'Ин бояд воқеии IPv6-адрес.',
    'json'                 => 'Ин бояд допустимая сатри JSON.',
    'lt'                   => [
        'array'   => 'The content must have less than :value items.',
        'file'    => 'The file size must be less than :value kilobytes.',
        'numeric' => 'The value must be less than :value.',
        'string'  => 'The string must be less than :value characters.',
    ],
    'lte'                  => [
        'array'   => 'The content must not have more than :value items.',
        'file'    => 'The file size must be less than or equal :value kilobytes.',
        'numeric' => 'The value must be less than or equal :value.',
        'string'  => 'The string must be less than or equal :value characters.',
    ],
    'max'                  => [
        'array'   => 'The content may not have more than :max items.',
        'file'    => 'The file size may not be greater than :max kilobytes.',
        'numeric' => 'The value may not be greater than :max.',
        'string'  => 'The string may not be greater than :max characters.',
    ],
    'mimes'                => 'Он бояд бошад, навъи файл: :values.',
    'mimetypes'            => 'Он бояд бошад, навъи файл: :values.',
    'min'                  => [
        'array'   => 'The value must have at least :min items.',
        'file'    => 'The file size must be at least :min kilobytes.',
        'numeric' => 'The value must be at least :min.',
        'string'  => 'The string must be at least :min characters.',
    ],
    'multiple_of'          => 'Ин аҳамияти бояд multiples :value',
    'not_in'               => 'Интихоб арзиши як недопустимым.',
    'not_regex'            => 'Ин формат недопустим.',
    'numeric'              => 'Ин аст, бояд ба шумора.',
    'password'             => 'Рамз неверный.',
    'present'              => 'Ин майдон бояд ҳузур дошта.',
    'prohibited'           => 'Ин майдон манъ аст.',
    'prohibited_if'        => 'Ин соҳа аст, манъ, ки :other баробар :value.',
    'prohibited_unless'    => 'Ин майдон манъ аст, агар танҳо :other аст, дар :values.',
    'prohibits'            => 'This field prohibits :other from being present.',
    'regex'                => 'Ин формат недопустим.',
    'relatable'            => 'Ин соҳа метавонад на вобаста ба маълумотҳои захираҳо.',
    'required'             => 'Ин майдон ҳатмист.',
    'required_if'          => 'Ин майдон ҳатмист, агар :other баробар :value.',
    'required_unless'      => 'Ин майдон ҳатмист, агар танҳо дар соли :other аст, дар :values сол.',
    'required_with'        => 'Ин майдон ҳатмист ва ҳангоми мавҷуд будани :values.',
    'required_with_all'    => 'Ин майдон ҳатмист ва ҳангоми мавҷуд будани :values.',
    'required_without'     => 'Ин майдон ҳатмист, ки :values надорад.',
    'required_without_all' => 'Ин майдон ҳатмист, агар ҳеҷ яке аз :values на мазкур.',
    'same'                 => 'Аҳамияти ин соҳаи бояд совпадать бо оид ба аҳамияти ҳуқуқии аз :other.',
    'size'                 => [
        'array'   => 'The content must contain :size items.',
        'file'    => 'The file size must be :size kilobytes.',
        'numeric' => 'The value must be :size.',
        'string'  => 'The string must be :size characters.',
    ],
    'starts_with'          => 'Ин бояд бо оғоз мекунанд, ки бо яке аз нуқтаҳои зерин: :values.',
    'string'               => 'Ин аст, ки бояд струна.',
    'timezone'             => 'Ин бояд допустимая минтақаи.',
    'unique'               => 'Ин аллакай анҷом.',
    'uploaded'             => 'Ин нашуд зеркашӣ.',
    'url'                  => 'Ин формат недопустим.',
    'uuid'                 => 'Ин бояд воқеии UUID.',
    'custom'               => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],
];
