<?php
/**
 * Created by PhpStorm.
 * User: wei gao
 * Email:1225039937@qq.com
 * Date: 2019-08-23
 * Time: 10:23
 */

namespace App\Support;


trait ModelOptionsHelper
{
    public static function getOptions($mapKey)
    {
        if (!property_exists(self::class, $mapKey) || !is_array(self::$$mapKey)) {
            return [];
        }
        $options = [];
        foreach (self::$$mapKey as $value => $label) {
            array_push($options, [
                'label' => $label,
                'value' => $value,
            ]);
        }
        return $options;
    }
}