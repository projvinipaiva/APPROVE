window.onload = function() {
  // Função original para Dark Mode e Monochrome
  const darkModeSwitch = document.getElementById('switch');
  const monochromeSwitch = document.getElementById('monochromeSwitch');
  const isDarkMode = localStorage.getItem('darkMode');
  const isMonochrome = localStorage.getItem('monochromeMode');
 
  if (isDarkMode === 'enabled') {
    document.body.classList.add('dark-mode');
    darkModeSwitch.checked = true;  
  }

  if (isMonochrome === 'enabled') {
    document.body.classList.add('monochrome');
    monochromeSwitch.checked = true;  
  }

  darkModeSwitch.addEventListener('change', function() {
    if (this.checked) {
      document.body.classList.add('dark-mode');
      localStorage.setItem('darkMode', 'enabled');  
      monochromeSwitch.checked = false;
      document.body.classList.remove('monochrome');
      localStorage.setItem('monochromeMode', 'disabled');
    } else {
      document.body.classList.remove('dark-mode');
      localStorage.setItem('darkMode', 'disabled');  
    }
  });

  monochromeSwitch.addEventListener('change', function() {
    if (this.checked) {
      document.body.classList.add('monochrome');
      localStorage.setItem('monochromeMode', 'enabled');  
      darkModeSwitch.checked = false;
      document.body.classList.remove('dark-mode');
      localStorage.setItem('darkMode', 'disabled');
    } else {
      document.body.classList.remove('monochrome');
      localStorage.setItem('monochromeMode', 'disabled');  
    }
  });

  // Função original para VLibras
  const vlibrasSwitch = document.getElementById('vlibrasSwitch'); 
  const vlibrasEnabled = document.querySelector('.enabled');
  const isVlibrasEnabled = localStorage.getItem('vlibrasEnabled');

  if (isVlibrasEnabled === 'enabled') {
    vlibrasEnabled.style.display = 'block'; 
    vlibrasSwitch.checked = true;
  } else {
    vlibrasEnabled.style.display = 'none';
  }

  vlibrasSwitch.addEventListener('change', function() {
    if (this.checked) {
      vlibrasEnabled.style.display = 'block';
      localStorage.setItem('vlibrasEnabled', 'enabled');
    } else {
      vlibrasEnabled.style.display = 'none';
      localStorage.setItem('vlibrasEnabled', 'disabled');
    }
  });

  const script = document.createElement('script');
  script.src = 'https://vlibras.gov.br/app/vlibras-plugin.js';
  document.body.appendChild(script);
  script.onload = function() {
    new window.VLibras.Widget('https://vlibras.gov.br/app');
  };
};
