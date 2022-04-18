//load pages
let search      = search_ele.value,
    data_status = 1;

function loadPages(page) {
    axios.post("?page=" + page, { 'search': search })
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


//join group
generalEventListener('click','.join_btn',e=>{
    let target   = e.target,
        group_id = target.getAttribute('data-group_id');
    
    axios.post('/'+lang+"/group/reqs",{'group_id':group_id})
        .then(res=>{
            if (res.status == 200) {
                target.disabled    = true;
                target.textContent = "awaiting approval";
            }
        })
})





