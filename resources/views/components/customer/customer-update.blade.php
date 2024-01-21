<div class="modal animated zoomIn" id="update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Customer</h5>
            </div>
            <div class="modal-body">
                <form id="update-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Customer Name *</label>
                                <input type="text" class="form-control" id="customerNameUpdate">

                                <label class="form-label mt-3">Customer Email *</label>
                                <input type="text" class="form-control" id="customerEmailUpdate">

                                <label class="form-label mt-3">Customer Mobile *</label>
                                <input type="text" class="form-control" id="customerMobileUpdate">

                                <input type="text" class="d-none" id="updateID">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="update-modal-close" class="btn bg-gradient-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                <button onclick="Update()" id="update-btn" class="btn bg-gradient-success" >Update</button>
            </div>
        </div>
    </div>
</div>

<script>
    async function FilledUpdatedData(id)
    {
        document.getElementById('updateID').value = id

        showLoader()
        let response = await axios.post('/customer-by-id', {id:id})
        hideLoader()

        document.getElementById('customerNameUpdate').value     = response.data['name']
        document.getElementById('customerEmailUpdate').value    = response.data['email']
        document.getElementById('customerMobileUpdate').value   = response.data['mobile']
    }

    async function Update()
    {
        let updateID    = document.getElementById('updateID').value
        let name        = document.getElementById('customerNameUpdate').value
        let email       = document.getElementById('customerEmailUpdate').value
        let mobile      = document.getElementById('customerMobileUpdate').value


        if(name.length == 0)
        {
            errorToast("Name is required")
        }
        else if(email.length == 0)
        {
            errorToast("Email is required")
        }
        else if(mobile.length == 0)
        {
            errorToast("Mobile number is required")
        }
        else
        {
            document.getElementById('update-modal-close').click()
            showLoader()
            let response = await axios.post('/update-customer', {
                name:name,
                email:email,
                mobile:mobile,
                id:updateID
            })
            hideLoader()

            if(response.status == 200 && response.data == 1)
            {
                successToast("Update successful")
                document.getElementById("update-form").reset()
                await getList()
            }
            else
            {
                errorToast("Something went wrong")
            }
        }
    }
</script>
