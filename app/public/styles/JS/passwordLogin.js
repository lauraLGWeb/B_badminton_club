
    const password = document.getElementById("password");
    const viewPicto = document.getElementById("viewPicto");
    let hidePwd =true;

    const viewPath = viewPicto.dataset.view;
    const hidePath = viewPicto.dataset.hide; 


  //login
    viewPicto.addEventListener("click", function(){
        if(hidePwd){
            password.type="text";
            hidePwd=false;
            //change the picture
            viewPicto.src = hidePath;  
                      
        } else {
             password.type="password";
             hidePwd=true;
             viewPicto.src = viewPath;
        }        
     })

