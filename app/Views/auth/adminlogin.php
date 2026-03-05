<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - User Management System</title>
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.npmmirror.com/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #0f172a;
            --primary-hover: #1e293b;
            --bg: #f1f5f9;
            --card-bg: #ffffff;
            --text-main: #0f172a;
            --text-muted: #64748b;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg);
            background-image: radial-gradient(at 0% 0%, rgba(15, 23, 42, 0.05) 0, transparent 50%), 
                              radial-gradient(at 50% 0%, rgba(30, 41, 59, 0.05) 0, transparent 50%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .login-card {
            background: var(--card-bg);
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            padding: 2.5rem;
        }

        .brand-logo {
            width: 44px;
            height: 44px;
            background: var(--primary);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.25rem;
        }

        .brand-logo svg {
            color: white;
            width: 22px;
            height: 22px;
        }

        h2 {
            color: var(--text-main);
            font-weight: 700;
            letter-spacing: -0.025em;
            margin-bottom: 0.5rem;
            text-align: center;
            font-size: 1.5rem;
        }

        .subtitle {
            color: var(--text-muted);
            text-align: center;
            margin-bottom: 2rem;
            font-size: 0.9rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--text-main);
            font-size: 0.85rem;
            margin-bottom: 0.4rem;
        }

        .form-control {
            border-radius: 10px;
            padding: 0.65rem 0.9rem;
            border: 1px solid #e2e8f0;
            background-color: #f8fafc;
            font-size: 0.9rem;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.1);
            background-color: #fff;
        }

        .btn-primary {
            background-color: var(--primary);
            border: none;
            border-radius: 10px;
            padding: 0.75rem;
            font-weight: 600;
            width: 100%;
            margin-top: 0.75rem;
            font-size: 0.95rem;
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
        }

        .footer-text {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.85rem;
            color: var(--text-muted);
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="brand-logo">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
        </svg>
    </div>
    
    <h2>Admin Portal</h2>
    <p class="subtitle">Secure administrative access</p>
    
    <form action="/admin/login/authenticate" method="POST">
        <div class="mb-3">
            <label for="email" class="form-label">Admin Email</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="admin@admin.com" required>
        </div>
        <div class="mb-4">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Authorize Access</button>
    </form>
    
    <div class="footer-text">
        System Security Active
    </div>
</div>

</body>
</html>
