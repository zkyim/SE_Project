<?php ob_start(); session_start(); session_regenerate_id(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <title>Document</title>
  <style type="text/tailwindcss">
    @theme {
        --color-border: hsl(214.3 31.8% 91.4%);
        --color-input: hsl(214.3 31.8% 91.4%);
        --color-ring: hsl(222.2 84% 4.9%);
        --color-background: hsl(0 0% 100%);
        --color-foreground: hsl(222.2 84% 4.9%);
        --color-primary: hsl(222.2 47.4% 11.2%);
        --color-primary-foreground: hsl(210 40% 98%);
        --color-secondary: hsl(210 40% 96.1%);
        --color-secondary-foreground: hsl(222.2 47.4% 11.2%);
        --color-destructive: hsl(0 84.2% 60.2%);
        --color-destructive-foreground: hsl(210 40% 98%);
        --color-muted: hsl(210 40% 96.1%);
        --color-muted-foreground: hsl(215.4 16.3% 46.9%);
        --color-accent: hsl(210 40% 96.1%);
        --color-accent-foreground: hsl(222.2 47.4% 11.2%);
        --color-popover: hsl(0 0% 100%);
        --color-popover-foreground: hsl(222.2 84% 4.9%);
        --color-card: hsl(0 0% 100%);
        --color-card-foreground: hsl(222.2 84% 4.9%);
        --borderRadius-lg: 0.5rem;
        --borderRadius-md: calc(0.5rem - 2px);
        --borderRadius-sm: calc(0.5rem - 4px);
    }
</style>
</head>
<body style="font-family: Cairo, sans-serif;">

    <?php if (isset($_SESSION['user_id'])): ?>
      <header class="h-[55px] shadow">
        <div class="px-6 h-full md:px-10">
          <div class="flex items-center justify-between h-full gap-10">
            <div class="flex gap-2">
              <i data-lucide="earth" class="w-6 h-6"></i>
              <span class="font-bold">My App</span>
            </div>
            <div class="relative md:flex-1 flex items-center h-full group/list">
              <span class="hidden group-hover/list:block w-16 h-16 block md:hidden absolute translate-y-[90%] bottom-5 right-0 bg-transparent"></span>
              <span class="block flex flex-col items-end justify-between w-6 h-4 cursor-pointer md:hidden">
                <span class="w-[50%] group-hover/list:w-full h-[2px] rounded-md bg-primary transition-[1s]"></span>
                <span class="w-[70%] group-hover/list:w-full h-[2px] rounded-md bg-primary transition-[1s]"></span>
                <span class="w-[90%] group-hover/list:w-full h-[2px] rounded-md bg-primary transition-[1s]"></span>
              </span>
              <nav class="hidden group-hover/list:block group-hover/list:md:flex p-1 bg-background overflow-hidden border-border border rounded-md md:rounded-none md:border-none md:p-0 w-[150px] h-fit absolute md:relative bottom-2 md:bottom-0 right-0 translate-y-[100%] md:translate-y-0 md:flex md:items-center md:justify-between md:h-full md:w-full md:flex-1 gap-2 space-y-1 md:space-y-0">
                <div class="h-full space-x-2 space-y-2"> 
                  <a class="h-full rounded-md md:rounded-none py-2 md:py-0 text-primary md:relative group/link flex items-center px-4 md:py-0 hover:bg-accent hover:md:bg-accent/70 transition-[1s]" href="">
                    Home
                    <span class="md:absolute top-0 left-0 h-[3px] w-0 group-hover/link:md:w-full bg-primary transition-[1s]"></span>
                    <span class="md:absolute bottom-0 right-0  h-[3px] w-0 group-hover/link:md:w-full bg-primary transition-[1s]"></span>
                  </a>
                </div>
                <div class="md:block space-x-2 space-y-1">
                  <a href="<?php echo '../controllers/Users.php?query=logout'; ?>">
                    <button class="w-full md:w-fit px-3 py-1 rounded-md bg-primary text-primary-foreground hover:bg-primary/80 cursor-pointer">
                      Logout
                    </button>
                  </a>
                </div>
              </nav>
            </div>
          </div>
        </div>
      </header>
    <?php endif; ?>