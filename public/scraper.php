<?php

$serverName = 'localhost';
$userName = "root";
$password = "";
$dbname = 'deb140017_dbs';

$connection = new mysqli($serverName, $userName, $password, $dbname);

$word_Sql = $connection->query('select * from dictionary');

$words = array();
while ($row = mysqli_fetch_assoc($word_Sql)) {
    $words[] = $row;
}

$url = 'https://rss.politie.nl/rss/algemeen/nb/alle-nieuwsberichten.xml';
$buffer = file_get_contents($url);

$res = xmlToArray($buffer);
$data = array();
if (isset($res['rss']['channel']['item'])) {
    $items = $res['rss']['channel']['item'];
    $sqlValues = "";
    foreach ($items as $item) {
        // check exists or not in database
        $check = $connection->query("select id from news where post_url='{$item['link']}'");
        $check_num_rows = mysqli_num_rows($check);
        $news = mysqli_fetch_array($check);

        if ($check_num_rows > 0) {
            if ($news["id"] > 0) {
                continue;
            }
        }
        $row['title'] = addslashes($item['title']);
        $row['link'] = $item['link'];
        $row['description'] = addslashes($item['description']);
        $datetime = str_replace('T', ' ', $item['dc:date']);
        $datetime = str_replace('Z', '', $datetime);
        $row['pudate'] = $datetime;
        $row['content'] = '';
        $content = '';
        if (isset($item['content:items']['rdf:Bag']['rdf:li']['content:item']['rdf:value'])) {
            $row['content'] = addslashes($item['content:items']['rdf:Bag']['rdf:li']['content:item']['rdf:value']);
            $content = $item['content:items']['rdf:Bag']['rdf:li']['content:item']['rdf:value'];
        }

        $image = get_news_image($item['title'], $item['description'], $content, $words);
        $row['image'] = $image[0];
        $row['tag'] = $image[1];

        $row['lat'] = (isset($item['geo:lat']) ? $item['geo:lat'] : '');
        $row['lon'] = (isset($item['geo:long']) ? $item['geo:long'] : '');

        $loc = location($row['lat'], $row['lon']);
        $slug = slug($row["title"]);


        $sqlValues.="('{$row["title"]}','{$row['link']}','{$row['pudate']}','{$row['description']}','{$row['content']}','{$slug}','{$row['lat']}','{$row['lon']}','{$row['tag']}','{$loc['state']}','{$loc['city']}','{$loc['staddress']}','{$loc['postal']}','{$row['image']}'),";;

    }

    if(!empty($sqlValues)){
        $sqlValues=rtrim($sqlValues,',');
        $sql="INSERT INTO  news (title,post_url,pubdate,description,content,slug,lat,lon,tags,state,city,staddress,postal,image)
        values ".$sqlValues;
        $insert = $connection->query($sql);
        echo'ok';
    }



}

function xmlToArray($contents, $getAttributes = true, $tagPriority = true, $encoding = 'utf-8')
{
    $contents = trim($contents);
    if (empty($contents)) {
        return [];
    }
    $parser = xml_parser_create('');
    xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, $encoding);
    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
    if (xml_parse_into_struct($parser, $contents, $xmlValues) === 0) {
        xml_parser_free($parser);

        return [];
    }
    xml_parser_free($parser);
    if (empty($xmlValues)) {
        return [];
    }
    unset($contents, $parser);
    $xmlArray = [];
    $current = &$xmlArray;
    $repeatedTagIndex = [];
    foreach ($xmlValues as $num => $xmlTag) {
        $result = null;
        $attributesData = null;
        if (isset($xmlTag['value'])) {
            if ($tagPriority) {
                $result = $xmlTag['value'];
            } else {
                $result['value'] = $xmlTag['value'];
            }
        }
        if (isset($xmlTag['attributes']) and $getAttributes) {
            foreach ($xmlTag['attributes'] as $attr => $val) {
                if ($tagPriority) {
                    $attributesData[$attr] = $val;
                } else {
                    $result['@attributes'][$attr] = $val;
                }
            }
        }
        if ($xmlTag['type'] == 'open') {
            $parent[$xmlTag['level'] - 1] = &$current;
            if (!is_array($current) or (!in_array($xmlTag['tag'], array_keys($current)))) {
                $current[$xmlTag['tag']] = $result;
                unset($result);
                if ($attributesData) {
                    $current['@' . $xmlTag['tag']] = $attributesData;
                }
                $repeatedTagIndex[$xmlTag['tag'] . '_' . $xmlTag['level']] = 1;
                $current = &$current[$xmlTag['tag']];
            } else {
                if (isset($current[$xmlTag['tag']]['0'])) {
                    $current[$xmlTag['tag']][$repeatedTagIndex[$xmlTag['tag'] . '_' . $xmlTag['level']]] = $result;
                    unset($result);
                    if ($attributesData) {
                        if (isset($repeatedTagIndex['@' . $xmlTag['tag'] . '_' . $xmlTag['level']])) {
                            $current[$xmlTag['tag']][$repeatedTagIndex['@' . $xmlTag['tag'] . '_' . $xmlTag['level']]] = $attributesData;
                        }
                    }
                    $repeatedTagIndex[$xmlTag['tag'] . '_' . $xmlTag['level']] += 1;
                } else {
                    $current[$xmlTag['tag']] = [$current[$xmlTag['tag']], $result];
                    unset($result);
                    $repeatedTagIndex[$xmlTag['tag'] . '_' . $xmlTag['level']] = 2;
                    if (isset($current['@' . $xmlTag['tag']])) {
                        $current[$xmlTag['tag']]['@0'] = $current['@' . $xmlTag['tag']];
                        unset($current['@' . $xmlTag['tag']]);
                    }
                    if ($attributesData) {
                        $current[$xmlTag['tag']]['@1'] = $attributesData;
                    }
                }
                $lastItemIndex = $repeatedTagIndex[$xmlTag['tag'] . '_' . $xmlTag['level']] - 1;
                $current = &$current[$xmlTag['tag']][$lastItemIndex];
            }
        } elseif ($xmlTag['type'] == 'complete') {
            if (!isset($current[$xmlTag['tag']]) and empty($current['@' . $xmlTag['tag']])) {
                $current[$xmlTag['tag']] = $result;
                unset($result);
                $repeatedTagIndex[$xmlTag['tag'] . '_' . $xmlTag['level']] = 1;
                if ($tagPriority and $attributesData) {
                    $current['@' . $xmlTag['tag']] = $attributesData;
                }
            } else {
                if (isset($current[$xmlTag['tag']]['0']) and is_array($current[$xmlTag['tag']])) {
                    $current[$xmlTag['tag']][$repeatedTagIndex[$xmlTag['tag'] . '_' . $xmlTag['level']]] = $result;
                    unset($result);
                    if ($tagPriority and $getAttributes and $attributesData) {
                        $current[$xmlTag['tag']]['@' . $repeatedTagIndex[$xmlTag['tag'] . '_' . $xmlTag['level']]] = $attributesData;
                    }
                    $repeatedTagIndex[$xmlTag['tag'] . '_' . $xmlTag['level']] += 1;
                } else {
                    $current[$xmlTag['tag']] = [
                        $current[$xmlTag['tag']],
                        $result,
                    ];
                    unset($result);
                    $repeatedTagIndex[$xmlTag['tag'] . '_' . $xmlTag['level']] = 1;
                    if ($tagPriority and $getAttributes) {
                        if (isset($current['@' . $xmlTag['tag']])) {
                            $current[$xmlTag['tag']]['@0'] = $current['@' . $xmlTag['tag']];
                            unset($current['@' . $xmlTag['tag']]);
                        }
                        if ($attributesData) {
                            $current[$xmlTag['tag']]['@' . $repeatedTagIndex[$xmlTag['tag'] . '_' . $xmlTag['level']]] = $attributesData;
                        }
                    }
                    $repeatedTagIndex[$xmlTag['tag'] . '_' . $xmlTag['level']] += 1;
                }
            }
        } elseif ($xmlTag['type'] == 'close') {
            $current = &$parent[$xmlTag['level'] - 1];
        }
        unset($xmlValues[$num]);
    }

    return $xmlArray;
}

