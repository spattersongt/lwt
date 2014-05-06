<html>
<head>
<script type="text/javascript" src="jquery-1.7.2.min.js"></script>
</head>

<body>

<script>
    
function setText(txt) {
    href = parent.frames[2].location.href + '&trans=' + encodeURI(txt);
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
