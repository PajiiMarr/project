document.getElementById('course_id').addEventListener('change', function() {
    const selectedCourseId = this.value;
    const courseYear = document.getElementById('course_year');
    const upperYears = document.querySelectorAll('.upper-year');
    const section = document.getElementById('course_section');

    if (selectedCourseId) {
        courseYear.disabled = false;
    } else {
        courseYear.disabled = true;
    }

    if (selectedCourseId == 1 || selectedCourseId == 2) {
        upperYears.forEach(option => option.style.display = 'block');
        section.style.display = "block";
    } else {
        upperYears.forEach(option => option.style.display = 'none');
        courseYear.value = "";
        section.style.display = "none";
    }
});

// Set min and max dates for DOB
const today = new Date();
const maxDate = new Date(today.getFullYear() - 15, today.getMonth(), today.getDate());
const minDate = new Date(1960, 0, 1);

function formatDate(date) {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0'); // Months are zero-indexed
    const day = String(date.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
}

const dobInput = document.getElementById('dob');
dobInput.setAttribute('min', formatDate(minDate));
dobInput.setAttribute('max', formatDate(maxDate));

dobInput.addEventListener('change', function () {
    const dob = new Date(this.value);
    const ageInput = document.getElementById('age');
    const ageHiddenInput = document.getElementById('hidden_age');

    if (dob) {
        let age = today.getFullYear() - dob.getFullYear();
        const monthDifference = today.getMonth() - dob.getMonth();

        if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < dob.getDate())) {
            age--;
        }

        ageInput.value = age;
        ageHiddenInput.value = age;
    }
});