<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration | Veterian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #f8f9fc;
            --success-color: #1cc88a;
            --text-color: #5a5c69;
        }
        
        body {
            background-color: var(--secondary-color);
            font-family: 'Nunito', sans-serif;
        }
        
        .register-container {
            max-width: 500px;
            margin: 5% auto;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            border-radius: 15px;
            overflow: hidden;
        }
        
        .register-header {
            background-color: var(--primary-color);
            color: white;
            padding: 1.5rem;
            text-align: center;
        }
        
        .register-body {
            padding: 2rem;
            background: white;
        }
        
        .pet-logo {
            width: 80px;
            height: 80px;
            background-color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            box-shadow: 0 0.15rem 0.5rem rgba(0, 0, 0, 0.1);
        }
        
        .pet-logo i {
            color: var(--primary-color);
            font-size: 2.5rem;
        }
        
        .btn-register {
            background-color: var(--success-color);
            border: none;
            padding: 0.75rem;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-register:hover {
            background-color: #17a673;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }
        
        .login-link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
        }
        
        .login-link:hover {
            text-decoration: underline;
        }
        
        .password-hint {
            font-size: 0.8rem;
            color: var(--text-color);
            margin-top: 0.25rem;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-header">
            <div class="pet-logo">
                <i class="fas fa-paw"></i>
            </div>
            <h2>Create Admin Account</h2>
        </div>
        
        <div class="register-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.register') }}">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" name="name" class="form-control" placeholder="Enter your full name" required>
                    </div>
                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" name="email" class="form-control" placeholder="admin@example.com" required>
                    </div>
                    @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" name="password" class="form-control" placeholder="Create a password" required>
                    </div>
                    <div class="password-hint">Use 8 or more characters with a mix of letters, numbers & symbols</div>
                    @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <button type="submit" class="btn btn-success w-100 btn-register mb-3">Create Account</button>
                
                <div class="text-center">
                    <p>Already have an account? <a href="{{ route('admin.login.form') }}" class="login-link">Sign in here</a></p>
                </div>
            </form>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>