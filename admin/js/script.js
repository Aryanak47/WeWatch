
let { pathname } = window.location;
pathname = pathname.split("/");
pathname = pathname[pathname.length - 1]
const navs = document.querySelectorAll(".side-nav__link")

navs.forEach(function(element) {
    const attr = element.getAttribute("href")
    if (pathname === "movies.php" || pathname === "series.php") {
        $(".side-nav__sub").removeClass("hidden")


    }
    if (attr === pathname) {
        element.parentElement.classList.add("side-nav__item--active")
    } else if (pathname === "series.php") {
        $(".video-nav").addClass("side-nav__item--active")
    }

})


function sortByValue(page) {
    let sort = $("#sort").val()
    window.location.href = `http://localhost/wewatch/admin/${page}.php?sort=${sort}`
}



  
  


