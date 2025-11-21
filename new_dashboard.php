<?php
if (isset($_REQUEST["email"])) {
    // 1. Establish database connection
    require_once 'db_connect.php';

    // 2. Sanitize input
    $email = mysqli_real_escape_string($conn, $_REQUEST["email"]);

    // 3. Prepare and execute query
    $query = "
        SELECT *, 
        (CASE WHEN last_activity <> logout_time THEN 1 ELSE 0 END) AS status 
        FROM user 
        WHERE email != '$email'";

    $rs = mysqli_query($conn, $query);

    // 4. Display results
    echo "<table class='table table-borderless'>";

    while ($r = mysqli_fetch_array($rs)) {
        $statusIndicator = $r['status'] == 1
            ? "<span style='color: green;'>● Active</span>"
            : "<span style='color: red;'>● Inactive</span>";
?>
        <tr>
            <td>
                <a href="chat.php?userid=<?php echo $r["userId"]; ?>" style="text-decoration:none;color:black;">
                    <img src="images/<?php echo $r["userId"]; ?>.jpg" class="rounded-circle" style="width:60px;height:60px;">
                    <span><?php echo $r["first_name"] . " " . $r["last_name"]; ?></span>
                    <?php echo $statusIndicator; ?>
                    <span>
                        <p>message....</p>
                    </span>
                </a>
            </td>
        </tr>
<?php
    }
    echo "</table>";

    // 5. Close the connection
    mysqli_close($conn);
}
?>