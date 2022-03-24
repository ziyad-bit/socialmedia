//infinite scrolling for posts
let posts_status   = true,
    reqs_status    = false,
    members_status = false,
    admins_status  = false;

group_req_id   = document.getElementById('group_req_id').value;

const parent_posts = document.querySelector('.parent_posts');

function loadPages(page_code) {
    axios.post("?cursor=" + page_code, { 'agax': 1 })
        .then(res => {
            if (res.status == 200) {
                let view   = res.data.view,
                    cursor = res.data.page_code;

                parent_posts.setAttribute('data-page_code', cursor);
                parent_posts.insertAdjacentHTML('beforeend', view);
            }
        })
}

window.onscroll = function () {
    if (window.scrollY + window.innerHeight - 70 >= document.body.clientHeight) {
        let page_code = parent_posts.getAttribute('data-page_code'),
            punish    = document.getElementById('punish').value;

        if (page_code && posts_status == true && punish == 0) {
            loadPages(page_code);
        }
    }
}

document.getElementById('nav-posts-tab').onclick = function () {
    posts_status   = true;
    reqs_status    = false;
    members_status = false;
    admins_status  = false;
}

//join group
let group_id    = document.getElementById('group_id').value,
    group_owner = document.getElementById('group_owner').value,
    auth_id     = document.getElementById('auth_id').value;

if (group_owner != auth_id) {
    const join_btn = document.querySelector('.join_btn');
    join_btn.onclick = function () {
        axios.post("/group/reqs", { 'group_id': group_id })
            .then(res => {
                if (res.status == 200) {
                    this.disabled = true;
                    this.textContent = "awaiting approval";
                }
            })
    }
}

//show requests
const parent_requests = document.querySelector('.parent_requests');
if (parent_requests) {
    let reqs_page_code = parent_requests.getAttribute('data-page_code');
        
    function getRequests(reqs_page_code, group_req_id) {
        axios.get("/group/reqs/" + group_req_id + '?cursor=' + reqs_page_code)
            .then(res => {
                if (res.status == 200) {
                    let view           = res.data.view;
                        reqs_page_code = res.data.page_code;

                    if (view == '') {
                        parent_requests.insertAdjacentHTML('beforeend', 

                            '<h3 style="margin-left:5px">No requests</h3>');
                    }

                    parent_requests.insertAdjacentHTML('beforeend', view);
                    parent_requests.setAttribute('data-page_code', reqs_page_code);
                }
            })
    }

    const request_tap = document.querySelector('.requests_tap');
    let reqs_click = false;
    if (request_tap) {
        request_tap.onclick = function () {
            reqs_status    = true;
            posts_status   = false;
            members_status = false;
            admins_status  = false;

            if (reqs_click == false) {
                getRequests(reqs_page_code, group_req_id)
            }
            reqs_click = true;
        }
    }

    //load requests on scroll
    parent_requests.onscroll = function () {
        if (parent_requests.scrollHeight - parent_requests.scrollTop == parent_requests.offsetHeight) {
            let reqs_page_code = parent_requests.getAttribute('data-page_code');
            if (reqs_page_code && reqs_status == true) {
                getRequests(reqs_page_code, group_req_id);
            }
        }
    }

    //approve request
    generalEventListener('click', '.btn_approve', e => {
        let group_req_id = e.target.getAttribute('data-group_req_id');
        axios.put('/group/reqs/' + group_req_id)
            .then(res => {
                if (res.status == 200) {
                    let success_msg = res.data.success;

                    const success_msg_ele = document.querySelector('.success_msg');

                    success_msg_ele.textContent   = success_msg;
                    success_msg_ele.style.display = '';

                    setTimeout(() => {
                        success_msg_ele.style.display = 'none';
                    }, 3000);

                    document.querySelector('.group_user' + group_req_id).remove();
                }
            })
    })

    //ignore request
    generalEventListener('click', '.btn_ignore', e => {
        let group_req_id = e.target.getAttribute('data-group_req_id');
        axios.put('/group/reqs/ignore/' + group_req_id)
            .then(res => {
                if (res.status == 200) {
                    let success_msg = res.data.success;

                    const success_msg_ele = document.querySelector('.success_msg');

                    success_msg_ele.textContent   = success_msg;
                    success_msg_ele.style.display = '';

                    setTimeout(() => {
                        success_msg_ele.style.display = 'none';
                    }, 3000);

                    document.querySelector('.group_user' + group_req_id).remove();
                }
            })
    })
}


//show members
const parent_members    = document.querySelector('.parent_members');
let   members_page_code = parent_members.getAttribute('data-page_code');

function getMembers(members_page_code, group_req_id) {
    axios.get("/group-users/" + group_req_id + '?cursor=' + members_page_code)
        .then(res => {
            if (res.status == 200) {
                let view              = res.data.view;
                    members_page_code = res.data.page_code;

                    if (view == '') {
                        parent_members.insertAdjacentHTML('beforeend', 

                            '<h3 style="margin-left:5px">No members</h3>');
                    }

                    parent_members.insertAdjacentHTML('beforeend', view);
                    parent_members.setAttribute('data-page_code', members_page_code);
            }
        })
}

