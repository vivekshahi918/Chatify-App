<?php
session_start();
if (isset($_COOKIE["login"]) && isset($_SESSION["session"])) {
    require_once 'db_connect.php';

    $email = mysqli_real_escape_string($conn, $_COOKIE["login"]);

    if (isset($_REQUEST["ch"])) {
        $ch = mysqli_real_escape_string($conn, $_REQUEST["ch"]);

        $query = "SELECT *, (CASE WHEN last_activity <> logout_time THEN 1 ELSE 0 END) AS status 
                  FROM user 
                  WHERE (first_name LIKE '%$ch%' OR last_name LIKE '%$ch%') 
                  AND email != '$email'";
        $rs = mysqli_query($conn, $query);

        if(mysqli_num_rows($rs) > 0) {
            echo "<table class='table table-borderless'>";
            while ($r = mysqli_fetch_array($rs)) {
                $statusIndicator = $r['status'] == 1 ? "<span style='color: green;'>● Active</span>" : "<span style='color: red;'>● Inactive</span>";
                echo "<tr>
                    <td>
                        <a href='chat.php?userid=" . $r["userId"] . "' style='text-decoration:none;color:black;display:flex;align-items:center;'>
                            <img src='images/" . $r["userId"] . ".jpg' class='rounded-circle' style='width:60px;height:60px;'>
                            <span style='margin-left: 10px;'>" . $r["first_name"] . " " . $r["last_name"] . " $statusIndicator</span>
                        </a>
                    </td>
                </tr>";
            }
            echo "</table>";
        } else {
            echo "<div class='alert alert-warning'>Record Not Found</div>";
        }
    }
    mysqli_close($conn);
} else {
    header("location:login.php");
}
?>