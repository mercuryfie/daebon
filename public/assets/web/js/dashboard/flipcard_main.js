function getTimeRemaining() {
  const now = new Date();
  const endTime = new Date(now.getFullYear(), now.getMonth(), now.getDate(), 15, 0, 0);
  
  // 만약 현재 시간이 15:00를 지났다면, 다음 날 15:00로 설정
  if (now > endTime) {
      endTime.setDate(endTime.getDate() + 1);
  }
  
  const total = endTime - now;
  const seconds = Math.floor((total / 1000) % 60);
  const minutes = Math.floor((total / 1000 / 60) % 60);
  const hours = Math.floor((total / (1000 * 60 * 60)) % 24);

  return {
      total,
      hours: hours.toString().padStart(2, '0'),
      minutes: minutes.toString().padStart(2, '0'),
      seconds: seconds.toString().padStart(2, '0')
  };
}

function updateFlipCard(selector, newValue, oldValue) {
  const flipper = document.querySelector(selector);
  const card = flipper.querySelector('.card');
  const topText = card.querySelector('.top .text');
  const bottomText = card.querySelector('.bottom .text');

  if (newValue !== oldValue) {
      bottomText.textContent = newValue;
      card.classList.add('flip');

      setTimeout(() => {
          topText.textContent = newValue;
          card.classList.remove('flip');
      }, 300);
  }
}

function initializeClock() {
  let oldTime = { hours: '', minutes: '', seconds: '' };

  function updateClock() {
      const t = getTimeRemaining();

      updateFlipCard('.flipper.hours', t.hours, oldTime.hours);
      updateFlipCard('.flipper.minutes', t.minutes, oldTime.minutes);
      updateFlipCard('.flipper.seconds', t.seconds, oldTime.seconds);

      oldTime = { hours: t.hours, minutes: t.minutes, seconds: t.seconds };

      if (t.total <= 0) {
          clearInterval(timeinterval);
      }
  }

  updateClock();
  const timeinterval = setInterval(updateClock, 1000);
}

initializeClock();