//scroll to comment_input
generalEventListener('click', '.comment_btn', e => {
    let id    = e.target.id,
        input = document.getElementById('input' + id);

    input.scrollIntoView({
        behavior: 'smooth',
        block   : 'center'
    });

    input.focus()
})

//view comments
generalEventListener('click','.view_comments',e=>{
    let id            = e.target.classList[1];
        view_comments = document.getElementById('view'+id)
        comments      = document.getElementsByClassName('com' + id);

    for (let i = 0; i < comments.length; i++) {
        if (comments[i].style.display === 'none') {
            comments[i].style.display = '';
            view_comments.textContent = 'hide all comments';
        } else {
            comments[i].style.display = 'none';
            view_comments.textContent = 'view all comments';
        }
    }
})


//edit comment
generalEventListener('click', '.fa-edit', e => {
    let id           = e.target.classList[2],
        comment      = document.querySelector('#comm'+id+' p span').textContent,
        update_btn   = document.getElementById('update_btn'),
        update_input = document.querySelector('#update_input');

    update_btn.setAttribute('comment_id',id)
    update_input.textContent = comment;
})

//update comment
let update_btn         = document.getElementById('update_btn');
    update_btn.onclick = function(){
        let id      = this.getAttribute('comment_id'),
            comment = document.getElementById('update_input').textContent;

        axios.put("/comments/" + id,{'text':comment})
            .then(res=> {
                if (res.status == 200) {
                    let success_msg=res.data.success_msg;
                    let success_ele=document.getElementById('success_msg');

                    success_ele.textContent=success_msg;
                    success_ele.style.display='';
                }
            }).catch(err=>{
                let error   = err.response.data.errors.text[0],
                    err_ele = document.getElementById('error');

                err_ele.textContent=error;
                err_ele.style.display='';
            })
}

//delete comment
generalEventListener('click', '#delete_icon', e => {
    let id      = e.target.getAttribute('data-id');

    axios.delete("/comments/" + id)
        .then(res=> {
            if (res.status == 200) {
                document.getElementById('comm'+id).remove();
            }
        })
})

//post comments
generalEventListener('keypress', '.comment_input', e => {
    let id       = e.target.getAttribute('data-post_id');
        form_ele = document.getElementById('form_comment'+id),
        formData = new FormData(form_ele);
    
    if (e.keyCode == 13) {
        axios.post("/comments" ,formData)
        .then(res=> {
            if (res.status == 200) {
                let view=res.data.view;

                document.querySelector('.comment_input').value='';
                form_ele.insertAdjacentHTML('beforebegin',view);
            }
        })
    }
    
})


//infinite scroll
