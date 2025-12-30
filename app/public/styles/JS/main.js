//******************************
// ========================
//  variables
// ========================
//******************************
 const btndarkMode = document.querySelector(".btnmode")
 const body = document.querySelector("body")
 const darkmode = document.querySelector(".btnmode:first-child")
 const lightmode = document.querySelector(".btnmode:nth-child(2)")




//******************************
// ========================
//  local storage
// ========================
//******************************


//******************************
// ========================
//  main page
// ========================
//******************************

// ------------------------
//  button light dark mode
// -------------------------
let actualTheme = localStorage.getItem("theme");
if (actualTheme === "dark") {
     body.classList.toggle("dark");
     darkmode.style.display = "none";
     lightmode.style.display = "block";
} else {
       darkmode.style.display = "block";
       lightmode.style.display = "none";
}




btndarkMode.addEventListener("click", function () {
    body.classList.toggle("dark") 
    if( body.classList.contains("dark")){
        localStorage.setItem("theme","dark")
        darkmode.style.display = "none";
        lightmode.style.display = "block";
    } else {
        localStorage.removeItem("dark");
        darkmode.style.display = "block";
        lightmode.style.display = "none";
    }


})