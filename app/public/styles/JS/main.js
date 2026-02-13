//******************************
// ========================
//  variables
// ========================
//******************************
 const btndarkMode = document.querySelector(".btnmode")
 const body = document.querySelector("body")
 const darkmode = document.getElementById("darkMode")
 const lightmode = document.getElementById("lightMode")
 const textDarkMode = document.getElementById("textDarkMode")
 const textLightMode = document.getElementById("textLightMode")


// ------------------------
//  button light dark mode
// -------------------------
let actualTheme = localStorage.getItem("theme");
if (actualTheme === "dark") {
     body.classList.toggle("dark");
     darkmode.style.display = "none";
     lightmode.style.display = "block";
     textLightMode.style.display = "block";
     textDarkMode.style.display = "none";
} else {
       textDarkMode.style.display = "block";
       darkmode.style.display = "block";
       lightmode.style.display = "none";
       textLightMode.style.display = "none";
}


btndarkMode.addEventListener("click", function () {
    body.classList.toggle("dark") 
    if( body.classList.contains("dark")){
        localStorage.setItem("theme","dark")
        darkmode.style.display = "none";
        lightmode.style.display = "block";
        textLightMode.style.display = "block";
        textDarkMode.style.display = "none";
    } else {
        localStorage.removeItem("theme");
        darkmode.style.display = "block";
        lightmode.style.display = "none";
        textDarkMode.style.display = "block";
        textLightMode.style.display = "none";
        
    }
})


