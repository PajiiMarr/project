<div class="admin-icon  d-flex flex-column justify-content-center align-items-center">
    <i class="fa-regular fa-circle-user icon-size crimson py-3"></i>
    <h2>Admin</h2>
</div>
<div class="admin-nav d-flex flex-column justify-content-between">
    <div class="an-child h-35 w-100 d-flex flex-column">
        <nav class="h-100 w-100">
            <ul class="list-unstyled h-100 w-100 d-flex flex-column justify-content-center align-items-center mt-2">
                <li class="header-list w-100 h-25 li-unselected px-2">
                    <a href="dashboard.php" id="dashboard-link" class="anchor-tag d-flex justify-content-center align-items-center w-100 h-100 text-decoration-none crimson px-3">
                    <i class="fas fa-dashboard w-25 fs-4"></i>
                        <p class="w-75 fs-5 pt-3">Dashboard</p>
                    </a>
                </li>
                <li class="header-list w-100 h-25 li-unselected px-2">
                    <a href="organization.php" id="org-overview-link" class="anchor-tag d-flex justify-content-center align-items-center w-100 h-100 text-decoration-none crimson px-3">
                        <i class="fa-solid fa-people-group w-25 fs-4"></i>
                        <p class="w-75 fs-5 pt-3">Organizations</p>
                    </a>
                </li>
                <li class="header-list w-100 h-25 px-2 li-unselected li-student">
                    <a href="student.php" id="students-link" class="anchor-tag d-flex justify-content-center align-items-center w-100 h-100 text-decoration-none crimson px-3">
                        <i class="fa-regular fa-user w-25 mt-1 fs-4"></i>
                        <p class="w-75 fs-5 pt-3">Students</p>
                    </a>

                    <form class="subheader-list list-unstyled position-absolute w-100 text-center" method="POST">
                        <button type="submit" name="course_id" value="1" class="text-white text-decoration-none d-block p-2 w-100 border-none">BSIT</button>
                        <button type="submit" name="course_id" value="2" class="text-white text-decoration-none d-block p-2 w-100 border-none">BSCS</button>
                        <button type="submit" name="course_id" value="3" class="text-white text-decoration-none d-block p-2 w-100 border-none">ACT AD</button>
                        <button type="submit" name="course_id" value="4" class="text-white text-decoration-none d-block p-2 w-100 border-none">ACT NT</button>
                    </form>
                </li>
                <li class="header-list w-100 h-25 li-unselected px-2">
                    <a href="payments.php" id="payment-link" class="anchor-tag d-flex justify-content-center align-items-center w-100 h-100 text-decoration-none crimson px-3">
                        <i class="fa-solid fa-people-group w-25 fs-4"></i>
                        <p class="w-75 fs-5 pt-3">Payment History</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    <div class="an-child h-25 w-100 p-2 d-flex flex-column justify-content-center align-items-center">
        <a href="" class="btn w-100 h-20 my-2 py-4 bg-crimson d-flex">
            <div class="w-25 h-100 d-flex align-items-center justify-content-center">
                <i class="fa-solid fa-money-bill fs-4"></i>
            </div>
            <div class="w-75 h-100 d-flex align-items-center justify-content-start">
                <p class="fs-5 mb-0">Create Payment</p>
            </div>
        </a>
    </div>
</div>
<div class="sign-out d-flex justify-content-end align-items-center">
    <a href="admin_logout.php" class="w-50 crimson text-decoration-none d-flex">
        <i class="fa-solid fa-arrow-right-from-bracket w-25 fs-5 mt-1"></i>
        <div class="w-75 h-100 d-flex align-items-center">
            <p class="fs-5">Sign Out</p>
        </div>
        
    </a>
</div>
