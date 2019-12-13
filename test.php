<?php
/**
 * Created by PhpStorm.
 * User: wei gao
 * Email:1225039937@qq.com
 * Date: 2019-12-10
 * Time: 17:09
 */

$id = '96567';

$file = __DIR__."/{$id}.html";

if (!file_exists($file)) {
    file_put_contents($file, file_get_contents("https://www.135editor.com/editor_styles/{$id}.html"));
}

$str = file_get_contents($file);

preg_match("/(\<section.*\>[.|\r|\n]*\<\/section\>)/s", $str, $sections);

if (count($sections) == 0) {
    echo "未匹配section";
    return false;
}

$sectionStr = $sections[0];

preg_match_all("/src=\"(\S+?)\"\sdata-src=\"(\S+?)\"/", $sectionStr, $matches);

foreach ($matches as $match) {
    $tempStr = '==TEMPSTR==';
    $img_str = $match[0];
    $sectionStr = str_replace($img_str, $tempStr, $sectionStr);
    $img_str = str_replace($match[0], $match[1], $img_str);
    $sectionStr = str_replace($tempStr, $img_str, $sectionStr);
}



// img、video、audit src
// style background-image: url(url)
// style background: url(url)
