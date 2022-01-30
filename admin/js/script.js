const navLists = document.querySelectorAll(".side-nav__item")

navLists.forEach(element => {
    element.addEventListener("click",e =>{
        element.classList.remove("mystyle");
        let activeElement = document.querySelector(".side-nav__item--active")
        activeElement.classList.remove("side-nav__item--active")
        element.classList.add("side-nav__item--active")
    })
    
});
