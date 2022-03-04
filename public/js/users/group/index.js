//infinite scrolling for posts
const parent_posts = document.querySelector('.parent_posts');

function loadPages(page_code) {
    axios.post("?cursor=" + page_code, { 'agax': 1 })
        .then(res => {
            if (res.status == 200) {
                let view = res.data.view,
                    cursor = res.data.page_code;

                parent_posts.setAttribute('data-page_code', cursor);
                parent_posts.insertAdjacentHTML('beforeend', view);
            }
        })
}

window.onscroll = function () {
    if (window.scrollY + window.innerHeight - 54 >= document.body.clientHeight) {
        let page_code = parent_posts.getAttribute('data-page_code');
        if (page_code) {
            loadPages(page_code);
        }
    }
}

//join group
let group_id = document.getElementById('group_id').value,
    auth_id = document.getElementById('auth_id').value;

if (group_id != auth_id) {
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
const request_tap = document.querySelector('.requests_tap');
request_tap.onclick = function () {
    let group_id = this.getAttribute('data-group_id');

    axios.get("/group/users/" + group_id)
        .then(res => {
            if (res.status == 200) {

            }
        })
}