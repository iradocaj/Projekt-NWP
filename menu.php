<?php
print '
<ul>
    <li><a href="index.php?menu=1">Home</a></li>
    <li><a href="index.php?menu=2">News</a></li>
    <li><a href="index.php?menu=3">Contact</a></li>
    <li><a href="index.php?menu=4">About</a></li>';
    
if (!isset($_SESSION['user']['valid']) || $_SESSION['user']['valid'] == 'false') {
    print '
    <li><a href="index.php?menu=5">Register</a></li>
    <li><a href="index.php?menu=6">Sign In</a></li>';
}
else if ($_SESSION['user']['valid'] == 'true') {
    if ($_SESSION['user']['role'] == '2') {
        

        print '
        <li><a href="signout.php">Sign out</a></li>';
        
    }
    else if ($_SESSION['user']['role'] == '3'){
        
        print '
        <li><a href="index.php?menu=7">Admin</a></li>
        <li><a href="signout.php">Sign Out</a></li>';
    }else {

        print '
        <li><a href="index.php?menu=10.php">Edit</a></li>
        <li><a href="signout.php">Sign out</a></li>';
    }
}

print '
<li><a href="index.php?menu=8">Dodge vehicles</a></li>
<li><a href="index.php?menu=9">VIN decoder</a></li>
</ul>';
?>