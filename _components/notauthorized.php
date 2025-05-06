  <main class="flex flex-col items-center justify-center h-screen space-y-4">
    <i data-lucide="shield-x" class="w-30 h-30 text-muted-foreground"></i>
    <div class="space-y-8">
      <div class="space-y-1">
        <h3 class="text-2xl text-center font-semibold text-rose-500">Not Authorized</h3>
        <p class="text-muted-foreground">You don't have permission to access this page.</p>
      </div>
      <div class="space-x-3 text-center">
        <a href="../controllers/Users.php?query=logout" class="px-3 py-1 rounded-md bg-primary hover:bg-primary/80 text-white">Log Out</a>
        <a href="../login.php" class="px-3 py-1 rounded-md bg-primary hover:bg-primary/80 text-white">Go Home</a>
      </div>
    </div>
  </main>