
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
    messageEl.textContent=message;
    if(enable){
        messageEl.style.display='block';
        el.classList.add('border','border-danger')
    }else{
        messageEl.style.display='none';
        el.classList.remove('border','border-danger');
    };
}
const bindFormValidator=(callback=null) =>{
    document.querySelectorAll('form').forEach((form) => {
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const inputs = e.target.querySelectorAll("[data-validate='1']");
            let allValide = true;
            for (let input of inputs) {
                const isInputValide = input.value.match(input.dataset.validatePattern);
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