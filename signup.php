<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="allcss/signup.css">
</head>
<body>
    <main class="container">
        <section>
            <div class="setup">
                <form action="profiling.php" method="post">
                    <h1>Create Account</h1>
                    <input type="email" name="email" id="email" placeholder="Email">
                    <input type="password" name="password" id="password" placeholder="Password">
                    <input type="password" name="confirm" id="confirm" placeholder="Re-enter Password">
                    <button type="submit" name="submit">
                        <span>
                            Next
                        </span>
                    </button>
                </form>
            </div>
        </section>  
    </main>
    <script src="sripts/signup.js"></script>
</body>
</html>