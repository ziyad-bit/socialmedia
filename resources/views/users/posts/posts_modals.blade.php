 <!--       edit post        -->
 <div class="modal fade" id="edit_post_modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit_post_modal"> edit post</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="edit_post_form" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="alert alert-success text-center" id="edit_post_msg" style="display: none"></div>

                    <div class="form-group">
                        <label for="exampleInputname1">text </label>
                        <textarea name="text" class="form-control edit_text" cols="15" rows="5"></textarea>
                        <small style="color:red" id="text_edit_err">

                        </small>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputname1">photo </label>
                        <input type="file" name="photo" class="form-control">
                        <small style="color:red" id="photo_edit_err">

                        </small>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputname1">file </label>
                        <input type="file" name="file" class="form-control">
                        <small style="color:red" id="file_edit_err">

                        </small>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputname1">video </label>
                        <input type="file" name="video" class="form-control">
                        <small style="color:red" id="video_edit_err">

                        </small>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">cancel</button>
                    <button type="button" id="edit_post_btn" class="btn btn-primary">update</button>
                </div>
            </form>
        </div>
    </div>
</div>
     <!--       delete comment modal        -->
     <div class="modal fade" id="delete_modal" tabindex="-1" aria-labelledby="delete_modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="delete_modal"> Delete comment </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-success text-center" id="delete_msg" style="display: none"></div>
                    <div class="alert alert-danger text-center" id="err_delete_msg" style="display: none"></div>
                    <h4>Are you want to delete it?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">cancel</button>
                    <button type="button" id="delete_btn" data-comment_id='' data-post_id=""
                        class="btn btn-danger">delete</button>
                </div>
            </div>
        </div>
    </div>

    <!--       edit comment modal        -->
    <div class="modal fade" id="edit_modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit_modal"> Edit comment </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-success text-center" id="success_msg" style="display: none"></div>
                    <div id="update_input" class="form-control" contenteditable="true"></div>
                    <small style="color: red; display:none" id="error"></small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">cancel</button>
                    <button type="button" id="update_btn" data-comment_id='' data-post_id='' class="btn btn-primary">update</button>
                </div>
            </div>
        </div>
    </div>

    <!--       share post        -->
    <div class="modal fade" id="share_modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="share_modal"> share post</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-success text-center" id="success_msg" style="display: none"></div>
                    <h4>Are you want to share this post?</h4>
                    <small style="color: red; display:none" id="error_share"></small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">cancel</button>
                    <button type="button" id="share_btn" data-post_id='' class="btn btn-primary">share</button>
                </div>
            </div>
        </div>
    </div>

    <!--       delete post        -->
    <div class="modal fade" id="delete_post_modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="delete_post"> share post</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-success text-center" id="delete_post_msg" style="display: none"></div>
                    <h4>Are you want to delete this post?</h4>
                    <small style="color: red; display:none" id="error_delete_post"></small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">cancel</button>
                    <button type="button" id="delete_post_btn" data-post_id='' class="btn btn-danger">delete</button>
                </div>
            </div>
        </div>
    </div>