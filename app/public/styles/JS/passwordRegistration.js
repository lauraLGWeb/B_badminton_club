
    const passwordRegistration = document.getElementById("registration_form_plainPassword");
    const viewPictoRegistration = document.getElementById("viewPictoRegistration");
    let hidePwda =true;
    
    const viewPathRegistration = viewPictoRegistration.dataset.viewpathregistration;
    const hidePathRegistration = viewPictoRegistration.dataset.hidepathregistration;
   

     viewPictoRegistration.addEventListener("click", function(){
         if(hidePwda){
            passwordRegistration.type="text";
            hidePwda=false;
            //change the picture
            viewPictoRegistration.src = hidePathRegistration;  
                      
        } else {
             passwordRegistration.type="password";
             hidePwda=true;
             viewPictoRegistration.src = viewPathRegistration;
        }        
     })


  
   