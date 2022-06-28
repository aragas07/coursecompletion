var nav = document.getElementsByClassName("nav-link"),
page = document.getElementById("page").value;
nav[page].classList.add("active");