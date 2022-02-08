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

        axios.put("/users_comments/" + id,{'text':comment})
            .then(res=> {
                if (res.status == 200) {
                    let success_msg=res.data.success_msg;
                    let success_ele=document.getElementById('success_msg');

                    success_ele.textContent=success_msg;
                    success_ele.style.display='';
                }
            })
            .catch(err=>{
                let error   = err.response.data.errors.text[0],
                    err_ele = document.getElementById('error');

                err_ele.textContent=error;
                err_ele.style.display='';
            })
}

//delete comment
generalEventListener('click', '#delete_icon', e => {
    let id      = e.target.getAttribute('data-id');

    axios.delete("/users_comments/" + id)
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
        axios.post("/users_comments" ,formData)
            .then(res=> {
                if (res.status == 200) {
                    let view=res.data.view;

                    document.querySelector('.comment_input').value='';
                    form_ele.insertAdjacentHTML('beforebegin',view);
                }
            })
            .catch(err=>{
                let err_res=err.response;
                if (err_res.status == 422) {
                    let error   = err_res.data.errors.text[0];
                    if (error) {
                        err_ele = document.querySelector(`#form_comment${id} #comment_err`);

                        err_ele.textContent=error;
                        err_ele.style.display='';
                    }
                }
            })
    }
    
})


//infinite scroll for posts
let posts_data=true;
function loadPages(post_id) {
    axios.get("/users_posts/"+post_id)
        .then(res=> {
            if (res.status == 200) {
                let view      = res.data.view;
                document.querySelector('.parent').insertAdjacentHTML('beforeend', view);
            }
        })
        .catch(err=>{
            if (err.response.status == 404) {
                posts_data=false;
            }
        })
}


window.onscroll = function () {
    if (window.scrollY + window.innerHeight-54 >= document.body.clientHeight) {
        if (posts_data != false) {
            let post_id=document.getElementsByClassName('parent')[0].lastElementChild.id;
            loadPages(post_id);
        }
    }
}

//infinite scroll for comments
let comments_data=true;
const comments_box=document.querySelector('.card-bottom');
function loadPages(post_id) {
    axios.get("/users_comments/"+post_id)
        .then(res=> {
            if (res.status == 200) {
                let view      = res.data.view;
                document.querySelector('.parent').insertAdjacentHTML('beforeend', view);
            }
        })
        .catch(err=>{
            if (err.response.status == 404) {
                comments_data=false;
            }
        })
}


comments_box.onscroll = function () {
    if (comments_box.scrollHeight - comments_box.scrollTop == comments_box.offsetHeight) {
        //if (comments_data != false) {
            let post_id=this.getAttribute('data-post_id');
            let comment_id=document.querySelector('.parent_comments'+post_id).lastElementChild.getAttribute('data-comment_id');
            
            //loadPages(post_id);
        //}
    }
}
