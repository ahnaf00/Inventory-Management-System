<div class="modal animated zoomIn" id="update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Category</h5>
            </div>
            <div class="modal-body">
                <form id="update-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Category Name *</label>
                                <input type="text" class="form-control" id="categoryNameUpdate">
                                <input class="d-none" id="updateID">
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

    async function FillUpdatedForm(id)
    {
        document.getElementById('updateID').value = id
        showLoader()
        let response = await axios.post('/category-by-id', {
            id:id
        })
        hideLoader()

        document.getElementById('categoryNameUpdate').value = response.data['name'];


    }

    async function Update()
    {
        let categoryName    = document.getElementById('categoryNameUpdate').value
        let updateID        = document.getElementById('updateID').value

        if(categoryName.length == 0)
        {
            errorToast("Category required !")
        }
        else
        {
            document.getElementById('update-modal-close').click()
            showLoader()
            let response = await axios.post('/update-category', {
                name:categoryName,
                id:updateID
            })
            hideLoader()

            if(response.status == 200 && response.data == 1)
            {
                document.getElementById('update-form').reset()
                successToast("Category updated successfully")
                await getList()
            }
            else
            {
                errorToast("Something went wrong")
            }

        }

    }
</script>

