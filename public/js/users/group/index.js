const parent_posts = document.querySelector('.parent_posts'); 

function loadPages(page_code) {
    axios.post("?cursor=" + page_code,{'agax':1})
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