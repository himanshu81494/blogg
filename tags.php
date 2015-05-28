<?php
session_start();
include_once"connect.php";
echo $_SESSION['tags'];
//$tagarray=$_SESSION['tags'];
echo $tagarray = "school, school, technology, tech, india, dps"; 
echo "<br>";
$tag = explode(",", $tagarray,15);

for($i = 0; $i < count($tag); $i++){
$tag[$i]=trim($tag[$i]);
	$len =strlen($tag[$i]);
if($len<3){unset($tag[$i]);$tag[$i]=NULL;$len=strlen($tag[$i]);}
$qry=<<<EOD
ALTER TABLE tags  ADD COLUMN  '$tag[$i]' TEXT
EOD;
//$db->exec($qry); echo "added $tag[$i]";

echo "tag $i = $tag[$i] $len<br />";
}
$count=0;
$tablesquery = $db->query("PRAGMA table_info(tags);");

    while ($table = $tablesquery->fetchArray(SQLITE3_ASSOC)) {
    	$tagname=$table['name'];
        echo "<a href='?$tagname'>".$tagname ."</a>". '<br />';$count++;
        //<a  href="?logout">Logout</a>
}
echo "<div style='color:red;font-size:15px;float:right'>total of $count</div>";

function array2commaList($list, $lastIdentifier = 'and')
{
    switch(count($list))
    {
        case 0:
            $string = false;
        break;
        case 1:
            $string = $list[0];
        break;
        case 2:
            $string = implode(' '.$lastIdentifier.' ', $list);
        break;
        default:
            $lastItem = array_pop($list);
            $string = implode(', ', $list).', '.$lastIdentifier.' '.$lastItem;
    }
    return $string;
}


/*
*
* Grabs all of the input values of the html code given
*
* @param $html The code of an html file
* @return An array of the names and values of the code
*/
function get_input_values($html)
{
    $dom = new DOMDocument('1.0');
    $dom->loadHTML($html);
    $aResult = array();
    if($input = $dom->getElementsByTagName('input'))
    {
        foreach($input as $item)
        {
            $attributes = $item->attributes;
            if($attributes->getNamedItem('name') != null)
            {
                $aResult[$attributes->getNamedItem('name')->nodeValue] = array();
                foreach($attributes as $attr)
                {
                    $aResult[$attributes->getNamedItem('name')->nodeValue][$attr->name] = $attr->value;
                }
            }
        }
    }
    return $aResult;
}