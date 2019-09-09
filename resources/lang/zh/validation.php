<?php

return [

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

    'accepted'             => ':attribute 必须为已接受',
    'active_url'           => ':attribute 不是有效的 URL',
    'after'                => ':attribute 必须大于 :date',
    'after_or_equal'       => ':attribute 必须大于或等于 :date',
    'alpha'                => ':attribute 可接受类型：字母',
    'alpha_dash'           => ':attribute 可接受类型：字母、数字、短划线和下划线',
    'alpha_num'            => ':attribute 可接受类型：字母、数字',
    'array'                => ':attribute 可接受类型：数组',
    'before'               => ':attribute 必须小于 :date',
    'before_or_equal'      => ':attribute 必须小于或等于 :date',
    'between'              => [
        'numeric' => ':attribute 必须介于 [:min - :max] 之间',
        'file'    => ':attribute 最小：:min KB，最大：:max KB',
        'string'  => ':attribute 最少：:min 个字符，最多：:max 个字符',
        'array'   => ':attribute 最少：:min 项，最多：:max 项',
    ],
    'boolean'              => ':attribute 可接受类型：是 或 否',
    'confirmed'            => 'The :attribute confirmation does not match.',
    'date'                 => ':attribute 不是有效的日期',
    'date_format'          => ':attribute 格式错误，格式：:format.',
    'different'            => ':attribute 不能等于 :other',
    'digits'               => ':attribute 必须是 :digits 位数',
    'digits_between'       => ':attribute 最少 :min 位数，最多：:max 位数',
    'dimensions'           => ':attribute 图片尺寸不匹配',
    'distinct'             => ':attribute 已存在相同的选项',
    'email'                => ':attribute 不是有效的邮箱地址',
    'exists'               => '不存在的选项：:attribute',
    'file'                 => ':attribute 必须是一个有效的文件',
    'filled'               => ':attribute 必须填写',
    'gt'                   => [
        'numeric' => ':attribute 必须大于 :value.',
        'file'    => ':attribute 必须大于 :value KB',
        'string'  => ':attribute 必须大于 :value 个字符',
        'array'   => ':attribute 必须大于 :value 项',
    ],
    'gte'                  => [
        'numeric' => ':attribute 必须大于或等于 :value',
        'file'    => ':attribute 必须大于或等于 :value KB',
        'string'  => ':attribute 必须大于或等于 :value 个字符',
        'array'   => ':attribute 必须大于或等于 :value 项',
    ],
    'image'                => ':attribute 必须是一个图像',
    'in'                   => ':attribute 不是一个有效的值',
    'in_array'             => ':other 不包含 :attribute',
    'integer'              => ':attribute 必须是整数',
    'ip'                   => ':attribute 无效的 IP 地址',
    'ipv4'                 => ':attribute 无效的 IPv4 地址',
    'ipv6'                 => ':attribute 无效的 IPv6 地址',
    'json'                 => ':attribute 无效的 JSON 字符串',
    'lt'                   => [
        'numeric' => ':attribute 必须小于 :value.',
        'file'    => ':attribute 必须小于 :value KB',
        'string'  => ':attribute 必须小于 :value 个字符',
        'array'   => ':attribute 必须小于 :value 项',
    ],
    'lte'                  => [
        'numeric' => ':attribute 必须小于或等于 :value',
        'file'    => ':attribute 必须小于或等于 :value KB',
        'string'  => ':attribute 必须小于或等于 :value 个字符',
        'array'   => ':attribute 必须小于或等于 :value 项',
    ],
    'max'                  => [
        'numeric' => ':attribute 不能大于 :max',
        'file'    => ':attribute 不能大于 :max KB',
        'string'  => ':attribute 不能大于 :max 个字符',
        'array'   => ':attribute 不能多于 :max 项',
    ],
    'mimes'                => ':attribute 的文件类型必须是: :values.',
    'mimetypes'            => ':attribute 的文件类型必须是: :values.',
    'min'                  => [
        'numeric' => ':attribute 最小值：:min.',
        'file'    => ':attribute 不能小于 :min KB',
        'string'  => ':attribute 最少 :min 个字符',
        'array'   => ':attribute 最少包含 :min 项',
    ],
    'not_in'               => '当前选项 :attribute 无效',
    'not_regex'            => ':attribute 格式错误',
    'numeric'              => ':attribute 必须是数值',
    'present'              => ':attribute 必须存在',
    'regex'                => ':attribute 格式错误',
    'required'             => '必须指定：:attribute',
    'required_if'          => '当 :other 等于 :value 时，必须指定：:attribute',
    'required_unless'      => '除非 :values 包含 :other，否则必须指定：:attribute',
    'required_with'        => '当 :values 存在时，必须指定：:attribute',
    'required_with_all'    => '当 :values 存在时，必须指定：:attribute',
    'required_without'     => '当 :values 不存在时，必须指定：:attribute',
    'required_without_all' => '当 :values 未指定时，必须指定：:attribute',
    'same'                 => ':attribute 必须与 :other 相匹配',
    'size'                 => [
        'numeric' => ':attribute 必须是 :size',
        'file'    => ':attribute 必须是 :size KB',
        'string'  => ':attribute 必须是 :size 个字符',
        'array'   => ':attribute 必须是 :size 项',
    ],
    'string'               => ':attribute 必须是字符串',
    'timezone'             => ':attribute 必须是有效的时区',
    'unique'               => ':attribute 不能与已存在的项相同',
    'uploaded'             => ':attribute 上传失败',
    'url'                  => ':attribute 格式错误',
    'uuid'                 => ':attribute 无效的 UUID 格式',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'username'                 => '用户名',
        'password'                 => '密码',
        'old_password'             => '原密码',
    ],

];