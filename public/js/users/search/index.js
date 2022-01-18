window.onload = function () {
    //load pages
    const search_ele  = document.getElementById('search'),
        card_header = document.querySelector('.card-header');
    let search=search_ele.value;

    function loadPages(page) {
        axios.post("?page=" + page, { 'search': search, 'agax': 1 })
            .then(function (res) {
                let view = res.data.view;
                if (view != "") {
                    document.querySelector('.text-dark').insertAdjacentHTML('beforeend', view);
                } else {
                    card_header.setAttribute('data-status', '0');
                }
            })
    }


    let page = 1;
    window.onscroll = function () {
        if (window.scrollY + window.innerHeight >= document.body.clientHeight) {
            let data_status = card_header.getAttribute('data-status');
            
            if (data_status != "0") {
                page++;
                loadPages(page);
            }
        }
    }
}

