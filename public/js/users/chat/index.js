window.onload = function () {
    const users_box = document.getElementById('list-tab');
    //load pages by infinite scrolling
    function loadPages(page) {
        axios.post("?page=" + page, { 'agax': 1 })
            .then(res => {
                if (res.status == 200) {
                    let users  = res.data.friends_user.data;

                    if (users.length > 0) {
                        for (let i = 0; i < users.length; i++) {
                            users_box.insertAdjacentHTML('beforeend',
                                    `
                                    <button class="user${users[i].id} nav-link list-group-item list-group-item-action "
                                        id="list-home-list" data-bs-toggle="pill" data-bs-target="#chat_box${users[i].id}" role="tab"
                                        data-id=${users[i].id} aria-controls="home"
                                        >${users[i].name} 

                                        <img class="rounded-circle" src="/images/users/${users[i].photo}" alt="loading">
                                    </button>
                                    `
                                );
                        }
                    }else{
                        users_box.setAttribute('data-status', '0');
                    }
                }
            })
    }

    let page=1;
    users_box.onscroll = function () {
        let scrolly    = users_box.scrollHeight - users_box.scrollTop;
        let box_height = users_box.offsetHeight;
        

        if (box_height == scrolly) {
            let data_status = users_box.getAttribute('data-status');

            page++
            if (data_status == '1') {
                loadPages(page);
            }
        }
    }

    /*
        //approve friend request
        generalEventListener('click','.approve_btn',e=>{
            let friend_req_id=e.target.getAttribute('data-friend_req_id');
            axios.put('/friends/'+friend_req_id)
                .then(res=>{
                    if (res.status == 200) {
                        document.querySelector(`[data-friend_req="${friend_req_id}"]`)
                            .style.display='none';
                    }
                })
        })
    
        //ignore friend request
        generalEventListener('click','.ignore_btn',e=>{
            let friend_req_id=e.target.getAttribute('data-friend_req_id');
            axios.get('/friends/'+friend_req_id)
                .then(res=>{
                    if (res.status == 200) {
                        document.querySelector(`[data-friend_req="${friend_req_id}"]`)
                            .style.display='none';
                    }
                })
        })
        */
}

