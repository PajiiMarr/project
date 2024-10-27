document.getElementById('course_year').disabled = true;

document.getElementById('course_id').addEventListener('change', function() {
    const selectedCourseId = this.value;
    const courseYear = document.getElementById('course_year');
    const upperYears = document.querySelectorAll('.upper-year');
    const section = document.querySelector('.section');

    if(selectedCourseId){
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

const today = new Date();
const maxDate = new Date(today.getFullYear() - 15, today.getMonth(), today.getDate());
const minDate = new Date(1960, 0, 1);

function formatDate(date) {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0'); // Months are zero-indexed
    const day = String(date.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
}

document.getElementById('dob').setAttribute('min', formatDate(minDate));
document.getElementById('dob').setAttribute('max', formatDate(maxDate));

document.getElementById('dob').addEventListener('change', function() {
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


function toggleCheckbox(div) {
    const checkbox = div.querySelector('input[type="checkbox"]');
    
    checkbox.checked = !checkbox.checked;
    
    if (checkbox.id === 'facilitatorCheckbox') {
        const studentCheckbox = document.getElementById('studentCheckbox');
        const studentDiv = studentCheckbox.closest('.input');
        
        if (checkbox.checked) {
            studentCheckbox.checked = true;
            studentDiv.classList.add('checked');
            studentDiv.style.pointerEvents = 'none'; // Disable interaction with the Student checkbox
        } else {
            studentCheckbox.checked = false;
            studentDiv.classList.remove('checked');
            studentDiv.style.pointerEvents = 'auto'; // Enable interaction
        }
    }
    
    if (checkbox.id === 'studentCheckbox' && document.getElementById('facilitatorCheckbox').checked) {
        checkbox.checked = true; // Force Student checkbox to remain checked
    }

    div.classList.toggle('checked', checkbox.checked);
}