<?php 
include_once("includes/header.php");

?>
<div class="textBoxContainer">
    <input type="textbox" class="inputTextBox" placeholder="Search For Something">
</div>

<div class="results"></div>

<script>
    $(function(){
        var username='<?php echo $userLoggedIn; ?>';
        var timer;

        $(".inputTextBox").keyup(function(){
            clearTimeout(timer);

            timer=setTimeout(function(){
                var val=$(".inputTextBox").val();
                if (val!=0){
                    $.post("ajax/searchProgress.php",{term : val , username : username},function(data){
                        $(".results").html(data);
                    });
                }
                else{
                    $(".results").html("");
                }
            },500)
        })
    })
</script>