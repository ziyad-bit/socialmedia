//infinite scrolling for posts
let posts_status = true,
    reqs_status  = false;

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
    if (window.scrollY + window.innerHeight - 54 >= document.body.clientHeight) {
        let page_code = parent_posts.getAttribute('data-page_code');
        
        if (page_code && posts_status == true) {
            loadPages(page_code);
        }
    }
}

document.getElementById('nav-posts-tab').onclick=function(){
    posts_status =true;
}

//join group
let group_id    = document.getElementById('group_id').value,
    group_owner = document.getElementById('group_owner').value,
    auth_id     = document.getElementById('auth_id').value;

if (group_owner != auth_id) {
    const join_btn = document.querySelector('.join_btn');
    join_btn.onclick = function () {
        axios.post("/group/users", { 'group_id': group_id })
            .then(res => {
                if (res.status == 200) {
                    this.disabled = true;
                    this.textContent = "awaiting approval";
                }
            })
    }
}

//show requests
const parent_requests=document.querySelector('.parent_requests');
let reqs_page_code=parent_requests.getAttribute('data-page_code');

function getRequests(reqs_page_code,group_id) {
    axios.get("/group/users/" + group_id +'?cursor='+reqs_page_code)
        .then(res => {
            if (res.status == 200) {
                let view           = res.data.view;
                    reqs_page_code = res.data.page_code;
                
                parent_requests.insertAdjacentHTML('beforeend',view);
                parent_requests.setAttribute('data-page_code',reqs_page_code);
            }
        })
}

const request_tap = document.querySelector('.requests_tap');
let reqs_click=false;
request_tap.onclick = function () {
    reqs_status  = true;
    posts_status = false;

    if (reqs_click == false) {
        getRequests(reqs_page_code , group_id)
    }
    reqs_click=true;
}

parent_requests.onscroll = function () {
    if (parent_requests.scrollHeight - parent_requests.scrollTop == parent_requests.offsetHeight) {
        let reqs_page_code=parent_requests.getAttribute('data-page_code');
        if (reqs_page_code && reqs_status == true) {
            getRequests(reqs_page_code ,group_id);
        }
    }
}
