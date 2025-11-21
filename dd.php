<?php
// Establish the database connection. This is the main fix.
require_once 'db_connect.php';
?>
<script>
$(document).ready(function(){
    $(".fa.fa-telegram").click(function(){
        var msg = $("#message").val();
        // This $userId variable must be defined in the parent PHP file
        var userid = "<?php echo $userId; ?>"; 
        if(msg.length != 0){
            $.post(
                "message.php",
                {msg: msg, userid: userid},
                function(data){
                    $("#chat-box").html(data);
                }
            );
        }
    });
});
</script>

<div class="row">
    <div class="col-sm-6">
        <!-- Intentionally left blank -->
    </div>
    <div class="col-sm-6">
        <?php
        // This query will now work because $conn is available.
        // The $sender_userid and $receiver_userid variables must be defined in the parent PHP file.
        $query = "SELECT * FROM message WHERE (sender_userid = '$sender_userid' AND receiver_userid='$receiver_userid') OR (sender_userid = '$receiver_userid' AND receiver_userid='$sender_userid')";
        $ry = mysqli_query($conn, $query);

        while ($qr = mysqli_fetch_array($ry)) {
            $fuid = $qr["sender_userid"];
            if ($fuid == $sender_userid) {
        ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($qr["message"]); ?></div><span>Sender</span>
        <?php
            } else {
        ?>
            <div class="alert alert-info"><?php echo htmlspecialchars($qr["message"]); ?></div><span>Receiver</span>
        <?php
            }
        }
        ?>
    </div>
</div>
