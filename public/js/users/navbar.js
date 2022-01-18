const search_ele = document.getElementById('search');
const  list_ele = document.getElementsByClassName('list-group-item');

function generalEventListener(type, selector, callback) {
    document.addEventListener(type, e => {
        if (e.target.matches(selector)) {
            callback(e)
        }
    })
}

//show matched search results
search_ele.onkeyup = function () {
    let search = search_ele.value;
    if (search) {
        axios.post('/search/show', { 'search': search })
            .then(function (res) {
                const list_group = document.querySelector('.list-group');
                let req_num = list_group.getAttribute('data-req_num');

                if (req_num == '1') {
                    for (let i = 0; i < list_ele.length; i++) {
                        list_ele[i].style.display = 'none';
                    }
                }

                generalEventListener('click','.list-group-item',e=>{
                    let text=e.target.textContent;
                    let pure_text=text.replace(/ /g, "");

                    search_ele.value=pure_text;

                    document.getElementById('search_form').submit()
                })

                list_group.setAttribute('data-req_num', '1');

                let users = res.data.users;
                for (let i = 0; i < users.length; i++) {
                    list_group.insertAdjacentHTML('beforeend',
                        `<li class="list-group-item" >
                            <img src="/images/users/${users[i].photo}" class="rounded-circle search_image">
                            <span>${users[i].name}</span> 
                        </li>`
                    );
                }

                let groups = res.data.groups;
                for (let i = 0; i < groups.length; i++) {
                    list_group.insertAdjacentHTML('beforeend',
                        `<li class="list-group-item" >
                            <img src="/images/groups/${groups[i].photo}" class="rounded-circle search_image">
                            <span>${groups[i].name}</span> 
                        </li>`
                    );
                }
            });
    }
};


