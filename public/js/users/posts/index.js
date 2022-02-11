//scroll to comment_input
generalEventListener('click', '.comment_icon', e => {
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
        let id            = this.getAttribute('comment_id'),
            comment       = document.getElementById('update_input').textContent;

        axios.put("/user_comment/" + id,{'text':comment})
            .then(res=> {
                if (res.status == 200) {
                    let success_msg=res.data.success_msg,
                    success_ele=document.getElementById('success_msg');

                    success_ele.textContent=success_msg;
                    success_ele.style.display='';

                    document.querySelector('#comm'+id+' p span').textContent=comment
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
    const target=e.target;
    let com_id  = target.getAttribute('data-id'),
        post_id = target.getAttribute('data-post_id');

    axios.delete("/user_comment/" + com_id)
        .then(res=> {
            if (res.status == 200) {
                document.getElementById('comm'+com_id).remove();

                const comment_ele=document.querySelector('.com_num'+post_id);
                let com_num=Number(comment_ele.textContent);

                com_num--;
                comment_ele.textContent=com_num;
            }
        })
})

//post comments
generalEventListener('keypress', '.comment_input', e => {
    let id       = e.target.getAttribute('data-post_id');
        form_ele = document.getElementById('form_comment'+id),
        formData = new FormData(form_ele);
    
    if (e.keyCode == 13) {
        axios.post("/user_comment" ,formData)
            .then(res=> {
                if (res.status == 200) {
                    let view=res.data.view;

                    document.querySelector('.comment_input').value='';
                    form_ele.insertAdjacentHTML('beforebegin',view);

                    const comment_ele=document.querySelector('.com_num'+id);
                    let com_num=Number(comment_ele.textContent);

                    com_num++;
                    comment_ele.textContent=com_num;
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

//infinite scroll for comments
function loadCommentsOnScroll(){
    let comments_data=true;
    const comments_box=document.getElementsByClassName('card-bottom');

    function loadComments(com_id,post_id) {
        axios.get("/users_comments/show_more/"+com_id+'/'+post_id)
            .then(res=> {
                if (res.status == 200) {
                    let view      = res.data.view;
                    console.log(view)
                    document.querySelector('.parent_comments'+post_id).insertAdjacentHTML('beforeend', view);
                }
            })
            .catch(err=>{
                if (err.response.status == 404) {
                    comments_data=false;
                }
            })
    }

    for (let i = 0; i < comments_box.length; i++) {
        comments_box[i].onscroll = function () {
            if (comments_box[i].scrollHeight - comments_box[i].scrollTop == comments_box[i].offsetHeight) {
                if (comments_data != false) {
                    let post_id = this.getAttribute('data-post_id'),
                        com_id  = document.querySelector('.parent_comments'+post_id).lastElementChild.getAttribute('data-comment_id');
                    
                    loadComments(com_id,post_id);
                }
            }
        }
        
    }
    
}

loadCommentsOnScroll()

//infinite scroll for posts
let posts_data=true;
function loadPages(post_id) {
    axios.get("/users_posts/"+post_id)
        .then(res=> {
            if (res.status == 200) {
                let view      = res.data.view;
                document.querySelector('.parent').insertAdjacentHTML('beforeend', view);

                loadCommentsOnScroll()
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

//like or unlike

generalEventListener('click', '.like', e => {
    let target  = e.target,
        post_id = target.getAttribute('data-post_id');
    
    axios.post("/users_likes/store" ,{'post_id':post_id})
        .then(res=> {
            if (res.status == 200) {
                const like_ele = document.querySelector('.like_num'+post_id);
                let like_num = Number(like_ele.textContent);

                if (target.classList.contains('liked_icon')) {
                    target.classList.remove('liked_icon')
                    target.classList.add('like_icon')

                    like_num--;
                }else{
                    target.classList.remove('like_icon')
                    target.classList.add('liked_icon')
    
                    like_num++;
                }

                like_ele.textContent=like_num;
            }
        })
})

