<!DOCTYPE html>
<head><title>Daniel Vasquez MD5</title></head>
<body>

<?php
$error = false;
$md5 = false;
$code = "";
if ( isset($_GET['code']) ) {
    $code = $_GET['code'];
    if ( strlen($code) != 4 ) {
        $error = "Input must be exactly 4 numbers";
    }  else {
        $md5 = hash('md5', $code);
    }
}
?>
<h1>MD5 PIN Maker</h1>
<?php
if ( $error !== false ) {
    print '<p style="color:red">';
    print htmlentities($error);
    print "</p>\n";
}

if ( $md5 !== false ) {
    print "<p>MD5 value: ".htmlentities($md5)."</p>";
}
?>
<p>Please enter a 4 digit key for encoding.</p>
<form>
<input type="text" name="code" value="<?= htmlentities($code) ?>"/>
<input type="submit" value="Compute MD5 for CODE"/>
</form>
<body>

<h1>MD5 cracker</h1>
<p>This application takes an MD5 hash
of a 4 digit pin an try all the combinations to get the original one.</p>
<pre>
Debug Output:
<?php
$goodpin = "Not found";
// If there is no parameter, this code is all skipped
if ( isset($_GET['md5']) ) {
    $time_pre = microtime(true);
    $md5 = $_GET['md5'];

    // This is our alphabet
    $numbers = "0123456789abcdefghijklmnopqrstuvwyxz";
    $show = 15;

    // Outer loop go go through the alphabet for the
    // first position in our "possible" pre-hash
    // text

    for($i=0; $i<strlen($numbers); $i++ ) {
        $ch1 = $numbers[$i]; 
        for($j=0; $j<strlen($numbers); $j++ ) {
            $ch2 = $numbers[$j];
            for($k=0; $k<strlen($numbers); $k++ ) {
                $ch3 = $numbers[$k];   // The third of 4 numbers
                // Our inner loop Not the use of new variables
                // $j and $ch2 
                for($l=0; $l<strlen($numbers); $l++ ) {
                    $ch4 = $numbers[$l];  // Our last number    
                    // Concatenate the two characters together to 
                    // form the "possible" pre-hash text
                    $try = $ch1.$ch2.$ch3.$ch4;
                    // Run the hash and then check to see if we match
                    $check = hash('md5', $try);
                    if ( $check == $md5 ) {
                        $goodpin = $try;
                        break;   // Exit the inner loop
                    }
                   // Debug output until $show hits 0
                    if ( $show > 0 ) {
                        print "$check $try\n";
                        $show = $show - 1;
                    }
                }
            }
        }
    }

    // Compute elapsed time
    $time_post = microtime(true);
    print "Elapsed time: ";
    print $time_post-$time_pre;
    print "\n";
}
?>
</pre>
<!-- Use the very short syntax and call htmlentities() -->
<p>Original PIN: <?= htmlentities($goodpin); ?></p>
<form>
<input type="text" name="md5" size="60" />
<input type="submit" value="Crack MD5"/>
</form>

</body>
</html>