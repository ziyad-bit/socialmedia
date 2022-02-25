//update photo
const update_photo_ele=document.getElementById('save_photo');

update_photo_ele.onclick=function(){
    let form=document.getElementById('photoForm'),
    formData=new FormData(form);

    axios.post("/users/profile/update/photo" ,formData)
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

    axios.post("/users/profile/update" ,formData)
        .then(res=> {
            if (res.status == 200) {
                let res_data = res.data,
                    msg      = res_data.success,
                    user     = res_data.user;

                for (const [key, value] of Object.entries(user)) {
                    document.querySelector('.user_'+key).textContent=value;
                }

                document.querySelector('.errors').style.display='';
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