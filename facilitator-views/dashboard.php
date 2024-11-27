<section class="container-fluid w-100 h-100">
    <!-- Header Section -->
    <div class="h-18 w-100 border-bottom">
        <div class="h-50 w-100 custom-border-bottom d-flex align-items-center justify-content-center">
            <h1 class="ccs-green">College of Computing Studies</h1>
        </div>
        <div class="h-50 w-100 custom-border-bottom container-fluid lh-1 py-3 px-5">
            <p class="text-secondary fs-5 m-0">Dashboard/Overview</p>
            <h2 class="m-0">Dashboard</h2>
        </div>
    </div>
    <!-- Main Content -->
    <div class="container-fluid h-80 w-100 py-5 px-5">
        <div class="h-100 w-100 shadow rounded-large overflow-scroll p-4">
            <!-- Filter Section -->
            <div class="row mb-4">
                <div class="col text-end">
                    <form class="d-flex align-items-center">
                        <label for="date-filter" class="mx-2">Filter:</label>
                        <select id="date-filter" name="date_filter" class="form-select w-auto">
                            <option value="today">Today</option>
                            <option value="week">This Week</option>
                            <option value="month">This Month</option>
                            <option value="all">All Time</option>
                        </select>
                        <button type="submit" class="btn btn-crimson ms-3">Apply</button>
                    </form>
                </div>
            </div>
            <!-- Metrics Section -->
            <div class="row g-3 mb-5">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="reports shadow rounded-large p-3 d-flex flex-column align-items-center bg-white">
                        <i class="fa-solid fa-money-check-dollar fs-1 text-crimson"></i>
                        <p class="fs-5 text-center mt-2">Fees Collected</p>
                        <h4 class="text-crimson"><?= $reports['fees_collected'] ?? '0'; ?></h4>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="reports shadow rounded-large p-3 d-flex flex-column align-items-center bg-white">
                        <i class="fa-solid fa-user-check fs-1 text-crimson"></i>
                        <p class="fs-5 text-center mt-2">Students Paid Today</p>
                        <h4 class="text-crimson"><?= $reports['students_paid_today'] ?? '0'; ?></h4>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="reports shadow rounded-large p-3 d-flex flex-column align-items-center bg-white">
                        <i class="fa-solid fa-calendar-day fs-1 text-crimson"></i>
                        <p class="fs-5 text-center mt-2">Payments Collected</p>
                        <h4 class="text-crimson"><?= $reports['payments_collected'] ?? '0'; ?></h4>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="reports shadow rounded-large p-3 d-flex flex-column align-items-center bg-white">
                        <i class="fa-solid fa-school fs-1 text-crimson"></i>
                        <p class="fs-5 text-center mt-2">Active Students</p>
                        <h4 class="text-crimson"><?= $reports['active_students'] ?? '0'; ?></h4>
                    </div>
                </div>
            </div>
            <!-- Recent Payments Section -->
            <div class="mt-4">
                <h3 class="text-crimson mb-4">Recent Payments</h3>
                <table class="table table-striped rounded-large overflow-hidden">
                    <thead>
                        <tr class="bg-light-crimson">
                            <th class="fs-5 text-white p-3">#</th>
                            <th class="fs-5 text-white p-3">Student Name</th>
                            <th class="fs-5 text-white p-3">Amount</th>
                            <th class="fs-5 text-white p-3">Date Paid</th>
                            <th class="fs-5 text-white p-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($recentPayments)): ?>
                            <tr>
                                <td colspan="5" class="text-center py-3 fw-bold text-muted">No Recent Payments</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($recentPayments as $index => $payment): ?>
                                <tr>
                                    <td><?= $index + 1; ?></td>
                                    <td><?= htmlspecialchars($payment['student_name']); ?></td>
                                    <td><?= htmlspecialchars($payment['amount']); ?></td>
                                    <td><?= htmlspecialchars($payment['date_paid']); ?></td>
                                    <td><?= htmlspecialchars($payment['status']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
