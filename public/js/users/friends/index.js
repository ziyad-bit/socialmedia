window.onload = function () {
    const card_header = document.querySelector('.card-header'); 
    //load pages by infinite scrolling
    function loadPages(page_code) {
        axios.post("?cursor=" + page_code,{'agax':1})
            .then(res=> {
                if (res.status == 200) {
                    let view   = res.data.view;
                    let cursor = res.data.page_code;
                    
                    card_header.setAttribute('data-page_code',cursor);

                    if (view != "") {
                        document.querySelector('.text-dark').insertAdjacentHTML('beforeend', view);
                    }
                }
            })
    }


    window.onscroll = function () {
        if (window.scrollY + window.innerHeight >= document.body.clientHeight) {
            let page_code = card_header.getAttribute('data-page_code');
            if (page_code) {
                loadPages(page_code);
            }
        }
    }


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
    
}