function location($lat, $long)
{

    $location = array(
        'state' => '',
        'city' => '',
        'staddress' => '',
        'postal' => '',
    );
    if ($lat && $long) {
        sleep(1);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, 'https://eu1.locationiq.com/v1/reverse.php?key=pk.828103d25fdfd93bc0ea706d666ea600&lat=' . $lat . '&lon=' . $long . '&format=json&&accept-language=NL&countrycodes=NL&dedupe=1&normalizeaddress=1');
        $result = curl_exec($ch);
        curl_close($ch);

        $obj = json_decode($result);

        if ($obj && !isset($obj->error)) {

            if (isset($obj->address->state)) {
                $location['state'] = addslashes($obj->address->state);
            }

            if (isset($obj->address->village)) {
                $location['city'] = addslashes($obj->address->village);
            }

            if (isset($obj->address->city)) {
                $location['city'] = addslashes($obj->address->city);
            }

            if (isset($obj->address->town)) {
                $location['city'] = addslashes($obj->address->town);
            }

            if (isset($obj->display_name)) {
                $location['staddress'] = addslashes($obj->display_name);
            }

            if (isset($obj->address->postcode)) {
                $location['postal'] = addslashes($obj->address->postcode);
            }

        }
    }

    return $location;
}

function slug($title, $separator = '-', $language = 'en')
{
    // Convert all dashes/underscores into separator
    $flip = $separator === '-' ? '_' : '-';

    $title = preg_replace('![' . preg_quote($flip) . ']+!u', $separator, $title);

    // Replace @ with the word 'at'
    $title = str_replace('@', $separator . 'at' . $separator, $title);

    // Remove all characters that are not the separator, letters, numbers, or whitespace.
    $title = preg_replace('![^' . preg_quote($separator) . '\pL\pN\s]+!u', '', lower($title));

    // Replace all separator characters and whitespace by a single separator
    $title = preg_replace('![' . preg_quote($separator) . '\s]+!u', $separator, $title);

    return trim($title, $separator);
}

function lower($value)
{
    return mb_strtolower($value, 'UTF-8');
}

function get_news_image($title, $description, $content, $words)
{

    $text = strip_tags($title . ' ' . $description . ' ' . $content);
    $result = array('unknown' => 1);

    foreach ($words as $word) {
        $synonyms = $word['synonyms'];
        //checked
        $data = explode(',', $synonyms);
        //checked
        $result[$word['main_word']] = 0;
        foreach ($data as $str) {
            $result[$word['main_word']] += substr_count($text, $str);
        }
    }

    //checked

    $tags = array();
    foreach ($result as $key => $count) {
        if ($count > 0 && $key != 'unknown') {
            $tags[$key] = $count;
        }
    }

    arsort($tags);
    $tags = array_keys($tags);
    $tag = implode(', ', $tags);
    arsort($result);
    $result = array_splice($result, 0, 1);
    $imagesDir = './news_imgs/' . key($result) . '/';
    $images = glob($imagesDir . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);

    $randomImage = $images[array_rand($images)];
    $randomImage = substr($randomImage, 1);

    return [$randomImage, $tag];
}
