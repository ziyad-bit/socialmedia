//load posts by infinite scrolling
const parent_posts = document.querySelector('.parent_posts'); 

function loadPages(page_code) {
    axios.post("?cursor=" + page_code)
        .then(res=> {
            if (res.status == 200) {
                let view   = res.data.view,
                    cursor = res.data.page_code;
                
                parent_posts.setAttribute('data-page_code',cursor);
                parent_posts.insertAdjacentHTML('beforeend', view);
            }
        })
}

window.onscroll = function () {
    if (window.scrollY + window.innerHeight-54 >= document.body.clientHeight) {
        let page_code = parent_posts.getAttribute('data-page_code');
        if (page_code) {
            loadPages(page_code);
        }
    }
}

//add friend
generalEventListener('click','.add_btn',e=>{
    let target    = e.target,
        friend_id = target.getAttribute('data-user_id');
    
    axios.post('/'+lang+'/friend',{'friend_id':friend_id})
        .then(res=>{
            if (res.status == 200) {
                target.disabled    = true;
                target.textContent = "awaiting approval";
            }
        })
})

//unfriend
generalEventListener('click','.unfriend_btn',e=>{
    let target        = e.target,
        friend_req_id = target.getAttribute('data-friend_req_id');
    
    axios.delete('/'+lang+'/friend/'+friend_req_id)
        .then(res=>{
            if (res.status == 200) {
                let msg=res.data.success;

                const msg_ele = document.querySelector('.profile_msg');
                    
                msg_ele.textContent=msg;
                msg_ele.style.display='';

                document.querySelector('.unfriend_btn').remove();
            }
        })
})