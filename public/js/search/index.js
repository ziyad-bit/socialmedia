function loadPages(page){
    let search=document.getElementById('search').value;
    console.log(search)
    axios.post("?page="+page,{'search':search,'agax':1})
        .then(function(res){
            let view=res.data.view;
            console.log(view)
        })
}

let page=1
window.onscroll=function(){
    if(window.scrollY+ window.innerHeight >= document.body.clientHeight){
        
        page++;
        loadPages(page);
    }
}