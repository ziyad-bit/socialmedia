const search_ele   = document.getElementById('search'),
    list_ele   = document.getElementsByClassName('search_item'),
    list_group = document.querySelector('.list_search');

let recent_req     = 0,
    search_req_num = 0;

let lang=document.getElementById('lang').value;
console.log(lang);
//add event listener
function generalEventListener(type, selector, callback) {
    document.addEventListener(type, e => {
        if (e.target.matches(selector)) {
            callback(e);
        }
    });
}

//debounce
function debounce(cb,delay=1000) {
    let timeout;

    return (...args)=>{
        clearTimeout(timeout);

        timeout=setTimeout(() => {
                cb(...args);
            }, delay);
    }
}

//hide search results on document click
document.onclick=function(){
    if(window.event.target.id != 'search'){
        for (let i = 0; i < list_ele.length; i++) {
            list_ele[i].style.display = 'none';
        }
    }
}

//submit search form on click
function submit_search(e){
    let text=e.target.innerText;
    
    search_ele.value=text;

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
        axios.get('/'+lang+'/search/show/recent')
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
let search_words=[];

function showMatchedSearch() {
    let search = search_ele.value;
    if (search) {
        if (search_words.includes(search)) {
            for (let i = 0; i < list_ele.length; i++) {
                list_ele[i].style.display = 'none';
            }

            let search_key_ele=document.getElementsByClassName(`${search}`);
            for (let i = 0; i < search_key_ele.length; i++) {
                search_key_ele[i].style.display='';
            }

            return
        }

        search_words.unshift(search);

        axios.post('/'+lang+'/search/show', { 'search': search })
            .then(res=> {
                if (res.status == 200) {
                    if (search_req_num == 1) {
                        for (let i = 0; i < list_ele.length; i++) {
                            list_ele[i].style.display = 'none';
                        }
                    }

                    search_req_num=1;

                    let friends = res.data.friends;
                    for (let i = 0; i < friends.length; i++) {
                        list_group.insertAdjacentHTML('beforeend',
                            `<li class="list-group-item search_item ${search}" >
                                <img src="/images/users/${friends[i].photo}" class="rounded-circle search_image ">
                                <span class="search_name">${friends[i].name}</span> 
                            </li>`
                        );
                    }

                    let users = res.data.users;
                    for (let i = 0; i < users.length; i++) {
                        list_group.insertAdjacentHTML('beforeend',
                            `<li class="list-group-item search_item ${search}" >
                                <img src="/images/users/${users[i].photo}" class="rounded-circle search_image">
                                <span class="search_name">${users[i].name}</span> 
                            </li>`
                        );
                    }

                    let groups_joined = res.data.groups_joined;
                    for (let i = 0; i < groups_joined.length; i++) {
                        list_group.insertAdjacentHTML('beforeend',
                            `<li class="list-group-item search_item ${search}" >
                                <img src="/images/groups/${groups_joined[i].photo}" class="rounded-circle search_image">
                                <span class="search_name">${groups_joined[i].name}</span> 
                            </li>`
                        );
                    }

                    let groups = res.data.groups;
                    for (let i = 0; i < groups.length; i++) {
                        list_group.insertAdjacentHTML('beforeend',
                            `<li class="list-group-item search_item ${search}" >
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
}

search_ele.addEventListener('keyup',debounce(()=>{
        showMatchedSearch()
    },1000)
)

//show recent searches
search_ele.onfocus=function(){
    let search=search_ele.value;
    if (! search) {
        show_recent_searches();
    }
}
