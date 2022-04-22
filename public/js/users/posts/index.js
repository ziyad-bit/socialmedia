//add post
const add_btn=document.getElementById('add_post_btn');
add_btn.onclick=function(){
    let form=document.getElementById('post_form'),
    formData=new FormData(form);

    axios.post('/'+lang+"/post" ,formData)
        .then(res=> {
            if (res.status == 200) {
                let res_data    = res.data,
                    success_msg = res_data.success,
                    view        = res_data.view;
                document.querySelector('.errors').style.display='none'
    
                const success_ele = document.getElementById('add_post_msg');

                success_ele.textContent=success_msg;
                success_ele.style.display='';

                document.querySelector('.parent_posts').insertAdjacentHTML('afterbegin',view);
            }
        })
        .catch(err=>{
            let error=err.response;
            if (error.status == 422) {
                let err_msgs=error.data.errors;
                for (const [key, value] of Object.entries(err_msgs)) {
                    let error_ele=document.getElementById(key+'_err');
                    
                    error_ele.textContent=value[0];
                    error_ele.style.display='';
                }
            }
        })
}

//infinite scroll for posts
let posts_data=true;
function loadPages(page) {
    axios.post("?page="+page)
        .then(res=> {
            if (res.status == 200) {
                let view      = res.data.view;

                if (view =='') {
                    posts_data=false;
                    return;
                }
                
                document.querySelector('.parent_posts').insertAdjacentHTML('beforeend', view); 
            }
        })
}

let page=1;
window.onscroll = function () {
    if (window.scrollY + window.innerHeight-54 >= document.body.clientHeight) {
        if (posts_data != false) {
            page++;
            loadPages(page);
        } 
    }
}
