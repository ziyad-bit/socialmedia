const search_ele   = document.getElementById('search'),
        list_ele   = document.getElementsByClassName('search_item'),
        list_group = document.querySelector('.list_search');

let recent_req     = 0,
    search_req_num = 0;

function generalEventListener(type, selector, callback) {
    document.addEventListener(type, e => {
        if (e.target.matches(selector)) {
            callback(e);
        }
    });
}

//submit search form on click
function submit_search(e){
    let text=e.target.textContent;
    let pure_text=text.replace(/ /g, "");

    search_ele.value=pure_text;

    document.getElementById('search_form').submit();
}

generalEventListener('click','.search_item',e=>{
    submit_search(e);
});

generalEventListener('click','.search_name',e=>{
    submit_search(e);
});

//show recent searches
function show_recent_searches(){
    if (recent_req == 0) {
        axios.get('/search/show/recent')
            .then(res=>{
                if (res.status == 200) {
                    
                    if (search_req_num == 1) {
                        for (let i = 0; i < list_ele.length; i++) {
                            list_ele[i].style.display = 'none';
                        }
                    }

                    search_req_num = 1;
                    recent_req     = 1;

                    let recent_searches=res.data.recent_searches;
                    for (let i = 0; i < recent_searches.length; i++) {
                        list_group.insertAdjacentHTML('beforeend',
                            `<li class="list-group-item search_item recent_search" >
                                <span class="search_name">${recent_searches[i].search}</span> 
                            </li>`
                        );
                    }
                }
                
            });
        }else{
            if (search_req_num == 1) {
                for (let i = 0; i < list_ele.length; i++) {
                    list_ele[i].style.display = 'none';
                }
            }

            const recent_searches_ele = document.getElementsByClassName('recent_search');
            
            for (let i = 0; i < recent_searches_ele.length; i++) {
                recent_searches_ele[i].style.display = '';
            }
    }
}

//show matched search results
search_ele.onkeyup = function () {
    let search = search_ele.value;
    if (search) {
        axios.post('/search/show', { 'search': search })
            .then(res=> {
                if (res.status == 200) {
                    if (search_req_num == 1) {
                        for (let i = 0; i < list_ele.length; i++) {
                            list_ele[i].style.display = 'none';
                        }
                    }

                    search_req_num=1;

                    let users = res.data.users;
                    for (let i = 0; i < users.length; i++) {
                        list_group.insertAdjacentHTML('beforeend',
                            `<li class="list-group-item search_item" >
                                <img src="/images/users/${users[i].photo}" class="rounded-circle search_image">
                                <span class="search_name">${users[i].name}</span> 
                            </li>`
                        );
                    }

                    let groups = res.data.groups;
                    for (let i = 0; i < groups.length; i++) {
                        list_group.insertAdjacentHTML('beforeend',
                            `<li class="list-group-item search_item" >
                                <img src="/images/groups/${groups[i].photo}" class="rounded-circle search_image">
                                <span class="search_name">${groups[i].name}</span> 
                            </li>`
                        );
                    }
                }
                
            });
    }else{
        show_recent_searches();
    }
};


//show recent searches
search_ele.onfocus=function(){
    let search=search_ele.value;
    if (! search) {
        show_recent_searches();
    }
}

