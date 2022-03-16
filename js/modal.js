const modal=$('#modal');
modal.showModal=()=>{
    modal.modal('show');
}
const modalBody=document.querySelector('#modalBody');
const sendAjaxForModalContent=(method,url)=>{
    modal.showModal();
    modalBody.textContent='loading ...';
    try {
        let request = new XMLHttpRequest();
        request.open('GET',url);
        request.onreadystatechange = () => {
            if (request.readyState === 4) {
                // so the form is loaded
                modalBody.innerHTML = request.response;
            }
        }
        request.send();
    }catch(ex){
        console.error(ex);
        modalBody.textContent="<p class='error'>failed to load content</p>"
    }
}
// handling btns with link to be opened in a dialog
document.querySelectorAll('.btn-display-in-modal').forEach((editBtn)=>{
    editBtn.addEventListener('click',(e)=>{
        e.preventDefault();
        sendAjaxForModalContent('GET',e.target.href);
    })
})
//handlign btns with a location to only be opend if confirmed with a predifined message
document.querySelectorAll("[data-confirm='1']").forEach((btn)=>{
    btn.addEventListener('click',(event)=>{
        if(confirm(event.target.dataset.confirmMessage)===false)
            event.preventDefault();
    })

})