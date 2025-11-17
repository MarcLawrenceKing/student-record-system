<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Laravel SRS</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

  <script>
    // for light/dark mode
    (function() {
      const savedTheme = localStorage.getItem('theme') || 'light';
      document.documentElement.setAttribute('data-bs-theme', savedTheme);
    })();
  </script>
</head>

<body style="min-height: 100vh; display:flex; flex-direction:column;">
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <a class="navbar-brand" href="/students">SRS</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
              <a href="{{ route('logout') }}" class="nav-link" 
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                  Log out
              </a>
          </li>

          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
          </form>
        </ul>
        <!-- Right-aligned Light/Dark toggle -->
        <div class="d-flex align-items-center ms-auto">
          <label class="form-check-label me-2" for="flexSwitchCheckChecked">Light/Dark Mode</label>
          <div class="form-switch">
            <input class="form-check-input p-2"
              type="checkbox"
              role="switch"
              id="flexSwitchCheckChecked"
              checked
              onclick="myFunction()" />
          </div>
        </div>
      </div>
    </div>
  </nav>
  @yield('content')
  @include('modals.confirmation')
  @include('toast')
  <footer class="text-center py-3 border-top" style="bottom:0; width:100%; margin-top: auto;">
    <div class="container">
      <p>&copy; 2025 Marc Lawrence King. All Rights Reserved</p>
    </div>
  </footer>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>

<script>
  // for light/dark mode
  window.onload = function() {
    const savedTheme = localStorage.getItem('theme') || 'light';
    document.getElementById('flexSwitchCheckChecked').checked = savedTheme === 'dark';
  };

  function myFunction() {
    const newTheme = document.documentElement.getAttribute('data-bs-theme') === 'light' ? 'dark' : 'light';
    document.documentElement.setAttribute('data-bs-theme', newTheme);
    localStorage.setItem('theme', newTheme);
  }
</script>

<script>
  // script for confirmation modal
  document.addEventListener("DOMContentLoaded", function () {

    let formToSubmit = null;
    const confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
    const header = document.getElementById("confirmHeader");
    const title = document.getElementById("confirmTitle");
    const messageBox = document.getElementById("confirmMessage");
    const yesBtn = document.getElementById("confirmYesBtn");

    document.querySelectorAll("button[data-confirm]").forEach(btn => {
      btn.addEventListener("click", function (e) {
        e.preventDefault();

        formToSubmit = btn.closest("form");
        const actionType = btn.getAttribute("data-confirm"); // delete/add/update

        // Remove previous color classes
        header.className = "modal-header"; 
        yesBtn.className = "btn";

        // Change text based on action
        switch (actionType) {
          case "delete":
            header.classList.add("bg-danger", "text-white");
            title.textContent = "Confirm Delete";
            yesBtn.classList.add("btn-danger");
            messageBox.textContent = "Are you sure you want to delete the student/s?";
            break;
          case "add":
            header.classList.add("bg-success", "text-white");
            title.textContent = "Confirm Add";
            yesBtn.classList.add("btn-success");
            messageBox.textContent = "Are you sure you want to add this student?";
            break;
          case "update":
            header.classList.add("bg-primary", "text-white");
            title.textContent = "Confirm Update";
            yesBtn.classList.add("btn-primary");
            messageBox.textContent = "Are you sure you want to save changes?";
            break;
          default:
            header.classList.add("bg-secondary", "text-white");
            title.textContent = "Please Confirm";
            yesBtn.classList.add("btn-secondary");
            messageBox.textContent = "Are you sure you want to continue?";
        }
          confirmModal.show();
        });
    });

    yesBtn.addEventListener("click", function () {
        if (formToSubmit) formToSubmit.submit();
    });
  });
</script>

<script>
  // script for toast
  document.addEventListener("DOMContentLoaded", function () {
    const toastEl = document.getElementById('successToast');
    if (toastEl) {
      const toast = new bootstrap.Toast(toastEl, { delay: 3000 });
      toast.show();
    }
  });
</script>

</html>