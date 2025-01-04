
  const meuCheck = document.getElementById('checkData');
  const inputData = document.getElementById('inputData');

  function trocar() {
      var meuCheck = document.getElementById('checkData');
      if (meuCheck.checked) {
        const inputData1 = document.getElementById('inputData1');
        const inputData2 = document.getElementById('inputData2');
        inputData1.removeAttribute("disabled");
        inputData2.removeAttribute("disabled");
      } else {
        const inputData1 = document.getElementById('inputData1');
        const inputData2 = document.getElementById('inputData2');
        inputData1.disabled = true; 
        inputData2.disabled = true; 
      }
  }