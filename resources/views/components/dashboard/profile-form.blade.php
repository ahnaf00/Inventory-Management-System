<div class="container">
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card animated fadeIn w-100 p-3">
                <div class="card-body">
                    <h4>User Profile</h4>
                    <hr/>
                    <div class="container-fluid m-0 p-0">
                        <div class="row m-0 p-0">
                            <div class="col-md-4 p-2">
                                <label>Email Address</label>
                                <input readonly id="email" placeholder="User Email" class="form-control" type="email"/>
                            </div>
                            <div class="col-md-4 p-2">
                                <label>First Name</label>
                                <input id="firstName" placeholder="First Name" class="form-control" type="text"/>
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Last Name</label>
                                <input id="lastName" placeholder="Last Name" class="form-control" type="text"/>
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Mobile Number</label>
                                <input id="mobile" placeholder="Mobile" class="form-control" type="mobile"/>
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Password</label>
                                <input id="password" placeholder="User Password" class="form-control" type="password"/>
                            </div>
                        </div>
                        <div class="row m-0 p-0">
                            <div class="col-md-4 p-2">
                                <button onclick="onUpdate()" class="btn mt-3 w-100  bg-gradient-primary">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    getProfile();

    async function getProfile()
    {
        showLoader();
        let response = await axios.get('/user-profile')
        hideLoader();

        if(response.status == 200 && response.data['status'] == 'success')
        {
            let data = response.data['data'];
            document.getElementById('firstName').value      =   data['firstName']
            document.getElementById('lastName').value       =   data['lastName']
            document.getElementById('email').value          =   data['email']
            document.getElementById('mobile').value         =   data['mobile']
            document.getElementById('password').value       =   data['password']
        }
        else
        {
            errorToast(response.data['message']);
        }
    }


    async function onUpdate()
    {
        let firstName   = document.getElementById('firstName').value
        let lastName    = document.getElementById('lastName').value
        let email       = document.getElementById('email').value
        let mobile      = document.getElementById('mobile').value
        let password    = document.getElementById('password').value

        if(firstName.length===0){
            errorToast('First Name is required')
        }
        else if(lastName.length===0){
            errorToast('Last Name is required')
        }
        else if(mobile.length===0){
            errorToast('Mobile is required')
        }
        else if(password.length===0){
            errorToast('Password is required')
        }
        else
        {
            showLoader()
            let response = await axios.post('/user-update', {
                firstName:firstName,
                lastName:lastName,
                mobile:mobile,
                password:password
            })
            hideLoader()

            if(response.status == 200 && response.data['status']=='success')
            {
                successToast(response.data['message']);
                await getProfile();
            }
            else
            {
                errorToast(response.data['message']);
            }
        }

    }
</script>
