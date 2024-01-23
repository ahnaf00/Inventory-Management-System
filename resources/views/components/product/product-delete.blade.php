<div class="modal animated zoomIn" id="delete-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <h3 class=" mt-3 text-warning">Delete !</h3>
                <p class="mb-3">Once delete, you can't get it back.</p>
                <input class="d-none" id="deleteID"/>
                <input class="d-none" id="deleteFilePath"/>

            </div>
            <div class="modal-footer justify-content-end">
                <div>
                    <button type="button" id="delete-modal-close" class="btn bg-gradient-success mx-2" data-bs-dismiss="modal">Cancel</button>
                    <button onclick="itemDelete()" type="button" id="confirmDelete" class="btn bg-gradient-danger" >Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    async function itemDelete()
    {
        let deletID = document.getElementById('deleteID').value;
        let filePath = document.getElementById('deleteFilePath').value;
        document.getElementById('delete-modal-close').click()

        showLoader()
        let response = await axios.post('/delete-product', {
            id:deletID,
            file_path:filePath
        })
        hideLoader()

        if(response.status == 200 && response.data==1)
        {
            successToast("Product delete successful");
            await getList()
        }
        else{
            errorToast("Something went wrong");
        }
    }
</script>
