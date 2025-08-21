
document.addEventListener("DOMContentLoaded", function () {  
    document.querySelectorAll('.clearinput').forEach(button => {
        button.addEventListener('click', function() {
            const input = this.previousElementSibling;
            input.value = '';
            input.focus();
        });
    });

    document.querySelectorAll('.inputcon input').forEach(input => {
        input.addEventListener('input', function() {
            const clearButton = this.nextElementSibling;
            clearButton.style.display = this.value ? 'block' : 'none';
        });
    });

    // x btn display inline and none
    document.querySelectorAll('.inputcon input').forEach(input => {
        input.addEventListener('input', function() {
            const clearButton = this.nextElementSibling;
            if (clearButton) {
                clearButton.style.display = this.value ? 'inline' : 'none'; // 값이 있으면 표시, 없으면 숨김
            }
        });
    });

    // input innerText '';
    document.querySelectorAll('.clearbtn').forEach(button => {
        button.addEventListener('click', function() {
            const input = this.previousElementSibling;
            if (input) {
                input.value = ''; // 입력값 삭제
                input.innerText = ''; // innerText를 비우기
                input.focus(); // 입력 필드에 포커스 유지
                this.style.display = 'none'; // x 버튼 숨기기
            }
        });
    });


    document.querySelectorAll('.clearbtn').forEach(button => {
        button.addEventListener('click', function() {
            const input = this.previousElementSibling;
            if (input) {
                input.value = ''; // 입력값 삭제
                input.innerText = ''; // innerText를 비우기
                input.focus(); // 입력 필드에 포커스 유지
            }
        });
    });
});