let students = window.students || [];

// Fetch all students saat halaman load
async function fetchStudents() {
    let res = await fetch('/api/students');
    students = await res.json();
    renderStudents();
}


// Render table mahasiswa
function renderStudents() {
    let tbody = document.querySelector('#table-students tbody');
    tbody.innerHTML = '';
    students.forEach(student => {
        tbody.innerHTML += `
        <tr>
            <td>${student.user.username}</td>
            <td>${student.user.full_name}</td>
            <td>${student.user.email}</td>
            <td>${student.entry_year}</td>
            <td>
                <button onclick="editStudent(${student.student_id})">Edit</button>
                <button onclick="deleteStudent(${student.student_id})">Delete</button>
            </td>
        </tr>
        `;
    })
}


 // gunakan array global jika sudah ada

document.getElementById('form-student').addEventListener('submit', async function(e) {
    e.preventDefault();

    let formData = new FormData(this);

    let response = await fetch('/dashboard-admin/kelola-mahasiswa', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': formData.get('_token'),
            'Accept': 'application/json'
        },
        body: formData
    });

    if (response.ok) {
        let student = await response.json();
        students.push(student);

        renderStudents();

        // (Opsional) Reset form
        this.reset();

        // (Opsional) Tampilkan notifikasi sukses
        alert('Student created successfully!');

        window.location.href = window.studentsIndexUrl;

    } else {
        let error = await response.json();
        alert(error.message || 'Gagal menambah mahasiswa');
    }
});

// Hapus Mahasiswa 
async function deleteStudent(studentId) {
    if (!confirm('Are you sure you want to delete this student?')) return;
    let token = document.querySelector('input[name="_token"]').value;
    let res = await fetch(`/dashboard-admin/kelola-mahasiswa/${studentId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': token
        }
    });

    if (res.ok) {
        students = students.filter(s => s.student_id !== studentId);
        renderStudents();
    }
}

// Edit mahasiswa (opsional: tampilkan modal/form edit)
window.showEditModal = function(studentId) {
    let student = students.find(s => s.student_id === studentId);
    if (!student) return;
    document.getElementById('edit-student-id').value = student.student_id;
    document.getElementById('edit-username').value = student.user.username;
    document.getElementById('edit-full_name').value = student.user.full_name;
    document.getElementById('edit-email').value = student.user.email;
    document.getElementById('edit-entry_year').value = student.entry_year;
    document.getElementById('edit-password').value = '';
    document.getElementById('edit-modal').classList.remove('hidden');
}

window.closeEditModal = function() {
    document.getElementById('edit-modal').classList.add('hidden');
}

// Update mahasiswa
document.getElementById('form-edit-student').addEventListener('submit', async function(e){
    e.preventDefault();
    let studentId = document.getElementById('edit-student-id').value;
    let formData = new FormData(this);

    let token = document.querySelector('input[name="_token"]').value;
    let response = await fetch(`/dashboard-admin/kelola-mahasiswa/${studentId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json',
        },
        body: formData
    });

    if (response.ok) {
        let updated = await response.json();
        // Update array students
        let idx = students.findIndex(s => s.student_id == studentId);
        if (idx !== -1) students[idx] = updated;
        renderStudents();
        closeEditModal();
    } else {
        alert('Gagal update mahasiswa');
    }
});

// Inisialisasi
window.addEventListener('DOMContentLoaded', fetchStudents);