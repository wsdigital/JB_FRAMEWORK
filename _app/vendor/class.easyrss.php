<?php
class easyRSS
{

function parse($feed, $datetype="")
{ // Parses the RSS feed into the array
    $arr = array();
    // Determine encoding
    preg_match('/<\?xml version="1\.0" encoding="(.*)"\?>/i', $feed, $sarr);
    $arr["encoding"] = $sarr[1];
    // Determine title
    preg_match('/<title>(.*)<\/title>/i', $feed, $sarr);
    $arr["title"] = $sarr[1];
    // Determine stylesheet
    preg_match('/<?xml-stylesheet.*href="(.*)".*?>/i', $feed, $sarr);
    $arr["stylesheet"] = $sarr[1];
    // Determine description
    preg_match('/<description>(.*)<\/description>/i', $feed, $sarr);
    $arr["description"] = $sarr[1];
    // Determine link
    preg_match('/<link>(.*)<\/link>/i', $feed, $sarr);
    $arr["link"] = $sarr[1];
    // Determine language
    preg_match('/<language>(.*)<\/language>/i', $feed, $sarr);
    $arr["language"] = $sarr[1];
    // Determine generator
    preg_match('/<generator>(.*)<\/generator>/i', $feed, $sarr);
    $arr["generator"] = $sarr[1];
    // Strip items
    $parts = explode("<item>", $feed);
    foreach($parts as $part)
    {
        $item = substr($part, 0, strpos($part, "</item>"));
        if(!empty($item))
            $items[] = $item;
    }
    // Fill the channel array
    $arr["items"] = array();
    foreach($items as $item)
    {
        // Determine title
        preg_match('/<title>(.*)<\/title>/i', $item, $title);
        // Determine pubdate
        preg_match('/<pubDate>(.*)<\/pubDate>/i', $item, $pubdate);
        $date = strtotime($pubdate[1]);
        if(!empty($datetype))
            $date = date($datetype, $date);
        // Determine link
        preg_match('/<link>(.*)<\/link>/i', $item, $link);
        // Determine description
        if(stristr($item, '<![CDATA['))
            preg_match('/<description><!\[CDATA\[(.*)\]\]><\/description>/is', $item, $description);
        else
            preg_match('/<description>(.*)<\/description>/is', $item, $description);
        $arr["items"][] = array("title"=>$title[1], "pubDate"=>$date, "link"=>$link[1], "description"=>$description[1]);
    }
    return $arr;
}

function rss($input)
{ // Builds the XML RSS schema using the array
    $input["encoding"] = (empty($input["encoding"]))?"UTF-8":stripslashes($input["encoding"]);
    $input["language"] = (empty($input["language"]))?"en-us":stripslashes($input["language"]);
    $input["generator"] = (empty($input["generator"]))?"EasyRSS":stripslashes($input["generator"]);
    $input["title"] = stripslashes($input["title"]);
    $input["description"] = stripslashes($input["description"]);
    $input["link"] = stripslashes($input["link"]);
    $rss = '<?xml version="1.0" encoding="'.$input["encoding"].'"?>';
    $rss .= (!empty($input["stylesheet"]))?"\n".'<?xml-stylesheet type="text/xsl" href="'.stripslashes($input["stylesheet"]).'"?>':"";
    $rss .= <<<__RSS__

<rss version="2.0">
<channel>
<title>{$input["title"]}</title>
<description>{$input["description"]}</description>
<link>{$input["link"]}</link>
<language>{$input["language"]}</language>
<generator>{$input["generator"]}</generator>

__RSS__;
    foreach($input["items"] as $item)
    {
        $data = date("r", $item["pubDate"]);
        $rss .= "\n<item>\n<title>".$item["title"]."</title>";
        $rss .= "\n<description><![CDATA[".$item["description"]."]]></description>";
        if (!empty($item["pubDate"]))
            $rss .= "\n<pubDate>".date("r", $item["pubDate"])."</pubDate>";
        if (!empty($item["link"]))
            $rss .= "\n<link>".$item["link"]."</link>";
        $rss .= "\n</item>\n";
    }
    $rss .= "\n</channel>\n</rss>";
    return $rss;
}

}
?>