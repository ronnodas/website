<?php

function form($key) {
    $text = '<form method="post" action="verify.php">'.'Answer: <input type="text" name="answer" size="28" autofocus="autofocus"/> '.'<input type="hidden" name="key" value="'.$key.'" />'.'<input type="submit" value="Check"/>'.'</form>';
    return $text;
}

$level = 0;
$key = 'start';
if (isset($_GET['level']) && isset($_GET['key'])) {
    $level = $_GET['level'];
    $key = $_GET['key'];
}
$content = file_get_contents($key.'.htm');
$form = form($key);
echo '<h2> Level '.$level.'</h2>'.$content.$form.' <br>'.'<p>Click <a href = "start.php">here</a> to go back to the start. Click <a href = "../index.html">here</a> to quit.</p>';
?>
