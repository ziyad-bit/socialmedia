//load friends by infinite scrolling
const parent_friends = document.querySelector('.parent_friends'); 
let friends_data=true;

function loadPages(page) {
    axios.post("?page=" + page,{'agax':1})
        .then(res=> {
            if (res.status == 200) {
                let friends   = res.data.friends.data,
                    next_page = res.data.friends.next_page_url;

                if (next_page == null) {
                    friends_data=false
                }

                for (let i = 0; i < friends.length; i++) {
                    
                    parent_friends.insertAdjacentHTML('beforeend',` 
                        <div class="card-body">
                            <img src="/images/users/${friends[i].photo}" class="rounded-circle" style="width: 100px"
                                alt="loading">
                            <span class="card-title">
                                ${friends[i].name}
                            </span>
                            <a class="btn btn-success">message</a>
                            <div class="card-text"  style="position: relative;
                            top: 5px;">
                                ${friends[i].work ? friends[i].work : ''}
                            </div>
                        </div>
                        <hr>
                    
                        `);
                }
                
            }
        })
}
let page=1;
window.onscroll = function () {
    if (window.scrollY + window.innerHeight >= document.body.clientHeight) {
        page++
        if (friends_data == true) {
            loadPages(page);
        }
    }
}