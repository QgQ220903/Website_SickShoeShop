<?php $this->view("include/header", $data) ?>

<div class="container-fluid">
  <div class="row p-5 bg-light">
    <div class="col-lg-6 col-md-6 col-sm-12 mx-auto ">
      <h5>My Profile</h5>
      <form class="profile-container p-5 bg-white border-4">
        <div class="mb-3 ">
          <label>Username</label>
          <input class="form-control bg-light" type="text" placeholder="Username"
            value="<?= $data['user_data']->username ?>" />
        </div>
        <div class="mb-3">
          <label>Email</label>
          <input class="form-control bg-light" type="email" placeholder="admin@example.com"
            value="<?= $data['user_data']->email ?>" />
        </div>
        <div class="mb-3">
          <label>Password</label>
          <input class="form-control bg-light" type="password" placeholder="password" <?= $data['user_data']->password ?> />
        </div>
        <div class="mb-3">
          <label>Phone</label>
          <input class="form-control bg-light" type="tel" placeholder="phone number"
            value="<?= $data['user_data']->phone ?>" />
        </div>
        <div class="mb-3">
          <button class="btn btn-primary">Save</button>
        </div>
      </form>
      <!-- end card -->
    </div>
    <!-- end col -->
  </div>
</div>
<?php $this->view("include/footer", $data) ?>