<?php

/*
  The following function checks for email injection.
  Specifically, it checks for carriage returns - typically used by spammers to inject a CC list.
 */

function isInjected($str) {
    $injections = array('(\n+)',
        '(\r+)',
        '(\t+)',
        '(%0A+)',
        '(%0D+)',
        '(%08+)',
        '(%09+)'
    );
    $injects = join('|', $injections);
    $inject = "/$injects/i";
    if (preg_match($inject, $str)) {
        return true;
    } else {
        return false;
    }
}

function hashans($ans) {
    $ret1 = hash('sha256', $ans);
    $ret2 = $ret1 . "JackSparrow";
    $ret3 = hash('sha256', $ret2);
    return $ret3;
}

function clean_input($data) {
    $data1 = htmlspecialchars(stripslashes(trim($data)));
    $data2 = str_replace(array(' ', '\n', '\t', '\r', '\0', "\x0B", '.', ',', '!', '?'), '', $data1);
    $data3 = strtolower($data2);
    return $data3;
}


$error_page = "start.php";
$correct_hashes = array(0 => array('start'),
    1 => array("888e594764bd45781f48bf4955243405d4a7ef9e41e9bc81127704861764476e"),
    2 => array("5bdc2a9def55c0abc6d8bc619cae5510a82822a8b4e9358e6166d3653c8170a8"),
    3 => array("97eaa23ff4a6768e20db94307034f1bb1a642b5c133006d9ef5824e591709f92"),
    4 => array("e73d33f7d6ff7e5cabc4a36353a19d6f89aaab4516f0acb1148c2b9a06efc072",
        "ee9acfce7137500b68337ecedc01e873ca045b0cf242c84d0e24e4031fa0583f"),
    5 => array("2f328c0c135227d6863b82e490c0f62dcc6af367623cf4caabe85c0acfa8620b",
        "7e64af052d96686de607f938f9f24d4695dcc896fede9c235edd94c6dd95d87b"),
    6 => array("3369c6343784514a160c4c9e57133f3b964ce4468f4f5e13a8186d51fab5de8c"),
    7 => array("1888dad673281a756f156d5847825f3c61f57433cae821f27f342e09dda459ac",
        "23cc83437ce3eeeb159b467abf2f7d9447695b2a7047625d97422703134117cc"),
    8 => array("fcdb5e8292b2df9f95e53aa50afbdd3899c507ac6d1213e8be02e2c38e9cc67b"),
    9 => array("1419be6b3fba561a74fd8ea80f41019b406d05caeb08aed05226a998918dc974"),
    10 => array("de6d98a9b2ac0648b07b9db067c0e1061af6d1a4daf2addbcac2f535d86c2cd7"),
    11 => array("d577a0f9a1438fadb53ac9f5cd1600e29c8d8d46ee2d4c661c2a466111221a54"),
    12 => array("91d3c789b5292c162f02a2bdf9d6c629df19e3fe73a7698e9c67a20d80af8a11"),
    13 => array("ac99cce94e2cf77e3515480002bd1ffbf7a1e51ac091f7be6863e7279b97dfa2"),
    14 => array("94b9a399b7c3218522252174419bcd86c252a597a4794dcd63b1d2eeb8bc3505"),
    15 => array("74ef4d59252941148355695726a0ae1d0aa6eb9f84aa9a9764c9cd23215d8c71",
        "ae434baa99a2c0b34abd10b6b536b46c6c5fadd86e02b49ffa2a4aa672dc0b26"),
    16 => array("0d0933d960cc141c781a665581030137815fcc9fff7a726019ba1954fe474fac"),
    17 => array("f15a1c839a8abe82450d7a663fa951f4c2fa7c3f6cac5c98f2986bc0f5e9e761"),
    18 => array("37573feac310f2d7b3f01492068277b2a05a250b8721df5522090dbf558e5cee"),
    19 => array("5bfc979db35bb2442307e27c71d854c7978b37446c990880e17d4eda4502232b"),
    20 => array("271e8dea9c846d708d8a29629dfbd35468f21191887469cc3ca05b94c84669b4"),
    21 => array("0fb174046966dfa73efc023f0d7a96b988729deb90195dae246ca24e12ff930d"),
    22 => array("88ea9b32f0f5a4b040ad61f1ebc3626cdeda35ccf50032a136ac15297c36be8a"),
    23 => array("ef3e9d253011ec1e96736b22e0c512decc4da2f4351f4ea023e641b88fb06945"),
    24 => array("4f96759f44b5e47fb79b0766a68a139532f5f2fc807cbd420dc5ab7e66b7e483"),
    25 => array("2be2f69085a1a5eb43df8f1b0c08d0acf303028a465980178c986c933a768a08"),
    26 => array("921a4a42b9a43f6729364d436f5f8a74f5378ebd95f7bf6479da4bee45dd4ccc"),
    27 => array("9fd35a2d423d518b449cf68419651526c0f371e26ad08a1d91cf0aad9b91552e"),
    28 => array("50f4060ba77452a01704ba4427a5d3c3eb43a65dec9d23069c5d277ed5fc1e03"),
    29 => array("6b989031913ec1a30f98209b7cc49f24ddb0cbc908a9dec686d80a75dbf930f6"),
    30 => array("227b3e4a131c4e49aad6afbec69abab04ddd42f2ee1384069bdc7991bd9b3621"),
    31 => array("01d4614a2a55cb469e43ef48857d34155db8c026cce6b70e245fd911b2f35c6e")
);

/*
  This next bit loads the form field data into variables.
  If you add a form field, you will need to add it here.
 */
$answer = clean_input($_POST['answer']);
$curhash = $_POST['key'];

$level=0;
foreach ($correct_hashes as $q => $p) {
    if ($curhash == $p[0]) {
        $level = $q;
    }
}

$current_page = 'start.php?level='.$level.'&key='.$curhash;
header("Location: $current_page");

// If the user tries to access this script directly, redirect them to the start,
if (!isset($_POST['answer'])) {
    header("Location: $error_page");
}

// If any injection is detected, send back to start.
elseif (isInjected($answer)) {
    header("Location: $error_page");
}

// If we passed all previous tests, check if the answer is correct
else {
    $checkans = hashans($answer);
    $correct = FALSE;
    foreach (($correct_hashes[($level + 1)]) as $poss) {
        if ($checkans == $poss) {
            $correct = TRUE;
        }
    }
    if ($correct) {
        $next_page = 'start.php?level='.($level+1).'&key='.($correct_hashes[($level + 1)][0]);
        header("Location: $next_page");
    } else {
        header("Location: $current_page");
    }
}
?>
