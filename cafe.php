<!DOCTYPE html>
<?php require("head.php") ?>
<?php require("session_handler.php") ?>

<script type="text/javascript">

    $(document).ready( function () {
        $("#messageInputForm").submit(handleMessageSubmit);
        
        updateMessageList();
    });
    
    function handleMessageSubmit() {
        console.log("Handle message submit()");
        
        if ($("#messageBox").val()!="") {
            $.post("msg_post.php", $(this).serialize(), function(status) {
                if (status=="ok") {
                    console.log("done");
                    updateMessageList();
                    $("#messageBox").val("");
                }
            });
        }

        return false;
    }
    
    function updateMessageList() {
        $.get("msg_get.php", "", function(data) {
            console.log("Messages: " +data);
            var messages = JSON.parse(data);
            
            $("#messageContainer").empty();
            
            for (var i=0; i < messages.length; i++) {
                var msg = messages[i];
                var date = new Date(msg.time + " UTC");
                
                var element = "<div class='media-body'><h4 class='media-heading'>" 
                              + msg.nickname + " " + date.toLocaleString() + "</h4>" + msg.text + "</div>"
                
                $("#messageContainer").append(element);
            }
        });        
    }
    
</script>

</head>

<body>
    <div id="container">
        
        <?php require("header.php"); createHeader("cafe"); ?>

        <div id="cafeContent">
            <form id="messageInputForm">
                <fieldset>                    
                    <div class="controls">
                        <textarea id="messageBox" name="message" placeholder="Kirjoita viesti" maxlength="140" rows="2"></textarea>
                    </div>							
                </fieldset>                            
                <button type="submit" class="btn btn-primary">Valmis</button>
            </form>
           
            <div id="messageContainer">
            </div>

        </div>
        
        <?php require("footer.php") ?>

    </div>    
</body>
</html>
