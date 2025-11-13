<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
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
      <a class="navbar-brand" href="/students">Student Record System</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="/students">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="/students/create">Add Student</a>
          </li>
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
  <footer class="text-center py-3 border-top" style="bottom:0; width:100%; margin-top: auto;">
    <div class="container">
      <p>&copy; 2025 Goldplan Insurance Services. All Rights Reserved</p>
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

</html>