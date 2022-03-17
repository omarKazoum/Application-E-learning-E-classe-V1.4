
const enableErrorOn=(el,enable,message)=>{
    let parent=el.parentNode;
    let messageEl;
    if(parent.getElementsByClassName('error').length>0){
        //so the error element already exists
        messageEl=parent.getElementsByClassName('error')[0];
    }else{
        messageEl=document.createElement('div')
        messageEl.classList.add('error');
        parent.insertBefore(messageEl,el);
    };
    messageEl.innerHTML=message;
    if(enable){
        messageEl.style.display='block';
        el.classList.add('border','border-danger')
    }else{
        messageEl.style.display='none';
        el.classList.remove('border','border-danger');
    };
}
/**
 * enables form validation for all Form Html elements in the calling html page
 * @param callback a callback to be called if all inputs are valid (takes an optional form object representing the valid form)
 * use data-validate='1' to specify which you want to validate
 * use data-validate-pattern='regex' to specify a pattern to respect
 * use data-validate-message='1' to specify a message to display above the input the element if it does not respect data-validate-pattern
 */
const bindFormValidator=(callback=null) =>{
    document.querySelectorAll('form').forEach((form) => {
        console.log('bound form '+form);
        console.log(form);
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const inputs = e.target.querySelectorAll("[data-validate='1']");
            let allValide = true;
            for (let i=0;i<inputs.length;i++) {
                input=inputs[i];

                console.log("bound:"+input.name);
                let isInputValide = input.value.match(input.dataset.validatePattern);
                if(input.hasAttribute('data-validate-match')){
                   let elementToMatch= document.getElementById(input.dataset.validateMatch);
                    isInputValide=input.value==elementToMatch.value;
                }
                if (!isInputValide) allValide = false;
                enableErrorOn(input, !isInputValide, input.dataset.validateMessage);
            }

            if (allValide) {
                console.log(callback);
                if (callback!=null)
                    callback(form);
                else form.submit();
            }
        })
    });
}