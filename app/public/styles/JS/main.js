//******************************
// ========================
//  variables
// ========================
//******************************
 const btndarkMode = document.querySelector(".btnsHeader")
 const body = document.querySelector("")




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

btndarkMode.addEventListener("click", function () {
    console.log("coucou");
        body.classList.toggle("dark");
    if (body.classList.contains("dark") && moonImg.style.display === "block") {
        localStorage.setItem("theme", "dark");
        img.classList.add("dark");
        moonImg.style.display = "none";
        sunImg.style.display = "block";
    } else if (sunImg.style.display === "block") {
        localStorage.removeItem("theme");
        moonImg.style.display = "block";
        sunImg.style.display = "none";
    }
});
