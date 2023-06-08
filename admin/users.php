<?php 


if (isset($_POST['edit']) && $_POST['_action_'] == 'TRUE') {
    $query  = "UPDATE korisnik SET Ime='" . $_POST['Ime'] . "', Prezime='" . $_POST['Prezime'] . "', Email='" . $_POST['Email'] . "', Username='" . $_POST['Username'] . "', Drzava='" . $_POST['Drzava'] . "', archive='" . $_POST['archive'] . "'";
    $query .= ", Rola='" . $_POST['Rola'] . "'";
    $query .= " WHERE id=" . (int)$_POST['edit'];
    $query .= " LIMIT 1";
    $result = @mysqli_query($MySQL, $query);
    
    @mysqli_close($MySQL);

    $_SESSION['message'] = '<p>You successfully changed user profile!</p>';

   
    header("Location: index.php?menu=7&action=1");
}



if (isset($_GET['delete']) && $_GET['delete'] != '') {

    $query  = "DELETE FROM korisnik";
    $query .= " WHERE id=".(int)$_GET['delete'];
    $query .= " LIMIT 1";
    $result = @mysqli_query($MySQL, $query);

    $_SESSION['message'] = '<p>You successfully deleted user profile!</p>';

    
    header("Location: index.php?menu=7&action=1");
}




if (isset($_GET['id']) && $_GET['id'] != '') {
    $query  = "SELECT * FROM korisnik";
    $query .= " WHERE id=".$_GET['id'];
    $result = @mysqli_query($MySQL, $query);
    $row = @mysqli_fetch_array($result);
    print '
    <h2>User profile</h2>
    <p><b>First name:</b> ' . $row['Ime'] . '</p>
    <p><b>Last name:</b> ' . $row['Prezime'] . '</p>
    <p><b>Username:</b> ' . $row['Username'] . '</p>';
    $_query  = "SELECT * FROM drzave";
    $_query .= " WHERE country_code='" . $row['Drzava'] . "'";
    $_result = @mysqli_query($MySQL, $_query);
    $_row = @mysqli_fetch_array($_result);
    print '
    <p><b>Drzava:</b> ' .$_row['country_name'] . '</p>
    <p><b>Date:</b> ' . pickerDateToMysql($row['date']) . '</p>
    <p><b>Rola:</b> ' . getRoleName($row['Rola']) . '</p>
    <p><a href="index.php?menu='.$menu.'&amp;action='.$action.'">Back</a></p>';
}

else if (isset($_GET['edit']) && $_GET['edit'] != '') {
    $query  = "SELECT * FROM korisnik";
    $query .= " WHERE id=".$_GET['edit'];
    $result = @mysqli_query($MySQL, $query);
    $row = @mysqli_fetch_array($result);
    $checked_archive = false;
    
    print '
    <h2>Edit user profile</h2>
    <form action="" id="registration_form" name="registration_form" method="POST">
        <input type="hidden" id="_action_" name="_action_" value="TRUE">
        <input type="hidden" id="edit" name="edit" value="' . $_GET['edit'] . '">
        
        <label for="fname">First Name *</label>
        <input type="text" id="fname" name="Ime" value="' . $row['Ime'] . '" placeholder="Your name.." required>

        <label for="lname">Last Name *</label>
        <input type="text" id="lname" name="Prezime" value="' . $row['Prezime'] . '" placeholder="Your last natme.." required>
            
        <label for="Email">Your E-mail *</label>
        <input type="Email" id="Email" name="Email"  value="' . $row['Email'] . '" placeholder="Your e-mail.." required>
        
        <label for="Username">Username *<small>(Username must have min 5 and max 10 char)</small></label>
        <input type="text" id="Username" name="Username" value="' . $row['Username'] . '" pattern=".{5,10}" placeholder="Username.." required><br>
        
        <label for="Drzava">Drzava</label>
        <select name="Drzava" id="Drzava">
            <option value="">molimo odaberite</option>';
            
            $_query  = "SELECT * FROM drzave";
            $_result = @mysqli_query($MySQL, $_query);
            while($_row = @mysqli_fetch_array($_result)) {
                print '<option value="' . $_row['country_code'] . '"';
                if ($row['Drzava'] == $_row['country_code']) { print ' selected'; }
                print '>' . $_row['country_name'] . '</option>';
            }
        print '
        </select>
        
        <label for="archive">Activated:</label><br />
        <input type="radio" name="archive" value="Y"'; if($row['archive'] == 'Y') { echo ' checked="checked"'; $checked_archive = true; } echo ' /> YES &nbsp;&nbsp;
        <input type="radio" name="archive" value="N"'; if($checked_archive == false) { echo ' checked="checked"'; } echo ' /> NO

		<br><br>

        <label for="Rola">Rola:</label><br />
        <select name="Rola" id="Rola">
            <option value="3"'; if($row['Rola'] == '3') { echo ' selected'; } echo '>Admin</option>
            <option value="2"'; if($row['Rola'] == '2') { echo ' selected'; } echo '>Korisnik</option>
            <option value="4"'; if($row['Rola'] == '4') { echo ' selected'; } echo '>Editor</option>

        </select>
        
        <hr>
        
        <input type="submit" value="Submit">
    </form>
    <p><a href="index.php?menu='.$menu.'&amp;action='.$action.'">Back</a></p>';
}
else {
    print '
    <h2>List of users</h2>
    <div id="korisnik">
        <table>
            <thead>
                <tr>
                    <th width="16"></th>
                    <th width="16"></th>
                    <th width="16"></th>
                    <th>First name</th>
                    <th>Last name</th>
                    <th>E mail</th>
                    <th>Država</th>
                    <th width="16"></th>
                </tr>
            </thead>
            <tbody>';
            $query  = "SELECT * FROM korisnik";
            $result = @mysqli_query($MySQL, $query);
            while($row = @mysqli_fetch_array($result)) {
                print '
                <tr>
                    <td><a href="index.php?menu='.$menu.'&amp;action='.$action.'&amp;id=' .$row['id']. '"><img src="img/user.png" alt="user"></a></td>
                    <td><a href="index.php?menu='.$menu.'&amp;action='.$action.'&amp;edit=' .$row['id']. '"><img src="img/edit.png" alt="uredi"></a></td>
                    <td><a href="index.php?menu='.$menu.'&amp;action='.$action.'&amp;delete=' .$row['id']. '"><img src="img/delete.png" alt="obriši"></a></td>
                    <td><strong>' . $row['Ime'] . '</strong></td>
                    <td><strong>' . $row['Prezime'] . '</strong></td>
                    <td>' . $row['Email'] . '</td>
                    <td>';
                        $_query  = "SELECT * FROM drzave";
                        $_query .= " WHERE country_code='" . $row['Drzava'] . "'";
                        $_result = @mysqli_query($MySQL, $_query);
                        $_row = @mysqli_fetch_array($_result, MYSQLI_ASSOC);
                        print $_row['country_name'] . '
                    </td>
                    <td>';
                        if ($row['archive'] == 'Y') { print '<img src="img/active.png" alt="" title="" />'; }
                        else if ($row['archive'] == 'N') { print '<img src="img/inactive.png" alt="" title="" />'; }
                    print '
                    </td>
                </tr>';
            }
        print '
            </tbody>
        </table>
    </div>';
}


function getRoleName($role) {
    if ($role == '3') {
        return 'Admin';
    } elseif ($role == '2') {
        return 'Korisnik';
    } else if($role == 4) {
        return 'Editor';
    }else {
        return 'Unknown';
    }
}


@mysqli_close($MySQL);
?>