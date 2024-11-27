<section class="container-fluid w-100 h-100">
            <div class="h-18 w-100 border-bottom">
                <div class="h-50 w-100 custom-border-bottom d-flex align-items-center justify-content-center">
                    <h1 class="ccs-green">College of Computing Studies</h1>
                </div>
                <div class="h-50 w-100 custom-border-bottom container-fluid lh-1 py-3 px-5">
                    <p class="text-secondary fs-5 m-0">Payment History/Overview</p>
                    <h2 class="m-0">Payment History</h2>
                </div>
            </div>
            <div class="container-fluid h-80 w-100 py-5 px-5">
                <div class="h-100 w-100 shadow rounded-large overflow-scroll">
                    <div class="w-100 d-flex justify-content-between p-2">
                        <form method="post" action="" class="form-selector p-1 d-flex align-items-center justify-content-between w-100">
                            <div class="w-50 justify-content-start">
                                <?php foreach($allOrgs as $orgs): ?>
                                    <?php $buttonClass = ($organization_id == $orgs['organization_id']) ? 'bg-light-crimson text-white' : 'bg-transparent'; ?>
                                    <button type="submit" name="organization_id" value="<?= htmlspecialchars($orgs['organization_id']); ?>" 
                                            class="rounded-3 p-2 ms-2 <?= $buttonClass ?>">
                                        <?= htmlspecialchars($orgs['org_name']); ?>
                                    </button>
                                <?php endforeach; ?>
                            </div>
                            
                            <div class="w-50 d-flex justify-content-end">
                                <label for="from_date" class="mx-2">From:</label>
                                <input type="date" id="from_date" name="from_date" value="<?= htmlspecialchars($from_date); ?>">
                                
                                <label for="to_date" class="mx-2">To:</label>
                                <input type="date" id="to_date" name="to_date" class="me-2" value="<?= htmlspecialchars($to_date); ?>">
                            </div>
                            
                            <button type="submit" class="btn">Apply Filter</button>
                        </form>
                    </div>
                    
                    <table class="max-h-100 w-100 table-hover">
                        <tr class="bg-light-crimson">
                            <th class="fs-4 text-white p-2">No.</th>
                            <th class="fs-4 text-white p-2">Student</th>
                            <th class="fs-4 text-white p-2">Issued by</th>
                            <th class="fs-4 text-white p-2">Date Paid</th>
                        </tr>
                        <?php if(empty($paymentHist)){ ?>
                            <tr>
                                <td colspan="4" class="text-center fw-bold fs-5 py-2">No Payments Found.</td>
                            </tr>
                        <?php } else {
                            $counter = 1;
                            foreach($paymentHist as $ph):
                        ?>
                                <tr>
                                    <td><?= $counter; ?></td>
                                    <td><?= $ph['last_name'] . ', ' . $ph['first_name'] . ' ' . $ph['middle_name']; ?></td>
                                    <td><?= $counter; ?></td>
                                    <td><?= $counter; ?></td>
                                </tr>
                        <?php endforeach;
                        } ?>
                    </table>
                </div>
            </div>
        </section>