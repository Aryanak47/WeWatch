<?php 
    require_once("includes/header.php") ;
?>

<div class="textboxContainer">
    <input type="text"  class="searchInput" placeholder="Search for Something...">
</div>

<div class="results">
    
</div>
<div class="loader" style="display: none">
        <img src="assets/images/load.gif" alt="loader" />
</div>


<script>
    $(function(){
        let timer;
        let user = '<?php echo $userLoggedIn; ?>';
        $(".searchInput").on("keyup", function(event){
            clearTimeout(timer);
            timer = setTimeout(function(){
                let value = $(event.target).val();
                if(value != "") {
                $(".loader").fadeIn();
                $.post("ajax/getSearchResult.php", { text: value, username: user }, function(data) {
                    if(data == 0) {
                        $(".results").html("");
                        load_details(value)
                        return

                    }
                    $(".loader").delay(300).fadeOut();
                    $(".results").html(data);
                })
            }
            else {
                $(".results").html("");
            }
            },2000)
        })
        
        function load_details(title){
            $.ajax({
                type: 'GET',
                url:`https://api.themoviedb.org/3/search/movie?api_key=da65565c4f946371b1aa947018514022&query=${title}`,

                success: function(movie){
                if(movie.results.length<1){
                    let html = "<div class='previewCategories noScroll'><h2> No results found</h2></div>"
                    $(".results").html(html);
                    $(".loader").delay(300).fadeOut();
                }
                else{
                    console.log(movie.results)
                   
                    let movies = movie.results
                    let html = `<div class="previewCategories noScroll">
                                    <div class="category">
                                        <div class="entities">`
                    movies.forEach(m => {
                        let title = m.title
                        let thumbnail = m.poster_path
                        let id = m.id
                        if(title && thumbnail &&id){
                            html += getHtmlContainer(title,id,thumbnail)

                        }
                    });
                    html += ` </div></div> </div>`
                    $(".loader").delay(300).fadeOut();
                    $(".results").html(html);
                }
                },
                error: function(){
                alert('Invalid Request');
                $(".loader").delay(300).fadeOut();
                },
            });
        }
    })
    
</script>