<?php 
    require_once("includes/header.php") ;
?>

<div class="textboxContainer">
    <input type="text"  class="searchInput" placeholder="Search for Something...">
</div>

<div class="results"></div>


<script>
    $(function(){
        let timer;
        let user = '<?php echo $userLoggedIn; ?>';

        $(".searchInput").on("keyup", function(event){
            clearTimeout(timer);
            timer = setTimeout(function(){
                let value = $(event.target).val();
                if(value != "") {
                $.post("ajax/getSearchResult.php", { text: value, username: user }, function(data) {
                    $(".results").html(data);
                })
            }
            else {
                $(".results").html("");
            }
                
            

            },2000)
        })
    })


</script>