const modal=$('#modal');
modal.showModal=()=>{
    modal.modal('show');
}
const modalBody=document.querySelector('#modalBody');
const btnAddStudents=document.querySelector('.btn-add-students');
const deleteBtns=document.querySelectorAll('.btn-delete');
const editBtns=document.querySelectorAll('.btn-edit');

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
btnAddStudents.addEventListener('click',(e)=>{
    e.preventDefault();
    sendAjaxForModalContent('GET',e.target.href);
})

deleteBtns.forEach((deleteBtn)=>{
    deleteBtn.addEventListener('click',(e)=>{
        console.log('editClicked');
        let userName=e.target.parentNode.parentNode.querySelector('.userName').textContent;
        let message=`are you sure you what to delete ${userName}`;
        if(confirm(message)==true){
            //window.location.href=e.target.href;
        }else {
            e.preventDefault();
            alert('thank you for letting the student live for another day');
        }
    });
});
// handling edit btns
editBtns.forEach((editBtn)=>{
    editBtn.addEventListener('click',(e)=>{
        e.preventDefault();
        sendAjaxForModalContent('GET',e.target.href);
    })
})
//handling add user
//const addUSerBtn=document.querySelector('');