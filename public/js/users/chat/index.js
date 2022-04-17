window.onload = function () {
    const users_box = document.getElementById('list-tab');
    let old_msg=1;

    //load old messages
    function loadOldMessages(){
        const chat_box=document.getElementsByClassName('card-body')
        for (let i = 0; i < chat_box.length; i++) {
            chat_box[i].onscroll=function(){
                if (chat_box[i].scrollTop == 0) {
                    if (old_msg == 1) {
                        let first_msg_id = this.firstElementChild.id,
                            reveiver_id  = this.getAttribute('data-user_id');
    
                        axios.put("/message/" + reveiver_id,{'first_msg_id':first_msg_id})
                            .then(res=> {
                                if (res.status == 200) {
                                    let messages=res.data.messages;
                            
                                    for (let i = 0; i < messages.length; i++) {
                                        this.insertAdjacentHTML('afterbegin',
                                        `
                                        <img id="${messages[i].id}" class="rounded-circle image" src="/images/users/${messages[i].users.photo}" alt="loading">
                                            <span class="user_name">${messages[i].users.name}</span>
                                            <p class="user_message"> ${messages[i].text} </p>
                                        `);
                                    }

                                    this.scrollTo({
                                        top     : 100,
                                        behavior: 'smooth'
                                    })
                                }
                            })
                            .catch(err=>{
                                old_msg=0;
                            })
                    }
                }
            }
            
        }
    }

    loadOldMessages()

    //load friends by infinite scrolling
    let next_friends_page=1;
    function loadPages(page) {
        axios.post("?page=" + page, { 'agax': 1 })
            .then(res => {
                if (res.status == 200) {
                    let users     = res.data.auth_friends.data;
                    let next_page = res.data.auth_friends.next_page_url;

                    if (next_page == null) {
                        next_friends_page=0;
                    }

                    if (users.length > 0) {
                        for (let i = 0; i < users.length; i++) {
                            users_box.insertAdjacentHTML('beforeend',
                                `
                                    <button class="user_btn nav-link list-group-item list-group-item-action "
                                        id="list-home-list" data-bs-toggle="pill" data-bs-target="#chat_box${users[i].id}" role="tab"
                                        data-id=${users[i].id} aria-controls="home"
                                        data-status='0'>${users[i].name} 

                                        <img class="rounded-circle image" src="/images/users/${users[i].photo}" alt="loading">
                                    </button>
                                    `
                            );

                            document.querySelector('.tab-content')
                                .insertAdjacentHTML('beforeend',
                                    `
                                <div class="tab-pane fade  " id="chat_box${users[i].id}"
                                    role="tabpanel" aria-labelledby="list-home-list">
                                    <form id="form${users.id}"  >
                
                                        <div class="card" style="height: 300px">
                                            <h5 class="card-header">chat<span id="loading${users[i].id}"
                                                    style="margin-left: 50px;display:none">loading old messages</span>
                                            </h5>
    
                                            <div class="card-body " id="box${users[i].id}" data-user_id="${users[i].id}" data-old_msg='1'>
                                                
                                            </div>
                                            <input type="hidden" name="receiver_id" class="receiver_id"
                                                value="${users[i].id}">
                                            <input type="text" name="message" id="msg${users[i].id}" class="form-control"
                                                data-id="${users[i].id}">
                                            
                                            <button type="button" class="btn btn-success send_btn"
                                                data-receiver_id="${users[i].id}">Send</button>
                                        </div>
                                    </form>
                                </div>
                                `)
                        }

                        loadOldMessages()
                    }
                }
            })
    }

    let page = 1;
    users_box.onscroll = function () {
        if (users_box.offsetHeight == users_box.scrollHeight - users_box.scrollTop ) {
            if (next_friends_page == 1) {
                page++;
                loadPages(page);
            }
        }
    }

    //store message
    generalEventListener('click', '.send_btn', e => {
        let receiver_id = e.target.getAttribute('data-receiver_id'),
            message     = document.getElementById('msg' + receiver_id).value;

        axios.post('/message', { 'text': message, 'receiver_id': receiver_id })
            .then(res => {
                if (res.status == 200) {
                    let auth_name  = document.getElementById('auth_name').value,
                        auth_photo = document.getElementById('auth_photo').value;
                    const box=document.getElementById('box'+receiver_id);

                    document.getElementById('msg'+receiver_id).value='';
                    box.insertAdjacentHTML('beforeend',
                            `
                            <img class="rounded-circle image" src="/images/users/${auth_photo}" alt="loading">
                                <span class="user_name">${auth_name}</span>
                                <p class="user_message">${message}</p>
                                `
                        )
                    
                    box.scrollTo({
                        top     : 10000,
                        behavior: 'smooth'
                    })
                }
            })
    })

    //get messages for users
    function getNewMessages(id){
        const       box=document.getElementById('box'+id),
        data_status_ele=document.querySelector(`[data-id="${id}"]`);

        let data_status=data_status_ele.getAttribute('data-status');
        if (data_status == '0') {
            axios.get("/message/" + id)
            .then(res=> {
                if (res.status == 200) {
                    let messages=res.data.messages;
                    
                    for (let i = 0; i < messages.length; i++) {
                        box.insertAdjacentHTML('afterbegin',
                        `
                        <img id="${messages[i].id}" class="rounded-circle image" src="/images/users/${messages[i].users.photo}" alt="loading">
                            <span class="user_name">${messages[i].users.name}</span>
                            <p class="user_message"> ${messages[i].text} </p>
                        `);
                    }
        
                    box.scrollTo({
                        top     : 10000,
                        behavior: 'smooth'
                    });

                    data_status_ele.setAttribute('data-status','1');
                }
            }).catch(err=>{
                let error=err.response.data.error;
            
                box.insertAdjacentHTML('beforeend',
                        `
                            <h3>${error}</h3>
                        `
                    );

                data_status_ele.setAttribute('data-status','1');
            });
        }
    }

    //get messages for first user
    let id=document.getElementsByClassName('index_0')[0].getAttribute('data-id');
    if (id) {
        let data_status=document.querySelector(`[data-id="${id}"]`).getAttribute('data-status');
        if (data_status == '0') {
            getNewMessages(id);
        }
        
    }
    
    //get messages for other users
    generalEventListener('click','.user_btn',e=>{
        let id=e.target.getAttribute('data-id');
        let data_status=document.querySelector(`[data-id="${id}"]`).getAttribute('data-status');

        if (data_status == '0') {
            getNewMessages(id);
        }
    })
    


    //subscribe chat channel and listen to event
    let auth_id=document.getElementById('auth_id').value;
    Echo.private(`chat.${auth_id}`)
        .listen('MessageSend', (e) => {
            console.log(e)
            const box=document.getElementById('box' + e.sender_id);

            box.insertAdjacentHTML('beforeend',
                    `
                    <img  class="rounded-circle image" src="/images/users/${e.user_photo}" alt="loading">
                    <span class="user_name">${e.user_name}</span>
                    <p class="user_message">${e.text}</p>
                    `
            )

            box.scrollTo({
                top     : 10000,
                left    : 0,
                behavior: 'smooth'
            })
        });
}

