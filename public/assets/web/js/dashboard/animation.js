$(document).ready(function () {
    var $ul = $('.counterul');
    var liHeight = $ul.find('counterul>li:first').outerHeight();
    var currentIndex = 0; 

    //탕전 주문 건수 -------------------------------------
    setInterval(function() {
        var $weeklyul = $('.weeklyul');
        var $li = $weeklyul.find('li'); 
        $li.first().show(1000, function() { 
          $(this).appendTo($weeklyul); 
          $weeklyul.find('li').last().slideDown(2000);
        });
    }, 3000);  

    //400,200 -------------------------------------
    setInterval(function() {
      var $counterul = $('.counterul');
      var $counterli = $counterul.find('li');  
      $counterli.first().show(1000, function() { 
        $(this).appendTo($counterul); 
        $counterul.find('li').last().slideDown(2000);
        });
      }, 3000); 


    //count 증가 -------------------------------------
    $('#counter').each(function() {
        var $this = $(this);
        var targetNumber = 465; // 목표 숫자 
        var duration = 500; // 애니메이션 지속 시간 (ms) 

        //count funtion ------------------------------
        $({ countNum: $this.text() }).animate(
          { countNum: targetNumber },
          {
            duration: duration,
            easing: 'swing', // 애니메이션 방식
            step: function() {
              // 애니메이션 진행 중에 숫자를 갱신
              $this.text(Math.floor(this.countNum));
            },
            complete: function() {
              // 애니메이션 완료 후 숫자 정확히 설정
              $this.text(targetNumber);
            }
          }
        ); 
      });
});