const members_tab   = document.querySelector('.members_tab');
let   members_click = false;

members_tab.onclick = function () {
    console.log(1)
    members_status = true;
    reqs_status    = false;
    posts_status   = false;
    admins_status  = false;

    if (members_click == false) {
        getMembers(members_page_code, group_req_id);
    }
    members_click = true;
}


//load members on scroll
parent_members.onscroll = function () {
    if (parent_members.scrollHeight - parent_members.scrollTop == parent_members.offsetHeight) {
        let members_page_code = parent_members.getAttribute('data-page_code');
        if (members_page_code && members_status == true) {
            getMembers(members_page_code, group_req_id);
        }
    }
}

//add admin
generalEventListener('click', '.btn_add_admin', e => {
    let group_req_id = e.target.getAttribute('data-group_req_id');
    axios.put('/group-users/' + group_req_id)
        .then(res => {
            if (res.status == 200) {
                let success_msg = res.data.success;

                const success_msg_ele = document.querySelector('.members_success_msg');

                success_msg_ele.textContent   = success_msg;
                success_msg_ele.style.display = '';

                setTimeout(() => {
                    success_msg_ele.style.display = 'none';
                }, 3000);

                document.querySelector('.group_user' + group_req_id).remove();
            }
        })
})

//delete user
generalEventListener('click', '.btn_delete', e => {
    let group_req_id = e.target.getAttribute('data-group_req_id');
    axios.delete('/group-users/' + group_req_id)
        .then(res => {
            if (res.status == 200) {
                let success_msg = res.data.success;

                const success_msg_ele = document.querySelector('.members_success_msg');

                success_msg_ele.textContent   = success_msg;
                success_msg_ele.style.display = '';

                setTimeout(() => {
                    success_msg_ele.style.display = 'none';
                }, 3000);

                document.querySelector('.group_user' + group_req_id).remove();
            }
        })
})

//punish user
generalEventListener('click', '.btn_punish', e => {
    let group_req_id = e.target.getAttribute('data-group_req_id');
    axios.put('/group-users/punish/' + group_req_id)
        .then(res => {
            if (res.status == 200) {
                let success_msg = res.data.success;

                const success_msg_ele = document.querySelector('.members_success_msg');

                success_msg_ele.textContent   = success_msg;
                success_msg_ele.style.display = '';

                setTimeout(() => {
                    success_msg_ele.style.display = 'none';
                }, 3000);

                e.target.textContent='punished';
                e.target.disabled=true;
            }
        })
})


//show admins
const parent_admins    = document.querySelector('.parent_admins');
let   admins_page_code = parent_admins.getAttribute('data-page_code');

function getAdmins(admins_page_code, group_req_id) {
    axios.get("/group-admins/" + group_req_id + '?cursor=' + admins_page_code)
        .then(res => {
            if (res.status == 200) {
                let view         = res.data.view;
                admins_page_code = res.data.page_code;

                    if (view == '') {
                        parent_admins.insertAdjacentHTML('beforeend', 
                            '<h3 style="margin-left:5px">No admins</h3>');
                    }

                    parent_admins.insertAdjacentHTML('beforeend', view);
                    parent_admins.setAttribute('data-page_code', admins_page_code);
            }
        })
}

const admins_tab   = document.querySelector('.admins_tab');
let   admins_tab_click = false;

admins_tab.onclick = function () {
    members_status = false;
    reqs_status    = false;
    posts_status   = false;
    admins_status  = true;

    if (admins_tab_click == false) {
        getAdmins(members_page_code, group_req_id)
    }
    admins_tab_click = true;
}


//load admins on scroll
parent_admins.onscroll = function () {
    if (parent_admins.scrollHeight - parent_admins.scrollTop == parent_admins.offsetHeight) {
        let members_page_code = parent_admins.getAttribute('data-page_code');

        if (members_page_code && admins_status == true) {
            getAdmins(members_page_code, group_req_id);
        }
    }
}


//remove admin
generalEventListener('click', '.btn_remove_admin', e => {
    let group_req_id = e.target.getAttribute('data-group_req_id');
    axios.put('/group-admins/' + group_req_id)
        .then(res => {
            if (res.status == 200) {
                let success_msg = res.data.success;

                const success_msg_ele = document.querySelector('.admins_success_msg');

                success_msg_ele.textContent   = success_msg;
                success_msg_ele.style.display = '';

                setTimeout(() => {
                    success_msg_ele.style.display = 'none';
                }, 3000);

                document.querySelector('.group_user' + group_req_id).remove();
            }
        })
})

//delete admin from group
generalEventListener('click', '.btn_delete_from_group', e => {
    let group_req_id = e.target.getAttribute('data-group_req_id');
    axios.delete('/group-admins/' + group_req_id)
        .then(res => {
            if (res.status == 200) {
                let success_msg = res.data.success;

                const success_msg_ele = document.querySelector('.admins_success_msg');

                success_msg_ele.textContent   = success_msg;
                success_msg_ele.style.display = '';

                setTimeout(() => {
                    success_msg_ele.style.display = 'none';
                }, 3000);

                document.querySelector('.group_user' + group_req_id).remove();
            }
        })
})