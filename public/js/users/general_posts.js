window.onload=()=>{
    //scroll to comment input
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
        let target        = e.target,
            id            = target.getAttribute('data-post_id'),
            com_req       = target.getAttribute('data-com_req');

        if (com_req == 'false') {
            axios.get('/'+lang+"/comment/" + id)
                .then(res=> {
                    if (res.status == 200) {
                        let view      = res.data.view;
                        document.querySelector('.parent_comments'+id).insertAdjacentHTML('beforeend', view);

                        target.setAttribute('data-com_req','true');
                        target.textContent = 'hide all comments';
                    }
                })
                .catch(err=>{
                    if (err.response.status == 404) {
                        target.setAttribute('data-com_req','true');
                    }
                })
        }

        let comments      = document.getElementsByClassName('com' + id);
        if (comments) {
            for (let i = 0; i < comments.length; i++) {
                if (comments[i].style.display === 'none') {
                    comments[i].style.display = '';
                    target.textContent = 'hide all comments';
                } else {
                    comments[i].style.display = 'none';
                    target.textContent = 'view comments';
                }
            }
        }
    })


    //infinite scroll for comments
    function loadCommentsOnScroll() {
        const comments_box = document.getElementsByClassName('card-bottom');

        function loadComments(com_id, post_id) {
            axios.get('/' + lang + "/comment/show_more/" + com_id + '/' + post_id)
                .then(res => {
                    if (res.status == 200) {
                        let view = res.data.view;
                        document.querySelector('.parent_comments' + post_id).insertAdjacentHTML('beforeend', view);
                    }
                })
                .catch(err => {
                    if (err.response.status == 404) {
                        document.getElementById('post_' + post_id).setAttribute('data-comments', 'false');
                    }
                })
        }

        for (let i = 0; i < comments_box.length; i++) {
            comments_box[i].onscroll = function () {
                if (comments_box[i].scrollHeight - comments_box[i].scrollTop == comments_box[i].offsetHeight) {
                    let comments_data = this.getAttribute('data-comments');
                    if (comments_data != 'false') {
                        let post_id = this.getAttribute('data-post_id'),
                            com_id = document.querySelector('.parent_comments' + post_id).lastElementChild.getAttribute('data-comment_id');

                        loadComments(com_id, post_id);
                    }
                }
            }

        }

    }

    loadCommentsOnScroll()


    //edit comment
    generalEventListener('click', '.edit_comment', e => {
        let com_id       = e.target.getAttribute('data-comment_id'),
            post_id      = e.target.getAttribute('data-post_id'),
            comment      = document.querySelector('#comm'+com_id+' p span').innerText,
            update_btn   = document.getElementById('update_btn'),
            update_input = document.querySelector('#update_input');

            console.log(comment)
        update_btn.setAttribute('data-comment_id',com_id);
        update_btn.setAttribute('data-post_id',post_id);

        update_input.textContent = comment;
    })

    //update comment
    let update_btn         = document.getElementById('update_btn');
        update_btn.onclick = function(){
            let com_id  = this.getAttribute('data-comment_id'),
                post_id = this.getAttribute('data-post_id'),
                comment = document.getElementById('update_input').textContent;

            axios.put('/'+lang+"/comment/" + com_id,{'text':comment,'post_id':post_id})
                .then(res=> {
                    if (res.status == 200) {
                        let success_msg = res.data.success_msg,
                            success_ele = document.getElementById('success_msg');

                        success_ele.textContent=success_msg;
                        success_ele.style.display='';

                        document.querySelector('#comm'+com_id+' p span').textContent=comment
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
    generalEventListener('click', '.fa-trash', e => {
        const target     = e.target,
            delete_btn = document.getElementById('delete_btn');

        let com_id  = target.getAttribute('data-comment_id'),
            post_id = target.getAttribute('data-post_id');
            
            delete_btn.setAttribute('data-comment_id',com_id);
            delete_btn.setAttribute('data-post_id',post_id);
    })

    generalEventListener('click', '#delete_btn', e => {
        const target  = e.target;
        let com_id  = target.getAttribute('data-comment_id'),
            post_id = target.getAttribute('data-post_id');

        axios.delete('/'+lang+"/comment/" + com_id)
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
            axios.post('/'+lang+"/comment" ,formData)
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


    //like or unlike
    generalEventListener('click', '.like', e => {
        let target  = e.target,
            post_id = target.getAttribute('data-post_id');
        
        axios.post('/'+lang+"/like/store" ,{'post_id':post_id})
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

    //share post
    generalEventListener('click', '.share', e => {
        let target  = e.target,
            post_id = target.getAttribute('data-post_id');
        
        document.getElementById('share_btn').setAttribute('data-post_id',post_id);
    })

    generalEventListener('click', '#share_btn', e => {
        let target  = e.target,
            post_id = target.getAttribute('data-post_id');
        
        axios.post('/'+lang+"/share/store" ,{'post_id':post_id})
            .then(res=> {
                if (res.status == 200) {
                    const share_ele = document.querySelector('.share_num'+post_id);
                    let share_num = Number(share_ele.textContent),
                        view      = res.data.view;

                    share_num++;
                    share_ele.textContent=share_num;

                    document.querySelector('.parent_posts').insertAdjacentHTML('afterbegin',view);
                }
            })
            .catch(err=>{
                let error=err.response;
                if (error.status == 404) {
                    const error_ele = document.getElementById('error_share');
                    let   error_msg = error.data.error;
                    
                    if (error_msg) {
                        error_ele.style.display='';
                        error_ele.textContent=error_msg;

                        setTimeout(function(){
                            error_ele.style.display='none';
                        },4000)
                    }
                    
                }
            })
    })

    //delete post
    generalEventListener('click', '.delete_post', e => {
        let target  = e.target,
            post_id = target.getAttribute('data-post_id');
        
        document.getElementById('delete_post_btn').setAttribute('data-post_id',post_id);
    })

    generalEventListener('click', '#delete_post_btn', e => {
        let target  = e.target,
            post_id = target.getAttribute('data-post_id');
        
        axios.delete('/'+lang+"/post/"+post_id ,{'post_id':post_id})
            .then(res=> {
                if (res.status == 200) {
                    let msg=res.data.success_msg;
                    const msg_ele=document.getElementById('delete_post_msg');
                    
                    msg_ele.textContent=msg;
                    msg_ele.style.display='';
                    
                    setTimeout(function(){
                        msg_ele.style.display='none';
                    },4000)

                    document.querySelector('.post'+post_id).remove();
                }
            })
            .catch(err=>{
                let error=err.response;
                if (error.status == 404) {
                    const error_ele=document.getElementById('error_delete_post');
                    let error_msg=error.data.error;

                    error_ele.style.display='';
                    error_ele.textContent=error_msg;
                    
                    setTimeout(function(){
                        error_ele.style.display='none';
                    },4000)
                }
            })
    })

    //edit post
    const text_ele = document.querySelector('.edit_text'),
        btn_ele  = document.getElementById('edit_post_btn');

    generalEventListener('click', '.edit_post', e => {
        let target    = e.target,
            post_id   = target.getAttribute('data-post_id'),
            post_text = document.querySelector('.text'+post_id).innerText ;

            text_ele.value=post_text;

            btn_ele.setAttribute('data-post_id',post_id);
    })

    btn_ele.onclick=function(e){
        let post_id  = e.target.getAttribute('data-post_id'),
            form     = document.getElementById('edit_post_form'),
            formData = new FormData(form);

        axios.post('/'+lang+"/post/"+post_id ,formData)
            .then(res=> {
                if (res.status == 200) {
                    let res_data    = res.data,
                        text        = text_ele.value;
                        success_msg = res_data.success,
                        post        = res_data.post;
                        
                    const success_ele = document.getElementById('edit_post_msg');

                    success_ele.textContent=success_msg;
                    success_ele.style.display='';

                    document.querySelector('.text'+post_id).textContent=text;

                    if (post.photo) {
                        const photo_ele=document.querySelector('.photo'+post_id);

                        photo_ele.src='/images/posts/'+post.photo;
                        photo_ele.style.display='';
                    }

                    if (post.file) {
                        const file_ele=document.querySelector('.file'+post_id);

                        file_ele.src='/files/'+post.file;
                        file_ele.style.display='';
                    }

                    if (post.video) {
                        const video_ele=document.querySelector('.video'+post_id);

                        video_ele.src='/videos/'+post.video;
                        video_ele.style.display='';
                    }
                }
            })
            .catch(err=>{
                let error=err.response;
                if (error.status == 422) {
                    let err_msgs=error.data.errors;
                    for (const [key, value] of Object.entries(err_msgs)) {
                        document.getElementById(key+'_edit_err').textContent=value[0];
                    }
                }
            })
    }

}
