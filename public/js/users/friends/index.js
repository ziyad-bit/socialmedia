window.onload = function () {
    const card_header = document.querySelector('.card-header'); 
    //load pages
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


    //add friend
    /*
    generalEventListener('click','.add_btn',e=>{
        let friend_id=e.target.getAttribute('data-user_id');
        axios.post('/friends',{'friend_id':friend_id})
            .then(res=>{
                if (res.status == 200) {
                    const add_btn=document.querySelector(`[data-user_id="${friend_id}"]`);
                    add_btn.disabled=true
                    add_btn.textContent="awaiting approval"
                }
            })
    })
*/
    
    
}

