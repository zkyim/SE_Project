
<?php require_once '../helpers/check_user.php'; require_once '../_components/header.php'; require '../helpers/session_helper.php'; ?>
  <?php $checkUser = new checkUser; $checkUser->checkUser(); ?>
  <main class="flex items-center justify-center h-screen">
    <div class="w-full h-[100vh] grid grid-cols-5 overflow-hidden">
      <div class="hidden md:block md:col-span-2 overflow-hidden">
        <img src="../assets/image2.jpg" class="w-full h-full object-cover" alt="iamge" loading="lazy" onerror="" />
      </div>
      <div class="col-span-5 md:col-span-3 flex items-center justify-center">
        <form class="w-[320px]" action="../controllers/Users.php" method="post">
          <input hidden name="type" value="sendCode" />
          <div>
            <h2 class="text-xl font-bold">Reset Password Page</h2>
            <p class="text-sm mt-1 text-muted-foreground">We will send you a code to reset your password.</p>
          </div>
          <div class="space-6 mt-6">
            <div class="space-y-4">

              <?php flash('sendCode'); ?>
              <div class="relative">
                <i data-lucide="mail" class="w-7 h-7 p-1 absolute left-1.5 top-1/2 transform -translate-y-1/2"></i>
                <input class="border pl-10 border-border rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Email" id="email" type="email" name="email" >
              </div>
              <button class="text-center mt-7 px-3 py-1 w-full block rounded-md bg-primary text-white cursor-pointer hover:bg-primary/80">
                Send
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>

  </main>
  <?php require_once '../_components/footer.php' ?>