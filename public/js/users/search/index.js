window.onload = function () {
    //load pages
    const search_ele  = document.getElementById('search');

    let search      = search_ele.value,
        data_status = 1;

    function loadPages(page) {
        axios.post("?page=" + page, { 'search': search, 'agax': 1 })
            .then(res=> {
                if (res.status == 200) {
                    let view      = res.data.view;
                    let next_page = res.data.next_page;

                    if (next_page == false) {
                        data_status=0;
                    }

                    if (view != "") {
                        document.querySelector('.text-dark').insertAdjacentHTML('beforeend', view);
                    } 
                }
            })
    }


    let page = 1;
    window.onscroll = function () {
        if (window.scrollY + window.innerHeight >= document.body.clientHeight) {
            if (data_status != 0) {
                page++;
                loadPages(page);
            }
        }
    }


    //add friend
    generalEventListener('click','.add_btn',e=>{
        let friend_id=e.target.getAttribute('data-user_id');
        
        axios.post('/friend',{'friend_id':friend_id})
            .then(res=>{
                if (res.status == 200) {
                    const add_btn=document.querySelector(`[data-user_id="${friend_id}"]`);
                    
                    add_btn.disabled    = true;
                    add_btn.textContent = "awaiting approval";
                }
            })
    })
}

