//update photo
const update_photo_ele=document.getElementById('save_photo');

update_photo_ele.onclick=function(){
    let form=document.getElementById('photoForm'),
    formData=new FormData(form);

    axios.post('/'+lang+"/users/profile/update/photo" ,formData)
        .then(res=> {
            if (res.status == 200) {
                let photo = res.data.photo,
                    msg   = res.data.success;
                document.querySelector('.image-profile').src='/images/users/'+photo;

                const success_ele=document.getElementById('success_photo');

                success_ele.textContent=msg;
                success_ele.style.display='';

                setTimeout(() => {
                    success_ele.style.display='none';
                }, 3000);
            }
        })
        .catch(err=>{
            let error=err.response;
            if (error.status == 422) {
                const msg_err_ele=document.getElementById('photo_err');
                msg_err_ele.textContent=error.data.errors.photo[0];
                msg_err_ele.style.display='';

                setTimeout(() => {
                    msg_err_ele.style.display='none';
                }, 3000);
            }
        })
}

//update profile
const update_profile_ele=document.getElementById('update_profile_btn');

update_profile_ele.onclick=function(){
    let form=document.getElementById('profile_form'),
    formData=new FormData(form);

    const errors_ele=document.getElementsByClassName('errors');
    for (let i = 0; i < errors_ele.length; i++) {
        errors_ele[i].style.display='none';
    }

    axios.post('/'+lang+"/users/profile/update" ,formData)
        .then(res=> {
            if (res.status == 200) {
                let res_data = res.data,
                    msg      = res_data.success,
                    user     = res_data.user;

                for (const [key, value] of Object.entries(user)) {
                    document.querySelector('.user_'+key).textContent=value;
                }
                
                const success_ele=document.getElementById('success_profile');

                success_ele.textContent=msg;
                success_ele.style.display='';

                setTimeout(() => {
                    success_ele.style.display='none';
                }, 3000);
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

//load posts by infinite scrolling
const parent_posts = document.querySelector('.parent_posts'); 

function loadPages(page_code) {
    axios.post("?cursor=" + page_code)
        .then(res=> {
            if (res.status == 200) {
                let view   = res.data.view,
                    cursor = res.data.page_code;
                
                parent_posts.setAttribute('data-page_code',cursor);
                parent_posts.insertAdjacentHTML('beforeend', view);
            }
        })
}

window.onscroll = function () {
    if (window.scrollY + window.innerHeight-54 >= document.body.clientHeight) {
        let page_code = parent_posts.getAttribute('data-page_code');
        if (page_code) {
            loadPages(page_code);
        }
    }
}