<div class="col-lg-6">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold"><?php echo $title ?></h6>
        </div>
        <div class="card-body">
            <?php echo form_open_multipart('pengaduan/add') ?>
            <div class="form-group">
                <label for="keluhan">Keluhan</label>
                <textarea id="keluhan" name="keluhan" class="form-control"><?= set_value('keluhan') ?></textarea>
                <?= form_error('name', '<small class="text-danger pl-3 ">', '</small>') ?>
            </div>

            <div class="modal-footer">
                <button type="reset" class="btn btn-secondary" data-dismiss="modal">Reset</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
            <?php echo form_close() ?>
        </div>
    </div>
</div>