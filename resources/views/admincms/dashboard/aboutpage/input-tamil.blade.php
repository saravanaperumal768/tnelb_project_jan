<div class="modal fade" id="inputFormModal_tamil" tabindex="-1" role="dialog" aria-labelledby="inputFormModalTamilLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header" id="inputFormModalTamilLabel">
                <h5 class="modal-title">Add Tamil Content</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true">X</button>
            </div>
            <div class="modal-body">
                <form action="backend/about/update_aboutcontent.php" method="POST">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="task-badge d-flex">
                                <textarea id="add-tasks2" placeholder="Task Text" class="form-control richcontent" name="content_tamil"></textarea>
                            </div>
                        </div>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-success float-right">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>