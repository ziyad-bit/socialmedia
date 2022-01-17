let search_ele = document.getElementById('search');

search_ele.onkeyup = function () {
    let search = search_ele.value;
    if (search) {
        axios.post('/search/show', { 'search': search })
            .then(function (res) {
                let list_group = document.querySelector('.list-group');
                let req_num = list_group.getAttribute('data-req_num');

                list_group.setAttribute('data-req_num', '1');

                if (req_num == '1') {
                    let list_ele = document.getElementsByClassName('list-group-item');
                    for (let i = 0; i < list_ele.length; i++) {
                        list_ele[i].style.display = 'none';

                    }
                }

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