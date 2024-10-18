<div class="col-lg-6">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">Edit User</h6>
        </div>
        <div class="card-body">
            <?php echo form_open_multipart('') ?>
            <div class="form-group">
                <label for="name">Nama</label>
                <input type="hidden" name="id" value="<?= $data_user->id ?>" readonly>
                <input type="text" id="name" name="name" class="form-control" value="<?= $data_user->name ?>">
                <?= form_error('name', '<small class="text-danger pl-3 ">', '</small>') ?>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" id="email" name="email" class="form-control" value="<?= $data_user->email ?>">
                <?= form_error('email', '<small class="text-danger pl-3 ">', '</small>') ?>
            </div>
            <div class="form-group">
                <label for="phone">No HP</label>
                <input type="text" id="phone" name="phone" class="form-control" value="<?= $data_user->phone ?>">
                <?= form_error('phone', '<small class="text-danger pl-3 ">', '</small>') ?>
            </div>
            <div class="form-group">
                <label for="address">Alamat</label>
                <textarea id="address" name="address" class="form-control"> <?= $data_user->address ?></textarea>
            </div>

            <div class="modal-footer">
                <button type="reset" class="btn btn-secondary" data-dismiss="modal">Reset</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
            <?php echo form_close() ?>
        </div>
    </div>
</div>