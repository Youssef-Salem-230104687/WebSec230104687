@extends('layouts.master')
@section('title', 'Calculator')
@section('content')
<div class="card m-4">
    <div class="card-header">Calculator</div>
    <div class="card-body">
        <!-- GPA Simulator -->
        <div class="mb-5">
            <h3>GPA Simulator</h3>
            <div class="mb-3">
                <label for="courseSelect" class="form-label">Select Course</label>
                <select class="form-select" id="courseSelect">
                    @foreach($courses as $course)
                        <option value="{{ $course['code'] }}" data-credits="{{ $course['credit_hours'] }}">
                            {{ $course['title'] }} ({{ $course['credit_hours'] }} credits)
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="gradeInput" class="form-label">Enter Grade</label>
                <input type="number" class="form-control" id="gradeInput" min="0" max="4" step="0.1" placeholder="Enter grade (0-4)">
            </div>
            <button type="button" class="btn btn-primary" onclick="addCourse()">Add Course</button>
            <hr>
            <h4>Selected Courses</h4>
            <ul id="selectedCourses" class="list-group mb-3"></ul>
            <button type="button" class="btn btn-success" onclick="calculateGPA()">Calculate GPA</button>
            <h4 class="mt-3">GPA: <span id="gpaResult"></span></h4>
        </div>

        <hr>

        <!-- Basic Calculator -->
        <h3>Basic Calculator</h3>
        <form id="calculatorForm">
            @csrf <!-- CSRF Token for security -->
            <div class="mb-3">
                <label for="num1" class="form-label">Number 1</label>
                <input type="number" class="form-control" id="num1" placeholder="Enter first number" required>
            </div>
            <div class="mb-3">
                <label for="num2" class="form-label">Number 2</label>
                <input type="number" class="form-control" id="num2" placeholder="Enter second number" required>
            </div>
            <div class="text-center">
                <button type="button" class="btn btn-primary m-2" onclick="calculate('add')">Add (+)</button>
                <button type="button" class="btn btn-primary m-2" onclick="calculate('subtract')">Subtract (-)</button>
                <button type="button" class="btn btn-primary m-2" onclick="calculate('multiply')">Multiply (*)</button>
                <button type="button" class="btn btn-primary m-2" onclick="calculate('divide')">Divide (/)</button>
            </div>
        </form>

        <!-- Result Display -->
        <div class="result mt-4">
            <h4 class="text-center">Result: <span id="result"></span></h4>
        </div>
    </div>
</div>

<!-- JavaScript for Calculator and GPA Simulator -->
<script>
    // GPA Simulator Logic
    let selectedCourses = [];

    function addCourse() {
        const courseSelect = document.getElementById('courseSelect');
        const gradeInput = document.getElementById('gradeInput');
        const selectedCoursesList = document.getElementById('selectedCourses');

        const courseCode = courseSelect.value;
        const courseTitle = courseSelect.options[courseSelect.selectedIndex].text;
        const credits = parseFloat(courseSelect.options[courseSelect.selectedIndex].getAttribute('data-credits'));
        const grade = parseFloat(gradeInput.value);

        if (isNaN(grade) || grade < 0 || grade > 4) {
            alert('Please enter a valid grade between 0 and 4.');
            return;
        }

        // Check if the course is already added
        const existingCourseIndex = selectedCourses.findIndex(course => course.code === courseCode);
        if (existingCourseIndex !== -1) {
            // Update the existing course grade
            selectedCourses[existingCourseIndex].grade = grade;
            alert('Course grade updated successfully!');
        } else {
            // Add new course
            selectedCourses.push({ code: courseCode, title: courseTitle, credits: credits, grade: grade });
        }

        // Refresh the selected courses list
        selectedCoursesList.innerHTML = '';
        selectedCourses.forEach(course => {
            const listItem = document.createElement('li');
            listItem.className = 'list-group-item';
            listItem.innerHTML = `
                ${course.title} - Grade: ${course.grade}, Credits: ${course.credits}
                <button type="button" class="btn btn-sm btn-warning float-end" onclick="editCourse('${course.code}')">Edit</button>
            `;
            selectedCoursesList.appendChild(listItem);
        });

        gradeInput.value = ''; // Clear the input field
    }

    function editCourse(courseCode) {
        const course = selectedCourses.find(course => course.code === courseCode);
        if (course) {
            const gradeInput = document.getElementById('gradeInput');
            gradeInput.value = course.grade;
            const courseSelect = document.getElementById('courseSelect');
            courseSelect.value = course.code;
        }
    }

    function calculateGPA() {
        if (selectedCourses.length === 0) {
            alert('Please add at least one course.');
            return;
        }

        let totalCredits = 0;
        let totalGradePoints = 0;

        selectedCourses.forEach(course => {
            totalCredits += course.credits;
            totalGradePoints += course.grade * course.credits;
        });

        const gpa = totalGradePoints / totalCredits;
        document.getElementById('gpaResult').textContent = gpa.toFixed(2);
    }

    // Basic Calculator Logic
    function calculate(operation) {
        const num1 = parseFloat(document.getElementById('num1').value);
        const num2 = parseFloat(document.getElementById('num2').value);

        if (isNaN(num1)) {
            alert("Please enter a valid number for Number 1.");
            return;
        }
        if (isNaN(num2)) {
            alert("Please enter a valid number for Number 2.");
            return;
        }

        let result;
        switch (operation) {
            case 'add':
                result = num1 + num2;
                break;
            case 'subtract':
                result = num1 - num2;
                break;
            case 'multiply':
                result = num1 * num2;
                break;
            case 'divide':
                if (num2 === 0) {
                    alert("Cannot divide by zero!");
                    return;
                }
                result = num1 / num2;
                break;
            default:
                result = "Invalid operation";
        }

        document.getElementById('result').innerText = result;
    }
</script>
@endsection