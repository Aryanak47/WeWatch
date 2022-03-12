<?php
    require_once("includes/header.php");
    if(!isset($_GET["id"])){
        ErrorMessage::show("No ID passed into page");
        exit();
    }
?>
    <div class="result">


    
    </div>
    </body>
    <script>
        $(document).ready(function() {
            getInformation()
        })
        function getInformation(){
            let id = '<?php echo $_GET['id']; ?>';
            console.log("id" ,id);
            $.ajax({
                type: 'GET',
                url:`https://api.themoviedb.org/3/movie/${id}?api_key=da65565c4f946371b1aa947018514022`,

                success: function(movie_details){
                    let html = show_details(movie_details,id);
                    $(".result").html(html);
                
                },
                error: function(){
                    alert("API Error!");
               
                },
            });
        }
        function show_details(movie_details,id){
            console.log(movie_details);
            var imdb_id = movie_details.imdb_id;
            var poster = 'https://image.tmdb.org/t/p/original'+movie_details.poster_path;
            var overview = movie_details.overview;
            var movie_title = movie_details.original_title
            var genres = movie_details.genres;
            var rating = movie_details.vote_average;
            var vote_count = movie_details.vote_count;
            var release_date = new Date(movie_details.release_date);
            var runtime = parseInt(movie_details.runtime);
            var status = movie_details.status;
            var genre_list = []
            for (var genre in genres){
                genre_list.push(genres[genre].name);
            }
            var my_genre = genre_list.join(", ");
            if(runtime%60==0){
                runtime = Math.floor(runtime/60)+" hour(s)"
            }
            else {
                runtime = Math.floor(runtime/60)+" hour(s) "+(runtime%60)+" min(s)"
            }
                        
            details = {
                'title':movie_title,
                'imdb_id':imdb_id,
                'poster':poster,
                'genres':my_genre || "unknown",
                'overview':overview,
                'rating':rating,
                'vote_count':vote_count.toLocaleString(),
                'release_date':release_date.toDateString().split(' ').slice(1).join(' '),
                'runtime':runtime,
                'status':status,
                // 'rec_movies':JSON.stringify(arr),
                
                
            }
            return createHtmlContainer(details)
        }
        function createHtmlContainer(details){
            let {poster,genres,overview,runtime,status,title} = details
            console.log(poster,genres,overview,runtime,status,title);
            let html = `<div id="home-slider">
                        <div class="slide slick-bg">
                        <div class="trailer">
                        <img src='${poster}' class='previewImage' style='height:100%;object-fit:cover' />
                        
                        </div>
                        <div class="container-fluid position-relative h-100">
                            <div class="slider-inner h-100">
                            <div class="row align-items-center h--100">
                                <div class="col-xl-6 col-lg-12 col-md-12">
                            
                                <a href="javascript:void(0)">
                                    <div class="channel-logo" data-animation-in="fadeInLeft" data-delay-in="0.5">
                                    <img src="assets/images/websitelogo.png" class="c-logo" alt="" />
                                    </div>
                                </a>
                                <h1 class="slider-text big-title title text-uppercase fadeInLeft animated" data-animation-in="fadeInLeft"
                                    data-delay-in="0.6">
                                ${title}
                                </h1>
                                <div class="d-flex flex-wrap align-items-center fadeInLeft animated" data-animation-in="fadeInLeft"
                                    style="opacity: 1">
                                    <p>
                                    ${overview}
                                </p>
                                   
                                </div>
                               
                                <div class="d-flex mt-2 mt-md-3">
                                    <span>${runtime} </span>
                                    </div>
                                <div class="trending-list">
                                    <div class="text-primary title genres">
                                    Genres : <span class="text-body">${genres}</span>
                                    </div>
                                    <div class="text-primary title genres">
                                    status : <span class="text-body">${status}</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center  mt-4">
                                    <div class='buttons'>
                                        <h2>Movie not available for now !</h2>
                                    </div>
                                </div>
                                </div>
                            </div>
                        
                            </div>
                        </div>
                        </div>
                    </div>`
            return html;
        }
    </script>
</html>