<div class="col-lg-6">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold"><?php echo $title ?></h6>
        </div>
        <div class="card-body">
            <?php echo form_open_multipart('data_user/add') ?>

            <div class="form-group">
                <label for="name">Nama</label>
                <input type="text" id="name" name="name" class="form-control"><?= set_value('name') ?>
                <?= form_error('name', '<small class="text-danger pl-3 ">', '</small>') ?>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control"><?= set_value('email') ?>
                <?= form_error('email', '<small class="text-danger pl-3 ">', '</small>') ?>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control"><?= set_value('password') ?>
                <?= form_error('password', '<small class="text-danger pl-3 ">', '</small>') ?>
            </div>

            <div class="form-group">
                <label for="phone">No HP</label>
                <input type="text" id="phone" name="phone" class="form-control"><?= set_value('phone') ?>
                <?= form_error('phone', '<small class="text-danger pl-3 ">', '</small>') ?>
            </div>

            <div class="form-group">
                <label for="address">Alamat</label>
                <textarea id="address" name="address" class="form-control"><?= set_value('address') ?></textarea>
                <?= form_error('address', '<small class="text-danger pl-3 ">', '</small>') ?>
            </div>

            <div class="form-group">
                <label for="gender">Jenis Kelamin</label>
                <select name="gender" id="gender" class="form-control">
                    <option value="Male">Male/Laki-laki</option>
                    <option value="Female">Female/Perempuan</option>
                </select>
                <?= form_error('gender', '<small class="text-danger pl-3 ">', '</small>') ?>
            </div>

            <div class="form-group">
                <label for="role">Role</label>
                <select name="role" id="role" class="form-control">
                    <option value="1">Admin</option>
                    <option value="3">Teknisi</option>
                </select>
                <?= form_error('role', '<small class="text-danger pl-3 ">', '</small>') ?>
            </div>

            <div class="form-group">
                <label for="image">Foto Profile</label>
                <input type="file" id="image" name="image" class="form-control" required>
            </div>

            <div class="modal-footer">
                <button type="reset" class="btn btn-secondary" data-dismiss="modal">Reset</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
            <?php echo form_close() ?>
        </div>
    </div>
</div>