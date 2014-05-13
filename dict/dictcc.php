<html>
<head>
</head>

<body>

<script>
    
function setText(txt) {

    /* Frame #2 works on the desktop but not on my iPad.  Frame 2 on the 
     * iPad is the reading pane -- this is in multiple browsers too.. Weird
     */
    var i = 0;
    for(i = 0; i < 4; i++) {
        href = parent.frames[i].location.href;
        if (href.search('edit_word.php') >= 0) {
            // found the right frame
            break;
        }
    }

    href = parent.frames[i].location.href + '&trans=' + encodeURI(txt);
    parent.frames[2].location.href = href;
}

</script>

<?php

require('phpQuery.php');

$term = $_GET['s'];

$dictHTML = file_get_contents("http://www.dict.cc/?s=${_GET['s']}");
$doc = phpQuery::newDocumentHTML($dictHTML);

phpQuery::selectDocument($doc);

$table = pq('#maincontent > table:nth-child(7)');

echo "<ul>";

foreach($table->find('tr') as $tr) {
    $english = pq($tr)->find('.td7nl a');
    $text = $english->text();

    $text = str_replace($term, "", $text);

    if ($text != "") {
        $text = trim(preg_replace('/\s+/', ' ', $text));
        $link = "<a href='#' onclick='setText(\"$text\")'>$text</a>";
	
        print "<li>" . $link . "</li>";
    }
}

echo "</ul>";


?>
</body>
</html>
