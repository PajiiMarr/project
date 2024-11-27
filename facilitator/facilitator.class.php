<?php
require_once '../utilities/database.class.php';

class Facilitator {
    private $conn;

    function __construct() {
        $db = new Database;
        $this->conn = $db->connect();
    }

    // Fetch dashboard data for the facilitator
    function getDashboardData($organization_id) {
        $data = [];

        // Fetch metrics
        $sqlMetrics = "SELECT 
                        COUNT(DISTINCT student.student_id) AS active_students,
                        SUM(payment.amount_to_pay) AS fees_collected,
                        SUM(CASE WHEN payment.date_of_payment = CURDATE() THEN payment.amount_to_pay ELSE 0 END) AS students_paid_today,
                        COUNT(payment.payment_id) AS payments_collected
                    FROM student_organization
                    INNER JOIN payment ON student_organization.stud_org_id = payment.student_org_id
                    INNER JOIN student ON student_organization.student_id = student.student_id
                    WHERE student_organization.organization_id = :organization_id";

        $queryMetrics = $this->conn->prepare($sqlMetrics);
        $queryMetrics->bindParam(':organization_id', $organization_id);

        if ($queryMetrics->execute()) {
            $data['metrics'] = $queryMetrics->fetch();
        }

        // Fetch recent payments
        $sqlRecentPayments = "SELECT 
                                student.student_id, 
                                CONCAT(student.first_name, ' ', student.last_name) AS student_name, 
                                payment.amount_to_pay AS amount,
                                payment.date_of_payment AS date_paid,
                                payment.payment_status AS status
                            FROM payment
                            INNER JOIN student_organization ON payment.student_org_id = student_organization.stud_org_id
                            INNER JOIN student ON student_organization.student_id = student.student_id
                            WHERE student_organization.organization_id = :organization_id
                            ORDER BY payment.date_of_payment DESC
                            LIMIT 5";

        $queryRecentPayments = $this->conn->prepare($sqlRecentPayments);
        $queryRecentPayments->bindParam(':organization_id', $organization_id);

        if ($queryRecentPayments->execute()) {
            $data['recentPayments'] = $queryRecentPayments->fetchAll();
        }

        return $data;
    }
}
