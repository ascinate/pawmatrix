<x-header/>

<body class="login-page">
<main class="float-start w-100">
   <div class="container">
        <aside class="loging-parts01 bg-white col-lg-4 col-xl-4 p-5 mx-auto">
            <a href="#" class="d-table mx-auto mb-4 text-center">
               <img src="{{ asset('assets/images/logo-mains.svg') }}" alt="logo"/>
            </a>
             @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <form method="POST" action="{{ route('admin.login') }}">
                @csrf
              <div class="form-group">
                  <label class="form-label">
                    Email 
                  </label>
                  <input type="email" name="email" class="form-control" placeholder="Email or username" required/>
                  @error('email') <small class="text-danger">{{ $message }}</small> @enderror
              </div>
              <div class="form-group">
                <div class="d-flex align-items-center justify-content-between w-100">
                    <label class="form-label">
                      Password
                    </label>
                    <a href="#" class="btn btn-forgets text-decoration-underline"> Forget password? </a>
                </div>
                <div class="position-relative w-100">
                      <input type="password" name="password" id="password" class="form-control" placeholder="Password" required/>
                     <i class="toggle-password fa fa-fw fa-eye"></i>
                     @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                 


              </div>
              <div class="form-check keps-text01">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                <label class="form-check-label" for="flexCheckChecked">
                    Keep me signed in
                </label>
              </div>
              <div class="form-group mb-0">
                  <button type="submit" class="btn signin-btn w-100"> Sign in </button>
              </div>

            </form>
        </aside>
   </div>
</main>

<script src="js/bootstrap.bundle.min.js" ></script>
<script src="js/jquery.min.js" ></script>
<script src="js/custom.js" ></script>
<script>
  $(document).ready(function(){
    $(".toggle-password").click(function() {
        $(this).toggleClass("fa-eye-slash fa-eye");
        input = $(this).parent().find("input");
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });
  });
</script>
</body>
</html>
